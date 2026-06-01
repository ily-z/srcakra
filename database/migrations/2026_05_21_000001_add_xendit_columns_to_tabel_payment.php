<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tabel_payment', function (Blueprint $table) {
            $table->string('xendit_invoice_id')->nullable()->after('total');
            $table->string('xendit_invoice_url')->nullable()->after('xendit_invoice_id');
            $table->string('xendit_external_id')->nullable()->after('xendit_invoice_url');
        });

        DB::statement("ALTER TABLE tabel_payment MODIFY COLUMN payment_method ENUM('cash', 'dana', 'gopay', 'shopeepay', 'xendit') NOT NULL DEFAULT 'cash'");
    }

    public function down(): void
    {
        Schema::table('tabel_payment', function (Blueprint $table) {
            $table->dropColumn(['xendit_invoice_id', 'xendit_invoice_url', 'xendit_external_id']);
        });

        DB::statement("ALTER TABLE tabel_payment MODIFY COLUMN payment_method ENUM('cash', 'dana', 'gopay', 'shopeepay') NOT NULL DEFAULT 'cash'");
    }
};
