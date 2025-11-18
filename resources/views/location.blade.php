<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Set Location - Klik Kelontong</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <div class="flex items-center justify-center min-h-screen p-8">
        
        <div class="w-full max-w-sm">

            <div class="flex justify-center mb-6">
                <span class="flex items-center justify-center w-28 h-28 bg-green-200 rounded-full">
                    <svg class="w-14 h-14 text-green-900" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                    </svg>
                </span>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 text-center">
                What is Your Location?
            </h2>

            <p class="text-gray-600 text-center mt-3">
                We need to know your location in order to suggest nearby services.
            </p>

            <a href="#" id="allow-location"
               class="block w-full text-center bg-green-700 text-white py-3 px-4 rounded-lg font-semibold text-lg mt-8 hover:bg-green-800 transition duration-300">
                Allow Location Access
            </a>

            <a href="{{ route('location.search') }}" class="block w-full text-center text-green-700 font-bold mt-6 hover:text-green-800">
                Enter Location Manually
            </a>

        </div>

    </div>

</body>
</html>