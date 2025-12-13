<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class AddPriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-price-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::all();
        foreach($products as $product){
            $price = $product->price;
            $sale_default_price = $product->sale_default_price;
            $price_after_percentage = $price / 0.9;
            $sale_default_price_after_percentage = $sale_default_price / 0.9;

            $product->price = ceil($price_after_percentage);
            $product->sale_default_price = ceil($sale_default_price_after_percentage);
            $product->save();
        }
    }
}
