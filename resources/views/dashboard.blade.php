@extends('layouts.app') {{-- Menggunakan layout utama aplikasi --}}

@section('content')
<div class="py-8"> {{-- Padding atas dan bawah untuk seluruh konten dashboard --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Baris untuk Tabs (All, Popular) dan Filter/Sort --}}
        {{-- BAGIAN INI TETAP SAMA SEPERTI KODE ANDA --}}
        <div class="flex justify-between items-center mb-6">
            {{-- Tabs --}}
            <div class="flex space-x-1 border border-gray-300 rounded-md p-1 bg-gray-100">
                <a href="#" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    All
                </a>
                <a href="#" class="px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-md hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Popular
                </a>
                {{-- Tambahkan tab lain jika perlu --}}
            </div>

            {{-- Filter dan Sort --}}
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <select class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded-md leading-tight focus:outline-none focus:bg-white focus:border-gray-500 text-sm">
                        <option>Sort by: Rating</option>
                        <option>Sort by: Newest</option>
                        <option>Sort by: Popularity</option>
                    </select>
                </div>
            </div>
        </div>
        {{-- AKHIR BAGIAN TABS DAN FILTER --}}

        {{-- Judul untuk bagian resep (bisa Anda sesuaikan) --}}
        {{-- Anda bisa mempertahankan loop kategori jika controller mengirim data $categories --}}
        {{-- Untuk contoh ini, saya akan menampilkan satu bagian "Discover Recipes" --}}
        <div class="mb-10">
            <h2 class="text-2xl font-semibold mb-6 text-center text-recipe-category-title text-[#3DA0A7]">Discover Recipes</h2>

            {{-- Cek apakah ada resep yang dikirim dari controller --}}
            @if(isset($recipes) && $recipes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Loop untuk setiap resep --}}
                    @foreach ($recipes as $recipe)
                        {{-- KARTU RESEP UNTUK DASHBOARD (Mirip desain awal Anda) --}}
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col font-poppins">
                            {{-- Bagian Gambar --}}
                            <div class="w-full h-48 bg-gray-200">
                                @if($recipe->image_path)
                                    <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            {{-- Bagian Konten Teks --}}
                            <div class="p-5 flex flex-col flex-grow bg-recipe-content"> {{-- Menggunakan class .bg-recipe-content --}}
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate" title="{{ $recipe->title }}">
                                    {{ $recipe->title }}
                                </h3>
                                <p class="text-gray-700 text-sm mb-2 flex-grow leading-relaxed h-16 overflow-hidden">
                                    {{ Str::limit($recipe->description ?? 'No description available.', 100) }}
                                </p>

                                 @if ($recipe->user) {{-- Cek jika relasi user ada (seharusnya selalu ada) --}}
                                    <p class="text-xs text-gray-700 mb-1">
                                        By: <span class="font-medium">{{ $recipe->user->name }}</span> {{-- Asumsi kolom nama di tabel users adalah 'name' --}}
                                    </p>
                                @endif

                                {{-- Rating Bintang --}}
                                <div class="flex items-center mb-4">
                                    @php
                                        // Anda perlu logika untuk mendapatkan rating dari $recipe
                                        // Misalnya, jika ada kolom 'average_rating' atau relasi ke reviews
                                        $rating = $recipe->average_rating ?? rand(3, 5); // Contoh: ambil dari db atau random
                                        $reviewCount = $recipe->reviews_count ?? rand(5,50); // Contoh jumlah review
                                    @endphp
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 {{ $i < $rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    @if($reviewCount > 0)
                                    <span class="ml-2 text-xs text-gray-600">({{ $reviewCount }} reviews)</span>
                                    @endif
                                </div>

                                <a href="{{ route('recipes.show', $recipe->id) }}" class="mt-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 bg-view-details-button bg-[#3DA0A7]"> {{-- Menggunakan class .bg-view-details-button --}}
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        {{-- AKHIR KARTU RESEP --}}
                    @endforeach
                </div>
            @else
                {{-- Pesan jika tidak ada resep --}}
                <div class="text-center py-10">
                    <h3 class="mt-2 text-lg font-medium text-gray-500">No Recipes Found!</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        It looks like there are no recipes here yet.
                        @auth {{-- Tampilkan link ini hanya jika user login --}}
                        <a href="{{ route('recipes.create') }}" class="text-[#3DA0A7] hover:underline font-medium">Be the first to add one!</a>
                        @endauth
                    </p>
                </div>
            @endif
        </div> {{-- Penutup untuk div .mb-10 --}}

    </div>
</div>
@endsection

@push('styles')
{{-- CSS kustom yang sudah Anda definisikan sebelumnya --}}
<style>
    .font-poppins {
        font-family: 'Poppins', sans-serif;
    }
    .text-recipe-category-title { /* Untuk judul seperti "Discover Recipes" */
        color: #16666B;
    }
    .bg-recipe-content { /* Untuk latar belakang area teks kartu, warna: #9BCFD2 */
        background-color: #9BCFD2;
    }
    .bg-view-details-button { /* Untuk tombol "View Details", warna: #16666B */
        background-color: #16666B;
    }
</style>
@endpush