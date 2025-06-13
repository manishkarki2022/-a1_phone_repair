<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link text-center"
        style="text-decoration: none; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 10px 0;">
        <!-- Logo -->
        <img src="{{ file_exists(public_path('' . websiteInfo()->logo)) ? asset('' . websiteInfo()->logo) : asset('default/no-image.png') }}"
            alt="{{ websiteInfo() ? websiteInfo()->name : 'Default App Name' }}"
            class="brand-image img-circle elevation-3"
            style="max-width: 60px; max-height: 60px; margin-bottom: 10px; border: 2px solid #ddd; padding: 5px; border-radius: 50%; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <!-- Website Info -->
        <span class="brand-text font-weight-light" style="font-size: 18px; font-weight: 600;">
            {{ websiteInfo() ? websiteInfo()->name : 'Default App Name' }}
        </span>
        <span class="text-sm text-muted" style="font-size: 14px; color: #888;">
            Hello {{ Auth::user()->name }}
        </span>
    </a>
    <!-- Sidebar -->

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <li
                    class="nav-item {{ request()->route()->named('dashboard') || request()->route()->named('dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                  <li
                    class="nav-item {{ request()->route()->named('admin.web_setting.show') || request()->route()->named('admin.web_setting.show') ? 'menu-open' : '' }}">
                    {{-- <a href="{{ route('site-settings.index') }}" class="nav-link"> --}}
                        <a href="{{ route('admin.web_setting.show') }}" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Site Settings
                        </p>
                    </a>
                </li>
                    <li
                    class="nav-item {{ request()->route()->named('categories.index') || request()->route()->named('categories.index') ? 'menu-open' : '' }}">
                    {{-- <a href="{{ route('site-settings.index') }}" class="nav-link"> --}}
                        <a href="{{ route('categories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                           Manage Categories
                        </p>
                    </a>
                </li>
                {{-- <li
                    class="nav-item {{ request()->route()->named('tables.create') || request()->route()->named('tables.index') || request()->route()->named('tables.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tables
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tables.create') }}"
                                class="nav-link {{ request()->route()->named('tables.create') ? 'active' : '' }}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                <p>Add Table</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tables.index') }}"
                                class="nav-link {{ request()->route()->named('tables.index') ? 'active' : '' }}">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <p>View Tables</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}

            </ul>
        </nav>
    </div>
</aside>
