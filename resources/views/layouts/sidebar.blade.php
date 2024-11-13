<style>
    
</style>
<div class="sidebar">
    <!-- Logo SIPASTI -->
    <div class="sidebar-logo" style="padding: 20px; color: #FFFFFF; font-size: 1.5em;">

    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : ''}}">
                    <i class="bi bi-columns-gap"></i>
                    <p>
                        Beranda
                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview {{ ($activeMenu == 'user_type' || $activeMenu == 'user') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-people"></i>
                    <p> Pengguna <i class="right bi bi-caret-left-fill"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/user_type') }}" class="nav-link {{ ($activeMenu == 'user_type') ? 'active' : '' }}">
                            <i class="bi bi-person"></i>
                            <p>Jenis Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                            <i class="bi bi-person"></i>
                            <p>Data Pengguna</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview {{ ($activeMenu == 'certification' || $activeMenu == 'vendorCtfn' || ($activeMenu == 'typeCtfn')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <p> Sertifikasi <i class="right bi bi-caret-left-fill"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/certification') }}" class="nav-link {{ ($activeMenu == 'certification') ? 'active' : '' }}">
                            <i class="bi bi-card-list"></i>
                            <p>Data Sertifikasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/vendorCtfn') }}" class="nav-link {{ ($activeMenu == 'vendorCtfn') ? 'active' : '' }}">
                            <i class="bi bi-person-gear"></i>
                            <p>Vendor Sertifikasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/certification_type') }}" class="nav-link {{ ($activeMenu == 'certification_type') ? 'active' : '' }}">
                            <i class="bi bi-list-nested"></i>
                            <p>Jenis Sertifikasi</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview {{ ($activeMenu == 'training' || $activeMenu == 'vendorTrn' || ($activeMenu == 'typeTrn')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-journals"></i>
                    <p> Pelatihan 
                        <i class="right bi bi-caret-left-fill"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/training') }}" class="nav-link {{ ($activeMenu == 'training') ? 'active' : '' }}">
                            <i class="bi bi-card-list"></i>
                            <p>Data Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/vendorTrn') }}" class="nav-link {{ ($activeMenu == 'vendorTrn') ? 'active' : '' }}">
                            <i class="bi bi-person-gear"></i>
                            <p>Vendor Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/typeTrn') }}" class="nav-link {{ ($activeMenu == 'typeTrn') ? 'active' : '' }}">
                            <i class="bi bi-list-nested"></i>
                            <p>Jenis Pelatihan</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>