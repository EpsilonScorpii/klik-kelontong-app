<div class="pb-20 md:pb-6">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-40 px-4 py-3">
        <div class="max-w-4xl mx-auto flex items-center justify-start relative">

            {{-- Back Button --}}
            <button onclick="history.back()" class="p-2 hover:bg-gray-100 rounded-full transition-colors absolute left-0">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>

            {{-- Title di Tengah --}}
            <h1 class="text-lg font-bold text-gray-900 mx-auto">Product Detail</h1>

            {{-- Share Button Dihilangkan dari Header --}}
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-6">

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            {{-- Hapus aspect-square dan max-w-md untuk membuat gambar lebih fokus di tengah --}}
            <div class="mx-auto flex justify-center items-center h-64 sm:h-80 bg-gray-50 rounded-xl overflow-hidden">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="h-full w-auto object-contain"
                        onerror="this.src='https://via.placeholder.com/500x500?text={{ urlencode($product->name) }}'">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>

            @if (!empty($productImages) && count($productImages) > 1)
                <div class="flex gap-2 mt-4 overflow-x-auto">
                    @foreach ($productImages as $image)
                        <div
                            class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-kl-green">
                            @if (is_array($image) && isset($image['image_path']))
                                <img src="{{ asset('storage/' . $image['image_path']) }}" alt="Thumbnail"
                                    class="w-full h-full object-cover">
                            @elseif(is_string($image))
                                <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail"
                                    class="w-full h-full object-cover">
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white p-0 mb-6">

            <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>

            <div class="flex items-baseline gap-3 mb-4">
                {{-- Hanya tampilkan harga utama, format diperkecil --}}
                <span class="text-xl font-bold text-gray-900">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>

                {{-- Logika Diskon Dihilangkan dari Tampilan Utama (Sesuai Desain) --}}
            </div>

            <div class="pb-4">
                {{-- Hapus border-t --}}
                <h3 class="font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </p>
            </div>

            {{-- Category & Stock Dihilangkan (Sesuai Desain) --}}
        </div>

        @if (count($variants) > 0)
            <div class="bg-white p-0 mb-6"> {{-- Hapus shadow dan rounded --}}
                <h3 class="font-bold text-gray-900 mb-4">Select Size</h3>
                <div class="flex gap-3">
                    @foreach ($variants as $variant)
                        <button wire:click="selectVariant('{{ $variant['value'] }}')" {{-- Ubah styling tombol varian --}}
                            class="px-6 py-3 rounded-lg font-medium transition-all text-sm
                            {{ $selectedVariant === $variant['value'] ? 'bg-kl-green text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ $variant['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Jika Anda tetap ingin Quantity, pindahkan logic Quantity ke dalam Bottom Action Bar --}}

    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white z-40 ">
        <div class="bottom-0 left-0 right-0 bg-white py-1 px-3 shadow-xl 
             rounded-3xl border border-black">
            <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">

                <div class="flex-1">
                    <p class="text-sm text-gray-700 font-bold mb-1">Total Price</p>
                    {{-- Format harga disesuaikan dengan desain --}}
                    <p class="text-xl font-bold text-gray-900">
                        Rp{{ number_format($totalPrice, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex gap-3">
                    <button wire:click="addToCart" wire:loading.attr="disabled" {{-- Tombol utama menggunakan kl-green --}}
                        class="px-8 py-3 bg-kl-green text-white font-semibold rounded-full hover:bg-kl-green-dark transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
                        <span wire:loading wire:target="addToCart">Loading...</span>
                    </button>
                </div>

                {{-- Tombol "Beli Sekarang" Dihapus sesuai desain --}}
            </div>
        </div>
    </div>

    {{-- Loading Indicator tetap dipertahankan --}}
    <div wire:loading class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 shadow-2xl">
            <div class="flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-kl-green" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-gray-700 font-medium">Loading...</span>
            </div>
        </div>
    </div>
</div>
