{{-- resources/views/dashboard/users/create.blade.php --}}
@extends('layouts.layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="text-primary fw-bold mb-1 text-center">Tambah Pengguna</h3>
                <p class="text-muted text-center mb-4">Masukkan informasi akun pengguna baru.</p>

                <form action="{{ route('datauser.store') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label for="role" class="form-label">Peran</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="" disabled selected>Pilih peran</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="murid">Murid</option>
                        </select>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('datauser.user') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
