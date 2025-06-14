@extends('backend.layout.app')

@section('title', 'Edit User - ' . $user->full_name)

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning rounded-circle p-3 mr-3">
                            <i class="fas fa-user-edit text-white fa-lg"></i>
                        </div>
                        <div>
                            <h1 class="m-0">Edit User</h1>
                            <small class="text-muted">Update user information and settings</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.index') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item active">Edit {{ $user->first_name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="editUserForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <!-- User Status Alert -->
                        @if(!$user->is_active)
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Inactive User!</h5>
                            This user account is currently inactive. Users cannot login when inactive.
                        </div>
                        @endif

                        @if(!$user->email_verified_at)
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-info-circle"></i> Email Not Verified!</h5>
                            This user's email address has not been verified yet.
                        </div>
                        @endif

                        <!-- Basic Information Card -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user mr-2"></i>Basic Information
                                </h3>
                                <div class="card-tools">
                                    <small class="text-muted">User ID: {{ $user->id }}</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('first_name') is-invalid @enderror"
                                                   id="first_name"
                                                   name="first_name"
                                                   value="{{ old('first_name', $user->first_name) }}"
                                                   placeholder="Enter first name"
                                                   required>
                                            @error('first_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   id="last_name"
                                                   name="last_name"
                                                   value="{{ old('last_name', $user->last_name) }}"
                                                   placeholder="Enter last name"
                                                   required>
                                            @error('last_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email', $user->email) }}"
                                                   placeholder="Enter email address"
                                                   required>
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone"
                                                   name="phone"
                                                   value="{{ old('phone', $user->phone) }}"
                                                   placeholder="Enter phone number">
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <input type="date"
                                                   class="form-control @error('date_of_birth') is-invalid @enderror"
                                                   id="date_of_birth"
                                                   name="date_of_birth"
                                                   value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                                            @error('date_of_birth')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-control @error('gender') is-invalid @enderror"
                                                    id="gender"
                                                    name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="3"
                                              placeholder="Enter full address">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Security Information Card -->
                        <div class="card card-warning card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-lock mr-2"></i>Security Information
                                </h3>
                                <div class="card-tools">
                                    <small class="text-muted">Leave password fields empty to keep current password</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <div class="input-group">
                                                <input type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       id="password"
                                                       name="password"
                                                       placeholder="Enter new password">


                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Leave blank to keep current password
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm New Password</label>
                                            <div class="input-group">
                                                <input type="password"
                                                       class="form-control"
                                                       id="password_confirmation"
                                                       name="password_confirmation"
                                                       placeholder="Confirm new password">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="send_password_reset_email"
                                                       name="send_password_reset_email"
                                                       value="1">
                                                <label class="custom-control-label" for="send_password_reset_email">
                                                    Send password change notification email
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="email_verified"
                                                       name="email_verified"
                                                       value="1"
                                                       {{ $user->email_verified_at ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="email_verified">
                                                    Mark email as verified
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Activity Card -->
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-clock mr-2"></i>Account Activity
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Account Created:</strong>
                                        <p class="text-muted">{{ $user->created_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Last Updated:</strong>
                                        <p class="text-muted">{{ $user->updated_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Email Verified:</strong>
                                        <p class="text-muted">
                                            @if($user->email_verified_at)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check mr-1"></i>
                                                    {{ $user->email_verified_at->format('M d, Y') }}
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock mr-1"></i> Not Verified
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Last Login:</strong>
                                        <p class="text-muted">
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->format('M d, Y g:i A') }}
                                            @else
                                                <span class="text-muted">Never logged in</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <!-- Profile Picture Card -->
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-image mr-2"></i>Profile Picture
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <img id="imagePreview"
                                             src="{{ $user->profile_photo_url ?? asset('default/avatar.png') }}"
                                             alt="Profile Preview"
                                             class="img-circle elevation-2"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input @error('profile_picture') is-invalid @enderror"
                                               id="profile_picture"
                                               name="profile_picture"
                                               accept="image/*">
                                        <label class="custom-file-label" for="profile_picture">Choose new picture</label>
                                    </div>
                                    @error('profile_picture')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Allowed formats: JPG, PNG, GIF. Max size: 2MB
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Role & Permissions Card -->
                        <div class="card card-secondary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-tag mr-2"></i>Role & Permissions
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="role">User Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror"
                                            id="role"
                                            name="role"
                                            required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                            Admin - Full Access
                                        </option>
                                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>
                                            Staff - Limited Access
                                        </option>
                                        <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>
                                            Customer - Basic Access
                                        </option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Account Status</label>
                                    <select class="form-control @error('is_active') is-invalid @enderror"
                                            id="status"
                                            name="is_active">
                                        <option value="1" {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('is_active')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Current Role Display -->
                                <div class="callout callout-info">
                                    <h5>Current Role:</h5>
                                    <p id="currentRoleDisplay">
                                        @switch($user->role)
                                            @case('admin')
                                                <span class="badge badge-danger">Admin</span>
                                                @break
                                            @case('staff')
                                                <span class="badge badge-warning">Staff</span>
                                                @break
                                            @default
                                                <span class="badge badge-info">Customer</span>
                                        @endswitch
                                    </p>
                                </div>

                                <!-- Role Description -->
                                <div class="alert alert-info" id="roleDescription" style="display: none;">
                                    <small id="roleDescriptionText"></small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-warning btn-block" id="submitBtn">
                                        <i class="fas fa-save mr-2"></i> Update User
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-arrow-left mr-2"></i> Back to List
                                    </a>
                                    <button type="button" class="btn btn-outline-warning btn-block" id="resetBtn">
                                        <i class="fas fa-undo mr-2"></i> Reset Changes
                                    </button>
                                </div>

                                @if($user->id !== auth()->id())
                                <hr>
                                <div class="text-center">
                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            data-toggle="modal"
                                            data-target="#deleteModal">
                                        <i class="fas fa-trash mr-1"></i> Delete User
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- Delete Confirmation Modal -->
@if($user->id !== auth()->id())
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Delete User
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $user->full_name }}</strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. All user data will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Cancel
                </button>
                <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Store original form data for reset functionality
    const originalFormData = $('#editUserForm').serialize();

    // Image preview functionality
    $('#profile_picture').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);

            // Update file label
            $(this).next('.custom-file-label').text(file.name);
        }
    });

    // Role description
    const roleDescriptions = {
        'admin': 'Administrators have full access to all system features including user management, settings, and system configuration.',
        'staff': 'Staff members have access to core features but cannot manage users or system settings.',
        'customer': 'Customers have basic access to their account and can browse products/services.'
    };

    $('#role').on('change', function() {
        const selectedRole = $(this).val();
        const descriptionDiv = $('#roleDescription');
        const descriptionText = $('#roleDescriptionText');

        if (selectedRole && roleDescriptions[selectedRole]) {
            descriptionText.text(roleDescriptions[selectedRole]);
            descriptionDiv.show();
        } else {
            descriptionDiv.hide();
        }
    });

    // Password confirmation validation
    $('#password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();

        if (password && confirmPassword && password !== confirmPassword) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<span class="invalid-feedback">Passwords do not match</span>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // Form submission
    $('#editUserForm').on('submit', function(e) {
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();

        if (password && password !== confirmPassword) {
            e.preventDefault();
            $('#password_confirmation').addClass('is-invalid');
            if (!$('#password_confirmation').siblings('.invalid-feedback').length) {
                $('#password_confirmation').after('<span class="invalid-feedback">Passwords do not match</span>');
            }
            return false;
        }

        // Show loading state
        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Updating User...');
    });

    // Reset form functionality
    $('#resetBtn').on('click', function() {
        if (confirm('Are you sure you want to reset all changes?')) {
            location.reload();
        }
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush



