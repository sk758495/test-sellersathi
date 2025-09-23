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
        $carouselImages = CarouselImage::where('status', 'active')->get();
        $gujju_category = GujjuCategory::take(12)->get();
        $brands = Brand::latest()->take(6)->get();
        $brand_categories = BrandCategory::with('images')->latest()->take(6)->get();
        
        // Get products for each Gujju category
        $womensProducts = Product::where('gujju_category_id', $gujju_category->where('name', "Women's")->first()->id ?? 0)
                                ->with(['brandCategory', 'subcategory'])
                                ->take(8)
                                ->get();
        
        $mensProducts = Product::where('gujju_category_id', $gujju_category->where('name', "Men's")->first()->id ?? 0)
                              ->with(['brandCategory', 'subcategory'])
                              ->take(8)
                              ->get();
        
        $electronicsProducts = Product::where('gujju_category_id', $gujju_category->where('name', 'Electronics')->first()->id ?? 0)
                                     ->with(['brandCategory', 'subcategory'])
                                     ->take(8)
                                     ->get();
        
        // Get all subcategories that have products in each Gujju category
        $womensSubcategories = \App\Models\Subcategory::whereHas('products', function($query) use ($gujju_category) {
            $query->where('gujju_category_id', $gujju_category->where('name', "Women's")->first()->id ?? 0);
        })->get();
        
        $mensSubcategories = \App\Models\Subcategory::whereHas('products', function($query) use ($gujju_category) {
            $query->where('gujju_category_id', $gujju_category->where('name', "Men's")->first()->id ?? 0);
        })->get();
        
        $electronicsSubcategories = \App\Models\Subcategory::whereHas('products', function($query) use ($gujju_category) {
            $query->where('gujju_category_id', $gujju_category->where('name', 'Electronics')->first()->id ?? 0);
        })->get();
        
        return view('user.dashboard', compact('brands', 'brand_categories', 'carouselImages', 'gujju_category', 'mensProducts', 'womensProducts', 'electronicsProducts', 'womensSubcategories', 'mensSubcategories', 'electronicsSubcategories'));
    }
    

    public function all_product_show_here()
    {
        $brands = Brand::take(6)->get();
        $brand_categories = BrandCategory::with('images')->get();
        
        // Group products by brand category
        $productsByCategory = BrandCategory::with(['products' => function($query) {
            $query->with('brand', 'brandCategory', 'subcategory');
        }])->get()->filter(function($category) {
            return $category->products->count() > 0;
        });

        return view('user.all_product_show_here',compact('productsByCategory','brands', 'brand_categories'));
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
        $category = BrandCategory::with('subcategories')->findOrFail($categoryId);
        
        // If category has subcategories, show subcategories page
        if($category->subcategories->count() > 0) {
            // Load subcategories with their products
            $subcategoriesWithProducts = $category->subcategories->map(function($subcategory) {
                $subcategory->products = Product::where('subcategory_id', $subcategory->id)->take(4)->get();
                return $subcategory;
            });
            return view('user.category_subcategories', compact('category', 'subcategoriesWithProducts'));
        }
        
        // If no subcategories, show all products in this category directly
        $brands = Brand::all();
        $brand_categories = BrandCategory::all();
        $products = Product::where('brand_category_id', $categoryId)->get();
        
        return view('user.category_products', compact('products', 'brands', 'brand_categories', 'category'));
    }

    public function subcategory_products($subcategoryId)
    {
        $brands = Brand::all();
        $brand_categories = BrandCategory::all();
        
        // Fetch the subcategory by ID
        $subcategory = \App\Models\Subcategory::findOrFail($subcategoryId);
        
        // Fetch all products under this subcategory
        $products = Product::where('subcategory_id', $subcategoryId)->get();
        
        return view('user.subcategory_products', compact('products', 'brands', 'brand_categories', 'subcategory'));
    }

    public function collection()
    {
        // Get categories with their subcategories and sample products
        $collections = BrandCategory::with(['subcategories' => function($query) {
            $query->with(['products' => function($q) {
                $q->take(4);
            }]);
        }])->get()->filter(function($category) {
            return $category->subcategories->filter(function($subcategory) {
                return $subcategory->products->count() > 0;
            })->count() > 0;
        });
        
        // Get featured products for showcase
        $featuredProducts = Product::with('brand', 'brandCategory')->take(8)->get();
        
        return view('user.collection', compact('collections', 'featuredProducts'));
    }
    
    public function collection_products($type)
    {
        $products = collect();
        $title = '';
        
        switch($type) {
            case 'electronics':
                $products = Product::whereHas('brandCategory', function($q) {
                    $q->where('name', 'like', '%Electronics%');
                })->get();
                $title = 'Electronics & Gadgets';
                break;
            case 'fashion':
                $products = Product::whereHas('brandCategory', function($q) {
                    $q->where('name', 'like', '%Clothing%');
                })->get();
                $title = 'Fashion & Lifestyle';
                break;
            case 'home-lifestyle':
                $products = Product::whereHas('brandCategory', function($q) {
                    $q->where('name', 'like', '%Home%');
                })->get();
                $title = 'Home & Lifestyle';
                break;
            default:
                $products = Product::all();
                $title = 'All Products';
        }
        
        return view('user.collection_products', compact('products', 'title', 'type'));
    }

    public function filterProducts(Request $request)
    {
        $gujjuCategory = $request->get('gujju_category');
        $subcategoryId = $request->get('subcategory');
        
        $gujju_categories = GujjuCategory::all();
        $categoryId = null;
        
        switch($gujjuCategory) {
            case 'womens':
                $categoryId = $gujju_categories->where('name', "Women's")->first()->id ?? 0;
                break;
            case 'mens':
                $categoryId = $gujju_categories->where('name', "Men's")->first()->id ?? 0;
                break;
            case 'electronics':
                $categoryId = $gujju_categories->where('name', 'Electronics')->first()->id ?? 0;
                break;
        }
        
        $products = Product::where('gujju_category_id', $categoryId)
                          ->where('subcategory_id', $subcategoryId)
                          ->with(['brandCategory', 'subcategory'])
                          ->get();
        
        return response()->json(['products' => $products]);
    }

    public function dynamicFilter(Request $request)
    {
        $query = Product::with('brand', 'brandCategory', 'subcategory');
        
        if ($request->category_id) {
            $query->where('brand_category_id', $request->category_id);
        }
        
        if ($request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }
        
        if ($request->min_price) {
            $query->where('discount_price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('discount_price', '<=', $request->max_price);
        }
        
        if ($request->color) {
            $query->where('color_name', 'like', '%' . $request->color . '%');
        }
        
        $products = $query->get();
        
        $productsByCategory = $products->groupBy('brand_category_id')->map(function($products, $categoryId) {
            $category = BrandCategory::find($categoryId);
            return (object) [
                'id' => $categoryId,
                'name' => $category ? $category->name : 'Unknown',
                'products' => $products
            ];
        });
        
        return response()->json([
            'success' => true,
            'productsByCategory' => $productsByCategory,
            'totalProducts' => $products->count()
        ]);
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('query');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $products = Product::where('product_name', 'LIKE', '%' . $query . '%')
                          ->with('brandCategory')
                          ->take(8)
                          ->get(['id', 'product_name', 'main_image', 'discount_price', 'brand_category_id']);
        
        return response()->json($products);
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
public function placeOrder(Request $request)
{
    // Get address from session (selected in PaymentController)
    $selectedAddress = session('selected_address');
    if ($selectedAddress) {
        session(['order_address_id' => $selectedAddress->id]);
    } elseif ($request->address_id) {
        session(['order_address_id' => $request->address_id]);
    }
    
    // If payment method is HDFC, redirect to payment gateway
    if ($request->payment_method === 'hdfc') {
        return $this->initiateHdfcPayment($request);
    }
    
    return redirect()->back()->with('error', 'Payment method not supported');
}

public function initiateHdfcPayment(Request $request)
{
    $user = Auth::user();
    $cartValue = CartValue::where('user_id', $user->id)->first();
    
    if (!$cartValue) {
        return redirect()->back()->with('error', 'Cart not found.');
    }
    
    $orderId = "order_" . $user->id . "_" . time();
    $customerId = "customer_" . $user->id;
    
    // Store order data in session for callback
    session([
        'pending_order' => [
            'payment_method' => 'hdfc',
            'total_amount' => $cartValue->total_price,
            'order_id' => $orderId
        ]
    ]);
    
    $data = [
        "order_id" => $orderId,
        "amount" => number_format($cartValue->total_price, 1, '.', ''),
        "currency" => "INR",
        "customer_id" => $customerId,
        "customer_email" => $user->email,
        "customer_phone" => $user->phone ?? "9876543210",
        "payment_page_client_id" => "hdfcmaster",
        "action" => "paymentPage",
        "return_url" => route('hdfc.user.callback'),
        "description" => "Complete your payment",
        "first_name" => $user->name ?? "Customer",
        "last_name" => ""
    ];
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://smartgatewayuat.hdfcbank.com/session',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'x-merchantid: SG3589',
            'x-customerid: ' . $customerId,
            'Content-Type: application/JSON',
            'version: 2023-06-30',
            'Authorization: Basic RUMyODVFNzc5MkY0Mzk1QkVCRjAyNkQyQjQ4OTkxOg=='
        ]
    ]);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        if (isset($result['payment_links']['web'])) {
            header("Location: " . $result['payment_links']['web']);
            exit;
        }
    }
    
    return redirect()->back()->with('error', 'Payment initiation failed: ' . $response);
}

public function handlePaymentCallback(Request $request)
{
    if (isset($_POST["order_id"])) {
        $params = $_POST;
    } else if (isset($_GET["order_id"])) {
        $params = $_GET;
    } else {
        return redirect()->route('dashboard')->with('error', 'Invalid payment response.');
    }
    
    $orderId = $params["order_id"];
    
    // Get order status using exact API format
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://smartgatewayuat.hdfcbank.com/orders/' . $orderId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPGET => true,
        CURLOPT_HTTPHEADER => [
            'x-merchantid: SG3589',
            'x-customerid: 325345',
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic RUMyODVFNzc5MkY0Mzk1QkVCRjAyNkQyQjQ4OTkxOg=='
        ]
    ]);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($httpCode === 200) {
        $order = json_decode($response, true);
        
        // If payment successful, create order and clear cart
        if ($order["status"] === "CHARGED") {
            // Extract user ID from order ID (format: order_userId_timestamp)
            $orderParts = explode('_', $orderId);
            $userId = isset($orderParts[1]) ? $orderParts[1] : null;
            
            if ($userId) {
                $carts = Cart::where('user_id', $userId)->with('product')->get();
                $addressId = session('order_address_id');
                
                // Create orders for each cart item
                foreach ($carts as $cart) {
                    \App\Models\Order::create([
                        'user_id' => $userId,
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity,
                        'total_price' => $cart->product->discount_price * $cart->quantity,
                        'payment_method' => 'hdfc',
                        'order_status' => 'Confirmed',
                        'order_id' => $orderId,
                        'transaction_id' => $order['transaction_id'] ?? null,
                        'address_id' => $addressId
                    ]);
                }
                
                // Clear cart and session after creating orders
                Cart::where('user_id', $userId)->delete();
                CartValue::where('user_id', $userId)->delete();
                session()->forget('order_address_id');
            }
            session()->forget('pending_order');
        }
        
        if ($order["status"] === "CHARGED") {
            return view('user.payment-success', compact('order'));
        } else {
            return redirect()->route('dashboard')->with('error', 'Payment failed: ' . ($order['status'] ?? 'Unknown error'));
        }
    }
    
    return redirect()->route('dashboard')->with('error', 'Payment verification failed: ' . $response);
}

private function getPaymentStatusMessage($order)
{
    $message = "Your order with order_id " . $order["order_id"] . " and amount " . $order["amount"] . " has the following status: ";
    $status = $order["status"];

    switch ($status) {
        case "CHARGED":
            return $message . "order payment done successfully";
        case "PENDING":
        case "PENDING_VBV":
            return $message . "order payment pending";
        case "AUTHORIZATION_FAILED":
            return $message . "order payment authorization failed";
        case "AUTHENTICATION_FAILED":
            return $message . "order payment authentication failed";
        default:
            return $message . "order status " . $status;
    }
}

}







