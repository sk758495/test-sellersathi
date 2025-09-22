<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\BrandCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * Transform each row into a Product model instance.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Find the Brand by name
        $brand = Brand::where('name', $row['brand_name'])->first();

        // Find the BrandCategory by name
        $brandCategory = BrandCategory::where('name', $row['brand_category_name'])->first();

        return new Product([
            'product_name' => $row['product_name'],
            'sku' => $row['sku'],
            'quantity' => $row['quantity'],
            'color_name' => $row['color_name'],
            'color_code' => $row['color_code'],
            'price' => $row['price'],
            'cost_price' => $row['cost_price'],
            'discount_price' => $row['discount_price'],
            'lead_time' => $row['lead_time'],
            'brand_id' => $brand ? $brand->id : null,  // Use the found Brand ID
            'brand_category_id' => $brandCategory ? $brandCategory->id : null,  // Use the found BrandCategory ID
            'short_description' => $row['short_description'],
            'long_description' => $row['long_description'],
            'features' => $row['features'],
            'whats_included' => $row['whats_included'],
        ]);
    }

    /**
     * Set the number of rows to read at a time for chunk reading.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;  // Adjust chunk size as needed for performance
    }
}
