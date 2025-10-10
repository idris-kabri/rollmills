<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategoryAssign;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RemoveDuplicateDataProductCategoryAssigns extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productCategoryAssign = ProductCategoryAssign::all();
        $processed = []; 

        foreach ($productCategoryAssign as $assign) {
            $key = $assign->product_id . '-' . $assign->category_id;

            if (isset($processed[$key])) {
                continue;
            }
            $processed[$key] = true;

            $duplicates = ProductCategoryAssign::where('product_id', $assign->product_id)
                ->where('category_id', $assign->category_id)
                ->where('id', '!=', $assign->id) 
                ->get();

            foreach ($duplicates as $duplicate) {
                $duplicate->delete();
            }
        }

    }
}
