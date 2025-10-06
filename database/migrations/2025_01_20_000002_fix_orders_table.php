<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;

return new class extends Migration
{
    public function up()
    {
        // Check if columns exist before adding them
        if (!Schema::hasColumn('orders', 'subtotal')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('subtotal', 10, 2)->default(0)->after('total_price');
            });
        }
        
        if (!Schema::hasColumn('orders', 'shipping_charge')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('shipping_charge', 10, 2)->default(50)->after('subtotal');
            });
        }
        
        if (!Schema::hasColumn('orders', 'order_number')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_number')->nullable()->after('id');
            });
        }
        
        // Update existing orders with order numbers and calculate subtotal
        $orders = Order::all();
        foreach ($orders as $order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . date('Ymd', strtotime($order->created_at)) . '-' . strtoupper(substr(uniqid(), -6));
            }
            if ($order->subtotal == 0) {
                $order->subtotal = max(0, $order->total_price - 50);
            }
            if ($order->shipping_charge == 0) {
                $order->shipping_charge = 50;
            }
            $order->save();
        }
        
        // Make order_number unique
        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_number')->nullable(false)->unique()->change();
            });
        } catch (Exception $e) {
            // Ignore if unique constraint already exists
        }
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
            if (Schema::hasColumn('orders', 'shipping_charge')) {
                $table->dropColumn('shipping_charge');
            }
            if (Schema::hasColumn('orders', 'order_number')) {
                $table->dropColumn('order_number');
            }
        });
    }
};