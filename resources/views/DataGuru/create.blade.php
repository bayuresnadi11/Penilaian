@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Tambah Data Guru</h5>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ups!</strong> Terjadi kesalahan saat mengisi data:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dataguru.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror"
                               value="{{ old('nip') }}" pattern="\d{18}" title="NIP harus terdiri dari 18 digit angka" required>
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">No Telepon</label>
                        <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                               value="{{ old('no_telp') }}" required>
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label d-block">Jenis Kelamin</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="L"
                                {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                            <label class="form-check-label">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="P"
                                {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required>
                            <label class="form-check-label">Perempuan</label>
                        </div>
                        @error('jenis_kelamin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror"
                               value="{{ old('tgl_lahir') }}" required>
                        @error('tgl_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                   <div class="col-md-6">
    <label for="username_user" class="form-label">Username User</label>
    <input type="text" 
           name="username_user" 
           id="username_user" 
           class="form-control @error('username_user') is-invalid @enderror" 
           value="{{ old('username_user') }}" 
           required>
    @error('username_user')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                    <div class="col-md-6">
                        <label class="form-label">Pilih Kode Mapel</label>
                        <select name="kode_mapel" class="form-select @error('kode_mapel') is-invalid @enderror" required>
                            <option value="" disabled {{ old('kode_mapel') ? '' : 'selected' }}>-- Pilih Kode Mata Pelajaran --</option>
                            @foreach ($mataPelajaran as $mapel)
                                <option value="{{ $mapel->kode }}" {{ old('kode_mapel') == $mapel->kode ? 'selected' : '' }}>
                                    {{ $mapel->kode }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_mapel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary" {{ $users->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('dataguru.guru') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection