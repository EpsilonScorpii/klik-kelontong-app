<div class="min-h-screen bg-gray-50 pb-24">
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('activities') }}" class="p-2">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-900">Track Order</h1>
            <div class="w-10"></div>
        </div>

        {{-- Product Info --}}
        @if($order->orderItems->count() > 0)
            @php $firstItem = $order->orderItems->first(); @endphp
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                <div class="flex gap-4">
                    {{-- Product Image --}}
                    <img src="{{ asset('storage/' . $firstItem->product->image) }}" 
                         alt="{{ $firstItem->product->name }}"
                         class="w-20 h-20 object-cover rounded-lg flex-shrink-0">

                    {{-- Product Details --}}
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $firstItem->product->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            Size: {{ $firstItem->product->unit ?? 'N/A' }} | Qty: {{ $firstItem->quantity }}pcs
                        </p>
                        <p class="text-lg font-bold text-gray-900">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Additional items indicator --}}
                @if($order->orderItems->count() > 1)
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            +{{ $order->orderItems->count() - 1 }} produk lainnya
                        </p>
                    </div>
                @endif
            </div>
        @endif

        {{-- Order Details --}}
        <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Order Details</h3>
            
            <div class="space-y-2">
                {{-- Expected Delivery Date --}}
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Expected Delivery Date</span>
                    <span class="font-medium text-gray-900">
                        {{ $order->created_at->copy()->addDays(3)->format('d M Y') }}
                    </span>
                </div>

                {{-- Tracking ID --}}
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Tracking ID</span>
                    <span class="font-medium text-gray-900">TRK{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>

        {{-- Order Status Timeline --}}
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <h3 class="font-semibold text-gray-900 mb-6">Order Status</h3>

            <div class="relative">
                {{-- Timeline Line --}}
                <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                {{-- Status Items --}}
                <div class="space-y-8">
                    @foreach($orderStatuses as $status)
                        <div class="relative flex items-start gap-4">
                            {{-- Status Icon/Dot --}}
                            <div class="relative z-10 flex-shrink-0">
                                @if($status['status'] === 'completed')
                                    {{-- Completed: Green checkmark --}}
                                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                @elseif($status['status'] === 'current')
                                    {{-- Current: Green dot --}}
                                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 bg-white rounded-full"></div>
                                    </div>
                                @else
                                    {{-- Pending: Gray dot --}}
                                    <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                                @endif
                            </div>

                            {{-- Status Text --}}
                            <div class="flex-1 pt-1">
                                <p class="font-semibold text-gray-900 mb-1">{{ $status['label'] }}</p>
                                @if($status['date'])
                                    <p class="text-sm text-gray-600">
                                        {{ $status['date']->format('d M Y, H:i A') }}
                                    </p>
                                @endif
                            </div>

                            {{-- Status Icon (Right side) --}}
                            <div class="flex-shrink-0 pt-1">
                                @if($status['icon'] === 'clipboard')
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                @elseif($status['icon'] === 'box')
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                @elseif($status['icon'] === 'truck')
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                    </svg>
                                @elseif($status['icon'] === 'check-box')
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3L22 4"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>