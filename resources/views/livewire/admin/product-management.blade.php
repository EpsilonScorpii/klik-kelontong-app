<div class="space-y-6">
    
    <div class="relative w-full">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
        
        <input type="text" 
               wire:model.live.debounce.300ms="searchQuery" 
               placeholder="Cari Produk..." 
               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
    </div>

    <div class="bg-white overflow-hidden rounded-lg shadow-md">
        
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
            <div class="flex items-center space-x-3">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Edit
                </button>
                <button wire:click="create()" class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm font-semibold hover:bg-green-800">
                    + Tambah Produk
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded m-6" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if($isModalOpen)
            @include('livewire.admin.product-modal')
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr wire:click="edit({{ $product->id }})" class="cursor-pointer hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->category->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            Tidak ada produk ditemukan (atau coba bersihkan pencarian Anda).
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>