<?php

namespace App\Http\Controllers;

use App\Models\Mata_Pelajaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MapelDashboardController extends Controller
{
    /**
     * Menampilkan daftar mata pelajaran dengan paginasi dan pencarian.
     */
 public function index(Request $request)
{
    $keyword = $request->keyword;
    $sort = $request->sort;

    $mapel = Mata_Pelajaran::when($keyword, function ($query) use ($keyword) {
            $query->where('kode', 'like', "%$keyword%")
                  ->orWhere('mata_pelajaran', 'like', "%$keyword%");
        })
        ->when($sort, function ($query) use ($sort) {
            $query->orderBy('mata_pelajaran', $sort);
        }, function ($query) {
            // Default sorting jika tidak ada sort, bisa disesuaikan
            $query->orderByRaw("FIELD(kode, 'MTK', 'BIN', 'BIG', 'PWEB', 'BADA', 'PAI', 'PKN')");
        })
        ->paginate(5)
        ->appends(['sort' => $sort, 'keyword' => $keyword]); // Agar pagination mempertahankan query

    return view('datamapel.mapel', compact('mapel'));
}


    // (Metode create, store, edit, update, destroy, exportPdf tetap sama seperti sebelumnya)
    public function create()
    {
        return view('datamapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:mata_pelajaran,kode|max:10',
            'mata_pelajaran' => 'required|string|max:255',
        ], [], [
            'kode' => 'Kode Mapel',
            'mata_pelajaran' => 'Nama Mapel',
        ]);

        Mata_Pelajaran::create([
            'kode' => $request->kode,
            'mata_pelajaran' => $request->mata_pelajaran,
        ]);

        return redirect()->route('datamapel.mapel')->with([
            'success' => 'Data mapel berhasil ditambahkan.',
            'type' => 'store'
        ]);
    }

    public function edit($kode)
    {
        $mapel = Mata_Pelajaran::where('kode', $kode)->firstOrFail();
        return view('datamapel.edit', compact('mapel'));
    }

    public function update(Request $request, $kode)
    {
        $request->validate([
            'kode' => 'required|max:10|unique:mata_pelajaran,kode,' . $kode . ',kode',
            'mata_pelajaran' => 'required|string|max:255',
        ], [], [
            'kode' => 'Kode Mapel',
            'mata_pelajaran' => 'Nama Mapel',
        ]);

        $mapel = Mata_Pelajaran::where('kode', $kode)->firstOrFail();

        $mapel->update([
            'kode' => $request->kode,
            'mata_pelajaran' => $request->mata_pelajaran,
        ]);

        return redirect()->route('datamapel.mapel')->with([
            'success' => 'Data mapel berhasil diperbarui.',
            'type' => 'update'
        ]);
    }

    public function destroy($kode)
    {
        $mapel = Mata_Pelajaran::where('kode', $kode)->firstOrFail();
        $mapel->delete();

        return redirect()->route('datamapel.mapel')->with([
            'success' => 'Data mapel berhasil dihapus.',
            'type' => 'delete'
        ]); {
            $mapel = Mata_Pelajaran::where('kode', $kode)->firstOrFail();

            // Hapus data nilai terkait
            $mapel->nilai()->delete();

            // Hapus data guru terkait
            $mapel->guru()->delete();

            // Hapus data mata pelajaran
            $mapel->delete();

            return redirect()->route('datamapel.mapel')->with([
                'success' => 'Data mapel dan data terkait berhasil dihapus.',
                'type' => 'delete'
            ]);
        }
    }

    public function exportPdf()
    {
        $mapel = Mata_Pelajaran::all();

        $pdf = Pdf::loadView('datamapel.export_pdf', compact('mapel'))->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-mapel.pdf');
    }
}
