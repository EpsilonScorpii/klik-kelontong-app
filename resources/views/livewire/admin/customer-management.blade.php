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
                    <h1 class="text-2xl font-bold text-white">👥 Manajemen Pelanggan</h1>
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
                       placeholder="🔍 Cari Pelanggan (Nama, Telepon, Email)"
                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 pl-10 py-3">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <!-- Pelanggan Terdaftar -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800">📋 Pelanggan Terdaftar</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Total Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Total Belanja</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                    @if($customer->phone)
                                        <div class="text-sm text-gray-500">📱 {{ $customer->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $customer->address ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    {{ $customer->total_orders }} pesanan
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                    {{ $customer->formatted_total_spent }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <button wire:click="viewCustomerDetails({{ $customer->id }})"
                                            class="px-4 py-2 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 font-medium">
                                        📊 Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada pelanggan</p>
                                        <p class="text-sm">Pelanggan akan muncul setelah melakukan pemesanan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Detail Pelanggan -->
    @if($showModal && $selectedCustomer)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>
            
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all" @click.stop>
                    
                    <!-- Close Button -->
                    <button wire:click="closeModal" type="button" class="absolute right-4 top-4 z-10 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Header -->
                    <div class="border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-5">
                        <h3 class="text-2xl font-bold text-gray-900">👤 Detail Pelanggan</h3>
                        <p class="mt-1 text-sm text-gray-600">Informasi lengkap dan riwayat transaksi</p>
                    </div>

                    <!-- Body -->
                    <div class="max-h-[calc(100vh-12rem)] overflow-y-auto px-6 py-6">
                        
                        <!-- Info Pelanggan -->
                        <div class="bg-gray-50 rounded-xl p-4 mb-6">
                            <h4 class="font-bold text-gray-800 mb-3">📋 Informasi Pelanggan</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Nama</p>
                                    <p class="font-semibold text-gray-900">{{ $selectedCustomer->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Telepon</p>
                                    <p class="font-semibold text-gray-900">{{ $selectedCustomer->phone ?? '-' }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-600">Alamat</p>
                                    <p class="font-semibold text-gray-900">{{ $selectedCustomer->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Pesanan -->
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-800 mb-3">🛍️ Riwayat Pesanan Pelanggan</h4>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Pelanggan</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">ID Pesanan</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($selectedCustomer->orders as $order)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3 text-sm text-gray-900">{{ $order->customer_name }}</td>
                                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                                <td class="px-4 py-3 text-sm text-gray-700">{{ $order->created_at->format('d-m-Y') }}</td>
                                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $order->formatted_total }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada pesanan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Program Loyalty & Cashback -->
                        <div>
                            <h4 class="font-bold text-gray-800 mb-3">💰 Program Loyalty & Cashback</h4>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Pelanggan</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Cashback</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Poin Loyalty</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        <tr>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $selectedCustomer->name }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold text-green-600">{{ $selectedCustomer->formatted_cashback }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold text-blue-600">{{ number_format($selectedCustomer->loyalty_points, 0) }} poin</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                        <button wire:click="closeModal" type="button" class="w-full rounded-lg bg-gray-600 px-6 py-2.5 font-semibold text-white hover:bg-gray-700 transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>