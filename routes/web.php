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
    Route::get('/create-user', [DashboardController::class, 'create_user'])->name('create-user');
    Route::post('/create-user', [DashboardController::class, 'store_User'])->name('store-user');
    Route::get('/all-user',[DashboardController::class, 'getalluser'])->name('get-all-user');
    Route::get('/edit-user/{id}', [DashboardController::class, 'edit_user'])->name('edit-user');
    Route::put('/update-user/{id}', [DashboardController::class, 'update_user'])->name('update-user');
});

// Rute untuk pengajuan cuti
Route::middleware(['auth'])->group(function () {
    Route::get('/cuti/create', [PengajuanCutiController::class, 'create'])->name('cuti.create');
    Route::post('/cuti', [PengajuanCutiController::class, 'store'])->name('cuti.store')->middleware('auth');
    Route::get('/lihat', [PengajuanCutiController::class, 'show'])->name('cuti.index');
    Route::get('/cuti/pengajuan/{id}', [PengajuanCutiController::class, 'pengajuan'])->name('cuti.pengajuan');
    Route::post('/cuti/pengajuan/{id}/approve', [PengajuanCutiController::class, 'approve'])->name('cuti.approve');
    Route::post('/cuti/pengajuan/{id}/reject', [PengajuanCutiController::class, 'reject'])->name('cuti.reject');
    Route::get('/cuti/print/form/{id}', [PengajuanCutiController::class, 'print_formcuti'])->name('cuti.print_form');
    Route::get('/cuti/print/izin/{id}', [PengajuanCutiController::class, 'print_suratizin'])->name('cuti.print_izin');
    Route::get('/cuti/all', [PengajuanCutiController::class, 'allpengajuan'])->name('cuti.all');
    Route::put('/{id}/update-cuti', [PengajuanCutiController::class, 'updateCuti'])->name('updateCuti');
    Route::get('/cuti/edit/{id}', [PengajuanCutiController::class, 'editcuti'])->name('cuti.edit');
    Route::get('/cuti/ketua-pengganti', [PengajuanCutiController::class, 'formKetuaPengganti'])->name('cuti.formKetuaPengganti');
    Route::post('/cuti/ketua-pengganti', [PengajuanCutiController::class, 'setKetuaPengganti'])->name('cuti.setKetuaPengganti');
});