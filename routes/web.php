<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DutaPrintController;
use Illuminate\Support\Facades\Route;

// Rute Publik GUEST (Hanya bisa diakses jika belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Rute Terproteksi AUTH (Harus login terlebih dahulu)
Route::middleware(['auth'])->group(function () {
    // Aksi Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Modul Utama Aplikasi DutaPrint
    Route::get('/penjualan', [DutaPrintController::class, 'penjualan'])->name('penjualan');
    Route::post('/penjualan', [DutaPrintController::class, 'storePenjualan'])->name('penjualan.store');
    Route::get('/invoice/{id}', [DutaPrintController::class, 'invoice'])->name('invoice');

    Route::middleware(['auth'])->group(function () {
    // Rute yang sudah ada sebelumnya...
    Route::get('/laporan', [DutaPrintController::class, 'laporan'])->name('laporan');
    
    // Rute Baru Tambahan Export Excel
    Route::get('/laporan/export', [DutaPrintController::class, 'exportExcel'])->name('laporan.export');
});

    Route::get('/operator', [DutaPrintController::class, 'operatorDashboard'])->name('operator');
    Route::put('/operator/item/{id}', [DutaPrintController::class, 'updateStatus'])->name('operator.update');

    Route::get('/settings', [DutaPrintController::class, 'settings'])->name('settings');
    Route::put('/settings/user/{id}', [DutaPrintController::class, 'updateUser'])->name('settings.user.update');
});