<div class="min-h-screen bg-white pb-32">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-center relative sticky top-0 z-40">
        <button onclick="history.back()" class="absolute left-4 p-2 -m-2">
            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <h1 class="text-base font-semibold text-gray-900">My Cart</h1>
    </div>

    <div class="px-4 py-4">
        
        @if(count($cartItems) > 0)
            <!-- Cart Items -->
            <div class="space-y-4 mb-6">
                @foreach($cartItems as $item)
                    <div class="flex gap-3 relative {{ $loop->last ? 'pb-4' : 'pb-4 border-b border-gray-100' }}">
                        <!-- Product Image -->
                        <div class="w-20 h-20 bg-gray-50 rounded-lg flex-shrink-0 p-2">
                            @if($item['product']['image'])
                                <img src="{{ asset('storage/' . $item['product']['image']) }}" 
                                     alt="{{ $item['product']['name'] }}"
                                     class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $item['product']['name'] }}</h3>
                            <p class="text-xs text-gray-500 mb-1">
                                Size: {{ $item['product']['unit'] ?? '-' }} | Qty: {{ $item['quantity'] }}pcs
                            </p>
                            <p class="text-sm font-bold text-gray-900">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="flex flex-col items-end justify-between">
                            <div class="flex items-center gap-2">
                                <button wire:click="decrementQuantity({{ $item['id'] }})"
                                        class="w-8 h-8 flex items-center justify-center border-2 border-gray-900 rounded-lg hover:bg-gray-50 disabled:opacity-50"
                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>

                                <input type="number" 
                                       value="{{ $item['quantity'] }}"
                                       wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)"
                                       min="1"
                                       max="{{ $item['product']['stock'] }}"
                                       class="w-10 text-center border-0 text-sm font-semibold focus:ring-0">

                                <button wire:click="incrementQuantity({{ $item['id'] }})"
                                        class="w-8 h-8 flex items-center justify-center border-2 border-gray-900 rounded-lg hover:bg-gray-50 disabled:opacity-50"
                                        {{ $item['quantity'] >= $item['product']['stock'] ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Delete Button -->
                        @if($loop->last)
                            <button wire:click="confirmRemove({{ $item['id'] }})"
                                    class="absolute right-0 top-0 bottom-0 w-16 bg-red-500 text-white flex items-center justify-center rounded-r-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-lg font-medium text-gray-900 mb-2">Keranjang Kosong</p>
                <p class="text-gray-500 mb-6">Belum ada produk di keranjang Anda</p>
                <a href="{{ route('home') }}" 
                   class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    <!-- Bottom Summary (Sticky) -->
    @if(count($cartItems) > 0)
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-4 shadow-lg">
        <div class="max-w-2xl mx-auto">
            
            <!-- Promo Code Section -->
            @if($appliedCoupon)
                <!-- Applied Coupon Display -->
                <div class="flex items-center gap-3 mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/>
                            </svg>
                            <span class="text-sm font-semibold text-green-800">{{ $appliedCoupon->code }}</span>
                        </div>
                        <p class="text-xs text-green-700 mt-1">{{ $appliedCoupon->name }}</p>
                    </div>
                    <button wire:click="removeCoupon" class="text-red-600 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @else
                <!-- Promo Code Input -->
                <div class="flex gap-2 mb-4">
                    <input type="text" 
                           wire:model="promoCode"
                           placeholder="Promo Code"
                           class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <button wire:click="applyPromoCode"
                            wire:loading.attr="disabled"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 disabled:opacity-50">
                        <span wire:loading.remove wire:target="applyPromoCode">Apply</span>
                        <span wire:loading wire:target="applyPromoCode">...</span>
                    </button>
                </div>

                <!-- View All Coupons Button -->
                <button wire:click="goToCoupons"
                        class="w-full mb-4 py-2 border-2 border-green-600 text-green-600 rounded-lg text-sm font-semibold hover:bg-green-50 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/>
                    </svg>
                    Lihat Semua Kupon
                </button>
            @endif

            <!-- Summary -->
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Sub-total</span>
                    <span class="font-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Delivery Fee</span>
                    <span class="font-semibold">Rp{{ number_format($deliveryFee, 0, ',', '.') }}</span>
                </div>
                @if($discount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Discount</span>
                    <span class="font-semibold text-green-600">-Rp{{ number_format($discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-sm pt-2 border-t border-gray-200">
                    <span class="text-gray-600">Total Cost</span>
                    <span class="font-bold text-base">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Checkout Button -->
            <button wire:click="proceedToCheckout"
                    wire:loading.attr="disabled"
                    class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="proceedToCheckout">Proceed to Checkout</span>
                <span wire:loading wire:target="proceedToCheckout">Processing...</span>
            </button>
        </div>
    </div>
    @endif

    <!-- Remove Confirmation Modal -->
    @if($showRemoveModal && $itemToRemove)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="cancelRemove"></div>
        
        <div class="flex min-h-screen items-end justify-center p-0 md:items-center md:p-4">
            <div class="relative w-full max-w-md bg-white rounded-t-3xl md:rounded-2xl shadow-2xl transform transition-all" @click.stop>
                
                <div class="px-6 py-4 text-center border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Remove from Cart</h3>
                </div>

                <div class="px-6 py-6">
                    <div class="flex gap-4 items-center mb-4">
                        <div class="w-20 h-20 bg-gray-50 rounded-lg flex-shrink-0 p-2">
                            @if($itemToRemove->product->image)
                                <img src="{{ asset('storage/' . $itemToRemove->product->image) }}" 
                                     alt="{{ $itemToRemove->product->name }}"
                                     class="w-full h-full object-contain">
                            @endif
                        </div>

                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900 mb-1">{{ $itemToRemove->product->name }}</h4>
                            <p class="text-xs text-gray-500 mb-1">
                                Size: {{ $itemToRemove->product->unit ?? '-' }} | Qty: {{ $itemToRemove->quantity }}pcs
                            </p>
                            <p class="text-sm font-bold text-gray-900">Rp {{ number_format($itemToRemove->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-4 mb-6">
                        <button wire:click="decrementQuantity({{ $itemToRemove->id }})"
                                class="w-10 h-10 flex items-center justify-center border-2 border-gray-900 rounded-lg"
                                {{ $itemToRemove->quantity <= 1 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>

                        <span class="text-lg font-bold text-gray-900 min-w-[2rem] text-center">{{ $itemToRemove->quantity }}</span>

                        <button wire:click="incrementQuantity({{ $itemToRemove->id }})"
                                class="w-10 h-10 flex items-center justify-center border-2 border-gray-900 rounded-lg"
                                {{ $itemToRemove->quantity >= $itemToRemove->product->stock ? 'disabled' : '' }}>
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="cancelRemove" 
                                class="flex-1 px-6 py-3 bg-green-100 text-green-700 font-semibold rounded-xl hover:bg-green-200 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="removeFromCart" 
                                class="flex-1 px-6 py-3 bg-green-700 text-white font-semibold rounded-xl hover:bg-green-800 transition-colors">
                            Yes, Remove
                        </button>
                    </div>
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
                <span class="text-gray-700 font-medium">Loading...</span>
            </div>
        </div>
    </div>
</div>