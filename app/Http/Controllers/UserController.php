<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // No constructor - middleware handled in routes

    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                          ->orWhere('last_name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->when($request->status !== null, function ($query) use ($request) {
                $query->where('is_active', $request->status);
            })
            ->select(['id', 'first_name', 'last_name', 'email', 'phone', 'role', 'is_active', 'email_verified_at', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admins' => User::where('role', 'admin')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'customers' => User::where('role', 'customer')->count(),
        ];

        // ✅ BLADE VIEW - No Inertia
        return view('backend.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        // ✅ BLADE VIEW - No Inertia
        return view('backend.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'role' => 'required|in:admin,customer,staff',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $validated['is_active'] ?? true;

        User::create($validated);

        // ✅ BLADE REDIRECT - No Inertia
        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        // ✅ BLADE VIEW - No Inertia
        return view('backend.users.edit', compact('user'));
    }

   public function update(Request $request, User $user)
    {
        // Check if user is trying to edit themselves and prevent role/status changes
        $isEditingSelf = Auth::id() === $user->id;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|min:8|confirmed',
            'role' => $isEditingSelf ? 'sometimes' : 'required|in:admin,staff,customer',
            'is_active' => $isEditingSelf ? 'sometimes' : 'required|boolean',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'send_password_reset_email' => 'boolean',
            'email_verified' => 'boolean',
        ]);

        try {
            // Store original email for comparison
            $originalEmail = $user->email;
            $originalEmailVerified = $user->email_verified_at;

            // Prepare update data
            $updateData = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'] ? Carbon::parse($validated['date_of_birth']) : null,
                'gender' => $validated['gender'],
                'address' => $validated['address'],
            ];

            // Handle password update
            $passwordChanged = false;
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
                $passwordChanged = true;
            }

            // Handle role and status (only if not editing self)
            if (!$isEditingSelf) {
                $updateData['role'] = $validated['role'];
                $updateData['is_active'] = $validated['is_active'];
            }

            // Handle email verification
            if ($request->has('email_verified')) {
                $updateData['email_verified_at'] = now();
            } else {
                // If email changed, remove verification
                if ($originalEmail !== $validated['email']) {
                    $updateData['email_verified_at'] = null;
                }
            }

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $updateData['profile_picture'] = $request->file('profile_picture')->store('profile-pictures', 'public');
            }

            // Update user
            $user->update($updateData);

            // Send password change notification if requested
            if ($passwordChanged && $request->has('send_password_reset_email')) {
                // Mail::to($user->email)->send(new PasswordChangedNotification($user));
            }

            // Prepare success message
            $message = 'User updated successfully!';
            if ($passwordChanged) {
                $message .= ' Password has been changed.';
            }

            if ($isEditingSelf) {
                return redirect()->route('users.edit', $user)->with('success', $message);
            }

            return redirect()->route('users.index')->with('success', $message);

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }


    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        // ✅ BLADE REDIRECT - No Inertia
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        // ✅ BLADE REDIRECT - No Inertia
        return back()->with('success', "User {$status} successfully.");
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // ✅ BLADE REDIRECT - No Inertia
        return back()->with('success', 'Password reset successfully.');
    }
}
