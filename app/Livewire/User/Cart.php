<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Coupon as CouponModel;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $cartItems = [];
    public $promoCode = '';
    public $appliedCoupon = null;
    public $discount = 0;
    public $deliveryFee = 5000;
    
    // Modal remove
    public $showRemoveModal = false;
    public $itemToRemove = null;

    public function mount()
    {
        $this->loadCartItems();
        $this->loadAppliedCoupon();
    }

    public function render()
    {
        $subtotal = $this->calculateSubtotal();
        $total = $subtotal + $this->deliveryFee - $this->discount;

        return view('livewire.user.cart', [
            'subtotal' => $subtotal,
            'total' => $total,
        ])->layout('layouts.app', ['title' => 'My Cart']);
    }

    private function loadCartItems()
    {
        $this->cartItems = CartItem::with('product')
                                   ->where('user_id', Auth::id())
                                   ->get()
                                   ->toArray();
    }

    private function loadAppliedCoupon()
    {
        $couponCode = session('applied_coupon');
        
        if ($couponCode) {
            $this->appliedCoupon = CouponModel::where('code', $couponCode)
                                              ->where('is_active', true)
                                              ->first();
            
            if ($this->appliedCoupon) {
                $this->promoCode = $this->appliedCoupon->code;
                $this->calculateDiscount();
            } else {
                session()->forget('applied_coupon');
            }
        }
    }

    private function calculateSubtotal()
    {
        return collect($this->cartItems)->sum(function($item) {
            return $item['quantity'] * $item['price'];
        });
    }

    private function calculateDiscount()
    {
        if (!$this->appliedCoupon) {
            $this->discount = 0;
            return;
        }

        $subtotal = $this->calculateSubtotal();

        if ($this->appliedCoupon->type === 'percentage') {
            $this->discount = ($subtotal * $this->appliedCoupon->value) / 100;
        } elseif ($this->appliedCoupon->type === 'fixed_amount') {
            $this->discount = $this->appliedCoupon->value;
        } elseif ($this->appliedCoupon->type === 'free_delivery') {
            $this->discount = min($this->deliveryFee, $this->appliedCoupon->value);
        }
    }

    public function incrementQuantity($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        
        if ($cartItem && $cartItem->quantity < $cartItem->product->stock) {
            $cartItem->increment('quantity');
            $this->loadCartItems();
            $this->calculateDiscount(); // Recalculate discount
            
            $this->dispatch('notify', [
                'message' => '✅ Quantity berhasil ditambah',
                'type' => 'success'
            ]);
        } else {
            $this->dispatch('notify', [
                'message' => '⚠️ Stok tidak mencukupi',
                'type' => 'error'
            ]);
        }
    }

    public function decrementQuantity($cartItemId)
    {
        try {
            $cartItem = CartItem::findOrFail($cartItemId);

            if ($cartItem->quantity <= 1) {
                // ✅ Jika quantity = 1, langsung delete (atau panggil confirm)
                $this->confirmRemove($cartItemId);
                return;
            }

            $cartItem->decrement('quantity');
            $this->loadCart();
            $this->dispatch('notify', ['message' => '✅ Quantity updated', 'type' => 'success']);

        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => '❌ Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $cartItem = CartItem::find($cartItemId);
        
        if ($cartItem) {
            if ($quantity < 1) {
                $quantity = 1;
            }
            
            if ($quantity > $cartItem->product->stock) {
                $quantity = $cartItem->product->stock;
                $this->dispatch('notify', [
                    'message' => '⚠️ Stok hanya tersedia ' . $cartItem->product->stock . ' unit',
                    'type' => 'error'
                ]);
            }
            
            $cartItem->update(['quantity' => $quantity]);
            $this->loadCartItems();
            $this->calculateDiscount(); // Recalculate discount
        }
    }

    public function confirmRemove($cartItemId)
    {
        $this->itemToRemove = CartItem::with('product')->find($cartItemId);
        $this->showRemoveModal = true;
    }

    public function removeFromCart()
    {
        if ($this->itemToRemove) {
            $this->itemToRemove->delete();
            $this->showRemoveModal = false;
            $this->itemToRemove = null;
            $this->loadCartItems();
            $this->calculateDiscount(); // Recalculate discount
            
            $this->dispatch('notify', [
                'message' => '✅ Produk berhasil dihapus dari keranjang',
                'type' => 'success'
            ]);
        }
    }

    public function cancelRemove()
    {
        $this->showRemoveModal = false;
        $this->itemToRemove = null;
    }

    public function goToCoupons()
    {
        return redirect()->route('coupons');
    }

    public function applyPromoCode()
    {
        if (empty($this->promoCode)) {
            $this->dispatch('notify', [
                'message' => '⚠️ Masukkan kode kupon',
                'type' => 'error'
            ]);
            return;
        }

        $coupon = CouponModel::where('code', strtoupper($this->promoCode))
                            ->where('is_active', true)
                            ->where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->first();

        if (!$coupon) {
            $this->dispatch('notify', [
                'message' => '❌ Kode kupon tidak valid',
                'type' => 'error'
            ]);
            return;
        }

        $subtotal = $this->calculateSubtotal();

        if ($subtotal < $coupon->min_purchase) {
            $remaining = $coupon->min_purchase - $subtotal;
            $this->dispatch('notify', [
                'message' => '⚠️ Minimum belanja Rp' . number_format($coupon->min_purchase, 0, ',', '.') . '. Tambah Rp' . number_format($remaining, 0, ',', '.') . ' lagi',
                'type' => 'error'
            ]);
            return;
        }

        if ($coupon->used_count >= $coupon->usage_limit) {
            $this->dispatch('notify', [
                'message' => '❌ Kupon sudah mencapai batas penggunaan',
                'type' => 'error'
            ]);
            return;
        }

        $this->appliedCoupon = $coupon;
        session(['applied_coupon' => $coupon->code]);
        $this->calculateDiscount();

        $this->dispatch('notify', [
            'message' => '✅ Kupon berhasil diterapkan! Hemat Rp' . number_format($this->discount, 0, ',', '.'),
            'type' => 'success'
        ]);
    }

    public function removeCoupon()
    {
        $this->appliedCoupon = null;
        $this->promoCode = '';
        $this->discount = 0;
        session()->forget('applied_coupon');

        $this->dispatch('notify', [
            'message' => '✅ Kupon dihapus',
            'type' => 'success'
        ]);
    }

    public function proceedToCheckout()
    {
        if (count($this->cartItems) === 0) {
            $this->dispatch('notify', [
                'message' => '⚠️ Keranjang belanja kosong',
                'type' => 'error'
            ]);
            return;
        }

        return redirect()->route('checkout');
    }
}