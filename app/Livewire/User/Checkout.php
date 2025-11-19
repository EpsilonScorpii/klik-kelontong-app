<?php
// v16
// prev : v9
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
    public $currentStep = 1; // 1-5 steps

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

    // Payment methods
    public $paymentMethods = [
        'cod' => [
            'id' => 'cod',
            'name' => 'Cash On Delivery',
            'description' => 'Bayar saat barang diterima',
        ],
        'dana' => [
            'id' => 'dana',
            'name' => 'Dana',
            'description' => 'E-Wallet Dana',
        ],
        'ovo' => [
            'id' => 'ovo',
            'name' => 'OVO',
            'description' => 'E-Wallet OVO',
        ],
        'gopay' => [
            'id' => 'gopay',
            'name' => 'Gopay',
            'description' => 'E-Wallet Gopay',
        ],
    ];
    public $selectedPaymentMethod = 'cod';

    public $cartItems = [];
    public $subtotal = 0;
    public $shippingCost = 10000;
    public $discount = 0;
    public $appliedCoupon = null;
    public $total = 0;

    public $createdOrder = null; // Store created order

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
        $pageTitle = match ($this->currentStep) {
            1 => 'Shipping Address',
            2 => 'Choose Shipping',
            3 => 'Checkout',
            4 => 'Pembayaran',
            5 => 'Payment Success',
            default => 'Checkout',
        };

        return view('livewire.user.checkout')->layout('layouts.app', ['title' => $pageTitle]);
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

    public function selectPaymentMethod($method)
    {
        $this->selectedPaymentMethod = $method;
        Log::info('Payment method selected', ['method' => $method]);
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
        Log::info('nextStep() called', ['current_step' => $this->currentStep]);

        if ($this->currentStep === 1) {
            if (!$this->selectedAddressId) {
                $this->dispatch('notify', ['message' => '⚠️ Pilih alamat', 'type' => 'error']);
                return;
            }
            $this->currentStep = 2;
            Log::info('Moved to step 2');
        } elseif ($this->currentStep === 2) {
            if (!$this->selectedShipping) {
                $this->dispatch('notify', ['message' => '⚠️ Pilih shipping', 'type' => 'error']);
                return;
            }
            $this->currentStep = 3;
            Log::info('Moved to step 3');
        } elseif ($this->currentStep === 3) {
            Log::info('Creating order from step 3...');
            $this->createOrder();
            // currentStep akan di-set di dalam createOrder()

        } elseif ($this->currentStep === 4) {
            Log::info('Processing payment from step 4...');
            $this->processPayment();
            // currentStep akan di-set di dalam processPayment()
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

    private function createOrder()
    {
        Log::info('=== createOrder() called ===', [
            'current_step' => $this->currentStep,
            'cart_items' => count($this->cartItems),
        ]);

        try {
            DB::beginTransaction();

            $address = $this->selectedAddress;
            $shipping = $this->selectedShippingData;
            $storeId = $this->cartItems[0]['product']['store_id'] ?? null;

            Log::info('Preparing order data...');

            // ✅ Insert menggunakan DB::table untuk bypass masalah
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => Auth::id(),
                'store_id' => $storeId,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'subtotal' => $this->subtotal ?? 0,
                'delivery_fee' => $this->shippingCost ?? 0,
                'service_fee' => 0,
                'discount' => $this->discount ?? 0,
                'total' => $this->total ?? 0,
                'total_amount' => $this->total ?? 0, // Jika kolom ini ada
                'payment_method' => $this->selectedPaymentMethod ?? 'cod',
                'payment_status' => 'pending',
                'delivery_address' => json_encode([
                    'label' => $address['label'] ?? '',
                    'recipient_name' => $address['recipient_name'] ?? '',
                    'recipient_phone' => $address['recipient_phone'] ?? '',
                    'address' => $address['address'] ?? '',
                ]),
                'shipping_method' => $shipping['name'] ?? 'Express',
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Order inserted', ['order_id' => $orderId]);

            // Get order object
            $order = Order::find($orderId);

            // Create order items
            foreach ($this->cartItems as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Log::info('Order items created');

            if ($this->appliedCoupon) {
                DB::table('coupon_usages')->insert([
                    'coupon_id' => $this->appliedCoupon->id,
                    'user_id' => Auth::id(),
                    'order_id' => $orderId,
                    'discount_amount' => $this->discount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('coupons')
                    ->where('id', $this->appliedCoupon->id)
                    ->increment('used_count');

                Log::info('Coupon applied');
            }

            DB::commit();

            $this->createdOrder = $order;

            Log::info('✅ Order creation SUCCESS, moving to step 4');

            // ✅ Set step ke 4
            $this->currentStep = 4;

            $this->dispatch('notify', ['message' => '✅ Order berhasil dibuat!', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ createOrder() FAILED', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('notify', ['message' => '❌ Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    private function processPayment()
    {
        Log::info('=== processPayment() called ===', [
            'order_id' => $this->createdOrder->id ?? 'null',
            'payment_method' => $this->selectedPaymentMethod,
        ]);

        if (!$this->createdOrder) {
            Log::error('No order found to process payment');
            $this->dispatch('notify', ['message' => '⚠️ Order tidak ditemukan', 'type' => 'error']);
            return;
        }

        try {
            $this->createdOrder->update([
                'payment_method' => $this->selectedPaymentMethod,
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);

            Log::info('Payment processed', ['order_id' => $this->createdOrder->id]);

            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();
            session()->forget('applied_coupon');

            Log::info('Cart cleared, moving to step 5');

            // ✅ Set step ke 5 (success)
            $this->currentStep = 5;

            Log::info('Step changed to 5', ['current_step' => $this->currentStep]);

            $this->dispatch('notify', ['message' => '✅ Pembayaran berhasil!', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('=== processPayment() FAILED ===', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            $this->dispatch('notify', ['message' => '❌ Gagal: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function backToHome()
    {
        return redirect()->route('home');
    }

    public function viewOrder()
    {
        return redirect()->route('activities');
    }
}
