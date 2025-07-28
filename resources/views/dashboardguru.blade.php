<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SIPENA</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --secondary: #6b7280;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --dark: #1f2937;
            --light: #f8fafc;
            --gray: #6b7280;
            --gray-light: #e5e7eb;
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --rounded: 0.75rem;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.5;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: -300px;
            top: 0;
            width: 300px;
            height: 100vh;
            background: var(--white);
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid var(--gray-light);
        }

        .logo {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: var(--rounded);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            font-size: 1.25rem;
        }

        .logo-text h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
        }

        .logo-text p {
            font-size: 0.75rem;
            color: var(--gray);
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-section {
            margin-bottom: 1rem;
        }

        .nav-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--gray);
            text-transform: uppercase;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--gray);
            text-decoration: none;
            transition: var(--transition);
            gap: 0.75rem;
            border-radius: var(--rounded);
            margin: 0 0.5rem;
        }

        .nav-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .nav-item.active {
            background: var(--primary);
            color: var(--white);
        }

        .nav-item i {
            width: 20px;
            font-size: 1rem;
        }

        .nav-item span {
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            margin-left: 0;
            min-height: 100vh;
            transition: var(--transition);
        }

        .main-content.shifted {
            margin-left: 300px;
        }

        /* Header */
        .header {
            background: var(--white);
            padding: 1rem 1.5rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .menu-btn {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--gray);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--rounded);
            transition: var(--transition);
        }

        .menu-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: var(--gray);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: var(--rounded);
            transition: var(--transition);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.875rem;
            font-weight: 600;
        }

        .user-details h4 {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark);
        }

        .user-details p {
            font-size: 0.75rem;
            color: var(--gray);
        }

        .logout-btn {
            background: var(--danger);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: var(--rounded);
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        /* Content */
        .content {
            padding: 1.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--rounded);
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
        }

        .stat-card:nth-child(2)::before { background: var(--warning); }
        .stat-card:nth-child(3)::before { background: var(--success); }
        .stat-card:nth-child(4)::before { background: var(--danger); }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .stat-title {
            font-size: 0.75rem;
            color: var(--gray);
            font-weight: 500;
            text-transform: uppercase;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: var(--rounded);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1rem;
        }

        .stat-icon.orange { background: var(--warning); }
        .stat-icon.green { background: var(--success); }
        .stat-icon.red { background: var(--danger); }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--dark);
        }

        .stat-change {
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 500;
        }

        .stat-change.positive { color: var(--success); }
        .stat-change.negative { color: var(--danger); }
        .stat-change.neutral { color: var(--gray); }

        /* Card */
        .card {
            background: var(--white);
            border-radius: var(--rounded);
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-title i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .card-body {
            padding: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        .table th {
            background: var(--primary-light);
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--gray-light);
            font-size: 0.875rem;
        }

        .table tr:hover {
            background: var(--primary-light);
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-avatar {
            width: 36px;
            height: 36px;
            background: var(--warning);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.875rem;
            font-weight: 600;
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge.success { background: #d1fae5; color: #065f46; }
        .badge.warning { background: #fef3c7; color: #92400e; }
        .badge.danger { background: #fee2e2; color: #991b1b; }
        .badge.info { background: #dbeafe; color: #1e40af; }

        /* Actions Grid */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .action-card {
            background: var(--white);
            border-radius: var(--rounded);
            padding: 1rem;
            text-decoration: none;
            color: var(--dark);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow-sm);
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: var(--rounded);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.25rem;
        }

        .action-icon.orange { background: var(--warning); }
        .action-icon.green { background: var(--success); }
        .action-icon.purple { background: #8b5cf6; }

        .action-content h3 {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .action-content p {
            font-size: 0.75rem;
            color: var(--gray);
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .content {
                padding: 1rem;
            }
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                left: -100%;
            }
            .main-content.shifted {
                margin-left: 0;
            }
            .header {
                padding: 0.75rem;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .user-details {
                display: none;
            }
            .logout-btn span {
                display: none;
            }
            .logout-btn {
                padding: 0.5rem;
                width: 40px;
                height: 40px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">S</div>
            <div class="logo-text">
                <h3>SIPENA</h3>
                <p>Sistem Penilaian</p>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-title">Menu Utama</div>
                <a href="{{ route('dashboard.guru') }}" class="nav-item active">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-title">Manajemen Data</div>
                <a href="{{ route('datamurid.murid') }}" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Data Murid</span>
                </a>
                <a href="{{ route('datamapel.mapel') }}" class="nav-item">
                    <i class="fas fa-book"></i>
                    <span>Mata Pelajaran</span>
                </a>
                <a href="{{ route('datanilai.nilai') }}" class="nav-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Data Nilai</span>
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-title">Akademik</div>
                <a href="{{ route('datanilai.create') }}" class="nav-item">
                    <i class="fas fa-star"></i>
                    <span>Input Penilaian</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="menu-btn" id="menuBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">Dashboard Guru</h1>
                    <p class="page-subtitle">Selamat datang di sistem penilaian SIPENA</p>
                </div>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr($guru->nama, 0, 1)) }}{{ strtoupper(substr(explode(' ', $guru->nama)[1] ?? '', 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h4>{{ $guru->nama }}</h4>
                        <p>NIP: {{ $guru->nip }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <main class="content">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Total Murid</div>
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-value">{{ $totalMurid }}</div>
                    <div class="stat-change neutral">
                        <i class="fas fa-equals"></i> <span>Jumlah seluruh murid</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Mata Pelajaran</div>
                        <div class="stat-icon orange"><i class="fas fa-book"></i></div>
                    </div>
                    <div class="stat-value">{{ $totalMapel }}</div>
                    <div class="stat-change neutral">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>{{ $mataPelajaranGuru ? 'Anda mengajar: ' . $mataPelajaranGuru->mata_pelajaran : 'Total mata pelajaran' }}</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Rata-rata Nilai</div>
                        <div class="stat-icon green"><i class="fas fa-chart-line"></i></div>
                    </div>
                    <div class="stat-value">{{ number_format($rataRata, 1) }}</div>
                    <div class="stat-change {{ $rataRata >= 75 ? 'positive' : ($rataRata >= 65 ? 'neutral' : 'negative') }}">
                        <i class="fas fa-arrow-{{ $rataRata >= 75 ? 'up' : ($rataRata >= 65 ? 'right' : 'down') }}"></i>
                        <span>{{ $rataRata >= 75 ? 'Baik' : ($rataRata >= 65 ? 'Cukup' : 'Perlu Perbaikan') }}</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Nilai Terendah</div>
                        <div class="stat-icon red"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                    <div class="stat-value">{{ $nilaiTerendah }}</div>
                    <div class="stat-change negative">
                        <i class="fas fa-arrow-down"></i> <span>Perlu perhatian khusus</span>
                    </div>
                </div>
            </div>

            <!-- Nilai Terakhir -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="fas fa-clipboard-list"></i> Nilai Terakhir Diinput</h2>
                    <a href="{{ route('datanilai.nilai') }}" class="view-all">Lihat Semua <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Murid</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Nilai</th>
                                    <th>Predikat</th>
                                    <th>Semester</th>
                                    <th>Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($nilaiTerbaru as $nilai)
                                    <tr>
                                        <td>
                                            <div class="student-info">
                                                <div class="student-avatar">
                                                    {{ strtoupper(substr($nilai->murid->nama, 0, 1)) }}{{ strtoupper(substr(explode(' ', $nilai->murid->nama)[1] ?? '', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight: 600;">{{ $nilai->murid->nama }}</div>
                                                    <div style="font-size: 0.75rem; color: var(--gray);">{{ $nilai->murid->kelas }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $nilai->mataPelajaran->mata_pelajaran }}</td>
                                        <td style="font-weight: 600; color: {{ $nilai->nilai >= 80 ? 'var(--success)' : ($nilai->nilai >= 70 ? 'var(--warning)' : 'var(--danger)') }};">
                                            {{ $nilai->nilai }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $nilai->predikat == 'A' ? 'success' : ($nilai->predikat == 'B' ? 'info' : ($nilai->predikat == 'C' ? 'warning' : 'danger')) }}">
                                                {{ $nilai->predikat }}
                                            </span>
                                        </td>
                                        <td>Semester {{ $nilai->semester }}</td>
                                        <td>{{ $nilai->guru->nama }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: var(--gray); padding: 2rem;">
                                            <i class="fas fa-inbox" style="font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                                            <div>Belum ada data nilai</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Distribusi Nilai -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="fas fa-chart-bar"></i> Distribusi Nilai</h2>
    </div>
    <div class="card-body">
        @if (empty($distribusiNilai) || array_sum($distribusiNilai) == 0)
            <div style="text-align: center; color: var(--gray); padding: 2rem;">
                <i class="fas fa-inbox" style="font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                <div>Belum ada data nilai untuk ditampilkan</div>
            </div>
        @else
            <canvas id="nilaiChart" style="height: 300px;"></canvas>
        @endif
    </div>
</div>

<!-- Proporsi Nilai Siswa -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="fas fa-chart-pie"></i> Proporsi Nilai Siswa</h2>
    </div>
    <div class="card-body">
        @if (empty($statistikPredikat) || array_sum($statistikPredikat) == 0)
            <div style="text-align: center; color: var(--gray); padding: 2rem;">
                <i class="fas fa-inbox" style="font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                <div>Belum ada data nilai untuk ditampilkan</div>
            </div>
        @else
            <canvas id="proporsiChart" style="height: 300px;"></canvas>
        @endif
    </div>
</div>

<!-- Actions Grid -->
<div class="actions-grid">
    <a href="{{ route('datanilai.create') }}" class="action-card">
        <div class="action-icon"><i class="fas fa-plus"></i></div>
        <div class="action-content">
            <h3>Tambah Nilai</h3>
            <p>Input nilai baru untuk siswa</p>
        </div>
    </a>
    <a href="{{ route('datamurid.murid') }}" class="action-card">
        <div class="action-icon orange"><i class="fas fa-graduation-cap"></i></div>
        <div class="action-content">
            <h3>Lihat Murid</h3>
            <p>Kelola data murid</p>
        </div>
    </a>
    <a href="{{ route('datamapel.mapel') }}" class="action-card">
        <div class="action-icon green"><i class="fas fa-book"></i></div>
        <div class="action-content">
            <h3>Mata Pelajaran</h3>
            <p>Kelola mata pelajaran</p>
        </div>
    </a>
    <a href="{{ route('datanilai.nilai') }}" class="action-card">
        <div class="action-icon purple"><i class="fas fa-chart-bar"></i></div>
        <div class="action-content">
            <h3>Laporan Nilai</h3>
            <p>Lihat statistik dan laporan</p>
        </div>
    </a>
</div>
</main>
</div>

<!-- Script untuk Chart.js dan Interaksi -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sidebar Toggle
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        mainContent.classList.toggle('shifted');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        mainContent.classList.remove('shifted');
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            mainContent.classList.remove('shifted');
        } else if (sidebar.classList.contains('active')) {
            mainContent.classList.add('shifted');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            mainContent.classList.remove('shifted');
        }
    });

    // Card Animation
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.stat-card, .action-card, .card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });

    // Charts
    @if (!empty($distribusiNilai) && array_sum($distribusiNilai) > 0)
        const distribusiNilai = @json($distribusiNilai);
        const nilaiChart = new Chart(document.getElementById('nilaiChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['A (85-100)', 'B (75-84)', 'C (65-74)', 'D (<65)'],
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: [
                        distribusiNilai['A'] || 0,
                        distribusiNilai['B'] || 0,
                        distribusiNilai['C'] || 0,
                        distribusiNilai['D'] || 0
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.7)', // Success (A)
                        'rgba(245, 158, 11, 0.7)', // Warning (B)
                        'rgba(59, 130, 246, 0.7)', // Info (C)
                        'rgba(239, 68, 68, 0.7)'  // Danger (D)
                    ],
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Siswa', font: { size: 12 } }
                    },
                    x: {
                        title: { display: true, text: 'Kategori Nilai', font: { size: 12 } }
                    }
                }
            }
        });
    @endif

    @if (!empty($statistikPredikat) && array_sum($statistikPredikat) > 0)
        const statistikPredikat = @json($statistikPredikat);
        const proporsiChart = new Chart(document.getElementById('proporsiChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['A (85-100)', 'B (75-84)', 'C (65-74)', 'D (<65)'],
                datasets: [{
                    label: 'Proporsi Siswa',
                    data: [
                        statistikPredikat['A'] || 0,
                        statistikPredikat['B'] || 0,
                        statistikPredikat['C'] || 0,
                        statistikPredikat['D'] || 0
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(239, 68, 68, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 12 } } },
                    tooltip: { enabled: true }
                }
            }
        });
    @endif
</script>
</body>
</html>