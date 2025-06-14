<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Profile Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                    <img src="{{ asset('default/avatar.png') }}"
                    class="img-circle elevation-2" width="40" height="40" alt="">
            </a>

            <div class="dropdown-menu dropdown-menu-right p-3">

                <h4 class="h4 mb-0"><strong>{{ Auth::user()->name }}</strong></h4>
                <div class="mb-3">{{ Auth::user()->email }}</div>
                <div class="dropdown-divider"></div>
                <a href="" class="dropdown-item">
                {{-- <a href="{{ route('profile.edit') }}" class="dropdown-item"> --}}

                    <i class="fas fa-user-cog mr-2"></i>Profile Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>

                <!-- Logout Form -->
                <form id="logout-form" action="" method="POST" style="display: none;">
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>
<!-- /.navbar -->
