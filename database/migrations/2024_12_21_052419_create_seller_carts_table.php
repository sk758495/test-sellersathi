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
        Schema::create('seller_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('seller_admin_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->string('color_name');
            $table->string('color_code');
            $table->unsignedInteger('quantity')->default(1); // Default quantity is 1
            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_admin_id')->references('id')->on('seller_admins')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('seller_products')->onUpdate('cascade');

            // Ensure uniqueness of the combination
            $table->unique(['user_id', 'product_id', 'seller_admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_carts');
    }
};
