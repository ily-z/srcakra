<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tabel_payment', function (Blueprint $table) {
            $table->renameColumn('xendit_invoice_id', 'midtrans_transaction_id');
            $table->renameColumn('xendit_invoice_url', 'midtrans_redirect_url');
            $table->renameColumn('xendit_external_id', 'midtrans_order_id');
        });

        DB::statement("UPDATE tabel_payment SET payment_method = 'midtrans' WHERE payment_method = 'xendit'");
        DB::statement("ALTER TABLE tabel_payment MODIFY COLUMN payment_method ENUM('cash', 'dana', 'gopay', 'shopeepay', 'midtrans') NOT NULL DEFAULT 'cash'");
    }

    public function down(): void
    {
        Schema::table('tabel_payment', function (Blueprint $table) {
            $table->renameColumn('midtrans_transaction_id', 'xendit_invoice_id');
            $table->renameColumn('midtrans_redirect_url', 'xendit_invoice_url');
            $table->renameColumn('midtrans_order_id', 'xendit_external_id');
        });

        DB::statement("ALTER TABLE tabel_payment MODIFY COLUMN payment_method ENUM('cash', 'dana', 'gopay', 'shopeepay', 'xendit') NOT NULL DEFAULT 'cash'");
    }
};
