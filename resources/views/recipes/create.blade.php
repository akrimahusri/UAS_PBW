{{-- File: resources/views/recipes/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="w-full bg-white flex flex-col min-h-screen">

    {{-- Bagian Header Halaman (Judul "New Recipe") --}}
    <div class="px-6 md:px-10 py-5 border-b border-gray-200 flex justify-end items-center">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">New Recipe</h1>
    </div>

    {{-- Konten Utama Halaman --}}
    <div class="flex-grow p-6 md:p-10">
        <p class="text-gray-600 mb-8 text-base md:text-lg">
            Fill out the details below to share your delicious creation.
        </p>

        {{-- Pastikan action, method, dan enctype sudah benar --}}
        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- Proteksi CSRF Laravel --}}

            <div class="space-y-6">
                {{-- Recipe Title --}}
                <div>
                    <label for="recipe_title" class="block text-sm font-medium text-gray-700 mb-1">Recipe Title</label>
                    <input type="text" name="recipe_title" id="recipe_title"
                           class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           value="{{ old('recipe_title') }}"> {{-- Menampilkan kembali input lama jika ada error validasi --}}
                </div>

                {{-- Description (Tambahkan input ini jika belum ada) --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-xs text-gray-500">(Optional)</span></label>
                    <textarea name="description" id="description" rows="3"
                              class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                </div>

                {{-- Ingredient (Ini adalah BLOK YANG BENAR untuk ingredient dinamis) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ingredient</label>
                    <div id="ingredients_container">
                        {{-- Initial Ingredient Field --}}
                        <div class="ingredient-entry flex items-center space-x-2 mb-2">
                            <input type="text" name="ingredients[]"
                                   class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="e.g., 2 cups Wheat Flour" value=""> {{-- Isi value dari old() jika ada error validasi dan Anda ingin mempertahankan input dinamis --}}
                        </div>
                        {{-- Jika ada error validasi dan ingredients lama perlu ditampilkan kembali, Anda perlu loop old('ingredients') di sini --}}
                    </div>
                    <button type="button" id="add_ingredient_button" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 flex items-center font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Ingredient
                    </button>
                </div>

                {{-- Direction --}}
                <div>
                    <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                    <textarea name="direction" id="direction" rows="6"
                              class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('direction') }}</textarea>
                </div>

                {{-- Cooking duration --}}
                <div>
                    <label for="cooking_duration_value" class="block text-sm font-medium text-gray-700 mb-1">Cooking duration</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" name="cooking_duration_value" id="cooking_duration_value" placeholder="e.g., 30"
                               class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               value="{{ old('cooking_duration_value') }}">
                        <input type="text" name="cooking_duration_unit" id="cooking_duration_unit" placeholder="e.g., minutes"
                               class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               value="{{ old('cooking_duration_unit') }}">
                    </div>
                </div>

                {{-- Select Category --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Category <span class="text-xs text-gray-500">(Optional)</span></label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-2">
                        @php
                            // Idealnya, $categories diambil dari database melalui controller
                            $categories_options = ['Quick & Easy', 'Main Course', 'Dessert', 'Vegan', 'Drink', 'Sauce & Dip'];
                        @endphp
                        @foreach($categories_options as $category_option)
                        <div class="flex items-center">
                            <input id="category_{{ Str::slug($category_option) }}" name="categories[]" type="checkbox" value="{{ $category_option }}" {{-- Ganti value dengan ID kategori jika dari DB --}}
                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                   {{ (is_array(old('categories')) && in_array($category_option, old('categories'))) ? 'checked' : '' }}>
                            <label for="category_{{ Str::slug($category_option) }}" class="ml-2 block text-sm text-gray-900">{{ $category_option }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Upload Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Image <span class="text-xs text-gray-500">(Optional)</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center"> {{-- Ditambahkan justify-center agar teks "Upload a file" juga di tengah --}}
                                {{-- Label sekarang menunjuk ke ID input file yang benar --}}
                                <label for="file_upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="file_upload" name="file_upload" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                    {{-- Untuk menampilkan nama file yang dipilih (opsional, butuh sedikit JavaScript) --}}
                    <div id="file_upload_name" class="mt-1 text-sm text-gray-500"></div>
                </div>
                 {{-- Menampilkan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="mt-4 p-3 bg-red-100 text-red-700 border border-red-200 rounded-md">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>


            {{-- Tombol Save Recipe --}}
            <div class="pt-8 flex justify-end">
                <button type="submit"
                        class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-[#3DA0A7] hover:bg-[#328c92] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3DA0A7]">
                    Save Recipe
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ingredientsContainer = document.getElementById('ingredients_container');
        const addIngredientButton = document.getElementById('add_ingredient_button');

        // Fungsi untuk menambah field ingredient baru
        function addIngredientField(value = '') {
            const newIngredientEntry = document.createElement('div');
            newIngredientEntry.classList.add('ingredient-entry', 'flex', 'items-center', 'space-x-2', 'mb-2');

            newIngredientEntry.innerHTML = `
                <input type="text" name="ingredients[]"
                       class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="e.g., 1 sdt Garam" value="${value}">
                <button type="button" class="remove-ingredient-button p-1 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
            ingredientsContainer.appendChild(newIngredientEntry);
        }

        if (addIngredientButton) {
            addIngredientButton.addEventListener('click', function () {
                addIngredientField(); // Panggil fungsi untuk menambah field kosong
            });
        }

        if (ingredientsContainer) {
            ingredientsContainer.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.remove-ingredient-button');
                if (removeButton) {
                    // Jangan hapus jika ini adalah field ingredient terakhir di container
                    if (ingredientsContainer.querySelectorAll('.ingredient-entry').length > 1) {
                        removeButton.closest('.ingredient-entry').remove();
                    } else {
                        // Jika ini adalah field terakhir, kosongkan saja nilainya
                        const inputField = removeButton.closest('.ingredient-entry').querySelector('input[name="ingredients[]"]');
                        if (inputField) {
                            inputField.value = '';
                        }
                    }
                }
            });
        }

        // Jika ada data lama (misalnya karena error validasi), render kembali field ingredients
        const oldIngredients = {!! json_encode(old('ingredients')) !!};
        if (oldIngredients && oldIngredients.length > 0) {
            // Hapus field awal yang mungkin sudah ada dari HTML statis jika Anda hanya ingin render dari old()
            // atau, jika field pertama sudah di-render, mulai loop dari oldIngredients[1]
            // Untuk kesederhanaan, jika ada oldIngredients, kita hapus dulu yang statis (jika hanya satu)
            // dan render semua dari old.
            
            const firstStaticEntry = ingredientsContainer.querySelector('.ingredient-entry');
            let hasRenderedFirstOld = false;

            oldIngredients.forEach((ingredientValue, index) => {
                if (index === 0 && firstStaticEntry && firstStaticEntry.querySelector('input[name="ingredients[]"]')) {
                    // Isi field statis pertama dengan nilai old pertama
                    firstStaticEntry.querySelector('input[name="ingredients[]"]').value = ingredientValue;
                    hasRenderedFirstOld = true;
                } else {
                    // Tambah field baru untuk sisa old ingredients
                    addIngredientField(ingredientValue);
                }
            });
             // Jika oldIngredients kosong tapi field statis pertama ada, pastikan value nya kosong atau dari old() yang mungkin null
            if (!oldIngredients && firstStaticEntry && firstStaticEntry.querySelector('input[name="ingredients[]"]')) {
                 firstStaticEntry.querySelector('input[name="ingredients[]"]').value = {!! json_encode(old('ingredients.0')) !!} || '';
            }
        }
    });
</script>
@endpush