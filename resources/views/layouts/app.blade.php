<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Pastikan ini ada jika halaman lain menggunakan @push('styles') --}}
    @stack('styles')
</head>
<body class="font-sans antialiased">
    {{-- Kontainer terluar, min-h-screen memastikan background mengisi layar jika konten pendek --}}
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: true }">

        {{-- Kontainer flex untuk sidebar dan kolom konten utama.
             PENTING: class 'h-screen' DIHAPUS dari sini.
             Ini memungkinkan seluruh 'div.flex' untuk tumbuh melebihi tinggi layar jika kontennya panjang.
        --}}
        <div class="flex">

            {{-- Komponen Sidebar --}}
            @auth
                {{-- Sidebar akan selalu ada di DOM jika user login.
                     Visibilitas & transisi diatur Alpine & CSS.
                     Jika konten sidebar BISA lebih panjang dari layar, dan sidebar kamu 'fixed' atau 'sticky',
                     maka sidebar ini mungkin perlu 'h-screen overflow-y-auto' sendiri.
                     Namun, untuk struktur ini, kita biarkan dulu.
                --}}
                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-in-out duration-300"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="w-72 bg-[#70B9BE] shadow-md z-20 flex-shrink-0 lg:relative"> {{-- z-index ditambah, lg:relative agar tidak overlap --}}
                    <x-sidebar />
                </div>
            @endauth

            {{-- Kontainer untuk Navigasi Atas dan Konten Utama --}}
            {{-- flex-1 agar mengambil sisa lebar.
                 flex flex-col agar navigasi di atas konten utama.
                 min-w-0 untuk mencegah konten lebar 'mendorong' layout.
                 PENTING: 'overflow-hidden' DIHAPUS dari sini.
            --}}
            <div class="flex-1 flex flex-col min-w-0">
                {{-- Navigasi Atas (termasuk tombol hamburger untuk toggle sidebar) --}}
                {{-- Pastikan navigasi ini tidak memiliki tinggi yang berlebihan atau overflow sendiri --}}
                @include('layouts.navigation')

                {{-- Konten Utama Halaman --}}
                {{-- flex-1 agar mengambil sisa tinggi dalam 'flex-col' parent-nya.
                     PENTING: 'overflow-x-hidden' dan 'overflow-y-auto' DIHAPUS dari sini.
                     Konten sekarang akan membuat 'main' dan parent-nya tumbuh,
                     dan scrollbar utama browser akan menangani overflow.
                --}}
                <main class="flex-1 bg-gray-100 p-6">
                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </main>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
