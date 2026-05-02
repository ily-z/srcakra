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
        Schema::create('tabel_kunjungan', function (Blueprint $table) {
            $table->id('id_pengunjung');
            $table->date('tanggal_kunjungan');
            $table->string('nama_display'); // Gabungan nama atau instansi
            $table->string('email');
            $table->integer('jumlah_pengunjung');
            $table->string('payment_method');
            $table->foreignId('id_payment')->constrained('tabel_payments', 'id_payment');
            $table->enum('status_kunjungan', ['waiting', 'checked_in'])->default('waiting');
            $table->string('qr_token text')->unique(); // Token unik untuk QR
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_kunjungan');
    }
};
