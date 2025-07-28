<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MuridDashboardController;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\MapelDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\NilaiDashboardController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardGuruController;
use App\Http\Controllers\DashboardMuridController;

// ---------------- ROUTE MURID ----------------
// Alihkan URL root ke halaman login admin
Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::prefix('murid')->group(function () {
    Route::get('/', [MuridDashboardController::class, 'index'])->name('datamurid.murid');
    Route::get('/create', [MuridDashboardController::class, 'create'])->name('datamurid.create');
    Route::post('/', [MuridDashboardController::class, 'store'])->name('datamurid.store');
    Route::get('/{nis}/edit', [MuridDashboardController::class, 'edit'])->name('datamurid.edit');
    Route::put('/{nis}', [MuridDashboardController::class, 'update'])->name('datamurid.update');
    Route::delete('/{nis}', [MuridDashboardController::class, 'destroy'])->name('datamurid.destroy');
});
use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::get('/grafik-mapel', [NilaiDashboardController::class, 'grafikMapel'])->name('grafik.mapel');

// Export PDF Murid
Route::get('/dashboard/murid/export/pdf', [MuridDashboardController::class, 'exportPdf'])->name('dashboard.murid.export.pdf');


// ---------------- ROUTE GURU ----------------
Route::get('/guru', [GuruDashboardController::class, 'index'])->name('dataguru.guru');
Route::get('/guru/create', [GuruDashboardController::class, 'create'])->name('dataguru.create');
Route::post('/guru', [GuruDashboardController::class, 'store'])->name('dataguru.store');
Route::get('/guru/{nip}/edit', [GuruDashboardController::class, 'edit'])->name('dataguru.edit');
Route::put('/guru/{nip}/', [GuruDashboardController::class, 'update'])->name('dataguru.update');
Route::delete('/guru/{nip}', [GuruDashboardController::class, 'destroy'])->name('dataguru.destroy');

// Export PDF Guru
Route::get('/dashboard/guru/export/pdf', [GuruDashboardController::class, 'exportPdf'])->name('guru.export.pdf');


// ---------------- ROUTE MAPEL ----------------
Route::get('/mapel', [MapelDashboardController::class, 'index'])->name('datamapel.mapel');
Route::get('/mapel/create', [MapelDashboardController::class, 'create'])->name('datamapel.create');
Route::post('/mapel', [MapelDashboardController::class, 'store'])->name('datamapel.store');
Route::get('/mapel/{kode}/edit', [MapelDashboardController::class, 'edit'])->name('datamapel.edit');
Route::put('/mapel/{kode}', [MapelDashboardController::class, 'update'])->name('datamapel.update');
Route::delete('/mapel/{kode}', [MapelDashboardController::class, 'destroy'])->name('datamapel.destroy');

// Export PDF Mapel
Route::get('/mapel/export/pdf', [MapelDashboardController::class, 'exportPdf'])->name('datamapel.export.pdf');


// ---------------- ROUTE USER ----------------
Route::get('/user', [UserDashboardController::class, 'index'])->name('datauser.user');
Route::get('/datauser/create', [UserDashboardController::class, 'create'])->name('datauser.create');
Route::post('/datauser', [UserDashboardController::class, 'store'])->name('datauser.store');
Route::get('/datauser/{id}/edit', [UserDashboardController::class, 'edit'])->name('datauser.edit');
Route::put('/datauser/{id}', [UserDashboardController::class, 'update'])->name('datauser.update');
Route::get('/datauser/{id}/delete', [UserDashboardController::class, 'confirmDelete'])->name('datauser.confirmDelete');
Route::delete('/datauser/{id}', [UserDashboardController::class, 'destroy'])->name('datauser.destroy');

// Export PDF User
Route::get('/datauser/export/pdf', [UserDashboardController::class, 'exportPDF'])->name('datauser.export.pdf');


// ---------------- ROUTE NILAI ----------------
Route::get('/nilai', [NilaiDashboardController::class, 'index'])->name('datanilai.nilai');
Route::get('/nilai/create', [NilaiDashboardController::class, 'create'])->name('datanilai.create');
Route::post('/nilai', [NilaiDashboardController::class, 'store'])->name('datanilai.store');
Route::get('/nilai/{id}/edit', [NilaiDashboardController::class, 'edit'])->name('datanilai.edit');
Route::put('/nilai/{id}', [NilaiDashboardController::class, 'update'])->name('datanilai.update');
Route::delete('/nilai/{id}', [NilaiDashboardController::class, 'destroy'])->name('datanilai.destroy');

// Export PDF Nilai
Route::get('/nilai/export/pdf', [NilaiDashboardController::class, 'exportPdf'])->name('nilai.export.pdf');


// ---------------- ADMIN LOGIN ----------------
Route::get('/login-admin', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login-admin', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout-admin', [AuthController::class, 'logout'])->name('admin.logout');

// Dashboard khusus admin (dengan middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard.', [DashboardAdminController::class, 'index'])->name('dashboard.admin');
});

Route::get('/admin/dashboard/murid', [DashboardMuridController::class, 'index'])->name('dashboard.murid')->middleware('auth');
Route::middleware(['auth', 'role:guru'])->group(function () {
});
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard/guru', [DashboardGuruController::class, 'index'])->name('dashboard.guru');
});




// ---------------- USER LOGIN ----------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ---------------- DASHBOARD LAIN (optional) ----------------
// Ini contoh jika ingin memisah dashboard untuk role tertentu



// ---------------- DEBUG / DEVELOPMENT ----------------
Route::get('/hash-admin', function () {
    return Hash::make('admin123');
});

