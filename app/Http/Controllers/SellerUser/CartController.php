<?php

namespace App\Http\Controllers\SellerUser;

use App\Http\Controllers\Controller;
use App\Mail\AdminNewOrderNotification;
use App\Mail\OrderPlaced;
use App\Mail\SellerUserOrderPlaced;
use App\Models\Address;
use App\Models\SellerAdmin;
use App\Models\SellerCart;
use App\Models\SellerCartValue;
use App\Models\SellerOrder;
use App\Models\SellerProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    // Add product to the cart
    public function addToCart($sellerAdminId, $productId, Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            // Redirect the user to the login page if not authenticated
            return redirect()->route('login')->with('error', 'You need to login first.');
        }

        // Default quantity is 1 if no quantity is provided
        $quantity = $request->input('quantity', 1);

        // Ensure the product belongs to the specified SellerAdmin
        $product = SellerProduct::where('id', $productId)
            ->where('seller_admin_id', $sellerAdminId)
            ->firstOrFail();

        // Check if the cart for this seller already exists for this user
        $cart = SellerCart::where('user_id', Auth::id())
            ->where('seller_admin_id', $sellerAdminId)
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            // If the product already exists in the cart, just update the quantity
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            // Otherwise, create a new cart item with all details
            SellerCart::create([
                'user_id' => Auth::id(),  // Ensure user_id is correctly set
                'seller_admin_id' => $sellerAdminId,
                'product_id' => $productId,
                'product_name' => $product->product_name,
                'color_name' => $product->color_name,
                'color_code' => $product->color_code,
                'quantity' => $quantity,
                'price' => $product->price, // Assuming price is stored in SellerProduct
            ]);
        }

        return redirect()->route('seller.cart.view', ['sellerAdminId' => $sellerAdminId])
            ->with('success', 'Product added to cart successfully!');
    }

    // View the user's cart
    public function viewCart($sellerAdminId)
    {
        // Fetch the seller details (optional)
        $sellerAdmin = SellerAdmin::findOrFail($sellerAdminId);

        // Retrieve the cart for the logged-in user, with product details (eager loading)
        $cart = SellerCart::where('user_id', Auth::id())
                    ->where('seller_admin_id', $sellerAdminId)
                    ->with('product')  // Eager load the related product
                    ->get(); // Retrieve all items for this seller

        if ($cart->isEmpty()) {
            // If the cart is empty, return a message or redirect to another page
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Calculate the subtotal (sum of all item prices)
        $subtotal = $cart->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->quantity; // item price * quantity
        });

        // Assume shipping is a fixed value, for example ₹50. You can calculate this dynamically as needed.
        $shipping = 30;  // You can calculate this based on the weight, location, etc.

        // Calculate the total (subtotal + shipping charges)
        $total = $subtotal + $shipping;

        // Store cart details in SellerCartValue
        SellerCartValue::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'seller_admin_id' => $sellerAdminId
            ],
            [
                'subtotal' => $subtotal,
                'shipping_charge' => $shipping,
                'total' => $total,
                'products' => $cart->map(function ($cartItem) {
                    return [
                        'product_id' => $cartItem->product->id,
                        'product_name' => $cartItem->product->name,
                        'price' => $cartItem->price,
                        'quantity' => $cartItem->quantity,
                    ];
                })->toJson(),  // Convert the products to a JSON string
            ]
        );

        // Pass cart and sellerAdminId to the view
        return view('seller-user.cart.view', compact('cart', 'sellerAdminId', 'subtotal', 'shipping', 'total'));
    }


    public function updateCartQuantity(Request $request)
    {
        // Validate the request
        $request->validate([
            'cart_id' => 'required|exists:seller_carts,id',  // Validate that the cart ID exists
            'quantity' => 'required|integer|min:1',          // Validate that quantity is a positive integer
        ]);

        // Find the cart item using the provided cart ID
        $cartItem = SellerCart::findOrFail($request->cart_id);

        // Update the quantity of the cart item
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        // Calculate the new item total
        $itemTotal = $cartItem->price * $cartItem->quantity;

        // Recalculate the subtotal for all items in the cart
        $cart = SellerCart::where('user_id', Auth::id())
                          ->where('seller_admin_id', $cartItem->seller_admin_id)
                          ->get();

        // Calculate the subtotal
        $subtotal = $cart->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Shipping (this can be dynamic based on your logic)
        $shipping = 50;

        // Total = subtotal + shipping
        $total = $subtotal + $shipping;

        // Store updated cart details in SellerCartValue
        SellerCartValue::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'seller_admin_id' => $cartItem->seller_admin_id
            ],
            [
                'subtotal' => $subtotal,
                'shipping_charge' => $shipping,
                'total' => $total,
                'products' => $cart->map(function ($cartItem) {
                    return [
                        'product_id' => $cartItem->product->id,
                        'product_name' => $cartItem->product->name,
                        'price' => $cartItem->price,
                        'quantity' => $cartItem->quantity,
                    ];
                })->toJson(),  // Convert the products to a JSON string
            ]
        );

        // Return a JSON response with updated values
        return response()->json([
            'item_total' => '₹' . $itemTotal,
            'subtotal' => '₹' . $subtotal,
            'total' => '₹' . $total
        ]);
    }

    public function removeFromCart($sellerAdminId, $cartId)
{
    // Find the cart item by ID and user ID
    $cartItem = SellerCart::where('id', $cartId)
        ->where('user_id', Auth::id())
        ->where('seller_admin_id', $sellerAdminId)
        ->first();

    // If the cart item is not found, return an error response
    if (!$cartItem) {
        return response()->json(['message' => 'Cart item not found.'], 404);
    }

    // Delete the cart item
    $cartItem->delete();

    // Recalculate the subtotal and total after removing the item
    $cartItems = SellerCart::where('user_id', Auth::id())
        ->where('seller_admin_id', $sellerAdminId)
        ->get();

    $subtotal = $cartItems->sum(function ($cartItem) {
        return $cartItem->price * $cartItem->quantity; // item price * quantity
    });

    $shipping = 30; // Assume shipping charge is a fixed value, adjust as needed
    $total = $subtotal + $shipping;

    // Update the cart summary in SellerCartValue
    SellerCartValue::updateOrCreate(
        [
            'user_id' => Auth::id(),
            'seller_admin_id' => $sellerAdminId
        ],
        [
            'subtotal' => $subtotal,
            'shipping_charge' => $shipping,
            'total' => $total,
        ]
    );

    // Return a success response with the updated totals and a message
    return response()->json([
        'message' => 'Item removed from cart successfully.',
        'subtotal' => '₹' . $subtotal,
        'total' => '₹' . $total
    ]);
}

public function showAddressPage($sellerAdminId)
{
    // Fetch the seller details (optional)
    $sellerAdmin = SellerAdmin::findOrFail($sellerAdminId);

    // Fetch all addresses for the logged-in user
    $addresses = Address::where('user_id', auth()->id())->get();

    // Pass the addresses to the view
    return view('seller-user.select_address.address', compact('addresses', 'sellerAdminId'));
}



public function saveAddress(Request $request)
{
    // Validate the request
    $request->validate([
        'address_line1' => 'required|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
    ]);

    // Create a new address for the logged-in user
    $address = new Address();
    $address->user_id = auth()->id();
    $address->address_line1 = $request->address_line1;
    $address->address_line2 = $request->address_line2;
    $address->city = $request->city;
    $address->state = $request->state;
    $address->country = $request->country;
    $address->postal_code = $request->postal_code;
    $address->save();

    // Redirect to the address selection page
    return redirect()->back()->with('success', 'New address added successfully!');
}

public function selectAddress(Request $request)
{
    // Ensure the 'address_id' is provided
    $address = Address::where('user_id', auth()->id())
                      ->findOrFail($request->address_id);

    // Store the selected address in the session
    session(['selected_address' => $address]);

    // Redirect to the payment page and pass the sellerAdminId
    return redirect()->route('seller-user.payment.payment_page', ['sellerAdminId' => $request->sellerAdminId])
                     ->with('success', 'Address selected successfully!');
}


// Show payment page
public function showPaymentPage($sellerAdminId)
{
    // Get the selected address from the session
    $selectedAddress = session('selected_address');

    // Fetch the user's cart items for the specific seller
    $cartItems = SellerCart::where('user_id', auth()->id())
                           ->where('seller_admin_id', $sellerAdminId)
                           ->with('product') // Eager load the related product details
                           ->get();

    // Calculate the total amount by multiplying product price with quantity and summing up
    $totalAmount = $cartItems->sum(function($cartItem) {
        return $cartItem->product->price * $cartItem->quantity;
    });

    // Get the SellerCartValue for the specific user and sellerAdminId
    $cartValue = SellerCartValue::where('user_id', auth()->id())
                                ->where('seller_admin_id', $sellerAdminId)
                                ->first(); // You can also use `firstOrNew` or `firstOrCreate` depending on your use case

    // If cart value exists, use the saved total price from the SellerCartValue table
    if ($cartValue) {
        $totalAmount = $cartValue->total; // This will override the calculated total from the cart items
    }

    // Pass the cart items, totalAmount, and selectedAddress to the view
    return view('seller-user.payment.payment_page', compact('sellerAdminId', 'totalAmount', 'selectedAddress', 'cartItems'));
}




// Handle the order placement (after selecting the payment method)
public function placeOrder(Request $request, $sellerAdminId)
{
    $user = Auth::user();  // Get the authenticated user (buyer)

    // Fetch the selected address from session
    $address = session('selected_address');
    if (!$address) {
        return redirect()->route('checkout')->with('error', 'No address selected.');
    }

    // Get the SellerCartValue for the user and seller (which includes the total price with shipping)
    $cartValue = SellerCartValue::where('user_id', $user->id)
                                ->where('seller_admin_id', $sellerAdminId)
                                ->first();
    if (!$cartValue) {
        return redirect()->route('seller.cart.view', ['sellerAdminId' => $sellerAdminId])
                         ->with('error', 'Cart value not found.');
    }

    // Retrieve the cart items for this seller
    $cartItems = SellerCart::where('user_id', $user->id)
                           ->where('seller_admin_id', $sellerAdminId)
                           ->with('product') // Eager load the related product details
                           ->get();

    // Check if there are cart items
    if ($cartItems->isEmpty()) {
        return redirect()->route('seller.cart.view', ['sellerAdminId' => $sellerAdminId])
                         ->with('error', 'Your cart is empty.');
    }

    // Get the total price (which includes the shipping charge) from SellerCartValue
    $totalPrice = $cartValue->total;

    // Get the last cart item
    $lastCartItem = $cartItems->last(); // Fetch the last cart item for the seller

    // Ensure the last cart item exists
    if (!$lastCartItem) {
        return redirect()->route('seller.cart.view', ['sellerAdminId' => $sellerAdminId])
                         ->with('error', 'Unable to find the last cart item.');
    }

    // Ensure that the product exists in SellerProduct table for the last cart item
    $product = SellerProduct::find($lastCartItem->product_id);
    if (!$product) {
        return redirect()->route('seller.cart.view', ['sellerAdminId' => $sellerAdminId])
                         ->with('error', 'One or more products in your cart are unavailable.');
    }

    // Optionally, create the order for the last cart item (if you want to save it in SellerOrder)
    $order = new SellerOrder();
    $order->user_id = $user->id;
    $order->seller_admin_id = $sellerAdminId;
    $order->address_id = $address->id;
    $order->product_id = $lastCartItem->product_id;  // Use the last cart item's product_id
    $order->payment_method = $request->payment_method;
    $order->quantity = $lastCartItem->quantity;
    $order->total_price = $totalPrice;  // Use the total price (which includes shipping) from SellerCartValue
    $order->status = 'pending';  // Default status for new orders
    $order->email_sent = false;  // Initially set email_sent to false
    $order->save();

    // Check if email has already been sent for this order
    if (!$order->email_sent) {
        // Send the order confirmation email to the user
        Mail::to($user->email)->send(new SellerUserOrderPlaced($order, $user, SellerAdmin::find($sellerAdminId)));

        // Update the email_sent field to true after sending the email
        $order->email_sent = true;
        $order->save();
    }

    // Send email to the admin notifying about the new order
    $adminEmail = 'arjuncableconverters@gmail.com';  // Admin's email
    Mail::to($adminEmail)->send(new AdminNewOrderNotification($order, SellerAdmin::find($sellerAdminId)));

    // Optionally, clear the user's cart for this seller after the order is placed
    SellerCart::where('user_id', $user->id)
              ->where('seller_admin_id', $sellerAdminId)
              ->delete();

              // Also clear the SellerCartValue for the user and seller after order is placed
    SellerCartValue::where('user_id', $user->id)
    ->where('seller_admin_id', $sellerAdminId)
    ->delete();

    // Redirect to the order confirmation page
    return redirect()->route('order.confirmation', [
        'orderId' => $order->id,  // Pass the ID of the order that was created
        'sellerAdminId' => $sellerAdminId
    ])
    ->with('success', 'Your order has been received successfully!');
}




public function showOrder($orderId)
{
    // Retrieve the SellerOrder with the related Product using eager loading
    $order = SellerOrder::with('product') // Eager load the product relationship
                        ->where('id', $orderId)
                        ->first();

    // Check if the order exists
    if (!$order) {
        return redirect()->route('orders.index')->with('error', 'Order not found.');
    }

    // Pass the order to the view
    return view('seller-user.orders.show-order', compact('order'));
}

// In CartController.php

public function showOrderdetails($orderId, $sellerAdminId)
{
    // Retrieve the order and sellerAdmin using both IDs
    $order = SellerOrder::with('product')->where('id', $orderId)->first();

    // Check if the order exists
    if (!$order) {
        return redirect()->route('orders.index')->with('error', 'Order not found.');
    }

    // Pass the order and sellerAdminId to the view
    return view('seller-user.orders.show-order', compact('order', 'sellerAdminId'));
}



}
