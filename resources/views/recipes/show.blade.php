@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8 font-poppins">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        {{-- GAMBAR RESEP --}}
        @if($recipe->image_path)
            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-64 md:h-80 object-cover">
        @else
            <div class="w-full h-64 md:h-80 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">No Image Available</span>
            </div>
        @endif

        {{-- KONTEN UTAMA RESEP --}}
        <div class="p-6 md:p-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-2 text-gray-800">{{ $recipe->title }}</h1>

            @if($recipe->user)
                <p class="text-sm text-gray-600 mb-4">By: <span class="font-semibold">{{ $recipe->user->name }}</span></p>
            @endif

            {{-- Tampilkan jumlah likes dan saves --}}
            <div class="flex items-center text-sm text-gray-600 mb-4">
                <span class="mr-4 flex items-center">
                    <svg class="w-5 h-5 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    {{ $likeCount }} Likes
                </span>
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2H5zm0 2h10v6H5V6zm4 2a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm1 3a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z"></path></svg>
                    {{ $saveCount }} Saves
                </span>
            </div>

            {{-- Tombol Like/Unlike dan Save/Unsave (hanya jika user login dan bukan pemilik resep) --}}
            @auth
                @if(Auth::id() !== $recipe->user_id)
                    <div class="mt-4 flex space-x-3">
                        @if($isLiked)
                            <form action="{{ route('recipes.unlike', $recipe) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full text-sm">
                                    Unlike
                                </button>
                            </form>
                        @else
                            <form action="{{ route('recipes.like', $recipe) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-gray-200 hover:bg-red-100 text-red-600 border border-red-300 font-bold py-2 px-4 rounded-full text-sm">
                                    Like
                                </button>
                            </form>
                        @endif

                        @if($isSaved)
                            <form action="{{ route('recipes.unsave', $recipe) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full text-sm">
                                    Unsave
                                </button>
                            </form>
                        @else
                            <form action="{{ route('recipes.save', $recipe) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-gray-200 hover:bg-blue-100 text-blue-600 border border-blue-300 font-bold py-2 px-4 rounded-full text-sm">
                                    Save
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            @endauth

            {{-- KATEGORI --}}
            @if($recipe->categories && count($recipe->categories) > 0)
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Categories</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($recipe->categories as $category)
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-medium rounded-full">{{ $category }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- DESKRIPSI --}}
            @if($recipe->description)
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Description</h2>
                <p class="text-gray-600 leading-relaxed">{{ $recipe->description }}</p>
            </div>
            @endif

            {{-- INGREDIENTS --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Ingredients</h2>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    @foreach(is_array($recipe->ingredients) ? $recipe->ingredients : json_decode($recipe->ingredients, true) ?? [] as $ingredient)
                        <li>{{ $ingredient }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- DIRECTIONS --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Directions</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $recipe->directions }}</p>
            </div>

            {{-- COOKING DURATION --}}
            @if($recipe->cooking_duration)
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Cooking Duration</h2>
                <p class="text-gray-600">{{ $recipe->cooking_duration }}</p>
            </div>
            @endif

            {{-- Tombol Aksi untuk Pemilik Resep --}}
            @auth
                @if(Auth::id() === $recipe->user_id)
                    <div class="mt-8 mb-4 flex space-x-4">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            Edit Recipe
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Delete Recipe
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div> 

        {{-- BAGIAN REVIEW --}}
        <div class="p-6 md:p-8 border-t border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Reviews</h2>
            {{-- Rata-rata Rating & Jumlah Review --}}
            <div class="mb-8 flex items-center">
                 @if($recipe->reviews_count > 0)
                    @php $avgRating = round($recipe->average_rating); @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    @endfor
                    <span class="ml-2 text-sm text-gray-600">({{ number_format($recipe->average_rating, 1) }} out of 5 | {{ $recipe->reviews_count }} {{ Str::plural('review', $recipe->reviews_count) }})</span>
                @else
                    <p class="text-sm text-gray-500">No reviews yet. Be the first to review!</p>
                @endif
            </div>

            {{-- FORM TAMBAH REVIEW --}}
            @auth
                 @if(Auth::id() !== $recipe->user_id && !$recipe->reviews()->where('user_id', Auth::id())->exists())
                    <div class="mb-8 p-4 border border-gray-200 rounded-lg bg-slate-50">
                        <h3 class="text-xl font-semibold text-gray-700 mb-3">Write your review</h3>
                        <form action="{{ route('reviews.store', $recipe) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                               
                                <div class="flex flex-row-reverse justify-end" id="star-rating">
                                    @for ($s = 5; $s >= 1; $s--)
                                    <label for="rating{{ $s }}" class="cursor-pointer p-1">
                                        <input type="radio" name="rating" id="rating{{ $s }}" value="{{ $s }}" class="sr-only peer" {{ old('rating') == $s ? 'checked' : '' }} required>
                                        <svg class="w-7 h-7 text-gray-300 peer-hover:text-yellow-300 peer-checked:text-yellow-400 transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                    @endfor
                                </div>
                                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700">Write your review here!</label>
                                <textarea name="comment" id="comment" rows="4" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="A simple and tasty waffle recipe...">{{ old('comment') }}</textarea>
                                @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="review_image" class="block text-sm font-medium text-gray-700">Upload foto (Optional)</label>
                                <div class="mt-1">
                                    <input type="file" name="review_image" id="review_image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                 @error('review_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#008080] hover:bg-[#006666] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#008080]">
                                Submit Review
                            </button>
                        </form>
                    </div>
                @elseif(Auth::id() === $recipe->user_id)
                    <p class="mb-8 text-sm text-gray-500 italic">You cannot review your own recipe.</p>
                @elseif($recipe->reviews()->where('user_id', Auth::id())->exists())
                     <p class="mb-8 text-sm text-gray-500 italic">You have already reviewed this recipe.</p>
                @endif
            @else
                <p class="mb-8 text-sm text-gray-500">Please <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">login</a> to write a review.</p>
            @endauth

            {{-- DAFTAR REVIEW YANG SUDAH ADA --}}
            <div class="space-y-6">
                 @forelse ($recipe->reviews as $review)
                    <div class="p-4 border rounded-lg {{ $loop->first && !$errors->any() ? 'bg-gray-50' : '' }}">
                        <div class="flex items-start mb-2">
                            <div class="flex-grow">
                                <div class="flex items-center">
                                    @for ($k = 1; $k <= 5; $k++)
                                        <svg class="w-4 h-4 {{ $k <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                    <span class="ml-2 text-sm font-semibold text-gray-700">{{ $review->user->name ?? 'Anonymous' }}</span>
                                </div>
                                <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>

                            {{-- Tombol Aksi untuk Review --}}
                                @auth
                                    @if(Auth::id() === $review->user_id)
                                        <div class="ml-auto flex space-x-2 flex-shrink-0">
                                            {{-- Tombol Edit dengan SVG --}}
                                            <a href="{{ route('reviews.edit', $review) }}" class="text-xs text-blue-600 hover:text-blue-800" title="Edit Review">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            {{-- Tombol Delete dengan SVG (di dalam form) --}}
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:text-red-800" title="Delete Review">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                            @endauth
                        </div>
                        @if($review->comment)
                            <p class="text-gray-600 text-sm leading-relaxed bg-gray-100 p-3 rounded-md mt-2">{{ $review->comment }}</p>
                        @endif
                        @if($review->image_path)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $review->image_path) }}" alt="Review image by {{ $review->user->name ?? 'User' }}" class="max-w-xs max-h-48 rounded-md shadow">
                            </div>
                        @endif
                    </div>
                @empty
                    {{-- Tidak ada pesan di sini karena sudah ada di bagian rata-rata rating --}}
                @endforelse
            </div>
        </div> 

        {{-- LINK KEMBALI --}}
        <div class="p-6 md:p-8 border-t border-gray-200">
            <a href="{{ url()->previous() == url()->current() ? route('dashboard') : url()->previous() }}" class="text-indigo-600 hover:text-indigo-800">&laquo; Back</a>
        </div>
    </div> {{-- Penutup untuk div.max-w-2xl --}}
</div> 
@endsection 


@push('styles')
<style>
    #star-rating {
        
    }
    #star-rating label { 
        cursor: pointer;
    }
    
</style>
@endpush
