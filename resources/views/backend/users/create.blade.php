@extends('backend.layout.app')

@section('title', 'Create New User')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle p-3 mr-3">
                            <i class="fas fa-user-plus text-white fa-lg"></i>
                        </div>
                        <div>
                            <h1 class="m-0">Create New User</h1>
                            <small class="text-muted">Add a new user to the system</small>
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
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="createUserForm">
                @csrf

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <!-- Basic Information Card -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user mr-2"></i>Basic Information
                                </h3>
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
                                                   value="{{ old('first_name') }}"
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
                                                   value="{{ old('last_name') }}"
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
                                                   value="{{ old('email') }}"
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
                                                   value="{{ old('phone') }}"
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
                                                   value="{{ old('date_of_birth') }}">
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
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
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
                                              placeholder="Enter full address">{{ old('address') }}</textarea>
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
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       id="password"
                                                       name="password"
                                                       placeholder="Enter password"
                                                       required>

                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Password must be at least 8 characters long
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password"
                                                       class="form-control"
                                                       id="password_confirmation"
                                                       name="password_confirmation"
                                                       placeholder="Confirm password"
                                                       required>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="send_welcome_email"
                                               name="send_welcome_email"
                                               value="1"
                                               {{ old('send_welcome_email') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="send_welcome_email">
                                            Send welcome email with login credentials
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="email_verified"
                                               name="email_verified"
                                               value="1"
                                               {{ old('email_verified') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="email_verified">
                                            Mark email as verified
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <!-- Profile Picture Card -->
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-image mr-2"></i>Profile Picture
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="form-group">
                                    <div class="image-preview-container mb-3">
                                        <img id="imagePreview"
                                             src="{{ asset('default/avatar.png') }}"
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
                                        <label class="custom-file-label" for="profile_picture">Choose file</label>
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
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                            Admin - Full Access
                                        </option>
                                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>
                                            Staff - Limited Access
                                        </option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>
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
                                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('is_active')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
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
                                    <button type="submit" class="btn btn-success btn-block" id="submitBtn">
                                        <i class="fas fa-save mr-2"></i> Create User
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-times mr-2"></i> Cancel
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning btn-block">
                                        <i class="fas fa-undo mr-2"></i> Reset Form
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
.content-wrapper {
    margin-left: 250px;
    transition: margin-left 0.3s ease-in-out;
}

.sidebar-mini.sidebar-collapse .content-wrapper {
    margin-left: 60px;
}

@media (max-width: 768px) {
    .content-wrapper {
        margin-left: 0;
    }
}

.content-header {
    padding: 15px 15px 0 15px;
}

.content {
    padding: 15px;
}

.card {
    margin-bottom: 20px;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.image-preview-container {
    position: relative;
    display: inline-block;
}

.custom-file-label::after {
    content: "Browse";
}

.form-group label .text-danger {
    font-weight: normal;
}

.btn-block {
    margin-bottom: 10px;
}

.btn-block:last-child {
    margin-bottom: 0;
}

/* Password strength indicator */
.password-strength {
    height: 5px;
    margin-top: 5px;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.password-weak { background-color: #dc3545; }
.password-medium { background-color: #ffc107; }
.password-strong { background-color: #28a745; }

/* Role description styles */
.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
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

    // Password strength indicator
    $('#password').on('input', function() {
        const password = $(this).val();
        const strengthDiv = $('.password-strength');

        if (strengthDiv.length === 0) {
            $(this).parent().after('<div class="password-strength"></div>');
        }

        const strength = checkPasswordStrength(password);
        $('.password-strength')
            .removeClass('password-weak password-medium password-strong')
            .addClass('password-' + strength);
    });

    function checkPasswordStrength(password) {
        if (password.length < 6) return 'weak';
        if (password.length < 8) return 'medium';

        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSpecial = /[!@#$%^&*]/.test(password);

        const criteriaMet = [hasUpper, hasLower, hasNumber, hasSpecial].filter(Boolean).length;

        if (criteriaMet >= 3 && password.length >= 8) return 'strong';
        if (criteriaMet >= 2) return 'medium';
        return 'weak';
    }

    // Password confirmation validation
    $('#password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();

        if (confirmPassword && password !== confirmPassword) {
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
    $('#createUserForm').on('submit', function(e) {
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();

        if (password !== confirmPassword) {
            e.preventDefault();
            $('#password_confirmation').addClass('is-invalid');
            if (!$('#password_confirmation').siblings('.invalid-feedback').length) {
                $('#password_confirmation').after('<span class="invalid-feedback">Passwords do not match</span>');
            }
            return false;
        }

        // Show loading state
        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Creating User...');
    });

    // Reset form functionality
    $('button[type="reset"]').on('click', function() {
        $('#imagePreview').attr('src', '{{ asset("default/avatar.png") }}');
        $('.custom-file-label').text('Choose file');
        $('#roleDescription').hide();
        $('.password-strength').remove();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
