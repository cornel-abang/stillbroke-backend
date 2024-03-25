<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('cart_items', 'color'))
        {
            Schema::table('cart_items', function (Blueprint $table)
            {
                $table->dropColumn('color');
            });
        }

        if (Schema::hasColumn('cart_items', 'size'))
        {
            Schema::table('cart_items', function (Blueprint $table)
            {
                $table->dropColumn('size');
            });
        }

        Schema::table('cart_items', function (Blueprint $table) {
            $table->string('extra_ids')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('extra_ids');
        });
    }
};
