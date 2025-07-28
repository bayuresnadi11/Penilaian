@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <h4>Edit Mata Pelajaran</h4>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('datamapel.update', $mapel->kode) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kode" class="form-label">Kode Mapel</label>
                    <input type="text" name="kode" class="form-control" value="{{ $mapel->kode }}" required>
                    @error('kode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mata_pelajaran" class="form-label">Nama Mapel</label>
                    <input type="text" name="mata_pelajaran" class="form-control" value="{{ $mapel->mata_pelajaran }}" required>
                    @error('mata_pelajaran')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('datamapel.mapel') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
