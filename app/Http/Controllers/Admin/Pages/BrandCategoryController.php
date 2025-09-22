<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use App\Models\BrandCategoryImage;

class BrandCategoryController extends Controller
{
    // Method to view all brands and their associated categories and subcategories
    public function view_brands()
    {
        // Fetch brands with their categories and subcategories
        $brands = Brand::with('brandCategories.subcategories')->get();
        return view('admin.pages.brands', compact('brands'));
    }

    // Method to add a brand category
    public function add_brand_category($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        return view('admin.pages.add_brand_category', compact('brand'));
    }

    // Method to store the brand category

    public function store_brand_category(Request $request, $brandId)
{
    // Validate the input fields
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // Validate image (optional)
    ]);

    // Find the brand
    $brand = Brand::findOrFail($brandId);

    // Create a new BrandCategory instance
    $brandCategory = new BrandCategory();
    $brandCategory->name = $request->input('name');
    $brandCategory->brand_id = $brand->id;
    $brandCategory->save();

    // Handle the image upload if present
    if ($request->hasFile('image')) {
        $image = $request->file('image'); // Get the uploaded file
        $imagePath = $image->store('brand_category_image', 'public');  // Store in public disk

        // Save the image to the brand_category_images table
        BrandCategoryImage::create([
            'brand_category_id' => $brandCategory->id,  // Associate the image with the created brand category
            'image' => $imagePath,
        ]);
    }

    return redirect()->route('pages.view_brands')->with('success', 'Brand Category created successfully!');
}

    // Method to add a subcategory to a brand category
    public function add_subcategory($brandCategoryId)
    {
        $brandCategory = BrandCategory::findOrFail($brandCategoryId);
        return view('admin.pages.add_subcategory', compact('brandCategory'));
    }

    // Method to store a subcategory
    public function store_subcategory(Request $request, $brandCategoryId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brandCategory = BrandCategory::findOrFail($brandCategoryId);
        $subcategory = new Subcategory();
        $subcategory->name = $request->input('name');
        $subcategory->brand_category_id = $brandCategory->id;
        $subcategory->save();

        return redirect()->route('pages.view_brands')->with('success', 'Subcategory created successfully!');
    }

    // Method to show the edit form for a brand category
    public function edit($id)
    {
        $brandCategory = BrandCategory::findOrFail($id);
        return view('admin.pages.edit_brand_category', compact('brandCategory'));
    }

    // Method to update the brand category
    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image if present
    ]);

    // Find the BrandCategory by ID
    $brandCategory = BrandCategory::findOrFail($id);

    // Update the name
    $brandCategory->name = $request->input('name');

    // Check if a new image is uploaded
    if ($request->hasFile('image')) {
        // Delete the old image if exists (optional)
        if ($brandCategory->images->isNotEmpty()) {
            Storage::disk('public')->delete($brandCategory->images->first()->image);
        }

        // Get the uploaded image
        $image = $request->file('image');

        // Store the new image and get the path
        $imagePath = $image->store('brand_category_image', 'public');

        // Update the image in the database (assuming images relation)
        // If your model is set up for images, you can store the path or upload logic here
        // Example: assuming your 'images' relationship stores file paths
        $brandCategory->images()->update(['image' => $imagePath]);
    }

    // Save the updated BrandCategory
    $brandCategory->save();

    // Redirect back to the brands view with success message
    return redirect()->route('pages.view_brands')->with('success', 'Brand Category updated successfully!');
}

public function destroy($id)
{
    // Find the BrandCategory by ID
    $brandCategory = BrandCategory::findOrFail($id);

    // Check if the category has an associated image
    if ($brandCategory->images->isNotEmpty()) {
        // Loop through all associated images and delete them
        foreach ($brandCategory->images as $image) {
            // Delete image from storage
            Storage::disk('public')->delete($image->image);
        }
    }

    // Delete the BrandCategory record
    $brandCategory->delete();

    // Redirect back to the brands view with a success message
    return redirect()->route('pages.view_brands')->with('success', 'Brand Category deleted successfully!');
}


    // Method to delete a subcategory
    public function destroySubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();

        // Redirect back with a success message
        return redirect()->route('pages.view_brands')->with('success', 'Subcategory deleted successfully!');
    }

}
