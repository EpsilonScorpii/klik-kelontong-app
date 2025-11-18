<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class ProductDetail extends Component
{
    public $product;
    public $selectedVariant = null;
    public $quantity = 1;
    public $totalPrice = 0;
    
    // Product variants (jika ada)
    public $variants = [];
    
    // ✅ Product images
    public $productImages = [];

    public function mount($slug)
    {
        // ✅ Load product tanpa eager load images dulu
        $this->product = Product::with(['category'])
                               ->where('slug', $slug)
                               ->where('is_active', true)
                               ->firstOrFail();
        
        // ✅ Load images jika ada relasi, jika tidak skip
        $this->loadProductImages();
        
        // Load variants jika produk punya variant (opsional)
        $this->loadVariants();
        
        // Set default selected variant (jika ada)
        if (count($this->variants) > 0) {
            $this->selectedVariant = $this->variants[0]['value'];
        }
        
        $this->calculateTotal();
    }

    public function render()
    {
        return view('livewire.user.product-detail')
                    ->layout('layouts.app', ['title' => $this->product->name]);
    }

    // ✅ Load images dengan safe check
    private function loadProductImages()
    {
        try {
            // Cek apakah relasi images ada
            if (method_exists($this->product, 'images')) {
                $this->productImages = $this->product->images()->get()->toArray();
            }
        } catch (\Exception $e) {
            // Jika error, set empty array
            $this->productImages = [];
        }
        
        // Jika tidak ada images dari relasi, cek kolom images (JSON)
        if (empty($this->productImages) && !empty($this->product->images)) {
            // Jika kolom images berupa JSON array
            $this->productImages = is_array($this->product->images) 
                ? $this->product->images 
                : json_decode($this->product->images, true) ?? [];
        }
    }

    private function loadVariants()
    {
        // Dummy variants - nanti bisa diganti dengan data dari database
        // Contoh: ukuran berbeda untuk produk yang sama
        if ($this->product->unit) {
            $this->variants = [
                ['label' => '2L', 'value' => '2L'],
                ['label' => '1L', 'value' => '1L'],
                ['label' => '500ml', 'value' => '500ml'],
            ];
        }
    }

    public function selectVariant($variant)
    {
        $this->selectedVariant = $variant;
        $this->calculateTotal();
    }

    public function incrementQuantity()
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
            $this->calculateTotal();
        } else {
            $this->dispatch('notify', [
                'message' => '⚠️ Stok tidak mencukupi!',
                'type' => 'error'
            ]);
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->calculateTotal();
        }
    }

    public function updateQuantity()
    {
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }
        
        if ($this->quantity > $this->product->stock) {
            $this->quantity = $this->product->stock;
            $this->dispatch('notify', [
                'message' => '⚠️ Stok hanya tersedia ' . $this->product->stock . ' unit',
                'type' => 'error'
            ]);
        }
        
        $this->calculateTotal();
    }

    private function calculateTotal()
    {
        $this->totalPrice = $this->product->price * $this->quantity;
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            // Cek apakah produk sudah ada di cart
            $cartItem = CartItem::where('user_id', Auth::id())
                               ->where('product_id', $this->product->id)
                               ->first();

            if ($cartItem) {
                // Update quantity jika sudah ada
                $newQuantity = $cartItem->quantity + $this->quantity;
                
                if ($newQuantity > $this->product->stock) {
                    $this->dispatch('notify', [
                        'message' => '⚠️ Total quantity melebihi stok tersedia!',
                        'type' => 'error'
                    ]);
                    return;
                }
                
                $cartItem->update([
                    'quantity' => $newQuantity,
                ]);
            } else {
                // Tambah item baru ke cart
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $this->product->id,
                    'quantity' => $this->quantity,
                    'price' => $this->product->price,
                ]);
            }

            $this->dispatch('notify', [
                'message' => '✅ Produk berhasil ditambahkan ke keranjang!',
                'type' => 'success'
            ]);

            // Reset quantity
            $this->quantity = 1;
            $this->calculateTotal();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => '❌ Gagal menambahkan ke keranjang: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function buyNow()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Add to cart dulu
        $this->addToCart();

        // Redirect ke checkout
        return redirect()->route('checkout');
    }
}