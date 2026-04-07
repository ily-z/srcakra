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
         Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('reservation_id');

            $table->integer('total');
            $table->string('payment_method')->nullable();

            $table->string('status'); // pending, success, failed
            $table->string('provider')->nullable();
            $table->string('provider_ref')->nullable();

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
        Schema::dropIfExists('payments');
    }
};
