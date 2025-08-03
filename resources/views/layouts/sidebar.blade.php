<!-- Sidebar -->
<!--
Sidebar Mini Mode - Display Helper classes

Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
    If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
-->
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <!-- Logo -->
            <a class="fw-bold text-white tracking-wide fs-2" href="{{ route('dashboard.index') }}">
                <span class="smini-visible">
                    SIK<span class="opacity-50">AP</span>
                </span>
                <span class="smini-hidden">
                    SIK<span class="opacity-50">AP</span>
                </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Toggle Sidebar Style -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                    data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on"
                    onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </button>
                <!-- END Toggle Sidebar Style -->

                <!-- Dark Mode -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                    data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
                    <i class="far fa-moon" id="dark-mode-toggler"></i>
                </button>
                <!-- END Dark Mode -->

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout"
                    data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}"
                        href="{{ route('dashboard.index') }}">
                        <i class="nav-main-link-icon si si-home"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                        {{-- <span class="nav-main-link-badge badge rounded-pill bg-primary">5</span> --}}
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('project*') ? ' active' : '' }}"
                        href="{{ route('project.index') }}">
                        <i class="nav-main-link-icon fa fa-briefcase"></i>
                        <span class="nav-main-link-name">Project</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dapil*') ? ' active' : '' }}"
                        href="{{ route('dapil.index') }}">
                        <i class="nav-main-link-icon fa fa-map"></i>
                        <span class="nav-main-link-name">Dapil</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('tps*') ? ' active' : '' }}"
                        href="{{ route('tps.index') }}">
                        <i class="nav-main-link-icon fa fa-cube"></i>
                        <span class="nav-main-link-name">TPS</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('election*') ? ' active' : '' }}"
                        href="{{ route('election.index') }}">
                        <i class="nav-main-link-icon fa fa-line-chart"></i>
                        <span class="nav-main-link-name">Hasil Pemilu</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('visit*') ? ' active' : '' }}"
                        href="{{ route('visit.index') }}">
                        <i class="nav-main-link-icon fa fa-plane"></i>
                        <span class="nav-main-link-name">Kunjungan</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('issue*') ? ' active' : '' }}"
                        href="{{ route('issue.index') }}">
                        <i class="nav-main-link-icon fa fa-bug"></i>
                        <span class="nav-main-link-name">Isu-isu</span>
                    </a>
                </li>

                {{-- <li class="nav-main-heading">Pelayanan</li> --}}
                {{-- @Admin
                    <li class="nav-main-item{{ request()->is('pasien*') ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="true" href="#">
                            <i class="nav-main-link-icon fa fa-user-injured"></i>
                            <span class="nav-main-link-name">Pasien</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('pasien/create') ? ' active' : '' }}"
                                    href="{{ route('pasien.create') }}">
                                    <span class="nav-main-link-name">Tambah Pasien Baru</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('pasien') ? ' active' : '' }}"
                                    href="{{ route('pasien.index') }}">
                                    <span class="nav-main-link-name">Data Pasien</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item{{ request()->is('registrasi*') ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="true" href="#">
                            <i class="nav-main-link-icon fa fa-book"></i>
                            <span class="nav-main-link-name">Registrasi</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('registrasi/create') ? ' active' : '' }}"
                                    href="{{ route('registrasi.create') }}">
                                    <span class="nav-main-link-name">Buat Registrasi Baru</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('registrasi') ? ' active' : '' }}"
                                    href="{{ route('registrasi.index') }}">
                                    <span class="nav-main-link-name">Data Registrasi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endAdmin

                @Suster
                    <li class="nav-main-item{{ request()->is('pemeriksaan-*') ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="true" href="#">
                            <i class="nav-main-link-icon fa fa-stethoscope"></i>
                            <span class="nav-main-link-name">Pemeriksaan</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('pemeriksaan-awal*') ? ' active' : '' }}"
                                    href="{{ route('pemeriksaan-awal.index') }}">
                                    <span class="nav-main-link-name">Pemeriksaan Awal</span>
                                </a>
                            </li>
                            @Dokter
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('pemeriksaan-dokter*') ? ' active' : '' }}"
                                        href="{{ route('pemeriksaan-dokter.index') }}">
                                        <span class="nav-main-link-name">Pemeriksaan Dokter</span>
                                    </a>
                                </li>
                            @endDokter
                        </ul>
                    </li>
                @endSuster
                @Kasir
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('kasir*') ? ' active' : '' }}"
                            href="{{ route('kasir.index') }}">
                            <i class="nav-main-link-icon fa fa-cash-register"></i>
                            <span class="nav-main-link-name">Kasir</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('laporan*') ? ' active' : '' }}"
                            href="{{ route('laporan.index') }}">
                            <i class="nav-main-link-icon fa fa-money-bill-trend-up"></i>
                            <span class="nav-main-link-name">Laporan</span>
                        </a>
                    </li>
                @endKasir --}}
                {{-- @superAdmin --}}
                <li class="nav-main-heading">Super Admin</li>
                <li class="nav-main-item{{ request()->is('master-data*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-database"></i>
                        <span class="nav-main-link-name">Master Data</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/user*') ? ' active' : '' }}"
                                href="{{ route('user.index') }}">
                                <i class="nav-main-link-icon fa fa-users"></i>
                                <span class="nav-main-link-name">User</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/gender*') ? ' active' : '' }}"
                                href="{{ route('gender.index') }}">
                                <i class="nav-main-link-icon si si-symbol-female"></i>
                                <span class="nav-main-link-name">Gender</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/role*') ? ' active' : '' }}"
                                href="{{ route('role.index') }}">
                                <i class="nav-main-link-icon fa fa-user-gear"></i>
                                <span class="nav-main-link-name">Role</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/category*') ? ' active' : '' }}"
                                href="{{ route('category.index') }}">
                                <i class="nav-main-link-icon fa fa-bars"></i>
                                <span class="nav-main-link-name">Category</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/status*') ? ' active' : '' }}"
                                href="{{ route('status.index') }}">
                                <i class="nav-main-link-icon fa fa-tags"></i>
                                <span class="nav-main-link-name">Status</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Area</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/provinsi*') ? ' active' : '' }}"
                                href="{{ route('provinsi.index') }}">
                                <i class="nav-main-link-icon fa fa-building"></i>
                                <span class="nav-main-link-name">Provinsi</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/kabupaten*') ? ' active' : '' }}"
                                href="{{ route('kabupaten.index') }}">
                                <i class="nav-main-link-icon fa fa-university"></i>
                                <span class="nav-main-link-name">Kabupaten</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/kecamatan*') ? ' active' : '' }}"
                                href="{{ route('kecamatan.index') }}">
                                <i class="nav-main-link-icon fa fa-industry"></i>
                                <span class="nav-main-link-name">Kecamatan</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/desa*') ? ' active' : '' }}"
                                href="{{ route('desa.index') }}">
                                <i class="nav-main-link-icon fa fa-home"></i>
                                <span class="nav-main-link-name">Desa</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Project</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/party*') ? ' active' : '' }}"
                                href="{{ route('party.index') }}">
                                <i class="nav-main-link-icon fa fa-flag"></i>
                                <span class="nav-main-link-name">Partai</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/periode*') ? ' active' : '' }}"
                                href="{{ route('periode.index') }}">
                                <i class="nav-main-link-icon fa fa-clock"></i>
                                <span class="nav-main-link-name">Periode</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/election-type*') ? ' active' : '' }}"
                                href="{{ route('election-type.index') }}">
                                <i class="nav-main-link-icon fa fa-id-card"></i>
                                <span class="nav-main-link-name">Tipe Pemilihan</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Profil</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/profile*') ? ' active' : '' }}"
                                href="{{ route('profile.index') }}">
                                <i class="nav-main-link-icon fa fa-address-card"></i>
                                <span class="nav-main-link-name">Profil Kandidat</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Kunjungan</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('master-data/visit-type*') ? ' active' : '' }}"
                                href="{{ route('visit-type.index') }}">
                                <i class="nav-main-link-icon fa fa-newspaper"></i>
                                <span class="nav-main-link-name">Tipe Kunjungan</span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- @endsuperAdmin --}}
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
<!-- END Sidebar -->
