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
                @can('Finance BiayaJasa')
                <li class="{{ request()->is('jasa/biaya_jasa/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('jasa.biayaJasa') }}">
                        <i data-feather="truck"></i>
                        <span>Biaya Jasa</span>
                    </a>
                </li>
                @endcan
                <li class="menu-title">Finance</li>
                @can('Finance PPN')
                <li class="{{ request()->is('jurnal/keuangan/*') ? 'menuitem-active' : null }}">
                    <a href="#">
                        <i data-feather="truck"></i>
                        <span>PPN</span>
                    </a>
                </li>
                @endcan
                {{-- <li class="{{ request()->is('jurnal/keuangan/*') ? 'menuitem-active' : null }}">
                    <a href="#">
                        <i data-feather="truck"></i>
                        <span>Kode COA</span>
                    </a>
                </li> --}}
                @can('Finance COA')
                <li class="{{ request()->is('finance/coa/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('finance.coa') }}">
                        <i data-feather="truck"></i>
                        <span>Chart of Account</span>
                    </a>
                </li>
                @endcan
                @can('Finance Journal')
                <li class="{{ request()->is('finance/journal/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('finance.journal') }}">
                        <i data-feather="truck"></i>
                        <span>Jurnal</span>
                    </a>
                </li>
                @endcan
                @can('Finance BukuBesar')
                <li class="{{ request()->is('finance/buku_besar/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('finance.buku_besar') }}">
                        <i data-feather="truck"></i>
                        <span>Buku Besar</span>
                    </a>
                </li>
                @endcan
                @can('Finance LajurBuku')
                <li class="{{ request()->is('finance/lajur/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('finance.lajur') }}">
                        <i data-feather="truck"></i>
                        <span>Lajur Buku</span>
                    </a>
                </li>
                @endcan
                @can('Finance LabaRugi')
                <li class="{{ request()->is('finance/laba_rugi/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('finance.laba_rugi') }}">
                        <i data-feather="truck"></i>
                        <span>Laba / Rugi</span>
                    </a>
                </li>
                @endcan
                @can('Finance Neraca')
                <li class="{{ request()->is('finance/neraca/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('finance.neraca') }}">
                        <i data-feather="truck"></i>
                        <span>Neraca</span>
                    </a>
                </li>
                @endcan

                @can('Keuangan List')
                <li class="menu-title">Laporan</li>
                {{-- <li class="{{ request()->is('laporan/keuangan/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('lap_keuangan.index') }}">
                        <i data-feather="truck"></i>
                        <span>Keuangan</span>
                    </a>
                </li> --}}
                <li class="{{ request()->is('laporan/inspeksi/*') ? 'menuitem-active' : null }}">
                    <a href="{{ route('lap_inspeksi.index') }}">
                        <i data-feather="truck"></i>
                        <span>Inspeksi</span>
                    </a>
                </li>
                @endcan

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
