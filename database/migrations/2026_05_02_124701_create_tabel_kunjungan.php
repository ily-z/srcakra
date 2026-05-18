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
            $table->date('tanggal_daftar');
            $table->date('tanggal_kunjungan');
            $table->string('nama')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->string('email');
            $table->text('tujuan_kunjungan');
            $table->string('surat_pengajuan')->nullable();
            $table->integer('jumlah_pengunjung')->default(1);
            $table->string('payment_method');
            $table->foreignId('id_payment')->constrained('tabel_payment', 'id_payment');
            $table->enum('status_kunjungan', ['waiting', 'completed'])->default('waiting');
            $table->string('qr_token')->unique();
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
