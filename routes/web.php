<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanCutiController;

// Halaman Publik (tanpa login)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Dashboard setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/all_cuti', [DashboardController::class, 'all_cuti'])->name('all_cuti');
});

// Rute untuk pengajuan cuti
Route::middleware(['auth'])->group(function () {
    Route::get('/cuti/create', [PengajuanCutiController::class, 'create'])->name('cuti.create');
    Route::post('/cuti', [PengajuanCutiController::class, 'store'])->name('cuti.store')->middleware('auth');
    Route::get('/lihat', [PengajuanCutiController::class, 'show'])->name('cuti.index');
    Route::get('/cuti/pengajuan/{id}', [PengajuanCutiController::class, 'pengajuan'])->name('cuti.pengajuan');
    Route::post('/cuti/pengajuan/{id}/approve', [PengajuanCutiController::class, 'approve'])->name('cuti.approve');
});