<style>
    /* Sidebar Styling */
    .sidebar {
        background-color: #2C3941;
        /* Warna latar sidebar */
        height: 100vh;
        color: #FFFFFF;
        font-size: 1rem;
    }

    .sidebar-logo {
        text-align: center;
        font-weight: bold;
        font-size: 1.5em;
    }

    .sidebar .nav-link {
        color: #FFFFFF;
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .sidebar .nav-link i {
        margin-right: 10px;
        font-size: 1.25rem;
        color: inherit;
    }

    .sidebar .nav-link.active {
        background-color: #FFFFFF !important;
        color: #000000 !important;
    }

    .sidebar .nav-link.active i {
        color: #000000 !important;
    }

    .sidebar .nav-item.has-treeview .nav-link {
        color: #FFFFFF;
    }

    .sidebar .nav-item.has-treeview .nav-link i.right {
        margin-left: auto;
    }

    .sidebar .nav-item.has-treeview.menu-open>.nav-link {
        background-color: #CBD5DC;
        color: #000000;
    }

    .sidebar .nav-item.has-treeview.menu-open>.nav-link i {
        color: #000000;
    }

    .sidebar .nav-treeview .nav-link.active {
        background-color: #FFFFFF;
        color: #000000;
    }

    .sidebar .nav-link i {
        display: inline-block;
        text-align: center;
        width: 30px;
        /* Memastikan ikon berada di tengah */
    }

    .sidebar .nav-link p {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .sidebar .nav-link i.right {
        font-size: 1rem;
        margin-right: 2px;
        transform: rotate(0deg);
        transition: transform 0.1s ease;
    }
</style>
<div class="sidebar">
    <br>
    <br>
    <!-- Sidebar Menu -->
    <nav class="mt-2">

        {{-- Sidebar Untuk Admin --}}
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : ''}}">
                    <i class="bi bi-columns-gap"></i>
                    <p>
                        Beranda
                    </p>
                </a>
            </li>

            <li
                class="nav-item has-treeview {{ ($activeMenu == 'certification_input' || $activeMenu == 'certification_history') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-award"></i>
                    <p> Sertifikasi <i class="right bi bi-caret-left-fill"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/certification_input') }}" class="nav-link {{ ($activeMenu == 'certification_input') ? 'active' : '' }}">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <p>Input Sertifikasi</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/certification_history') }}" class="nav-link {{ ($activeMenu == 'certification_history') ? 'active' : '' }}">
                            <i class="bi bi-clock"></i>
                            <p>Riwayat Sertifikasi</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="nav-item has-treeview {{ ($activeMenu == 'training_input' || $activeMenu == 'training_history') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-journal-text"></i>
                    <p> Pelatihan
                        <i class="right bi bi-caret-left-fill"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/training_input') }}" class="nav-link {{ ($activeMenu == 'training_input') ? 'active' : '' }}">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <p>Input Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/training_history') }}"
                            class="nav-link {{ ($activeMenu == 'training_history') ? 'active' : '' }}">
                            <i class="bi bi-clock"></i>
                            <p>Riwayat Pelatihan</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Sidebar Untuk Dosen --}}
            <li class="nav-item has-treeview {{ ($activeMenu == 'envelope_submission' || $activeMenu == 'history_envelope') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-envelope"></i>
                    <p> Surat <i class="right bi bi-caret-left-fill"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/envelope_submission') }}"
                            class="nav-link {{ ($activeMenu == 'envelope_submission') ? 'active' : '' }}">
                            <i class="bi bi-envelope-paper"></i>
                            <p>Permintaan Surat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/history_envelope') }}"
                            class="nav-link {{ ($activeMenu == 'history_envelope') ? 'active' : '' }}">
                            <i class="bi bi-clock"></i>
                            <p>Riwayat Permintaan Surat</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>