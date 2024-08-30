<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="https://ui-avatars.com/api/?name=app&color=7F9CF5&background=EBF4FF" type="image/x-icon">
    <title>
        {{ config('app.name') }} | @yield('title', '')
    </title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Booststrap Icons -->
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}"/>

    @stack('custom-css') <!-- Custom CSS Stack -->
    <style>
        .profile-picture {
            max-width: 40px;
            max-height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        html, body {
            height: 100%;
            background-image: url('https://cms.it.osu.edu/sites/default/files/2023-06/timesheet.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>
<body>
@auth
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="btn btn-outline-secondary btn-sm me-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample"
                    aria-controls="offcanvasExample">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img
                    src="https://dhillonmedicalcentre.com/wp-content/uploads/2023/10/cropped-Dhillon-Medical-Centre.png"
                    alt="" class="profile-picture me-lg-2">
                {{ config('app.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employees.index') }}">Karyawan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('payroll.index') }}">Penggajian</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Laporan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('reports.salary') }}">Laporan Gaji</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.benefits') }}">Laporan Tunjangan</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('reports.taxes') }}">Laporan Pajak</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                           role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img
                                src="{{ Auth::user()->detail->photo ?? 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                                alt="{{ Auth::user()->name }}" class="profile-picture me-2">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item" href="{{ route('logout') }}" id="logout">Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <aside class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
           aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ config('app.name') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   aria-current="true">
                    Dashboard
                </a>
                @if($isSuperAdmin)
                    <!-- Only Super Admin can see this -->
                    <a href="{{ route('superadmin') }}"
                       class="list-group-item list-group-item-action {{ request()->routeIs('superadmin') ? 'active' : '' }}">
                        Super Admin Menu
                    </a>
                @endif
                <!-- Karyawan Menu with Submenu -->
                <div class="list-group">
                    <a href="#"
                       class="list-group-item list-group-item-action {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" data-bs-target="#karyawanMenu" aria-expanded="false"
                       aria-controls="karyawanMenu">
                        Karyawan
                    </a>
                    <div id="karyawanMenu" class="collapse {{ request()->routeIs('employees.*') ? 'show' : '' }}">
                        <a href="{{ route('employees.index') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('employees.index') ? 'active' : '' }}">Daftar
                            Karyawan</a>
                        <a href="{{ route('employees.create') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('employees.create') ? 'active' : '' }}">Tambah/Edit
                            Karyawan</a>
                        <a href="{{ route('employees.status') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('employees.status') ? 'active' : '' }}">Karyawan
                            Aktif/Tidak Aktif</a>
                    </div>
                </div>
                <!-- Penggajian Menu with Submenu -->
                <div class="list-group">
                    <a href="#"
                       class="list-group-item list-group-item-action {{ request()->routeIs('payroll.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" data-bs-target="#payrollMenu" aria-expanded="false"
                       aria-controls="payrollMenu">
                        Penggajian
                    </a>
                    <div id="payrollMenu" class="collapse {{ request()->routeIs('payroll.*') ? 'show' : '' }}">
                        <a href="{{ route('payroll.index') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('payroll.index') ? 'active' : '' }}">Gaji
                            Bulanan</a>
                        <a href="{{ route('payroll.additions') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('payroll.additions') ? 'active' : '' }}">Tambahan
                            dan Potongan</a>
                        <a href="{{ route('payroll.approval') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('payroll.approval') ? 'active' : '' }}">Pengesahan
                            Gaji</a>
                        <a href="{{ route('payroll.history') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('payroll.history') ? 'active' : '' }}">Riwayat
                            Penggajian</a>
                    </div>
                </div>
                <!-- Tunjangan dan Manfaat Menu with Submenu -->
                <div class="list-group">
                    <a href="#"
                       class="list-group-item list-group-item-action {{ request()->routeIs('benefits.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" data-bs-target="#benefitsMenu" aria-expanded="false"
                       aria-controls="benefitsMenu">
                        Tunjangan dan Manfaat
                    </a>
                    <div id="benefitsMenu" class="collapse {{ request()->routeIs('benefits.*') ? 'show' : '' }}">
                        <a href="{{ route('benefits.list') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('benefits.list') ? 'active' : '' }}">Daftar
                            Tunjangan</a>
                        <a href="{{ route('benefits.employee') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('benefits.employee') ? 'active' : '' }}">Manfaat
                            Karyawan</a>
                    </div>
                </div>
                <!-- Pajak dan Kepatuhan Menu with Submenu -->
                <div class="list-group">
                    <a href="#"
                       class="list-group-item list-group-item-action {{ request()->routeIs('taxes.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" data-bs-target="#taxesMenu" aria-expanded="false"
                       aria-controls="taxesMenu">
                        Pajak dan Kepatuhan
                    </a>
                    <div id="taxesMenu" class="collapse {{ request()->routeIs('taxes.*') ? 'show' : '' }}">
                        <a href="{{ route('taxes.rules') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('taxes.rules') ? 'active' : '' }}">Peraturan
                            Pajak</a>
                        <a href="{{ route('taxes.report') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('taxes.report') ? 'active' : '' }}">Laporan
                            Pajak</a>
                        <a href="{{ route('taxes.compliance') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('taxes.compliance') ? 'active' : '' }}">Kepatuhan</a>
                    </div>
                </div>
                <!-- Laporan Menu with Submenu -->
                <div class="list-group">
                    <a href="#"
                       class="list-group-item list-group-item-action {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" data-bs-target="#reportsMenu" aria-expanded="false"
                       aria-controls="reportsMenu">
                        Laporan
                    </a>
                    <div id="reportsMenu" class="collapse {{ request()->routeIs('reports.*') ? 'show' : '' }}">
                        <a href="{{ route('reports.salary') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('reports.salary') ? 'active' : '' }}">Laporan
                            Gaji</a>
                        <a href="{{ route('reports.benefits') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('reports.benefits') ? 'active' : '' }}">Laporan
                            Tunjangan</a>
                        <a href="{{ route('reports.taxes') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('reports.taxes') ? 'active' : '' }}">Laporan
                            Pajak</a>
                    </div>
                </div>
                <!-- Pengaturan Menu with Submenu -->
                <div class="list-group">
                    <a href="#"
                       class="list-group-item list-group-item-action {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" data-bs-target="#settingsMenu" aria-expanded="false"
                       aria-controls="settingsMenu">
                        Pengaturan
                    </a>
                    <div id="settingsMenu" class="collapse {{ request()->routeIs('settings.*') ? 'show' : '' }}">
                        <a href="{{ route('settings.general') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('settings.general') ? 'active' : '' }}">Pengaturan
                            Umum</a>
                        <a href="{{ route('settings.salary') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('settings.salary') ? 'active' : '' }}">Pengaturan
                            Gaji</a>
                        <a href="{{ route('settings.benefits') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('settings.benefits') ? 'active' : '' }}">Pengaturan
                            Tunjangan</a>
                    </div>
                </div>
                <!-- Audit dan Log -->
                <div class="list-group">
                    <a href="#"
                       class="list-group-item list-group-item-action {{ request()->routeIs('audit.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" data-bs-target="#auditMenu" aria-expanded="false"
                       aria-controls="auditMenu">
                        Audit dan Log
                    </a>
                    <div id="auditMenu" class="collapse {{ request()->routeIs('audit.*') ? 'show' : '' }}">
                        <a href="{{ route('audit.payroll') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('audit.payroll') ? 'active' : '' }}">Audit
                            Penggajian</a>
                        <a href="{{ route('audit.log') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('audit.log') ? 'active' : '' }}">Log
                            Aktivitas</a>
                    </div>
                </div>
                <!-- Bantuan -->
                <a href="{{ route('help') }}"
                   class="list-group-item list-group-item-action {{ request()->routeIs('help') ? 'active' : '' }}">Bantuan</a>
                <!-- Notifikasi dan Pengumuman -->
                <a href="{{ route('notifications') }}"
                   class="list-group-item list-group-item-action {{ request()->routeIs('notifications') ? 'active' : '' }}">Notifikasi
                    dan Pengumuman</a>
            </div>
        </div>
    </aside>

@endauth

<main class="main-content">
    @yield('content')
</main>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!-- JQuery -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<!-- DataTables JS -->
<script src="{{ asset('assets/js/datatables.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTables
        $('.dataTable').DataTable({
            responsive: true
        });

        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Satuan',
            width: '100%' // Make sure the Select2 dropdown is full width
        });

        // Logout Confirmation
        $('#logout').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Logout',
                text: 'Are you sure you want to logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'No, Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logout-form').submit();
                }
            });
        });
    });
</script>
@stack('custom-js') <!-- Custom JS Stack -->
</body>
</html>
