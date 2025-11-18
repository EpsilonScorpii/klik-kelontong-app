<div class="min-h-screen bg-gray-50 pb-24">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-center relative sticky top-0 z-40">
        <a href="{{ route('orders') }}" class="absolute left-4 p-2 -m-2">
            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-base font-semibold text-gray-900">Pembayaran</h1>
    </div>

    <div class="px-4 py-6">
        
        <!-- COD Section -->
        <div class="mb-6">
            <h2 class="text-base font-bold text-gray-900 mb-3">COD</h2>
            <button wire:click="selectPaymentMethod('cod')"
                    class="w-full bg-white border-2 rounded-xl p-4 transition-all {{ $selectedPaymentMethod === 'cod' ? 'border-green-600 ring-2 ring-green-100' : 'border-gray-200' }}">
                <div class="flex items-center gap-3">
                    <!-- Icon -->
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>

                    <!-- Name -->
                    <div class="flex-1 text-left">
                        <h3 class="text-base font-medium text-gray-900">Cash On Delivery</h3>
                    </div>

                    <!-- Radio -->
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $selectedPaymentMethod === 'cod' ? 'border-green-600' : 'border-gray-300' }}">
                            @if($selectedPaymentMethod === 'cod')
                                <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </button>
        </div>

        <!-- E-Wallet Section -->
        <div class="mb-6">
            <h2 class="text-base font-bold text-gray-900 mb-3">E-Wallet</h2>
            <div class="bg-white rounded-xl border-2 border-gray-200 divide-y divide-gray-100">
                
                <!-- DANA -->
                <button wire:click="selectPaymentMethod('dana')"
                        class="w-full p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <!-- Icon -->
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 8v8M8 12h8" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <!-- Name -->
                        <div class="flex-1 text-left">
                            <h3 class="text-base font-medium text-gray-900">Dana</h3>
                        </div>

                        <!-- Radio -->
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $selectedPaymentMethod === 'dana' ? 'border-green-600' : 'border-gray-300' }}">
                                @if($selectedPaymentMethod === 'dana')
                                    <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </button>

                <!-- OVO -->
                <button wire:click="selectPaymentMethod('ovo')"
                        class="w-full p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <!-- Icon -->
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-600" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="10"/>
                                <circle cx="12" cy="12" r="4" fill="white"/>
                            </svg>
                        </div>

                        <!-- Name -->
                        <div class="flex-1 text-left">
                            <h3 class="text-base font-medium text-gray-900">OVO</h3>
                        </div>

                        <!-- Radio -->
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $selectedPaymentMethod === 'ovo' ? 'border-green-600' : 'border-gray-300' }}">
                                @if($selectedPaymentMethod === 'ovo')
                                    <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </button>

                <!-- Gopay -->
                <button wire:click="selectPaymentMethod('gopay')"
                        class="w-full p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <!-- Icon -->
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                                <rect x="4" y="4" width="16" height="16" rx="3"/>
                                <path d="M12 8v8M8 12h8" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <!-- Name -->
                        <div class="flex-1 text-left">
                            <h3 class="text-base font-medium text-gray-900">Gopay</h3>
                        </div>

                        <!-- Radio -->
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $selectedPaymentMethod === 'gopay' ? 'border-green-600' : 'border-gray-300' }}">
                                @if($selectedPaymentMethod === 'gopay')
                                    <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Ringkasan Pembayaran</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Belanja</span>
                    <span class="font-medium">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Ongkir</span>
                    <span class="font-medium">Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                </div>
                @if($order->discount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Diskon</span>
                    <span class="font-medium text-green-600">-Rp{{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-base font-bold pt-2 border-t border-gray-200">
                    <span>Total Bayar</span>
                    <span class="text-green-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Button -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-4 shadow-lg">
        <div class="max-w-2xl mx-auto">
            <button wire:click="processPayment"
                    wire:loading.attr="disabled"
                    class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="processPayment">Bayar Sekarang</span>
                <span wire:loading wire:target="processPayment">Processing...</span>
            </button>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div wire:loading.delay class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 shadow-2xl">
            <div class="flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 font-medium">Processing Payment...</span>
            </div>
        </div>
    </div>
</div>