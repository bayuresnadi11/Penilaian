@extends('layouts.layout')

@section('content')
    <!-- Dashboard Header -->
    <div class="row d-flex justify-content-end">
        <div class="col-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="text-primary fw-bold mb-0">Data Mapel</h1>
                            <p class="text-muted mb-md-0">Kelola data Mapel dengan mudah dan efisien</p>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-md-end">
                                <a href="{{ route('datamapel.create') }}" class="btn btn-primary d-flex align-items-center">
                                    <i class="bi bi-person-plus-fill me-2"></i>
                                    Tambah Mapel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if (session('success'))
        <div class="row justify-content-end">
            <div class="col-9">
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="row d-flex justify-content-end">
        <div class="col-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('datamapel.mapel') }}" method="GET" class="d-flex gap-2 flex-wrap">
                        <div class="input-group" style="max-width: 550px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="keyword" class="form-control border-start-0 ps-0"
                                placeholder="Cari ID atau mapel..." value="{{ request('keyword') }}">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">Cari</button>

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center"
                                type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-download me-2"></i> Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('datamapel.export.pdf') }}" target="_blank">
                                        <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-auto">
                            <select name="sort" class="form-select">
                                <option value="">Urutkan Nama</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
                            </select>
                        </div>
                         <div class="col-md-auto">
                        <a href="{{ route('datamapel.mapel') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Murid -->
    <div class="row d-flex justify-content-end">
        <div class="col-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Mata Pelajaran</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mapel as $index => $m)
                                    <tr>
                                        <td>{{ $m->kode }}</td>
                                        <td>
                                            <span
                                                class="badge bg-light text-primary fw-semibold px-3 py-2">{{ $m->mata_pelajaran }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('datamapel.edit', $m->kode) }}"
                                                class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('datamapel.destroy', $m->kode) }}" method="POST"
                                                class="d-inline" id="delete-form-{{ $m->kode }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete('{{ $m->kode }}')" title="Hapus">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                            <strong>Belum ada data mata pelajaran</strong><br>
                                            Tambahkan data mapel terlebih dahulu
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $mapel->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Konfirmasi Hapus --}}
    <script>
        function confirmDelete(kode) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                // Submit form hapus berdasarkan kode unik
                document.getElementById('delete-form-' + kode).submit();
            }
        }
    </script>
