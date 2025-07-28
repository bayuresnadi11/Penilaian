<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UserDashboardController extends Controller
{
    /**
     * Tampilkan semua pengguna dengan pencarian dan filter role
     */
    public function index(Request $request)
    {
          $query = User::query();

    // Filter pencarian
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function ($q) use ($keyword) {
            $q->where('username', 'like', '%' . $keyword . '%')
              ->orWhere('role', 'like', '%' . $keyword . '%');
        });
    }

    // Filter role
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    // Sorting username numerik (jika hanya angka)
    if ($request->filled('sort_username_numeric')) {
        $sort = $request->sort_username_numeric;

        // Sorting hanya untuk username yang terdiri dari angka
        $query->whereRaw('username REGEXP "^[0-9]+$"')
              ->orderByRaw("CAST(username AS UNSIGNED) $sort");
    } else {
        $query->orderBy('username', 'asc'); // default sorting A-Z
    }

    $users = $query->paginate(5)->appends($request->query());

    return view('datauser.user', compact('users'));
    }

    /**
     * Tampilkan form tambah pengguna
     */
    public function create()
    {
        return view('datauser.create');
    }

    /**
     * Simpan pengguna baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,guru,murid',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('datauser.user')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit pengguna
     */
    public function edit($username)
    {
        $user = User::findOrFail($username);
        return view('DataUser.edit', compact('user'));
    }

    /**
     * Update data pengguna
     */
    public function update(Request $request, $username)
    {
        $user = User::findOrFail($username);

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->username,
            'role' => 'required|in:admin,guru,murid',
            'password' => 'nullable|min:6',
        ]);

        $user->username = $request->username;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('datauser.user')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Hapus pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('datauser.user')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Export data pengguna ke PDF
     */
    public function exportPDF(Request $request)
    {
        $query = User::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('username', 'like', '%' . $keyword . '%')
                  ->orWhere('role', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        $pdf = Pdf::loadView('datauser.export_pdf', compact('users'));
        return $pdf->download('data_user.pdf');
    }
}
