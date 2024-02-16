<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('discounted')->default(false);
            $table->smallInteger('duration')->default(0);
            $table->smallInteger('percentage')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('discounted');
            $table->dropColumn('duration');
            $table->dropColumn('percentage');
        });
    }
};
