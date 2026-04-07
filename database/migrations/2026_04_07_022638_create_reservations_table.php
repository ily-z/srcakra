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
       Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Data pengunjung
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->text('alamat')->nullable();

            // Detail kunjungan
            $table->date('tanggal');
            $table->uuid('slot_id');

            $table->integer('jumlah_kunjungan');
            $table->text('tujuan')->nullable();

            // File surat
            $table->string('surat_pengajuan')->nullable();

            // Status
            $table->enum('status', [
                'PENDING',
                'PAID',
                'CONFIRMED',
                'CHECKED_IN',
                'CANCELLED',
                'EXPIRED'
            ])->default('PENDING');

            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            // FK
            $table->foreign('slot_id')
                  ->references('id')
                  ->on('slots')
                  ->cascadeOnDelete();

            // Index
            $table->index(['slot_id', 'tanggal']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
