<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Store;
use App\Models\CustomerAddress;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Get user EpsilonScorpii (bukan admin)
        $user = User::where('email', 'EpsilonScorpii@example.com')
                    ->where('is_admin', false)
                    ->first();
        
        if (!$user) {
            // Jika tidak ada, buat user baru
            $user = User::create([
                'name' => 'Epsilon Scorpii',
                'email' => 'EpsilonScorpii@example.com',
                'phone' => '081234567890',
                'password' => bcrypt('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]);
        }

        $store = Store::first();
        
        if (!$store) {
            $this->command->error('❌ No store found. Please run StoreSeeder first.');
            return;
        }

        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();

        if ($products->count() === 0) {
            $this->command->error('❌ No products found. Please run ProductSeeder first.');
            return;
        }

        // Get user address
        $address = CustomerAddress::where('user_id', $user->id)->first();
        
        $defaultAddress = [
            'label' => $address->label ?? 'Home',
            'recipient_name' => $address->recipient_name ?? $user->name,
            'recipient_phone' => $address->recipient_phone ?? $user->phone ?? '081234567890',
            'address' => $address->address ?? 'Jl. Kemang Raya No.10, RT.10/RW.01, Bangka, Mampang Prapatan, Jakarta Selatan, DKI Jakarta 12730',
        ];

        $this->command->info("Creating orders for user: {$user->name} ({$user->email})");

        // ===== ACTIVE ORDERS (3 orders) =====
        $this->command->info('Creating Active orders...');
        
        $activeStatuses = ['pending', 'confirmed', 'processing'];
        for ($i = 0; $i < 3; $i++) {
            $this->createOrder($user, $store, $products, $defaultAddress, [
                'status' => $activeStatuses[$i],
                'payment_status' => 'pending',
                'shipping_method' => 'Express',
                'created_at' => now()->subHours(rand(1, 48)),
            ]);
        }

        // ===== COMPLETED ORDERS (4 orders) =====
        $this->command->info('Creating Completed orders...');
        
        for ($i = 0; $i < 4; $i++) {
            $this->createOrder($user, $store, $products, $defaultAddress, [
                'status' => 'delivered',
                'payment_status' => 'paid',
                'shipping_method' => rand(0, 1) ? 'Express' : 'Regular',
                'created_at' => now()->subDays(rand(3, 30)),
                'updated_at' => now()->subDays(rand(1, 29)),
            ]);
        }

        // ===== CANCELLED ORDERS (4 orders) =====
        $this->command->info('Creating Cancelled orders...');
        
        for ($i = 0; $i < 4; $i++) {
            $this->createOrder($user, $store, $products, $defaultAddress, [
                'status' => 'cancelled',
                'payment_status' => 'cancelled',
                'shipping_method' => 'Regular',
                'created_at' => now()->subDays(rand(5, 60)),
                'updated_at' => now()->subDays(rand(4, 59)),
            ]);
        }

        $this->command->info('✅ Orders seeded successfully for user EpsilonScorpii!');
        $this->command->table(
            ['Total Orders', 'Active', 'Completed', 'Cancelled'],
            [[11, 3, 4, 4]]
        );
    }

    private function createOrder($user, $store, $products, $address, $attributes = [])
    {
        $subtotal = 0;
        
        $order = Order::create(array_merge([
            'user_id' => $user->id,
            'store_id' => $store->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'subtotal' => 0, // Will update later
            'delivery_fee' => 5000,
            'discount' => 0,
            'total' => 0, // Will update later
            'payment_method' => 'cod',
            'delivery_address' => json_encode($address),
            'notes' => null,
        ], $attributes));

        // Add 1-3 items per order
        $itemCount = rand(1, 3);
        $selectedProducts = $products->random($itemCount);

        foreach ($selectedProducts as $product) {
            $quantity = rand(1, 3);
            $price = $product->price;
            $itemSubtotal = $quantity * $price;
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $itemSubtotal,
            ]);
            
            $subtotal += $itemSubtotal;
        }

        // Update order total
        $total = $subtotal + $order->delivery_fee - $order->discount;
        $order->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);

        return $order;
    }
}