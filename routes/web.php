<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AdminPresensiController;

// =========================
// Route Awal (Login Page)
// =========================
Route::get('/', function () {
    return view('auth.pagelogin');
})->name('login');

// =========================
// Auth: Login & Logout
// =========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =========================
// Route untuk User Biasa
// =========================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Presensi
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::get('/presensi/create', [PresensiController::class, 'create'])->name('presensi.create');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
});

// =========================
// Route untuk Admin
// =========================
Route::middleware(['auth', 'is_admin'])->group(function () {

    // Dashboard admin
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // Presensi admin (dari controller)
    Route::get('/admin/presensi', [AdminPresensiController::class, 'adminPresensi'])->name('admin.presensi');


    // ========== LOKASI KANTOR (CRUD) ==========
    Route::get('/admin/kantor', [KantorController::class, 'index'])->name('admin.kantor');
    Route::get('/admin/office/create', [KantorController::class, 'create'])->name('admin.office.create');
    Route::post('/admin/office/store', [KantorController::class, 'store'])->name('admin.office.store');
    Route::get('/admin/office/{id}/edit', [KantorController::class, 'edit'])->name('admin.office.edit');
    Route::put('/admin/office/{id}', [KantorController::class, 'update'])->name('admin.office.update');
    Route::delete('/admin/office/{id}', [KantorController::class, 'destroy'])->name('admin.office.destroy');

    // ========== PENGGUNA / USER (CRUD) ==========
    Route::get('/admin/pengguna', [PenggunaController::class, 'index'])->name('admin.pengguna');
    Route::get('/admin/user/pengguna', [PenggunaController::class, 'index'])->name('admin.user.pengguna');
    Route::get('/admin/user/create', [PenggunaController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user/store', [PenggunaController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/user/{id}/edit', [PenggunaController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/{id}/update', [PenggunaController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [PenggunaController::class, 'destroy'])->name('admin.user.destroy');
});
