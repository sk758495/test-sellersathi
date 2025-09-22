<?php

namespace App\Http\Controllers\SellerUser;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SellerAdmin;
use App\Models\SellerCart;
use App\Models\SellerProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerUserProductController extends Controller
{
    public function showDashboard($sellerAdminId)
    {
        // Fetch the SellerAdmin by the given ID
        $sellerAdmin = SellerAdmin::findOrFail($sellerAdminId);

        // Fetch all products for the given SellerAdmin (assuming products are related to SellerAdmin through SellerProduct)
        $products = $sellerAdmin->products()->get();  // Adjust this based on your relationship model

        // Return the dashboard view with products
        return view('seller-user.dashboard', [
            'products' => $products,
            'sellerAdminId' => $sellerAdminId,
            'sellerAdminName' => $sellerAdmin->name, // Assuming 'name' is the field that holds the admin's name
        ]);
    }


    // Show details of a single product for a specific seller
    public function showProductDetails($sellerAdminId, $productId)
    {
        // Fetch the SellerAdmin
        $sellerAdmin = SellerAdmin::findOrFail($sellerAdminId);

        // Fetch the product based on productId and ensure it belongs to the given SellerAdmin
        $product = SellerProduct::where('id', $productId)
            ->where('seller_admin_id', $sellerAdminId)
            ->firstOrFail();

         // Get the count of distinct products in the cart for the logged-in user
        $cartProductCount = SellerCart::where('user_id', Auth::id())
        ->where('seller_admin_id', $sellerAdminId)
        ->distinct('product_id')
        ->count();

        // Return the product details view
        return view('seller-user.single_product', [
            'product' => $product,
            'sellerAdminId' => $sellerAdminId,'cartProductCount' => $cartProductCount,
        ]);
    }

}
