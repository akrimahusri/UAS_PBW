<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Untuk menghapus file
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // Untuk type hinting redirect

class RecipeController extends Controller
{
    /**
     * Display a listing of the user's recipes.
     * Method ini untuk halaman "My Recipe".
     */
    public function index(): View
    {
        $recipes = Auth::user()->recipes()->latest()->get();
        return view('user.my-recipes', ['recipes' => $recipes]);
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create(): View
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created recipe in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'recipe_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array',
            'ingredients.*' => 'nullable|string|max:255',
            'direction' => 'required|string',
            'cooking_duration_value' => 'nullable|numeric|min:0',
            'cooking_duration_unit' => 'nullable|string|max:50',
            'file_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('file_upload') && $request->file('file_upload')->isValid()) {
            $imagePath = $request->file('file_upload')->store('recipes', 'public');
        }

        $recipeData = [
            'user_id' => Auth::id(),
            'title' => $validatedData['recipe_title'],
            'description' => $validatedData['description'] ?? '',
            'ingredients' => $validatedData['ingredients'],
            'directions' => $validatedData['direction'],
            'image_path' => $imagePath,
        ];

        if (!empty($validatedData['cooking_duration_value']) && !empty($validatedData['cooking_duration_unit'])) {
            $recipeData['cooking_duration'] = $validatedData['cooking_duration_value'] . ' ' . $validatedData['cooking_duration_unit'];
        } else {
            $recipeData['cooking_duration'] = null;
        }

        Recipe::create($recipeData);

        return redirect()->route('my-recipes')->with('success', 'Recipe created successfully!');
    }

    /**
     * Display the specified recipe. (READ DETAIL)
     * Route Model Binding: Laravel akan otomatis mencari Recipe berdasarkan ID di URL.
     */
    public function show(Recipe $recipe): View
    {
        // Anda bisa memuat relasi jika perlu, contoh:
        // $recipe->load('user'); // Memuat data user pembuat resep
        return view('recipes.show', ['recipe' => $recipe]);
    }

    /**
     * Show the form for editing the specified recipe. (Form UPDATE)
     */
    public function edit(Recipe $recipe): View
    {
        // Autorisasi: Pastikan user yang login adalah pemilik resep
        if (Auth::id() !== $recipe->user_id) {
            abort(403, 'Unauthorized action.'); // Atau redirect dengan pesan error
        }

        return view('recipes.edit', ['recipe' => $recipe]);
    }

    /**
     * Update the specified recipe in storage. (Proses UPDATE)
     */
    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        // Autorisasi: Pastikan user yang login adalah pemilik resep
        if (Auth::id() !== $recipe->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'recipe_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array',
            'ingredients.*' => 'nullable|string|max:255',
            'direction' => 'required|string',
            'cooking_duration_value' => 'nullable|numeric|min:0',
            'cooking_duration_unit' => 'nullable|string|max:50',
            'file_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar opsional saat update
        ]);

        $recipeData = [
            'title' => $validatedData['recipe_title'],
            'description' => $validatedData['description'] ?? '',
            'ingredients' => $validatedData['ingredients'],
            'directions' => $validatedData['direction'],
        ];

        if (!empty($validatedData['cooking_duration_value']) && !empty($validatedData['cooking_duration_unit'])) {
            $recipeData['cooking_duration'] = $validatedData['cooking_duration_value'] . ' ' . $validatedData['cooking_duration_unit'];
        } else {
            $recipeData['cooking_duration'] = $recipe->cooking_duration; // Pertahankan nilai lama jika tidak diisi
        }

        // Handle upload gambar jika ada gambar baru
        if ($request->hasFile('file_upload') && $request->file('file_upload')->isValid()) {
            // Hapus gambar lama jika ada
            if ($recipe->image_path) {
                Storage::disk('public')->delete($recipe->image_path);
            }
            // Simpan gambar baru
            $recipeData['image_path'] = $request->file('file_upload')->store('recipes', 'public');
        }
        // Jika tidak ada gambar baru diupload, image_path tidak diubah (mempertahankan gambar lama)

        $recipe->update($recipeData);

        return redirect()->route('my-recipes')->with('success', 'Recipe updated successfully!');
        // Atau redirect ke halaman detail resep:
        // return redirect()->route('recipes.show', $recipe)->with('success', 'Recipe updated successfully!');
    }

    /**
     * Remove the specified recipe from storage. (Proses DELETE)
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        // Autorisasi: Pastikan user yang login adalah pemilik resep
        if (Auth::id() !== $recipe->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus gambar dari storage jika ada
        if ($recipe->image_path) {
            Storage::disk('public')->delete($recipe->image_path);
        }

        $recipe->delete();

        return redirect()->route('my-recipes')->with('success', 'Recipe deleted successfully!');
    }
}