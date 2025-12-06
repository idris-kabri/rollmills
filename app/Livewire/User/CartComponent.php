<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Traits\HasToastNotification;
use App\Models\ProductCategoryAssign;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
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
    public $display_coupons = [];
    public $surprise_gift_amount = 0;
    public $surprise_gift_product_id = null;
    public $productCategoryIds = [];
    public $flat_rate;

    public $confirmMessage = '';
    public $confirmAction = '';

    public function askRemove($rowId)
    {
        $this->confirmMessage = "Are you sure you want to remove this item from your cart?";
        $this->confirmAction  = "removeFromCart('$rowId')";

        $this->dispatch('open-cart-remove-item-modal');
    }

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
                $this->productCategoryIds[] = $category->category_id;
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
        $this->productCategoryIds = array_unique($this->productCategoryIds);
        $this->dispatch('view-cart', ['items' => $items, 'total' => Cart::instance('cart')->total()]);
        // $this->surprise_gift_amount = (int) Setting::where('label', 'surprise_gift_minimum_amount')->first()->value;
        $this->surprise_gift_product_id = Setting::where('label', 'surprise_gift_product_id')->first();
        $this->getDisplayCoupons();
        $this->checkSurpriseGift('no');
        $this->flat_rate = Setting::where('label', 'Flat Rate')->first(); 
        if($this->flat_rate){ 
            session()->put('shipping_charge', (int) $this->flat_rate->value);
        }
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
            return false;
        }

        // Count total usage of this coupon
        $orderCount = Order::where('coupon_id', $checkCuponCode->id)->where('status', 1)->count();

        if ((int) $checkCuponCode->total_usage <= $orderCount) {
            $this->toastError('This Coupon has been Expired!!!');
            return false;
        }

        // Check logged in user's usage if user is logged in
        if (Auth::check()) {
            $orderUserCount = Order::where('logged_in_user_id', Auth::user()->id)
                ->where('coupon_id', $checkCuponCode->id)
                ->where('status', 1)
                ->count();

            if ((int) $checkCuponCode->usage_limit <= $orderUserCount) {
                $this->toastError('Coupon Code Already Used');
                return false;
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
            $this->toastError('No products in cart belong to the coupon category.');
            return;
        }

        // Check minimum order value on eligible products total
        if ($eligibleProductsTotal < (float) $checkCuponCode->minimum_order_value) {
            $this->toastError('Minimum order value must be ₹' . number_format($checkCuponCode->minimum_order_value) . ' for products in coupon category.');
            return;
        }

        // Check coupon expiry date using Carbon
        if (!Carbon::parse($checkCuponCode->expiry_date)->gt(Carbon::now())) {
            $this->toastError('This Coupon Is Expired!');
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

        return true;
    }

    public function getDisplayCoupons()
    {
        $cartTotal = (float) str_replace(',', '', Cart::total());
        $display_coupons = [];
        $currentDate = Carbon::now()->format('Y-m-d');

        // First Condition: Global Coupons
        $global_coupons = Coupon::where('is_global', 1)->where('expiry_date', '>', $currentDate)->get();

        foreach ($global_coupons as $coupon) {
            // Check total usage limit
            $totalUsage = Order::where('coupon_id', $coupon->id)->count();
            if ($totalUsage >= $coupon->total_usage) {
                // dd($coupon, $coupon->total_usage, $totalUsage);
                continue;
            }

            // Check user-specific usage if logged in
            if (Auth::check() && $coupon->usage_limit > 0) {
                $userUsage = Order::where('coupon_id', $coupon->id)->where('logged_in_user_id', Auth::id())->count();
                if ($userUsage >= $coupon->usage_limit) {
                    continue;
                }
            }

            $display_coupons[] = $coupon;
        }

        // Second Condition: User-Specific Coupons
        if (Auth::check()) {
            $user_coupons = Coupon::where('is_global', 0)->whereNotNull('order_id')->where('expiry_date', '>', $currentDate)->join('orders', 'coupons.order_id', '=', 'orders.id')->where('orders.logged_in_user_id', Auth::id())->get();

            foreach ($user_coupons as $coupon) {
                // Check total usage limit
                $totalUsage = Order::where('coupon_id', $coupon->id)->count();
                if ($totalUsage >= $coupon->total_usage) {
                    continue;
                }

                // Check user-specific usage
                $userUsage = Order::where('coupon_id', $coupon->id)->where('logged_in_user_id', Auth::id())->count();
                if ($userUsage >= $coupon->usage_limit) {
                    continue;
                }

                $display_coupons[] = $coupon;
            }
        }
        // New Code
        $non_global_coupons = Coupon::where('is_global', 0)
            ->whereNull('order_id')
            ->where('expiry_date', '>', $currentDate)
            ->where(function ($query) {
                // 1. Allow coupons defined for ALL categories (null)
                $query->whereNull('category');

                // 2. Loop through every category in the cart and check if it matches the coupon
                if (!empty($this->productCategoryIds)) {
                    $query->orWhere(function ($subQuery) {
                        foreach ($this->productCategoryIds as $id) {
                            // Check if this specific ID exists in the comma-separated DB column
                            $subQuery->orWhereRaw('FIND_IN_SET(?, category)', [$id]);
                        }
                    });
                }
            })
            ->get();

        foreach ($non_global_coupons as $coupon) {
            // Check minimum order value
            if ($cartTotal < $coupon->minimum_order_value) {
                continue;
            }

            // Check total usage limit
            $totalUsage = Order::where('coupon_id', $coupon->id)->count();
            if ($totalUsage >= $coupon->total_usage) {
                continue;
            }

            // Check user-specific usage
            if (Auth::check() && $coupon->usage_limit > 0) {
                $userUsage = Order::where('coupon_id', $coupon->id)->where('logged_in_user_id', Auth::id())->count();
                if ($userUsage >= $coupon->usage_limit) {
                    continue;
                }
            }

            $display_coupons[] = $coupon;
        }

        $this->display_coupons = $display_coupons;
    }

    public function checkSurpriseGift($value = 'yes')
    {
        // 1. Validate that the setting exists and has a value
        if (!$this->surprise_gift_product_id || empty($this->surprise_gift_product_id->value)) {
            return;
        }

        $giftProductId = $this->surprise_gift_product_id->value;
        $threshold = $this->surprise_gift_amount;

        // 2. Calculate Current Cart Total (Excluding the gift itself)
        $currentCartTotal = 0;
        $existingGiftRowId = null;

        foreach (Cart::instance('cart')->content() as $item) {
            // Check if this specific row is our automated gift
            if (isset($item->options['is_gift_product']) && $item->options['is_gift_product'] == true) {
                $existingGiftRowId = $item->rowId;
                continue; // Do not add the gift value to the total calculation
            }

            // Calculate total of normal items
            $currentCartTotal += $item->price * $item->qty;
        }

        // 3. Compare Total vs Threshold
        if ($currentCartTotal >= $threshold) {
            // User is ELIGIBLE for the gift
            if (!$existingGiftRowId) {
                // Fetch the product details from DB
                $product = \App\Models\Product::find($giftProductId);

                if ($product) {
                    Cart::instance('cart')
                        ->add(
                            $product->id,
                            $product->name,
                            1, // Quantity
                            0, // Price
                            [
                                'is_gift_product' => true,
                                'featured_image' => $product->featured_image,
                                'discount_price' => 0,
                            ],
                        )
                        ->associate('App\Models\Product');
                }
            }
            $total = floatval(str_replace(',', '', Cart::total()));
            $remain_amount = 0;

            if ($this->surprise_gift_amount > 0) {

                if ($total >= $this->surprise_gift_amount) {
                    $percentage = 100;
                    $remain_amount = 0;
                } else {
                    $percentage = ($total / $this->surprise_gift_amount) * 100;
                    $remain_amount = $this->surprise_gift_amount - $total;
                }
            } else {
                // Fallback if surprise_gift_amount is 0 or null
                $percentage = 0;
                $remain_amount = 0;
            }
        } else {
            // User is NOT ELIGIBLE (Total is too low)
            if ($existingGiftRowId) {
                // Remove the gift if it exists
                Cart::instance('cart')->remove($existingGiftRowId);
            }
            if ($value == 'yes') {
                $this->dispatch('surprise-gift');
            }
        }
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
        $this->checkSurpriseGift();
        $this->getDisplayCoupons();
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
        $this->checkSurpriseGift();
        $this->getDisplayCoupons();
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
        $this->checkSurpriseGift();
        $this->getDisplayCoupons();
    }

    public function removeFromCart($rowId)
    {
        $qty = Cart::instance('cart')->get($rowId)->qty;
        $productId = Cart::instance('cart')->get($rowId)->model->id;
        $removeCart = finalRemoveFromCart($rowId);
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
            $this->dispatch('close-cart-remove-item-modal');
        }
        // $this->offerCheckEligibility();
        $this->pincodeCheckFunction();
        $this->checkSurpriseGift();
        $this->getDisplayCoupons();
    }

    public function pincodeCheckFunction($show_toast = 'no')
    {
        $checkoutconditionFail = false;

        if ($this->pincode == '' && $show_toast == 'yes') {
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
                session()->put('latest_etd', '5 to 7 days');
                session()->put('shipping_bear_margin', 0);

                // $checkoutconditionFail = calculateRates($cart_items, $this->pincode);
                // if ($checkoutconditionFail) {
                //     $this->toastError('Sorry ! Delivery is currently unavailable to the selected pincode.');
                // } else {
                //     $this->free_shipping = false;
                session()->forget('free_shipping_pincode');
                session()->put('show_deleviery_time', true);
                if ($show_toast == 'yes') {
                    $this->toastSuccess('Charges Calculated Successfully!');
                }
                // }
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

    public function checkCoupon($coupon_code)
    {
        $this->couponCode = $coupon_code;
        $response = $this->applyCoupon();
        if (!$response) {
            $this->couponCode = '';
        }
    }

    public function render()
    {
        return view('livewire.user.cart-component')->layout('layouts.user.app');
    }
}
