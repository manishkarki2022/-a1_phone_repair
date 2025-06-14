<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ file_exists(public_path('' . websiteInfo()->logo)) ? asset('' . websiteInfo()->logo) : asset('default/no-image.png') }}"
            alt="{{ websiteInfo() ? websiteInfo()->name : 'Default App Name' }}"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">
            {{ websiteInfo() ? websiteInfo()->name : 'Admin Panel' }}
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('default/avatar.png') }}"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                <small class="text-muted">{{ Auth::user()->email }}</small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Navigation Header -->
                <li class="nav-header">CONTENT MANAGEMENT</li>

                <!-- Categories -->
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}"
                       class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>Categories</p>
                    </a>
                </li>

                <!-- Brands -->
                <li class="nav-item">
                    <a href="{{ route('brands.index') }}"
                       class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copyright"></i>
                        <p>Brands</p>
                    </a>
                </li>

                <!-- Products -->
                <li class="nav-item">
                    <a href="{{ route('products.index') }}"
                       class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Products</p>
                    </a>
                </li>

                <!-- Navigation Header -->
                <li class="nav-header">USER MANAGEMENT</li>

                <!-- Users Management -->
                {{-- TODO: Create these routes in web.php --}}
                {{-- Route::resource('users', UserController::class); --}}
                <li class="nav-item {{ request()->routeIs('users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                               class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}"
                               class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Navigation Header -->
                <li class="nav-header">SYSTEM</li>

                <!-- Site Settings -->
                <li class="nav-item">
                    <a href="{{ route('admin.web_setting.show') }}"
                       class="nav-link {{ request()->routeIs('admin.web_setting.show') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Site Settings</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
/* Custom AdminLTE Sidebar Enhancements */
.main-sidebar {
    transition: all 0.3s ease-in-out;
}

.sidebar {
    padding-bottom: 40px;
}

.user-panel .info a {
    color: #c2c7d0;
    font-weight: 600;
}

.user-panel .info small {
    font-size: 0.75rem;
    opacity: 0.8;
}

.nav-sidebar .nav-item .nav-link {
    transition: all 0.3s ease;
    border-radius: 0.25rem;
    margin: 0 0.5rem;
}

.nav-sidebar .nav-item .nav-link:hover {
    background-color: rgba(255,255,255,0.1);
    color: #fff;
}

.nav-sidebar .nav-item .nav-link.active {
    background-color: #007bff;
    color: #fff;
    box-shadow: 0 2px 4px rgba(0,123,255,0.25);
}

.nav-header {
    color: #6c757d;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 1rem;
    padding: 0.5rem 1rem;
}

.nav-treeview .nav-link {
    padding-left: 2.5rem;
}

.nav-treeview .nav-link.active {
    background-color: rgba(0,123,255,0.8);
}

/* Badge styles */
.badge {
    font-size: 0.65rem;
    font-weight: 600;
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .nav-header {
        display: none;
    }
}

/* Animation for menu items */
.nav-item {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Icon colors */
.nav-icon.text-danger {
    color: #dc3545 !important;
}

/* Hover effects for better UX */
.nav-link:hover .nav-icon {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}
</style>
