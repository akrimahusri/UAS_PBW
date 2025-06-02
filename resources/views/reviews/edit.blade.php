@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 font-poppins">
    <div class="max-w-lg mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Edit Your Review</h1>
        <p class="text-sm text-gray-600 mb-6">For recipe: <a href="{{ route('recipes.show', $recipe) }}" class="text-indigo-600 hover:underline">{{ $recipe->title }}</a></p>

        <form action="{{ route('reviews.update', $review) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Penting untuk request update --}}

            {{-- Rating Input (Bintang) --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                {{-- Menggunakan ID unik untuk kontainer bintang di halaman edit --}}
                <div class="flex flex-row-reverse justify-end" id="star-rating-edit">
                    @for ($i = 5; $i >= 1; $i--)
                    <label for="rating_edit_{{ $i }}" class="cursor-pointer p-1">
                        {{-- ID input juga unik --}}
                        <input type="radio" name="rating" id="rating_edit_{{ $i }}" value="{{ $i }}" class="sr-only peer"
                               {{ (old('rating', $review->rating) == $i) ? 'checked' : '' }} required>
                        <svg class="w-7 h-7 text-gray-300 peer-hover:text-yellow-300 peer-checked:text-yellow-400 transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </label>
                    @endfor
                </div>
                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Review Comment --}}
            <div class="mb-6">
                <label for="comment_edit" class="block text-sm font-medium text-gray-700">Your review</label>
                <textarea name="comment" id="comment_edit" rows="5" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Edit your review...">{{ old('comment', $review->comment) }}</textarea>
                @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Upload Foto untuk Review --}}
            <div class="mb-6">
                <label for="review_image_edit" class="block text-sm font-medium text-gray-700">Change photo (Optional)</label>
                <input type="file" name="review_image" id="review_image_edit" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @error('review_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                @if ($review->image_path)
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-1">Current photo:</p>
                    <img src="{{ asset('storage/' . $review->image_path) }}" alt="Current review image" class="max-w-xs max-h-40 rounded-md shadow">
                    <div class="mt-2">
                        <label for="remove_review_image" class="flex items-center text-sm text-red-600 cursor-pointer">
                            <input type="checkbox" name="remove_review_image" id="remove_review_image" value="1" class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500 mr-2">
                            Remove current photo
                        </label>
                    </div>
                </div>
                @endif
            </div>

            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('recipes.show', $review->recipe_id) }}" class="text-sm text-gray-600 hover:text-gray-900">&laquo; Cancel & Back to Recipe</a>
                <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#008080] hover:bg-[#006666] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#008080]">
                    Update Review
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- Style untuk bintang bisa diletakkan di app.css atau di push seperti ini --}}
@push('styles')
<style>
    
    #star-rating-edit {
        
    }
    #star-rating-edit label {
        cursor: pointer;
    }
    
</style>
@endpush
