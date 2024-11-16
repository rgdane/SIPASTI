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
                class="nav-item has-treeview {{ ($activeMenu == 'user_type' || $activeMenu == 'user') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-people"></i>
                    <p> Pengguna <i class="right bi bi-caret-left-fill"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/user_type') }}"
                            class="nav-link {{ ($activeMenu == 'user_type') ? 'active' : '' }}">
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

            <li
<<<<<<< HEAD
                class="nav-item has-treeview {{ ($activeMenu == 'certification' || $activeMenu == 'certificationVendor' || ($activeMenu == 'certification_type')) ? 'menu-open' : '' }}">
=======
                class="nav-item has-treeview {{ ($activeMenu == 'certification' || $activeMenu == 'certification_vendor' || ($activeMenu == 'certificationType')) ? 'menu-open' : '' }}">
>>>>>>> 1f14f2f01ed9d7af3b7d7e65dc39005a571fe40f
                <a href="#" class="nav-link">
                    <i class="bi bi-award"></i>
                    <p> Sertifikasi <i class="right bi bi-caret-left-fill"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/certification') }}"
                            class="nav-link {{ ($activeMenu == 'certification') ? 'active' : '' }}">
                            <i class="bi bi-card-list"></i>
                            <p>Data Sertifikasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/certification_input') }}"
                            class="nav-link {{ ($activeMenu == 'certification_input') ? 'active' : '' }}">
                            <i class="bi bi-card-list"></i>
                            <p>Input Sertifikasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/certification_vendor') }}"
                            class="nav-link {{ ($activeMenu == 'certification_vendor') ? 'active' : '' }}">
                            <i class="bi bi-building-gear"></i>
                            <p>Vendor Sertifikasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
<<<<<<< HEAD
                        <a href="{{ url('/certification_type') }}"
                            class="nav-link {{ ($activeMenu == 'certification_type') ? 'active' : '' }}">
=======
                        <a href="{{ url('/certification_type') }}" class="nav-link {{ ($activeMenu == 'certification_type') ? 'active' : '' }}">
>>>>>>> 1f14f2f01ed9d7af3b7d7e65dc39005a571fe40f
                            <i class="bi bi-list-nested"></i>
                            <p>Jenis Sertifikasi</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="nav-item has-treeview {{ ($activeMenu == 'training' || $activeMenu == 'trainingVendor' || ($activeMenu == 'trainingType')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-journal-text"></i>
                    <p> Pelatihan
                        <i class="right bi bi-caret-left-fill"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/training') }}"
                            class="nav-link {{ ($activeMenu == 'training') ? 'active' : '' }}">
                            <i class="bi bi-card-list"></i>
                            <p>Data Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/trainingVendor') }}"
                            class="nav-link {{ ($activeMenu == 'trainingVendor') ? 'active' : '' }}">
                            <i class="bi bi-building-gear"></i>
                            <p>Vendor Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/trainingType') }}"
                            class="nav-link {{ ($activeMenu == 'trainingType') ? 'active' : '' }}">
                            <i class="bi bi-list-nested"></i>
                            <p>Jenis Pelatihan</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ url('/interest') }}" class="nav-link {{ ($activeMenu == 'interest') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <p>Bidang Minat</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/course') }}" class="nav-link {{ ($activeMenu == 'course') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <p>Mata Kuliah</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/envelope') }}" class="nav-link {{ ($activeMenu == 'envelope') ? 'active' : '' }}">
                    <i class="bi bi-envelope"></i>
                    <p>Surat Tugas</p>
                </a>
            </li>

            {{-- Sidebar Untuk Dosen --}}

            <li
                class="nav-item has-treeview {{ ($activeMenu == 'input_certification' || $activeMenu == 'history_certification') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-award"></i>
                    <p> Sertifikasi <i class="right bi bi-caret-left-fill"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/input_certification') }}"
                            class="nav-link {{ ($activeMenu == 'input_certification') ? 'active' : '' }}">
                            <i class="bi bi-upload"></i>
                            <p>Input & Upload Sertifikasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/history_certification') }}"
                            class="nav-link {{ ($activeMenu == 'history_certification') ? 'active' : '' }}">
                            <i class="bi bi-clock"></i>
                            <p>Riwayat Sertifikasi</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="nav-item has-treeview {{ ($activeMenu == 'input_training' || $activeMenu == 'history_training') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="bi bi-journal-text"></i>
                    <p> Pelatihan <i class="right bi bi-caret-left-fill"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/input_training') }}"
                            class="nav-link {{ ($activeMenu == 'input_training') ? 'active' : '' }}">
                            <i class="bi bi-upload"></i>
                            <p>Input & Upload Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/history_training') }}"
                            class="nav-link {{ ($activeMenu == 'history_training') ? 'active' : '' }}">
                            <i class="bi bi-clock"></i>
                            <p>Riwayat Pelatihan</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="nav-item has-treeview {{ ($activeMenu == 'envelope_submission' || $activeMenu == 'history_envelope') ? 'menu-open' : '' }}">
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