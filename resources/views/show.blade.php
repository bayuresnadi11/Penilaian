<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-500 min-h-screen text-white font-sans">

    <div class="max-w-md mx-auto p-6">
        <!-- Header Profil -->
        <div class="text-center mt-6">
            <div class="w-28 h-28 mx-auto rounded-full bg-white text-blue-600 flex items-center justify-center text-4xl font-bold shadow-md">
                {{ strtoupper(substr($murid->nama, 0, 1)) }}
            </div>
            <h1 class="mt-4 text-2xl font-bold">{{ $murid->nama }}</h1>
            <p class="text-sm text-blue-100">Profil Siswa</p>
        </div>

        <!-- Data Siswa -->
        <div class="mt-8 bg-white text-gray-800 rounded-xl shadow-md p-5 space-y-4">
            <div class="flex justify-between">
                <span class="font-semibold">Nama</span>
                <span>{{ $murid->nama }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">NIS</span>
                <span>{{ $murid->nis }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Kelas</span>
                <span>{{ $murid->kelas ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Telepon</span>
                <span>{{ $murid->telepon ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Jenis Kelamin</span>
                <span>{{ $murid->jenis_kelamin ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Tanggal Lahir</span>
                <span>{{ \Carbon\Carbon::parse($murid->tanggal_lahir)->format('d M Y') ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Username</span>
                <span>{{ $murid->user->username ?? '-' }}</span>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-6 text-center">
            <a href="{{ route('profile') }}" class="inline-block bg-white text-blue-600 px-6 py-2 rounded-full font-semibold shadow hover:bg-blue-100 transition">
                ← Kembali
            </a>
        </div>
    </div>

</body>
</html>
