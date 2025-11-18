<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->string('type'); // 'general', 'rate', 'area'
            $table->string('key'); // nama setting
            $table->text('value'); // nilai setting
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->decimal('distance_from', 8, 2); // km awal
            $table->decimal('distance_to', 8, 2)->nullable(); // km akhir (null = unlimited)
            $table->decimal('cost', 10, 2); // biaya
            $table->string('label'); // label untuk tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->string('area_name'); // nama wilayah
            $table->string('city')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_areas');
        Schema::dropIfExists('shipping_rates');
        Schema::dropIfExists('shipping_settings');
    }
};