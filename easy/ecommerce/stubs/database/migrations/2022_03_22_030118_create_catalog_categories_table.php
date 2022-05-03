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
        Schema::create('catalog_categories',  static function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->string('title', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('banner', 191)->nullable();
            $table->string('meta_title', 100)->nullable();
            $table->string('meta_description', 170)->nullable();
            $table->string('meta_image', 191)->nullable();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->integer('sort_order')->nullable();
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
        Schema::dropIfExists('catalog_categories');
    }
};
