<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extras', function (Blueprint $table) {
            $table->id();
            $table->foreign('product_id');
            $table->string('name');
            $table->string('value');
            $table->timestamps();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('no action')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extras');
    }
};
