@extends('layouts.layout')

@section('content')
    <!-- Dashboard Header -->
    <div class="row d-flex justify-content-end">
        <div class="col-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="text-primary fw-bold mb-0">Data Murid</h1>
                            <p class="text-muted mb-md-0">Kelola data Murid dengan mudah dan efisien</p>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-md-end">
                                <a href="{{ route('datamurid.create') }}" class="btn btn-primary d-flex align-items-center">
                                    <i class="bi bi-person-plus-fill me-2"></i>
                                    Tambah Murid
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

    <!--<!-- Search & Filter -->
<div class="row d-flex justify-content-end">
    <div class="col-9">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('datamurid.murid') }}" method="PUT" class="row g-2 align-items-center">

                    <!-- Keyword Pencarian -->
                    <div class="col-md-auto flex-grow-1">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="keyword" class="form-control border-start-0 ps-0"
                                   placeholder="Cari nama atau NIS..." value="{{ request('keyword') }}">
                        </div>
                    </div>
                    

                    <!-- Filter Kelas -->
                    <div class="col-md-auto">
                        <select name="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            <option value="XI RPL 1" {{ request('kelas') == 'XI RPL 1' ? 'selected' : '' }}>XI RPL 1</option>
                            <option value="XI RPL 2" {{ request('kelas') == 'XI RPL 2' ? 'selected' : '' }}>XI RPL 2</option>
                            <option value="XI RPL 3" {{ request('kelas') == 'XI RPL 3' ? 'selected' : '' }}>XI RPL 3</option>
                        </select>
                    </div>

                    <!-- Filter Jenis Kelamin -->
                    <div class="col-md-auto">
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua Gender</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Urutan Nama -->
                    <div class="col-md-auto">
                        <select name="sort" class="form-select">
                            <option value="">Urutkan Nama</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
                        </select>
                    </div>

                    <!-- Tombol Cari -->
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>

                    <!-- Tombol Reset -->
                    <div class="col-md-auto">
                        <a href="{{ route('datamurid.murid') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    </div>

                    <!-- Tombol Export -->
                    <div class="col-md-auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center"
                                    type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-download me-2"></i> Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.murid.export.pdf') }}" target="_blank">
                                        <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
                                    </a>
                                </li>
                            </ul>
                        </div>
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
                <th class="border-0 ps-4 py-3">#</th>
                <th class="border-0 py-3">Nama</th>
                <th class="border-0 py-3">NIS</th>
                <th class="border-0 py-3">Kelas</th>
                <th class="border-0 py-3">Telepon</th>
                <th class="border-0 py-3">Jenis Kelamin</th>
                <th class="border-0 py-3">Tanggal Lahir</th>
                <th class="border-0 py-3">Username_user</th>
                <th class="border-0 text-end pe-4 py-3">Aksi</th>
            </tr>
        </thead>
       <tbody>
    @forelse ($murid as $index => $m)
        <tr class="align-middle">
            <td class="ps-4 py-3 fw-semibold text-muted">{{ $murid->firstItem() + $index }}</td>

            <!-- Nama dan Avatar -->
            <td class="py-3">
                <div class="d-flex align-items-center">
                    <div class="avatar-initial bg-{{ $m->jenis_kelamin == 'L' ? 'primary' : 'danger' }} 
                        bg-opacity-10 text-{{ $m->jenis_kelamin == 'L' ? 'primary' : 'danger' }} 
                        rounded-circle d-flex justify-content-center align-items-center me-3"
                        style="width: 40px; height: 40px;">
                        <strong>{{ strtoupper(substr($m->nama, 0, 1)) }}</strong>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $m->nama }}</div>
                    </div>
                </div>
            </td>

            <!-- NIS -->
            <td class="py-3">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    {{ $m->nis }}
                </span>
            </td>

            <!-- Kelas -->
            <td class="py-3">
                <span class="badge bg-primary bg-opacity-10 text-primary border px-3 py-2 rounded-pill">
                    {{ $m->kelas }}
                </span>
            </td>

            <!-- Telepon -->
            <td class="py-3">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    {{ $m->telepon }}
                </span>
            </td>

            <!-- Jenis Kelamin -->
            <td class="py-3">
                <span class="badge bg-{{ $m->jenis_kelamin == 'L' ? 'primary' : 'danger' }} 
                    bg-opacity-25 text-{{ $m->jenis_kelamin == 'L' ? 'primary' : 'danger' }} 
                    px-3 py-2 rounded-pill">
                    {{ $m->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
            </td>

            <!-- Tanggal Lahir -->
            <td class="py-3">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    {{ \Carbon\Carbon::parse($m->tanggal_lahir)->format('d M Y') }}
                </span>
            </td>

            <!-- Username -->
            <td class="py-3">
                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill">
                    <i class="bi bi-person-circle me-1"></i>{{ $m->username_user }}
                </span>
            </td>

            <!-- Tombol Aksi -->
           <td class="text-end pe-4 py-3">
    <div class="d-flex justify-content-end gap-2">
        <!-- Tombol Edit -->
        <a href="{{ route('datamurid.edit', $m->nis) }}"
            class="btn btn-outline-primary d-flex align-items-center justify-content-center"
            style="width: 38px; height: 38px;"
            title="Edit">
            <i class="bi bi-pencil-square"></i>
        </a>

        <!-- Tombol Hapus -->
       <form id="delete-form-{{ $m->nis }}" action="{{ route('datamurid.destroy', $m->nis) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="button"
        class="btn btn-outline-danger d-flex align-items-center justify-content-center"
        style="width: 38px; height: 38px;"
        onclick="confirmDelete({{ $m->nis }})"
        title="Hapus">
        <i class="bi bi-trash3"></i>
    </button>
</form>


    </div>
</td>

    @empty
        <tr>
            <td colspan="9" class="text-center py-3">Tidak ada data murid</td>
        </tr>
    @endforelse
</tbody>


    </table>
    <div class="mt-4 d-flex justify-content-center">
    {{ $murid->links() }}
</div>

</div>


    <!-- JavaScript: Konfirmasi hapus & auto-dismiss alert -->
    <script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data murid ini?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // Auto dismiss alert success (8 detik)
    setTimeout(() => {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            // Tambahkan efek fade-out pelan
            alert.style.transition = "opacity 1s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 1000); // Hapus dari DOM setelah animasi selesai
        }
    }, 20000); // tampil selama 8 detik
</script>



