<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('slug');
            $table->time('opening_time')->nullable()->after('phone');
            $table->time('closing_time')->nullable()->after('opening_time');
            $table->text('refund_policy')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['logo', 'opening_time', 'closing_time', 'refund_policy']);
        });
    }
};