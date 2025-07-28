<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Sekolah')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
            --text-muted: #6c757d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: #ffffff;
            border-right: 1px solid var(--border-color);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-logo img {
            width: 50px;
            height: 50px;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
        }

        .sidebar-body {
            padding: 1rem 0;
        }

        .sidebar-section {
            margin-bottom: 1rem;
            padding: 0 1rem;
        }

        .sidebar-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #495057;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: white !important;
        }

        .nav-icon {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .nav-text {
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-text {
            display: none;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .user-details {
            white-space: nowrap;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
        }

        .content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            padding: 2rem;
        }

        .content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Header -->
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('assets/0.png') }}" alt="Logo Sekolah">
                <h1 class="logo-text">SIPENA</h1>
            </div>
            <button id="toggleSidebar" class="btn btn-sm btn-outline-secondary d-none d-md-block">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Sidebar Body -->
        <div class="sidebar-body">
            <!-- Menu Utama -->
            <div class="sidebar-section">
                <h6 class="sidebar-section-title">Menu Utama</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin') }}" class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                            <i class="fas fa-home nav-icon"></i>
                            <span class="nav-text">Dashboard Admin</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.guru') }}" class="nav-link {{ request()->routeIs('dashboard.guru') ? 'active' : '' }}">
                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                            <span class="nav-text">Dashboard Guru</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.murid') }}" class="nav-link {{ request()->routeIs('dashboard.murid') ? 'active' : '' }}">
                            <i class="fas fa-user-graduate nav-icon"></i>
                            <span class="nav-text">Dashboard Murid</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Manajemen Data -->
            <div class="sidebar-section">
                <h6 class="sidebar-section-title">Manajemen Data</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('datamurid.murid') }}" class="nav-link {{ request()->routeIs('datamurid.murid') ? 'active' : '' }}">
                            <i class="fas fa-user-graduate nav-icon"></i>
                            <span class="nav-text">Data Murid</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dataguru.guru') }}" class="nav-link {{ request()->routeIs('dataguru.guru') ? 'active' : '' }}">
                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                            <span class="nav-text">Data Guru</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('datauser.user') }}" class="nav-link {{ request()->routeIs('datauser.user') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon"></i>
                            <span class="nav-text">Data User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('datamapel.mapel') }}" class="nav-link {{ request()->routeIs('datamapel.mapel') ? 'active' : '' }}">
                            <i class="fas fa-book nav-icon"></i>
                            <span class="nav-text">Mata Pelajaran</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Akademik -->
            <div class="sidebar-section">
                <h6 class="sidebar-section-title">Akademik</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('datanilai.nilai') }}" class="nav-link {{ request()->routeIs('datanilai.nilai') ? 'active' : '' }}">
                            <i class="fas fa-star nav-icon"></i>
                            <span class="nav-text">Penilaian</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details">
                    <h6 class="user-name">Admin Sekolah</h6>
                    <p class="user-role">Administrator</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content" id="mainContent">
        @yield('content')
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('toggleSidebar');

            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
            });

            if (window.innerWidth < 768) {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
            }
        });

        window.addEventListener('resize', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('mainContent');

            if (window.innerWidth < 768) {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
            } else {
                sidebar.classList.remove('collapsed');
                content.classList.remove('expanded');
            }
        });
    </script>
</body>
</html>
