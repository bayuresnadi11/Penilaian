@extends('layouts.layout')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i> Edit Data User
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('datauser.update', $user->username)}}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Username --}}
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" id="username" name="username" 
                            class="form-control shadow-sm @error('username') is-invalid @enderror" 
                            value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select name="role" id="role" 
                            class="form-select shadow-sm @error('role') is-invalid @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="guru" {{ $user->role === 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="murid" {{ $user->role === 'murid' ? 'selected' : '' }}>Murid</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('datauser.user') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
