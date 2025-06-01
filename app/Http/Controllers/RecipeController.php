<?php

namespace App\Http\Controllers;

use App\Models\Recipe; // Pastikan Model Recipe sudah di-import
use App\Models\User;   // Jika Anda perlu interaksi langsung dengan model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login
use Illuminate\View\View;
use Illuminate\Support\Str; // Untuk helper string jika diperlukan

class RecipeController extends Controller
{
    /**
     * Display a listing of the user's recipes.
     * Method ini untuk halaman "My Recipe".
     */
    public function index(): View
    {
        // Ambil resep milik pengguna yang sedang login, urutkan dari yang terbaru
        // Menggunakan relasi 'recipes()' yang sudah didefinisikan di model User
        $recipes = Auth::user()->recipes()->latest()->get();

        // Ganti 'my-recipes' dengan path view yang benar jika berbeda (misal 'user.my-recipes')
        return view('user.my-recipes', ['recipes' => $recipes]);
    }

    /**
     * Show the form for creating a new recipe.
     * Method ini untuk menampilkan halaman form "New Recipe".
     */
    public function create(): View
    {
        // View 'recipes.create' mengarah ke resources/views/recipes/create.blade.php
        return view('recipes.create');
    }

    /**
     * Store a newly created recipe in storage.
     * Method ini akan dipanggil saat form "New Recipe" di-submit.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'recipe_title' => 'required|string|max:255',
            'description' => 'nullable|string', // Asumsi Anda menambahkan field ini di form
            'ingredients' => 'required|array',
            'ingredients.*' => 'nullable|string|max:255', // Validasi setiap item dalam array ingredients
            'direction' => 'required|string',
            'cooking_duration_value' => 'nullable|numeric|min:0',
            'cooking_duration_unit' => 'nullable|string|max:50',
            // 'categories' => 'nullable|array', // Aktifkan jika Anda menghandle kategori
            // 'categories.*' => 'integer|exists:categories,id', // Contoh validasi untuk kategori
            'file_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('file_upload') && $request->file('file_upload')->isValid()) {
            // Simpan gambar ke storage/app/public/recipes
            // Nama file akan digenerate unik oleh Laravel
            $imagePath = $request->file('file_upload')->store('recipes', 'public');
        } else {

        }

        // Siapkan data untuk disimpan
        $recipeData = [
            'user_id' => Auth::id(),
            'title' => $validatedData['recipe_title'],
            'description' => $validatedData['description'] ?? '',
            'ingredients' => $validatedData['ingredients'], // Akan di-cast ke JSON oleh model jika $casts diset
            'directions' => $validatedData['direction'],
            'image_path' => $imagePath,
        ];

        if (!empty($validatedData['cooking_duration_value']) && !empty($validatedData['cooking_duration_unit'])) {
            $recipeData['cooking_duration'] = $validatedData['cooking_duration_value'] . ' ' . $validatedData['cooking_duration_unit'];
        } else {
            $recipeData['cooking_duration'] = null;
        }

        // Buat dan simpan resep baru menggunakan mass assignment
        $recipe = Recipe::create($recipeData);

        // Jika Anda menghandle kategori dengan relasi many-to-many (misalnya menggunakan tabel pivot)
        // if (!empty($validatedData['categories'])) {
        //     $recipe->categories()->sync($validatedData['categories']); // $validatedData['categories'] harus berisi array ID kategori
        // }

        // Redirect pengguna ke halaman "My Recipe" dengan pesan sukses
        return redirect()->route('my-recipes')->with('success', 'Recipe created successfully!');
    }

    /**
     * Display the specified recipe.
     * Method ini untuk menampilkan detail satu resep.
     * Menggunakan Route Model Binding: Laravel akan otomatis mencari Recipe berdasarkan ID di URL.
     */
    public function show(Recipe $recipe): View // Type-hinting Recipe $recipe untuk Route Model Binding
    {
        // $recipe sudah berisi instance Model Recipe yang sesuai dengan ID dari URL.
        // Jika Anda perlu memuat relasi tambahan (misalnya user yang membuat, atau review):
        // $recipe->load('user', 'reviews'); // Asumsi ada relasi 'reviews' di model Recipe

        // Pastikan Anda memiliki view 'recipes.show.blade.php'
        return view('user.my-recipes', ['recipes' => $recipes]);
    }

    // Anda bisa menambahkan method lain di sini seperti edit(), update(), destroy() nantinya.
}