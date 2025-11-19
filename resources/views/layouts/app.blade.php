<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Klik Kelontong' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50">

    <!-- Header - Desktop & Mobile -->
    <header class="bg-white sticky top-0 z-50">
        <!-- Main Header dengan Logo & Search -->
        <div class="bg-primary px-4 py-3">
            <div class="max-w-7xl mx-auto flex items-center gap-3">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 rounded-lg px-3 py-2">
                    <img src="{{ asset('images/logo-klik-kelontong.png') }}" alt="Logo Klik Kelontong" class="w-9 h-9">
                    <span class="text-white font-light text-sm">Klik Kelontong</span>
                </a>

                <!-- Search Bar -->
                <div class="flex-1 relative">
                    <form action="{{ route('products.search') }}" method="GET">
                        <input type="text" name="q" placeholder="Cari produk..."
                            class="w-full bg-gray-300 pl-3 pr-12 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 rounded-lg">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Cart Icon -->
                <a href="{{ auth()->check() ? route('cart') : route('login') }}" class="relative p-2">
                    <img src="{{ asset('images/cart.png') }}" alt="Pembayaran" class="w-6 h-6">
                    @auth
                        @php $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity'); @endphp
                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full font-bold">
                                {{ $cartCount }}
                            </span>
                        @endif
                    @endauth
                </a>
            </div>
        </div>

        <!-- Category Dropdown -->
        @if (request()->routeIs('home'))
            <div class="bg-gray-100 px-4 py-2">
                <div class="max-w-7xl mx-auto">
                    <select
                        class="w-full md:w-48 bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option>All Category</option>
                        @php $categories = \App\Models\Category::where('is_active', true)->get(); @endphp
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        {{-- Desktop Navigation (Hidden on Mobile) --}}
        <nav class="hidden md:block border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center gap-8 py-3">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium {{ request()->routeIs('home') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">
                        Beranda
                    </a>
                    <a href="{{ auth()->check() ? route('activities') : route('login') }}"
                        class="text-sm font-medium {{ request()->routeIs('activities') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">
                        Aktivitas
                    </a>
                    <a href="{{ auth()->check() ? route('inbox') : route('login') }}"
                        class="text-sm font-medium {{ request()->routeIs('inbox') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">
                        Kotak Masuk
                    </a>

                    <div class="ml-auto flex items-center gap-4">
                        @auth
                            <a href="{{ route('account') }}"
                                class="flex items-center gap-2 hover:bg-gray-50 px-3 py-2 rounded-lg">
                                @if (auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                        class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                    </div>
                                @endif
                                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- ✅ Main Content with Conditional Padding -->
    @php
        $hideBottomNav = request()->routeIs(['products.show','track-order','cart', 'checkout', 'coupons', 'payment', 'payment.success']);
    @endphp
    <main class="min-h-screen bg-white {{ $hideBottomNav ? 'pb-0' : 'pb-20 md:pb-8' }}">
        {{ $slot }}
    </main>

    <!-- ✅ Bottom Navigation - Conditional Display -->
    @if (!$hideBottomNav)
        <nav
            class="fixed bottom-0 left-0 right-0 bg-primary-light border-t border-gray-200 md:hidden z-40 safe-area-inset-bottom">
            <div class="grid grid-cols-5 h-16">
                <!-- Beranda -->
                <a href="{{ route('home') }}"
                    class="flex flex-col items-center justify-center {{ request()->routeIs('home') ? 'text-green-600' : 'text-gray-700' }}">
                    <img src="{{ asset('images/nav-home.png') }}" alt="Beranda" class="w-6 h-6">
                    <span class="text-xs">Beranda</span>
                </a>

                <!-- Aktivitas -->
                <a href="{{ auth()->check() ? route('activities') : route('login') }}"
                    class="flex flex-col items-center justify-center {{ request()->routeIs('activities') ? 'text-green-600' : 'text-gray-700' }}">
                    <img src="{{ asset('images/nav-aktivitas.png') }}" alt="Aktivitas" class="w-6 h-6">
                    <span class="text-xs">Aktivitas</span>
                </a>

                <!-- Pembayaran -->
                <a href="{{ auth()->check() ? route('payments') : route('login') }}"
                    class="flex flex-col items-center justify-center {{ request()->routeIs('payments') ? 'text-green-600' : 'text-gray-700' }}">
                    <img src="{{ asset('images/nav-pembayaran.png') }}" alt="Pembayaran" class="w-6 h-6">
                    <span class="text-xs">Pembayaran</span>
                </a>

                <!-- Kotak Masuk -->
                <a href="{{ auth()->check() ? route('inbox') : route('login') }}"
                    class="flex flex-col items-center justify-center {{ request()->routeIs('inbox') ? 'text-green-600' : 'text-gray-700' }}">
                    <img src="{{ asset('images/nav-kotakmasuk.png') }}" alt="Kotak Masuk" class="w-6 h-6">
                    <span class="text-xs">Kotak Masuk</span>
                </a>

                <!-- Akun -->
                <a href="{{ auth()->check() ? route('account') : route('login') }}"
                    class="flex flex-col items-center justify-center {{ request()->routeIs('account') ? 'text-green-600' : 'text-gray-700' }}">
                    <img src="{{ asset('images/nav-akun.png') }}" alt="Akun" class="w-6 h-6">
                    <span class="text-xs">Akun</span>
                </a>
            </div>
        </nav>
    @endif

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

</body>

</html>
