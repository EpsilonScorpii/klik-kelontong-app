<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon as CouponModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Checkout extends Component
{
    public $currentStep = 1;
    public $addresses = [];
    public $selectedAddressId = null;
    public $selectedAddress = null;
    public $showAddAddressModal = false;
    
    public $newAddress = [
        'label' => '',
        'recipient_name' => '',
        'recipient_phone' => '',
        'address' => '',
        'latitude' => null,
        'longitude' => null,
        'is_default' => false,
    ];
    
    public $shippingMethods = [
        [
            'id' => 'regular',
            'name' => 'Regular',
            'description' => 'Estimated Arrival 2 - 6 Jam',
            'cost' => 5000,
        ],
        [
            'id' => 'express',
            'name' => 'Express',
            'description' => 'Estimated Arrival 10 - 60 Menit',
            'cost' => 10000,
        ],
    ];
    public $selectedShipping = 'express';
    public $selectedShippingData = null;
    
    public $cartItems = [];
    public $subtotal = 0;
    public $shippingCost = 10000;
    public $discount = 0;
    public $appliedCoupon = null;
    public $total = 0;

    public function mount()
    {
        $cartCount = CartItem::where('user_id', Auth::id())->count();
        if ($cartCount === 0) {
            return redirect()->route('cart')->with('error', '⚠️ Keranjang belanja kosong');
        }

        $this->loadAddresses();
        $this->loadCartItems();
        $this->loadAppliedCoupon();
        $this->loadSelectedShippingData();
        $this->calculateTotal();
    }

    public function render()
    {
        return view('livewire.user.checkout')->layout('layouts.app', ['title' => 'Checkout']);
    }

    private function loadAddresses()
    {
        $this->addresses = CustomerAddress::where('user_id', Auth::id())
                                         ->orderBy('is_default', 'desc')
                                         ->get()
                                         ->toArray();
        
        $defaultAddress = collect($this->addresses)->firstWhere('is_default', true);
        if ($defaultAddress) {
            $this->selectedAddressId = $defaultAddress['id'];
            $this->selectedAddress = $defaultAddress;
        } elseif (count($this->addresses) > 0) {
            $this->selectedAddressId = $this->addresses[0]['id'];
            $this->selectedAddress = $this->addresses[0];
        }
    }

    private function loadCartItems()
    {
        $this->cartItems = CartItem::with('product')->where('user_id', Auth::id())->get()->toArray();
        $this->subtotal = collect($this->cartItems)->sum(fn($item) => $item['quantity'] * $item['price']);
    }

    private function loadAppliedCoupon()
    {
        $couponCode = session('applied_coupon');
        if ($couponCode) {
            $this->appliedCoupon = CouponModel::where('code', $couponCode)->where('is_active', true)->first();
            if ($this->appliedCoupon) {
                $this->calculateDiscount();
            }
        }
    }

    private function loadSelectedShippingData()
    {
        $this->selectedShippingData = collect($this->shippingMethods)->firstWhere('id', $this->selectedShipping);
        $this->shippingCost = $this->selectedShippingData['cost'];
    }

    private function calculateDiscount()
    {
        if (!$this->appliedCoupon) {
            $this->discount = 0;
            return;
        }

        if ($this->appliedCoupon->type === 'percentage') {
            $this->discount = ($this->subtotal * $this->appliedCoupon->value) / 100;
        } elseif ($this->appliedCoupon->type === 'fixed_amount') {
            $this->discount = $this->appliedCoupon->value;
        } elseif ($this->appliedCoupon->type === 'free_delivery') {
            $this->discount = min($this->shippingCost, $this->appliedCoupon->value);
        }
    }

    private function calculateTotal()
    {
        $this->total = $this->subtotal + $this->shippingCost - $this->discount;
    }

    public function selectAddress($addressId)
    {
        $this->selectedAddressId = $addressId;
        $this->selectedAddress = collect($this->addresses)->firstWhere('id', $addressId);
    }

    public function selectShipping($shippingId)
    {
        $this->selectedShipping = $shippingId;
        $shipping = collect($this->shippingMethods)->firstWhere('id', $shippingId);
        if ($shipping) {
            $this->shippingCost = $shipping['cost'];
            $this->selectedShippingData = $shipping;
            $this->calculateDiscount();
            $this->calculateTotal();
        }
    }

    public function changeAddress()
    {
        $this->currentStep = 1;
    }

    public function changeShipping()
    {
        $this->currentStep = 2;
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            if (!$this->selectedAddressId) {
                $this->dispatch('notify', ['message' => '⚠️ Pilih alamat pengiriman', 'type' => 'error']);
                return;
            }
            $this->currentStep = 2;
        } elseif ($this->currentStep === 2) {
            if (!$this->selectedShipping) {
                $this->dispatch('notify', ['message' => '⚠️ Pilih metode pengiriman', 'type' => 'error']);
                return;
            }
            $this->currentStep = 3;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        } else {
            return redirect()->route('cart');
        }
    }

    public function toggleAddAddressModal()
    {
        $this->showAddAddressModal = !$this->showAddAddressModal;
        
        if (!$this->showAddAddressModal) {
            $this->reset('newAddress');
        } else {
            $this->newAddress['recipient_name'] = Auth::user()->name;
            $this->newAddress['recipient_phone'] = Auth::user()->phone ?? '';
        }
    }

    public function saveNewAddress()
    {
        $this->validate([
            'newAddress.label' => 'required|string|max:50',
            'newAddress.recipient_name' => 'required|string|max:100',
            'newAddress.recipient_phone' => 'required|string|max:20',
            'newAddress.address' => 'required|string',
        ]);

        try {
            $address = CustomerAddress::create([
                'user_id' => Auth::id(),
                'label' => $this->newAddress['label'],
                'recipient_name' => $this->newAddress['recipient_name'],
                'recipient_phone' => $this->newAddress['recipient_phone'],
                'address' => $this->newAddress['address'],
                'latitude' => $this->newAddress['latitude'],
                'longitude' => $this->newAddress['longitude'],
                'is_default' => $this->newAddress['is_default'],
            ]);

            $this->loadAddresses();
            $this->selectedAddressId = $address->id;
            $this->selectedAddress = $address->toArray();
            $this->toggleAddAddressModal();

            $this->dispatch('notify', ['message' => '✅ Alamat berhasil ditambahkan', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => '❌ Gagal: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function continueToPayment()
    {
        Log::info('=== Continue to Payment clicked ===', [
            'user_id' => Auth::id(),
            'step' => $this->currentStep,
            'cart_count' => count($this->cartItems),
            'address_id' => $this->selectedAddressId,
            'shipping' => $this->selectedShipping,
        ]);

        if (count($this->cartItems) === 0) {
            Log::warning('Cart is empty');
            $this->dispatch('notify', ['message' => '⚠️ Keranjang kosong', 'type' => 'error']);
            return redirect()->route('cart');
        }

        if (!$this->selectedAddressId || !$this->selectedShipping) {
            Log::warning('Missing address or shipping');
            $this->dispatch('notify', ['message' => '⚠️ Lengkapi data', 'type' => 'error']);
            return;
        }

        try {
            DB::beginTransaction();

            $address = $this->selectedAddress;
            $shipping = $this->selectedShippingData;
            $storeId = $this->cartItems[0]['product']['store_id'] ?? null;

            Log::info('Creating order...', ['store_id' => $storeId, 'total' => $this->total]);

            $order = Order::create([
                'user_id' => Auth::id(),
                'store_id' => $storeId,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'subtotal' => $this->subtotal,
                'delivery_fee' => $this->shippingCost,
                'service_fee' => 0,
                'discount' => $this->discount,
                'total' => $this->total,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'delivery_address' => json_encode([
                    'label' => $address['label'],
                    'recipient_name' => $address['recipient_name'],
                    'recipient_phone' => $address['recipient_phone'],
                    'address' => $address['address'],
                ]),
                'shipping_method' => $shipping['name'],
            ]);

            Log::info('Order created', ['order_id' => $order->id, 'order_number' => $order->order_number]);

            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                ]);
            }

            if ($this->appliedCoupon) {
                \App\Models\CouponUsage::create([
                    'coupon_id' => $this->appliedCoupon->id,
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'discount_amount' => $this->discount,
                ]);
                $this->appliedCoupon->increment('used_count');
            }

            CartItem::where('user_id', Auth::id())->delete();
            session()->forget('applied_coupon');

            DB::commit();

            Log::info('Order completed successfully', ['order_id' => $order->id]);

            $this->dispatch('notify', ['message' => '✅ Pesanan berhasil dibuat!', 'type' => 'success']);

            return $this->redirect(route('payment', ['orderId' => $order->id]), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            $this->dispatch('notify', ['message' => '❌ Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }
}