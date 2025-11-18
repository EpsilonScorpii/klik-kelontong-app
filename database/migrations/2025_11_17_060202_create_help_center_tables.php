<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel untuk FAQ
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // All, Services, General, Account
            $table->string('question');
            $table->text('answer');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk Contact Methods
        Schema::create('contact_methods', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // customer_service, whatsapp, instagram, email
            $table->string('label');
            $table->string('value'); // phone number, username, email
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk Support Tickets
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('contact_methods');
        Schema::dropIfExists('faqs');
    }
};