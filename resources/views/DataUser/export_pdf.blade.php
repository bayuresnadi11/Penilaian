<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pengguna - SMKN 11 Bandung</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            margin: 40px;
            color: #000;
        }

        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .kop h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .kop h3 {
            margin: 0;
            font-size: 16px;
        }

        .kop p {
            margin: 2px 0;
            font-size: 12px;
        }

        h4 {
            text-align: center;
            margin-top: 25px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
            font-size: 11px;
        }

        th {
            background-color: #eaeaea;
        }

        .footer {
            margin-top: 60px;
            position: relative;
            font-size: 12px;
            min-height: 120px;
        }

        .ttd-left {
            position: absolute;
            left: 0;
            width: 30%;
            text-align: center;
        }

        .ttd-line {
            margin-top: 80px;
            border-top: 1px solid #000;
            width: 100%;
            padding-top: 5px;
        }

        .printed-info {
            margin-top: 140px;
            text-align: right;
            font-size: 12px;
        }

        .avoid-page-break {
            page-break-inside: avoid;
            page-break-before: auto;
            page-break-after: auto;
        }
    </style>
</head>
<body>

    <!-- Kop Surat Tengah -->
    <div class="kop">
        <h2>PEMERINTAH PROVINSI JAWA BARAT</h2>
        <h3>SMK NEGERI 11 BANDUNG</h3>
        <p>Jl. Raya Cilember, RT.01/RW.04, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40153</p>
        <p>Telp. (022) 1234567 | Email: info@smkn11bdg.sch.id</p>
    </div>

    <!-- Judul -->
    <h4>LAPORAN DATA PENGGUNA<br>TAHUN AJARAN {{ now()->year }}/{{ now()->year + 1 }}</h4>

    <!-- Tabel Data Pengguna -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Tidak ada data pengguna tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @php
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = \Carbon\Carbon::now()->translatedFormat('d F Y');
        $jam = date('H:i:s');
    @endphp

    <!-- Footer -->
    <div class="avoid-page-break">
        <div class="footer">
            <div class="ttd-left">
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <div class="ttd-line">Nama Kepala Sekolah</div>
            </div>
        </div>

        <div class="printed-info">
            <p>Bandung, {{ $tanggal }}</p>
            <p>Dicetak pukul {{ $jam }} WIB</p>
        </div>
    </div>

</body>
</html>
