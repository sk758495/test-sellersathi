<?php

namespace App\Http\Controllers\Admin\Discount;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    public function show_add_discount(){
        $products = Product::all();
        return view('admin.discount_page.add-discount', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|integer|min:0|max:100',
            'discounted_price' => 'required|numeric|min:0',
        ]);

        Discount::create([
            'product_id' => $request->product_id,
            'discount_percentage' => $request->discount_percentage,
            'discounted_price' => $request->discounted_price,
        ]);

        return redirect()->back()->with('success', 'Discount added successfully!');
    }

    public function index()
    {
        $discounts = Discount::with('product')->get();
        return view('admin.discount_page.discount_page', compact('discounts'));
    }

    public function destroy($id)
    {
        // Find the discount by its ID
        $discount = Discount::findOrFail($id);

        // Delete the discount
        $discount->delete();

        // Redirect back with a success message
        return redirect()->route('dashboard.discounts')->with('success', 'Your Discount Added Product Deleted Successfully!');
    }

    // //for user
    // public function getDiscountedProducts($discountPercentage)
    // {
    //     // Fetch the discounts with the associated products
    //     $discounts = Discount::where('discount_percentage', $discountPercentage)
    //         ->with('product') // Fetch related product details
    //         ->get();

    //     // Iterate over the discounts to calculate the discounted price and discount amount
    //     foreach ($discounts as $discount) {
    //         // Get the original price of the product
    //         $originalPrice = $discount->product->price;

    //         // Calculate the discount amount
    //         $discountAmount = ($discountPercentage / 100) * $originalPrice;

    //         // Calculate the discounted price
    //         $calculatedDiscountedPrice = $originalPrice - $discountAmount;

    //         // Add the calculated values to the discount object
    //         $discount->discountAmount = $discountAmount; // Store discount amount
    //         $discount->calculated_discounted_price = $calculatedDiscountedPrice; // Store discounted price
    //     }

    //     // Return the view with the data
    //     return view('user.discount.show_discount', compact('discounts', 'discountPercentage'));
    // }




}

