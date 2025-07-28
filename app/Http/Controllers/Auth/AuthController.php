<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Murid;

class AuthController extends Controller 
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Proses login untuk admin, guru, atau murid berdasarkan:
     * - Username (User)
     * - NIP (Guru)
     * - NIS (Murid)
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // 1. Coba login via username (User model)
        $user = User::where('username', $login)->first();
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard.admin');
                case 'guru':
                    return redirect()->route('dashboard.guru');
                case 'murid':
                    return redirect()->route('dashboard.murid');
                default:
                    Auth::logout();
                    return back()->withErrors(['login' => 'Peran pengguna tidak dikenali.']);
            }
        }

        // 2. Coba login via NIP (Guru)
        $guru = Guru::where('nip', $login)->first();
        if ($guru && $guru->user && Hash::check($password, $guru->user->password)) {
            Auth::login($guru->user);
            return redirect()->route('dataguru.guru');
        }

        // 3. Coba login via NIS (Murid)
        $murid = Murid::where('nis', $login)->first();
        if ($murid && $murid->user && Hash::check($password, $murid->user->password)) {
            Auth::login($murid->user);
            return redirect()->route('datamurid.murid');
        }

        // 4. Jika semua gagal
        return back()->withErrors([
            'login' => 'Login gagal. Periksa kembali Username/NIP/NIS dan password Anda.',
        ]);
    }

    /**
     * Proses login untuk API (Flutter).
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Cek login via NIS (Murid)
        $murid = Murid::where('nis', $login)->first();
        if ($murid && $murid->user && Hash::check($password, $murid->user->password)) {
            $token = $murid->user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $murid->user,
                'murid' => $murid
            ], 200);
        }

        return response()->json([
            'message' => 'NIS atau password salah',
        ], 401);
    }

    /**
     * Ambil data nilai siswa untuk API.
     */
    public function apiGetNilai(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'murid') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $murid = Murid::where('username_user', $user->username)->first();
        if (!$murid) {
            return response()->json(['message' => 'Data murid tidak ditemukan'], 404);
        }

        $nilai = $murid->nilai()->get();
        return response()->json([
            'message' => 'Data nilai berhasil diambil',
            'data' => $nilai
        ], 200);
    }

    /**
     * Logout user yang sedang login.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}