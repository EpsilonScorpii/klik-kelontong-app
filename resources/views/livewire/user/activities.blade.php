<div class="min-h-screen bg-gray-50 pb-24">
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        
        {{-- Header --}}
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Aktivitas</h1>

        {{-- Tab Switcher --}}
        <div class="flex gap-2 mb-6">
            <button wire:click="switchTab('active')"
                    class="flex-1 py-3 rounded-lg font-semibold transition-colors {{ $activeTab === 'active' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                Active
            </button>
            <button wire:click="switchTab('completed')"
                    class="flex-1 py-3 rounded-lg font-semibold transition-colors {{ $activeTab === 'completed' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                Completed
            </button>
            <button wire:click="switchTab('cancelled')"
                    class="flex-1 py-3 rounded-lg font-semibold transition-colors {{ $activeTab === 'cancelled' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                Cancelled
            </button>
        </div>

        {{-- Orders List --}}
        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    
                    {{-- Order Header --}}
                    <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-center gap-3">
                            {{-- Status Badge --}}
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                {{ $order['status'] === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                                {{ in_array($order['status'], ['pending', 'confirmed', 'processing']) ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $order['status'] === 'shipped' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $order['status'] === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($order['status']) }}
                            </span>

                            {{-- Order ID --}}
                            <span class="text-xs text-gray-600">
                                #{{ str_pad($order['id'], 8, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        {{-- Order Date --}}
                        <span class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y, H:i') }}
                        </span>
                    </div>

                    {{-- Order Content --}}
                    <div class="p-4">
                        {{-- Product Items --}}
                        @if(count($order['order_items']) > 0)
                            @php $firstItem = $order['order_items'][0]; @endphp
                            
                            {{-- First Product --}}
                            <div class="flex gap-3 mb-3">
                                <img src="{{ asset('storage/' . $firstItem['product']['image']) }}" 
                                     alt="{{ $firstItem['product']['name'] }}"
                                     class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-sm line-clamp-2 mb-1">
                                        {{ $firstItem['product']['name'] }}
                                    </h4>
                                    <p class="text-xs text-gray-600 mb-1">
                                        {{ $firstItem['quantity'] }} item{{ $firstItem['quantity'] > 1 ? 's' : '' }}
                                        @if($firstItem['product']['unit'])
                                            × {{ $firstItem['product']['unit'] }}
                                        @endif
                                    </p>
                                    <p class="text-sm font-bold text-green-600">
                                        Rp {{ number_format($firstItem['price'] * $firstItem['quantity'], 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Additional Items Indicator --}}
                            @if(count($order['order_items']) > 1)
                                <div class="bg-gray-50 rounded-lg p-2 mb-3">
                                    <p class="text-xs text-gray-600 text-center">
                                        +{{ count($order['order_items']) - 1 }} produk lainnya
                                    </p>
                                </div>
                            @endif
                        @endif

                        {{-- Order Total --}}
                        <div class="flex justify-between items-center mb-4 pt-3 border-t border-gray-200">
                            <span class="text-sm text-gray-600">Total Pembayaran</span>
                            <span class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($order['total_amount'], 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="grid grid-cols-2 gap-2">
                            
                            {{-- Track Order (Active & Completed) --}}
                            @if(in_array($order['status'], ['pending', 'confirmed', 'processing', 'shipped', 'delivered']))
                                <a href="{{ route('track-order', $order['id']) }}"
                                   class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-3 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Track Order
                                </a>
                            @endif

                            {{-- Review Product (Delivered only) --}}
                            @if($order['status'] === 'delivered')
                                <button wire:click="reviewOrder({{ $order['id'] }})"
                                        class="flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold py-3 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    Review
                                </button>
                            @endif

                            {{-- Order Again --}}
                            <button wire:click="reorder({{ $order['id'] }})"
                                    class="flex items-center justify-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold py-3 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Order Again
                            </button>

                            {{-- View Detail --}}
                            <button wire:click="viewOrderDetail({{ $order['id'] }})"
                                    class="flex items-center justify-center gap-2 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-semibold py-3 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        @if($activeTab === 'active')
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        @elseif($activeTab === 'completed')
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        @if($activeTab === 'active')
                            Tidak Ada Pesanan Aktif
                        @elseif($activeTab === 'completed')
                            Belum Ada Pesanan Selesai
                        @else
                            Tidak Ada Pesanan Dibatalkan
                        @endif
                    </h3>
                    
                    <p class="text-gray-600 mb-6 max-w-sm mx-auto">
                        @if($activeTab === 'active')
                            Ayo mulai belanja dan buat pesanan pertamamu!
                        @elseif($activeTab === 'completed')
                            Pesanan yang sudah diterima akan muncul di sini
                        @else
                            Pesanan yang dibatalkan akan muncul di sini
                        @endif
                    </p>
                    
                    @if($activeTab !== 'cancelled')
                        <a href="{{ route('products') }}"
                           class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                            Belanja Sekarang
                        </a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</div>