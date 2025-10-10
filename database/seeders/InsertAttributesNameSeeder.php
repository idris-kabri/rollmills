<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttributeAssign;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsertAttributesNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::where('attribute_id','!=',null)->get(); 
        foreach($products as $product){ 
            $attributeIds = explode(',',$product->attribute_id); 
            $productAttributeAsigns = ProductAttributeAssign::whereIn('id',$attributeIds)->get(); 

            $titles = [] ;
            foreach($productAttributeAsigns as $productAttributeAsign){ 
                $titles[] = $productAttributeAsign->title; 
            }
            $product->attributes_name = implode(',',$titles); 
            $product->save();
        }
    }
}
