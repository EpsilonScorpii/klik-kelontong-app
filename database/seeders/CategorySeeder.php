<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Sembako', 'icon' => '🌾'],
            ['name' => 'Makanan', 'icon' => '🍱'],
            ['name' => 'Minuman', 'icon' => '🥤'],
            ['name' => 'Kebersihan', 'icon' => '🧹'],
            ['name' => 'Obat-Obatan', 'icon' => '💊'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'is_active' => true,
            ]);
        }
    }
}