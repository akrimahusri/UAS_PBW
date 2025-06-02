@extends('layouts.app')

@section('content')

{{-- Wrapper utama untuk konten halaman "My Recipe" --}}
<div class="w-full bg-white flex flex-col min-h-screen">

    {{-- Bagian Header Halaman (Judul "My Recipe") --}}
    <div class="px-6 md:px-10 py-3 border-b border-gray-200 flex justify-end items-center">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">My Recipe</h1>
    </div>

    {{-- Konten Utama Halaman --}}
    <div class="flex-grow p-6 md:p-10 flex flex-col">

        {{-- Pesan Selamat Datang --}}
        <div class="mb-10 md:mb-12">
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">
                Hello, <span class="text-[#3DA0A7]">{{ Auth::user()->name }}</span> 👋
            </p>
            <p class="text-gray-500 text-base md:text-lg">
                Got a recipe to share? Start building your flavor legacy today.
            </p> <br>
            <a href="{{ route('recipes.create') }}" class="inline-block bg-[#3DA0A7] text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:bg-[#328c92] focus:outline-none focus:ring-2 focus:ring-[#3DA0A7] focus:ring-offset-2 transition-colors duration-150 text-sm">
                Create New Recipe
            </a>
        </div>

        <hr class="my-4 border-gray-200">

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md shadow">
                {{ session('success') }}
            </div>
        @endif
        @if(session('info'))
            <div class="mb-6 p-4 bg-blue-100 text-blue-700 rounded-md shadow">
                {{ session('info') }}
            </div>
        @endif

        @if(isset($recipes) && $recipes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-6">
                @foreach($recipes as $recipe)
                {{-- Kontainer Kartu Utama --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                    
                    {{-- 1. BAGIAN GAMBAR --}}
                    <div class="w-full"> {{-- Pastikan wrapper gambar mengambil lebar penuh --}}
                        @if($recipe->image_path)
                            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>

                    {{-- 2. BAGIAN KONTEN TEKS --}}
                    <div class="w-full p-5" style="background-color: #9BCFD2;"> {{-- Pastikan wrapper konten teks mengambil lebar penuh --}}
                        <h3 class="text-xl font-bold text-slate-700 mb-1 truncate" title="{{ $recipe->title }}">
                            {{ $recipe->title }}
                        </h3>
                        
                        <div class="h-16 overflow-hidden">
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ Str::limit($recipe->description ?? 'No description available.', 100) }} {{-- Meningkatkan limit sedikit jika h-16 memungkinkan --}}
                            </p>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-600 mt-2">
                            <span class="mr-3 flex items-center">
                                <svg class="w-4 h-4 inline-block mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                {{ $recipe->liked_by_users_count ?? 0 }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 inline-block mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2H5zm0 2h10v6H5V6zm4 2a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm1 3a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z"></path></svg>
                                {{ $recipe->saved_by_users_count ?? 0 }}
                            </span>
                        </div>
                    </div>

                    {{-- 3. BAGIAN TOMBOL AKSI --}}
                    <div class="w-full p-3 flex justify-end space-x-2" style="background-color: #AED5D6; border-top: 1px solid rgba(255,255,255,0.5);"> {{-- Pastikan wrapper tombol aksi mengambil lebar penuh --}}
                        <a href="{{ route('recipes.show', $recipe->id) }}" class="text-xs bg-slate-700 text-white py-1.5 px-3 rounded-md hover:bg-slate-600 transition-colors">View</a>
                        {{-- 
                        <a href="{{ route('recipes.edit', $recipe->id) }}" class="text-xs bg-yellow-500 text-white py-1.5 px-3 rounded-md hover:bg-yellow-600 transition-colors">Edit</a>
                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs bg-red-500 text-white py-1.5 px-3 rounded-md hover:bg-red-600 transition-colors">Delete</button>
                        </form>
                        --}}
                    </div>
                </div>
                @endforeach
            </div>
        @else
            {{-- Pesan jika tidak ada resep --}}
            <div class="flex-grow flex flex-col items-center justify-center text-center mt-6">
                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <p class="text-xl text-gray-400">Nothing here yet.</p>
                <p class="mt-2 text-sm text-gray-500">
                    You haven't added any recipes. Why not <a href="{{ route('recipes.create') }}" class="text-[#3DA0A7] hover:underline font-medium">create your first one</a>?
                </p>
            </div>
        @endif
    </div>
</div>
@endsection