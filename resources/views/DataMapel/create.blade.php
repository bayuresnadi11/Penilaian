@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Mata Pelajaran</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('datamapel.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kode" class="form-label">Kode Mapel</label>
                    <input type="text" name="kode" class="form-control" required autofocus>
                    @error('kode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mata_pelajaran" class="form-label">Nama Mapel</label>
                    <input type="text" name="mata_pelajaran" class="form-control" required>
                    @error('mata_pelajaran')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                    <a href="{{ route('datamapel.mapel') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
