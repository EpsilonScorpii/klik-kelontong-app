<div class="pb-20 md:pb-6">

    <section class="px-4 py-8">
        <div class="max-w-7xl mx-auto">

            <div id="hero-slider" class="splide" aria-label="Promo Products Slider">
                <div class="splide__track">
                    <ul class="splide__list">

                        <li class="splide__slide">
                            {{-- Ganti warna bawaan green-400/emerald-500 dengan kl-green-dark/kl-green --}}
                            <div
                                class="bg-primary-light rounded-2xl overflow-hidden shadow-xl">
                                <div class="flex flex-row items-start justify-between p-6 md:p-8">
                                    <div class="flex-1 text-primary mb-6 md:mb-0">
                                        <p class="text-sm font-medium mb-2">— THE BEST PRODUCT</p>
                                        <h1 class="text-3xl md:text-4xl font-bold mb-4">Promo Sembako</h1>
                                        <p class="text-primary mb-6">"Promo sembako TERBATAS! Belanja sekarang sebelum
                                            promo berakhir! 🛒✨"</p>
                                        <a href="{{ route('products') }}" {{-- Ganti text-green-600 dengan text-kl-green-dark --}}
                                            class="inline-flex items-center gap-2 bg-primary text-primary-light px-2 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                            SHOP NOW
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('images/promo-product1.png') }}" alt="Promo Products"
                                            class="w-48 h-48 md:w-64 md:h-64 object-contain mx-auto">
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide">
                            <div
                                class="bg-gradient-to-r from-blue-600 to-blue-400 rounded-2xl overflow-hidden shadow-xl">
                                <div class="flex flex-row items-start justify-between p-6 md:p-8">
                                    <div class="flex-1 text-white mb-6 md:mb-0">
                                        <p class="text-sm font-medium mb-2">— NEW DEALS</p>
                                        <h1 class="text-3xl md:text-4xl font-bold mb-4">Diskon Minuman Segar</h1>
                                        <p class="text-white/90 mb-6">"Dapatkan minuman dingin dengan harga terbaik hari
                                            ini!"</p>
                                        <a href="{{ route('products') }}"
                                            class="inline-flex items-center gap-2 bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                            SHOP NOW
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="flex-shrink-0 ">
                                        <img src="{{ asset('images/promo-product2.jpeg') }}" alt="Promo Products"
                                            class="w-48 h-48 md:w-64 md:h-64 object-contain">
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            {{-- INDIKATOR DOTS DARI KODE ASLI DIHAPUS KARENA SPLIDE MENGAMBIL ALIH --}}

        </div>
    </section>

    <hr class="my-4 border-gray-100">

    <section class="px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-xl font-bold text-gray-900 mb-6">category</h2>
            <div class="grid grid-cols-3 sm:grid-cols-5 gap-4">
                @forelse($categories as $category)
                    @php
                        // 1. Ambil nama kategori, konversi ke huruf kecil, dan hapus spasi/karakter khusus
                        $sluggedName = Str::slug($category['name']);

                        // 2. Tentukan nama file gambar
                        // Contoh: Jika nama kategori adalah "Obat-obatan", $sluggedName menjadi "obat-obatan".
                        // Kami akan mencari file "obat-obatan.png" di public/images/icons/
                        $imageFile = "images/icons/{$sluggedName}.png";

                        // Fallback: Jika tidak ditemukan file spesifik, gunakan ikon default
                        $imageAsset = asset($imageFile);
                    @endphp

                    <a href="{{ route('products') }}?category={{ $category['id'] }}"
                        class="flex flex-col items-center gap-2 p-1 hover:opacity-75 transition-opacity">

                        {{-- KOTAK IKON DENGAN LINGKARAN HIJAU --}}
                        <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center">

                            {{-- ICON GAMBAR DIGUNAKAN DI SINI --}}
                            <img src="{{ $imageAsset }}" alt="{{ $category['name'] }} Icon"
                                class="w-8 h-8 object-contain"
                                onerror="this.onerror=null; this.src='{{ asset('images/icons/default.png') }}';"
                                {{-- Fallback ke gambar default --}}>
                        </div>

                        {{-- Teks Kategori (TETAP DIAMBIL DARI DATABASE) --}}
                        <span class="text-sm font-medium text-gray-800 text-center">{{ $category['name'] }}</span>
                    </a>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        Belum ada kategori
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <hr class="my-4 border-gray-100">

    <section class="px-4 py-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Rekomendasi</h2>
                {{-- Ganti text-green-600 dengan text-kl-green --}}
                <a href="{{ route('products') }}" class="text-sm text-kl-green hover:text-green-700 font-medium">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($recommendations as $product)
                    <div
                        class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ auth()->check() ? route('products.show', $product['slug']) : route('login') }}"
                            class="block">
                            <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                @if ($product['image'])
                                    <img src="{{ asset('storage/' . $product['image']) }}"
                                        alt="{{ $product['name'] }}" class="w-full h-full object-cover"
                                        onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                @if (isset($product['discount_price']) && $product['discount_price'] > 0)
                                    <div
                                        class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        -{{ round((($product['price'] - $product['discount_price']) / $product['price']) * 100) }}%
                                    </div>
                                @endif
                            </div>
                        </a>

                        <div class="p-3">
                            <a
                                href="{{ auth()->check() ? route('products.show', $product['slug']) : route('login') }}">
                                <h3 class="font-medium text-gray-900 mb-1 line-clamp-2 hover:text-kl-green">
                                    {{ $product['name'] }}
                                </h3>
                            </a>

                            <div class="flex items-baseline gap-2 mb-3">
                                {{-- Ganti text-green-600 dengan text-kl-green --}}
                                <span class="text-lg font-bold text-kl-green">
                                    Rp{{ number_format($product['price'], 0, ',', '.') }}
                                </span>
                                @if (isset($product['discount_price']) && $product['discount_price'] > 0)
                                    <span class="text-sm text-gray-400 line-through">
                                        Rp{{ number_format($product['discount_price'], 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>

                            @auth
                                <button wire:click="addToCart({{ $product['id'] }})" {{-- Ganti bg-green-600 dengan bg-kl-green dan hover:bg-green-700 dengan hover:bg-kl-green-dark --}}
                                    class="w-full bg-kl-green text-white py-2 rounded-lg font-medium hover:bg-kl-green-dark transition-colors text-sm">
                                    Beli
                                </button>
                            @else
                                <a href="{{ route('login') }}"
                                    class="block w-full bg-gray-600 text-white text-center py-2 rounded-lg font-medium hover:bg-gray-700 transition-colors text-sm">
                                    Beli
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-gray-500 font-medium">Belum ada produk rekomendasi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @if (count($featuredProducts) > 0)
        <section class="px-4 py-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Produk Unggulan</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($featuredProducts as $product)
                        <div
                            class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                            <a href="{{ auth()->check() ? route('products.show', $product['slug']) : route('login') }}"
                                class="block">
                                <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                    @if ($product['image'])
                                        <img src="{{ asset('storage/' . $product['image']) }}"
                                            alt="{{ $product['name'] }}" class="w-full h-full object-cover"
                                            onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                    @endif
                                </div>
                            </a>

                            <div class="p-3">
                                <a
                                    href="{{ auth()->check() ? route('products.show', $product['slug']) : route('login') }}">
                                    {{-- Ganti hover:text-green-600 dengan hover:text-kl-green --}}
                                    <h3 class="font-medium text-gray-900 mb-1 line-clamp-2 hover:text-kl-green">
                                        {{ $product['name'] }}
                                    </h3>
                                </a>

                                <div class="flex items-baseline gap-2 mb-3">
                                    {{-- Ganti text-green-600 dengan text-kl-green --}}
                                    <span class="text-lg font-bold text-kl-green">
                                        Rp{{ number_format($product['price'], 0, ',', '.') }}
                                    </span>
                                </div>

                                @auth
                                    <button wire:click="addToCart({{ $product['id'] }})" {{-- Ganti bg-green-600 dengan bg-kl-green dan hover:bg-green-700 dengan hover:bg-kl-green-dark --}}
                                        class="w-full bg-kl-green text-white py-2 rounded-lg font-medium hover:bg-kl-green-dark transition-colors text-sm">
                                        Beli
                                    </button>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block w-full bg-gray-600 text-white text-center py-2 rounded-lg font-medium hover:bg-gray-700 transition-colors text-sm">
                                        Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

{{-- 3. Inisialisasi Script Carousel --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Splide !== 'undefined') {
            var splide = new Splide('#hero-slider', {
                type: 'loop', // Carousel berulang
                autoplay: true, // Otomatis berputar
                interval: 5000, // Durasi 5 detik per slide
                pauseOnHover: true,
                arrows: false, // Sembunyikan panah
                pagination: true, // Tampilkan indikator dots
            });

            splide.mount();
        }
    });
</script>
