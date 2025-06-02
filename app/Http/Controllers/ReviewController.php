<?php // app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View; // Tambahkan ini

class ReviewController extends Controller
{
    // Method store yang sudah ada (pastikan dd() dihapus setelah debug)
    public function store(Request $request, Recipe $recipe): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'review_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($recipe->user_id == Auth::id()) {
            return back()->with('error', 'You cannot review your own recipe.');
        }

        $existingReview = Review::where('recipe_id', $recipe->id)
                                ->where('user_id', Auth::id())
                                ->first();
        if ($existingReview) {
            // Jika ingin user bisa update reviewnya, arahkan ke edit atau beri pesan berbeda
            // Untuk sekarang, kita anggap hanya bisa review sekali.
            return back()->with('error', 'You have already reviewed this recipe.');
        }

        $imagePath = null;
        if ($request->hasFile('review_image') && $request->file('review_image')->isValid()) {
            $imagePath = $request->file('review_image')->store('reviews', 'public');
        }

        Review::create([
            'recipe_id' => $recipe->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('recipes.show', $recipe)->with('success', 'Thank you for your review!');
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review): View
    {
        // Pastikan user yang login adalah pemilik review
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Unauthorized action.');
        }
        // Kita butuh recipe untuk link kembali dan konteks
        $recipe = $review->recipe;

        return view('reviews.edit', compact('review', 'recipe'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review): RedirectResponse
    {
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'review_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_review_image' => 'nullable|boolean', // Checkbox untuk hapus gambar
        ]);

        $reviewData = [
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        // Handle penghapusan gambar jika dicentang
        if ($request->boolean('remove_review_image') && $review->image_path) {
            Storage::disk('public')->delete($review->image_path);
            $reviewData['image_path'] = null;
        }

        // Handle upload gambar baru jika ada (dan tidak dicentang hapus)
        if ($request->hasFile('review_image') && $request->file('review_image')->isValid() && !$request->boolean('remove_review_image')) {
            // Hapus gambar lama jika ada
            if ($review->image_path) {
                Storage::disk('public')->delete($review->image_path);
            }
            $reviewData['image_path'] = $request->file('review_image')->store('reviews', 'public');
        }

        $review->update($reviewData);

        return redirect()->route('recipes.show', $review->recipe_id)->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Simpan recipe_id untuk redirect sebelum review dihapus
        $recipeId = $review->recipe_id;

        // Hapus gambar dari storage jika ada
        if ($review->image_path) {
            Storage::disk('public')->delete($review->image_path);
        }

        $review->delete();

        return redirect()->route('recipes.show', $recipeId)->with('success', 'Review deleted successfully!');
    }
}


