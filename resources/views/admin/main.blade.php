<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ngabsen.in - Admin</title>

    <!-- Bootstrap & Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
            background-color: #f0f5f9;
        }

        h4 {
            color: #0f2c63;
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
            padding-top: 2rem;
            
        }

        .sidebar .logo {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .sidebar .logo span {
            color: #fbb03b;
        }

        .sidebar .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            margin-bottom: 10px;
            color: white;
            text-decoration: none;
            border-radius: 40px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .sidebar .nav-item:hover {
            background-color: #123876;
            color: #fbb03b; 
        }

        .sidebar .nav-item.active {
            background-color: white;
            color: #0f2c63 !important;
            font-weight: 600;
        }

        .sidebar .nav-item.active i {
            color: #0f2c63 !important;
        }

        .content-area {
            padding: 1.5rem;
            overflow-x: hidden;
            background-color: #f0f5f9;
        }

        #overlay {
            display: none;
            position: fixed;
            z-index: 1040;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .btn-toggle-sidebar {
            background-color: #f0f5f9;
            color: #0f2c63 !important;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 0.8rem;
            font-size: 1.25rem;
            transition: background-color 0.2s ease;
        }

        .btn-toggle-sidebar:hover {
            color: black;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1050;
                top: 0;
                left: 0;
                width: 75%;
                height: 100vh;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            #overlay.show {
                display: block;
            }

            .content-area {
                padding-top: 1rem;
            }

            .user-dropdown {
                background-color: transparent !important;
                box-shadow: none !important;
                padding: 0 !important;
            }

            .user-name {
                color: #0f2c63;
                font-weight: 600;
            }

            .user-dropdown .bi-chevron-down {
                display: none !important;
            }
        }
        
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        <!-- Overlay -->
        <div id="overlay"></div>

        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar d-md-block" id="sidebar">
            <div class="logo">ngabsen.<span>in</span></div>

            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i> Beranda
            </a>

            <a href="{{ route('admin.presensi') }}" class="nav-item {{ request()->routeIs('admin.presensi') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i> Presensi
            </a>

            <a href="{{ route('admin.kantor') }}" class="nav-item {{ request()->routeIs('admin.kantor') || request()->routeIs('admin.office*') ? 'active' : '' }}">
                <i class="bi bi-building me-2"></i> Kantor
            </a>

            <a href="{{ route('admin.pengguna') }}" class="nav-item {{ request()->routeIs('admin.pengguna') || request()->routeIs('admin.user*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i> Pengguna
            </a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 content-area">
            <!-- Toggle Button (Mobile) -->
            <button class="btn-toggle-sidebar d-md-none mb-3" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>

            <!-- User Info Dropdown -->
            <div class="d-flex justify-content-end align-items-center mb-3 px-2">
                <div class="dropdown">
                    <a href="#" class="user-dropdown d-flex align-items-center text-decoration-none gap-2 p-2" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle text-white d-flex justify-content-center align-items-center" style="width: 36px; height: 36px; background-color: #0f2c63;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="user-details">
                            <div class="fw-semibold user-name" style="font-size: 0.9rem; color: #0f2c63;">{{ Auth::user()->nama ?? 'Admin' }}</div>
                            <div class="text-muted user-role" style="font-size: 0.75rem;">Admin</div>
                        </div>
                        <i class="bi bi-chevron-down text-muted ms-1 d-none d-sm-inline"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm border-0" aria-labelledby="userDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            @yield('content')

            {{-- Footer --}}
            <footer class="mt-3 py-2 text-center" style="color: #0f2c63;">
                <div class="small">
                    &copy; {{ date('Y') }} <strong>Ngabsen.in</strong> — Sistem Presensi Karyawan. Dibuat oleh Tim IBI Kesatuan.
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- Toggle Sidebar Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleSidebar");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");

        function toggleSidebar() {
            sidebar.classList.toggle("show");
            overlay.classList.toggle("show");
        }

        toggleBtn?.addEventListener("click", toggleSidebar);
        overlay?.addEventListener("click", toggleSidebar);
    });
</script>
</body>
</html>
