@extends('layouts.layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3 px-4 rounded-top-4">
                    <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Data Murid</h4>
                </div>

                <div class="card-body px-4 py-5">
                    <form action="{{ route('datamurid.update', $murid->nis) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ $murid->nama }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="nis" class="form-label fw-semibold">NIS</label>
                                <input type="text" name="nis" id="nis" class="form-control" value="{{ $murid->nis }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="kelas" class="form-label fw-semibold">Kelas</label>
                                <input type="text" name="kelas" id="kelas" class="form-control" value="{{ $murid->kelas }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="telepon" class="form-label fw-semibold">No. Telepon</label>
                                <input type="text" name="telepon" id="telepon" class="form-control" value="{{ $murid->telepon }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                    <option value="L" {{ $murid->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $murid->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ $murid->tanggal_lahir }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="username_user" class="form-label fw-semibold">Username User</label>
                                <select name="username_user" class="form-select" id="username_user" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->username }}"
                                            {{ (string) old('username_user', $murid->username_user) === $user->username ? 'selected' : '' }}>
                                            {{ $user->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between">
                            <a href="{{ route('datamurid.murid') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
