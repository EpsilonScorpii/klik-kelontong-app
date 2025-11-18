<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forget Password - Klik Kelontong</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <a href="{{ route('login') }}" class="absolute top-6 left-6 text-gray-700">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </a>

    <div class="flex items-center justify-center min-h-screen py-12 px-6">
        <div class="w-full max-w-sm">

            <h1 class="text-4xl font-bold text-gray-900 text-center">
                Forget Password
            </h1>

            <p class="text-gray-600 text-center mt-2">
                Masukkan email yang sudah terdaftar
            </p>

            <x-auth-session-status class="my-4 text-green-600" :status="session('status')" />
            
            <x-input-error :messages="$errors->get('email')" class="mt-4" />

            <form method="POST" action="{{ route('password.email') }}" class="mt-8">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                           placeholder="example@gmail.com">
                </div>

                <button type="submit"
                        class="w-full text-center bg-green-700 text-white py-3 px-4 rounded-lg font-semibold text-lg mt-8 hover:bg-green-800 transition duration-300">
                    Kirim
                </button>
            </form>

            <div class="relative flex items-center justify-center my-8">
                <span class="absolute bg-white px-4 text-sm text-gray-500">Or sign in with</span>
                <div class="w-full h-px bg-gray-300"></div>
            </div>

            <div class="flex justify-center gap-4">
                <a href="#" class="flex items-center justify-center w-14 h-14 border border-gray-300 rounded-full hover:bg-gray-50" aria-label="Sign in with Apple">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.001 4.8C10.941 4.8 9.931 5.43 9.281 6.32C8.351 7.6 7.991 9.03 7.991 10.44C7.991 13.05 9.201 14.89 10.731 16.02C11.421 16.52 12.181 16.8 13.021 16.8C13.811 16.8 14.501 16.58 15.191 16.12C16.031 15.58 16.751 14.73 17.201 13.71H14.121C14.081 13.71 13.061 13.13 13.061 11.93C13.061 10.74 14.081 10.16 14.121 10.16H17.381C17.301 8.99 16.841 7.94 16.081 7.15C15.301 6.33 14.271 5.92 13.201 5.92C12.061 5.92 11.081 6.4 10.371 7.33C10.301 7.42 10.251 7.52 10.221 7.63C10.201 7.68 10.191 7.74 10.191 7.81C10.191 7.91 10.211 8 10.261 8.08C10.321 8.18 10.401 8.26 10.511 8.32C10.591 8.37 10.681 8.4 10.781 8.4C10.891 8.4 11.001 8.37 11.101 8.3C11.201 8.23 11.291 8.14 11.351 8.04C11.751 7.42 12.331 7.08 13.021 7.08C13.771 7.08 14.421 7.4 14.931 7.97C14.961 8 15.001 8.02 15.031 8.03C15.071 8.04 15.101 8.04 15.141 8.04C15.241 8.04 15.341 8.01 15.421 7.94C15.511 7.87 15.581 7.78 15.621 7.68C15.661 7.57 15.671 7.46 15.651 7.35C15.631 7.24 15.581 7.14 15.511 7.06C14.731 6.16 13.761 5.61 12.631 5.61C12.381 5.61 12.131 5.63 11.881 5.68C12.311 5.17 12.861 4.8 13.521 4.8C13.521 3.97 12.831 3.28 12.001 3.28C11.171 3.28 10.481 3.97 10.481 4.8C10.481 5.4 10.821 5.9 11.331 6.16C11.021 6.11 10.701 6.09 10.371 6.09C9.741 6.09 9.141 6.27 8.631 6.59C8.011 5.6 6.941 4.96 5.701 4.96C4.161 4.96 2.921 6.19 2.921 7.74C2.921 8.68 3.371 9.53 4.101 10.12C3.891 10.74 3.791 11.4 3.791 12.08C3.791 14.91 5.701 17.01 8.321 17.01C9.651 17.01 10.841 16.45 11.661 15.54C12.431 16.4 13.511 17.65 15.391 17.65C16.961 17.65 18.231 16.86 19.111 15.93C19.341 16.63 19.821 17.61 20.651 18.39C21.011 18.73 21.391 19.09 21.841 19.33C21.071 19.72 20.171 20.12 19.141 20.35C18.821 20.44 18.501 20.51 18.171 20.57C17.011 20.79 15.791 20.8 14.521 20.8C12.601 20.8 10.841 20.18 9.511 19.09C8.301 18.06 7.501 16.63 7.211 15.01C6.271 14.73 5.431 14.11 4.791 13.25C4.261 12.56 3.991 11.73 3.991 10.83C3.991 9.29 4.861 8.08 6.031 7.4C6.871 7.92 7.821 8.24 8.841 8.24C9.831 8.24 10.711 7.97 11.471 7.42C12.111 8.49 13.251 9.15 14.571 9.15C15.151 9.15 15.701 9.02 16.201 8.79C16.211 8.79 16.221 8.79 16.231 8.78C16.891 8.52 17.471 8.09 17.921 7.54C18.661 8.53 19.121 9.7 19.121 10.95C19.121 13.05 17.901 14.86 16.331 15.96C15.581 16.51 14.761 16.8 13.881 16.8C13.061 16.8 12.301 16.5 11.601 16C10.081 14.88 8.991 13.05 8.991 10.44C8.991 9.07 9.331 7.78 10.221 6.55C10.901 5.62 11.831 4.8 12.991 4.8L12.001 4.8Z"/></svg>
                </a>
                <a href="#" class="flex items-center justify-center w-14 h-14 border border-gray-300 rounded-full hover:bg-gray-50" aria-label="Sign in with Google">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/></svg>
                </a>
                <a href="#" class="flex items-center justify-center w-14 h-14 border border-gray-300 rounded-full hover:bg-gray-50" aria-label="Sign in with Facebook">
                    <svg class="w-6 h-6 text-[#1877F2]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z"/></svg>
                </a>
            </div>

            <div class="text-center mt-10">
                <span class="text-gray-600">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-green-700 font-bold underline hover:text-green-800 ml-1">
                    Sign Up
                </a>
            </div>

        </div>
    </div>

</body>
</html>