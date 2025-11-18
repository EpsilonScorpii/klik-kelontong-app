<div class="min-h-screen bg-gray-50 pb-24">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-center relative sticky top-0 z-40">
        <h1 class="text-base font-semibold text-gray-900">Pembayaran</h1>
    </div>

    <div class="px-4 py-12">
        
        <!-- Success Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-32 h-32 bg-green-500 rounded-full flex items-center justify-center">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <!-- Success Message -->
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Payment Successful!</h2>
            <p class="text-gray-600">Terimakasih atas pembayaran anda</p>
        </div>

        <!-- Order Info -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 mb-6">
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Order Number</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Payment Method</span>
                    <span class="text-sm font-semibold text-gray-900 uppercase">{{ $order->payment_method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Total Payment</span>
                    <span class="text-base font-bold text-green-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Status</span>
                    <span class="text-sm font-semibold text-green-600">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <button wire:click="viewOrder"
                    class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition-colors">
                View Order
            </button>
            <button wire:click="viewReceipt"
                    class="w-full bg-white border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                View E-Receipt
            </button>
        </div>
    </div>
</div>