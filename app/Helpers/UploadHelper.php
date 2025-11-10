<?php

use App\Models\Product;
use App\Models\Setting;
use Carbon\Carbon;

function getPrice($id){ 
    $product = Product::findOrFail($id); 
    $currentDate = Carbon::parse(now())->format('Y-m-d');  
    $isOnSale = $product->sale_from_date <= $currentDate && $product->sale_to_date >= $currentDate;

    if($product->sale_price != 0 && $isOnSale){ 

        return [
            'price' => $product->sale_price,
            'original_price' => $product->price,
            'discount' => $product->price >$product->sale_price ? round((($product->price - $product->sale_price) / $product->price ) * 100) : 0,
        ];

    }else if($product->sale_default_price != 0){ 

        return [
            'price' => $product->sale_default_price,
            'original_price' => $product->price,
            'discount' => $product->price >$product->sale_price ? round((($product->price - $product->sale_default_price) / $product->price ) * 100) : 0,
        ];

    }else{ 

        return [
            'price' => $product->price,
            'original_price' => null,
            'discount' => null,
        ];
        
    } 
}