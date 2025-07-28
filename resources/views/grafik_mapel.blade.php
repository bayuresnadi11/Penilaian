@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Grafik Jumlah Data Nilai per Kode Mata Pelajaran</h4>
    <canvas id="chartMapel" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartMapel');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($data->pluck('kode_mapel')) !!},
            datasets: [{
                label: 'Jumlah Data Nilai',
                data: {!! json_encode($data->pluck('jumlah')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection
