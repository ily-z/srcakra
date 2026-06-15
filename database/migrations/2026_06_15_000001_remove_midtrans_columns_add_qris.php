<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE tabel_payment MODIFY COLUMN payment_method ENUM('cash', 'dana', 'gopay', 'shopeepay', 'midtrans', 'qris') NOT NULL DEFAULT 'cash'");

        DB::statement("UPDATE tabel_payment SET payment_method = 'qris' WHERE payment_method = 'midtrans'");

        DB::statement("ALTER TABLE tabel_payment MODIFY COLUMN payment_method ENUM('cash', 'qris') NOT NULL DEFAULT 'cash'");

        Schema::table('tabel_payment', function (Blueprint $table) {
            $table->dropColumn(['midtrans_transaction_id', 'midtrans_redirect_url', 'midtrans_order_id']);
        });
    }

    public function down(): void
    {
        Schema::table('tabel_payment', function (Blueprint $table) {
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_redirect_url')->nullable();
            $table->string('midtrans_order_id')->nullable();
        });

        DB::statement("ALTER TABLE tabel_payment MODIFY COLUMN payment_method ENUM('cash', 'dana', 'gopay', 'shopeepay', 'midtrans') NOT NULL DEFAULT 'cash'");
    }
};
