<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed_amount', 'free_delivery'])->default('percentage');
            $table->decimal('value', 10, 2); // nilai diskon atau gratis ongkir
            $table->decimal('min_purchase', 10, 2)->default(0); // minimum pembelian
            $table->integer('usage_limit')->default(100); // batas penggunaan
            $table->integer('used_count')->default(0); // sudah digunakan berapa kali
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk tracking penggunaan coupon per user
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->decimal('discount_amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
        Schema::dropIfExists('coupons');
    }
};