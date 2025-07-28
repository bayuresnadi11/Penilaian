@extends('layouts.layout')

@section('content')
<!-- Dashboard Header -->
<div class="row d-flex justify-content-center">
    <div class="col-14">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="text-primary fw-bold mb-0">Data Nilai</h1>
                        <p class="text-muted mb-md-0">Kelola data Nilai dengan mudah dan efisien</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end">
                            <a href="{{ route('datanilai.create') }}" class="btn btn-primary d-flex align-items-center">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Tambah Nilai
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

<!-- Search, Filter, Export -->
<div class="row d-flex justify-content-end">
    <div class="col-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('datanilai.nilai') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">

                    <!-- Search: Cari nama mapel -->
                    <div class="input-group" style="max-width: 400px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="keyword" class="form-control border-start-0 ps-0"
                               placeholder="Cari nama mapel..." value="{{ request('keyword') }}">
                    </div>

                    <!-- Sort by Nilai -->
                    <select name="sort" class="form-select" style="max-width: 180px;">
                        <option value="">Urutkan Nilai</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Nilai Terendah</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Nilai Tertinggi</option>
                    </select>

                    <!-- Filter Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center"
                                type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel me-2"></i> Filter
                        </button>
                        <div class="dropdown-menu p-4" style="min-width: 300px;">
                            <!-- Predikat -->
                            <div class="mb-3">
                                <label for="predikat" class="form-label">Predikat</label>
                                <select name="predikat" id="predikat" class="form-select">
                                    <option value="">Semua</option>
                                    @foreach (['A', 'B', 'C', 'D', 'E'] as $p)
                                        <option value="{{ $p }}" {{ request('predikat') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Semester -->
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select name="semester" id="semester" class="form-select">
                                    <option value="">Semua</option>
                                    @for ($i = 1; $i <= 2; $i++)
                                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Export -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center"
                                type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-download me-2"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('nilai.export.pdf') }}" target="_blank">
                                    <i class="bi bi-file-earmark-pdf me-2"></i> Export to PDF
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Reset -->
                    <a href="{{ route('datanilai.nilai') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </a>

                    <!-- Tombol Cari -->
                    <button type="submit" class="btn btn-primary px-3">Cari</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Nilai -->
<div class="row d-flex justify-content-end">
    <div class="col-13">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>NIP</th>
                                <th>NIS</th>
                                <th>Kode Mapel</th>
                                <th>Nilai</th>
                                <th>Predikat</th>
                                <th>Semester</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-body-custom">
                            @foreach($nilai as $n)
                            <tr class="table-row-hover">
                                <td class="text-center fw-medium text-muted">
                                    {{ $loop->iteration + ($nilai->currentPage() - 1) * $nilai->perPage() }}
                                </td>
                                <td class="text-center"><span class="badge bg-light text-primary fw-normal px-2 py-1">{{ $n->id }}</span></td>
                                <td class="text-center"><span class="text-primary fw-medium">{{ $n->nip }}</span></td>
                                <td class="text-center"><span class="text-info fw-medium">{{ $n->nis }}</span></td>
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $n->kode }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge 
                                        @if($n->nilai >= 90) bg-success
                                        @elseif($n->nilai >= 80) bg-info  
                                        @elseif($n->nilai >= 70) bg-warning
                                        @else bg-danger
                                        @endif
                                        px-3 py-2 fs-6 fw-bold rounded-pill">
                                        {{ $n->nilai }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge px-3 py-2 fw-bold rounded-pill predikat-badge
                                        @if($n->predikat == 'A') predikat-a
                                        @elseif($n->predikat == 'B') predikat-b
                                        @elseif($n->predikat == 'C') predikat-c
                                        @else predikat-d
                                        @endif" style="min-width: 40px;">
                                        {{ $n->predikat }}
                                    </span>
                                </td>
                                <td class="text-center"><span class="text-secondary fw-medium">{{ $n->semester }}</span></td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('datanilai.edit', $n->id) }}" class="btn btn-outline-primary btn-sm rounded-circle action-btn-hover" title="Edit Data">
                                            <i class="bi bi-pencil-square fs-6"></i>
                                        </a>
                                        <form action="{{ route('datanilai.destroy', $n->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle action-btn-hover" title="Hapus Data">
                                                <i class="bi bi-trash3 fs-6"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                <div class="d-flex justify-content-center mt-4">
                    <div class="pagination pagination-rounded">
                        {{ $nilai->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styling -->
<style>
.table-body-custom tr {
    border-bottom: 1px solid #e9ecef;
    transition: all 0.2s ease;
}
.table-row-hover:hover {
    background-color: #f8f9ff !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,123,255,0.1);
}
.table-body-custom td {
    padding: 12px 8px;
    vertical-align: middle;
    border: none;
}
.action-btn-hover {
    transition: all 0.3s ease;
    border-width: 1.5px;
}
.action-btn-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.btn-outline-primary.action-btn-hover:hover {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}
.btn-outline-danger.action-btn-hover:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}
.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}
.bg-opacity-10 {
    background-color: rgba(13, 110, 253, 0.1) !important;
}
.predikat-badge {
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,0.2);
}
.predikat-a {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
}
.predikat-b {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}
.predikat-c {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}
.predikat-d {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
}
@media (max-width: 768px) {
    .table-body-custom td {
        padding: 8px 4px;
        font-size: 0.875rem;
    }
    .action-btn-hover {
        width: 30px !important;
        height: 30px !important;
    }
}
@keyframes subtle-bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}
.table-row-hover:hover .badge {
    animation: subtle-bounce 0.6s ease-in-out;
}
</style>
@endsection
