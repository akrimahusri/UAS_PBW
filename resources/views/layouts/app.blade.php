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

    @stack('styles')
</head>
<body class="font-sans antialiased">
    {{-- Kontainer terluar, min-h-screen memastikan background mengisi layar jika konten pendek --}}
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: true }">

        <div class="flex">

            {{-- Komponen Sidebar --}}
            @auth
                
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

            <div class="flex-1 flex flex-col min-w-0">
                
                @include('layouts.navigation')

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
