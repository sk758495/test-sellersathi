<?php

namespace App\Http\Controllers\User\Discount;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDiscountController extends Controller
{

    public function categoryofdiscount()
    {
        $brands = Brand::all();
        $brand_categories = BrandCategory::all();
        $subcategories = Subcategory::all();
        return view('user.discount.discount_category', compact('brands','brand_categories','subcategories'));
    }

        //for user
        public function getDiscountedProducts($discountPercentage)
        {
            // Fetch the discounts with the associated products
            $discounts = Discount::where('discount_percentage', $discountPercentage)
                ->with('product') // Fetch related product details
                ->get();


            $brand_categories = BrandCategory::all();
            // Iterate over the discounts to calculate the discounted price and discount amount
            foreach ($discounts as $discount) {
                // Get the original price of the product
                $originalPrice = $discount->product->price;

                // Calculate the discount amount
                $discountAmount = ($discountPercentage / 100) * $originalPrice;

                // Calculate the discounted price
                $calculatedDiscountedPrice = $originalPrice - $discountAmount;

                // Add the calculated values to the discount object
                $discount->discountAmount = $discountAmount; // Store discount amount
                $discount->calculated_discounted_price = $calculatedDiscountedPrice; // Store discounted price
            }

            // Return the view with the data
            return view('user.discount.show_discount', compact('discounts', 'discountPercentage','brand_categories'));
        }

       public function view_discount_product($id)
{
    // Fetch the discount along with the product, brand, brandCategory, and subcategory relationships
    $discount = Discount::with('product', 'product.brand', 'product.brandCategory', 'product.subcategory')
        ->findOrFail($id); // Fetch the discount by ID

    // Get the original price of the product
    $originalPrice = $discount->product->price;

    // Calculate the discount amount
    $discountAmount = ($discount->discount_percentage / 100) * $originalPrice;

    // Calculate the discounted price
    $calculatedDiscountedPrice = $originalPrice - $discountAmount;

    // Add the calculated values to the discount object
    $discount->discountAmount = $discountAmount;
    $discount->calculated_discounted_price = $calculatedDiscountedPrice;

    // Fetch all brand categories (for dropdowns or related data)
    $brand_categories = BrandCategory::all();

    // Return the view with the product and calculated values
    return view('user.discount.discounted_single_product', compact('discount', 'brand_categories'));
}

public function add_cart($productId, $discountId = null)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Find the product based on the product ID
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // If discount ID is provided, add the discount to the cart
        if ($discountId) {
            // Find the discount using the discount ID
            $discount = Discount::find($discountId);
            if (!$discount) {
                return redirect()->back()->with('error', 'Discount not found.');
            }

            // Save the product and discount in the cart
            $cart = Cart::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $productId,
                ],
                [
                    'discount_id' => $discountId, // Save the discount ID
                    'quantity' => 1, // Default quantity is 1
                ]
            );
        } else {
            // If no discount ID, just add the product to the cart without discount
            $cart = Cart::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $productId,
                ],
                [
                    'quantity' => 1, // Default quantity is 1
                ]
            );
        }

        // Redirect back to the cart with a success message
        return redirect()->route('user.cart')->with('success', 'Product added to cart!');
    }

}
