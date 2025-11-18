<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ShippingSetting;
use App\Models\ShippingRate;
use App\Models\ServiceArea;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShippingSettings extends Component
{
    // General Settings
    public $deliveryTime = '';
    
    // Shipping Rates
    public $rates = [];
    public $newRate = [
        'distance_from' => '',
        'distance_to' => '',
        'cost' => '',
        'label' => ''
    ];
    
    // Service Areas
    public $areas = [];
    public $newArea = '';
    public $searchArea = '';

    public function mount()
    {
        // ✅ Auto-create store jika belum ada
        $this->ensureStoreExists();
        
        $this->loadSettings();
        $this->loadRates();
        $this->loadAreas();
    }

    public function render()
    {
        return view('livewire.admin.shipping-settings')
                    ->layout('layouts.admin', ['title' => 'Pengaturan Pengiriman']);
    }

    // ✅ Method untuk memastikan store exists
    private function ensureStoreExists()
    {
        $user = auth()->user();
        
        if (!$user->store) {
            Store::create([
                'user_id' => $user->id,
                'name' => 'Toko ' . $user->name,
                'slug' => Str::slug('toko-' . $user->name . '-' . time()),
                'address' => 'Alamat belum diisi',
                'phone' => $user->phone ?? '0000000000',
                'is_active' => true,
            ]);
            
            // Refresh user relationship
            $user->load('store');
        }
    }

    private function loadSettings()
    {
        $store = auth()->user()->store; // ✅ Gunakan auth()->user()->store
        
        $setting = ShippingSetting::where('store_id', $store->id)
                                  ->where('key', 'delivery_time')
                                  ->first();
        
        $this->deliveryTime = $setting ? $setting->value : 'Dikirim setelah pesanan masuk 30-60menit';
    }

    private function loadRates()
    {
        $store = auth()->user()->store;
        
        $this->rates = ShippingRate::where('store_id', $store->id)
                                   ->where('is_active', true)
                                   ->orderBy('distance_from')
                                   ->get()
                                   ->toArray();
    }

    private function loadAreas()
    {
        $store = auth()->user()->store;
        
        $query = ServiceArea::where('store_id', $store->id)
                           ->where('is_active', true);
        
        if (!empty($this->searchArea)) {
            $query->where('area_name', 'like', '%' . $this->searchArea . '%');
        }
        
        $this->areas = $query->orderBy('area_name')->get()->toArray();
    }

    public function saveDeliveryTime()
    {
        try {
            $store = auth()->user()->store;
            
            ShippingSetting::updateOrCreate(
                [
                    'store_id' => $store->id,
                    'key' => 'delivery_time',
                ],
                [
                    'type' => 'general',
                    'value' => $this->deliveryTime,
                    'is_active' => true,
                ]
            );
            
            session()->flash('message', '✅ Pengaturan waktu pengiriman berhasil disimpan!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function addRate()
    {
        $this->validate([
            'newRate.distance_from' => 'required|numeric|min:0',
            'newRate.distance_to' => 'nullable|numeric|gt:newRate.distance_from',
            'newRate.cost' => 'required|numeric|min:0',
            'newRate.label' => 'required|string',
        ], [
            'newRate.distance_from.required' => 'Jarak awal wajib diisi',
            'newRate.distance_to.gt' => 'Jarak akhir harus lebih besar dari jarak awal',
            'newRate.cost.required' => 'Biaya pengiriman wajib diisi',
            'newRate.label.required' => 'Label wajib diisi',
        ]);

        try {
            $store = auth()->user()->store;
            
            ShippingRate::create([
                'store_id' => $store->id,
                'distance_from' => $this->newRate['distance_from'],
                'distance_to' => $this->newRate['distance_to'],
                'cost' => $this->newRate['cost'],
                'label' => $this->newRate['label'],
                'is_active' => true,
            ]);
            
            $this->newRate = [
                'distance_from' => '',
                'distance_to' => '',
                'cost' => '',
                'label' => ''
            ];
            
            $this->loadRates();
            session()->flash('message', '✅ Tarif pengiriman berhasil ditambahkan!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal menambahkan tarif: ' . $e->getMessage());
        }
    }

    public function deleteRate($rateId)
    {
        try {
            ShippingRate::findOrFail($rateId)->delete();
            $this->loadRates();
            session()->flash('message', '✅ Tarif pengiriman berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal menghapus tarif: ' . $e->getMessage());
        }
    }

    public function addArea()
    {
        $this->validate([
            'newArea' => 'required|string|min:3',
        ], [
            'newArea.required' => 'Nama wilayah wajib diisi',
            'newArea.min' => 'Nama wilayah minimal 3 karakter',
        ]);

        try {
            $store = auth()->user()->store;
            
            ServiceArea::create([
                'store_id' => $store->id,
                'area_name' => $this->newArea,
                'is_active' => true,
            ]);
            
            $this->newArea = '';
            $this->loadAreas();
            session()->flash('message', '✅ Wilayah layanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal menambahkan wilayah: ' . $e->getMessage());
        }
    }

    public function deleteArea($areaId)
    {
        try {
            ServiceArea::findOrFail($areaId)->delete();
            $this->loadAreas();
            session()->flash('message', '✅ Wilayah layanan berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal menghapus wilayah: ' . $e->getMessage());
        }
    }

    public function updatedSearchArea()
    {
        $this->loadAreas();
    }
}