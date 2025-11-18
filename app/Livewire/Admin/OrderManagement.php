<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderManagement extends Component
{
    use WithPagination;

    public $searchQuery = '';
    public $filterStatus = '';
    public $filterDate = '';
    public $filterCustomer = '';

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $ordersQuery = Order::with(['user', 'store', 'items.product']);

        // Filter berdasarkan pencarian
        if (!empty($this->searchQuery)) {
            $ordersQuery->where(function($query) {
                $query->where('order_number', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('customer_name', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('customer_phone', 'like', '%' . $this->searchQuery . '%');
            });
        }

        // Filter berdasarkan status
        if (!empty($this->filterStatus)) {
            $ordersQuery->where('status', $this->filterStatus);
        }

        // Filter berdasarkan tanggal
        if (!empty($this->filterDate)) {
            $ordersQuery->whereDate('created_at', $this->filterDate);
        }

        // Filter berdasarkan pelanggan
        if (!empty($this->filterCustomer)) {
            $ordersQuery->where('customer_name', 'like', '%' . $this->filterCustomer . '%');
        }

        $orders = $ordersQuery->latest()->paginate(15);

        return view('livewire.admin.order-management', [
            'orders' => $orders,
            'title' => 'Manajemen Pesanan'
        ])->layout('layouts.admin', ['title' => 'Manajemen Pesanan']);
    }

    public function updateStatus($orderId, $newStatus)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->update(['status' => $newStatus]);
            
            session()->flash('message', '✅ Status pesanan berhasil diupdate!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal update status: ' . $e->getMessage());
        }
    }

    public function clearFilters()
    {
        $this->searchQuery = '';
        $this->filterStatus = '';
        $this->filterDate = '';
        $this->filterCustomer = '';
    }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterDate()
    {
        $this->resetPage();
    }
}