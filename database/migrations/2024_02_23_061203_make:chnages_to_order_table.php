<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_address');
            $table->string('shipping_phone');
            $table->string('payment_ref')->nullable(true)->change();
            $table->string('receipt_url')->nullable(true)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_address');
            $table->dropColumn('shipping_phone');
            $table->string('payment_ref')->nullable(false)->change();
            $table->string('receipt_url')->nullable(false)->change();
        });
    }
};
