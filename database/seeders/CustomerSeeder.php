<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Store;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $store = Store::first();

        $customers = [
            ['name' => 'Alice', 'address' => 'Jl. Cikini Raya No.20', 'phone' => '081234567801', 'cashback' => 5000],
            ['name' => 'Stevan', 'address' => 'Jl. Cikini Raya No.15', 'phone' => '081234567802', 'cashback' => 5000],
            ['name' => 'Edward', 'address' => 'Jl. Cikini Raya No.32', 'phone' => '081234567803', 'cashback' => 0],
            ['name' => 'Layla', 'address' => 'Jl. Cikini Raya No.8', 'phone' => '081234567804', 'cashback' => 5000],
            ['name' => 'Tegar', 'address' => 'Jl. Cikini Raya No.13', 'phone' => '081234567805', 'cashback' => 0],
        ];

        foreach ($customers as $customer) {
            Customer::create([
                'store_id' => $store->id,
                'name' => $customer['name'],
                'address' => $customer['address'],
                'phone' => $customer['phone'],
                'cashback_balance' => $customer['cashback'],
                'loyalty_points' => rand(100, 1000),
                'total_orders' => rand(1, 5),
                'total_spent' => rand(50000, 200000),
            ]);
        }
    }
}