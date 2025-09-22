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
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_id')->nullable();  // Add the discount_id column
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');  // Foreign key relationship with discounts table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
             // Drop the foreign key first, then the column
             $table->dropForeign(['discount_id']);
             $table->dropColumn('discount_id');
        });
    }
};
