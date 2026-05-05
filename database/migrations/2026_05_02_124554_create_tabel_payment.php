<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tabel_payment', function (Blueprint $table) {
            // 1. Primary Key
            $table->id('id_payment');

            // 2. Foreign Key
            // Menggunakan foreignId agar otomatis bertipe BIGINT UNSIGNED (sinkron dengan tabel pendaftar)
            $table->foreignId('id_pendaftar')
                  ->constrained('tabel_pendaftar', 'id_pendaftar')
                  ->onDelete('cascade');

            // 3. Detail Pembayaran
            $table->string('payment_method'); // Contoh: 'cash' atau 'midtrans'
            $table->string('status')->default('pending'); // Contoh: 'pending', 'success', 'expired'
            $table->decimal('total', 15, 2)->default(0); // Gunakan decimal untuk nilai mata uang
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_payment');
    }
};
