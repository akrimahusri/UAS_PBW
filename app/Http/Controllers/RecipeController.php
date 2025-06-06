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
    
    public function index(): View
    {
        $recipes = Auth::user()->recipes()->withCount(['likedByUsers', 'savedByUsers'])->latest()->get();
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
            'categories' => 'nullable|array', 
            'categories.*' => 'nullable|string',
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
            'categories' => $validatedData['categories'] ?? null,
        ];

        if (!empty($validatedData['cooking_duration_value']) && !empty($validatedData['cooking_duration_unit'])) {
            $recipeData['cooking_duration'] = $validatedData['cooking_duration_value'] . ' ' . $validatedData['cooking_duration_unit'];
        } else {
            $recipeData['cooking_duration'] = null;
        }

        Recipe::create($recipeData);

        return redirect()->route('my-recipes')->with('success', 'Recipe created successfully!');
    }


   public function show(Recipe $recipe): View
    {
        $recipe->load(['user', 'reviews' => function ($query) {
            $query->with('user')->latest(); // Muat user dari review, urutkan review terbaru
        }]);
        $isLiked = Auth::check() ? Auth::user()->likedRecipes->contains($recipe->id) : false;
        $isSaved = Auth::check() ? Auth::user()->savedRecipes->contains($recipe->id) : false;
        $likeCount = $recipe->likedByUsers()->count();
        $saveCount = $recipe->savedByUsers()->count();

        return view('recipes.show', [
            'recipe' => $recipe,
            'isLiked' => $isLiked,
            'isSaved' => $isSaved,
            'likeCount' => $likeCount,
            'saveCount' => $saveCount,
        ]);
    }

    /**
     *  (Form UPDATE)
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
            'categories' => 'nullable|array',
            'categories.*' => 'nullable|string',
            'file_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar opsional saat update
        ]);

        $recipeData = [
            'title' => $validatedData['recipe_title'],
            'description' => $validatedData['description'] ?? '',
            'ingredients' => $validatedData['ingredients'],
            'directions' => $validatedData['direction'],
            'categories' => $validatedData['categories'] ?? $recipe->categories,
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

        $recipe->update($recipeData);

        return redirect()->route('my-recipes')->with('success', 'Recipe updated successfully!');
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

    public function like(Recipe $recipe): RedirectResponse
    {
        $user = Auth::user();
        if (!$user->likedRecipes()->where('recipe_id', $recipe->id)->exists()) {
            $user->likedRecipes()->attach($recipe->id);
            return back()->with('success', 'Recipe liked!');
        }
        return back()->with('info', 'You already liked this recipe.');
    }

    public function unlike(Recipe $recipe): RedirectResponse
    {
        $user = Auth::user();
        $user->likedRecipes()->detach($recipe->id);
        return back()->with('success', 'Recipe unliked!');
    }

    public function save(Recipe $recipe): RedirectResponse
    {
        $user = Auth::user();
        if (!$user->savedRecipes()->where('recipe_id', $recipe->id)->exists()) {
            $user->savedRecipes()->attach($recipe->id);
            return back()->with('success', 'Recipe saved!');
        }
        return back()->with('info', 'You already saved this recipe.');
    }

    public function unsave(Recipe $recipe): RedirectResponse
    {
        $user = Auth::user();
        $user->savedRecipes()->detach($recipe->id);
        return back()->with('success', 'Recipe unsaved!');
    }

    public function likedRecipes(): View
    {
        $recipes = Auth::user()->likedRecipes()->with('user')->latest()->get(); //
        return view('user.liked-recipes', ['recipes' => $recipes]);
    }

    public function savedRecipes(): View
    {
        $recipes = Auth::user()->savedRecipes()->with('user')->latest()->get(); //
        return view('user.saved-recipes', ['recipes' => $recipes]);
    }
}