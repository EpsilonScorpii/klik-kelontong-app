<div class="min-h-screen bg-gray-50 pb-24">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-center relative sticky top-0 z-40">
        <h1 class="text-base font-semibold text-gray-900">Pembayaran</h1>
    </div>

    <div class="px-4 py-6">
        
        <!-- Saved Cards -->
        @if(count($savedCards) > 0)
        <div class="mb-6">
            <h2 class="text-base font-bold text-gray-900 mb-3">Kartu Tersimpan</h2>
            <div class="space-y-3">
                @foreach($savedCards as $card)
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-6 text-white relative overflow-hidden">
                    <!-- Card Pattern -->
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full"></div>
                    <div class="absolute -right-20 -bottom-10 w-60 h-60 bg-white/5 rounded-full"></div>
                    
                    <!-- Card Content -->
                    <div class="relative">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <p class="text-xs opacity-70 mb-1">Card Type</p>
                                <p class="font-semibold">{{ strtoupper($card['card_type'] ?? 'VISA') }}</p>
                            </div>
                            <button wire:click="deletePaymentMethod({{ $card['id'] }})" class="text-white/70 hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mb-6">
                            <p class="text-2xl tracking-wider font-mono">•••• •••• •••• {{ substr($card['card_number'], -4) }}</p>
                        </div>
                        
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-xs opacity-70 mb-1">Card Holder</p>
                                <p class="font-medium">{{ $card['card_holder_name'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs opacity-70 mb-1">Expiry</p>
                                <p class="font-medium">{{ $card['expiry_date'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- E-Wallets -->
        <div class="mb-6">
            <h2 class="text-base font-bold text-gray-900 mb-3">E-Wallet</h2>
            <div class="bg-white rounded-xl border-2 border-gray-200 divide-y divide-gray-100">
                
                <div class="p-4 flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-medium text-gray-900">Dana</h3>
                        <p class="text-sm text-gray-500">Connected</p>
                    </div>
                    <button class="text-sm text-red-600 font-medium">Hapus</button>
                </div>

                <div class="p-4 flex items-center gap-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-purple-600" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-medium text-gray-900">OVO</h3>
                        <p class="text-sm text-gray-500">Not connected</p>
                    </div>
                    <button class="text-sm text-green-600 font-medium">Hubungkan</button>
                </div>

                <div class="p-4 flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="4" y="4" width="16" height="16" rx="3"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-medium text-gray-900">Gopay</h3>
                        <p class="text-sm text-gray-500">Not connected</p>
                    </div>
                    <button class="text-sm text-green-600 font-medium">Hubungkan</button>
                </div>
            </div>
        </div>

        <!-- Add New Button -->
        <button wire:click="toggleAddCardModal"
                class="w-full border-2 border-dashed border-green-400 bg-green-50 text-green-700 rounded-xl p-4 font-semibold hover:bg-green-100 transition-colors">
            + Tambah Kartu Debit/Kredit
        </button>
    </div>

    <!-- Add Card Modal -->
    @if($showAddCardModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="toggleAddCardModal"></div>
        
        <div class="flex min-h-screen items-end justify-center p-0 md:items-center md:p-4">
            <div class="relative w-full max-w-md bg-white rounded-t-3xl md:rounded-2xl shadow-2xl" @click.stop>
                
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Tambah Kartu</h3>
                    <button wire:click="toggleAddCardModal" class="p-1 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-6">
                    <!-- Card Preview -->
                    <div class="bg-gradient-to-br from-amber-800 to-amber-950 rounded-2xl p-6 text-white mb-6 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full"></div>
                        
                        <div class="relative">
                            <div class="flex justify-between items-start mb-4">
                                <p class="text-sm opacity-70">Classic Debit</p>
                                <div class="text-yellow-400 font-bold text-2xl">N</div>
                            </div>
                            
                            <div class="mb-6">
                                <div class="w-12 h-8 bg-yellow-400/20 rounded mb-4"></div>
                                <p class="text-xl tracking-wider font-mono">3456 4325 2367 4356</p>
                            </div>
                            
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-xs opacity-70 mb-1">VALID<br>THRU</p>
                                    <p class="text-sm">04/14 - 03/24</p>
                                    <p class="text-sm mt-1">A.N. OTHER</p>
                                </div>
                                <div class="bg-white rounded px-3 py-1">
                                    <span class="text-blue-900 font-bold text-lg">VISA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Card Holder Name</label>
                            <input type="text" 
                                   placeholder="A.N. OTHER"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                            <input type="text" 
                                   placeholder="1234 5678 9012 3456"
                                   maxlength="19"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                <input type="text" 
                                       placeholder="MM/YY"
                                       maxlength="5"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                <input type="text" 
                                       placeholder="123"
                                       maxlength="3"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Save Card</span>
                        </label>
                    </form>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    <button class="w-full bg-green-700 text-white py-3 rounded-xl font-semibold hover:bg-green-800">
                        Save Card
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>