<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Activities extends Component
{
    public $activeTab = 'active';
    public $orders = [];

    public function mount()
    {
        $this->loadOrders();
    }

    public function render()
    {
        return view('livewire.user.activities')
                    ->layout('layouts.app', ['title' => 'Aktivitas']);
    }

    public function loadOrders()
    {
        $query = Order::with(['orderItems.product'])
                     ->where('user_id', Auth::id());

        switch ($this->activeTab) {
            case 'active':
                $query->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped']);
                break;
            case 'completed':
                $query->where('status', 'delivered');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
        }

        $this->orders = $query->latest()->get()->toArray();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadOrders();
    }

    public function trackOrder($orderId)
    {
        return redirect()->route('track-order', $orderId);
    }

    public function reviewOrder($orderId)
    {
        // TODO: Implement review page
        $this->dispatch('notify', [
            'message' => 'ℹ️ Fitur review sedang dalam pengembangan',
            'type' => 'info'
        ]);
    }

    public function reorder($orderId)
    {
        try {
            $order = Order::with('orderItems.product')->find($orderId);

            if (!$order) {
                $this->dispatch('notify', [
                    'message' => '❌ Pesanan tidak ditemukan',
                    'type' => 'error'
                ]);
                return;
            }

            $addedCount = 0;

            foreach ($order->orderItems as $item) {
                if ($item->product && $item->product->is_active && $item->product->stock > 0) {
                    $cartItem = CartItem::where('user_id', Auth::id())
                                       ->where('product_id', $item->product_id)
                                       ->first();

                    if ($cartItem) {
                        // Check if adding quantity exceeds stock
                        $newQuantity = $cartItem->quantity + $item->quantity;
                        if ($newQuantity <= $item->product->stock) {
                            $cartItem->increment('quantity', $item->quantity);
                            $addedCount++;
                        }
                    } else {
                        CartItem::create([
                            'user_id' => Auth::id(),
                            'product_id' => $item->product_id,
                            'quantity' => min($item->quantity, $item->product->stock),
                            'price' => $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price,
                        ]);
                        $addedCount++;
                    }
                }
            }

            if ($addedCount > 0) {
                $this->dispatch('notify', [
                    'message' => "✅ {$addedCount} produk ditambahkan ke keranjang!",
                    'type' => 'success'
                ]);
                $this->dispatch('cartUpdated');
                return redirect()->route('cart');
            } else {
                $this->dispatch('notify', [
                    'message' => '⚠️ Tidak ada produk yang bisa ditambahkan (stok habis atau produk tidak aktif)',
                    'type' => 'warning'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Reorder failed', ['error' => $e->getMessage()]);
            $this->dispatch('notify', [
                'message' => '❌ Gagal menambahkan ke keranjang',
                'type' => 'error'
            ]);
        }
    }

    public function viewOrderDetail($orderId)
    {
        // TODO: Implement order detail page
        return redirect()->route('track-order', $orderId);
    }
}