@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="text-danger">Konfirmasi Hapus Data</h4>
            <p>Apakah kamu yakin ingin menghapus nilai berikut ini?</p>

            <ul>
                <li><strong>Guru ID:</strong> {{ $nilai->id_guru }}</li>
                <li><strong>Murid ID:</strong> {{ $nilai->id_murid }}</li>
                <li><strong>Mata Pelajaran ID:</strong> {{ $nilai->id_mata_pelajaran }}</li>
                <li><strong>Nilai:</strong> {{ $nilai->nilai }}</li>
                <li><strong>Predikat:</strong> {{ $nilai->predikat }}</li>
                <li><strong>Semester:</strong> {{ $nilai->semester }}</li>
            </ul>

            <form action="{{ route('datanilai.destroy', $nilai->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <a href="{{ route('datanilai.nilai') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
