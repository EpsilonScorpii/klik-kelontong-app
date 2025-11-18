<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

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
        return redirect()->route('order.track', ['order' => $orderId]);
    }

    public function reviewOrder($orderId)
    {
        return redirect()->route('order.review', ['order' => $orderId]);
    }

    public function reorder($orderId)
    {
        try {
            $order = Order::with('orderItems.product')->find($orderId);

            foreach ($order->orderItems as $item) {
                if ($item->product && $item->product->is_active && $item->product->stock > 0) {
                    $cartItem = \App\Models\CartItem::where('user_id', Auth::id())
                                                    ->where('product_id', $item->product_id)
                                                    ->first();

                    if ($cartItem) {
                        $cartItem->increment('quantity', $item->quantity);
                    } else {
                        \App\Models\CartItem::create([
                            'user_id' => Auth::id(),
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->product->price,
                        ]);
                    }
                }
            }

            $this->dispatch('notify', [
                'message' => '✅ Produk berhasil ditambahkan ke keranjang!',
                'type' => 'success'
            ]);

            return redirect()->route('cart');

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => '❌ Gagal menambahkan ke keranjang: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function viewOrderDetail($orderId)
    {
        return redirect()->route('order.detail', ['order' => $orderId]);
    }
}