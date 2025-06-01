@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        @if($recipe->image_path)
            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-64 object-cover">
        @else
            <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">No Image Available</span>
            </div>
        @endif

        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ $recipe->title }}</h1>

            @if($recipe->user) {{-- Jika relasi user dimuat --}}
                <p class="text-sm text-gray-600 mb-4">By: {{ $recipe->user->name }}</p>
            @endif

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Description</h2>
                <p class="text-gray-600 leading-relaxed">{{ $recipe->description ?? 'No description provided.' }}</p>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Ingredients</h2>
                <ul class="list-disc list-inside text-gray-600">
                    @foreach(is_array($recipe->ingredients) ? $recipe->ingredients : json_decode($recipe->ingredients, true) ?? [] as $ingredient)
                        <li>{{ $ingredient }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Directions</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $recipe->directions }}</p>
            </div>

            @if($recipe->cooking_duration)
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Cooking Duration</h2>
                <p class="text-gray-600">{{ $recipe->cooking_duration }}</p>
            </div>
            @endif

            {{-- Tombol Aksi untuk Pemilik Resep --}}
            @auth
                @if(Auth::id() === $recipe->user_id)
                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Recipe
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Recipe
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
             <div class="mt-6">
                <a href="{{ url()->previous() }}" class="text-indigo-600 hover:text-indigo-800">&laquo; Back</a>
            </div>
        </div>
    </div>
</div>
@endsection