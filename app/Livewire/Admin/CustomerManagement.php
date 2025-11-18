<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;
use App\Models\Order;

class CustomerManagement extends Component
{
    use WithPagination;

    public $searchQuery = '';
    public $selectedCustomer = null;
    public $showModal = false;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $customersQuery = Customer::with('orders');

        // Filter berdasarkan pencarian
        if (!empty($this->searchQuery)) {
            $customersQuery->where(function($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('phone', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('email', 'like', '%' . $this->searchQuery . '%');
            });
        }

        $customers = $customersQuery->latest()->paginate(10);

        return view('livewire.admin.customer-management', [
            'customers' => $customers,
            'title' => 'Manajemen Pelanggan'
        ])->layout('layouts.admin', ['title' => 'Manajemen Pelanggan']);
    }

    public function viewCustomerDetails($customerId)
    {
        $this->selectedCustomer = Customer::with(['orders' => function($query) {
            $query->latest()->take(10);
        }])->find($customerId);
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCustomer = null;
    }

    public function toggleStatus($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            $customer->is_active = !$customer->is_active;
            $customer->save();
            
            session()->flash('message', '✅ Status pelanggan berhasil diupdate!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal update status: ' . $e->getMessage());
        }
    }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }
}