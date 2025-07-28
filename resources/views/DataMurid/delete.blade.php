@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Hapus Data Murid</h1>
    <p>Apakah kamu yakin ingin menghapus data murid bernama <strong>{{ $murid->nama }}</strong>?</p>

    <form action="{{ route('deletemurid', $murid->nis) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        <a href="{{ route('datamurid.murid') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection