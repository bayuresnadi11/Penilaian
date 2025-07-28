<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Guru;
use App\Models\Murid;
use App\Models\Mata_Pelajaran;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiDashboardController extends Controller
{
    // Tampilkan daftar nilai
    public function index(Request $request)
    {
        $keyword   = $request->keyword;
        $idMapel   = $request->id_mata_pelajaran;
        $predikat  = $request->predikat;
        $semester  = $request->semester;
        $sort      = $request->sort;

        $nilai = Nilai::with(['guru', 'murid', 'mapel'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('mapel', function ($q) use ($keyword) {
                    $q->where('mata_pelajaran', 'like', '%' . $keyword . '%');
                });
            })
            ->when($idMapel, fn($q) => $q->where('id_mata_pelajaran', $idMapel))
            ->when($predikat, fn($q) => $q->where('predikat', $predikat))
            ->when($semester, fn($q) => $q->where('semester', $semester))
            ->when(in_array($sort, ['asc', 'desc']), fn($q) => $q->orderBy('nilai', $sort))
            ->paginate(5);

        $nilai->appends($request->query());

        $mapel = Mata_Pelajaran::all();

        return view('datanilai.nilai', compact('nilai', 'mapel'));
    }

    // Form tambah data nilai
    public function create()
    {
        $guru  = Guru::all();
        $murid = Murid::all();
        $mapel = Mata_Pelajaran::all();

        return view('datanilai.create', compact('guru', 'murid', 'mapel'));
    }

    // Simpan data nilai baru
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:nilai,id',
            'nip' => 'required|exists:guru,nip',
            'nis' => 'required|exists:murid,nis',
            'kode' => 'required|exists:mata_pelajaran,kode',
            'nilai' => 'required|numeric|min:0|max:100',
            'predikat' => 'required|string|in:A,B,C,D,E',
            'semester' => 'required|in:1,2',
        ]);

        $guru  = Guru::where('nip', $request->nip)->first();
        $murid = Murid::where('nis', $request->nis)->first();
        $mapel = Mata_Pelajaran::where('kode', $request->kode)->first();

        Nilai::create([
            'id' => $request->id,
            'nip' => $guru->nip,
            'nis' => $murid->nis,
            'kode' => $mapel->kode,
            'nilai' => $request->nilai,
            'predikat' => $request->predikat,
            'semester' => $request->semester,
        ]);

        return redirect()->route('datanilai.nilai')->with('success', 'Data nilai berhasil ditambahkan.');
    }

    // Form edit data nilai
    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $guru  = Guru::all();
        $murid = Murid::all();
        $mataPelajaran = Mata_Pelajaran::all();  // variabel ini harus sesuai dengan di view

        return view('datanilai.edit', compact('nilai', 'guru', 'murid', 'mataPelajaran'));
    }

    // Update data nilai
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|exists:guru,nip',
            'nis' => 'required|exists:murid,nis',
            'kode' => 'required|exists:mata_pelajaran,kode',
            'nilai' => 'required|numeric|min:0|max:100',
            'predikat' => 'required|string|in:A,B,C,D,E',
            'semester' => 'required|in:1,2',
        ]);

        $guru  = Guru::where('nip', $request->nip)->first();
        $murid = Murid::where('nis', $request->nis)->first();
        $mapel = Mata_Pelajaran::where('kode', $request->kode)->first();

        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'nip' => $guru->nip,
            'nis' => $murid->nis,
            'kode' => $mapel->kode, // <== ini penting!
            'nilai' => $request->nilai,
            'predikat' => $request->predikat,
            'semester' => $request->semester,
        ]);


        return redirect()->route('datanilai.nilai')->with('success', 'Data nilai berhasil diperbarui.');
    }

    // Hapus data nilai
    public function destroy($id)
    {
        Nilai::destroy($id);
        return redirect()->route('datanilai.nilai')->with('success', 'Nilai berhasil dihapus.');
    }

    // Export PDF
    public function exportPdf()
    {
        $nilai = Nilai::with(['guru', 'murid', 'mapel'])->get();
        $pdf = Pdf::loadView('datanilai.export_pdf', compact('nilai'))->setPaper('a4', 'landscape');
        return $pdf->download('data_nilai.pdf');
    }
}
