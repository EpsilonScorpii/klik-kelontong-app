<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if total_amount exists and total doesn't, then rename
        if (Schema::hasColumn('orders', 'total_amount') && !Schema::hasColumn('orders', 'total')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('total_amount', 'total');
            });
        }
        
        // If both exist, drop total_amount (assuming total is the correct one)
        if (Schema::hasColumn('orders', 'total_amount') && Schema::hasColumn('orders', 'total')) {
            // Copy data from total_amount to total if total is null/zero
            DB::statement('UPDATE orders SET total = total_amount WHERE total = 0 OR total IS NULL');
            
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('total_amount');
            });
        }
        
        Schema::table('orders', function (Blueprint $table) {
            // Add missing columns only if they don't exist
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('orders', 'delivery_fee')) {
                $table->decimal('delivery_fee', 10, 2)->default(0)->after('subtotal');
            }
            if (!Schema::hasColumn('orders', 'service_fee')) {
                $table->decimal('service_fee', 10, 2)->default(0)->after('delivery_fee');
            }
            if (!Schema::hasColumn('orders', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->after('service_fee');
            }
            // total already exists, skip
            
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('total');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'delivery_address')) {
                $table->json('delivery_address')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->string('shipping_method')->nullable()->after('delivery_address');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('shipping_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['subtotal', 'delivery_fee', 'service_fee', 'discount', 'payment_method', 'payment_status', 'delivery_address', 'shipping_method', 'notes'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};