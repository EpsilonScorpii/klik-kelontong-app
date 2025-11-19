<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Conversations table
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Customer
            $table->foreignId('store_id')->constrained()->onDelete('cascade'); // Store/Toko
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });

        // Messages table
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->enum('sender_type', ['user', 'store']); // Who sent the message
            $table->text('message')->nullable();
            $table->string('image')->nullable();
            $table->string('audio')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // User Notifications table
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // order_shipped, review_product, promo, etc
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable();
            $table->json('data')->nullable(); // Extra data (order_id, product_id, etc)
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('user_notifications');
    }
};