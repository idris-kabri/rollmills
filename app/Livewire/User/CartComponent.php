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
    public $totalOfferDiscountedPrice = 0;
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

    // --- NEW VARIABLES ---
    public $minimum_order_value = 1000;
    public $discount_percentage = 15;
    public $maximum_extra_discount_amount = 500; // NEW: Maximum allowed discount cap
    public $extra_discount = 0;

    public $surprise_gift_amount = 0;
    public $surprise_gift_product_id = null;
    public $productCategoryIds = [];
    public $flat_rate = 0;

    public $confirmMessage = '';
    public $confirmAction = '';

    public function askRemove($rowId)
    {
        $this->confirmMessage = 'Are you sure you want to remove this item from your cart?';
        $this->confirmAction = "removeFromCart('$rowId')";

        $this->dispatch('open-cart-remove-item-modal');
    }

    public function mount()
    {
        $items = [];
        $this->minimum_order_value = Setting::where('label', 'extra_discount_order_value')->first()->value;
        $this->discount_percentage = Setting::where('label', 'extra_discount')->first()->value;
        $this->maximum_extra_discount_amount = Setting::where('label', 'maximum_extra_discount')->first()->value;
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

            $itemData = [
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
                    $itemData['item_category'] = $category->category->name;
                } else {
                    $itemData['item_category' . $key + 1] = $category->category->name;
                }
            }

            $itemData['item_list_id'] = '';
            $itemData['item_list_name'] = '';
            if ($product->attributes_name != null) {
                $attributes = explode(',', $product->attributes_name);
                foreach ($attributes as $key => $attribute) {
                    $itemData['item_variant'] = $attribute;
                }
            }
            $itemData['location_id'] = '';
            $itemData['price'] = (float) $price;
            $itemData['quantity'] = $quantity;

            $items[] = $itemData;
        }
        if (session()->has('shipping_pincode') && session('shipping_pincode') != null) {
            $this->pincode = session('shipping_pincode');
        }
        $this->productCategoryIds = array_unique($this->productCategoryIds);
        $this->dispatch('view-cart', ['items' => $items, 'total' => Cart::instance('cart')->total()]);

        $giftAmountSetting = Setting::where('label', 'surprise_gift_minimum_amount')->first();
        $this->surprise_gift_amount = $giftAmountSetting ? (int) $giftAmountSetting->value : 0;

        $giftProductSetting = Setting::where('label', 'surprise_gift_product_id')->first();
        $this->surprise_gift_product_id = $giftProductSetting ? $giftProductSetting->value : null;

        $flatRateSetting = Setting::where('label', 'Flat Rate')->first();
        if ($flatRateSetting) {
            $this->flat_rate = (int) $flatRateSetting->value;
            session()->put('flat_rate_charge', (int) $this->flat_rate);
        }

        $this->checkSurpriseGift();
    }

    public function applyCoupon($show_dispatch_event = 'no')
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $checkCuponCode = Coupon::where('coupon_code', $this->couponCode)->first();

        if (!$checkCuponCode) {
            $this->toastError('This Coupon Code Not Exists!');
            return false;
        }

        $orderCount = Order::where('coupon_id', $checkCuponCode->id)->where('status', 1)->count();

        if ($checkCuponCode->start_date != null) {
            $start_date = Carbon::parse($checkCuponCode->start_date);
            $todays_date = Carbon::now();
            if ($start_date->gt($todays_date)) {
                $this->toastError('You can use these coupon after ' . Carbon::parse($checkCuponCode->start_date)->format('d M Y'));
                return false;
            }
        }

        if ((int) $checkCuponCode->total_usage <= $orderCount) {
            $this->toastError('This Coupon has been Expired!!!');
            return false;
        }

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

        $couponCategoryIds = explode(',', $checkCuponCode->category);
        $cartItems = Cart::instance('cart')->content();
        $eligibleProductsTotal = 0;
        $eligibleProductCount = 0;

        foreach ($cartItems as $item) {
            if ($checkCuponCode->category != '' && $checkCuponCode->category != null) {
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

        if ($eligibleProductsTotal == 0) {
            $this->toastError('No products in cart belong to the coupon category.');
            return;
        }

        if ($eligibleProductsTotal < (float) $checkCuponCode->minimum_order_value) {
            $this->toastError('Minimum order value must be ₹' . number_format($checkCuponCode->minimum_order_value) . ' for products in coupon category.');
            return;
        }

        if (!Carbon::parse($checkCuponCode->expiry_date)->gt(Carbon::now())) {
            $this->toastError('This Coupon Is Expired!');
            return;
        }

        if ($checkCuponCode->discount_type == 'Percentage') {
            $discountAmount = ($eligibleProductsTotal * $checkCuponCode->discount_value) / 100;

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

        if ($this->couponCode != session()->get('coupon_code')) {
            $this->dispatch('coupon-applied');
        }

        session()->put('coupon_discount_amount', $this->mainDiscountAmount);
        session()->put('coupon_discount_id', $checkCuponCode->id);
        session()->put('coupon_code', $this->couponCode);

        return true;
    }

    public function fetchDisplayCoupons()
    {
        $cartTotal = (float) str_replace(',', '', Cart::total());
        $display_coupons = [];
        $currentDate = Carbon::now()->format('Y-m-d');

        $global_coupons = Coupon::where('is_global', 1)->where('expiry_date', '>', $currentDate)->get();

        foreach ($global_coupons as $coupon) {
            $totalUsage = Order::where('coupon_id', $coupon->id)->count();
            if ($totalUsage >= $coupon->total_usage) {
                continue;
            }

            if (Auth::check() && $coupon->usage_limit > 0) {
                $userUsage = Order::where('coupon_id', $coupon->id)->where('logged_in_user_id', Auth::id())->count();
                if ($userUsage >= $coupon->usage_limit) {
                    continue;
                }
            }

            $display_coupons[] = $coupon;
        }

        if (Auth::check()) {
            $user_coupons = Coupon::where('is_global', 0)->whereNotNull('order_id')->where('expiry_date', '>', $currentDate)->join('orders', 'coupons.order_id', '=', 'orders.id')->where('orders.logged_in_user_id', Auth::id())->select('coupons.*')->get();

            foreach ($user_coupons as $coupon) {
                $totalUsage = Order::where('coupon_id', $coupon->id)->count();
                if ($totalUsage >= $coupon->total_usage) {
                    continue;
                }

                $userUsage = Order::where('coupon_id', $coupon->id)->where('logged_in_user_id', Auth::id())->count();
                if ($userUsage >= $coupon->usage_limit) {
                    continue;
                }

                $display_coupons[] = $coupon;
            }
        }

        $non_global_coupons = Coupon::where('is_global', 0)
            ->whereNull('order_id')
            ->where('expiry_date', '>', $currentDate)
            ->where(function ($query) {
                $query->whereNull('category');
                if (!empty($this->productCategoryIds)) {
                    $query->orWhere(function ($subQuery) {
                        foreach ($this->productCategoryIds as $id) {
                            $subQuery->orWhereRaw('FIND_IN_SET(?, category)', [$id]);
                        }
                    });
                }
            })
            ->get();

        foreach ($non_global_coupons as $coupon) {
            if ($cartTotal < $coupon->minimum_order_value) {
                continue;
            }

            $totalUsage = Order::where('coupon_id', $coupon->id)->count();
            if ($totalUsage >= $coupon->total_usage) {
                continue;
            }

            if (Auth::check() && $coupon->usage_limit > 0) {
                $userUsage = Order::where('coupon_id', $coupon->id)->where('logged_in_user_id', Auth::id())->count();
                if ($userUsage >= $coupon->usage_limit) {
                    continue;
                }
            }

            $display_coupons[] = $coupon;
        }

        return $display_coupons;
    }

    public function checkSurpriseGift()
    {
        if (!$this->surprise_gift_product_id) {
            return;
        }
        $giftProductId = $this->surprise_gift_product_id;
        $threshold = (float) $this->surprise_gift_amount;

        $currentCartTotal = 0;
        $existingGiftRowId = null;

        foreach (Cart::instance('cart')->content() as $item) {
            if (isset($item->options['is_gift_product']) && $item->options['is_gift_product'] == true) {
                $existingGiftRowId = $item->rowId;
                continue;
            }
            $currentCartTotal += $item->price * $item->qty;
        }

        if ($currentCartTotal >= $threshold) {
            if (!$existingGiftRowId) {
                $product = \App\Models\Product::find($giftProductId);

                if ($product) {
                    Cart::instance('cart')
                        ->add($product->id, $product->name, 1, 0, [
                            'is_gift_product' => true,
                            'featured_image' => $product->featured_image,
                            'discount_price' => 0,
                        ])
                        ->associate('App\Models\Product');

                    $this->dispatch('coupon-applied');
                    $this->dispatch('surprise-gift');
                }
            }
            if (!session()->has('free_gift') || session()->get('free_gift') == false) {
                session()->put('free_gift', true);
                $this->dispatch('surprise-gift');
            }
        } else {
            if ($existingGiftRowId) {
                Cart::instance('cart')->remove($existingGiftRowId);
            }
            if (session()->has('free_gift')) {
                session()->forget('free_gift');
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
                $itemData = [
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
                        $itemData['item_category'] = $category->category->name;
                    } else {
                        $itemData['item_category' . $key + 1] = $category->category->name;
                    }
                }

                $itemData['item_list_id'] = '';
                $itemData['item_list_name'] = '';
                if ($product->attributes_name != null) {
                    $attributes = explode(',', $product->attributes_name);
                    foreach ($attributes as $key => $attribute) {
                        $itemData['item_variant'] = $attribute;
                    }
                }
                $itemData['location_id'] = '';
                $itemData['price'] = (float) $price;
                $itemData['quantity'] = $qty;

                $items[] = $itemData;
                $this->dispatch('add-to-cart', $items);

                if (session('coupon_discount_id')) {
                    $this->applyCoupon();
                }
            }
        }
        $this->checkSurpriseGift();
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
                $itemData = [
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
                        $itemData['item_category'] = $category->category->name;
                    } else {
                        $itemData['item_category' . $key + 1] = $category->category->name;
                    }
                }

                $itemData['item_list_id'] = '';
                $itemData['item_list_name'] = '';
                if ($product->attributes_name != null) {
                    $attributes = explode(',', $product->attributes_name);
                    foreach ($attributes as $key => $attribute) {
                        $itemData['item_variant'] = $attribute;
                    }
                }
                $itemData['location_id'] = '';
                $itemData['price'] = (float) $price;
                $itemData['quantity'] = $qty;

                $items[] = $itemData;
                $this->dispatch('add-to-cart', $items);

                if (session('coupon_discount_id')) {
                    $this->applyCoupon();
                }
            }
        }
        $this->checkSurpriseGift();
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
                $itemData = [
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
                        $itemData['item_category'] = $category->category->name;
                    } else {
                        $itemData['item_category' . $key + 1] = $category->category->name;
                    }
                }

                $itemData['item_list_id'] = '';
                $itemData['item_list_name'] = '';
                if ($product->attributes_name != null) {
                    $attributes = explode(',', $product->attributes_name);
                    foreach ($attributes as $key => $attribute) {
                        $itemData['item_variant'] = $attribute;
                    }
                }
                $itemData['location_id'] = '';
                $itemData['price'] = (float) $price;
                $itemData['quantity'] = $qty;

                $items[] = $itemData;
                $this->dispatch('add-to-cart', $items);

                if (session('coupon_discount_id')) {
                    $this->applyCoupon();
                }
            }
        }
        $this->checkSurpriseGift();
    }

    public function removeFromCart($rowId)
    {
        try {
            $item = Cart::instance('cart')->get($rowId);
        } catch (\Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException $e) {
            return;
        }
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
        $itemData = [
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
                $itemData['item_category'] = $category->category->name;
            } else {
                $itemData['item_category' . $key + 1] = $category->category->name;
            }
        }

        $itemData['item_list_id'] = '';
        $itemData['item_list_name'] = '';
        if ($product->attributes_name != null) {
            $attributes = explode(',', $product->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $itemData['item_variant'] = $attribute;
            }
        }
        $itemData['location_id'] = '';
        $itemData['price'] = (float) $price;
        $itemData['quantity'] = (float) $qty;

        $items[] = $itemData;
        $this->dispatch('remove-from-cart', $items);
        if ($removeCart) {
            $this->toastError('Product Remove Successfully From Your Cart!');
            $this->dispatch('close-cart-remove-item-modal');
        }

        $this->checkSurpriseGift();
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
            $this->checkout_button = true;
        }
    }

    public function checkCoupon($coupon_code)
    {
        $this->couponCode = $coupon_code;
        if ($this->couponCode != session()->get('coupon_code')) {
            $response = $this->applyCoupon('yes');
        } else {
            $response = $this->applyCoupon('no');
        }
        if (!$response) {
            $this->couponCode = '';
        }
    }

    public function render()
    {
        $giftAlreadyAdded = false;
        $currentCartTotal = 0;

        foreach (Cart::instance('cart')->content() as $item) {
            if (isset($item->options['is_gift_product']) && $item->options['is_gift_product'] == true) {
                $giftAlreadyAdded = true;
                continue;
            }
            $currentCartTotal += $item->price * $item->qty;
        }

        // --- UPDATED LOGIC FOR DYNAMIC DISCOUNT WITH CAP ---
        if ($currentCartTotal >= $this->minimum_order_value) {
            // Calculate percentage discount
            $calculated_discount = ($currentCartTotal * $this->discount_percentage) / 100;

            // Apply the min() function to ensure we don't exceed the maximum allowed discount
            $this->extra_discount = min($calculated_discount, $this->maximum_extra_discount_amount);

            session()->put('extra_discount', $this->extra_discount);
        } else {
            $this->extra_discount = 0;
            session()->forget('extra_discount');
        }

        $display_coupons = $this->fetchDisplayCoupons();

        return view('livewire.user.cart-component', compact('giftAlreadyAdded', 'display_coupons'))->layout('layouts.user.app');
    }
}
