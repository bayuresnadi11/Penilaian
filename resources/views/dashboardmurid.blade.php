<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Murid - SIPENA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        :root {
            --primary: #3B82F6;
            --primary-dark: #2563EB;
            --secondary: #8B5CF6;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --info: #06B6D4;
            --light: #F8FAFC;
            --dark: #1E293B;
            --gray-100: #F1F5F9;
            --gray-200: #E2E8F0;
            --gray-300: #CBD5E1;
            --gray-500: #64748B;
            --gray-700: #334155;
            --gray-800: #1E293B;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--light) 0%, #ffffff 100%);
            min-height: 100vh;
            color: var(--gray-700);
            padding-bottom: 100px;
        }

        .header-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 2rem 0 3rem;
            position: relative;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-text h2 {
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .welcome-text p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin: 0;
        }

        .main-content {
            padding: 2rem 1rem;
            margin-top: -2rem;
            position: relative;
            z-index: 3;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: var(--primary);
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .nilai-card {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .nilai-card:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .nilai-badge {
            font-size: 1.1rem;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }

        .predikat-A { background: var(--success); color: white; }
        .predikat-B { background: var(--info); color: white; }
        .predikat-C { background: var(--warning); color: white; }
        .predikat-D { background: var(--warning); color: white; }
        .predikat-E { background: var(--danger); color: white; }

        .activity-item {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            background: white;
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .activity-icon.success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .activity-icon.primary { background: rgba(59, 130, 246, 0.1); color: var(--primary); }
        .activity-icon.warning { background: rgba(245, 158, 11, 0.1); color: var(--warning); }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid var(--gray-200);
            padding: 0.75rem 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
            z-index: 1000;
        }

        .nav-link {
            color: var(--gray-500);
            text-align: center;
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary);
            background: rgba(59, 130, 246, 0.1);
        }

        .nav-link i {
            font-size: 1.2rem;
            display: block;
            margin-bottom: 0.25rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin: 1rem 0;
        }

        .grade-summary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .grade-summary h4 {
            margin-bottom: 1rem;
        }

        .summary-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
        }

        .summary-item h5 {
            font-size: 1.5rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-8">
                    <div class="welcome-text">
                        <h2>Hai, {{ $murid->nama }}! 👋</h2>
                        <p>NIS: {{ $murid->nis }} | Kelas: {{ $murid->kelas }}</p>
                        <p>{{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                </div>
                <div class="col-4 text-end">
                    <a href="{{ route('logout') }}" class="logout-btn"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3">
                <div class="col-4">
                    <div class="stat-card">
                        <h3>{{ number_format($avgGrade, 1) }}</h3>
                        <p>Rata-rata</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-card">
                        <h3>{{ $totalMapel }}</h3>
                        <p>Mata Pelajaran</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-card">
                        <h3>{{ $nilaiTertinggi ? $nilaiTertinggi->nilai : '-' }}</h3>
                        <p>Nilai Tertinggi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content container">
        <!-- Grade Summary -->
        @if($nilaiTertinggi && $nilaiTerendah)
        <div class="grade-summary">
            <h4><i class="bi bi-trophy"></i> Ringkasan Prestasi</h4>
            <div class="row g-3">
                <div class="col-6">
                    <div class="summary-item">
                        <h5>{{ $nilaiTertinggi->nilai }}</h5>
                        <p>{{ $nilaiTertinggi->mata_pelajaran }}</p>
                        <small>Nilai Terbaik</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="summary-item">
                        <h5>{{ $nilaiTerendah->nilai }}</h5>
                        <p>{{ $nilaiTerendah->mata_pelajaran }}</p>
                        <small>Perlu Ditingkatkan</small>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Chart Section -->
        <div class="section-title">
            <i class="bi bi-bar-chart-fill"></i> Grafik Nilai per Mata Pelajaran
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="grafikNilai"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Grades -->
        <div class="section-title">
            <i class="bi bi-list-check"></i> Detail Nilai Mata Pelajaran
        </div>
        <div class="mb-4">
            @foreach($nilaiData as $nilai)
            <div class="nilai-card">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h6 class="mb-1">{{ $nilai->mata_pelajaran }}</h6>
                        <small class="text-muted">{{ $nilai->nama_guru }}</small>
                    </div>
                    <div class="col-3 text-center">
                        <div class="nilai-badge predikat-{{ $nilai->predikat }}">
                            {{ $nilai->nilai }}
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <span class="badge bg-primary">{{ $nilai->predikat }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Recent Activities -->
        <div class="section-title">
            <i class="bi bi-clock-history"></i> Aktivitas Terkini
        </div>
        <div class="mb-4">
            @foreach($aktivitasTerkini as $activity)
            <div class="activity-item">
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="activity-icon {{ $activity['color'] }}">
                            <i class="{{ $activity['icon'] }}"></i>
                        </div>
                    </div>
                    <div class="col-10">
                        <h6 class="mb-1">{{ $activity['title'] }}</h6>
                        <p class="mb-1 small text-muted">{{ $activity['description'] }}</p>
                        <small class="text-muted">{{ $activity['time'] }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Statistics -->
        @if($predikatStats->count() > 0)
        <div class="section-title">
            <i class="bi bi-pie-chart"></i> Statistik Predikat
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    @foreach($predikatStats as $predikat => $count)
                    <div class="col-6">
                        <div class="text-center p-3 border rounded">
                            <h4 class="mb-1">{{ $count }}</h4>
                            <p class="mb-0">Predikat {{ $predikat }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <a href="{{ route('dashboard.murid') }}" class="nav-link active">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
                    </a>
                </div>
                
                <div class="col">
                    <a href="{{ route('profile') }}" class="nav-link">
                        <i class="bi bi-person"></i>
                        <span>Profil</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart Configuration
        const ctx = document.getElementById('grafikNilai').getContext('2d');
        const chartLabels = {!! $chartLabels !!};
        const chartData = {!! $chartData !!};
        const chartColors = {!! $chartColors !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Nilai',
                    data: chartData,
                    backgroundColor: chartColors.map(color => color + '40'),
                    borderColor: chartColors,
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 10
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                elements: {
                    bar: {
                        borderRadius: 8
                    }
                }
            }
        });

        // Add click animation to cards
        document.querySelectorAll('.nilai-card, .activity-item, .stat-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    </script>
</body>
</html>