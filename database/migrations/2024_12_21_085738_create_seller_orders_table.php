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
        if (!Schema::hasTable('seller_orders')) {
        Schema::create('seller_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // User (buyer)
            $table->foreignId('seller_admin_id')->constrained()->onDelete('cascade'); // Seller
            $table->foreignId('address_id')->constrained()->onDelete('cascade'); // Shipping Address
            $table->unsignedBigInteger('product_id'); // Add the product_id column (no need for `after()` here)
            $table->foreign('product_id')->references('id')->on('seller_products')->onDelete('cascade');  // Foreign key to products table
            $table->integer('quantity');  // Quantity of product ordered
            $table->string('payment_method'); // 'COD', 'UPI', etc.
            $table->decimal('total_price', 10, 2); // Total price of the order
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending'); // Order status
            $table->boolean('email_sent')->default(false);
            $table->timestamps();
        });
    }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_orders');
    }
};
