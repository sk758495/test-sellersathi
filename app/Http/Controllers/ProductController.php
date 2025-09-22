<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Product;
use App\Models\ProductImage;  // Include the ProductImage model
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\GujjuCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function create()
    {
        // Pass all brands and categories to the view
        $brands = Brand::all();
        $brand_categories = BrandCategory::all();
        $subcategories = Subcategory::all();
        $gujju_categories = GujjuCategory::all();
        return view('admin.product.add_product', compact('brands', 'brand_categories','subcategories','gujju_categories'));
    }

    public function store(Request $request)
    {
        // Validate the incoming form data
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products',
            'quantity' => 'required|integer',
            'color_name' => 'required|string',
            'color_code' => 'required|string',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'lead_time' => 'required|string',
            'brand' => 'required|exists:brands,id', // Ensure 'brand' is used here
            'brand_category' => 'required|exists:brand_categories,id', // Ensure 'brand_category' is used here
            'subcategory_id' => 'nullable|exists:subcategories,id', // No change needed for validation
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'features' => 'required|string',
            'whats_included' => 'required|string',
            'main_images' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Main image validation
            'product_images' => 'nullable|array',
            'product_images.*' => 'image|max:2048', // Limit image size to 2MB
            'gujju_category_id' => 'required|exists:gujju_categories,id',
        ]);

        // Store the main image
        $mainImagePath = $request->file('main_images')->store('product_main_images', 'public');


        // Store additional images
    $images = [];
    if ($request->hasFile('product_images')) {
        foreach ($request->file('product_images') as $image) {
            $images[] = $image->store('product_images', 'public');
        }
    }

        // Ensure the subcategory_id is available or null
        $subcategory_id = $validated['subcategory_id'] ?? null; // Use null if not set

        // Create the product record
        $product = Product::create([
            'product_name' => $validated['product_name'],
            'sku' => $validated['sku'],
            'color_name' => $validated['color_name'],
            'color_code' => $validated['color_code'],
            'quantity' => $validated['quantity'],
            'lead_time' => $validated['lead_time'],
            'price' => $validated['price'],
            'cost_price' => $validated['cost_price'],
            'discount_price' => $validated['discount_price'],
            'short_description' => $validated['short_description'],
            'long_description' => $validated['long_description'],
            'features' => $validated['features'],
            'whats_included' => $validated['whats_included'],
            'brand_id' => $validated['brand'], // Ensure matching field names
            'brand_category_id' => $validated['brand_category'], // Ensure matching field names
            'subcategory_id' => $subcategory_id, // Use the null fallback
            'gujju_category_id' => $validated['gujju_category_id'], // Add category_id here
        ]);

        /// Store the main image path in the database
    $product->main_image = str_replace('public/', '', $mainImagePath);  // Store the path without 'public/' prefix
    $product->save();

    // Store additional product images in the database
    if (!empty($images)) {
        $product->images()->createMany(array_map(function ($image) {
            return ['path' => str_replace('public/', '', $image)];  // Remove 'public/' from the path
        }, $images));
    }

        return redirect()->route('admin.products.view_product')->with('success', 'Product added successfully!');
    }

    // This function will handle dynamic Brand Category fetching via AJAX
    public function getBrandCategories($brandId)
    {
        // Get all brand categories by brand ID
        $brandCategories = BrandCategory::where('brand_id', $brandId)->get();
        return response()->json($brandCategories);
    }

    // This function will handle dynamic Subcategory fetching via AJAX
    public function getSubcategories($brandCategoryId)
    {
        // Get all subcategories by brand category ID
        $subcategories = Subcategory::where('brand_category_id', $brandCategoryId)->get();
        return response()->json($subcategories);
    }



    public function view_all_products()
    {
        // Fetch all products with their relationships (brand, category, subcategory)
        $products = Product::with('category','brand', 'brandCategory', 'subcategory')->get();

        return view('admin.product.view_product', compact('products'));
    }

    public function view_product_details($id)
    {
        // Fetch the product by ID with its relationships
        $product = Product::with('category','brand', 'brandCategory', 'subcategory')->findOrFail($id);

        return view('admin.product.view_product_details', compact('product'));
    }

    public function edit_product($id)
    {
        // Pass all brands and categories to the view
        $brands = Brand::all();
        $brand_categories = BrandCategory::all();
        $subcategories = Subcategory::all();
        
        $gujju_categories = GujjuCategory::all();
        // Fetch the product by ID with its relationships
        $product = Product::with('category','brand', 'brandCategory', 'subcategory')->findOrFail($id);

        return view('admin.product.edit_product', compact('product','brands', 'brand_categories','subcategories','gujju_categories'));
    }

    // Update the product
    public function update(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'product_name' => 'required|string|max:255',
            'sku' => 'required|string|max:100',
            'brand' => 'required|exists:brands,id',
            'brand_category' => 'required|exists:brand_categories,id',
            'quantity' => 'required|integer|min:1',
            'color_name' => 'required|string|max:100',
            'color_code' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'lead_time' => 'required|string|max:255',
            'main_images' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'features' => 'nullable|string',
            'whats_included' => 'nullable|string',
            'product_images' => 'nullable|array',  // Allow product images to be updated
            'product_images.*' => 'image|max:2048', // Additional images validation
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update the product's attributes (excluding the images)
        $product->product_name = $request->product_name;
        $product->sku = $request->sku;
        $product->brand_id = $request->brand;
        $product->brand_category_id = $request->brand_category;
        $product->subcategory_id = $request->subcategory_id;
        $product->quantity = $request->quantity;
        $product->color_name = $request->color_name;
        $product->color_code = $request->color_code;
        $product->price = $request->price;
        $product->cost_price = $request->cost_price;
        $product->discount_price = $request->discount_price;
        $product->lead_time = $request->lead_time;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->features = $request->features;
        $product->whats_included = $request->whats_included;
        $product->gujju_category_id = $request->gujju_category_id;
        
        // Handle the main image upload if any
        if ($request->hasFile('main_images')) {
            // Delete old main image if exists
            if ($product->main_image) {
                Storage::delete('public/' . $product->main_image);  // Ensure the correct path prefix
            }

            // Store new main image
            $mainImagePath = $request->file('main_images')->store('product_main_images', 'public');
            $product->main_image = str_replace('public/', '', $mainImagePath);  // Store only relative path
        }

        // Handle additional images if any
        if ($request->hasFile('product_images')) {
            // Delete old product images if any (if you want to clear before adding new ones)
            $product->images()->delete();

            // Store additional images
            $images = [];
            foreach ($request->file('product_images') as $image) {
                $images[] = $image->store('product_images', 'public');
            }

            // Store the image paths in the database
            foreach ($images as $image) {
                $product->images()->create([
                    'path' => str_replace('public/', '', $image)  // Store relative path without 'public/'
                ]);
            }
        }

        // Save the updated product
        $product->save();

        // Redirect back to the product index with a success message
        return redirect()->route('admin.products.view_product')->with('success', 'Product updated successfully!');
    }


    public function destroy($id)
    {
        // Find the product by its ID
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        // Redirect back with a success message
        return redirect()->route('admin.products.view_product')->with('success', 'Product deleted successfully!');
    }



    // Export page with filter
    public function exportFilter()
    {
        $brands = Brand::all();
        $brand_categories = BrandCategory::all();

        return view('admin.product.export_filter', compact('brands', 'brand_categories'));
    }

    // Handle export request with filter
    public function export(Request $request)
    {
        // Validate filter data
        $validated = $request->validate([
            'brand' => 'nullable|exists:brands,id',
            'brand_category' => 'nullable|exists:brand_categories,id',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
        ]);

        // Use the validated data to filter the products
        $query = Product::query();

        if ($validated['brand']) {
            $query->where('brand_id', $validated['brand']);
        }

        if ($validated['brand_category']) {
            $query->where('brand_category_id', $validated['brand_category']);
        }

        if ($validated['price_min']) {
            $query->where('price', '>=', $validated['price_min']);
        }

        if ($validated['price_max']) {
            $query->where('price', '<=', $validated['price_max']);
        }

        // Pass the filtered data to the export
        return Excel::download(new ProductsExport($query->get()), 'products_export.xlsx');
    }

    // Show the import form

    // Method to show the import form
    public function showImportForm()
    {
        return view('admin.product.import_product');  // Return the view where you want the import form
    }

    // Method to handle the import
    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',  // Only allow Excel or CSV files with a max size of 2MB
        ]);

        // Import the file using the ProductsImport class
        Excel::import(new ProductsImport, $request->file('file'));

        // Redirect back with a success message
        return redirect()->route('admin.products.view_product')->with('success', 'Products imported successfully!');
    }

    public function search(Request $request)
    {
        // Get the search term from the input
        $search = $request->input('search');
        $message = null;  // Initialize the $message variable
    
        // Check if the search term is provided
        if ($search) {
            // Query the products and search by multiple columns using `orWhere`
            $products = Product::where('product_name', 'like', "%$search%")
                ->orWhere('sku', 'like', "%$search%")
                ->orWhere('color_name', 'like', "%$search%")
                ->orWhere('color_code', 'like', "%$search%")
                ->orWhere('quantity', 'like', "%$search%")
                ->orWhere('lead_time', 'like', "%$search%")
                ->orWhere('price', 'like', "%$search%")
                ->orWhere('cost_price', 'like', "%$search%")
                ->orWhere('discount_price', 'like', "%$search%")
                ->paginate(12);
        } else {
            // If no search term, set products to an empty collection and provide a message
            $products = collect(); // Empty collection
            $message = "Please enter a value to search for products.";
        }
    
        // Eager load 'images' relationship with brand categories
        $brand_categories = BrandCategory::with('images')->take(6)->get();
    
        // Return to the view with the products and the message
        return view('user.search-product', compact('products', 'brand_categories', 'message'));
    }
    
    
}
