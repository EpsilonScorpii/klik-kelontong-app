<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPaymentMethod;
use App\Models\User;

class UserPaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'EpsilonScorpii@example.com')->first();

        if (!$user) {
            $user = User::first();
        }

        if ($user) {
            $paymentMethods = [
                // Card 1
                [
                    'user_id' => $user->id,
                    'type' => 'card',
                    'card_type' => 'visa',
                    'card_holder_name' => strtoupper($user->name),
                    'card_number' => '4532123456789012', // Dummy VISA number
                    'expiry_date' => '12/25',
                    'is_default' => true,
                ],
                // Card 2
                [
                    'user_id' => $user->id,
                    'type' => 'card',
                    'card_type' => 'mastercard',
                    'card_holder_name' => strtoupper($user->name),
                    'card_number' => '5425233430109903', // Dummy Mastercard number
                    'expiry_date' => '06/26',
                    'is_default' => false,
                ],
                // E-Wallet: Dana
                [
                    'user_id' => $user->id,
                    'type' => 'ewallet',
                    'ewallet_provider' => 'dana',
                    'ewallet_account' => $user->phone ?? '081234567890',
                    'is_linked' => true,
                    'is_default' => false,
                ],
                // E-Wallet: OVO (not linked)
                [
                    'user_id' => $user->id,
                    'type' => 'ewallet',
                    'ewallet_provider' => 'ovo',
                    'ewallet_account' => null,
                    'is_linked' => false,
                    'is_default' => false,
                ],
                // E-Wallet: Gopay (not linked)
                [
                    'user_id' => $user->id,
                    'type' => 'ewallet',
                    'ewallet_provider' => 'gopay',
                    'ewallet_account' => null,
                    'is_linked' => false,
                    'is_default' => false,
                ],
            ];

            foreach ($paymentMethods as $method) {
                UserPaymentMethod::create($method);
            }

            $this->command->info('✅ User payment methods seeded successfully!');
        } else {
            $this->command->error('❌ No user found to seed payment methods.');
        }
    }
}