<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PaymentSuccess extends Component
{
    public $order;

    public function mount($orderId)
    {
        $this->order = Order::where('id', $orderId)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.user.payment-success')
                    ->layout('layouts.app', ['title' => 'Payment Successful']);
    }

    public function viewOrder()
    {
        return redirect()->route('order.detail', ['order' => $this->order->id]);
    }

    public function viewReceipt()
    {
        // TODO: Generate PDF receipt
        $this->dispatch('notify', [
            'message' => 'ℹ️ Fitur e-receipt akan segera hadir',
            'type' => 'info'
        ]);
    }
}