<div class="min-h-screen bg-gray-50 pb-24">

    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 sticky top-0 z-40">
        <div class="flex items-center justify-center relative">
            <button wire:click="previousStep" class="absolute left-0 p-2 -m-2">
                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h1 class="text-base font-semibold text-gray-900">Checkout</h1>
        </div>
    </div>

    <div class="px-4 py-6">

        <!-- STEP 1: Shipping Address -->
        @if ($currentStep === 1)
            <div class="space-y-3 mb-6">
                @forelse($addresses as $address)
                    <button wire:click="selectAddress({{ $address['id'] }})"
                        class="w-full text-left bg-white border-2 rounded-xl p-4 transition-all {{ $selectedAddressId === $address['id'] ? 'border-green-600 ring-2 ring-green-100' : 'border-gray-200' }}">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 {{ $selectedAddressId === $address['id'] ? 'text-green-600' : 'text-gray-600' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 mb-1">{{ $address['label'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $address['address'] }}</p>
                                @if ($address['is_default'])
                                    <span
                                        class="inline-block mt-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded font-medium">Default</span>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <div
                                    class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $selectedAddressId === $address['id'] ? 'border-green-600' : 'border-gray-300' }}">
                                    @if ($selectedAddressId === $address['id'])
                                        <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">Belum ada alamat pengiriman</p>
                    </div>
                @endforelse

                <button wire:click="toggleAddAddressModal"
                    class="w-full border-2 border-dashed border-green-400 bg-green-50 text-green-700 rounded-xl p-4 font-medium hover:bg-green-100 transition-colors">
                    + Add New Shipping Address
                </button>
            </div>
        @endif

        <!-- STEP 2: Choose Shipping -->
        @if ($currentStep === 2)
            <div class="space-y-3 mb-6">
                @foreach ($shippingMethods as $method)
                    <button wire:click="selectShipping('{{ $method['id'] }}')"
                        class="w-full text-left bg-white border-2 rounded-xl p-4 transition-all {{ $selectedShipping === $method['id'] ? 'border-green-600 ring-2 ring-green-100' : 'border-gray-200' }}">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 {{ $selectedShipping === $method['id'] ? 'text-green-600' : 'text-gray-600' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 mb-1">{{ $method['name'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $method['description'] }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div
                                    class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $selectedShipping === $method['id'] ? 'border-green-600' : 'border-gray-300' }}">
                                    @if ($selectedShipping === $method['id'])
                                        <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif

        <!-- STEP 3: Review Order -->
        @if ($currentStep === 3)
            <!-- Shipping Address -->
            <div class="mb-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-bold text-gray-900">Shipping Address</h2>
                    <button wire:click="changeAddress"
                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                        Change
                    </button>
                </div>
                @if ($selectedAddress)
                    <div class="bg-white rounded-xl p-4 border border-gray-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ $selectedAddress['label'] }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $selectedAddress['address'] }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Shipping Type -->
            <div class="mb-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-bold text-gray-900">Shipping Type</h2>
                    <button wire:click="changeShipping"
                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                        Change
                    </button>
                </div>
                @if ($selectedShippingData)
                    <div class="bg-white rounded-xl p-4 border border-gray-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ $selectedShippingData['name'] }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $selectedShippingData['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Order List -->
            <div class="mb-4">
                <h2 class="text-base font-bold text-gray-900 mb-3">Order List</h2>
                <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">
                    @foreach ($cartItems as $item)
                        <div class="p-4 flex gap-3">
                            <div class="w-16 h-16 bg-gray-50 rounded-lg flex-shrink-0 p-2">
                                @if ($item['product']['image'])
                                    <img src="{{ asset('storage/' . $item['product']['image']) }}"
                                        alt="{{ $item['product']['name'] }}" class="w-full h-full object-contain">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $item['product']['name'] }}</h3>
                                <p class="text-xs text-gray-500 mb-1">Size: {{ $item['product']['unit'] ?? '-' }} |
                                    Qty: {{ $item['quantity'] }}pcs</p>
                                <p class="text-sm font-bold text-gray-900">Rp
                                    {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Bottom Button - DEBUG VERSION -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-4 shadow-lg">
        <div class="max-w-2xl mx-auto">
            <!-- Debug Info -->
            <div class="mb-2 p-2 bg-yellow-100 text-xs">
                Step: {{ $currentStep }} | Address: {{ $selectedAddressId }} | Shipping: {{ $selectedShipping }}
            </div>

            @if ($currentStep === 1 || $currentStep === 2)
                <button wire:click="nextStep" onclick="console.log('Next Step clicked'); alert('Next Step clicked');"
                    wire:loading.attr="disabled"
                    class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="nextStep">Apply</span>
                    <span wire:loading wire:target="nextStep">Processing...</span>
                </button>
            @elseif($currentStep === 3)
                <button wire:click="continueToPayment"
                    onclick="console.log('Continue clicked'); alert('Continue to Payment clicked');"
                    wire:loading.attr="disabled"
                    class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="continueToPayment">Continue to Payment</span>
                    <span wire:loading wire:target="continueToPayment">Processing...</span>
                </button>
                @if (session('debug'))
                    <div class="fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
                        {{ session('debug') }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Add Address Modal (tetap sama) -->
    @if ($showAddAddressModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="toggleAddAddressModal"></div>

            <div class="flex min-h-screen items-end justify-center p-0 md:items-center md:p-4">
                <div class="relative w-full max-w-md bg-white rounded-t-3xl md:rounded-2xl shadow-2xl" @click.stop>

                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Add New Address</h3>
                        <button wire:click="toggleAddAddressModal" class="p-1 hover:bg-gray-100 rounded-full">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Label *</label>
                                <input type="text" wire:model="newAddress.label" placeholder="e.g. Home, Office"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('newAddress.label')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima *</label>
                                <input type="text" wire:model="newAddress.recipient_name"
                                    placeholder="Nama lengkap"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('newAddress.recipient_name')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon *</label>
                                <input type="tel" wire:model="newAddress.recipient_phone"
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('newAddress.recipient_phone')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                                <textarea wire:model="newAddress.address" rows="3"
                                    placeholder="Jl. Nama Jalan No.XX, RT/RW, Kelurahan, Kecamatan"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                                @error('newAddress.address')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="newAddress.is_default"
                                    class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                <span class="text-sm text-gray-700">Jadikan alamat utama</span>
                            </label>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 flex gap-3">
                        <button wire:click="toggleAddAddressModal"
                            class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200">
                            Cancel
                        </button>
                        <button wire:click="saveNewAddress" wire:loading.attr="disabled"
                            class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 disabled:opacity-50">
                            <span wire:loading.remove wire:target="saveNewAddress">Save</span>
                            <span wire:loading wire:target="saveNewAddress">Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Loading Overlay -->
    <div wire:loading.delay class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
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
                <span class="text-gray-700 font-medium">Processing...</span>
            </div>
        </div>
    </div>
</div>
