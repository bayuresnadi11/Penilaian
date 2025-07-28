@extends('layouts.layout')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    :root {
      --primary-blue: #1E40AF;
      --secondary-blue: #3B82F6;
      --light-blue: #DBEAFE;
      --accent-blue: #60A5FA;
      --success-green: #059669;
      --success-light: #D1FAE5;
      --warning-orange: #D97706;
      --warning-light: #FEF3C7;
      --info-cyan: #0891B2;
      --info-light: #CFFAFE;
      --danger-red: #DC2626;
      --gray-50: #F8FAFC;
      --gray-100: #F1F5F9;
      --gray-200: #E2E8F0;
      --gray-300: #CBD5E1;
      --gray-400: #94A3B8;
      --gray-500: #64748B;
      --gray-600: #475569;
      --gray-700: #334155;
      --gray-800: #1E293B;
      --gray-900: #0F172A;
      --white: #FFFFFF;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 1;
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        z-index: 1;
    }

    .dashboard-header .content {
        position: relative;
        z-index: 2;
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .dashboard-header p {
        opacity: 0.9;
        font-size: 1.1rem;
        margin: 0;
    }

    .user-dropdown {
        position: relative;
        z-index: 2;
    }

    .user-dropdown .btn {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 0.75rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .user-dropdown .btn:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.4);
        color: white;
        transform: translateY(-1px);
    }

    .user-dropdown .dropdown-menu {
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        border-radius: 12px;
        padding: 0.5rem;
        margin-top: 0.5rem;
    }

    .user-dropdown .dropdown-item {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }

    .user-dropdown .dropdown-item:hover {
        background: var(--gray-100);
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--gray-100);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-color);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-card.primary::before { background: linear-gradient(90deg, var(--primary-blue), var(--accent-blue)); }
    .stat-card.success::before { background: linear-gradient(90deg, var(--success-green), #10B981); }
    .stat-card.info::before { background: linear-gradient(90deg, var(--info-cyan), #06B6D4); }
    .stat-card.warning::before { background: linear-gradient(90deg, var(--warning-orange), #F59E0B); }

    .stat-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover .icon-circle {
        transform: scale(1.05);
    }

    .icon-circle.primary { background: var(--light-blue); }
    .icon-circle.success { background: var(--success-light); }
    .icon-circle.info { background: var(--info-light); }
    .icon-circle.warning { background: var(--warning-light); }

    .icon-circle i {
        font-size: 1.5rem;
    }

    .icon-circle.primary i { color: var(--primary-blue); }
    .icon-circle.success i { color: var(--success-green); }
    .icon-circle.info i { color: var(--info-cyan); }
    .icon-circle.warning i { color: var(--warning-orange); }

    .stat-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-700);
        margin: 0;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
    }

    .stat-subtitle {
        color: var(--gray-500);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .stat-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-modern {
        border-radius: 10px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-modern.primary {
        background: var(--primary-blue);
        color: white;
    }

    .btn-modern.primary:hover {
        background: var(--secondary-blue);
        color: white;
    }

    .btn-modern.primary-outline {
        background: transparent;
        color: var(--primary-blue);
        border: 2px solid var(--primary-blue);
    }

    .btn-modern.primary-outline:hover {
        background: var(--primary-blue);
        color: white;
    }

    .btn-modern.success {
        background: var(--success-green);
        color: white;
    }

    .btn-modern.success-outline {
        background: transparent;
        color: var(--success-green);
        border: 2px solid var(--success-green);
    }

    .btn-modern.success-outline:hover {
        background: var(--success-green);
        color: white;
    }

    .btn-modern.info {
        background: var(--info-cyan);
        color: white;
    }

    .btn-modern.info-outline {
        background: transparent;
        color: var(--info-cyan);
        border: 2px solid var(--info-cyan);
    }

    .btn-modern.info-outline:hover {
        background: var(--info-cyan);
        color: white;
    }

    .btn-modern.warning {
        background: var(--warning-orange);
        color: white;
    }

    .btn-modern.warning-outline {
        background: transparent;
        color: var(--warning-orange);
        border: 2px solid var(--warning-orange);
    }

    .btn-modern.warning-outline:hover {
        background: var(--warning-orange);
        color: white;
    }

    /* Activity Table */
    .activity-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--gray-100);
        overflow: hidden;
    }

    .activity-header {
        background: var(--gray-50);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .activity-header h5 {
        margin: 0;
        font-weight: 600;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .activity-body {
        padding: 0;
    }

    .modern-table {
        margin: 0;
    }

    .modern-table thead th {
        background: transparent;
        border: none;
        padding: 1.5rem 2rem 1rem;
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .modern-table tbody td {
        border: none;
        padding: 1rem 2rem;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .modern-table tbody tr:hover {
        background: var(--gray-50);
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 0.875rem;
    }

    .activity-login {
        background: var(--success-light);
        color: var(--success-green);
    }

    .activity-create {
        background: var(--light-blue);
        color: var(--primary-blue);
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary-blue);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
        margin-right: 0.75rem;
    }

    .date-badge {
        background: var(--gray-100);
        color: var(--gray-600);
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-header h1 {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .stat-actions {
            flex-direction: column;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 1rem;
        }
    }

    /* Loading Animation */
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.6s ease forwards;
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }

    .slide-up {
        transform: translateY(20px);
        opacity: 0;
        animation: slideUp 0.6s ease forwards;
    }

    @keyframes slideUp {
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="fw-bold mb-1">Dashboard Admin</h2>
                <p class="text-muted mb-0">Selamat datang di Sistem Manajemen Sekolah SIPENA</p>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i>
                    {{ Auth::user()->name ?? 'Admin' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3">
        @php
            $cards = [
                ['title' => 'Data Murid', 'icon' => 'user-graduate', 'color' => 'primary', 'count' => $muridCount, 'route' => 'datamurid.murid', 'create' => 'datamurid.create'],
                ['title' => 'Data Guru', 'icon' => 'chalkboard-teacher', 'color' => 'success', 'count' => $guruCount, 'route' => 'dataguru.guru', 'create' => 'dataguru.create'],
                ['title' => 'Data User', 'icon' => 'users', 'color' => 'info', 'count' => $userCount, 'route' => 'datauser.user', 'create' => 'datauser.create'],
                ['title' => 'Mata Pelajaran', 'icon' => 'book', 'color' => 'warning', 'count' => $mapelCount, 'route' => 'datamapel.mapel', 'create' => 'datamapel.create'],
            ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-start border-4 border-{{ $card['color'] }}">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="text-{{ $card['color'] }} me-2">
                            <i class="fas fa-{{ $card['icon'] }} fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-0">{{ $card['title'] }}</h6>
                            <small class="text-muted">Total: {{ $card['count'] }}</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route($card['route']) }}" class="btn btn-sm btn-outline-{{ $card['color'] }}">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                        <a href="{{ route($card['create']) }}" class="btn btn-sm btn-{{ $card['color'] }}">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Chart Section -->
    <div class="card mt-4">
        <div class="card-body">
            <h6 class="card-title"><i class="fas fa-chart-bar me-2 text-primary"></i> Statistik Data</h6>
            <div style="height: 300px;">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Activity Section -->
    <div class="card mt-4">
        <div class="card-body">
            <h6 class="card-title"><i class="fas fa-history me-2 text-primary"></i> Aktivitas Terbaru</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Aktivitas</th>
                            <th>Pengguna</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fas fa-sign-in-alt text-success me-2"></i> Login Sistem</td>
                            <td><span class="badge bg-secondary">Admin</span></td>
                            <td>12 Mei 2025</td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-user-plus text-info me-2"></i> Tambah Data Murid</td>
                            <td><span class="badge bg-secondary">Admin</span></td>
                            <td>11 Mei 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart Script -->
<script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Murid', 'Guru', 'User', 'Mata Pelajaran'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $muridCount }}, {{ $guruCount }}, {{ $userCount }}, {{ $mapelCount }}],
                backgroundColor: [
                    'rgba(13, 110, 253, 0.7)',
                    'rgba(25, 135, 84, 0.7)',
                    'rgba(13, 202, 240, 0.7)',
                    'rgba(255, 193, 7, 0.7)'
                ],
                borderColor: [
                    'rgba(13, 110, 253, 1)',
                    'rgba(25, 135, 84, 1)',
                    'rgba(13, 202, 240, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>


    <!-- Activity Section -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.btn-modern').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add ripple animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection