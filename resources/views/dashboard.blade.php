@extends('layouts.app')

@section('content')
<div class="py-8"> 
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Bagian "Discover Recipes" --}}
        <div class="mb-10">
            <h2 class="text-2xl font-semibold mb-6 text-center text-recipe-category-title text-[#3DA0A7]">Discover Recipes</h2>

            @if(isset($recipes) && $recipes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($recipes as $recipe)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col font-poppins"
                     x-data="{ 
                         isLiked: {{ Auth::check() && Auth::user()->likedRecipes->contains($recipe->id) ? 'true' : 'false' }},
                         isSaved: {{ Auth::check() && Auth::user()->savedRecipes->contains($recipe->id) ? 'true' : 'false' }},
                         likeCount: {{ $recipe->liked_by_users_count ?? 0 }}, /* Pastikan liked_by_users_count ada di $recipe */
                         saveCount: {{ $recipe->saved_by_users_count ?? 0 }}, /* Pastikan saved_by_users_count ada di $recipe */
                         toggleLike() {
                             if (! {{ Auth::check() ? 'true' : 'false' }} ) {
                                 alert('You need to be logged in to like recipes!');
                                 window.location.href = '{{ route('login') }}';
                                 return;
                             }
                             if (this.isLiked) {
                                 fetch('{{ route('recipes.unlike', $recipe->id) }}', { // Gunakan $recipe->id dari loop ini
                                     method: 'DELETE',
                                     headers: {
                                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                         'Content-Type': 'application/json',
                                         'Accept': 'application/json'
                                     }
                                 }).then(response => response.json())
                                 .then(data => {
                                     if (data.success) {
                                         this.isLiked = false;
                                         this.likeCount = data.likeCount !== undefined ? data.likeCount : this.likeCount - 1;
                                     }
                                 });
                             } else {
                                 fetch('{{ route('recipes.like', $recipe->id) }}', { // Gunakan $recipe->id dari loop ini
                                     method: 'POST',
                                     headers: {
                                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                         'Content-Type': 'application/json',
                                         'Accept': 'application/json'
                                     }
                                 }).then(response => response.json())
                                 .then(data => {
                                     if (data.success) {
                                         this.isLiked = true;
                                         this.likeCount = data.likeCount !== undefined ? data.likeCount : this.likeCount + 1;
                                     }
                                 });
                             }
                         },
                         toggleSave() {
                             if (! {{ Auth::check() ? 'true' : 'false' }} ) {
                                 alert('You need to be logged in to save recipes!');
                                 window.location.href = '{{ route('login') }}';
                                 return;
                             }
                             if (this.isSaved) {
                                 fetch('{{ route('recipes.unsave', $recipe->id) }}', { // Gunakan $recipe->id dari loop ini
                                     method: 'DELETE',
                                     headers: {
                                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                         'Content-Type': 'application/json',
                                         'Accept': 'application/json'
                                     }
                                 }).then(response => response.json())
                                 .then(data => {
                                     if (data.success) {
                                         this.isSaved = false;
                                         this.saveCount = data.saveCount !== undefined ? data.saveCount : this.saveCount - 1;
                                     }
                                 });
                             } else {
                                 fetch('{{ route('recipes.save', $recipe->id) }}', { // Gunakan $recipe->id dari loop ini
                                     method: 'POST',
                                     headers: {
                                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                         'Content-Type': 'application/json',
                                         'Accept': 'application/json'
                                     }
                                 }).then(response => response.json())
                                 .then(data => {
                                     if (data.success) {
                                         this.isSaved = true;
                                         this.saveCount = data.saveCount !== undefined ? data.saveCount : this.saveCount + 1;
                                     }
                                 });
                             }
                         }
                     }"
                >
                    {{-- KONTEN KARTU RESEP DIMULAI DI SINI --}}
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
                    <div class="p-5 flex flex-col flex-grow bg-recipe-content">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate" title="{{ $recipe->title }}">
                            {{ $recipe->title }}
                        </h3>
                        <p class="text-gray-700 text-sm mb-2 flex-grow leading-relaxed h-16 overflow-hidden">
                            {{ Str::limit($recipe->description ?? 'No description available.', 100) }}
                        </p>

                        @if ($recipe->user)
                            <p class="text-xs text-gray-700 mb-1">
                                By: <span class="font-medium">{{ $recipe->user->name }}</span>
                            </p>
                        @endif

                        {{-- Rating Bintang --}}
                        <div class="flex items-center mb-4">
                            @php
                                $rating = $recipe->average_rating ?? rand(3, 5); 
                                $reviewCount = $recipe->reviews_count ?? rand(5,50);
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

                        {{-- Menampilkan jumlah like dan save --}}
                        <div class="flex items-center text-sm text-gray-600 mt-auto pt-2"> {{-- `mt-auto` untuk mendorong ke bawah, `pt-2` untuk sedikit spasi atas --}}
                            <span class="mr-3 flex items-center" @click.stop="toggleLike">
                                <svg class="w-5 h-5 inline-block mr-1 cursor-pointer" :class="{'text-red-500': isLiked, 'text-gray-400': !isLiked}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                <span x-text="likeCount"></span>
                            </span>
                            <span class="flex items-center" @click.stop="toggleSave">
                                <svg class="w-5 h-5 inline-block mr-1 cursor-pointer" :class="{'text-blue-500': isSaved, 'text-gray-400': !isSaved}" fill="currentColor" viewBox="0 0 20 20"> <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v12l-5-3-5 3V4z"/> </svg> {{-- Icon save yang lebih umum --}}
                                <span x-text="saveCount"></span>
                            </span>
                        </div>
                         <a href="{{ route('recipes.show', $recipe->id) }}" class="mt-3 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 bg-view-details-button bg-[#3DA0A7]">
                            View Details
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                    {{-- AKHIR KONTEN KARTU RESEP --}}
                </div> 
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
        </div> 

    </div>
</div>
@endsection

@push('styles')

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