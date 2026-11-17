<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;

// Rute Publik
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/jadwal', [PublicController::class, 'schedule'])->name('public.schedule');
Route::get('/laporan', [PublicController::class, 'reports'])->name('public.reports');
Route::post('/laporan', [PublicController::class, 'storeReport'])->name('public.reports.store');
Route::get('/pengumuman', [PublicController::class, 'announcements'])->name('public.announcements');
Route::get('/dokumentasi', [PublicController::class, 'documentation'])->name('public.documentation');
Route::get('/denda', [PublicController::class, 'fines'])->name('public.fines');
Route::get('/kontak', [PublicController::class, 'contact'])->name('public.contact');

// Login & Logout Petugas
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Panel Petugas
Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/denda', [PetugasController::class, 'denda'])->name('denda');
    Route::post('/denda', [PetugasController::class, 'storeDenda'])->name('denda.store');
    Route::post('/denda/{id}/toggle', [PetugasController::class, 'toggleDenda'])->name('denda.toggle');
    Route::delete('/denda/{id}', [PetugasController::class, 'deleteDenda'])->name('denda.delete');
    Route::get('/denda/export', [PetugasController::class, 'exportDenda'])->name('denda.export');

    Route::get('/laporan', [PetugasController::class, 'laporan'])->name('laporan');
    Route::delete('/laporan/{id}', [PetugasController::class, 'deleteLaporan'])->name('laporan.delete');

    Route::get('/pengumuman', [PetugasController::class, 'pengumuman'])->name('pengumuman');
    Route::post('/pengumuman', [PetugasController::class, 'storePengumuman'])->name('pengumuman.store');
    Route::delete('/pengumuman/{id}', [PetugasController::class, 'deletePengumuman'])->name('pengumuman.delete');

    Route::get('/dokumentasi', [PetugasController::class, 'dokumentasi'])->name('dokumentasi');
    Route::post('/dokumentasi', [PetugasController::class, 'storeDokumentasi'])->name('dokumentasi.store');
    Route::delete('/dokumentasi/{id}', [PetugasController::class, 'deleteDokumentasi'])->name('dokumentasi.delete');
});

