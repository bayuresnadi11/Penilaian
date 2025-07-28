<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Guru;
use App\Models\User;
use App\Models\Mata_Pelajaran;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Ambil jumlah data dari database
        $muridCount = Murid::count();
        $guruCount = Guru::count();
        $userCount = User::count();
        $mapelCount = Mata_Pelajaran::count();

        // Kirim data ke view
        return view('dashboard', compact(
            'muridCount',
            'guruCount',
            'userCount',
            'mapelCount'
        ));
    }
}
