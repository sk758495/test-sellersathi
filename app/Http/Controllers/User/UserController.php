<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\CarouselImage;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartValue;
use App\Models\Discount;
use App\Models\GujjuCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function dashboard()
    {
        // Fetch all active carousel images from the database
        $carouselImages = CarouselImage::where('status', 'active')->get();
    
        // Get the Gujju Categories (you don't need to eager load 'images' here)
        $gujju_category = GujjuCategory::take(12)->get();  // No need to use 'with()'
    
        $brands = Brand::latest()->take(6)->get();
        
        // Eager load 'images' relationship with brand categories
        $brand_categories = BrandCategory::with('images')->latest()->take(6)->get();
    
        // Get brand categories for each section (matching by name)
        $womensBrandCategories = BrandCategory::where('name', "Women's")->with('subcategories')->get();
        $mensBrandCategories = BrandCategory::where('name', "Men's")->with('subcategories')->get();
        $electronicsBrandCategories = BrandCategory::where('name', 'Electronics')->with('subcategories')->get();
        
        // Get first 4 subcategories for each category
        $womensSubcategories = $womensBrandCategories->flatMap->subcategories->take(4);
        $mensSubcategories = $mensBrandCategories->flatMap->subcategories->take(4);
        $electronicsSubcategories = $electronicsBrandCategories->flatMap->subcategories->take(4);
        
        // Fetch products grouped by subcategory for filtering
        $womensProductsBySubcategory = [];
        foreach($womensSubcategories as $subcategory) {
            $womensProductsBySubcategory[$subcategory->id] = Product::with('category', 'brand', 'brandCategory', 'subcategory')
                ->where('subcategory_id', $subcategory->id)->take(8)->get();
        }
        
        $mensProductsBySubcategory = [];
        foreach($mensSubcategories as $subcategory) {
            $mensProductsBySubcategory[$subcategory->id] = Product::with('category', 'brand', 'brandCategory', 'subcategory')
                ->where('subcategory_id', $subcategory->id)->take(8)->get();
        }
        
        $electronicsProductsBySubcategory = [];
        foreach($electronicsSubcategories as $subcategory) {
            $electronicsProductsBySubcategory[$subcategory->id] = Product::with('category', 'brand', 'brandCategory', 'subcategory')
                ->where('subcategory_id', $subcategory->id)->take(8)->get();
        }
        
        // Get products for first subcategory only (initial display)
        $womensProducts = $womensSubcategories->isNotEmpty() ? Product::with('category', 'brand', 'brandCategory', 'subcategory')
            ->where('subcategory_id', $womensSubcategories->first()->id)->take(8)->get() : collect();
            
        $mensProducts = $mensSubcategories->isNotEmpty() ? Product::with('category', 'brand', 'brandCategory', 'subcategory')
            ->where('subcategory_id', $mensSubcategories->first()->id)->take(8)->get() : collect();
            
        $electronicsProducts = $electronicsSubcategories->isNotEmpty() ? Product::with('category', 'brand', 'brandCategory', 'subcategory')
            ->where('subcategory_id', $electronicsSubcategories->first()->id)->take(8)->get() : collect();
    
        return view('user.dashboard', compact('brands', 'brand_categories', 'carouselImages', 'gujju_category', 'mensProducts', 'womensProducts', 'electronicsProducts', 'womensSubcategories', 'mensSubcategories', 'electronicsSubcategories', 'womensProductsBySubcategory', 'mensProductsBySubcategory', 'electronicsProductsBySubcategory'));
    }
    

    public function all_product_show_here()
    {
        $brands = Brand::take(6)->get();
         // Eager load 'images' relationship with brand categories
         $brand_categories = BrandCategory::with('images')->take(6)->get();
        // Fetch all products with their relationships (brand, category, subcategory)
        $products = Product::with('brand', 'brandCategory', 'subcategory')->get();

        return view('user.all_product_show_here',compact('products','brands', 'brand_categories'));
    }

    public function category_page()
    {
        // Fetch all brands
        $brands = Brand::all();

        // Eager load 'images' relationship with brand categories
        $brand_categories = BrandCategory::with('images')->get();

        // Fetch all products with their relationships (brand, category, subcategory)
        $products = Product::with('brand', 'brandCategory', 'subcategory')->get();

        return view('user.category_page', compact('products', 'brands', 'brand_categories'));
    }

    // In UserController.php
    public function showBrandCategory($brandId)
    {
        $brand_categories = BrandCategory::with('images')->latest()->take(6)->get();
        // Fetch brand categories based on the brand ID
        $brand = BrandCategory::where('brand_id', $brandId)->get(); // Get categories for the specific brand

        // Pass the data to the view
        return view('user.brand_category', compact('brand','brand_categories'));
    }

    public function gujju_category_products($categoryId)
    {
        $gujju_category = GujjuCategory::take(6)->get();
        $brands = Brand::all();
        $category = GujjuCategory::findOrFail($categoryId);
        $brand_categories = BrandCategory::all();
        // Get filter parameters from the request
        $minPrice = request('minPrice', 0);
        $maxPrice = request('maxPrice', 100000);
        $brandId = request('brand');
    
        // Start the query for products
        $productsQuery = Product::where('gujju_category_id', $categoryId);
    
        // Apply filters based on the request parameters
        if ($minPrice && $maxPrice) {
            $productsQuery->whereBetween('discount_price', [$minPrice, $maxPrice]);
        }
    
        if ($brandId) {
            $productsQuery->where('brand_id', $brandId);
        }
    
        // Fetch products with applied filters
        $products = $productsQuery->get();
    
        return view('user.gujju_category_products', compact('products', 'brands', 'category', 'gujju_category','brand_categories'));
    }

    public function category_products($categoryId)
    {
        $brands = Brand::all();

        $brand_categories = BrandCategory::all();
         // Fetch the category by ID
        $category = BrandCategory::findOrFail($categoryId);

        // Fetch all products under this category
        $products = Product::where('brand_category_id', $categoryId)->get();

        return view('user.category_products',compact('products','brands','brand_categories','category'));
    }


    public function view_product($id)
    {
        // Fetch the product by ID with its relationships
        $product = Product::with('brand', 'brandCategory', 'subcategory')->findOrFail($id);
    
        // Fetch related products based on the same brand or category (example logic)
        $relatedProducts = Product::with('brand', 'brandCategory', 'subcategory')
            ->where('brand_id', $product->brand_id) // You can also use category_id or other attributes
            ->where('id', '!=', $id)  // Exclude the current product
            ->take(6) // Limit the number of related products shown
            ->get();
    
        // Eager load 'images' relationship with brand categories
        $brand_categories = BrandCategory::with('images')->take(6)->get();
    
        // Return the view with the product and related products
        return view('user.single_product', compact('product', 'relatedProducts', 'brand_categories'));
    }
    
    public function add_cart($productId, $discountId = null)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Find the product based on the product ID
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found .');
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
        return redirect()->route('user.cart')->with('success', 'Product added to cart 🤩!');
    }


    public function view_cart()
    {
        $user = Auth::user();
        $carts = $user->carts()->with('product', 'product.discount')->get(); // Eager load product and discount

        // Fetch brand categories (for UI purposes, such as displaying in sidebar or sections)
        $brand_categories = BrandCategory::with('images')->take(6)->get();

        // If the cart is empty, redirect to dashboard with an error message
        if ($carts->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Your cart is empty 😰.');
        }

        // Calculate subtotal dynamically based on the cart's quantity and product's price (discounted if applicable)
        $subtotal = $carts->sum(function ($cart) {
            $product = $cart->product;

            // Default price is the product's discount price, if available
            $price = $product->discount_price;

            // If the product has a discount applied
            if ($cart->discount_id && $cart->discount) {
                $discount = $cart->discount; // Get the associated discount for the product
                if ($discount) {
                    // Calculate the discounted price based on the discount percentage
                    $price = $product->price - ($product->price * ($discount->discount_percentage / 100));
                }
            }

            // Calculate price * quantity
            return $price * $cart->quantity;
        });

        // Calculate shipping (for now, it's a flat fee of $10, you can change the logic as needed)
        $shipping = 10;

        // The total price is the subtotal plus shipping
        $total = $subtotal + $shipping;

        // Check if a CartValue entry already exists or create a new one
        $cartValue = CartValue::updateOrCreate(
            [
                'user_id' => $user->id,
                'cart_id' => $carts->first()->id // Assuming the first cart item is associated with the user (optional)
            ],
            [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total_price' => $total,
            ]
        );

        // Return the view with the updated cart data
        return view('user.cart', compact('carts', 'subtotal', 'shipping', 'total', 'brand_categories'));
    }



    public function updateCartQuantity(Request $request)
{
    try {
        // Validate the request data
        $validated = $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Retrieve the logged-in user
        $user = Auth::user();

        // Find the cart item by ID
        $cart = $user->carts()->find($request->cart_id);

        // Check if cart item exists
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found '], 404);
        }

        // Update the quantity of the cart item
        $cart->quantity = $request->quantity;
        $cart->save();

        // Calculate the new item total
        $itemTotal = $cart->product->discount_price * $cart->quantity;

        // Recalculate the subtotal for the updated cart
        $subtotal = $user->carts->sum(function ($cart) {
            return $cart->product->discount_price * $cart->quantity;
        });

        // Assuming a flat shipping fee of $10
        $shipping = 50;
        $total = $subtotal + $shipping;

        // Update the CartValue for the user
        CartValue::updateOrCreate(
            [
                'user_id' => $user->id,
                'cart_id' => $cart->id // You can use any cart item id or aggregate logic if needed
            ],
            [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total_price' => $total,
            ]
        );

        // Return the updated totals as a JSON response
        return response()->json([
            'item_total' => number_format($itemTotal, 2), // Format as money
            'subtotal' => number_format($subtotal, 2),   // Format as money
            'total' => number_format($total, 2),         // Format as money
        ]);

    } catch (\Exception $e) {
        // Log the exception and return a 500 error
        Log::error('Error updating cart: ' . $e->getMessage());
        return response()->json(['error' => 'Server error, please try again later'], 500);
    }
}



public function removeFromCart(Request $request)
{
    try {
        // Validate the request data
        $validated = $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        // Retrieve the logged-in user
        $user = Auth::user();

        // Find the cart item by ID
        $cart = $user->carts()->findOrFail($request->cart_id);

        // Delete the cart item
        $cart->delete();

        // Recalculate the subtotal and total after removal
        $subtotal = $user->carts->sum(function ($cart) {
            return $cart->product->discount_price * $cart->quantity;
        });

        $shipping = 10;
        $total = $subtotal + $shipping;

        // Return updated totals as a JSON response
        return response()->json([
            'subtotal' => number_format($subtotal, 2), // Format as money
            'total' => number_format($total, 2),       // Format as money
        ]);

    } catch (\Exception $e) {
        // Log the exception and return a 500 error
        Log::error('Error removing item from cart: ' . $e->getMessage());
        return response()->json(['error' => 'Server error, please try again later'], 500);
    }
}


// Payment Method





}







