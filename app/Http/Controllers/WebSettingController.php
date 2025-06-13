<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebSettingController extends Controller
{
    public function show()
    {
        // Default values if no record found
        $default = [
            'name' => 'My Website',
            'moto' => 'Your Success, Our Commitment',
            'logo' => null,
            'favicon' => null,
            'address' => '123 Main Street, City',
            'phone' => '123-456-7890',
            'email' => 'info@example.com',
            'opening_closing_days' => json_encode([
                'Monday' => '9:00 AM - 5:00 PM',
                'Tuesday' => '9:00 AM - 5:00 PM',
                'Wednesday' => '9:00 AM - 5:00 PM',
                'Thursday' => '9:00 AM - 5:00 PM',
                'Friday' => '9:00 AM - 5:00 PM',
                'Saturday' => 'Closed',
                'Sunday' => 'Closed',
            ]),
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'google_map_embed' => null,
            'social_media' => json_encode([
                'facebook' => null,
                'twitter' => null,
                'instagram' => null,
                'linkedin' => null,
            ]),
            'copyright_text' => '© '.date('Y').' My Website. All rights reserved.',
            'meta_title' => 'Welcome to My Website',
            'meta_description' => 'This is the default meta description.',
        ];

        $siteSetting = WebSetting::first();

        if (!$siteSetting) {
            // Use default as an object for blade usage
            $siteSetting = (object) $default;
        }



        return view('backend.websetting', compact('siteSetting'));
    }
public function update(Request $request)
{
    $validated = $request->validate([
        'name' => 'nullable|string|max:255',
        'moto' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:255',
        'opening_closing_days' => 'nullable|string',
        'primary_color' => 'nullable|string|max:7',
        'secondary_color' => 'nullable|string|max:7',
        'google_map_embed' => 'nullable|string',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:255',
        'copyright_text' => 'nullable|string|max:255',
        'social_media' => 'nullable|array',
        'social_media.*' => 'nullable|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'favicon' => 'nullable|image|mimes:ico,png|max:512',
    ]);

    $webSetting = WebSetting::firstOrNew();

    // Handle file uploads and delete old files
    if ($request->hasFile('logo')) {
        // Delete old logo if exists
        if ($webSetting->logo && Storage::disk('public')->exists(str_replace('storage/', '', $webSetting->logo))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $webSetting->logo));
        }

        $logoPath = $request->file('logo')->store('uploads/logo', 'public');
        $validated['logo'] = 'storage/' . $logoPath;
    } else {
        // Keep existing logo if no new file uploaded
        $validated['logo'] = $webSetting->logo;
    }

    if ($request->hasFile('favicon')) {
        // Delete old favicon if exists
        if ($webSetting->favicon && Storage::disk('public')->exists(str_replace('storage/', '', $webSetting->favicon))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $webSetting->favicon));
        }

        $faviconPath = $request->file('favicon')->store('uploads/favicon', 'public');
        $validated['favicon'] = 'storage/' . $faviconPath;
    } else {
        // Keep existing favicon if no new file uploaded
        $validated['favicon'] = $webSetting->favicon;
    }

    // Convert social media to JSON string if present
    if (isset($validated['social_media'])) {
        $validated['social_media'] = json_encode($validated['social_media']);
    } else {
        // Keep existing social media if not provided
        $validated['social_media'] = $webSetting->social_media;
    }

    $webSetting->fill($validated);
    $webSetting->save();

    return redirect()->back()->with('success', 'Web settings updated successfully.');
}

}
