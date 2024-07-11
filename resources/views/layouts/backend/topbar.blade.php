<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-end mb-0">

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ $asset }}/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ms-1">
                        {{ auth()->user()->name }} <i class="uil uil-angle-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <a href="pages-profile.html" class="dropdown-item notify-item">
                        <i data-feather="user" class="icon-dual icon-xs me-1"></i><span>My Account</span>
                    </a>

                    <a href="pages-lock-screen.html" class="dropdown-item notify-item">
                        <i data-feather="lock" class="icon-dual icon-xs me-1"></i><span>Lock Screen</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                        <i data-feather="log-out" class="icon-dual icon-xs me-1"></i><span>Logout</span>
                    </a>

                </div>
            </li>

            <!-- <li class="dropdown notification-list">
                <a href="javascript:void(0);" class="nav-link right-bar-toggle">
                    <i data-feather="settings"></i>
                </a>
            </li> -->

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{ route('home') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ $asset }}/images/icons/logo_inspector.jpg" alt="" height="32">
                    <!-- <span class="logo-lg-text-light">Shreyu</span> -->
                </span>
                <span class="logo-lg">
                    <img src="{{ $asset }}/images/icons/logo_inspector.jpg" alt="" height="32">
                    <!-- <span class="logo-lg-text-light">S</span> -->
                </span>
            </a>

            <a href="{{ route('home') }}" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ $asset }}/images/icons/logo_inspector.jpg" alt="" height="32">
                </span>
                <span class="logo-lg">
                    <img src="{{ $asset }}/images/icons/logo_inspector.jpg" alt="" height="32">
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile">
                    <i data-feather="menu"></i>
                </button>
            </li>

            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-bs-toggle="collapse"
                    data-bs-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>

            <li class="dropdown d-none d-xl-block">
                <!-- <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    Create New
                    <i class="uil uil-angle-down"></i>
                </a> -->
                <div class="dropdown-menu">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="uil uil-bag me-1"></i><span>New Projects</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="uil uil-user-plus me-1"></i><span>Create Users</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="uil uil-chart-pie me-1"></i><span>Revenue Report</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="uil uil-cog me-1"></i><span>Settings</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="uil uil-question-circle me-1"></i><span>Help & Support</span>
                    </a>

                </div>
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
</div>
