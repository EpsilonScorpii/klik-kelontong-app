<div class="min-h-screen bg-gray-50 pb-20 md:pb-6">
    
    <!-- Header dengan Search Bar -->
    <div class="bg-white border-b border-gray-200 sticky top-[104px] md:top-[120px] z-40">
        <div class="px-4 py-4">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center gap-3">
                    <!-- Back Button -->
                    <button onclick="history.back()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </button>

                    <h1 class="text-lg font-bold text-gray-900">Search</h1>
                </div>

                <!-- Search Input -->
                <div class="relative mt-4">
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchQuery"
                           placeholder="Search"
                           class="w-full rounded-full border-gray-300 pl-12 pr-12 py-3 focus:border-green-500 focus:ring-green-500">
                    
                    <!-- Search Icon -->
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>

                    <!-- Clear Button -->
                    @if(!empty($searchQuery))
                        <button wire:click="$set('searchQuery', '')" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 p-1 hover:bg-gray-100 rounded-full">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        
        @if(empty($searchQuery))
            <!-- Recent Searches -->
            @if(count($recentSearches) > 0)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Recent</h2>
                        <button wire:click="clearRecentSearches" class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                            Clear All
                        </button>
                    </div>

                    <div class="space-y-3">
                        @foreach($recentSearches as $recent)
                            <div class="flex items-center justify-between py-2 hover:bg-gray-50 rounded-lg px-2 -mx-2">
                                <button wire:click="selectRecentSearch('{{ $recent }}')" 
                                        class="flex-1 text-left text-gray-700">
                                    {{ $recent }}
                                </button>
                                <button wire:click="removeRecentSearch('{{ $recent }}')"
                                        class="p-1 hover:bg-gray-200 rounded-full">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">Cari produk yang Anda butuhkan</p>
                </div>
            @endif
        @else
            <!-- Search Results -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-base font-medium text-gray-700">
                    Result for "{{ $searchQuery }}"
                    @if($resultCount > 0)
                        <span class="text-gray-500">({{ $resultCount }})</span>
                    @endif
                </h2>
                <button wire:click="toggleFilterModal" 
                        class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                </button>
            </div>

            @if($resultCount > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($products as $product)
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                            <a href="{{ auth()->check() ? route('products.show', $product->slug) : route('login') }}" class="block">
                                <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            
                            <div class="p-3">
                                <a href="{{ auth()->check() ? route('products.show', $product->slug) : route('login') }}">
                                    <h3 class="font-medium text-gray-900 mb-1 line-clamp-2 text-sm hover:text-green-600">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-base font-bold text-gray-900">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Rating & Reviews -->
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                        <span class="text-xs text-gray-600">4.9</span>
                                    </div>
                                    <span class="text-xs text-gray-400">• 500 terjual</span>
                                </div>
                                
                                <button class="w-full bg-green-600 text-white py-2 rounded-lg font-medium hover:bg-green-700 transition-colors text-sm">
                                    Beli
                                </button>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-900 text-lg font-medium mb-2">Produk tidak ditemukan</p>
                    <p class="text-gray-500 mb-4">Coba kata kunci lain atau hapus filter</p>
                    <button wire:click="resetFilters" 
                            class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                        Reset Filter
                    </button>
                </div>
            @endif
        @endif
    </div>

    <!-- Filter Modal -->
    @if($showFilterModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="toggleFilterModal"></div>
            
            <div class="flex min-h-screen items-end justify-center md:items-center p-0 md:p-4">
                <div class="relative w-full max-w-2xl bg-white rounded-t-3xl md:rounded-2xl shadow-2xl transform transition-all" @click.stop>
                    
                    <!-- Header -->
                    <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-3xl md:rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900">Filter</h3>
                            <button wire:click="toggleFilterModal" class="p-1 hover:bg-gray-100 rounded-full">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                        
                        <!-- Brands -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Brands</h4>
                            <div class="flex flex-wrap gap-2">
                                <button wire:click="$set('selectedBrand', 'all')"
                                        class="px-4 py-2 rounded-full font-medium transition-colors {{ $selectedBrand === 'all' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                    All
                                </button>
                                @foreach($brands as $brand)
                                    <button wire:click="$set('selectedBrand', {{ $brand['id'] }})"
                                            class="px-4 py-2 rounded-full font-medium transition-colors {{ $selectedBrand == $brand['id'] ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                        {{ $brand['name'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Size -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Size</h4>
                            <div class="flex flex-wrap gap-2">
                                <button wire:click="$set('selectedSize', 'all')"
                                        class="px-4 py-2 rounded-full font-medium transition-colors {{ $selectedSize === 'all' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                    All
                                </button>
                                @foreach($sizes as $size)
                                    <button wire:click="$set('selectedSize', '{{ $size['value'] }}')"
                                            class="px-4 py-2 rounded-full font-medium transition-colors {{ $selectedSize === $size['value'] ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                        {{ $size['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Sort by -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Sort by</h4>
                            <div class="flex flex-wrap gap-2">
                                <button wire:click="$set('sortBy', 'most_recent')"
                                        class="px-4 py-2 rounded-full font-medium transition-colors {{ $sortBy === 'most_recent' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                    Most Recent
                                </button>
                                <button wire:click="$set('sortBy', 'popular')"
                                        class="px-4 py-2 rounded-full font-medium transition-colors {{ $sortBy === 'popular' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                    Popular
                                </button>
                                <button wire:click="$set('sortBy', 'low_price')"
                                        class="px-4 py-2 rounded-full font-medium transition-colors {{ $sortBy === 'low_price' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                    Low Price
                                </button>
                            </div>
                        </div>

                        <!-- Pricing Range -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Pricing Range</h4>
                            
                            <div class="px-2">
                                <!-- Price Range Slider -->
                                <div class="relative pt-1 mb-4">
                                    <input type="range" 
                                           wire:model.live="priceMax"
                                           min="0" 
                                           max="150000" 
                                           step="1000"
                                           class="w-full h-2 bg-green-200 rounded-lg appearance-none cursor-pointer accent-green-600">
                                </div>

                                <!-- Price Labels -->
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Rp0</span>
                                    <span>Rp10k</span>
                                    <span>Rp20k</span>
                                    <span>Rp50k</span>
                                    <span>Rp100k</span>
                                    <span>Rp150k+</span>
                                </div>

                                <!-- Selected Range Display -->
                                <div class="text-center mt-4">
                                    <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium">
                                        Rp{{ number_format($priceMin, 0, ',', '.') }} - Rp{{ number_format($priceMax, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Reviews</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                                    <input type="radio" 
                                           wire:model.live="selectedRating"
                                           value="4.5"
                                           class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <div class="flex items-center gap-2">
                                        <div class="flex gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-700">4.5 and above</span>
                                    </div>
                                </label>

                                <label class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                                    <input type="radio" 
                                           wire:model.live="selectedRating"
                                           value="4.0"
                                           class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <div class="flex items-center gap-2">
                                        <div class="flex gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-700">4.0 - 4.5</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex gap-3">
                        <button wire:click="resetFilters" 
                                class="flex-1 px-6 py-3 bg-green-100 text-green-700 font-semibold rounded-xl hover:bg-green-200 transition-colors">
                            Reset Filter
                        </button>
                        <button wire:click="applyFilters" 
                                class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Loading Overlay -->
    <div wire:loading class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 shadow-2xl">
            <div class="flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 font-medium">Searching...</span>
            </div>
        </div>
    </div>
</div>