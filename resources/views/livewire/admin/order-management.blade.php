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
                    <h1 class="text-2xl font-bold text-white">📦 Manajemen Pesanan</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <input type="text" 
                       wire:model.live.debounce.300ms="searchQuery"
                       placeholder="🔍 Cari Pesanan (ID, Nama, Telepon)"
                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 pl-10 py-3">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select wire:model.live="filterStatus" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="proses">Proses</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                    <input type="date" 
                           wire:model.live="filterDate"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <!-- Customer Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pelanggan</label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="filterCustomer"
                           placeholder="Nama pelanggan"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <!-- Clear Button -->
                <div class="flex items-end">
                    <button wire:click="clearFilters" 
                            class="w-full px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        🔄 Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                ID Pesanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $order->created_at->format('d-m-Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <div class="font-medium">{{ $order->customer_name }}</div>
                                    @if($order->customer_phone)
                                        <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $order->formatted_total }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status_badge }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        @if($order->status === 'pending')
                                            <button wire:click="updateStatus({{ $order->id }}, 'proses')"
                                                    class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 font-medium">
                                                Proses
                                            </button>
                                        @endif
                                        
                                        @if($order->status === 'proses')
                                            <button wire:click="updateStatus({{ $order->id }}, 'selesai')"
                                                    class="px-3 py-1 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 font-medium">
                                                Selesai
                                            </button>
                                        @endif
                                        
                                        @if(in_array($order->status, ['pending', 'proses']))
                                            <button wire:click="updateStatus({{ $order->id }}, 'dibatalkan')"
                                                    class="px-3 py-1 bg-red-100 text-red-800 rounded-lg hover:bg-red-200 font-medium">
                                                Batal
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada pesanan</p>
                                        <p class="text-sm">Pesanan akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>