<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Seeders\UserSeeder;
use App\Seeders\CategorySeeder;
use App\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            CouponSeeder::class,
            CustomerAddressSeeder::class,
        ]);
    }
}