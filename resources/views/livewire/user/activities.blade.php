<div class="min-h-screen bg-gray-50 pb-24">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-center relative sticky top-0 z-40">
        <button onclick="history.back()" class="absolute left-4 p-2 -m-2">
            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <h1 class="text-base font-semibold text-gray-900">Aktivitas</h1>
    </div>

    <!-- Tabs -->
    <div class="bg-white border-b border-gray-200 sticky top-[49px] z-30">
        <div class="flex">
            <button wire:click="switchTab('active')"
                    class="flex-1 py-3 text-sm font-medium transition-colors {{ $activeTab === 'active' ? 'text-gray-900 border-b-2 border-green-600' : 'text-gray-500' }}">
                Active
            </button>
            <button wire:click="switchTab('completed')"
                    class="flex-1 py-3 text-sm font-medium transition-colors {{ $activeTab === 'completed' ? 'text-gray-900 border-b-2 border-green-600' : 'text-gray-500' }}">
                Completed
            </button>
            <button wire:click="switchTab('cancelled')"
                    class="flex-1 py-3 text-sm font-medium transition-colors {{ $activeTab === 'cancelled' ? 'text-gray-900 border-b-2 border-green-600' : 'text-gray-500' }}">
                Cancelled
            </button>
        </div>
    </div>

    <!-- Order List -->
    <div class="px-4 py-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
                <!-- Order Header -->
                <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Order #{{ $order['order_number'] }}</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y, H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        {{ $order['status'] === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order['status'] === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $order['status'] === 'processing' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $order['status'] === 'shipped' ? 'bg-indigo-100 text-indigo-700' : '' }}
                        {{ $order['status'] === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $order['status'] === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($order['status']) }}
                    </span>
                </div>

                <!-- Order Items -->
                @foreach($order['order_items'] as $item)
                <div class="flex gap-3 mb-3" wire:key="item-{{ $item['id'] }}">
                    <!-- Product Image -->
                    <div class="w-16 h-16 bg-gray-50 rounded-lg flex-shrink-0 p-2">
                        @if($item['product'] && $item['product']['image'])
                            <img src="{{ asset('storage/' . $item['product']['image']) }}" 
                                 alt="{{ $item['product']['name'] }}"
                                 class="w-full h-full object-contain">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-medium text-gray-900 mb-1">
                            {{ $item['product']['name'] ?? 'Product not found' }}
                        </h3>
                        <p class="text-xs text-gray-500 mb-1">
                            Size: {{ $item['product']['unit'] ?? '-' }} | Qty: {{ $item['quantity'] }}pcs
                        </p>
                        <p class="text-sm font-bold text-gray-900">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach

                <!-- Order Total -->
                <div class="flex justify-between items-center pt-3 border-t border-gray-100 mb-3">
                    <span class="text-sm text-gray-600">Total Pesanan</span>
                    <span class="text-base font-bold text-gray-900">Rp {{ number_format($order['total'], 0, ',', '.') }}</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    @if($activeTab === 'active')
                        <button wire:click="trackOrder({{ $order['id'] }})"
                                class="flex-1 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            Track Order
                        </button>
                    @elseif($activeTab === 'completed')
                        <button wire:click="viewOrderDetail({{ $order['id'] }})"
                                class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            View Detail
                        </button>
                        <button wire:click="reviewOrder({{ $order['id'] }})"
                                class="flex-1 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            Review
                        </button>
                    @else
                        <button wire:click="viewOrderDetail({{ $order['id'] }})"
                                class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            View Detail
                        </button>
                        <button wire:click="reorder({{ $order['id'] }})"
                                class="flex-1 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            Re-Order
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-lg font-medium text-gray-900 mb-2">
                    @if($activeTab === 'active')
                        Belum ada pesanan aktif
                    @elseif($activeTab === 'completed')
                        Belum ada pesanan selesai
                    @else
                        Belum ada pesanan dibatalkan
                    @endif
                </p>
                <p class="text-gray-500 mb-6">Mulai belanja sekarang!</p>
                <a href="{{ route('home') }}" 
                   class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                    Belanja Sekarang
                </a>
            </div>
        @endforelse
    </div>

    <!-- Loading Overlay -->
    <div wire:loading.delay class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 shadow-2xl">
            <div class="flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 font-medium">Loading...</span>
            </div>
        </div>
    </div>
</div>