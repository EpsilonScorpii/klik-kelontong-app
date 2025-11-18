<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard' }} - Klik Kelontong</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-gray-100">

    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">

        <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/50 transition-opacity lg:hidden"
            @click="sidebarOpen = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <div x-show="sidebarOpen" class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-green-800 text-white"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full">

            <nav class="flex-1 space-y-1 px-4 py-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Beranda</a>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Manajemen Produk</a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Manajemen
                    Pesanan</a>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Manajemen
                    Pelanggan</a>
                <a href="{{ route('admin.shipping.settings') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Pengaturan
                    Pengiriman</a>
                <a href="{{ route('admin.store.settings') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Pengaturan Toko</a>
                <a href="{{ route('admin.financial.reports') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Keuangan &
                    Laporan</a>
                <a href="{{ route('admin.help.center') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Pusat Bantuan</a>
            </nav>
        </div>
        <aside
            class="fixed inset-y-0 left-0 z-20 hidden w-72 flex-col border-r border-gray-200 bg-green-800 text-white lg:flex">
            <nav class="flex-1 space-y-1 px-4 py-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Beranda</a>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Manajemen Produk</a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Manajemen
                    Pesanan</a>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Manajemen
                    Pelanggan</a>
                <a href="{{ route('admin.shipping.settings') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Pengaturan
                    Pengiriman</a>
                <a href="{{ route('admin.store.settings') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Pengaturan Toko</a>
                <a href="{{ route('admin.financial.reports') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Keuangan &
                    Laporan</a>
                <a href="{{ route('admin.help.center') }}" class="flex items-center rounded-lg px-4 py-2 hover:bg-green-700">Pusat Bantuan</a>
            </nav>
        </aside>
        <div class="flex min-h-screen flex-col lg:pl-72">

            <header
                class="sticky top-0 z-30 flex h-16 w-full items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6 lg:justify-end">

                <button type="button" class="text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <h1 class="text-lg font-semibold lg:hidden">
                    {{ $title ?? 'Dashboard' }}
                </h1>

                <button type="button" class="text-gray-700">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </header>
            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

    <div x-data="{ show: false, message: '', type: 'success' }" 
     @alert.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
     x-show="show"
     x-transition
     class="fixed top-4 right-4 z-50 max-w-sm">
    <div :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'" 
         class="text-white px-6 py-4 rounded-lg shadow-lg">
        <p x-text="message"></p>
    </div>
</div>
</body>

</html>
