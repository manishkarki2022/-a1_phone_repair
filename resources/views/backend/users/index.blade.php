@extends('backend.layout.app')

@section('title', 'User Management')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-3 mr-3">
                            <i class="fas fa-users text-white fa-lg"></i>
                        </div>
                        <div>
                            <h1 class="m-0">User Management</h1>
                            <small class="text-muted">Manage all system users and their permissions</small>
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
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Stats Cards Row -->
            <div class="row mb-3">
                @foreach([
                    ['count' => $users->total(), 'label' => 'Total Users', 'icon' => 'users', 'color' => 'info'],
                    ['count' => $stats['active'] ?? 0, 'label' => 'Active', 'icon' => 'check-circle', 'color' => 'success'],
                    ['count' => $stats['inactive'] ?? 0, 'label' => 'Inactive', 'icon' => 'times-circle', 'color' => 'danger'],
                    ['count' => $stats['admins'] ?? 0, 'label' => 'Admins', 'icon' => 'crown', 'color' => 'warning'],
                    ['count' => $stats['staff'] ?? 0, 'label' => 'Staff', 'icon' => 'user-tie', 'color' => 'secondary'],
                    ['count' => $stats['customers'] ?? 0, 'label' => 'Customers', 'icon' => 'user', 'color' => 'primary']
                ] as $stat)
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-{{ $stat['color'] }}">
                        <div class="inner">
                            <h3>{{ $stat['count'] }}</h3>
                            <p>{{ $stat['label'] }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-{{ $stat['icon'] }}"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Search and Filters Card -->
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-2"></i>Search & Filters
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-{{ request()->hasAny(['search', 'role', 'status']) ? 'minus' : 'plus' }}"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="{{ !request()->hasAny(['search', 'role', 'status']) ? 'display: none;' : '' }}">
                    <form method="GET" action="{{ route('users.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search">Search Users</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" name="search"
                                               placeholder="Search by name or email..." value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="role">Filter by Role</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="">All Roles</option>
                                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Filter by Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-filter mr-1"></i> Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>Users List
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Add New User
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 20%">User</th>
                                    <th style="width: 15%">Email</th>
                                    <th style="width: 10%">Phone</th>
                                    <th style="width: 10%">Role</th>
                                    <th style="width: 8%">Status</th>
                                    <th style="width: 10%">Verified</th>
                                    <th style="width: 12%">Joined</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>
                                      <div class="d-flex align-items-center">
                                        <img
                                            src="{{ $user->profile_photo_url ?? asset('default/avatar.png') }}"
                                            onerror="this.onerror=null;this.src='{{ asset('default/avatar.png') }}';"
                                            class="img-circle mr-2"
                                            alt="{{ $user->first_name }}"
                                            style="width: 36px; height: 36px; object-fit: cover;">

                                        <div>
                                            <div class="font-weight-bold">{{ $user->full_name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                    </td>
                                    <td class="text-truncate" style="max-width: 200px;" title="{{ $user->email }}">
                                        {{ $user->email }}
                                    </td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $user->is_active ? 'success' : 'secondary' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i> Verified
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-exclamation-circle mr-1"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('users.edit', $user->id) }}"
                                               class="btn btn-info"
                                               title="Edit"
                                               data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('users.toggle-status', $user->id) }}"
                                                  class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }}"
                                                        title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}"
                                                        data-toggle="tooltip">
                                                    <i class="fas {{ $user->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                                </button>
                                            </form>

                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-toggle="modal"
                                                    data-target="#resetPasswordModal{{ $user->id }}"
                                                    title="Reset Password"
                                                    data-toggle="tooltip">
                                                <i class="fas fa-key"></i>
                                            </button>

                                            @if($user->id !== auth()->id())
                                            <form method="POST"
                                                  action="{{ route('users.destroy', $user->id) }}"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger"
                                                        title="Delete"
                                                        data-toggle="tooltip"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Reset Password Modal -->
                                <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white">
                                                    Reset Password for {{ $user->full_name }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="text-white">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('users.reset-password', $user->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="password{{ $user->id }}">New Password</label>
                                                        <input type="password"
                                                               class="form-control"
                                                               id="password{{ $user->id }}"
                                                               name="password"
                                                               required
                                                               placeholder="Enter new password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password_confirmation{{ $user->id }}">Confirm Password</label>
                                                        <input type="password"
                                                               class="form-control"
                                                               id="password_confirmation{{ $user->id }}"
                                                               name="password_confirmation"
                                                               required
                                                               placeholder="Confirm new password">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        <i class="fas fa-times mr-1"></i> Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save mr-1"></i> Update Password
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-user-slash fa-3x text-muted mb-2"></i>
                                            <h5 class="text-muted">No users found</h5>
                                            @if(request()->hasAny(['search', 'role', 'status']))
                                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary mt-2">
                                                    Clear filters
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                        </div>
                        <div>
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
/* Fix any potential layout issues */
.content-wrapper {
    margin-left: 250px; /* Adjust based on your sidebar width */
    transition: margin-left 0.3s ease-in-out;
}

/* When sidebar is collapsed */
.sidebar-mini.sidebar-collapse .content-wrapper {
    margin-left: 60px;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .content-wrapper {
        margin-left: 0;
    }
}

/* Ensure proper spacing */
.content-header {
    padding: 15px 15px 0 15px;
}

.content {
    padding: 15px;
}

/* Fix card spacing */
.card {
    margin-bottom: 20px;
}

/* Ensure breadcrumb alignment */
.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Toggle search/filter section
        $('[data-card-widget="collapse"]').on('click', function() {
            const icon = $(this).find('i');
            if (icon.hasClass('fa-plus')) {
                icon.removeClass('fa-plus').addClass('fa-minus');
            } else {
                icon.removeClass('fa-minus').addClass('fa-plus');
            }
        });

        // Show loading state on form submissions
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        });
    });
</script>
@endpush
