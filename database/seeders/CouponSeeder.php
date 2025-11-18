<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use App\Models\Store;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run()
    {
        // Ambil store pertama, atau create jika belum ada
        $store = Store::first();

        if (!$store) {
            // Create dummy store jika belum ada
            $admin = \App\Models\User::where('is_admin', true)->first();
            
            if ($admin) {
                $store = Store::create([
                    'user_id' => $admin->id,
                    'name' => 'Klik Kelontong Store',
                    'slug' => 'klik-kelontong-store',
                    'address' => 'Jakarta, Indonesia',
                    'phone' => '081234567890',
                    'is_active' => true,
                ]);
            }
        }

        $coupons = [
            [
                'store_id' => $store->id ?? null,
                'code' => 'ONGKIR5K',
                'name' => 'GRATIS ONGKIR RP 5000',
                'description' => 'Gratis ongkir untuk pembelian minimum Rp 50.000',
                'type' => 'free_delivery',
                'value' => 5000,
                'min_purchase' => 50000,
                'usage_limit' => 100,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
                'is_active' => true,
            ],
            [
                'store_id' => $store->id ?? null,
                'code' => 'CASHBACK5',
                'name' => 'CASHBACK 5%',
                'description' => 'Dapatkan cashback 5% untuk pembelian minimum Rp 50.000',
                'type' => 'percentage',
                'value' => 5,
                'min_purchase' => 50000,
                'usage_limit' => 50,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
                'is_active' => true,
            ],
            [
                'store_id' => $store->id ?? null,
                'code' => 'DISC10K',
                'name' => 'DISKON RP 10.000',
                'description' => 'Diskon Rp 10.000 untuk pembelian minimum Rp 100.000',
                'type' => 'fixed_amount',
                'value' => 10000,
                'min_purchase' => 100000,
                'usage_limit' => 30,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
                'is_active' => true,
            ],
            [
                'store_id' => $store->id ?? null,
                'code' => 'NEWUSER',
                'name' => 'WELCOME NEW USER',
                'description' => 'Diskon 10% untuk pengguna baru (max Rp 20.000)',
                'type' => 'percentage',
                'value' => 10,
                'min_purchase' => 30000,
                'usage_limit' => 200,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(60),
                'is_active' => true,
            ],
            [
                'store_id' => $store->id ?? null,
                'code' => 'FREEONGKIR',
                'name' => 'FREE DELIVERY',
                'description' => 'Gratis ongkir tanpa minimum pembelian',
                'type' => 'free_delivery',
                'value' => 10000,
                'min_purchase' => 0,
                'usage_limit' => 50,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(7),
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}