<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->default(0)->after('stock'); // Rating 0.0 - 5.0
            $table->integer('total_sales')->default(0)->after('rating'); // Total terjual
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['rating', 'total_sales']);
        });
    }
};