<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['card', 'ewallet']); // card atau ewallet
            
            // For Card
            $table->string('card_type')->nullable(); // visa, mastercard, etc
            $table->string('card_holder_name')->nullable();
            $table->string('card_number')->nullable(); // encrypted
            $table->string('card_last_four', 4)->nullable(); // last 4 digits untuk display
            $table->string('expiry_date', 5)->nullable(); // MM/YY
            $table->string('cvv')->nullable(); // encrypted (tidak recommended disimpan)
            
            // For E-Wallet
            $table->string('ewallet_provider')->nullable(); // dana, ovo, gopay
            $table->string('ewallet_account')->nullable(); // phone number atau email
            $table->boolean('is_linked')->default(false);
            
            // General
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_payment_methods');
    }
};