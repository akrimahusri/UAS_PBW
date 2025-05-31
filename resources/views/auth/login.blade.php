<x-guest-layout>
    <div class="flex min-h-screen">

        <div class="hidden lg:flex w-1/2 bg-[#70B9BE] flex-col items-center justify-end p-6 md:p-12 relative" 
             style="background-image: url('{{ asset('images/register.png') }}'); background-size: contain; background-position: center 45%; background-repeat: no-repeat;">
            
            <img src="{{ asset('images/cooklab-icon.png') }}" alt="Cooklab Icon" 
                 class="absolute top-6 left-6 md:top-8 md:left-8 w-21 h-16 z-8"> 
            
            <div class="text-center relative mb-6 md:mb-8 xl:mb-10"> 
                <h2 class="text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-3 md:mb-4" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">Hi, Friend!</h2>
                <p class="text-white mb-6 md:mb-10 text-sm lg:text-base xl:text-lg" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">No account yet? Sign up to get started!</p>
                <a href="{{ route('register') }}" 
                   class="bg-[#16666B] hover:bg-[#124f53] text-white font-semibold py-3 px-10 md:py-3 md:px-12 rounded-lg shadow-md text-sm lg:text-base xl:text-lg">
                    Sign Up
                </a>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 sm:p-12 bg-white">
            <div class="w-full max-w-xs sm:max-w-sm">
                <h1 class="text-4xl sm:text-5xl font-bold mb-8 sm:mb-10 text-gray-800 text-center lg:text-left">Sign In</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    {{-- Input fields --}}
                    <div>
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-100 border-transparent focus:border-gray-300 focus:ring-0 p-3 placeholder-gray-500 rounded-md" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Username or Email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-6">
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-100 border-transparent focus:border-gray-300 focus:ring-0 p-3 placeholder-gray-500 rounded-md"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password"
                                        placeholder="Password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#16666B] shadow-sm focus:ring-[#16666B] focus:ring-offset-0" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#16666B]" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-[#16666B] hover:bg-[#124f53] text-white font-semibold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Sign In
                        </button>
                    </div>
                </form>
                <div class="mt-8 text-center lg:hidden">
                    <p class="text-sm text-gray-600">
                        No account yet? 
                        <a href="{{ route('register') }}" class="font-medium text-[#16666B] hover:text-[#124f53]">
                            Sign up
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>