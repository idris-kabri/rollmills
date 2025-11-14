<?php

use App\Models\Brand;
use App\Models\Offer;
use App\Models\OfferAppliesConfig;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductCategoryAssign;
use Gloudemans\Shoppingcart\Facades\Cart;

function triggerProductFunction($triger_offer_product_array, &$applied_offer_id, &$to_be_applied_offer_id, &$offer_applied_cart_product_id)
{
    foreach ($triger_offer_product_array as $productId => $triggerProduct) {
        $offer = Offer::find($triggerProduct['offer_id']);
        if (!in_array($offer->id, $applied_offer_id)) {
            $offer_applies = OfferAppliesConfig::where('offer_id', $offer->id)->get();
            $check_product_cart = Cart::instance('cart')
                ->search(function ($cartItem) use ($productId) {
                    return $cartItem->id === $productId;
                })
                ->first();
            if ($check_product_cart != null) {
                $minQty = $triggerProduct['min_qty'];
                $minAmount = $triggerProduct['min_amount'];
                $trigger_priceInfo = getPrice($check_product_cart->id);
                $trigger_actualPrice = $trigger_priceInfo['price'];
                $trigger_totalValue = $check_product_cart->qty * $trigger_actualPrice;

                if ($check_product_cart != null && (($minQty != 0 && $check_product_cart->qty >= $minQty) || ($minAmount != 0 && $trigger_totalValue >= $minAmount))) {
                    appliesFunctionCheck($offer_applies, $check_product_cart, $offer, $productId, $triggerProduct, $applied_offer_id, $to_be_applied_offer_id, $offer_applied_cart_product_id);
                }
            }
        }
    }
}

function triggerBrandFunction($triger_offer_brand_array, &$applied_offer_id, &$to_be_applied_offer_id, &$offer_applied_cart_product_id)
{
    foreach ($triger_offer_brand_array as $brandId => $triggerBrand) {
        $offer = Offer::find($triggerBrand['offer_id']);
        if (!in_array($offer->id, $applied_offer_id)) {
            $offer_applies = OfferAppliesConfig::where('offer_id', $offer->id)->get();
            $brands_products = ProductBrand::where('brand_id', $brandId)->pluck('product_id')->toArray();
            $is_item_found = false;
            $productId = 0;
            $minQty = $triggerBrand['min_qty'];
            $minAmount = $triggerBrand['min_amount'];
            $check_product_cart = null;
            foreach ($brands_products as $product_id) {
                $cart_check = Cart::instance('cart')
                    ->search(function ($cartItem) use ($product_id) {
                        return $cartItem->id === $product_id;
                    })
                    ->first();
                if ($cart_check != null) {
                    $trigger_priceInfo = getPrice($product_id);
                    $trigger_actualPrice = $trigger_priceInfo['price'];
                    $trigger_totalValue = $cart_check->qty * $trigger_actualPrice;

                    if (($minQty != 0 || $minAmount != 0) && (($minQty != 0 && $cart_check->qty >= $minQty) || ($minAmount != 0 && $trigger_totalValue >= $minAmount))) {
                        $is_item_found = true;
                        $productId = $product_id;
                        $check_product_cart = Cart::instance('cart')
                            ->search(function ($cartItem) use ($cart_check) {
                                return $cartItem->rowId === $cart_check->rowId;
                            })
                            ->first();
                        break;
                    }
                }
            }

            if ($is_item_found && $check_product_cart != null) {
                appliesFunctionCheck($offer_applies, $check_product_cart, $offer, $productId, $triggerBrand, $applied_offer_id, $to_be_applied_offer_id, $offer_applied_cart_product_id);
            }
        }
    }
}

function triggerCategoryFunction($triger_offer_category_array, &$applied_offer_id, &$to_be_applied_offer_id, &$offer_applied_cart_product_id)
{
    foreach ($triger_offer_category_array as $categoryId => $triggercategory) {
        $offer = Offer::find($triggercategory['offer_id']);
        if (!in_array($offer->id, $applied_offer_id)) {
            $offer_applies = OfferAppliesConfig::where('offer_id', $offer->id)->get();
            $category_products = ProductCategoryAssign::where('category_id', $categoryId)->pluck('product_id')->toArray();
            $is_item_found = false;
            $productId = 0;
            $minQty = $triggercategory['min_qty'];
            $minAmount = $triggercategory['min_amount'];
            $check_product_cart = [];
            foreach ($category_products as $product_id) {
                $cart_check = Cart::instance('cart')
                    ->search(function ($cartItem) use ($product_id) {
                        return $cartItem->id === $product_id;
                    })
                    ->first();
                if ($cart_check != null) {
                    $trigger_priceInfo = getPrice($product_id);
                    $trigger_actualPrice = $trigger_priceInfo['price'];
                    $trigger_totalValue = $cart_check->qty * $trigger_actualPrice;

                    if (($minQty != 0 || $minAmount != 0) && ($cart_check->qty >= $minQty || $trigger_totalValue >= $minAmount)) {
                        $is_item_found = true;
                        $productId = $product_id;
                        $check_product_cart = Cart::instance('cart')
                            ->search(function ($cartItem) use ($cart_check) {
                                return $cartItem->rowId === $cart_check->rowId;
                            })
                            ->first();
                        break;
                    }
                }
            }
            if ($is_item_found && $check_product_cart != null) {
                appliesFunctionCheck($offer_applies, $check_product_cart, $offer, $productId, $triggercategory, $applied_offer_id, $to_be_applied_offer_id, $offer_applied_cart_product_id);
            }
        }
    }
}

function appliesFunctionCheck($offer_applies, $check_product_cart, $offer, $productId, $triggerProduct, &$applied_offer_id, &$to_be_applied_offer_id, &$offer_applied_cart_product_id)
{
    foreach ($offer_applies as $appliesItems) {
        $applies_min_qty = $appliesItems->min_qnty;
        $applies_min_amount = $appliesItems->min_amount;
        if ($appliesItems->applies == 1) {
            if (!in_array($offer->id, $applied_offer_id)) {
                aapliesProductFunctionCheck($productId, $appliesItems, $check_product_cart, $applies_min_qty, $applies_min_amount, $offer, $triggerProduct, $applied_offer_id, $to_be_applied_offer_id, $offer_applied_cart_product_id);
            }
        } elseif ($appliesItems->applies == 2) {
            if (!in_array($offer->id, $applied_offer_id)) {
                appliesBrandFunctionCheck($productId, $appliesItems, $offer, $triggerProduct, $applied_offer_id, $to_be_applied_offer_id, $offer_applied_cart_product_id, $applies_min_qty, $applies_min_amount);
            }
        } elseif ($appliesItems->applies == 3) {
            if (!in_array($offer->id, $applied_offer_id)) {
                appliesCategoryFunctionCheck($productId, $appliesItems, $offer, $triggerProduct, $applied_offer_id, $to_be_applied_offer_id, $offer_applied_cart_product_id);
            }
        } elseif ($appliesItems->applies == 4) {
            if (!in_array($offer->id, $applied_offer_id)) {
                appliesLeastPriceFunctionCheck($productId, $offer, $triggerProduct, $appliesItems, $applied_offer_id, $to_be_applied_offer_id, $offer_applied_cart_product_id);
            }
        }
    }
}

function aapliesProductFunctionCheck($productId, $appliesItems, $check_product_cart, $applies_min_qty, $applies_min_amount, $offer, $triggerProduct, &$applied_offer_id, &$to_be_applied_offer_id, &$offer_applied_cart_product_id)
{
    $getItem = Product::find($appliesItems->refrence_id);
    $cart_item = Cart::instance('cart')
        ->search(function ($cartItem) use ($getItem, $productId) {
            return $cartItem->id === $getItem->id && $cartItem->id != $productId;
        })
        ->first();

    if ($cart_item != null) {
        $applies_priceInfo = getPrice($cart_item->id);
        $applies_actualPrice = $applies_priceInfo['price'];
        $applies_totalValue = $cart_item->qty * $applies_actualPrice;

        if (($applies_min_qty != 0 || $applies_min_amount != 0) && ($cart_item->qty >= $applies_min_qty || $applies_totalValue >= $applies_min_amount) && !in_array($appliesItems->refrence_id, $offer_applied_cart_product_id)) {
            $discount = $offer->discount_type == 'Percentage' ? ($cart_item->subtotal * $offer->discount_value) / 100 : $offer->discount_value;
            $finalPrice = max(0, $applies_totalValue - $discount);
            Cart::instance('cart')->update($cart_item->rowId, [
                'options' => array_merge($cart_item->options->all(), ['discount_price' => $finalPrice, 'offer_id' => $offer->id, 'offer_applied_id' => $appliesItems->id, 'offer_trigger_id' => $triggerProduct['id']]),
            ]);
            session()->put('offer_applied_id', $cart_item->name);
            $applied_offer_id[] = $offer->id;
            $offer_applied_cart_product_id[] = $cart_item->id;
        } else {
            $to_be_applied_offer_id[]['product'][$offer->id][$appliesItems->refrence_id] = [
                'discount' => $offer->discount_type == 'Percentage' ? $offer->discount_value . '%' : '₹' . $offer->discount_value,
                'minimum' => $appliesItems->min_qnty != 0 ? "Buy {$appliesItems->min_qnty} quantity in one item" : "Buy more than ₹{$appliesItems->min_amount}",
                'name' => $getItem->name,
            ];
        }
    } else {
        $to_be_applied_offer_id[]['product'][$offer->id][$appliesItems->refrence_id] = [
            'discount' => $offer->discount_type == 'Percentage' ? $offer->discount_value . '%' : '₹' . $offer->discount_value,
            'minimum' => $appliesItems->min_qnty != 0 ? "Buy {$appliesItems->min_qnty} quantity in one item" : "Buy more than ₹{$appliesItems->min_amount}",
            'name' => $getItem->name,
        ];
    }
}

function appliesCategoryFunctionCheck($productId, $appliesItems, $offer, $triggerProduct, &$applied_offer_id, &$to_be_applied_offer_id, &$offer_applied_cart_product_id)
{
    $getCategoryItem = ProductCategory::find($appliesItems->refrence_id);
    $category_assign = ProductCategoryAssign::where('category_id', $getCategoryItem->id)->pluck('product_id')->toArray();
    $is_category_item_found = false;
    $highest_price_product_id = '';
    $highest_price = 0;

    foreach ($category_assign as $category_assign_item) {
        $cart_item = Cart::instance('cart')
            ->search(function ($cartItem) use ($category_assign_item, $productId) {
                return $cartItem->id === $category_assign_item && $cartItem->id != $productId;
            })
            ->first();
        if ($cart_item != null) {
            if (!$cart_item->options->has('offer_id') && !in_array($cart_item->id, $offer_applied_cart_product_id)) {
                $is_category_item_found = true;
                $category_applies_priceInfo = getPrice($cart_item->id);
                $category_applies_actualPrice = $category_applies_priceInfo['price'];
                $category_applies_totalValue = $cart_item->qty * $category_applies_actualPrice;
                if ($category_applies_totalValue > $highest_price) {
                    $highest_price = $category_applies_totalValue;
                    $highest_price_product_id = $category_assign_item;
                }
            }
        }
    }
    if (!in_array($offer->id, $applied_offer_id)) {
        if ($is_category_item_found) {
            $cart_item = Cart::instance('cart')
            ->search(function ($cartItem) use ($highest_price_product_id) {
                return $cartItem->id === $highest_price_product_id;
            })
            ->first();
            if ($cart_item != null && !in_array($cart_item->id, $offer_applied_cart_product_id) && ($appliesItems->min_qnty != 0 && $cart_item->qty >= $appliesItems->min_qnty) && ($appliesItems->min_amount != 0 || $highest_price * $cart_item->qty >= $appliesItems->min_amount)) {
                $applies_priceInfo = getPrice($highest_price_product_id);
                $applies_actualPrice = $applies_priceInfo['price'];
                $applies_totalValue = $cart_item->qty * $applies_actualPrice;
                $discount = $offer->discount_type == 'Percentage' ? ($cart_item->subtotal * $offer->discount_value) / 100 : $offer->discount_value;
                $finalPrice = max(0, $applies_totalValue - $discount);
                Cart::instance('cart')->update($cart_item->rowId, [
                    'options' => array_merge($cart_item->options->all(), ['discount_price' => $finalPrice, 'offer_id' => $offer->id, 'offer_applied_id' => $appliesItems->id, 'offer_trigger_id' => $triggerProduct['id']]),
                ]);
                $applied_offer_id[] = $offer->id;
                $offer_applied_cart_product_id[] = $cart_item->id;
                session()->put('offer_applied_id', $cart_item->name);
            } else {
                $to_be_applied_offer_id['category'][$offer->id][$appliesItems->refrence_id] = [
                    'discount' => $offer->discount_type == 'Percentage' ? $offer->discount_value . '%' : '₹' . $offer->discount_value,
                    'minimum' => $appliesItems->min_qnty != 0 ? "Buy {$appliesItems->min_qnty} quantity in one item" : "Buy more than ₹{$appliesItems->min_amount}",
                    'name' => $getCategoryItem->name,
                ];
            }
        } else {
            $to_be_applied_offer_id['category'][$offer->id][$appliesItems->refrence_id] = [
                'discount' => $offer->discount_type == 'Percentage' ? $offer->discount_value . '%' : '₹' . $offer->discount_value,
                'minimum' => $appliesItems->min_qnty != 0 ? "Buy {$appliesItems->min_qnty} quantity in one item" : "Buy more than ₹{$appliesItems->min_amount}",
                'name' => $getCategoryItem->name,
            ];
        }
    }
}

function appliesBrandFunctionCheck($productId, $appliesItems, $offer, $triggerProduct, &$applied_offer_id, &$to_be_applied_offer_id, &$offer_applied_cart_product_id)
{
    $getbrandItem = Brand::find($appliesItems->refrence_id);
    $brand_assign = ProductBrand::where('brand_id', $getbrandItem->id)->pluck('product_id')->toArray();
    $is_brand_item_found = false;
    $highest_price_product_id = '';
    $highest_price = 0;

    
    foreach ($brand_assign as $brand_assign_item) {
        $cart_item = Cart::instance('cart')
        ->search(function ($cartItem) use ($brand_assign_item, $productId) {
            return $cartItem->id === $brand_assign_item && $cartItem->id != $productId;
        })
        ->first();
        if ($cart_item != null) {
            if (!$cart_item->options->has('offer_id') && !in_array($cart_item->id, $offer_applied_cart_product_id)) {
                $is_brand_item_found = true;
                $brand_applies_priceInfo = getPrice($cart_item->id);
                $brand_applies_actualPrice = $brand_applies_priceInfo['price'];
                $brand_applies_totalValue = $cart_item->qty * $brand_applies_actualPrice;
                if ($brand_applies_totalValue > $highest_price) {
                    $highest_price = $brand_applies_totalValue;
                    $highest_price_product_id = $brand_assign_item;
                }
            }
        }
    }
    if (!in_array($offer->id, $applied_offer_id)) {
        if ($is_brand_item_found) {
            $cart_item = Cart::instance('cart')
            ->search(function ($cartItem) use ($highest_price_product_id) {
                return $cartItem->id === $highest_price_product_id;
            })
            ->first();
            if ($cart_item != null && !in_array($cart_item->id, $offer_applied_cart_product_id) && ($appliesItems->min_qnty != 0 && $cart_item->qty >= $appliesItems->min_qnty) && ($appliesItems->min_amount != 0 || $highest_price * $cart_item->qty >= $appliesItems->min_amount)) {
                $applies_priceInfo = getPrice($highest_price_product_id);
                $applies_actualPrice = $applies_priceInfo['price'];
                $applies_totalValue = $cart_item->qty * $applies_actualPrice;
                $discount = $offer->discount_type == 'Percentage' ? ($cart_item->subtotal * $offer->discount_value) / 100 : $offer->discount_value;
                $finalPrice = max(0, $applies_totalValue - $discount);
                Cart::instance('cart')->update($cart_item->rowId, [
                    'options' => array_merge($cart_item->options->all(), ['discount_price' => $finalPrice, 'offer_id' => $offer->id, 'offer_applied_id' => $appliesItems->id, 'offer_trigger_id' => $triggerProduct['id']]),
                ]);
                $applied_offer_id[] = $offer->id;
                $offer_applied_cart_product_id[] = $cart_item->id;
                session()->put('offer_applied_id', $cart_item->name);
            } else {
                $to_be_applied_offer_id['brand'][$offer->id][$appliesItems->refrence_id] = [
                    'discount' => $offer->discount_type == 'Percentage' ? $offer->discount_value . '%' : '₹' . $offer->discount_value,
                    'minimum' => $appliesItems->min_qnty != 0 ? "Buy {$appliesItems->min_qnty} quantity in one item" : "Buy more than ₹{$appliesItems->min_amount}",
                    'name' => $getbrandItem->name,
                ];
            }
        } else {
            $to_be_applied_offer_id['brand'][$offer->id][$appliesItems->refrence_id] = [
                'discount' => $offer->discount_type == 'Percentage' ? $offer->discount_value . '%' : '₹' . $offer->discount_value,
                'minimum' => $appliesItems->min_qnty != 0 ? "Buy {$appliesItems->min_qnty} quantity in one item" : "Buy more than ₹{$appliesItems->min_amount}",
                'name' => $getbrandItem->name,
            ];
        }
    }
}

function appliesLeastPriceFunctionCheck($productId, $offer, $triggerProduct, $appliesItems, &$applied_offer_id, &$to_be_applied_offer_id, &$offer_applied_cart_product_id)
{
    $cart_items = Cart::instance('cart')
        ->search(function ($cartItem) use ($productId) {
            return $cartItem->id != $productId;
        });

    if ($cart_items != null) {
        $lowest_product_id = '';
        $lowest_price = 0;
        foreach ($cart_items as $cart_item) {
            $applies_priceInfo = getPrice($cart_item->id);
            $applies_actualPrice = $applies_priceInfo['price'];
            $applies_totalValue = $cart_item->qty * $applies_actualPrice;
            if ($applies_totalValue > $lowest_price && !in_array($cart_item->id, $offer_applied_cart_product_id)) {
                $lowest_price = $applies_totalValue;
                $lowest_product_id = $cart_item->id;
            }
        }
        $cart_item = Cart::instance('cart')
            ->search(function ($cartItem) use ($lowest_product_id, $productId) {
                return $cartItem->id === $lowest_product_id && $cartItem->id != $productId;
            })
            ->first();
        if ($cart_item != null) {
            $applies_priceInfo = getPrice($lowest_product_id);
            $applies_actualPrice = $applies_priceInfo['price'];
            $applies_totalValue = $cart_item->qty * $applies_actualPrice;
            $discount = $offer->discount_type == 'Percentage' ? ($cart_item->subtotal * $offer->discount_value) / 100 : $offer->discount_value;
            $finalPrice = max(0, $applies_totalValue - $discount);
            Cart::instance('cart')->update($cart_item->rowId, [
                'options' => array_merge($cart_item->options->all(), ['discount_price' => $finalPrice, 'offer_id' => $offer->id, 'offer_applied_id' => $appliesItems->id, 'offer_trigger_id' => $triggerProduct['id']]),
            ]);
            $applied_offer_id[] = $offer->id;
            $offer_applied_cart_product_id[] = $cart_item->id;
            session()->put('offer_applied_id', $cart_item->name);
        }
    }
}