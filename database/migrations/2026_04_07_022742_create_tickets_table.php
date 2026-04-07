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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('reservation_id');

            $table->string('qr_code')->unique();
            $table->boolean('is_used')->default(false);

            $table->timestamp('used_at')->nullable();

            $table->timestamps();

            $table->foreign('reservation_id')
                  ->references('id')
                  ->on('reservations')
                  ->cascadeOnDelete();

            $table->index('reservation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
