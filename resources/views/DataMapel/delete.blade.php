@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="mb-4">Konfirmasi Hapus</h3>
            <p>Apakah kamu yakin ingin menghapus mata pelajaran berikut?</p>

            <ul>
                <li><strong>Kode:</strong> {{ $mapel->kode }}</li>
                <li><strong>Nama:</strong> {{ $mapel->nama }}</li>
            </ul>

            <form action="{{ route('datamapel.destroy', $mapel->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <a href="{{ route('datamapel.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
