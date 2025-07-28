<?php
namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Nilai;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardMuridController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data murid berdasarkan username yang login
        $murid = Murid::where('username_user', $user->username)->first();
        
        if (!$murid) {
            return redirect()->route('logout')->withErrors('Data murid tidak ditemukan');
        }

        // Ambil semua nilai murid dengan relasi mata pelajaran dan guru
        $nilaiData = Nilai::where('nis', $murid->nis)
            ->join('mata_pelajaran', 'nilai.kode', '=', 'mata_pelajaran.kode')
            ->join('guru', 'nilai.nip', '=', 'guru.nip')
            ->select(
                'nilai.*',
                'mata_pelajaran.mata_pelajaran',
                'guru.nama as nama_guru'
            )
            ->orderBy('mata_pelajaran.mata_pelajaran')
            ->get();

        // Hitung rata-rata nilai
        $avgGrade = $nilaiData->avg('nilai') ?? 0;

        // Data untuk grafik per mata pelajaran
        $chartLabels = $nilaiData->pluck('mata_pelajaran')->toArray();
        $chartData = $nilaiData->pluck('nilai')->toArray();
        $chartColors = $this->generateColors(count($chartLabels));

        // Statistik nilai berdasarkan predikat
        $predikatStats = $nilaiData->groupBy('predikat')->map(function ($group) {
            return $group->count();
        });

        // Mata pelajaran dengan nilai tertinggi dan terendah
        $nilaiTertinggi = $nilaiData->sortByDesc('nilai')->first();
        $nilaiTerendah = $nilaiData->sortBy('nilai')->first();

        // Hitung jumlah mata pelajaran
        $totalMapel = $nilaiData->count();

        // Aktivitas terkini (simulasi berdasarkan data nilai terbaru)
        $aktivitasTerkini = $this->generateRecentActivities($nilaiData);

        return view('dashboardmurid', [
            'murid' => $murid,
            'avgGrade' => $avgGrade,
            'nilaiData' => $nilaiData,
            'chartLabels' => json_encode($chartLabels),
            'chartData' => json_encode($chartData),
            'chartColors' => json_encode($chartColors),
            'predikatStats' => $predikatStats,
            'nilaiTertinggi' => $nilaiTertinggi,
            'nilaiTerendah' => $nilaiTerendah,
            'totalMapel' => $totalMapel,
            'aktivitasTerkini' => $aktivitasTerkini
        ]);
    }

    private function generateColors($count)
    {
        $colors = [
            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
            '#06B6D4', '#84CC16', '#F97316', '#EC4899', '#6366F1'
        ];
        
        $result = [];
        for ($i = 0; $i < $count; $i++) {
            $result[] = $colors[$i % count($colors)];
        }
        
        return $result;
    }

    private function generateRecentActivities($nilaiData)
    {
        $activities = [];
        
        if ($nilaiData->count() > 0) {
            // Simulasi aktivitas berdasarkan nilai terbaru
            $activities[] = [
                'icon' => 'bi-check-circle-fill',
                'color' => 'success',
                'title' => 'Nilai ' . $nilaiData->last()->mata_pelajaran . ' telah diperbarui',
                'description' => 'Nilai: ' . $nilaiData->last()->nilai . ' (Predikat ' . $nilaiData->last()->predikat . ')',
                'time' => '2 jam yang lalu'
            ];

            if ($nilaiData->where('nilai', '>=', 80)->count() > 0) {
                $nilaiTinggi = $nilaiData->where('nilai', '>=', 80)->first();
                $activities[] = [
                    'icon' => 'bi-star-fill',
                    'color' => 'primary',
                    'title' => 'Prestasi Bagus di ' . $nilaiTinggi->mata_pelajaran,
                    'description' => 'Selamat! Nilai kamu ' . $nilaiTinggi->nilai,
                    'time' => '1 hari yang lalu'
                ];
            }

            if ($nilaiData->where('nilai', '<', 70)->count() > 0) {
                $nilaiRendah = $nilaiData->where('nilai', '<', 70)->first();
                $activities[] = [
                    'icon' => 'bi-exclamation-triangle-fill',
                    'color' => 'warning',
                    'title' => 'Perlu Perbaikan di ' . $nilaiRendah->mata_pelajaran,
                    'description' => 'Nilai: ' . $nilaiRendah->nilai . ' - Ayo semangat belajar!',
                    'time' => '3 hari yang lalu'
                ];
            }
        }

        return $activities;
    }
}