<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
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

Route::post('/recipes/{recipe}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth'); // Hanya user terautentikasi
Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit')->middleware('auth');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update')->middleware('auth');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');

 // Rute untuk aksi like/unlike
    Route::post('/recipes/{recipe}/like', [RecipeController::class, 'like'])->name('recipes.like');
    Route::delete('/recipes/{recipe}/unlike', [RecipeController::class, 'unlike'])->name('recipes.unlike');

    // Rute untuk aksi save/unsave
    Route::post('/recipes/{recipe}/save', [RecipeController::class, 'save'])->name('recipes.save');
    Route::delete('/recipes/{recipe}/unsave', [RecipeController::class, 'unsave'])->name('recipes.unsave');

    // Rute untuk halaman liked recipes
    Route::get('/liked-recipes', [RecipeController::class, 'likedRecipes'])->name('recipes.liked'); //

    // Rute untuk halaman saved recipes
    Route::get('/saved-recipes', [RecipeController::class, 'savedRecipes'])->name('recipes.saved'); //

// Grup rute yang memerlukan autentikasi (login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
