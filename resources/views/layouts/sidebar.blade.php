<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion
" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('') }}">
        <div class="sidebar-brand-text mx-1">Klinik</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('*dashboard*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fas fa-fw fa-signal"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ request()->is('*kelola-kas*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/kelola-kas') }}">
            <i class="fas fa-fw fa-book-medical"></i>
            <span>Catat Arus Kas</span></a>
    </li>
    <li class="nav-item {{ request()->is('*riwayat-kas*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('riwayat-kas') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Arus Kas</span></a>
    </li>
    <li class="nav-item {{ request()->is('*setting*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('setting') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
