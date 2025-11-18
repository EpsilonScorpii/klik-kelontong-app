<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Location - Klik Kelontong</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <header class="flex items-center justify-between p-4 border-b border-gray-200">
        <a href="{{ route('location.show') }}" class="text-gray-700">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </a>
        
        <h1 class="text-lg font-semibold">Search Location</h1>
        
        <div class="w-6"></div>
    </header>

    <main class="p-4" x-data="{ searchQuery: 'Mercu Buana' }">
        
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="Cari lokasi..." 
                   class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            
            <button x-show="searchQuery.length > 0" 
                    @click="searchQuery = ''" 
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
        </div>

        <a href="#" class="flex items-center gap-3 py-4 text-gray-800 font-semibold">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L6 12Zm0 0h7.5" />
            </svg>
            <span>Use my current location</span>
        </a>

        <div>
            <h2 class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Search Result</h2>
            
            <a href="#" class="flex items-center gap-3 py-3 border-t border-gray-100">
                <svg class="w-5 h-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L6 12Zm0 0h7.5" />
                </svg>
                
                <div>
                    <div class="font-semibold text-gray-900">Mercu Buana</div>
                    <div class="text-sm text-gray-600">Jl. Raya, RT.4/RW.1, Meruya Sel., Kec. Kembangan</div>
                </div>
            </a>

            </div>

    </main>
</body>
</html>