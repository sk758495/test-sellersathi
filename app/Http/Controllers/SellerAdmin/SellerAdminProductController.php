<?php

namespace App\Http\Controllers\SellerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SellerAdmin;
use App\Models\SellerProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerAdminProductController extends Controller
{

    public function showAdminProducts($sellerAdminId)
    {
        // Get the logged-in seller admin's ID
        $loggedInSellerAdminId = Auth::guard('seller-admin')->user()->id;

        // Check if the logged-in user is trying to access their own data
        if ($loggedInSellerAdminId !== (int) $sellerAdminId) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Fetch all Admin products
        $adminProducts = Product::all();

        // Check if the product is already added to the seller's store
        $addedProductIds = SellerProduct::where('seller_admin_id', $sellerAdminId)
                                         ->pluck('admin_product_id')->toArray();

        // Pass the Admin products and added product IDs to the view
        return view('seller-admin.products.select-admin-product', compact('adminProducts', 'sellerAdminId', 'addedProductIds'));
    }


public function addProductToSellerStore($adminProductId, $sellerAdminId)
{
    // Fetch Admin's product
    $adminProduct = Product::findOrFail($adminProductId);

    // Generate a unique SKU for the SellerAdmin's product
    $sellerAdmin = SellerAdmin::findOrFail($sellerAdminId);
    $uniqueSku = $adminProduct->sku . '-' . $sellerAdmin->id;

    // Create the Seller's Product
    $sellerProduct = SellerProduct::create([
        'seller_admin_id' => $sellerAdmin->id,
        'admin_product_id' => $adminProduct->id,
        'sku' => $uniqueSku,
        'product_name' => $adminProduct->product_name,
        'color_name' => $adminProduct->color_name, // Correct field from admin product
        'color_code' => $adminProduct->color_code, // Correct field from admin product
        'quantity' => 100, // default quantity, can be modified
        'lead_time' => $adminProduct->lead_time, // Correct field from admin product
        'price' => $adminProduct->price, // default price, can be modified
        'cost_price' => $adminProduct->cost_price, // Correct field from admin product
        'discount_price' => $adminProduct->discount_price, // Correct field from admin product
        'brand_id' => $adminProduct->brand_id, // Correct field from admin product
        'brand_category_id' => $adminProduct->brand_category_id, // Correct field from admin product
        'subcategory_id' => $adminProduct->subcategory_id, // Correct field from admin product
        'short_description' => $adminProduct->short_description,
        'long_description' => $adminProduct->long_description,
        'features' => $adminProduct->features, // Correct field from admin product
        'whats_included' => $adminProduct->whats_included, // Correct field from admin product
        'main_image' => $adminProduct->main_image,
    ]);

    // Redirect to the seller's product page with the sellerAdminId
    return redirect()->route('seller-admin.dashboard', ['sellerAdminId' => $sellerAdminId])
                     ->with('success', 'Product added successfully.');
}

// Controller Method to Update Discount Price
public function updateDiscountPrice(Request $request, $productId)
{
    // Validate the input
    $request->validate([
        'price' => 'required|numeric|min:0',  // Make sure it's a positive number
    ]);

    // Find the product by ID
    $product = SellerProduct::findOrFail($productId);

    // Ensure the price is not lower than the cost price
    if ($request->price < $product->cost_price) {
        return redirect()->back()->with('error', 'price cannot be less than the cost price.');
    }

    // Update the discount price
    $product->price = $request->price;
    $product->save();

    // Redirect back with success message
    return redirect()->route('seller-admin.dashboard', ['sellerAdminId' => $product->seller_admin_id])
                     ->with('success', 'Discount price updated successfully.');
}

public function deleteProduct($productId)
{
    // Find the SellerProduct to delete
    $product = SellerProduct::findOrFail($productId);

    // Delete the product
    $product->delete();

    // Redirect back with success message
    return redirect()->route('seller-admin.dashboard', ['sellerAdminId' => $product->seller_admin_id])
                     ->with('success', 'Product deleted successfully.');
}


}
