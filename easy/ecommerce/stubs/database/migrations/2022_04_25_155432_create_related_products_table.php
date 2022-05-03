<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('related_products', static function (Blueprint $table) {
            $table->foreignId('main_product_id')->references('id')->on('catalog_products')->constrained()->onDelete('cascade');
            $table->foreignId('related_product_id')->references('id')->on('catalog_products')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('related_products');
    }
};
