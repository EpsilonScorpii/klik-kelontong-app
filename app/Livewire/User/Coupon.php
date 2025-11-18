<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Coupon as CouponModel;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class Coupon extends Component
{
    public $availableCoupons = [];
    public $cartSubtotal = 0;

    public function mount()
    {
        $this->loadCoupons();
        $this->calculateCartSubtotal();
    }

    public function render()
    {
        return view('livewire.user.coupon')
                    ->layout('layouts.app', ['title' => 'Coupon']);
    }

    private function loadCoupons()
    {
        // Load active coupons
        $this->availableCoupons = CouponModel::where('is_active', true)
                                             ->where('start_date', '<=', now())
                                             ->where('end_date', '>=', now())
                                             ->orderBy('min_purchase', 'asc')
                                             ->get()
                                             ->toArray();
    }

    private function calculateCartSubtotal()
    {
        $this->cartSubtotal = CartItem::where('user_id', Auth::id())
                                      ->get()
                                      ->sum(function($item) {
                                          return $item->quantity * $item->price;
                                      });
    }

    public function useCoupon($couponId)
    {
        $coupon = CouponModel::find($couponId);
        
        if (!$coupon) {
            $this->dispatch('notify', [
                'message' => '❌ Kupon tidak ditemukan',
                'type' => 'error'
            ]);
            return;
        }

        // Check minimum purchase
        if ($this->cartSubtotal < $coupon->min_purchase) {
            $remaining = $coupon->min_purchase - $this->cartSubtotal;
            $this->dispatch('notify', [
                'message' => '⚠️ Tambah belanja Rp' . number_format($remaining, 0, ',', '.') . ' lagi untuk gunakan kupon ini',
                'type' => 'error'
            ]);
            return;
        }

        // Check usage limit
        if ($coupon->used_count >= $coupon->usage_limit) {
            $this->dispatch('notify', [
                'message' => '❌ Kupon sudah habis digunakan',
                'type' => 'error'
            ]);
            return;
        }

        // Save coupon to session/cart
        session(['applied_coupon' => $coupon->code]);

        $this->dispatch('notify', [
            'message' => '✅ Kupon berhasil diterapkan!',
            'type' => 'success'
        ]);

        // Redirect to cart with applied coupon
        return redirect()->route('cart')->with('coupon_applied', $coupon->code);
    }

    public function canUseCoupon($coupon)
    {
        return $this->cartSubtotal >= $coupon['min_purchase'];
    }

    public function getRemainingAmount($coupon)
    {
        if ($this->cartSubtotal >= $coupon['min_purchase']) {
            return 0;
        }
        return $coupon['min_purchase'] - $this->cartSubtotal;
    }
}