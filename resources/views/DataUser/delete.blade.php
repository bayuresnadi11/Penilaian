@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="text-danger">Konfirmasi Hapus User</h4>
            <p>Apakah Anda yakin ingin menghapus user <strong>{{ $user->username }}</strong> (Role: {{ $user->role }})?</p>

            <form action="{{ route('datauser.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <a href="{{ route('datauser.user') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
