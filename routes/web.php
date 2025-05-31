<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController; // Pastikan ini di-import
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');

// Rute untuk Dashboard (Memerlukan login dan email terverifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup rute yang memerlukan autentikasi (login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // HAPUS BARIS INI DARI SINI:
    // Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');
    // Karena sudah kita pindahkan ke atas agar tidak dilindungi middleware 'auth'
});

// Ini akan mengimpor rute-rute autentikasi seperti login, register, dll.
require __DIR__.'/auth.php';
