<?php

namespace Database\Seeders;

use App\Models\ProductBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBrandRemoveDuplicateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productBrands = ProductBrand::all();
        $processed = [];

        foreach ($productBrands as $brand) {
            $key = $brand->product_id . '-' . $brand->brand_id;

            if (isset($processed[$key])) {
                continue;
            }
            $processed[$key] = true;

            $duplicates = ProductBrand::where('product_id', $brand->product_id)
                ->where('brand_id', $brand->brand_id)
                ->where('id', '!=', $brand->id)
                ->get();

            foreach ($duplicates as $duplicate) {
                $duplicate->delete();
            }
        }
    }
}
