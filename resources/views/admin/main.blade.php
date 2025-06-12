<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ngabsen.in - Admin</title>

    <!-- Bootstrap & Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
            background-color: #f0f5f9;
        }

        .container-fluid {
            min-height: 100vh;
            padding: 0;
        }

        .row {
            margin: 0;
        }

        .sidebar {
            background-color: #0f2c63;
            color: white;
            min-height: 100vh;
            overflow-y: auto;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        /* Class aktif sidebar */
        .sidebar a.active, .sidebar a:hover {
            background-color: #fbb03b;
            color: black !important;
        }

        .col-md-9.col-lg-10.p-4 {
            padding-bottom: 2rem;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-3 sidebar">
            <h5 class="fw-bold mb-4 text-center">ngabsen <span style="color: #fbb03b;">in</span></h5>

            <a href="{{ route('admin.dashboard') }}" class="d-block p-2 rounded mb-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill me-2"></i> Beranda
            </a>

            <a href="{{ route('admin.presensi') }}" class="d-block p-2 rounded mb-2 {{ request()->routeIs('admin.presensi') ? 'active' : '' }}">
                <i class="bi bi-clock me-2"></i> Presensi
            </a>

            <!-- Pastikan route kantor sesuai dengan nama route kamu -->
            <a href="{{ route('admin.kantor') }}" class="d-block p-2 rounded mb-2 {{ request()->routeIs('admin.kantor') ? 'active' : '' }}">
                <i class="bi bi-building me-2"></i> Kantor
            </a>

            <a href="{{ route('admin.pengguna') }}" class="d-block p-2 rounded mb-2 {{ request()->routeIs('admin.pengguna') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i> Pengguna
            </a>
        </div>

        <!-- Main content -->
         <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-end mb-3 align-items-center position-relative">
                <span class="me-2">{{ Auth::user()->nama ?? 'Admin' }}</span>
                <div class="dropdown">
                    <a href="#" class="text-dark" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person" style="font-size: 1.5rem; cursor: pointer;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Konten Halaman --}}
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
