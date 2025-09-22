<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brand_category_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_category_id')->constrained()->onDelete('cascade'); // Foreign key to brand_categories
            $table->string('image'); // Store the image file path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_category_images');
    }
};
