<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerAddress;
use App\Models\User;

class CustomerAddressSeeder extends Seeder
{
    public function run()
    {
        // Ambil user pertama (EpsilonScorpii)
        $user = User::where('email', 'EpsilonScorpii@example.com')->first();

        if (!$user) {
            // Jika tidak ada, ambil user pertama yang ada
            $user = User::first();
        }

        if ($user) {
            $addresses = [
                [
                    'user_id' => $user->id,
                    'label' => 'Home',
                    'recipient_name' => $user->name,
                    'recipient_phone' => $user->phone ?? '081234567890',
                    'address' => 'Jl. Kemang Raya No.10, RT.10/RW.01, Bangka, Mampang Prapatan, Jakarta Selatan, DKI Jakarta 12730',
                    'latitude' => -6.2615,
                    'longitude' => 106.8166,
                    'is_default' => true,
                ],
                [
                    'user_id' => $user->id,
                    'label' => 'Office',
                    'recipient_name' => $user->name,
                    'recipient_phone' => $user->phone ?? '081234567890',
                    'address' => 'Jl. Cikini Raya No.27, RT.8/RW.2, Cikini, Menteng, Jakarta Pusat, DKI Jakarta 10330',
                    'latitude' => -6.1944,
                    'longitude' => 106.8428,
                    'is_default' => false,
                ],
                [
                    'user_id' => $user->id,
                    'label' => 'Friends',
                    'recipient_name' => 'Budi Santoso',
                    'recipient_phone' => '081987654321',
                    'address' => 'Jl. Kebayoran Lama No.36, RT.2/RW.1, Grogol Utara, Kebayoran Lama, Jakarta Selatan, DKI Jakarta 12220',
                    'latitude' => -6.2423,
                    'longitude' => 106.7830,
                    'is_default' => false,
                ],
            ];

            foreach ($addresses as $address) {
                CustomerAddress::create($address);
            }

            $this->command->info('✅ Customer addresses seeded successfully!');
        } else {
            $this->command->error('❌ No user found to seed addresses.');
        }
    }
}