<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Mata_Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GuruDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Debug SQL query
        DB::listen(function ($query) {
            Log::info('SQL: ' . $query->sql);
            Log::info('Bindings: ', $query->bindings);
        });

        // Ambil input
        $keyword = $request->input('keyword', '');
        $mapel = $request->input('mapel', '');
        $gender = $request->input('gender', '');
        $sort = $request->input('sort', '');

        // Sanitasi keyword
        if (is_array($keyword)) {
            $keyword = implode(' ', array_filter($keyword, 'is_string'));
        }
        $keyword = trim($keyword);

        // Query builder
        $guru = Guru::with(['user', 'mataPelajaran'])
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nama', 'like', '%' . $keyword . '%')
                        ->orWhere('nip', 'like', '%' . $keyword . '%');
                });
            })
            ->when($mapel !== '', function ($query) use ($mapel) {
                $query->whereHas('mataPelajaran', function ($q) use ($mapel) {
                    $q->where('kode', $mapel);
                });
            })
            ->when($gender !== '', function ($query) use ($gender) {
                $query->where('jenis_kelamin', $gender);
            })
            ->when(in_array($sort, ['asc', 'desc']), function ($query) use ($sort) {
                $query->orderBy('nama', $sort);
            })
            ->paginate(5);

        $mataPelajaran = Mata_Pelajaran::all();
        $listGender = ['L' => 'Laki-laki', 'P' => 'Perempuan'];

        return view('dataguru.guru', compact('guru', 'mataPelajaran', 'listGender'));
    }

    public function create()
    {
        $users = User::all();
        $mataPelajaran = Mata_Pelajaran::all();
        return view('dataguru.create', compact('users', 'mataPelajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => ['required', 'digits:18', 'unique:guru,nip'],
            'email' => 'required|email|unique:guru,email',
            'no_telp' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'required|date',
            'username_user' => 'required|string|unique:users,username',
            'kode_mapel' => 'required|exists:mata_pelajaran,kode',
        ]);

        $user = User::create([
            'username' => $request->username_user,
            'password' => Hash::make($request->username_user),
            'role' => 'guru',
        ]);

        Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir' => $request->tgl_lahir,
            'username_user' => $user->username,
            'kode_mapel' => $request->kode_mapel,
        ]);
        $perPage = 5; // Sesuaikan dengan paginate di index()
        $totalGuru = Guru::count();
        $lastPage = ceil($totalGuru / $perPage);

        // Redirect ke halaman terakhir
        return redirect()->route('dataguru.guru', ['page' => $lastPage])
            ->with('success', 'Data guru dan user berhasil ditambahkan.');
    }

    public function edit($nip)
    {
        // Ambil data guru berdasarkan NIP
        $guru = Guru::where('nip', $nip)->firstOrFail();

        // Ambil data pengguna dan mata pelajaran
        $users = User::all();
        $mataPelajaran = Mata_Pelajaran::all();

        // Tampilkan halaman edit dengan data guru yang ditemukan
        return view('dataguru.edit', compact('guru', 'users', 'mataPelajaran'));
    }

    // Method untuk update data guru
    public function update(Request $request, $nip)
    {
        // Ambil data guru berdasarkan NIP terlebih dahulu
        $guru = Guru::where('nip', $nip)->firstOrFail();

        // Validasi input dari form
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'digits:18', Rule::unique('guru', 'nip')->ignore($guru->nip, 'nip')], // Ignore NIP yang sedang diedit
            'email' => ['required', 'email', Rule::unique('guru', 'email')->ignore($guru->nip, 'nip')], // Ignore email berdasarkan nip yang sedang diedit
            'no_telp' => ['required', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tgl_lahir' => ['required', 'date'],
            'username_user' => ['required', 'exists:users,username'],
            'kode_mapel' => ['required', 'exists:mata_pelajaran,kode'],
        ]);

        // Update data guru dengan input baru
        $guru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir' => $request->tgl_lahir,
            'username_user' => $request->username_user,
            'kode_mapel' => $request->kode_mapel,
        ]);

        // Redirect ke halaman daftar guru dengan pesan sukses
        return redirect()->route('dataguru.guru')->with('success', 'Data guru berhasil diperbarui.');
    }


    public function destroy($nip)
    {
        $guru = Guru::where('nip', $nip)->firstOrFail();
        $guru->delete();
        return redirect()->route('dataguru.guru')->with('success', 'Data guru berhasil dihapus.');
    }

    public function exportPdf()
    {
        $guru = Guru::with(['user', 'mataPelajaran'])->get();
        $pdf = Pdf::loadView('dataguru.export_pdf', compact('guru'))->setPaper('a4', 'portrait');
        return $pdf->download('laporan-data-guru.pdf');
    }
}
