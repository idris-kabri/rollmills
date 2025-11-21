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
    public $checkout_button = false;
    public $free_shipping = false;
    public $pincode = null;
    public $couponCode;
    public $out_of_stock_id = [];
    public $pincode_validation_id = [];
    public $mainDiscountAmount = 0;
    public $totalAfterDiscount = 0;
    public $triger_offer_product_array = [];
    public $triger_offer_brand_array = [];
    public $triger_offer_category_array = [];
    public $eligibleCategoryIds = [];
    public $eligibleBrandIds = [];
    public $eligibleProductIds = [];
    public $brandOfferMessages = [];
    public $getOfferTriggerButton = false;
    public $getOfferproductName = '';
    public $offerMessageKeys = [];
    public $lowestCouriers = [];
    public $latestEtd;
    public $applied_offer_id = [];
    public $to_be_applied_offer_id = [];
    public $offer_applied_cart_product_id = [];
    public $quantities = [];

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
        if (session()->has('shipping_pincode') && session('shipping_pincode') != null) {
            $this->pincode = session('shipping_pincode');
            $this->pincodeCheckFunction();
        }
        $this->dispatch('view-cart', ['items' => $items, 'total' => Cart::instance('cart')->total()]);
    }

    public function applyCoupon()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $checkCuponCode = Coupon::where('coupon_code', $this->couponCode)->first();

        session()->forget('coupon_discount_amount');
        session()->forget('coupon_discount_id');
        session()->forget('coupon_code');

        // Check if coupon exists
        if (!$checkCuponCode) {
            $this->toastError('This Coupon Code Not Exists!');
            return;
        }

        // Count total usage of this coupon
        $orderCount = Order::where('coupon_id', $checkCuponCode->id)->where('status', 1)->count();

        if ((int) $checkCuponCode->total_usage <= $orderCount) {
            $this->toastError('This Coupon has been Expired!!!');
            return;
        }

        // Check logged in user's usage if user is logged in
        if (Auth::check()) {
            $orderUserCount = Order::where('logged_in_user_id', Auth::user()->id)
                ->where('coupon_id', $checkCuponCode->id)
                ->where('status', 1)
                ->count();

            if ((int) $checkCuponCode->usage_limit <= $orderUserCount) {
                $this->toastError('Coupon Code Already Used');
                return;
            }
        }

        // Parse coupon categories (comma separated values)
        $couponCategoryIds = explode(',', $checkCuponCode->category);

        // Calculate total price of eligible products in cart
        $cartItems = Cart::instance('cart')->content();
        $eligibleProductsTotal = 0;
        $eligibleProductCount = 0;

        foreach ($cartItems as $item) {
            // Check if product belongs to coupon categories
            if ($checkCuponCode->category != '' && $checkCuponCode->category != null) {
                // Assume each product has categories relationship returning an array of category IDs
                $productCategoryIds = ProductCategoryAssign::where('product_id', $item->model->id)->pluck('category_id')->toArray();
                if (array_intersect($couponCategoryIds, $productCategoryIds)) {
                    $eligibleProductsTotal += $item->price * $item->qty;
                    $eligibleProductCount += $item->qty;
                }
            } else {
                $eligibleProductsTotal += $item->price * $item->qty;
                $eligibleProductCount += $item->qty;
            }
        }

        // If no eligible product found in cart for coupon categories
        if ($eligibleProductsTotal == 0) {
            $this->toastWarning('No products in cart belong to the coupon category.');
            return;
        }

        // Check minimum order value on eligible products total
        if ($eligibleProductsTotal < (float) $checkCuponCode->minimum_order_value) {
            $this->toastWarning('Minimum order value must be ₹' . number_format($checkCuponCode->minimum_order_value) . ' for products in coupon category.');
            return;
        }

        // Check coupon expiry date using Carbon
        if (!Carbon::parse($checkCuponCode->expiry_date)->gt(Carbon::now())) {
            $this->toastWarning('This Coupon Is Expired!');
            return;
        }

        // Calculate discount amount
        if ($checkCuponCode->discount_type == 'Percentage') {
            $discountAmount = ($eligibleProductsTotal * $checkCuponCode->discount_value) / 100;

            // Cap it at maximum_discount_amount if applicable
            if ($discountAmount > $checkCuponCode->maximum_discount_amount) {
                $discountAmount = (float) $checkCuponCode->maximum_discount_amount;
            }
            $this->mainDiscountAmount = $discountAmount;
            $this->totalAfterDiscount = $eligibleProductsTotal - $this->mainDiscountAmount;
        } else {
            $flatDiscount = min((float) $checkCuponCode->discount_value, (float) $checkCuponCode->maximum_discount_amount);
            $this->mainDiscountAmount = $flatDiscount;
            $this->totalAfterDiscount = $eligibleProductsTotal - $this->mainDiscountAmount;
        }

        // Save coupon info in session
        session()->put('coupon_discount_amount', $this->mainDiscountAmount);
        session()->put('coupon_discount_id', $checkCuponCode->id);
        session()->put('coupon_code', $this->couponCode);

        $this->dispatch('coupon-applied');
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
                if ($this->pincode != null) {
                    $this->pincodeCheckFunction();
                }
                if (session('coupon_discount_id')) {
                    $this->applyCoupon();
                }
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
                if ($this->pincode != null) {
                    $this->pincodeCheckFunction();
                }
                if (session('coupon_discount_id')) {
                    $this->applyCoupon();
                }
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
                if ($this->pincode != null) {
                    $this->pincodeCheckFunction();
                }
                if (session('coupon_discount_id')) {
                    $this->applyCoupon();
                }
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
        $this->pincodeCheckFunction();
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
                    $this->toastSuccess('Charges Calculated Successfully!');
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
