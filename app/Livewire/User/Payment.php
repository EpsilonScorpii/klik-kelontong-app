<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Payment extends Component
{
    public $order;
    public $selectedPaymentMethod = 'cod';
    
    public $paymentMethods = [
        'cod' => [
            'id' => 'cod',
            'name' => 'Cash On Delivery',
            'icon' => '🏪',
            'description' => 'Bayar saat barang diterima',
        ],
        'dana' => [
            'id' => 'dana',
            'name' => 'Dana',
            'icon' => '💳',
            'description' => 'Bayar dengan DANA',
        ],
        'ovo' => [
            'id' => 'ovo',
            'name' => 'OVO',
            'icon' => '💜',
            'description' => 'Bayar dengan OVO',
        ],
        'gopay' => [
            'id' => 'gopay',
            'name' => 'Gopay',
            'icon' => '💚',
            'description' => 'Bayar dengan Gopay',
        ],
    ];

    public function mount($orderId)
    {
        $this->order = Order::where('id', $orderId)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();
        
        // If already paid, redirect
        if ($this->order->payment_status === 'paid') {
            return redirect()->route('payment.success', ['order' => $this->order->id]);
        }
    }

    public function render()
    {
        return view('livewire.user.payment')
                    ->layout('layouts.app', ['title' => 'Pembayaran']);
    }

    public function selectPaymentMethod($method)
    {
        $this->selectedPaymentMethod = $method;
    }

    public function processPayment()
    {
        try {
            // Update order payment method
            $this->order->update([
                'payment_method' => $this->selectedPaymentMethod,
            ]);

            // For COD, mark as confirmed immediately
            if ($this->selectedPaymentMethod === 'cod') {
                $this->order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                ]);
            } else {
                // For e-wallet, simulate payment (in real app, integrate with payment gateway)
                // For now, auto confirm
                $this->order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                ]);
            }

            $this->dispatch('notify', [
                'message' => '✅ Pembayaran berhasil!',
                'type' => 'success'
            ]);

            return redirect()->route('payment.success', ['order' => $this->order->id]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => '❌ Gagal memproses pembayaran: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }
}