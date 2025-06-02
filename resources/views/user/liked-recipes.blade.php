@extends('layouts.app')

@section('content')
<div class="w-full bg-white flex flex-col min-h-screen">
    <div class="px-6 md:px-10 py-3 border-b border-gray-200 flex justify-end items-center">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Liked Recipes</h1>
    </div>

    <div class="flex-grow p-6 md:p-10 flex flex-col">
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

        @if($recipes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-6">
                @foreach($recipes as $recipe)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                    @if($recipe->image_path)
                        <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    <div class="p-5 flex-grow" style="background-color: #9BCFD2;">
                        <h3 class="text-xl font-bold text-slate-700 mb-1 truncate" title="{{ $recipe->title }}">
                            {{ $recipe->title }}
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed h-16 overflow-hidden">
                            {{ Str::limit($recipe->description ?? 'No description available.', 80) }}
                        </p>
                        @if ($recipe->user)
                            <p class="text-xs text-gray-700 mt-2">
                                By: <span class="font-medium">{{ $recipe->user->name }}</span>
                            </p>
                        @endif
                    </div>

                    <div class="p-3 flex justify-end space-x-2" style="background-color: #AED5D6; border-top: 1px solid rgba(255,255,255,0.5);">
                        <a href="{{ route('recipes.show', $recipe->id) }}" class="text-xs bg-slate-700 text-white py-1.5 px-3 rounded-md hover:bg-slate-600 transition-colors">View Details</a>
                        <form action="{{ route('recipes.unlike', $recipe->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs bg-red-500 text-white py-1.5 px-3 rounded-md hover:bg-red-600 transition-colors">Unlike</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="flex-grow flex flex-col items-center justify-center text-center mt-6">
                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <p class="text-xl text-gray-400">No liked recipes yet.</p>
                <p class="mt-2 text-sm text-gray-500">
                    Explore the <a href="{{ route('dashboard') }}" class="text-[#3DA0A7] hover:underline font-medium">dashboard</a> to find recipes you love!
                </p>
            </div>
        @endif
    </div>
</div>
@endsection