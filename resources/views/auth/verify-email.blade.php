<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Code - Klik Kelontong</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <a href="{{ route('register') }}" class="absolute top-6 left-6 text-gray-700">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </a>

    <div class="flex items-center justify-center min-h-screen py-12 px-6">
        <div class="w-full max-w-sm">

            <h1 class="text-4xl font-bold text-gray-900 text-center">
                Verify Code
            </h1>

            <p class="text-gray-600 text-center mt-2">
                Please enter the code we just sent to email
                @auth
                    <span class="font-bold text-gray-800">{{ auth()->user()->email }}</span>
                @else
                    <span class="font-bold text-gray-800">example@gmail.com</span>
                @endauth
            </p>

            <div class="flex justify-center gap-3 mt-8">
                <input type="text" value="0" readonly class="w-14 h-14 text-center text-2xl font-bold border-gray-300 rounded-lg bg-gray-50">
                <input type="text" value="1" readonly class="w-14 h-14 text-center text-2xl font-bold border-gray-300 rounded-lg bg-gray-50">
                <input type="text" value="-" readonly class="w-14 h-14 text-center text-2xl font-bold border-gray-300 rounded-lg bg-gray-50">
                <input type="text" value="-" readonly class="w-14 h-14 text-center text-2xl font-bold border-gray-300 rounded-lg bg-gray-50">
            </div>

            <div class="text-center mt-6">
                <span class="text-gray-600">Didn't receive OTP?</span>
                <a href="#" class="text-green-700 font-bold underline hover:text-green-800 ml-1">
                    Resend Code
                </a>
            </div>

            <a href="#"
                    class="block w-full text-center bg-green-700 text-white py-3 px-4 rounded-lg font-semibold text-lg mt-8 hover:bg-green-800 transition duration-300">
                Verify
            </a>

        </div>
    </div>
</body>
</html>