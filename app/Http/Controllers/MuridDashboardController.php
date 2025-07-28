<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class MuridDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Murid::query();

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->keyword . '%')
                  ->orWhere('nis', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $query->when($request->filled('sort'), function ($q) use ($request) {
            $q->orderBy('nama', $request->sort);
        }, function ($q) {
            $q->oldest();
        });

        $murid = $query->paginate(5)->appends($request->query());

        return view('DataMurid.murid', compact('murid'));
    }

    public function create()
    {
        return view('DataMurid.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nis' => 'required|digits:4|unique:murid,nis',
        'kelas' => 'required|string|max:50',
        'telepon' => 'nullable|string|max:20',
        'jenis_kelamin' => 'required|in:L,P',
        'tanggal_lahir' => 'required|date',
        'username_user' => 'required|string|unique:users,username',
    ], [
        'nis.required' => 'Kolom NIS wajib diisi.',
        'nis.digits' => 'Kolom NIS harus terdiri dari 4 angka.',
        'nis.unique' => 'NIS ini sudah terdaftar.',
        'username_user.unique' => 'Username sudah digunakan.',
    ]);

    // Buat akun user dengan password default (contoh: 'password123')
    $user = User::create([
        'username' => $request->username_user,
        'password' => Hash::make('password123'), // password default
        'role' => 'murid',
    ]);

    // Tambahkan murid dan hubungkan dengan username
    Murid::create([
        'nama' => $request->nama,
        'nis' => $request->nis,
        'kelas' => $request->kelas,
        'telepon' => $request->telepon,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tanggal_lahir' => $request->tanggal_lahir,
        'username_user' => $user->username,
    ]);

    $lastPage = ceil(Murid::count() / 10);

    return redirect()->route('datamurid.murid', ['page' => $lastPage])
                     ->with('success', 'Data murid berhasil ditambahkan. Password default: password123');
}


    public function edit($nis)
{
    $murid = Murid::where('nis', $nis)->firstOrFail();
    $users = User::all(); // Ambil semua user untuk dropdown

    return view('datamurid.edit', compact('murid', 'users'));
}

    public function update(Request $request, $nis)
    {
     $murid = Murid::where('nis', $nis)->firstOrFail();


        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|digits:4|unique:murid,nis,' . $nis . ',nis',
            'kelas' => 'required|string|max:50',
            'telepon' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'username_user' => 'required|exists:users,username',
        ]);

        $murid->update([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'telepon' => $request->telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'username_user' => $request->username_user,
        ]);

        return redirect()->route('datamurid.murid')->with('success', 'Data murid berhasil diperbarui.');
    }

    public function destroy($nis)
    {
       $murid = Murid::where('nis', $nis)->firstOrFail();

        $murid->delete();

        return redirect()->route('datamurid.murid')->with('success', 'Data murid berhasil dihapus.');
    }

    public function exportPdf()
    {
        $murid = Murid::all();

        $pdf = Pdf::loadView('DataMurid.export_pdf', compact('murid'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download('data_murid.pdf');
    }
}
