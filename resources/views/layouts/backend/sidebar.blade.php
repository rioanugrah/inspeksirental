<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="assets/images/users/avatar-1.jpg" alt="user-img" title="Mat Helme"
                class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                    data-bs-toggle="dropdown">{{ auth()->user()->name }}</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <a href="pages-profile.html" class="dropdown-item notify-item">
                        <i data-feather="user" class="icon-dual icon-xs me-1"></i><span>My Account</span>
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i data-feather="settings" class="icon-dual icon-xs me-1"></i><span>Settings</span>
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i data-feather="help-circle" class="icon-dual icon-xs me-1"></i><span>Support</span>
                    </a>
                    <a href="pages-lock-screen.html" class="dropdown-item notify-item">
                        <i data-feather="lock" class="icon-dual icon-xs me-1"></i><span>Lock Screen</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i data-feather="log-out" class="icon-dual icon-xs me-1"></i><span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <!-- <li class="menu-title">Navigation</li> -->
                <li class="{{ request()->is('home/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('home') }}">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">Inspeksi</li>
                <li class="{{ request()->is('cars/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('cars') }}">
                        <i data-feather="truck"></i>
                        <span>Mobil</span>
                    </a>
                </li>

                @can('User List')
                <li class="menu-title">User Management</li>
                <li class="{{ request()->is('users/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('users.index') }}">
                        <i data-feather="users"></i>
                        <span> Users </span>
                    </a>
                </li>
                @endcan
                @can('Role List')
                <li class="{{ request()->is('roles/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('roles.index') }}">
                        <i data-feather="sliders"></i>
                        <span> Roles </span>
                    </a>
                </li>
                @endcan
                @can('Permission List')
                <li class="{{ request()->is('permissions/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('permissions') }}">
                        <i data-feather="unlock"></i>
                        <span> Permissions </span>
                    </a>
                </li>
                @endcan
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
