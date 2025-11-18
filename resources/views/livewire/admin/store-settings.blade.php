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
                    <h1 class="text-2xl font-bold text-white">🏪 Pengaturan Toko</h1>
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

        <form wire:submit.prevent="save">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 space-y-6">
                    
                    <!-- Nama Toko -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            🏪 Nama Toko <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model="name" 
                               id="name" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="Toko ABC">
                        @error('name') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat & Logo -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Alamat -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                📍 Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="address" 
                                      id="address" 
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                      placeholder="Jalan Cikini Raya No.10, Jakarta, Indonesia"></textarea>
                            @error('address') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Logo Toko -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                🖼️ Logo Toko
                            </label>
                            
                            <!-- Preview Logo -->
                            <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-6 mb-3 min-h-[160px]">
                                @if ($logo)
                                    <!-- Preview Temporary Logo -->
                                    <div class="relative">
                                        <img src="{{ $logo->temporaryUrl() }}" 
                                             alt="Preview" 
                                             class="h-32 w-32 rounded-lg object-contain">
                                        <button type="button" 
                                                wire:click="$set('logo', null)"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @elseif ($old_logo)
                                    <!-- Existing Logo -->
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $old_logo) }}" 
                                             alt="Current Logo" 
                                             class="h-32 w-32 rounded-lg object-contain">
                                        <button type="button" 
                                                wire:click="removeLogo"
                                                onclick="return confirm('Yakin ingin menghapus logo?')"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <!-- Placeholder -->
                                    <svg class="h-20 w-20 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">Logo Toko</p>
                                @endif
                            </div>

                            <!-- Upload Button -->
                            <label for="logo-upload" 
                                   class="cursor-pointer w-full rounded-lg bg-green-100 px-4 py-2.5 font-semibold text-green-800 hover:bg-green-200 transition-colors text-center inline-block">
                                📁 {{ $logo || $old_logo ? 'Ganti Logo' : 'Upload' }}
                            </label>
                            <input type="file" 
                                   id="logo-upload" 
                                   wire:model="logo" 
                                   accept="image/*" 
                                   class="hidden">
                            
                            @error('logo') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- Loading Indicator -->
                            <div wire:loading wire:target="logo" class="mt-2 text-center">
                                <span class="text-sm text-blue-600">⏳ Mengupload...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            📱 Nomor Telepon
                        </label>
                        <input type="text" 
                               wire:model="phone" 
                               id="phone" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="081234567890">
                        @error('phone') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Operasional -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            ⏰ Jam Operasional
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="time" 
                                   wire:model="opening_time"
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <span class="text-gray-500 font-medium">-</span>
                            <input type="time" 
                                   wire:model="closing_time"
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        @error('opening_time') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('closing_time') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kebijakan Pengembalian & Refund -->
                    <div>
                        <label for="refund_policy" class="block text-sm font-semibold text-gray-700 mb-2">
                            📋 Kebijakan Pengembalian & Refund
                        </label>
                        <textarea wire:model="refund_policy" 
                                  id="refund_policy" 
                                  rows="6"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                  placeholder="Tulis kebijakan pengembalian dan refund toko Anda..."></textarea>
                        @error('refund_policy') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Footer -->
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            wire:target="save,logo"
                            class="w-full rounded-lg bg-green-600 px-6 py-3 font-semibold text-white shadow-md hover:bg-green-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="save">💾 Simpan Pengaturan</span>
                        <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>