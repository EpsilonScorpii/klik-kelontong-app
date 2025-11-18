<!-- Modal Overlay dengan Backdrop Blur -->
<div class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true">
    
    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity"
         wire:click="closeModal()"></div>
    
    <!-- Modal Container - Centered dengan Flexbox -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        
        <!-- Modal Card -->
        <div class="relative w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
             @click.stop>
            
            <!-- Close Button -->
            <button wire:click="closeModal()" 
                    type="button" 
                    class="absolute right-4 top-4 z-10 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors duration-200">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Form -->
            <form wire:submit.prevent="save">
                
                <!-- Header -->
                <div class="border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-5 sm:px-8">
                    <h3 class="text-2xl font-bold text-gray-900" id="modal-title">
                        {{ $isEditMode ? '✏️ Edit Produk' : '➕ Tambah Produk Baru' }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $isEditMode ? 'Perbarui informasi produk Anda' : 'Lengkapi formulir untuk menambahkan produk' }}
                    </p>
                </div>

                <!-- Body Content -->
                <div class="max-h-[calc(100vh-16rem)] overflow-y-auto px-6 py-6 sm:px-8">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        
                        <!-- Left Column: Form Fields -->
                        <div class="space-y-5">
                            <!-- Nama Produk -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       wire:model="name" 
                                       id="name" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="Contoh: Beras Premium 5kg">
                                @error('name') 
                                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Harga -->
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Harga <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                    <input type="number" 
                                           wire:model="price" 
                                           id="price" 
                                           class="block w-full pl-12 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                           placeholder="50000">
                                </div>
                                @error('price') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div>
                                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Stok <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       wire:model="stock" 
                                       id="stock" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="100">
                                @error('stock') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="category_id" 
                                        id="category_id" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->icon ?? '' }} {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Diskon -->
                            <div>
                                <label for="discount_price" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Harga Diskon (Opsional)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                    <input type="number" 
                                           wire:model="discount_price" 
                                           id="discount_price" 
                                           class="block w-full pl-12 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                           placeholder="45000">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Harga sebelum diskon (akan dicoret)</p>
                                @error('discount_price') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column: Image Upload -->
                        <div class="flex flex-col">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Foto Produk
                            </label>
                            
                            <!-- Preview Image Container -->
                            <div class="flex-1 flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-6 mb-3 min-h-[250px]">
                                @if ($image)
                                    <!-- Preview Temporary Image (baru diupload, belum disimpan) -->
                                    <div class="relative w-full h-full flex items-center justify-center">
                                        <img src="{{ $image->temporaryUrl() }}" 
                                             alt="Preview" 
                                             class="max-h-52 max-w-full rounded-lg object-contain shadow-md">
                                        <button type="button" 
                                                wire:click="$set('image', null)"
                                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-sm text-green-600 font-medium mt-2">✓ Gambar siap diupload</p>
                                
                                @elseif ($old_image)
                                    <!-- Show Existing Image (dari database) -->
                                    <div class="relative w-full h-full flex items-center justify-center">
                                        <img src="{{ asset('storage/' . $old_image) }}" 
                                             alt="Current Image" 
                                             class="max-h-52 max-w-full rounded-lg object-contain shadow-md">
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">📸 Gambar saat ini</p>
                                
                                @else
                                    <!-- Placeholder when no image -->
                                    <svg class="h-16 w-16 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Upload Foto Produk</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG, GIF</p>
                                    <p class="text-xs text-gray-500">Maksimal 5MB</p>
                                @endif
                            </div>

                            <!-- Upload Button -->
                            <label for="image-upload" 
                                   class="cursor-pointer w-full rounded-lg bg-green-100 px-4 py-2.5 font-semibold text-green-800 hover:bg-green-200 transition-colors duration-200 text-center inline-block">
                                📁 {{ $image || $old_image ? 'Ganti Foto' : 'Pilih File' }}
                            </label>
                            
                            <!-- Hidden File Input -->
                            <input type="file" 
                                   id="image-upload" 
                                   wire:model="image" 
                                   accept="image/png,image/jpeg,image/jpg,image/gif" 
                                   class="hidden">
                            
                            <!-- Error Message -->
                            @error('image') 
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror

                            <!-- Loading Indicator -->
                            <div wire:loading wire:target="image" class="mt-3 text-center">
                                <div class="inline-flex items-center gap-2 text-sm text-blue-600">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>Mengupload gambar...</span>
                                </div>
                            </div>

                            <!-- Image Info -->
                            @if($image)
                                <div class="mt-2 text-xs text-gray-500 text-center">
                                    <p>{{ $image->getClientOriginalName() }}</p>
                                    <p>{{ number_format($image->getSize() / 1024, 2) }} KB</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 sm:px-8">
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-between sm:items-center">
                        
                        <!-- Left Side Buttons (Delete & Toggle Status) -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            @if($isEditMode)
                                <button wire:click="toggleStatus" 
                                        type="button" 
                                        class="inline-flex items-center justify-center rounded-lg px-4 py-2.5 font-semibold transition-all duration-200 {{ $is_active ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                                    {{ $is_active ? '🔒 Nonaktifkan' : '✅ Aktifkan' }}
                                </button>

                                <button wire:click="delete" 
                                        type="button" 
                                        onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-100 px-4 py-2.5 font-semibold text-red-800 hover:bg-red-200 transition-all duration-200">
                                    🗑️ Hapus Produk
                                </button>
                            @endif
                        </div>

                        <!-- Right Side Buttons (Cancel & Save) -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button wire:click="closeModal" 
                                    type="button" 
                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-semibold text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                Batal
                            </button>
                            
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    wire:target="save,image"
                                    class="inline-flex items-center justify-center rounded-lg bg-green-600 px-6 py-2.5 font-semibold text-white shadow-md hover:bg-green-700 hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <!-- Loading State -->
                                <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Menyimpan...
                                </span>
                                
                                <!-- Normal State -->
                                <span wire:loading.remove wire:target="save">
                                    💾 Simpan Produk
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>