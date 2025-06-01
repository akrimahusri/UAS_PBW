<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rute untuk Halaman "My Recipe" (daftar resep pengguna)Add commentMore actions
Route::get('/my-recipes', [RecipeController::class, 'index'])->name('my-recipes')->middleware('auth');

// Rute untuk menampilkan form tambah resep baru
Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create')->middleware('auth');

Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show'); // Read Detail
Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit'); // Form Edit
Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update'); // Proses Update
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy'); // Proses Delete

// Rute untuk menampilkan detail satu resep
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show'); 

// Rute untuk MENYIMPAN resep baru dari form (method POST)
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store')->middleware('auth');
// Grup rute yang memerlukan autentikasi (login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/liked-recipes', function () {
        return view('recipes.liked'); // Ganti dengan controller dan view yang sesuai
    })->name('recipes.liked');

    Route::get('/saved-recipes', function () {
        return view('recipes.saved'); // Ganti dengan controller dan view yang sesuai
    })->name('recipes.saved');
});

    // HAPUS BARIS INI DARI SINI:
    // Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');
    // Karena sudah kita pindahkan ke atas agar tidak dilindungi middleware 'auth'

// Ini akan mengimpor rute-rute autentikasi seperti login, register, dll.
require __DIR__.'/auth.php';
