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
        Schema::table('products', function (Blueprint $table) {
        // Add the foreign key column for 'gujju_categories' and allow NULL values
        $table->foreignId('gujju_category_id')
        ->nullable() // Allow NULL for products without a category
        ->constrained('gujju_categories')
        ->onDelete('cascade');
     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key and column if the migration is rolled back
            $table->dropForeign(['gujju_category_id']);
            $table->dropColumn('gujju_category_id');
        });
    }
};
