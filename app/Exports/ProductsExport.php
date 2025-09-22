<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class ProductsExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $products;

    public function __construct(Collection $products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products->map(function ($product) {
            return [
                'Product Name' => $product->product_name,
                'SKU' => $product->sku,
                'Brand' => $product->brand->name,
                'Category' => $product->brandCategory->name,
                'Price' => $product->price,
                'Quantity' => $product->quantity,
                'Color Name' => $product->color_name,
                'Color Code' => $product->color_code,
                'Short_Description' => $product->short_description,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'SKU',
            'Brand',
            'Category',
            'Price',
            'Quantity',
            'Color Name',
            'Color Code',
            'Short_Description',
        ];
    }

    public function title(): string
    {
        return 'Products';
    }
}
