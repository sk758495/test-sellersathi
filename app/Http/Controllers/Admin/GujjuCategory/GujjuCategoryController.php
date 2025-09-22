<?php

namespace App\Http\Controllers\Admin\GujjuCategory;

use App\Http\Controllers\Controller;
use App\Models\GujjuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GujjuCategoryController extends Controller
{
    
    public function view_gujjucategory()
    {
        // Fetch all brands from the database
        $brands = GujjuCategory::all();

        // Pass the brands data to the view
        return view('admin.gujjucategory.gujjucategory', compact('brands'));
    }

    public function add_brand(){
        return view('admin.gujjucategory.add_gujjucategory');
    }

    // Method to store the brand data
    public function store_brand(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Add image validation
        ]);

        // Check if an image is uploaded
        if ($request->hasFile('image')) {
            // Get the image from the request
            $image = $request->file('image');

            // Check if the image is valid (a good practice to prevent invalid files)
            if ($image->isValid()) {
                // Generate a unique file name to avoid overwriting files
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store the image in the 'brands' directory inside the public disk
                // 'public' disk stores files in storage/app/public, accessible via /storage
                $imagePath = $image->storeAs('brands', $imageName, 'public');  // Store image with unique name

                // Create the brand and save the details in the database
                $brand = new GujjuCategory();
                $brand->name = $request->input('name');
                $brand->image = $imagePath;  // Store the image path in the database
                $brand->save();

                // Redirect with success message
                return redirect()->route('gujjucategory.view_gujjucategory')->with('success', 'Category created successfully!');
            } else {
                // If the image is invalid, return an error
                return redirect()->back()->with('error', 'The uploaded image is not valid.');
            }
        } else {
            // If no image is uploaded, return an error
            return redirect()->back()->with('error', 'Please upload a valid image.');
        }
    }



    // Method to show the edit brand form
    public function edit_brand($id)
    {
        $brand = GujjuCategory::findOrFail($id);
        return view('admin.gujjucategory.edit_gujjucategory', compact('brand'));
    }

    // Method to update the brand
        public function update_brand(Request $request, $id)
        {
            // Validate the incoming data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $brand = GujjuCategory::findOrFail($id);
            $brand->name = $request->input('name');

            // Handle the image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($brand->image) {
                    Storage::disk('public')->delete($brand->image);
                }

                // Store the new image
                $image = $request->file('image');
                $imagePath = $image->store('brands', 'public');
                $brand->image = $imagePath;
            }

            // Save the brand
            $brand->save();

            return redirect()->route('gujjucategory.view_gujjucategory')->with('success', 'Category updated successfully!');
        }

        public function destroy($id)
    {
        // Find the brand by its ID
        $brand = GujjuCategory::findOrFail($id);

        // Delete the image file if it exists
        if ($brand->image) {
            // Delete the old image file from storage
            Storage::disk('public')->delete($brand->image);
        }

        // Delete the brand from the database
        $brand->delete();

        // Redirect back to the brand list with a success message
        return redirect()->route('gujjucategory.view_gujjucategory')->with('success', 'Category deleted successfully!');
    }

}
