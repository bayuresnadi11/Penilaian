<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Murid;
use App\Models\Nilai;
use App\Models\Mata_Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardGuruController extends Controller
{
    public function index()
    {
        // Ambil data user yang login (asumsi guru login dengan username = NIP)
        $currentUser = Auth::user();
        $guru = Guru::with('mataPelajaran')->where('username_user', $currentUser->username)->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan.');
        }

        // Total murid yang diajar oleh guru ini (berdasarkan nilai yang diinput)
        $totalMurid = Nilai::where('nip', $guru->nip)
            ->distinct('nis') // Menggunakan 'nis' untuk menghitung murid unik
            ->count('nis');

        // Total mata pelajaran di sistem
        $totalMapel = Mata_Pelajaran::count();
        
        // Rata-rata nilai yang diinput oleh guru ini
        $rataRata = Nilai::where('nip', $guru->nip)->avg('nilai') ?? 0;
        
        // Nilai terendah yang diinput oleh guru ini
        $nilaiTerendah = Nilai::where('nip', $guru->nip)->min('nilai') ?? 0;
        
        // Data nilai terbaru yang diinput oleh guru ini (10 data terakhir)
        $nilaiTerbaru = Nilai::with(['guru', 'murid', 'mataPelajaran'])
            ->where('nip', $guru->nip)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Statistik predikat (A, B, C, D) yang diinput oleh guru ini
        $statistikPredikat = Nilai::where('nip', $guru->nip)
            ->select('predikat', DB::raw('count(*) as total'))
            ->groupBy('predikat')
            ->get()
            ->pluck('total', 'predikat')
            ->toArray();

        // Data untuk distribusi nilai (kategori A: 85-100, B: 75-84, C: 65-74, D: <65)
        $distribusiNilai = [
            'A' => Nilai::where('nip', $guru->nip)->whereBetween('nilai', [85, 100])->count(),
            'B' => Nilai::where('nip', $guru->nip)->whereBetween('nilai', [75, 84])->count(),
            'C' => Nilai::where('nip', $guru->nip)->whereBetween('nilai', [65, 74])->count(),
            'D' => Nilai::where('nip', $guru->nip)->where('nilai', '<', 65)->count(),
        ];

        // Mata pelajaran yang diajar guru
        $mataPelajaranGuru = $guru->mataPelajaran;
        
        // Nilai yang diinput oleh guru ini (opsional, jika diperlukan)
        $nilaiByGuru = Nilai::where('nip', $guru->nip)
            ->with(['murid', 'mataPelajaran'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Statistik nilai yang diinput guru ini
        $rataRataGuru = Nilai::where('nip', $guru->nip)->avg('nilai') ?? 0;
        $totalNilaiGuru = Nilai::where('nip', $guru->nip)->count();

        return view('dashboardguru', compact(
            'guru',
            'totalMurid',
            'totalMapel', 
            'rataRata',
            'nilaiTerendah',
            'nilaiTerbaru',
            'statistikPredikat',
            'distribusiNilai',
            'mataPelajaranGuru',
            'nilaiByGuru',
            'rataRataGuru',
            'totalNilaiGuru'
        ));
    }
}