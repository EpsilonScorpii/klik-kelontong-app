<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class TrackOrder extends Component
{
    public $orderId;
    public $order;
    public $orderStatuses = [];

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->loadOrder();
    }

    public function render()
    {
        return view('livewire.user.track-order')->layout('layouts.app', ['title' => 'Track Order']);
    }

    private function loadOrder()
    {
        $this->order = Order::with(['orderItems.product', 'shippingAddress'])
                           ->where('id', $this->orderId)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();

        // Build order status timeline
        $this->orderStatuses = $this->buildStatusTimeline();
    }

    private function buildStatusTimeline()
    {
        $statuses = [
            [
                'label' => 'Order Placed',
                'status' => 'completed',
                'date' => $this->order->created_at,
                'icon' => 'clipboard',
            ],
            [
                'label' => 'In Progress',
                'status' => $this->getStatusState('processing'),
                'date' => $this->getStatusDate('processing'),
                'icon' => 'box',
            ],
            [
                'label' => 'Shipped',
                'status' => $this->getStatusState('shipped'),
                'date' => $this->getStatusDate('shipped'),
                'icon' => 'truck',
            ],
            [
                'label' => 'Delivered',
                'status' => $this->getStatusState('delivered'),
                'date' => $this->getStatusDate('delivered'),
                'icon' => 'check-box',
            ],
        ];

        return $statuses;
    }

    private function getStatusState($status)
    {
        $orderStatus = $this->order->status;

        $statusOrder = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
        $currentIndex = array_search($orderStatus, $statusOrder);
        $checkIndex = array_search($status, $statusOrder);

        if ($currentIndex >= $checkIndex) {
            return 'completed';
        } elseif ($currentIndex == $checkIndex - 1) {
            return 'current';
        } else {
            return 'pending';
        }
    }

    private function getStatusDate($status)
    {
        // You can store status change history in a separate table
        // For now, we'll estimate based on created_at
        $baseDate = $this->order->created_at;

        switch ($status) {
            case 'processing':
                return $baseDate->copy()->addHours(1);
            case 'shipped':
                return $baseDate->copy()->addHours(2);
            case 'delivered':
                return $baseDate->copy()->addHours(3);
            default:
                return null;
        }
    }
}