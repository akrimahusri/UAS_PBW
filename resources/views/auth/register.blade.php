<x-guest-layout>
    <div class="flex min-h-screen">
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 sm:p-12 bg-white">
            <div class="w-full max-w-md">
                <h1 class="text-4xl font-bold mb-10 text-gray-800">Create Account</h1>

                <div class="flex items-center space-x-3 mb-6">
                    {{-- Ganti dengan path ke ikon Anda atau gunakan SVG --}}
                    <a href="#" class="w-10 h-10 p-2 border border-gray-300 rounded-full hover:bg-gray-100 flex items-center justify-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="w-5 h-5">
                    </a>
                    <a href="#" class="w-10 h-10 p-2 border border-gray-300 rounded-full hover:bg-gray-100 flex items-center justify-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" class="w-5 h-5">
                    </a>
                    <a href="#" class="w-10 h-10 p-2 border border-gray-300 rounded-full hover:bg-gray-100 flex items-center justify-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Octicons-mark-github.svg" alt="GitHub" class="w-5 h-5">
                    </a>
                    <a href="#" class="w-10 h-10 p-2 border border-gray-300 rounded-full hover:bg-gray-100 flex items-center justify-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png" alt="LinkedIn" class="w-5 h-5">
                    </a>
                </div>
                <p class="text-sm text-gray-600 mb-6">or use your email for registration</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    {{-- Input fields seperti sebelumnya --}}
                    <div>
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-100 border-gray-100 p-3 placeholder-gray-500" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-text-input id="username" class="block mt-1 w-full bg-gray-100 border-gray-100 p-3 placeholder-gray-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Username" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-100 border-gray-100 p-3 placeholder-gray-500"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password"
                                        placeholder="Password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-100 border-gray-100 p-3 placeholder-gray-500"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Konfirmasi Password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between mt-8">
                        <button type="submit" class="w-full bg-[#16666B] hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                            {{ __('Sign Up') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden lg:flex w-1/2 bg-[#70B9BE] flex-col items-center justify-end p-6 md:p-10 relative"
             style="background-image: url('{{ asset('images/register.png') }}'); background-size: contain; background-position: center 60%; background-repeat: no-repeat;">
            <img src="{{ asset('images/cooklab-icon.png') }}" alt="Cooklab Icon" 
                 class="absolute top-6 right-6 md:top-6 md:right-6 w-21 h-16 z-8"> 
            
            <div class="text-center relative">
                <h2 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-white mb-2 md:mb-4" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">Welcome Back!</h2>
                <p class="text-white mb-4 md:mb-8 text-xs lg:text-sm xl:text-base" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">Returning user? Click here to log in!</p>
                <a href="{{ route('login') }}" 
                   class="bg-white hover:bg-gray-100 text-[#16666B] font-semibold py-2 px-6 md:py-3 md:px-10 rounded-lg shadow-md text-xs lg:text-sm xl:text-base">
                    Sign In
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>