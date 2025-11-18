<div class="min-h-screen bg-gray-50 pb-20">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-center relative sticky top-0 z-40">
        <button onclick="history.back()" class="absolute left-4 p-2 -m-2">
            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <h1 class="text-base font-semibold text-gray-900">Coupon</h1>
    </div>

    <div class="px-4 py-6">
        
        <!-- Section Title -->
        <h2 class="text-base font-bold text-gray-900 mb-4">Best offers for you</h2>

        <!-- Coupons List -->
        <div class="space-y-4">
            @forelse($availableCoupons as $coupon)
                @php
                    $canUse = $this->canUseCoupon($coupon);
                    $remaining = $this->getRemainingAmount($coupon);
                @endphp

                <div class="bg-white border-2 border-gray-200 rounded-2xl overflow-hidden">
                    <!-- Coupon Header -->
                    <div class="px-4 pt-4 pb-3">
                        <h3 class="text-base font-bold text-gray-900 mb-1">{{ $coupon['name'] }}</h3>
                        
                        @if(!$canUse)
                            <p class="text-sm text-gray-600 mb-3">
                                Add items worth Rp {{ number_format($remaining, 0, ',', '.') }} more to unlock
                            </p>
                        @else
                            <p class="text-sm text-green-600 mb-3">
                                ✅ Syarat minimum terpenuhi
                            </p>
                        @endif

                        <!-- Coupon Benefits -->
                        <div class="flex items-start gap-2">
                            <div class="w-8 h-8 bg-gray-900 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    @if($coupon['type'] === 'free_delivery')
                                        Get Free Delivery Up to Rp {{ number_format($coupon['value'], 0, ',', '.') }}
                                    @elseif($coupon['type'] === 'percentage')
                                        Get {{ $coupon['value'] }}% OFF
                                    @elseif($coupon['type'] === 'fixed_amount')
                                        Get Discount Rp {{ number_format($coupon['value'], 0, ',', '.') }}
                                    @else
                                        Special Offer
                                    @endif
                                </p>
                                @if($coupon['description'])
                                    <p class="text-xs text-gray-500 mt-1">{{ $coupon['description'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Use Coupon Button -->
                    <button wire:click="useCoupon({{ $coupon['id'] }})"
                            class="w-full py-3 text-center font-semibold transition-colors {{ $canUse ? 'bg-green-400 text-white hover:bg-green-500' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
                            {{ !$canUse ? 'disabled' : '' }}>
                        USE COUPON
                    </button>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    <p class="text-lg font-medium text-gray-900 mb-2">Belum ada kupon tersedia</p>
                    <p class="text-gray-500 mb-6">Pantau terus untuk penawaran menarik!</p>
                    <a href="{{ route('home') }}" 
                       class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                        Kembali Belanja
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Info Box -->
        @if(count($availableCoupons) > 0)
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-blue-900 mb-1">Cara menggunakan kupon:</h4>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• Pilih kupon yang ingin digunakan</li>
                        <li>• Pastikan total belanja memenuhi syarat minimum</li>
                        <li>• Klik "USE COUPON" untuk menerapkan</li>
                        <li>• Kupon akan otomatis diterapkan di halaman checkout</li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>

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