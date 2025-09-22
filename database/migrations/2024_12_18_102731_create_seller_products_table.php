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
        Schema::create('seller_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_admin_id');
            $table->unsignedBigInteger('admin_product_id'); // Reference to Admin's Product
            $table->string('sku');
            $table->string('product_name');
            $table->string('color_name');
            $table->string('color_code');
            $table->integer('quantity');
            $table->string('lead_time');
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('short_description');
            $table->text('long_description');
            $table->text('features');
            $table->text('whats_included');
            $table->string('main_image');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('seller_admin_id')->references('id')->on('seller_admins')->onDelete('cascade');
            $table->foreign('admin_product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_products');
    }
};
