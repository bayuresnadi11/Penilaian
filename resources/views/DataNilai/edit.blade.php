@extends('layouts.layout')

@section('content')
<div class="container">
    <h4>Edit Data Nilai</h4>

    <form action="{{ route('datanilai.update', $nilai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $nilai->nip) }}" class="form-control @error('nip') is-invalid @enderror">
            @error('nip')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nis" class="form-label">NIS</label>
            <input type="text" name="nis" id="nis" value="{{ old('nis', $nilai->nis) }}" class="form-control @error('nis') is-invalid @enderror">
            @error('nis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kode" class="form-label">Kode Mata Pelajaran</label>
            <select name="kode" id="kode" class="form-select @error('kode') is-invalid @enderror">
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($mataPelajaran as $mp)
                    <option value="{{ $mp->kode }}" {{ old('kode', $nilai->kode) == $mp->kode ? 'selected' : '' }}>
                        {{ $mp->kode }}
                    </option>
                @endforeach
            </select>
            @error('kode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nilai" class="form-label">Nilai</label>
            <input type="number" name="nilai" id="nilai" value="{{ old('nilai', $nilai->nilai) }}" class="form-control @error('nilai') is-invalid @enderror" min="0" max="100">
            @error('nilai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="predikat" class="form-label">Predikat</label>
            <select name="predikat" id="predikat" class="form-select @error('predikat') is-invalid @enderror">
                <option value="">-- Pilih Predikat --</option>
                <option value="A" {{ old('predikat', $nilai->predikat) == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('predikat', $nilai->predikat) == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ old('predikat', $nilai->predikat) == 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ old('predikat', $nilai->predikat) == 'D' ? 'selected' : '' }}>D</option>
                <option value="E" {{ old('predikat', $nilai->predikat) == 'E' ? 'selected' : '' }}>E</option>
            </select>
            @error('predikat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select @error('semester') is-invalid @enderror">
                <option value="">-- Pilih Semester --</option>
                <option value="1" {{ old('semester', $nilai->semester) == '1' ? 'selected' : '' }}>1</option>
                <option value="2" {{ old('semester', $nilai->semester) == '2' ? 'selected' : '' }}>2</option>
            </select>
            @error('semester')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('datanilai.nilai') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
