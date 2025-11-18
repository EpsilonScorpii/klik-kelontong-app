<div class="pb-20 md:pb-6">
    
    <!-- Page Header -->
    <section class="bg-white border-b border-gray-200 px-4 py-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">🛍️ Semua Produk</h1>
            
            <!-- Filters & Sort -->
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchQuery"
                           placeholder="🔍 Cari produk..."
                           class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                </div>
                
                <!-- Category Filter -->
                <select wire:model.live="selectedCategory"
                        class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                    @endforeach
                </select>
                
                <!-- Sort -->
                <select wire:model.live="sortBy"
                        class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    <option value="latest">Terbaru</option>
                    <option value="price_asc">Harga Terendah</option>
                    <option value="price_desc">Harga Tertinggi</option>
                    <option value="popular">Terpopuler</option>
                </select>
                
                @if($selectedCategory || $searchQuery)
                    <button wire:click="clearFilter"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 whitespace-nowrap">
                        🔄 Reset
                    </button>
                @endif
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="px-4 py-8">
        <div class="max-w-7xl mx-auto">
            
            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($products as $product)
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow group">
                            <!-- ✅ Thumbnail PUBLIC - Bisa diklik tanpa login -->
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                             onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    @if($product->discount_price > 0)
                                        <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                            -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                        </div>
                                    @endif

                                    <!-- 🔒 Badge "Login untuk detail" -->
                                    @guest
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                                            <span class="opacity-0 group-hover:opacity-100 bg-white text-green-600 px-4 py-2 rounded-lg font-semibold text-sm transition-opacity">
                                                🔒 Login untuk detail
                                            </span>
                                        </div>
                                    @endguest
                                </div>
                            </a>
                            
                            <div class="p-3">
                                <!-- ✅ Nama Produk PUBLIC -->
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <h3 class="font-medium text-gray-900 mb-1 line-clamp-2 hover:text-green-600">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                
                                <!-- ✅ Harga PUBLIC -->
                                <div class="flex items-baseline gap-2 mb-3">
                                    <span class="text-lg font-bold text-green-600">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    @if($product->discount_price > 0)
                                        <span class="text-sm text-gray-400 line-through">
                                            Rp{{ number_format($product->discount_price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- ✅ Stok PUBLIC (tapi tidak exact number) -->
                                <div class="flex items-center gap-1 text-xs text-gray-600 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <span>{{ $product->stock > 10 ? 'Stok tersedia' : 'Stok terbatas' }}</span>
                                </div>
                                
                                <!-- 🔒 Button - Redirect ke login jika belum login -->
                                @auth
                                    <a href="{{ route('products.show', $product->slug) }}"
                                       class="block w-full bg-green-600 text-white text-center py-2 rounded-lg font-medium hover:bg-green-700 transition-colors text-sm">
                                        Lihat Detail
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="block w-full bg-gray-600 text-white text-center py-2 rounded-lg font-medium hover:bg-gray-700 transition-colors text-sm">
                                        🔒 Login untuk Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-xl font-medium text-gray-900 mb-2">Produk tidak ditemukan</p>
                    <p class="text-gray-600 mb-4">Coba kata kunci atau filter lain</p>
                    <button wire:click="clearFilter"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                        Reset Filter
                    </button>
                </div>
            @endif
        </div>
    </section>
</div>