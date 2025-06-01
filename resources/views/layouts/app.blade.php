<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- ... head content Anda ... --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: true }"> {{-- Default sidebar terbuka --}}

        <div class="flex h-screen">

            {{-- Komponen Sidebar --}}
            @auth
                {{-- Sidebar akan selalu ada di DOM jika user login, visibilitas & transisi diatur Alpine & CSS --}}
                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-in-out duration-300"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="w-72 bg-[#70B9BE] shadow-md z-10 flex-shrink-0">
                    <x-sidebar />
                </div>
            @endauth

            {{-- Kontainer untuk Navigasi Atas dan Konten Utama --}}
            <div class="flex-1 flex flex-col overflow-hidden">
                {{-- Navigasi Atas (termasuk tombol hamburger untuk toggle sidebar) --}}
                @include('layouts.navigation')

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </main>
            </div>
        </div>
    </div>
</body>
</html>