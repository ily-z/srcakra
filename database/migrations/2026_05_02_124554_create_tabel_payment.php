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
            $table->id('id_payment');
            $table->foreignId('id_pendaftar')
                  ->constrained('tabel_pendaftar', 'id_pendaftar')
                  ->onDelete('cascade');
            $table->enum('payment_method', ['cash', 'dana', 'gopay', 'shopeepay']);
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->decimal('total', 15, 2)->default(0);
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
