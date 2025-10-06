<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Since the columns were already removed, we'll just ensure the structure is correct
        // This migration is mainly for future reference and rollback capability
        
        // Check if there are any orders without order items
        $ordersWithoutItems = DB::table('orders')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->whereNull('order_items.order_id')
            ->select('orders.*')
            ->get();
            
        // For orders without items, we can't recreate the items since product_id is gone
        // This is expected for the new structure
        
        // Ensure columns are removed if they still exist
        if (Schema::hasColumn('orders', 'product_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            });
        }

        if (Schema::hasColumn('orders', 'quantity')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }
    }

    public function down()
    {
        // Add back the columns
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
        });

        // Move data back from order_items to orders (only for orders with single item)
        $orderItems = DB::table('order_items')
            ->select('order_id', DB::raw('COUNT(*) as item_count'), DB::raw('MIN(product_id) as product_id'), DB::raw('MIN(quantity) as quantity'))
            ->groupBy('order_id')
            ->having('item_count', '=', 1)
            ->get();

        foreach ($orderItems as $item) {
            DB::table('orders')
                ->where('id', $item->order_id)
                ->update([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ]);
        }
    }
};