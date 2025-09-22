<?php

namespace App\Http\Controllers\Admin\Carousel;

use App\Http\Controllers\Controller;
use App\Models\CarouselImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function carousel_view()
    {
        // Fetch all the carousel images from the database
        $carouselImages = CarouselImage::all();
        return view('admin.carousel_images.carousel', compact('carouselImages'));
    }

    public function save_carousel_images(Request $request)
{
    // Validate the incoming files
    $validated = $request->validate([
        'image_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'image_2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'image_3' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Handle each image upload
    $imagePaths = [];
    foreach (['image_1', 'image_2', 'image_3'] as $imageInput) {
        if ($request->hasFile($imageInput)) {
            try {
                $image = $request->file($imageInput);
                $imagePath = $image->store('carousel_images', 'public');
                $imagePaths[$imageInput] = $imagePath;
            } catch (\Exception $e) {
                Log::error('Image upload failed for ' . $imageInput . ': ' . $e->getMessage());
                return redirect()->back()->with('error', 'Image upload failed.');
            }
        }
    }

    // Save the images in the database
    foreach ($imagePaths as $imageInput => $imagePath) {
        CarouselImage::create([
            'image_path' => $imagePath,
            'status' => 'active',
        ]);
    }

    return redirect()->route('carousel.carousel_view')->with('success', 'Images added successfully!');
}


    public function edit_carousel_image($id)
{
    // Fetch the specific carousel image by its ID
    $carouselImage = CarouselImage::findOrFail($id); // Fetch the image based on ID
    return view('admin.carousel_images.carousel_edit', compact('carouselImage'));
}


     // Update the image
     public function update_carousel_image(Request $request, $id)
{
    // Find the carousel image by ID
    $carouselImage = CarouselImage::findOrFail($id);

    // Validate the incoming image
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Validation for the image
    ]);

    // Check if a new image is uploaded
    if ($request->hasFile('image')) {
        // Delete the old image file from the storage
        Storage::disk('public')->delete($carouselImage->image_path);

        // Store the new image
        $newImagePath = $request->file('image')->store('carousel_images', 'public');

        // Update the carousel image record in the database
        $carouselImage->update([
            'image_path' => $newImagePath, // Update with the new image path
        ]);
    }

    // Redirect back with a success message
    return redirect()->route('carousel.carousel_view')->with('success', 'Image updated successfully!');
}


     // Delete the image
     public function delete_carousel_image($id)
     {
         $carouselImage = CarouselImage::findOrFail($id);

         // Delete the image file
         Storage::disk('public')->delete($carouselImage->image_path);

         // Delete the record from the database
         $carouselImage->delete();

         return redirect()->route('carousel.carousel_view')->with('success', 'Image deleted successfully!');
     }

}
