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
        Schema::create('tabel_pendaftar', function (Blueprint $table) {
           $table->id('id_pendaftar');
            $table->enum('jenis_pendaftar', ['personal', 'instansi']);
            $table->date('tanggal_daftar');
            $table->date('tanggal_kunjungan');
            $table->string('nama')->nullable(); // null jika instansi
            $table->string('nama_instansi')->nullable(); // null jika personal
            $table->text('alamat');
            $table->string('email');
            $table->string('metode_pembayaran');
            $table->text('tujuan_kunjungan');
            $table->string('surat_pengajuan')->nullable();
            $table->integer('jumlah_pengunjung')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_pendaftar');
    }
};
