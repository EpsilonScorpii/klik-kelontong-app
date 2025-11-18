<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialTransaction;
use App\Models\Store;
use Carbon\Carbon;

class FinancialSeeder extends Seeder
{
    public function run()
    {
        $store = Store::first();

        // Generate transaksi 5 bulan terakhir
        for ($month = 0; $month < 5; $month++) {
            $date = now()->subMonths($month);
            
            // Pengeluaran random
            for ($i = 0; $i < rand(5, 10); $i++) {
                FinancialTransaction::create([
                    'store_id' => $store->id,
                    'type' => 'expense',
                    'amount' => rand(10000, 50000),
                    'category' => 'Operasional',
                    'description' => 'Pengeluaran operasional',
                    'transaction_date' => $date->copy()->subDays(rand(1, 28)),
                ]);
            }
        }
    }
}