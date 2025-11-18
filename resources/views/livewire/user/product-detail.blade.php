<div class="pb-20 md:pb-6">

    <!-- Header dengan Back Button -->
    <div class="bg-white border-b border-gray-200 sticky top-[104px] md:top-[120px] z-40 px-4 py-3">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <button onclick="history.back()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>
            <h1 class="text-lg font-bold text-gray-900">Product Detail</h1>
            <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-6">

        <!-- Product Image -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <div class="aspect-square max-w-md mx-auto bg-gray-50 rounded-xl overflow-hidden">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-full object-contain"
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

            <!-- Image Thumbnails (✅ Safe check untuk productImages) -->
            @if (!empty($productImages) && count($productImages) > 1)
                <div class="flex gap-2 mt-4 overflow-x-auto">
                    @foreach ($productImages as $image)
                        <div
                            class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-green-500">
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

        <!-- Product Info -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <!-- Product Name -->
            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>

            <!-- Price -->
            <div class="flex items-baseline gap-3 mb-4">
                <span class="text-3xl font-bold text-green-600">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
                @if ($product->discount_price > 0)
                    <span class="text-lg text-gray-400 line-through">
                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                    </span>
                    <span class="bg-red-100 text-red-600 text-sm font-bold px-2 py-1 rounded">
                        -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                    </span>
                @endif
            </div>

            <!-- Category & Stock -->
            <div class="flex items-center gap-4 mb-4 text-sm">
                <div class="flex items-center gap-1 text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span>{{ $product->category->name ?? 'Uncategorized' }}</span>
                </div>
                <span class="text-gray-300">•</span>
                <div class="flex items-center gap-1 {{ $product->stock > 10 ? 'text-green-600' : 'text-orange-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="font-medium">Stok: {{ $product->stock }}</span>
                </div>
            </div>

            <!-- Description -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </p>
            </div>
        </div>

        <!-- Select Variant (if available) -->
        @if (count($variants) > 0)
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Select Size</h3>
                <div class="flex gap-3">
                    @foreach ($variants as $variant)
                        <button wire:click="selectVariant('{{ $variant['value'] }}')"
                            class="px-6 py-3 rounded-lg font-medium transition-all {{ $selectedVariant === $variant['value'] ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $variant['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Quantity Selector -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4">Jumlah</h3>
            <div class="flex items-center gap-4">
                <button wire:click="decrementQuantity"
                    class="w-10 h-10 flex items-center justify-center bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ $quantity <= 1 ? 'disabled' : '' }}>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </button>

                <input type="number" wire:model.live.debounce.300ms="quantity" wire:change="updateQuantity"
                    min="1" max="{{ $product->stock }}"
                    class="w-20 text-center text-lg font-bold border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500">

                <button wire:click="incrementQuantity"
                    class="w-10 h-10 flex items-center justify-center bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ $quantity >= $product->stock ? 'disabled' : '' }}>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>

                <span class="text-sm text-gray-600 ml-auto">
                    Maks. {{ $product->stock }} unit
                </span>
            </div>
        </div>
    </div>

    <!-- Bottom Action Bar (Sticky) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-4 z-40 shadow-lg">
        <div class="max-w-4xl mx-auto flex items-center gap-4">
            <!-- Total Price -->
            <div class="flex-1">
                <p class="text-xs text-gray-600 mb-1">Total Price</p>
                <p class="text-2xl font-bold text-gray-900">
                    Rp{{ number_format($totalPrice, 0, ',', '.') }}
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button wire:click="addToCart" wire:loading.attr="disabled"
                    class="px-6 py-3 bg-white border-2 border-green-600 text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
                    <span wire:loading wire:target="addToCart">Loading...</span>
                </button>

                <button wire:click="buyNow" wire:loading.attr="disabled"
                    class="px-8 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="buyNow">Beli Sekarang</span>
                    <span wire:loading wire:target="buyNow">Processing...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 shadow-2xl">
            <div class="flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
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
