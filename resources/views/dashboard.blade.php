@extends('layouts.app') {{-- Menggunakan layout utama aplikasi --}}

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- HAPUS TOMBOL INI DARI SINI --}}
        {{-- <div class="mb-4 flex justify-start">
            <button @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center px-4 py-2 bg-gray-800 ...">
                Navigation
            </button>
        </div> --}}

        {{-- Baris untuk Tabs (All, Popular) dan Filter/Sort --}}
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
                <button class="p-2 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L13 10.414V15a1 1 0 01-.293.707l-2 2A1 1 0 019 17v-1.586L4.293 6.707A1 1 0 014 6V3z" />
                    </svg>
                </button>
                <div class="relative">
                    <select class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded-md leading-tight focus:outline-none focus:bg-white focus:border-gray-500 text-sm">
                        <option>Sort by: Rating</option>
                        <option>Sort by: Newest</option>
                        <option>Sort by: Popularity</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Resep Dummy (Nanti bisa diganti dengan data dari Controller) --}}
        @php
            $categories = [
                [
                    'name' => 'Simple Breakfast',
                    'recipes' => [
                        [
                            'image' => asset('images/placeholder/waffles.jpg'),
                            'title' => 'Waffles',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 5
                        ],
                        [
                            'image' => asset('images/placeholder/pancakes.jpg'),
                            'title' => 'Pancakes',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 4
                        ],
                        [
                            'image' => asset('images/placeholder/chocolate.jpg'),
                            'title' => 'Hot Chocolate',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 5
                        ],
                    ]
                ],
                // ... (kategori lainnya seperti yang sudah ada di file Anda)
                 [
                    'name' => 'Simple Lunch',
                    'recipes' => [
                         [
                            'image' => asset('images/placeholder/waffles.jpg'),
                            'title' => 'Waffles Lunch',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 5
                        ],
                        [
                            'image' => asset('images/placeholder/pancakes.jpg'),
                            'title' => 'Pancakes Lunch',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 4
                        ],
                        [
                            'image' => asset('images/placeholder/chocolate.jpg'),
                            'title' => 'Hot Chocolate Lunch',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 5
                        ],
                    ]
                ],
                 [
                    'name' => 'Simple Dinner',
                    'recipes' => [
                         [
                            'image' => asset('images/placeholder/waffles.jpg'),
                            'title' => 'Waffles Dinner',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 5
                        ],
                        [
                            'image' => asset('images/placeholder/pancakes.jpg'),
                            'title' => 'Pancakes Dinner',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 4
                        ],
                        [
                            'image' => asset('images/placeholder/chocolate.jpg'),
                            'title' => 'Hot Chocolate Dinner',
                            'description' => 'A recipe that\'s great to eat in the morning',
                            'rating' => 5
                        ],
                    ]
                ],
            ];
        @endphp

        {{-- Loop untuk setiap kategori resep --}}
        @foreach ($categories as $category)
            <div class="mb-10"> {{-- Jarak antar section kategori --}}
                <h2 class="text-2xl font-semibold mb-6 text-center" style="color: #16666B;">{{ $category['name'] }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Loop untuk setiap resep dalam kategori --}}
                    @foreach ($category['recipes'] as $recipe)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col" style="font-family: 'Poppins', sans-serif;">
                            {{-- Bagian Gambar --}}
                            <div class="w-full h-48 bg-gray-700">
                                <img src="{{ $recipe['image'] }}" alt="{{ $recipe['title'] }}" class="w-full h-full object-cover">
                            </div>
                            {{-- Bagian Konten Teks --}}
                            <div class="p-6 flex flex-col flex-grow" style="background-color: #9BCFD2;">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $recipe['title'] }}</h3>
                                <p class="text-gray-700 text-sm mb-3 flex-grow">{{ $recipe['description'] }}</p>
                                
                                {{-- Rating Bintang --}}
                                <div class="flex items-center mb-4">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 {{ $i < $recipe['rating'] ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>

                                <a href="#" class="mt-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2" style="background-color: #16666B;">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection

@push('styles')
{{-- Jika butuh CSS tambahan yang tidak bisa dengan Tailwind/inline --}}
<style>
    /* Contoh: Pastikan Poppins sudah di-load di layout utama */
    /* body { font-family: 'Poppins', sans-serif; } */
</style>
@endpush