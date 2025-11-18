<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class Homepage extends Component
{
    public $categories = [];
    public $featuredProducts = [];
    public $recommendations = [];  // ✅ Tambahkan ini
    public $bestSellers = [];
    public $promoProducts = [];

    public function mount()
    {
        $this->loadCategories();
        $this->loadFeaturedProducts();
        $this->loadRecommendations();  // ✅ Tambahkan ini
        $this->loadBestSellers();
        $this->loadPromoProducts();
    }

    public function render()
    {
        return view('livewire.user.homepage')
                    ->layout('layouts.app', ['title' => 'Beranda']);
    }

    private function loadCategories()
    {
        $this->categories = Category::where('is_active', true)
                                   ->orderBy('name')
                                   ->take(5)
                                   ->get()
                                   ->toArray();
    }

    private function loadFeaturedProducts()
    {
        $this->featuredProducts = Product::where('is_active', true)
                                         ->where('stock', '>', 0)
                                         ->inRandomOrder()
                                         ->take(4)
                                         ->get()
                                         ->toArray();
    }

    // ✅ Tambahkan method ini
    private function loadRecommendations()
    {
        $this->recommendations = Product::where('is_active', true)
                                        ->where('stock', '>', 0)
                                        ->inRandomOrder()
                                        ->take(4)
                                        ->get()
                                        ->toArray();
    }

    private function loadBestSellers()
    {
        $this->bestSellers = Product::where('is_active', true)
                                    ->where('stock', '>', 0)
                                    ->inRandomOrder()
                                    ->take(4)
                                    ->get()
                                    ->toArray();
    }

    private function loadPromoProducts()
    {
        $this->promoProducts = Product::where('is_active', true)
                                      ->where('stock', '>', 0)
                                      ->where('discount_price', '>', 0)
                                      ->take(4)
                                      ->get()
                                      ->toArray();
    }

    // ✅ Tambahkan method untuk add to cart (jika dipanggil dari homepage)
    public function addToCart($productId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        try {
            $product = Product::findOrFail($productId);

            // Cek apakah produk sudah ada di cart
            $cartItem = \App\Models\CartItem::where('user_id', auth()->id())
                                           ->where('product_id', $productId)
                                           ->first();

            if ($cartItem) {
                // Update quantity
                $cartItem->increment('quantity');
            } else {
                // Tambah baru
                \App\Models\CartItem::create([
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                    'quantity' => 1,
                    'price' => $product->price,
                ]);
            }

            $this->dispatch('notify', [
                'message' => '✅ Produk berhasil ditambahkan ke keranjang!',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => '❌ Gagal menambahkan ke keranjang',
                'type' => 'error'
            ]);
        }
    }
}