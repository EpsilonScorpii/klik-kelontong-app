<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        if ($user) {
            Store::create([
                'user_id' => $user->id,
                'name' => 'Toko Kelontong Berkah',
                'slug' => 'toko-kelontong-berkah',
                'description' => 'Toko kelontong terpercaya sejak 2025',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'phone' => '081234567890',
                'is_active' => true,
            ]);
        }
    }
}