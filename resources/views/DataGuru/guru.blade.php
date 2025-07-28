@extends('layouts.layout')

@section('content')
    <!-- Dashboard Header -->
    <div class="row d-flex justify-content-end">
        <div class="col-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="text-primary fw-bold mb-0">Data Guru</h1>
                            <p class="text-muted mb-md-0">Kelola data Guru dengan mudah dan efisien</p>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-md-end">
                                <a href="{{ route('dataguru.create') }}" class="btn btn-primary d-flex align-items-center">
                                    <i class="bi bi-person-plus-fill me-2"></i>
                                    Tambah Guru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if (session('success'))
        <div class="row justify-content-end">
            <div class="col-9">
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Search & Filter -->
    <!-- Search & Filter -->
    <div class="row d-flex justify-content-end">
        <div class="col-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('dataguru.guru') }}">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <!-- Search Input -->
                            <div class="input-group" style="max-width: 230px;">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="keyword" class="form-control border-start-0 ps-0"
                                    placeholder="Cari nama atau NIP..." value="{{ request('keyword') }}">
                            </div>

                            <!-- Filter Mapel -->
                            <select name="mapel" class="form-select" style="max-width: 160px;">
                                <option value="">Pilih Mapel</option>
                                @php
                                    $mapelList = [
                                        'Matematika',
                                        'Bahasa Indonesia',
                                        'Bahasa Inggris',
                                        'Pemrograman Web',
                                        'Basis Data',
                                        'Pendidikan Agama Islam',
                                        'Pendidikan Kewarganegaraan',
                                    ];
                                @endphp
                                @foreach ($mapelList as $mapel)
                                    <option value="{{ $mapel }}" {{ request('mapel') == $mapel ? 'selected' : '' }}>
                                        {{ $mapel }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Filter Gender -->
                            <select name="gender" class="form-select" style="max-width: 150px;">
                                <option value="">Pilih Gender</option>
                                <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>P</option>
                            </select>
                            <!-- Filter Sorting -->
                            <select name="sort" class="form-select" style="max-width: 150px;">
                                <option value="">Urutkan</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
                            </select>


                            <!-- Tombol Cari -->
                            <button type="submit" class="btn btn-primary d-flex align-items-center">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>

                            <!-- Tombol Reset -->
                            <a href="{{ route('dataguru.guru') }}"
                                class="btn btn-outline-secondary d-flex align-items-center">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </a>

                            <!-- Dropdown Export -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center"
                                    type="button" id="exportDropdown" data-bs-toggle="dropdown">
                                    <i class="bi bi-download me-2"></i> Export
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('guru.export.pdf') }}" target="_blank">
                                            <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
                                        </a>
                                    </li>
                                    {{-- Tambahkan Export Excel, CSV jika ada --}}
                                </ul>
                            </div>
                        </div> <!-- /.d-flex -->
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Tabel Data Murid -->
    <div class="row d-flex justify-content-end">
        <div class="col-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Email</th>
                                    <th>No. Telp</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Username User</th>
                                    <th>Kode_Mapel</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                           <tbody class="guru-table-body">
    @forelse($guru as $g)
        <tr class="guru-row-hover">
            <td class="text-center fw-medium text-muted row-number">
                {{ $loop->iteration }}
            </td>
            <td class="teacher-info-cell">
                @php
                    $inisial = strtoupper(substr($g->nama, 0, 1));
                    $isMale = $g->jenis_kelamin === 'L';
                    
                    // Array warna gradient untuk avatar
                    $avatarColors = [
                        'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                        'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                        'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                        'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                        'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                        'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
                        'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)'
                    ];
                    $colorIndex = $loop->iteration % count($avatarColors);
                @endphp

                <div class="d-flex align-items-center gap-3">
                    <div class="teacher-avatar" 
                         style="background: {{ $avatarColors[$colorIndex] }};">
                        {{ $inisial }}
                    </div>
                    <div class="teacher-details">
                        <div class="teacher-name">{{ $g->nama }}</div>
                        <div class="teacher-id">ID: {{ $g->id }}</div>
                    </div>
                </div>
            </td>
            <td class="nip-cell">
                <span class="nip-badge">{{ $g->nip }}</span>
            </td>
            <td class="email-cell">
                <span class="email-text">{{ $g->email }}</span>
            </td>
            <td class="phone-cell">
                <span class="phone-badge">{{ $g->no_telp }}</span>
            </td>
            <td class="gender-cell">
                <span class="gender-badge {{ $g->jenis_kelamin === 'L' ? 'gender-male' : 'gender-female' }}">
                    <i class="bi {{ $g->jenis_kelamin === 'L' ? 'bi-person-standing' : 'bi-person-standing-dress' }}"></i>
                    {{ $g->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
            </td>
            <td class="birth-cell">
                <span class="birth-date">
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ \Carbon\Carbon::parse($g->tgl_lahir)->translatedFormat('d M Y') }}
                </span>
            </td>
            <td class="username-cell">
                <span class="username-badge">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ $g->user ? $g->user->username : 'N/A' }}
                </span>
            </td>
            <td class="subject-cell">
                <span class="subject-code-badge">
                    <i class="bi bi-book me-1"></i>
                    {{ $g->mataPelajaran ? $g->mataPelajaran->kode : 'N/A' }}
                </span>
            </td>
            <td class="action-cell">
                <div class="action-buttons-guru">
                    <a href="{{ route('dataguru.edit', [$g->nip]) }}"
                       class="action-btn-guru edit-btn-guru" 
                       title="Edit" data-bs-toggle="tooltip">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('dataguru.destroy', [$g->nip]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="action-btn-guru delete-btn-guru"
                                onclick="return confirm('Yakin ingin menghapus guru ini?')"
                                title="Hapus" data-bs-toggle="tooltip">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr class="empty-row">
            <td colspan="10" class="text-center py-5">
                <div class="empty-state">
                    <i class="bi bi-person-x fs-1 text-muted mb-3"></i>
                    <div class="text-muted fs-5">Tidak ada data guru ditemukan</div>
                    <small class="text-muted">Silakan tambah data guru baru</small>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>

<style>
/* Guru Table Styling */
.guru-table-body {
    background: white;
}

.guru-row-hover {
    border: none;
    border-bottom: 1px solid #f1f3f4;
    transition: all 0.2s ease;
    height: 70px;
}

.guru-row-hover:hover {
    background-color: #f8f9ff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.08);
}

.guru-row-hover td {
    padding: 16px 12px;
    vertical-align: middle;
    border: none;
}

/* Row Number */
.row-number {
    font-size: 14px;
}

/* Teacher Info */
.teacher-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 18px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

.teacher-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 15px;
    line-height: 1.2;
}

.teacher-id {
    color: #718096;
    font-size: 12px;
    font-weight: 500;
}

/* NIP Badge */
.nip-badge {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    color: #1565c0;
    padding: 8px 12px;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-weight: 600;
    font-size: 13px;
    display: inline-block;
    border: 1px solid rgba(21, 101, 192, 0.1);
}

/* Email */
.email-text {
    color: #4a5568;
    font-size: 14px;
    font-weight: 500;
}

/* Phone Badge */
.phone-badge {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    color: #0369a1;
    padding: 6px 10px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 13px;
    display: inline-block;
    border: 1px solid rgba(3, 105, 161, 0.1);
}

/* Gender Badge */
.gender-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.gender-male {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1d4ed8;
    border: 1px solid rgba(29, 78, 216, 0.1);
}

.gender-female {
    background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
    color: #be185d;
    border: 1px solid rgba(190, 24, 93, 0.1);
}

/* Birth Date */
.birth-date {
    color: #6b7280;
    font-weight: 500;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
}

/* Username Badge */
.username-badge {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    border: 1px solid rgba(146, 64, 14, 0.1);
}

/* Subject Code Badge */
.subject-code-badge {
    background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
    color: #7c3aed;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    border: 1px solid rgba(124, 58, 237, 0.1);
}

/* Action Buttons */
.action-buttons-guru {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

.action-btn-guru {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1.5px solid;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    text-decoration: none;
    cursor: pointer;
}

.edit-btn-guru {
    border-color: #3b82f6;
    color: #3b82f6;
}

.edit-btn-guru:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.delete-btn-guru {
    border-color: #ef4444;
    color: #ef4444;
}

.delete-btn-guru:hover {
    background: #ef4444;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Empty State */
.empty-state {
    padding: 40px 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .guru-row-hover {
        height: auto;
    }
    
    .guru-row-hover td {
        padding: 12px 8px;
    }
    
    .teacher-avatar {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .teacher-name {
        font-size: 14px;
    }
    
    .action-btn-guru {
        width: 32px;
        height: 32px;
    }
    
    .nip-badge, .phone-badge, .username-badge, .subject-code-badge {
        padding: 4px 8px;
        font-size: 12px;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.guru-row-hover {
    animation: fadeInUp 0.3s ease;
}

.guru-row-hover:nth-child(even) {
    animation-delay: 0.1s;
}

/* Hover Animation for Badges */
.guru-row-hover:hover .nip-badge,
.guru-row-hover:hover .phone-badge,
.guru-row-hover:hover .username-badge,
.guru-row-hover:hover .subject-code-badge,
.guru-row-hover:hover .gender-badge {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}
</style>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <div class="pagination pagination-rounded">
                            {{ $guru->links() }} <!-- Paginasi -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
