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
        Schema::create('product_price', static function (Blueprint $table) {
            $table->id();
            $table->double('special_price', 8, 4)->nullable()->default(0000.0000);
            $table->double('base_price', 8, 4)->default(0000.0000);
            $table->date('offer_start')->nullable();
            $table->date('offer_end')->nullable();
            $table->foreignId('product_id')->references('id')->on('catalog_products')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('product_price');
    }
};
