@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Edit Recipe: {{ $recipe->title }}</h1>

    <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        @csrf
        @method('PUT') 

        <div class="mb-4">
            <label for="recipe_title" class="block text-gray-700 text-sm font-bold mb-2">Recipe Title:</label>
            <input type="text" name="recipe_title" id="recipe_title" value="{{ old('recipe_title', $recipe->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            @error('recipe_title') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $recipe->description) }}</textarea>
            @error('description') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        {{-- Field untuk Ingredients  --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Ingredients (one per line):</label>
            <textarea name="ingredients_text" id="ingredients_text" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Flour&#10;Sugar&#10;Eggs">{{ old('ingredients_text', implode("\n", is_array($recipe->ingredients) ? $recipe->ingredients : (json_decode($recipe->ingredients, true) ?? []) )) }}</textarea>
            {{-- Hidden input untuk mengirim array --}}
            @foreach(is_array($recipe->ingredients) ? $recipe->ingredients : (json_decode($recipe->ingredients, true) ?? []) as $key => $ingredient)
                <input type="hidden" name="ingredients[{{ $key }}]" value="{{ $ingredient }}">
            @endforeach
            @error('ingredients') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
             @error('ingredients.*') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="direction" class="block text-gray-700 text-sm font-bold mb-2">Directions:</label>
            <textarea name="direction" id="direction" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('direction', $recipe->directions) }}</textarea>
            @error('direction') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        {{-- Cooking Duration --}}
        @php
            $durationParts = $recipe->cooking_duration ? explode(' ', $recipe->cooking_duration, 2) : [null, null];
            $durationValue = old('cooking_duration_value', $durationParts[0]);
            $durationUnit = old('cooking_duration_unit', $durationParts[1] ?? '');
        @endphp
        <div class="flex mb-4 space-x-2">
            <div class="w-1/2">
                <label for="cooking_duration_value" class="block text-gray-700 text-sm font-bold mb-2">Cooking Duration Value:</label>
                <input type="number" name="cooking_duration_value" id="cooking_duration_value" value="{{ $durationValue }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0">
            </div>
            <div class="w-1/2">
                <label for="cooking_duration_unit" class="block text-gray-700 text-sm font-bold mb-2">Unit (e.g., minutes, hours):</label>
                <input type="text" name="cooking_duration_unit" id="cooking_duration_unit" value="{{ $durationUnit }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>
        @error('cooking_duration_value') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        @error('cooking_duration_unit') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror


        <div class="mb-6">
            <label for="file_upload" class="block text-gray-700 text-sm font-bold mb-2">Recipe Image (optional, leave blank to keep current):</label>
            <input type="file" name="file_upload" id="file_upload" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if($recipe->image_path)
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Current Image:</p>
                    <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="mt-1 h-32 w-auto rounded">
                </div>
            @endif
            @error('file_upload') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Recipe
            </button>
            <a href="{{ route('my-recipes') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancel
            </a>
        </div>
    </form>
</div>
<script>

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); 
    const ingredientsTextarea = document.getElementById('ingredients_text');

    if (form && ingredientsTextarea) {
        form.addEventListener('submit', function() {
            
            const existingHiddenIngredients = form.querySelectorAll('input[name^="ingredients["]');
            existingHiddenIngredients.forEach(input => input.remove());

            const lines = ingredientsTextarea.value.split('\n').filter(line => line.trim() !== '');
            lines.forEach((line, index) => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `ingredients[${index}]`;
                hiddenInput.value = line.trim();
                form.appendChild(hiddenInput);
            });
        });
    }
});
</script>
@endsection