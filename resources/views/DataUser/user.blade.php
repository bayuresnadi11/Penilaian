@extends('layouts.layout')

@section('content')
<!-- Dashboard Header -->
<div class="row d-flex justify-content-end">
    <div class="col-9">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="text-primary fw-bold mb-0">Data User</h1>
                        <p class="text-muted mb-md-0">Kelola data User dengan mudah dan efisien</p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-md-end">
                        <a href="{{ route('datauser.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Tambah User
                        </a>
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
                <form action="{{ route('datauser.user') }}" method="GET" class="d-flex gap-2 flex-wrap">
                    <div class="input-group" style="max-width: 550px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="keyword" class="form-control border-start-0 ps-0"
                            placeholder="Cari Username atau Role..." value="{{ request('keyword') }}">
                    </div>
                  {{-- Sorting Username Numerik --}}
    <select name="sort_username_numeric" class="form-select" onchange="this.form.submit()">
        <option value="">Urutkan Username Angka</option>
        <option value="asc" {{ request('sort_username_numeric') === 'asc' ? 'selected' : '' }}>Terkecil</option>
        <option value="desc" {{ request('sort_username_numeric') === 'desc' ? 'selected' : '' }}>Terbesar</option>
    </select>


                    <select name="role" class="form-select" style="max-width: 180px;">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ request('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="murid" {{ request('role') === 'murid' ? 'selected' : '' }}>Murid</option>
                    </select>
                    <a href="{{ route('datauser.user') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-clockwise me-1"></i> Reset
</a>


                    <button type="submit" class="btn btn-primary px-3">Cari</button>


                     <div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center"
        type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-download me-2"></i> Export
    </button>
    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('datauser.export.pdf') }}" target="_blank">
                <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
            </a>
        </li>
    </ul>
</div>


                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data User -->
<div class="row d-flex justify-content-end">
    <div class="col-9">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px; background-color: #e8f0fe; font-weight: bold; color: #3366cc;">
                                            {{ strtoupper(substr($user->username, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $user->username }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-primary border border-primary">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('datauser.edit', $user->username) }}"
                                        class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('datauser.destroy', $user->username) }}" method="POST" class="d-inline"
                                        id="delete-form-{{ $user->username }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete({{ $user->username }})" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="py-5">
                                        <i class="bi bi-search text-muted mb-3" style="font-size: 3rem;"></i>
                                        <h5>Data user belum tersedia</h5>
                                        <p class="text-muted">Silakan tambahkan data user baru</p>
                                        <a href="{{ route('datauser.create') }}" class="btn btn-primary mt-2">Tambah User</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-center">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Konfirmasi Hapus -->
<script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    setTimeout(() => {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            alert.style.transition = "opacity 1s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 1000);
        }
    }, 8000);
</script>