@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4 text-danger">Konfirmasi Hapus Guru</h2>

    <div class="alert alert-warning">
        <p>Apakah Anda yakin ingin menghapus guru berikut?</p>
    </div>

    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Nama:</strong> {{ $guru->nama }}</li>
        <li class="list-group-item"><strong>NIP:</strong> {{ $guru->nip }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $guru->email }}</li>
        <li class="list-group-item"><strong>No Telp:</strong> {{ $guru->no_telp }}</li>
        <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $guru->jenis_kelamin }}</li>
        <li class="list-group-item"><strong>Tanggal Lahir:</strong> {{ $guru->tgl_lahir }}</li>
    </ul>

    <form action="{{ route('dataguru.destroy', $guru->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <a href="{{ route('dataguru.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>
</div>

