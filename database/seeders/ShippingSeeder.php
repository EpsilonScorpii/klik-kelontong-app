<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingSetting;
use App\Models\ShippingRate;
use App\Models\ServiceArea;
use App\Models\Store;

class ShippingSeeder extends Seeder
{
    public function run()
    {
        $store = Store::first();

        // General Settings
        ShippingSetting::create([
            'store_id' => $store->id,
            'type' => 'general',
            'key' => 'delivery_time',
            'value' => 'Dikirim setelah pesanan masuk 30-60menit',
            'is_active' => true,
        ]);

        // Shipping Rates
        $rates = [
            ['from' => 0, 'to' => 1, 'cost' => 3000, 'label' => '< 1km'],
            ['from' => 1, 'to' => 2, 'cost' => 4000, 'label' => '< 2km'],
            ['from' => 2, 'to' => 3, 'cost' => 5000, 'label' => '< 3km'],
            ['from' => 4, 'to' => 5, 'cost' => 7000, 'label' => '4 - 5km'],
            ['from' => 5, 'to' => null, 'cost' => 0, 'label' => '> 5km Tidak Terjangkau'],
        ];

        foreach ($rates as $rate) {
            ShippingRate::create([
                'store_id' => $store->id,
                'distance_from' => $rate['from'],
                'distance_to' => $rate['to'],
                'cost' => $rate['cost'],
                'label' => $rate['label'],
                'is_active' => true,
            ]);
        }

        // Service Areas
        $areas = [
            'Jakarta Pusat',
            'Jakarta Selatan',
            'Jakarta Barat',
            'Jakarta Timur',
            'Jakarta Utara',
        ];

        foreach ($areas as $area) {
            ServiceArea::create([
                'store_id' => $store->id,
                'area_name' => $area,
                'is_active' => true,
            ]);
        }
    }
}