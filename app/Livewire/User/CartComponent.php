<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Traits\HasToastNotification;
use App\Models\ProductCategoryAssign;
use App\Models\Setting;
use Cart;
use Carbon\Carbon;

class CartComponent extends Component
{
    use HasToastNotification;
    public $quantities = [];
    public $pincode;

    public function mount()
    {
        $items = [];
        foreach (Cart::instance('cart')->content() as $item) {
            $this->quantities[$item->rowId] = $item->qty;
            $quantity = $item->qty;
            $product = $item->model;
            $sale_price = 0;
            $currentDate = Carbon::now();
            $sale_from_date = Carbon::parse($product->sale_from_date);
            $sale_to_date = Carbon::parse($product->sale_to_date);

            if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
                $sale_price = $product->sale_price;
            } else {
                $sale_price = $product->sale_default_price;
            }
            $price = $product->price;
            $discount = 0;
            if ($sale_price > 0) {
                $price = $sale_price;
                $discount = $product->price > $sale_price ? round($product->price - $sale_price) : 0;
            }
            $category_assign = ProductCategoryAssign::where('product_id', $product->id)->orderBy('category_id', 'asc')->get();

            $item = [
                'item_id' => $product->id,
                'item_name' => $product->name,
                'affiliation' => '',
                'coupon' => '',
                'discount' => (float) $discount,
                'index' => 0,
                'item_brand' => 'Roll Mills',
            ];

            foreach ($category_assign as $key => $category) {
                if ($key == 0) {
                    $item['item_category'] = $category->category->name;
                } else {
                    $item['item_category' . $key + 1] = $category->category->name;
                }
            }

            $item['item_list_id'] = '';
            $item['item_list_name'] = '';
            if ($product->attributes_name != null) {
                $attributes = explode(',', $product->attributes_name);
                foreach ($attributes as $key => $attribute) {
                    $item['item_variant'] = $attribute;
                }
            }
            $item['location_id'] = '';
            $item['price'] = (float) $price;
            $item['quantity'] = $quantity;

            $items[] = $item;
        }
        $this->dispatch('view-cart', ['items' => $items, 'total' => Cart::instance('cart')->total()]);
    }

    public function incrementQuantity($rowId)
    {
        if ($rowId) {
            $cart_check = Cart::instance('cart')
                ->search(function ($cartItem) use ($rowId) {
                    return $cartItem->rowId === $rowId;
                })
                ->first();

            if ($cart_check) {
                $item = Cart::instance('cart')->get($rowId);
                $product = $item->model;
                $qty = $item->qty + 1;
                $this->quantities[$rowId] = $qty;
                finalAddToCart($product, $qty, 'update-quantity');
                $sale_price = 0;
                $currentDate = Carbon::now();
                $sale_from_date = Carbon::parse($product->sale_from_date);
                $sale_to_date = Carbon::parse($product->sale_to_date);

                if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
                    $sale_price = $product->sale_price;
                } else {
                    $sale_price = $product->sale_default_price;
                }
                $price = $product->price;
                $discount = 0;
                if ($sale_price > 0) {
                    $price = $sale_price;
                    $discount = $product->price > $sale_price ? round($product->price - $sale_price) : 0;
                }
                $category_assign = ProductCategoryAssign::where('product_id', $product->id)->orderBy('category_id', 'asc')->get();

                $items = [];
                $item = [
                    'item_id' => $product->id,
                    'item_name' => $product->name,
                    'affiliation' => '',
                    'coupon' => '',
                    'discount' => (float) $discount,
                    'index' => 0,
                    'item_brand' => 'Roll Mills',
                ];

                foreach ($category_assign as $key => $category) {
                    if ($key == 0) {
                        $item['item_category'] = $category->category->name;
                    } else {
                        $item['item_category' . $key + 1] = $category->category->name;
                    }
                }

                $item['item_list_id'] = '';
                $item['item_list_name'] = '';
                if ($product->attributes_name != null) {
                    $attributes = explode(',', $product->attributes_name);
                    foreach ($attributes as $key => $attribute) {
                        $item['item_variant'] = $attribute;
                    }
                }
                $item['location_id'] = '';
                $item['price'] = (float) $price;
                $item['quantity'] = $qty;

                $items[] = $item;
                $this->dispatch('add-to-cart', $items);
                // $this->offerCheckEligibility();
                // if ($this->pincode != null) {
                //     $this->pincodeCheckFunction();
                // }
                // if (session('coupon_discount_id')) {
                //     $this->applyCoupon();
                // }
            }
        }
    }

    public function updateQuantity($rowId)
    {
        if ($rowId) {
            $cart_check = Cart::instance('cart')
                ->search(function ($cartItem) use ($rowId) {
                    return $cartItem->rowId === $rowId;
                })
                ->first();
            if ($cart_check) {
                $item = Cart::instance('cart')->get($rowId);
                $product = $item->model;
                $qty = $this->quantities[$rowId];
                finalAddToCart($product, $qty, 'update-quantity');
                $sale_price = 0;
                $currentDate = Carbon::now();
                $sale_from_date = Carbon::parse($product->sale_from_date);
                $sale_to_date = Carbon::parse($product->sale_to_date);

                if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
                    $sale_price = $product->sale_price;
                } else {
                    $sale_price = $product->sale_default_price;
                }
                $price = $product->price;
                $discount = 0;
                if ($sale_price > 0) {
                    $price = $sale_price;
                    $discount = $product->price > $sale_price ? round($product->price - $sale_price) : 0;
                }
                $category_assign = ProductCategoryAssign::where('product_id', $product->id)->orderBy('category_id', 'asc')->get();

                $items = [];
                $item = [
                    'item_id' => $product->id,
                    'item_name' => $product->name,
                    'affiliation' => '',
                    'coupon' => '',
                    'discount' => (float) $discount,
                    'index' => 0,
                    'item_brand' => 'Roll Mills',
                ];

                foreach ($category_assign as $key => $category) {
                    if ($key == 0) {
                        $item['item_category'] = $category->category->name;
                    } else {
                        $item['item_category' . $key + 1] = $category->category->name;
                    }
                }

                $item['item_list_id'] = '';
                $item['item_list_name'] = '';
                if ($product->attributes_name != null) {
                    $attributes = explode(',', $product->attributes_name);
                    foreach ($attributes as $key => $attribute) {
                        $item['item_variant'] = $attribute;
                    }
                }
                $item['location_id'] = '';
                $item['price'] = (float) $price;
                $item['quantity'] = $qty;

                $items[] = $item;
                $this->dispatch('add-to-cart', $items);
                // $this->offerCheckEligibility();
                // if ($this->pincode != null) {
                //     $this->pincodeCheckFunction();
                // }
                // if (session('coupon_discount_id')) {
                //     $this->applyCoupon();
                // }
            }
        }
    }

    public function decrementQuantity($rowId)
    {
        if ($rowId) {
            $cart_check = Cart::instance('cart')
                ->search(function ($cartItem) use ($rowId) {
                    return $cartItem->rowId === $rowId;
                })
                ->first();

            if ($cart_check) {
                $item = Cart::instance('cart')->get($rowId);
                $product = $item->model;
                $qty = $item->qty - 1;
                $this->quantities[$rowId] = $qty;
                finalAddToCart($product, $qty, 'update-quantity');
                $sale_price = 0;
                $currentDate = Carbon::now();
                $sale_from_date = Carbon::parse($product->sale_from_date);
                $sale_to_date = Carbon::parse($product->sale_to_date);

                if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
                    $sale_price = $product->sale_price;
                } else {
                    $sale_price = $product->sale_default_price;
                }
                $price = $product->price;
                $discount = 0;
                if ($sale_price > 0) {
                    $price = $sale_price;
                    $discount = $product->price > $sale_price ? round($product->price - $sale_price) : 0;
                }
                $category_assign = ProductCategoryAssign::where('product_id', $product->id)->orderBy('category_id', 'asc')->get();

                $items = [];
                $item = [
                    'item_id' => $product->id,
                    'item_name' => $product->name,
                    'affiliation' => '',
                    'coupon' => '',
                    'discount' => (float) $discount,
                    'index' => 0,
                    'item_brand' => 'Roll Mills',
                ];

                foreach ($category_assign as $key => $category) {
                    if ($key == 0) {
                        $item['item_category'] = $category->category->name;
                    } else {
                        $item['item_category' . $key + 1] = $category->category->name;
                    }
                }

                $item['item_list_id'] = '';
                $item['item_list_name'] = '';
                if ($product->attributes_name != null) {
                    $attributes = explode(',', $product->attributes_name);
                    foreach ($attributes as $key => $attribute) {
                        $item['item_variant'] = $attribute;
                    }
                }
                $item['location_id'] = '';
                $item['price'] = (float) $price;
                $item['quantity'] = $qty;

                $items[] = $item;
                $this->dispatch('add-to-cart', $items);
                // $this->offerCheckEligibility();
                // if ($this->pincode != null) {
                //     $this->pincodeCheckFunction();
                // }
                // if (session('coupon_discount_id')) {
                //     $this->applyCoupon();
                // }
            }
        }
    }

    public function removeFromCart($rowId)
    {
        $qty = Cart::instance('cart')->get($rowId)->qty;
        $removeCart = finalRemoveFromCart($rowId);
        $productId = Cart::instance('cart')->get($rowId)->model->id;
        $product = Product::find($productId);
        $sale_price = 0;
        $currentDate = Carbon::now();
        $sale_from_date = Carbon::parse($product->sale_from_date);
        $sale_to_date = Carbon::parse($product->sale_to_date);

        if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $product->sale_price;
        } else {
            $sale_price = $product->sale_default_price;
        }
        $price = $product->price;
        $discount = 0;
        if ($sale_price > 0) {
            $price = $sale_price;
            $discount = $product->price > $sale_price ? round($product->price - $sale_price) : 0;
        }
        $category_assign = ProductCategoryAssign::where('product_id', $product->id)->orderBy('category_id', 'asc')->get();

        $items = [];
        $item = [
            'item_id' => $product->id,
            'item_name' => $product->name,
            'affiliation' => '',
            'coupon' => '',
            'discount' => (float) $discount,
            'index' => 0,
            'item_brand' => 'Roll Mills',
        ];

        foreach ($category_assign as $key => $category) {
            if ($key == 0) {
                $item['item_category'] = $category->category->name;
            } else {
                $item['item_category' . $key + 1] = $category->category->name;
            }
        }

        $item['item_list_id'] = '';
        $item['item_list_name'] = '';
        if ($product->attributes_name != null) {
            $attributes = explode(',', $product->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $item['item_variant'] = $attribute;
            }
        }
        $item['location_id'] = '';
        $item['price'] = (float) $price;
        $item['quantity'] = (float) $qty;

        $items[] = $item;
        $this->dispatch('remove-from-cart', $items);
        if ($removeCart) {
            $this->toastError('Product Remove Successfully From Your Cart!');
        }
        // $this->offerCheckEligibility();
        // $this->pincodeCheckFunction();
    }

    public function pincodeCheckFunction()
    {
        $checkoutconditionFail = false;

        if ($this->pincode == '') {
            $this->toastError('Please Enter Pincode');
        }
        $setting = Setting::where('label', 'Pincode Out Of Delhivery')->first();
        if ($setting) {
            $outOfDeliveryPincodes = explode(',', $setting->value);

            if (in_array($this->pincode, $outOfDeliveryPincodes)) {
                $this->free_shipping = true;
                session()->put('free_shipping_pincode', $this->pincode);
                session()->forget('show_deleviery_time');
            } else {
                $cart_items = Cart::instance('cart')->content();

                $checkoutconditionFail = calculateRates($cart_items, $this->pincode);
                if ($checkoutconditionFail) {
                    $this->toastError('Sorry ! Delivery is currently unavailable to the selected pincode.');
                } else {
                    $this->free_shipping = false;
                    session()->forget('free_shipping_pincode');
                    session()->put('show_deleviery_time', true);
                }
            }
            session()->put('shipping_pincode', $this->pincode);
        }
        if (!$checkoutconditionFail) {
            $this->checkout_button = true;
            $this->checkoutCondition();
        } else {
            $this->checkout_button = false;
        }
    }

    public function checkoutCondition()
    {
        $this->out_of_stock_id = [];
        $this->pincode_validation_id = [];
        if ($this->pincode != null && $this->pincode != '') {
            $items = Cart::instance('cart')->content();
            foreach ($items as $item) {
                $product = $item->model;
                if ($product->out_of_stock == 1) {
                    $this->checkout_button = false;
                    $this->out_of_stock_id[] = $product->id;
                }

                if ($product->pincode_excluded != '' && $product->pincode_excluded != null) {
                    $pincodes = explode(',', $product->pincode_excluded);
                    if (count($pincodes) > 0) {
                        if (in_array($this->pincode, $pincodes)) {
                            $this->checkout_button = false;
                            $this->pincode_validation_id[] = $product->id;
                        }
                    }
                }
            }

            if (count($this->out_of_stock_id) <= 0 && count($this->pincode_validation_id) <= 0) {
                $this->checkout_button = true;
            } else {
                if (count($this->out_of_stock_id) > 0) {
                    $this->toastError('This product is currently out of stock.');
                }
                if (count($this->pincode_validation_id) > 0) {
                    $this->toastError('Delivery is currently unavailable to the selected pincode.');
                }
                $this->checkout_button = false;
            }
        } else {
            $this->checkout_button = false;
        }
    }

    public function render()
    {
        return view('livewire.user.cart-component')->layout('layouts.user.app');
    }
}
