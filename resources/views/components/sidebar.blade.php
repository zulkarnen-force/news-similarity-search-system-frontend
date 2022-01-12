        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('index')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Binocular</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('/') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('index')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            @auth
            
            {{-- check hanya admin yang dapat melihat data User --}}
            @if (Auth::user()->roles == 'ADMIN')
            <!-- Nav Item - User -->
            <li class="nav-item {{ request()->is('user') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('user-index')}}">
                <i class="far fa-user"></i>
                <span>Users</span></a>
            </li>
            @endif
            
            <!-- Nav Item - User -->
            <li class="nav-item {{ request()->is('file') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('file-index')}}">
                <i class="fas fa-upload"></i>
                <span>Upload File</span></a>
            </li>
            @endauth
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->