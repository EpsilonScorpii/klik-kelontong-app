<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel untuk withdrawal/penarikan dana
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_holder');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Tabel untuk transaksi keuangan
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->enum('type', ['income', 'expense']); // pemasukan atau pengeluaran
            $table->decimal('amount', 12, 2);
            $table->string('category'); // kategori transaksi
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
        Schema::dropIfExists('withdrawals');
    }
};