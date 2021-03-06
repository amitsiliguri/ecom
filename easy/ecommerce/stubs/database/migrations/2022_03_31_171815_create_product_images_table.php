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
        Schema::create('product_images', static function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('type')->default('additional');
            $table->string('alt_name')->nullable();
            $table->foreignId('product_id')->references('id')->on('catalog_products')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        // TODO:: Convert to below one
//        Schema::create('product_images', static function (Blueprint $table) {
//            $table->id();
//            $table->string('thumbnail'); //thumbnail image path
//            $table->string('small'); //small image path
//            $table->string('image'); //large
//            $table->boolean('use_in_parent')->default(true);
//            $table->string('alt_name')->nullable();
//            $table->foreignId('product_id')->references('id')->on('catalog_products')->constrained()->onDelete('cascade');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
