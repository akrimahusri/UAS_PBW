{{-- resources/views/components/sidebar.blade.php --}}
<aside class="h-full overflow-y-auto flex flex-col"> {{-- Lebar w-64 di sini, flex flex-col --}}
    <div class="p-6 flex-shrink-0"> {{-- Header sidebar, tidak scroll --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/cooklab-icon.png') }}" alt="CookLab Icon" class="h-12 w-auto"> {{-- Sesuaikan ukuran --}}
            </a>
            {{-- Tombol close sidebar (hamburger) di dalam sidebar, hanya untuk mobile atau jika diinginkan --}}
            <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700 md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @auth
            <div class="text-center mb-4"> {{-- Dibuat text-center untuk nama dan email --}}
                <h5 class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h5>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        @endauth
    </div>

    <nav class="flex-grow overflow-y-auto px-6 pb-6"> {{-- Navigasi bisa scroll jika panjang --}}
        {{-- Bagian Fitur --}}
        <div>
            <h6 class="mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Fitur
            </h6>
            <ul>
                <li class="mb-1">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center py-2 px-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md {{ request()->routeIs('dashboard') ? 'bg-gray-200 text-gray-900 font-medium' : '' }}">
                        {{-- <x-ikon-dashboard class="w-5 h-5 mr-2" /> --}}
                        Dashboard
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{ route('recipes.liked') }}"
                       class="flex items-center py-2 px-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md {{ request()->routeIs('recipes.liked') ? 'bg-gray-200 text-gray-900 font-medium' : '' }}">
                        Liked Recipes
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{ route('recipes.saved') }}"
                       class="flex items-center py-2 px-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md {{ request()->routeIs('recipes.saved') ? 'bg-gray-200 text-gray-900 font-medium' : '' }}">
                        Saved Recipes
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{ route('recipes.my') }}"
                       class="flex items-center py-2 px-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md {{ request()->routeIs('recipes.my') ? 'bg-gray-200 text-gray-900 font-medium' : '' }}">
                        My Recipes
                    </a>
                </li>
            </ul>
        </div>

        {{-- Bagian Setting --}}
        <div class="mt-4">
            <h6 class="mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Setting
            </h6>
            <ul>
                <li class="mb-1">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center py-2 px-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md {{ request()->routeIs('profile.edit') ? 'bg-gray-200 text-gray-900 font-medium' : '' }}">
                        Profile
                    </a>
                </li>
                @auth
                <li class="mb-1">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                           class="w-full flex items-center py-2 px-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 rounded-md">
                            Logout
                        </button>
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </nav>
</aside>