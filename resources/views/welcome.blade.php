<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klik Kelontong</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white" x-data="{ showSplash: true }" x-init="setTimeout(() => { showSplash = false }, 1000)">

    <div x-show="showSplash" x-transition:leave.opacity.duration.500ms
        class="flex items-center justify-center min-h-screen p-8">

        <div class="text-center">
            <svg class="w-24 h-24 text-green-800 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>

            <h1 class="text-2xl font-bold text-green-800 mt-2">KLIK KELONTONG</h1>
        </div>

    </div>

    <div x-show="!showSplash" x-transition:enter.opacity.duration.500ms style="display: none;"
        class="flex items-center justify-center min-h-screen p-8">

        <div class="w-full max-w-sm">

            <div class="flex flex-col items-center">
                <svg class="w-24 h-24 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <h1 class="text-2xl font-bold text-green-800 mt-2">KLIK KELONTONG</h1>
            </div>

            <h2 class="text-2xl font-bold text-green-800 text-center mt-10">
                "Klik Kelontong, solusi belanja harian Anda!"
            </h2>

            <p class="text-gray-600 text-center mt-4">
                Nikmati pengalaman belanja yang nyaman tanpa perlu antri atau keluar rumah. Kami siap mengantar
                kebutuhanmu. Yuk, mulai belanja sekarang!
            </p>

            <a href="{{ route('location.show') }}"
                class="block w-full text-center bg-green-700 text-white py-3 px-4 rounded-lg font-semibold text-lg mt-8 hover:bg-green-800 transition duration-300">
                Let's Get Started
            </a>

            <div class="text-center mt-6">
                <span class="text-gray-600">Belum Punya akun?</span>
                <a href="{{ route('register') }}" class="text-green-700 font-bold underline hover:text-green-800 ml-1">
                    Daftar
                </a>
            </div>

        </div>

    </div>
    @livewireScripts
</body>

</html>
