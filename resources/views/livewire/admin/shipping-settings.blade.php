<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 shadow-md">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="history.back()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </button>
                    <h1 class="text-2xl font-bold text-white">🚚 Pengaturan Pengiriman</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Pengiriman -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">⏰ Pengiriman</h2>
            <div>
                <textarea wire:model="deliveryTime"
                          rows="3"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                          placeholder="Contoh: Dikirim setelah pesanan masuk 30-60menit"></textarea>
                <button wire:click="saveDeliveryTime"
                        class="mt-3 px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                    💾 Simpan Pengaturan
                </button>
            </div>
        </div>

        <!-- Biaya Pengiriman -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">💰 Biaya Pengiriman</h2>
            
            <!-- List Tarif -->
            <div class="space-y-2 mb-4">
                @forelse($rates as $rate)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <span class="font-medium text-gray-900">{{ $rate['label'] }}</span>
                            <span class="text-sm text-gray-600 ml-2">
                                ({{ $rate['distance_from'] }}km - {{ $rate['distance_to'] ? $rate['distance_to'] . 'km' : 'unlimited' }})
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-green-600">Rp{{ number_format($rate['cost'], 0, ',', '.') }}</span>
                            <button wire:click="deleteRate({{ $rate['id'] }})"
                                    onclick="return confirm('Yakin ingin menghapus tarif ini?')"
                                    class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Belum ada tarif pengiriman</p>
                @endforelse
            </div>

            <!-- Form Tambah Tarif -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="font-semibold text-gray-700 mb-3">➕ Tambah Tarif Baru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jarak Dari (km)</label>
                        <input type="number" 
                               wire:model="newRate.distance_from"
                               step="0.01"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="0">
                        @error('newRate.distance_from') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jarak Sampai (km)</label>
                        <input type="number" 
                               wire:model="newRate.distance_to"
                               step="0.01"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="Kosongkan untuk unlimited">
                        @error('newRate.distance_to') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Biaya (Rp)</label>
                        <input type="number" 
                               wire:model="newRate.cost"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="5000">
                        @error('newRate.cost') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                        <input type="text" 
                               wire:model="newRate.label"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="< 1km">
                        @error('newRate.label') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button wire:click="addRate"
                        class="mt-3 px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    ➕ Tambah Tarif
                </button>
            </div>
        </div>

        <!-- Wilayah Layanan -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📍 Wilayah Layanan</h2>
            
            <!-- Search -->
            <div class="mb-4">
                <input type="text"
                       wire:model.live.debounce.300ms="searchArea"
                       placeholder="🔍 Cari Wilayah Layanan"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>

            <!-- List Wilayah -->
            <div class="space-y-2 mb-4 max-h-64 overflow-y-auto">
                @forelse($areas as $area)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">{{ $area['area_name'] }}</span>
                        <button wire:click="deleteArea({{ $area['id'] }})"
                                onclick="return confirm('Yakin ingin menghapus wilayah ini?')"
                                class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Belum ada wilayah layanan</p>
                @endforelse
            </div>

            <!-- Form Tambah Wilayah -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="font-semibold text-gray-700 mb-3">➕ Tambah Wilayah Baru</h3>
                <div class="flex gap-3">
                    <input type="text"
                           wire:model="newArea"
                           placeholder="Nama wilayah (contoh: Jakarta Pusat)"
                           class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <button wire:click="addArea"
                            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                        ➕ Tambah
                    </button>
                </div>
                @error('newArea') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
</div>