<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard', function () {
    $categories = [ /* ... data dummy seperti contoh sebelumnya ... */ ];
    return view('dashboard', ['categories' => $categories]);
})->name('dashboard'); 

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
