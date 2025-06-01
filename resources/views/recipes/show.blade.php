@extends('layouts.app') {{-- Menggunakan layout utama --}}Add commentMore actions

@section('content')
<div class="font-poppins"> {{-- Menggunakan font Poppins untuk konsistensi --}}

    {{-- Hero Section dengan Gambar Resep --}}
    <section class="relative h-80 md:h-96 bg-gray-700">
        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white text-center px-4">{{ $recipe->name }}</h1>
        </div>
    </section>

    {{-- Konten Utama (Ingredients, Directions, Reviews) dan Sidebar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:flex lg:space-x-8">

            {{-- Kolom Kiri (Konten Utama) --}}
            <div class="lg:w-2/3">
                {{-- Ingredients --}}
                <div class="mb-8 p-6 bg-white rounded-lg shadow">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ingredients</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        @foreach ($recipe->ingredients as $ingredient)
                            <li>{{ $ingredient }}</li>
                        @endforeach
                    </ul>
                </div>

                {{-- Directions --}}
                <div class="mb-8 p-6 bg-white rounded-lg shadow">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Directions</h2>
                    <ol class="list-decimal list-inside text-gray-700 space-y-2">
                        @foreach ($recipe->directions as $direction)
                            <li>{{ $direction }}</li>
                        @endforeach
                    </ol>
                </div>

                {{-- Reviews Section --}}
                <div class="mb-8 p-6 bg-white rounded-lg shadow">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ count($recipe->reviews) }} Reviews</h2>
                    <div class="space-y-6">
                        @forelse ($recipe->reviews as $review)
                            <div class="flex space-x-4">
                                <img src="{{ $review->user_avatar ?? asset('images/placeholder/avatar.png') }}" alt="{{ $review->user_name }}" class="h-12 w-12 rounded-full object-cover">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-semibold text-gray-800">{{ $review->user_name }}</h3>
                                        {{-- Rating Bintang untuk review individual --}}
                                        <div class="flex items-center">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="w-4 h-4 {{ $i < $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mt-1 text-sm">{{ $review->text }}</p>
                                    {{-- Gambar-gambar review jika ada --}}
                                    @if (!empty($review->images))
                                        <div class="mt-3 flex space-x-2">
                                            @foreach ($review->images as $img)
                                                <img src="{{ $img }}" alt="Review image" class="h-20 w-20 rounded object-cover">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600">No reviews yet. Be the first to write one!</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan (Sidebar Aksi) --}}
            <div class="lg:w-1/3 space-y-6 sticky top-8"> {{-- sticky dan top-8 agar sidebar "mengambang" saat scroll --}}
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex justify-around items-center mb-4">
                        {{-- Tombol Like/Favorite --}}
                        <button title="Like" class="text-gray-500 hover:text-red-500 {{ $recipe->is_liked_by_user ? 'text-red-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        {{-- Tombol Share --}}
                        <button title="Share" class="text-gray-500 hover:text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12s-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                            </svg>
                        </button>
                        {{-- Tombol Bookmark --}}
                        <button title="Bookmark" class="text-gray-500 hover:text-yellow-500 {{ $recipe->is_bookmarked_by_user ? 'text-yellow-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-3.13L5 18V4z" />
                            </svg>
                        </button>
                    </div>
                    {{-- Rating Keseluruhan --}}
                    <div class="flex items-center justify-center text-center">
                        <div class="flex">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-6 h-6 {{ $i < floor($recipe->overall_rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="ml-2 text-xl font-semibold text-gray-700">{{ number_format($recipe->overall_rating, 1) }}</span>
                        <span class="ml-1 text-gray-500">({{ $recipe->rating_count }})</span>
                    </div>
                </div>

                {{-- Tombol "Write a Review" --}}
                @auth
                <div class="mt-6 text-right">
                    <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Write a review
                    </a>
                </div>
                @else
                <div class="mt-6 text-right">
                     <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-500 hover:bg-gray-600">
                        Login to write a review
                    </a>
                </div>
                @endauth

            </div> {{-- End Sidebar --}}
        </div> {{-- End Flex Container --}}
    </div> {{-- End Max Width Container --}}
</div>
@endsection

@push('styles')
<style>
    /* Pastikan Poppins sudah di-load di layout utama, atau uncomment ini */
    /* .font-poppins { font-family: 'Poppins', sans-serif; } */

    /* Untuk membuat sidebar sticky (jika diperlukan dan Tailwind sticky tidak cukup) */
    /* .sticky { position: -webkit-sticky; position: sticky; } */
</style>
@endpush