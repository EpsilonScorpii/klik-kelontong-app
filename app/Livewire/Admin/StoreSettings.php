<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StoreSettings extends Component
{
    use WithFileUploads;

    public $store;
    public $name;
    public $address;
    public $phone;
    public $opening_time;
    public $closing_time;
    public $refund_policy;
    public $logo;
    public $old_logo;

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:10',
            'phone' => 'nullable|string|max:20',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i|after:opening_time',
            'refund_policy' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    protected $messages = [
        'name.required' => 'Nama toko wajib diisi.',
        'name.min' => 'Nama toko minimal 3 karakter.',
        'address.required' => 'Alamat toko wajib diisi.',
        'address.min' => 'Alamat toko minimal 10 karakter.',
        'closing_time.after' => 'Jam tutup harus setelah jam buka.',
        'logo.image' => 'File harus berupa gambar.',
        'logo.max' => 'Ukuran logo maksimal 2MB.',
    ];

    public function mount()
    {
        $user = auth()->user();
        
        // Ambil atau buat store untuk user
        $this->store = $user->store;
        
        if (!$this->store) {
            // Buat store baru jika belum ada
            $this->store = Store::create([
                'user_id' => $user->id,
                'name' => 'Toko ' . $user->name,
                'slug' => Str::slug('toko-' . $user->name . '-' . time()),
                'address' => 'Alamat belum diisi',
                'is_active' => true,
            ]);
        }

        // Load data ke properti
        $this->name = $this->store->name;
        $this->address = $this->store->address;
        $this->phone = $this->store->phone;
        $this->opening_time = $this->store->opening_time ? $this->store->opening_time->format('H:i') : '06:00';
        $this->closing_time = $this->store->closing_time ? $this->store->closing_time->format('H:i') : '22:00';
        $this->refund_policy = $this->store->refund_policy ?? 'Kepuasan pelanggan adalah prioritas utama kami di Klik Kelontong. Jika Anda menerima produk yang tidak sesuai, cacat, atau rusak, Anda dapat mengajukan permohonan pengembalian atau refund sesuai dengan ketentuan yang berlaku dalam kebijakan ini.';
        $this->old_logo = $this->store->logo;
    }

    public function render()
    {
        return view('livewire.admin.store-settings')
                    ->layout('layouts.admin', ['title' => 'Pengaturan Toko']);
    }

    public function save()
    {
        $this->validate();

        try {
            // Handle logo upload
            $logoPath = $this->old_logo;
            
            if ($this->logo) {
                $logoPath = $this->logo->store('stores/logos', 'public');
                
                // Hapus logo lama
                if ($this->old_logo && Storage::disk('public')->exists($this->old_logo)) {
                    Storage::disk('public')->delete($this->old_logo);
                }
            }

            // Update store
            $this->store->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'logo' => $logoPath,
                'address' => $this->address,
                'phone' => $this->phone,
                'opening_time' => $this->opening_time,
                'closing_time' => $this->closing_time,
                'refund_policy' => $this->refund_policy,
            ]);

            $this->old_logo = $logoPath;
            $this->logo = null;

            session()->flash('message', '✅ Pengaturan toko berhasil disimpan!');
            
        } catch (\Exception $e) {
            Log::error('Error saving store settings: ' . $e->getMessage());
            session()->flash('error', '❌ Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    public function removeLogo()
    {
        try {
            if ($this->old_logo && Storage::disk('public')->exists($this->old_logo)) {
                Storage::disk('public')->delete($this->old_logo);
            }

            $this->store->update(['logo' => null]);
            $this->old_logo = null;
            $this->logo = null;

            session()->flash('message', '✅ Logo berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal menghapus logo: ' . $e->getMessage());
        }
    }

    public function updatedLogo()
    {
        $this->validateOnly('logo');
    }
}