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
        Schema::create('stocks', static function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('reserved_quantity')->default(0);
            $table->foreignId('product_id')->references('id')->on('catalog_products')->constrained()->onDelete('cascade');
            $table->foreignId('inventory_id')->references('id')->on('inventories')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
