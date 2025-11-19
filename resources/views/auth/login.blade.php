<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In - Klik Kelontong</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <div class="flex items-center justify-center min-h-screen py-12 px-6">
        <div class="w-full max-w-sm">

            <h1 class="text-4xl font-bold text-gray-900 text-center">
                Sign In
            </h1>

            <p class="text-gray-600 text-center mt-2">
                Hi! Welcome back, you've been missed
            </p>

            <x-auth-session-status class="my-4" :status="session('status')" />
            
            <x-input-error :messages="$errors->get('email')" class="mt-4" />

            <form method="POST" action="{{ route('login') }}" class="mt-8">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username"
                           class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                           placeholder="example@gmail.com">
                    
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ✅ Password Field with Pure JavaScript Toggle --}}
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               class="block w-full mt-1 pr-10 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="************">
                        
                        {{-- Toggle Button --}}
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button type="button" 
                                    id="togglePassword" 
                                    class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                
                                {{-- Eye Slash Icon (Hidden) - Default --}}
                                <svg id="eyeSlash" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" />
                                </svg>
                                
                                {{-- Eye Icon (Visible) - Hidden by default --}}
                                <svg id="eyeVisible" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Forgot Password Link --}}
                <div class="text-right mt-2">
                    <a href="{{ route('password.request') }}" class="text-sm text-red-600 font-medium underline hover:text-red-700">
                        Forgot Password?
                    </a>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full text-center bg-green-700 text-white py-3 px-4 rounded-lg font-semibold text-lg mt-6 hover:bg-green-800 transition duration-300">
                    Sign In
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative flex items-center justify-center my-8">
                <span class="absolute bg-white px-4 text-sm text-gray-500">Or sign in with</span>
                <div class="w-full h-px bg-gray-300"></div>
            </div>

            {{-- Social Login Buttons --}}
            <div class="flex justify-center gap-4">
                <a href="#" class="flex items-center justify-center w-14 h-14 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors" aria-label="Sign in with Apple">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.53 4.09l-.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                    </svg>
                </a>
                <a href="#" class="flex items-center justify-center w-14 h-14 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors" aria-label="Sign in with Google">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                </a>
                <a href="#" class="flex items-center justify-center w-14 h-14 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors" aria-label="Sign in with Facebook">
                    <svg class="w-6 h-6 text-[#1877F2]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z"/>
                    </svg>
                </a>
            </div>

            {{-- Sign Up Link --}}
            <div class="text-center mt-10">
                <span class="text-gray-600">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-green-700 font-bold underline hover:text-green-800 ml-1">
                    Sign Up
                </a>
            </div>

        </div>
    </div>

    {{-- ✅ Pure JavaScript for Password Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeSlash = document.getElementById('eyeSlash');
            const eyeVisible = document.getElementById('eyeVisible');

            if (togglePassword && passwordInput && eyeSlash && eyeVisible) {
                togglePassword.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Toggle password visibility
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle eye icons
                    eyeSlash.classList.toggle('hidden');
                    eyeVisible.classList.toggle('hidden');
                });
            }
        });
    </script>

</body>
</html>