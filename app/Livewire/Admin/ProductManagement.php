<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductManagement extends Component
{
    use WithFileUploads;

    public $products, $categories;
    public $product_id, $name, $slug, $description, $price, $discount_price, $stock, $category_id, $is_active;
    public $image, $old_image;
    public $isModalOpen = false;
    public $isEditMode = false;
    public $searchQuery = '';

    // ⚠️ PENTING: Gunakan METHOD bukan property untuk Livewire v3
    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:5120',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama produk wajib diisi.',
        'name.min' => 'Nama produk minimal 3 karakter.',
        'price.required' => 'Harga produk wajib diisi.',
        'price.numeric' => 'Harga harus berupa angka.',
        'stock.required' => 'Stok produk wajib diisi.',
        'stock.integer' => 'Stok harus berupa angka bulat.',
        'category_id.required' => 'Kategori produk wajib dipilih.',
        'image.image' => 'File harus berupa gambar.',
        'image.max' => 'Ukuran gambar maksimal 5MB.',
        'discount_price.lt' => 'Harga diskon harus lebih kecil dari harga normal.',
    ];

    public function mount()
    {
        $this->categories = Category::where('is_active', true)->orderBy('name')->get();
    }

    public function render()
    {
        $title = 'Manajemen Produk';

        $productsQuery = Product::with('category');

        if (!empty($this->searchQuery)) {
            $productsQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $this->searchQuery . '%');
            });
        }

        $this->products = $productsQuery->latest()->get();

        return view('livewire.admin.product-management')
            ->layout('layouts.admin', ['title' => $title]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);

            $this->product_id = $id;
            $this->name = $product->name;
            $this->price = $product->price;
            $this->discount_price = $product->discount_price;
            $this->stock = $product->stock;
            $this->category_id = $product->category_id;
            $this->is_active = $product->is_active;
            $this->description = $product->description;
            $this->old_image = $product->image;

            $this->isEditMode = true;
            $this->isModalOpen = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Produk tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            // ✅ CEK USER PUNYA STORE ATAU BELUM
            $user = auth()->user();

            if (!$user) {
                $this->dispatch('alert', type: 'error', message: '❌ User tidak terautentikasi!');
                return;
            }

            // Jika user belum punya store, buat store dummy
            $store = $user->store;
            if (!$store) {
                $store = Store::create([
                    'user_id' => $user->id,
                    'name' => 'Toko ' . $user->name,
                    'slug' => Str::slug('toko-' . $user->name),
                    'address' => 'Alamat belum diisi',
                    'phone' => $user->phone ?? '0000000000',
                    'is_active' => true,
                ]);
            }

            // Handle gambar
            $imagePath = $this->old_image;

            if ($this->image) {
                $imagePath = $this->image->store('products', 'public');

                if ($this->old_image && Storage::disk('public')->exists($this->old_image)) {
                    Storage::disk('public')->delete($this->old_image);
                }
            }

            // Data yang akan disimpan
            $data = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'price' => $this->price,
                'discount_price' => $this->discount_price ?? 0,
                'stock' => $this->stock,
                'category_id' => $this->category_id,
                'image' => $imagePath,
                'store_id' => $store->id, // ✅ Gunakan store ID yang valid
                'is_active' => $this->is_active ?? true,
            ];

            if ($this->product_id) {
                Product::where('id', $this->product_id)->update($data);
                $this->dispatch('alert', type: 'success', message: '✅ Produk berhasil diperbarui!');
            } else {
                Product::create($data);
                $this->dispatch('alert', type: 'success', message: '✅ Produk berhasil ditambahkan!');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            Log::error('Error saving product: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            $this->dispatch('alert', type: 'error', message: '❌ Error: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if (!$this->product_id) return;

        try {
            $product = Product::findOrFail($this->product_id);

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();
            $this->dispatch('alert', type: 'success', message: '✅ Produk berhasil dihapus!');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: '❌ Error: ' . $e->getMessage());
        }
    }

    public function toggleStatus()
    {
        if (!$this->product_id) return;

        try {
            $product = Product::findOrFail($this->product_id);
            $product->is_active = !$product->is_active;
            $product->save();

            $this->is_active = $product->is_active;
            $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('alert', type: 'success', message: "✅ Produk berhasil {$status}!");
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: '❌ Error: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->product_id = null;
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->price = '';
        $this->discount_price = null;
        $this->stock = '';
        $this->category_id = '';
        $this->is_active = true;
        $this->image = null;
        $this->old_image = null;
        $this->isEditMode = false;
        $this->resetValidation();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedImage()
    {
        $this->validateOnly('image');
    }
}
