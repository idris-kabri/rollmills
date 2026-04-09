<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Traits\HasToastNotification;
use App\Models\ProductCategoryAssign;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\Order;
use App\Models\Address;
use App\Models\GiftCardItem;
use App\Models\OrderItems;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Cart;
use Carbon\Carbon;

class CartComponent extends Component
{
    use HasToastNotification;

    // --- CART VARIABLES ---
    public $checkout_button = false;
    public $free_shipping = false;
    public $pincode = null;
    public $couponCode;
    public $out_of_stock_id = [];
    public $pincode_validation_id = [];
    public $mainDiscountAmount = 0;
    public $totalOfferDiscountedPrice = 0;
    public $totalAfterDiscount = 0;
    public $quantities = [];
    public $minimum_order_value = 1000;
    public $discount_percentage = 15;
    public $maximum_extra_discount_amount = 500;
    public $extra_discount = 0;
    public $surprise_gift_amount = 0;
    public $surprise_gift_product_id = null;
    public $productCategoryIds = [];
    public $flat_rate = 0;
    public $confirmMessage = '';
    public $confirmAction = '';

    // --- PAYMENT & PRICING VARIABLES ---
    public $payment_method = 'online';
    public $is_first_order = true;
    public $onlineDiscountAmount = 0;
    public $cash_on_delivery_amount = 0;
    public $online_payment_amount = 0;
    public $potentialOnlineTotal = 0;
    public $potentialCodTotal = 0;
    public $finalTotal = 0;
    public $offerDiscount = 0;

    // --- CHECKOUT / ADDRESS VARIABLES ---
    public $billing_address = [];
    public $ship_to_different_address = [];
    public $fetch_user_address = [];
    public $additional_information;
    public $add_new_address = false;
    public $add_new_shipp_address = false;
    public $ship_to_different_address_enabled = false;
    public $gift_cards_items = [];
    public $applied_gift_card_ids;
    public $gift_card_amount = 0;
    public $gift_card_code;
    public $item_sum_discount = 0;

    public function askRemove($rowId)
    {
        $this->confirmMessage = 'Are you sure you want to remove this item from your cart?';
        $this->confirmAction = "removeFromCart('$rowId')";
        $this->dispatch('open-cart-remove-item-modal');
    }

    public function mount()
    {
        $this->minimum_order_value = Setting::where('label', 'extra_discount_order_value')->first()->value ?? 1000;
        $this->discount_percentage = Setting::where('label', 'extra_discount')->first()->value ?? 15;
        $this->maximum_extra_discount_amount = Setting::where('label', 'maximum_extra_discount')->first()->value ?? 500;

        // if (session()->has('selected_payment_method')) {
        //     $this->payment_method = session('selected_payment_method');
        // }

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
            $itemData = [
                'item_id' => $product->id,
                'item_name' => $product->name,
                'discount' => (float) $discount,
                'price' => (float) $price,
                'quantity' => $quantity,
            ];

            foreach ($category_assign as $key => $category) {
                $this->productCategoryIds[] = $category->category_id;
            }
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

        $this->billing_address['zipcode'] = session('shipping_pincode');
        $this->ship_to_different_address['zipcode'] = session('shipping_pincode');

        if (Auth::check()) {
            $this->fetch_user_address = Address::where('user_id', Auth::user()->id)->get();
            if ($this->fetch_user_address->count() > 0) {
                $this->storeAddressInToBilling($this->fetch_user_address->first()->id);
                $this->add_new_address = false;
            } else {
                $this->add_new_address = true;
            }
        } else {
            $this->fetch_user_address = collect([]);
            $this->add_new_address = true;
        }
    }

    public function checkFirstOrder()
    {
        if (Auth::check()) {
            $this->is_first_order =
                Order::where('logged_in_user_id', Auth::id())
                    ->whereNotIn('status', [0, 4])
                    ->count() == 0;
        } else {
            $mobile_number = $this->billing_address['mobile'] ?? ($this->ship_to_different_address['mobile'] ?? '');

            if (!empty($mobile_number)) {
                $order_count = Order::where(function ($query) use ($mobile_number) {
                    $query->where('billing_address_details', 'LIKE', "%$mobile_number%")->orWhere('ship_different_address_details', 'LIKE', "%$mobile_number%");
                })
                    ->whereNotIn('status', [0, 4])
                    ->count();

                $this->is_first_order = $order_count == 0;
            } else {
                $this->is_first_order = true;
            }
        }
    }

    public function defaultShippingCharge()
    {
        $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $cod_charges = (int) (Setting::where('label', 'cod_charges')->first()->value ?? 15);
        $free_delivery_order_amount = (int) (Setting::where('label', 'free_delivery_order_amount')->first()->value ?? 499);
        $shipping_charges = (int) (session('flat_rate_charge') ?? (Setting::where('label', 'Flat Rate')->first()->value ?? 0));

        if ($cartSubtotal > $free_delivery_order_amount) {
            $this->online_payment_amount = 0;
        } else {
            $this->online_payment_amount = $shipping_charges;
        }

        $this->cash_on_delivery_amount = $cod_charges + $this->online_payment_amount;
    }

    public function paymentMethod($method)
    {
        $this->payment_method = $method;
        session()->put('selected_payment_method', $method);

        if ($method == 'cod') {
            session()->put('shipping_charge', ceil($this->cash_on_delivery_amount));
        } else {
            session()->put('shipping_charge', ceil($this->online_payment_amount));
        }
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

        foreach ($cartItems as $item) {
            if ($checkCuponCode->category != '' && $checkCuponCode->category != null) {
                $productCategoryIds = ProductCategoryAssign::where('product_id', $item->model->id)->pluck('category_id')->toArray();
                if (array_intersect($couponCategoryIds, $productCategoryIds)) {
                    $eligibleProductsTotal += $item->price * $item->qty;
                }
            } else {
                $eligibleProductsTotal += $item->price * $item->qty;
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
        } else {
            $flatDiscount = min((float) $checkCuponCode->discount_value, (float) $checkCuponCode->maximum_discount_amount);
            $this->mainDiscountAmount = $flatDiscount;
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
                $product = Product::find($giftProductId);
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
        $item = Cart::instance('cart')->get($rowId);
        if ($item) {
            $qty = $item->qty + 1;
            $this->quantities[$rowId] = $qty;
            finalAddToCart($item->model, $qty, 'update-quantity');
            if (session('coupon_discount_id')) {
                $this->applyCoupon();
            }
        }
        $this->checkSurpriseGift();
    }

    public function decrementQuantity($rowId)
    {
        $item = Cart::instance('cart')->get($rowId);
        if ($item) {
            $qty = $item->qty - 1;
            $this->quantities[$rowId] = $qty;
            finalAddToCart($item->model, $qty, 'update-quantity');
            if (session('coupon_discount_id')) {
                $this->applyCoupon();
            }
        }
        $this->checkSurpriseGift();
    }

    public function removeFromCart($rowId)
    {
        finalRemoveFromCart($rowId);
        $this->toastError('Product Remove Successfully From Your Cart!');
        $this->dispatch('close-cart-remove-item-modal');
        $this->checkSurpriseGift();
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

    // Calculates all dynamic values
    private function calculateTotals()
    {
        $this->checkFirstOrder();
        $this->defaultShippingCharge();

        $cartTotalRaw = (float) str_replace(',', '', Cart::instance('cart')->total());

        $currentCartTotal = 0;
        foreach (Cart::instance('cart')->content() as $item) {
            if (isset($item->options['is_gift_product']) && $item->options['is_gift_product'] == true) {
                continue;
            }
            $currentCartTotal += $item->price * $item->qty;
        }

        if ($currentCartTotal >= $this->minimum_order_value) {
            $calculated_discount = ($currentCartTotal * $this->discount_percentage) / 100;
            $this->extra_discount = min($calculated_discount, $this->maximum_extra_discount_amount);
            session()->put('extra_discount', $this->extra_discount);
        } else {
            $this->extra_discount = 0;
            session()->forget('extra_discount');
        }

        $totalOfferDiscount = 0;
        foreach (Cart::instance('cart')->content() as $item) {
            if (!empty($item->options['discount_price'])) {
                $totalOfferDiscount += $item->price * $item->qty - $item->options['discount_price'];
            }
        }
        $this->offerDiscount = $totalOfferDiscount;
        $this->mainDiscountAmount = (float) (session('coupon_discount_amount') ?? 0);

        if ($this->is_first_order) {
            $discount_percentage = fetchDiscountPercentage();
            $this->onlineDiscountAmount = round(($cartTotalRaw * $discount_percentage) / 100, 2);
        } else {
            $this->onlineDiscountAmount = 0;
        }

        $baseAfterRegularDiscounts = $cartTotalRaw - $this->offerDiscount - $this->mainDiscountAmount - $this->extra_discount;

        $this->potentialOnlineTotal = ceil($baseAfterRegularDiscounts - $this->onlineDiscountAmount + $this->online_payment_amount);
        $this->potentialCodTotal = ceil($baseAfterRegularDiscounts + $this->cash_on_delivery_amount);

        if ($this->payment_method == 'online') {
            $this->finalTotal = $this->potentialOnlineTotal;
            session()->put('shipping_charge', $this->online_payment_amount);
        } else {
            $this->finalTotal = $this->potentialCodTotal;
            session()->put('shipping_charge', $this->cash_on_delivery_amount);
        }

        if ($this->finalTotal < 0) {
            $this->finalTotal = 0;
        }
    }

    // ==========================================
    // CHECKOUT PRE-TRIGGER
    // ==========================================
    public function openCheckoutModal()
    {
        // Only open if there are items
        if (Cart::instance('cart')->count() == 0) {
            $this->toastError('Your cart is empty');
            return;
        }

        $items = [];
        foreach (Cart::instance('cart')->content() as $item) {
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

            $items[] = [
                'item_id' => $product->id,
                'item_name' => $product->name,
                'discount' => (float) $discount,
                'price' => (float) $price,
                'quantity' => $item->qty,
            ];
        }

        $this->dispatch('initiate-checkout', ['items' => $items, 'total' => Cart::instance('cart')->total()]);
        $this->dispatch('show-checkout-modal');
    }

    // ==========================================
    // ADDRESS & CHECKOUT METHODS
    // ==========================================
    public function addNewAddress()
    {
        $this->add_new_address = true;
        $this->billing_address = [];
        $this->billing_address['zipcode'] = session('shipping_pincode');
    }

    public function cancelNewAddress()
    {
        $this->add_new_address = false;
        if ($this->fetch_user_address->count() > 0) {
            $this->storeAddressInToBilling($this->fetch_user_address->first()->id);
        }
    }

    public function addNewShipAddress()
    {
        $this->add_new_shipp_address = true;
        $this->ship_to_different_address = [];
        $this->ship_to_different_address['zipcode'] = session('shipping_pincode');
    }

    public function cancelNewShipAddress()
    {
        $this->add_new_shipp_address = false;
    }

    public function ship_to_different_address_function()
    {
        $this->ship_to_different_address['zipcode'] = session('shipping_pincode');
        $this->ship_to_different_address_enabled = !$this->ship_to_different_address_enabled;
        if ($this->ship_to_different_address_enabled) {
            $this->add_new_shipp_address = false;
        }
    }

    public function storeAddressInToBilling($address_id)
    {
        $address = Address::find($address_id);
        if ($address) {
            $this->billing_address = [
                'id' => $address->id,
                'name' => $address->name,
                'mobile' => $address->mobile,
                'billing_address1' => $address->address_line_1,
                'billing_address2' => $address->address_line_2,
                'city' => $address->city,
                'state' => $address->state,
                'zipcode' => $address->zipcode,
            ];
            $this->add_new_address = false;
            $this->calculateTotals();
        }
    }

    public function storeAddressInToShipping($address_id)
    {
        $address = Address::find($address_id);
        if ($address) {
            $this->ship_to_different_address = [
                'id' => $address->id,
                'name' => $address->name,
                'mobile' => $address->mobile,
                'billing_address1' => $address->address_line_1,
                'billing_address2' => $address->address_line_2,
                'city' => $address->city,
                'state' => $address->state,
                'zipcode' => $address->zipcode,
            ];
            $this->add_new_shipp_address = false;
            $this->calculateTotals();
        }
    }

    public function billingAddressMobile()
    {
        if (isset($this->billing_address['mobile']) && $this->billing_address['mobile'] != null) {
            $value = str_replace(' ', '', $this->billing_address['mobile']);
            if (str_starts_with($value, '+91')) {
                $value = substr($value, 3);
            }
            if (str_starts_with($value, '91') && strlen($value) > 10) {
                $value = substr($value, 2);
            }
            if (str_starts_with($value, '0')) {
                $value = substr($value, 1);
            }
            $this->billing_address['mobile'] = $value;
            $this->calculateTotals();
        }
    }

    public function shippingAddressMobile()
    {
        if (isset($this->ship_to_different_address['mobile']) && $this->ship_to_different_address['mobile'] != null) {
            $value = str_replace(' ', '', $this->ship_to_different_address['mobile']);
            if (str_starts_with($value, '+91')) {
                $value = substr($value, 3);
            }
            if (str_starts_with($value, '91') && strlen($value) > 10) {
                $value = substr($value, 2);
            }
            if (str_starts_with($value, '0')) {
                $value = substr($value, 1);
            }
            $this->ship_to_different_address['mobile'] = $value;
            $this->calculateTotals();
        }
    }

    public function createBillingAddress($userId = null)
    {
        $address = isset($this->billing_address['id']) ? Address::find($this->billing_address['id']) ?? new Address() : new Address();
        $address->name = $this->billing_address['name'];
        $address->mobile = $this->billing_address['mobile'];
        $address->address_line_1 = $this->billing_address['billing_address1'];
        $address->address_line_2 = $this->billing_address['billing_address2'] ?? null;
        $address->city = $this->billing_address['city'];
        $address->state = $this->billing_address['state'];
        $address->zipcode = $this->billing_address['zipcode'];
        $address->ip_address = request()->ip();
        $address->is_user_logged_in_user = Auth::check() ? 1 : 0;
        $address->user_id = Auth::id() ?? $userId;
        $address->save();

        return [
            'id' => $address->id,
            'name' => $address->name,
            'mobile' => $address->mobile,
            'address_line_1' => $address->address_line_1,
            'address_line_2' => $address->address_line_2,
            'city' => $address->city,
            'state' => $address->state,
            'zipcode' => $address->zipcode,
        ];
    }

    public function createShippingAddress($userId = null)
    {
        $ship_different_address = isset($this->ship_to_different_address['id']) ? Address::find($this->ship_to_different_address['id']) ?? new Address() : new Address();
        $ship_different_address->name = $this->ship_to_different_address['name'];
        $ship_different_address->mobile = $this->ship_to_different_address['mobile'] ?? $this->billing_address['mobile'];
        $ship_different_address->address_line_1 = $this->ship_to_different_address['billing_address1'];
        $ship_different_address->address_line_2 = $this->ship_to_different_address['billing_address2'] ?? null;
        $ship_different_address->city = $this->ship_to_different_address['city'];
        $ship_different_address->state = $this->ship_to_different_address['state'];
        $ship_different_address->zipcode = $this->ship_to_different_address['zipcode'];
        $ship_different_address->ip_address = request()->ip();
        $ship_different_address->is_user_logged_in_user = Auth::check() ? 1 : 0;
        $ship_different_address->user_id = Auth::id() ?? $userId;
        $ship_different_address->save();

        return [
            'id' => $ship_different_address->id,
            'name' => $ship_different_address->name,
            'mobile' => $ship_different_address->mobile,
            'address_line_1' => $ship_different_address->address_line_1,
            'address_line_2' => $ship_different_address->address_line_2,
            'city' => $ship_different_address->city,
            'state' => $ship_different_address->state,
            'zipcode' => $ship_different_address->zipcode,
        ];
    }

    public function createOrderItem($user_order)
    {
        $this->item_sum_discount = 0;
        foreach (Cart::instance('cart')->content() as $item) {
            $productPrice = getPrice($item->id);

            $orderItem = new OrderItems();
            $orderItem->order_id = $user_order->id;
            $orderItem->item_id = $item->id;
            $orderItem->quantity = $item->qty;

            $orderItem->regular_price = $item->model->price;
            $orderItem->sale_price = $item->model->sale_price ?? 0;
            $orderItem->sale_default_price = $item->model->sale_default_price ?? 0;
            $orderItem->sale_price_start_date = $item->model->sale_from_date;
            $orderItem->sale_price_end_date = $item->model->sale_to_date;

            $orderItem->subtotal = $item->qty * $productPrice['price'];

            $offerPrice = 0;
            if (!empty($item->options['discount_price'])) {
                $offerPrice = $item->price * $item->qty - $item->options['discount_price'];
                $orderItem->offer_id = $item->options['offer_id'];
            } else {
                $orderItem->offer_id = null;
            }
            $orderItem->offer_discount = $offerPrice;

            if ($this->is_first_order == true && $this->payment_method == 'online' && (!isset($item->options['is_gift_product']) || $item->options['is_gift_product'] == false)) {
                $discount_percentage = fetchDiscountPercentage();
                $item_discount = ($orderItem->subtotal * $discount_percentage) / 100;
                $this->item_sum_discount += $item_discount;
                $total = $orderItem->subtotal - $orderItem->offer_discount - $item_discount;
                $orderItem->bonus = $item_discount;
            } else {
                $total = $orderItem->subtotal - $orderItem->offer_discount;
            }
            $orderItem->total = $total;
            $orderItem->item_return_days = $item->model->product_return_days;
            $orderItem->gst = $item->model->gst ?? 0;
            $orderItem->gst_amount = $total - ($total * 100) / (100 + ($item->model->gst ?? 0));
            $orderItem->item_replacement_days = $item->model->product_replacement_days;
            $orderItem->delivery_at = now();
            $orderItem->is_gift_item = $item->options['is_gift_product'] ?? false ? 1 : 0;
            $orderItem->save();
        }
    }

    public function userCreate()
    {
        $password = Str::random(8);
        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
        } else {
            $user = User::where('mobile', $this->billing_address['mobile'])->first();
        }

        if (!$user) {
            $user = new User();
            $user->mobile = $this->billing_address['mobile'] ? $this->billing_address['mobile'] : $this->ship_to_different_address['mobile'] ?? null;
            $user->password = Hash::make($password);
            $user->password_view = $password;
            $user->is_guest_user = 1;
        }
        $user->name = $this->billing_address['name'];
        $user->role = 'User';
        $user->save();

        if (function_exists('wawiContact')) {
            wawiContact($user);
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'mobile' => $user->mobile,
        ];
    }

    public function verifyCheckout()
    {
        try {
            $this->validate(
                [
                    'billing_address.name' => 'required|string|max:255',
                    'billing_address.state' => 'required|string|max:255',
                    'billing_address.city' => 'required|string|max:255',
                    'billing_address.billing_address1' => 'required|string|max:255',
                    'billing_address.zipcode' => 'required',
                    'billing_address.mobile' => 'required|digits_between:10,15',
                ],
                [],
                [
                    'billing_address.name' => 'name',
                    'billing_address.state' => 'state',
                    'billing_address.city' => 'city',
                    'billing_address.billing_address1' => 'address',
                    'billing_address.zipcode' => 'zipcode',
                    'billing_address.mobile' => 'phone number',
                ],
            );
        } catch (ValidationException $e) {
            $this->dispatch('validation-failed');
            throw $e;
        }

        $this->placeOrder();
    }

    public function placeOrder()
    {
        try {
            $nonAuthUser = $this->userCreate();
            $billingAddress = $this->createBillingAddress($nonAuthUser['id']);

            $encdoeBillingAddress = json_encode($billingAddress);
            $user_order = new Order();

            if (!empty($this->ship_to_different_address['name']) && !empty($this->ship_to_different_address['billing_address1']) && !empty($this->ship_to_different_address['city']) && !empty($this->ship_to_different_address['state']) && !empty($this->ship_to_different_address['zipcode'])) {
                if (!Auth::check()) {
                    $shippingAddress = $this->createShippingAddress($nonAuthUser['id']);
                } else {
                    $shippingAddress = $this->createShippingAddress();
                }
                $encdoeShipDifferentAddress = json_encode($shippingAddress);
                $user_order->ship_different_address_id = $shippingAddress['id'];
                $user_order->ship_different_address_details = $encdoeShipDifferentAddress;
            } else {
                $user_order->ship_different_address_id = $billingAddress['id'];
                $user_order->ship_different_address_details = $encdoeBillingAddress;
            }

            if (Auth::check()) {
                $user_order->is_logged_in_user = 1;
                $user_order->logged_in_user_id = Auth::user()->id;
            } else {
                $user_order->is_logged_in_user = 0;
                $user_order->logged_in_user_id = $nonAuthUser['id'];
            }

            $user_order->subtotal = (float) str_replace(',', '', Cart::instance('cart')->total());
            $user_order->coupon_discount = $this->mainDiscountAmount > 0 && $this->payment_method == 'online' ? $this->mainDiscountAmount : 0;
            $user_order->coupon_id = $this->mainDiscountAmount > 0 && $this->payment_method == 'online' ? session('coupon_discount_id') : null;
            $user_order->offer_discount = $this->offerDiscount > 0 ? $this->offerDiscount : 0;
            $user_order->special_discount = $this->extra_discount > 0 ? $this->extra_discount : 0;

            if ($this->payment_method == 'online') {
                $user_order->total = ceil($this->finalTotal);
                $user_order->shipping_charges = (float) $this->online_payment_amount;
            } else {
                $user_order->total = ceil($this->finalTotal);
                $user_order->shipping_charges = (float) $this->cash_on_delivery_amount;
            }
            $user_order->status = 0;
            $user_order->is_manual_pickup = session('free_shipping_pincode') ? 1 : 0;
            $user_order->additional_information = $this->additional_information;
            $user_order->billing_address_id = $billingAddress['id'];
            $user_order->billing_address_details = $encdoeBillingAddress;
            $user_order->etd = session('latest_etd');
            $user_order->shipping_bearable = session('shipping_bear_margin') ?? 0;

            if ($this->payment_method == 'online') {
                $user_order->paid_amount = ceil($this->finalTotal);
                $user_order->remaining_amount = 0;
                $user_order->is_cod = 0;
                $user_order->save();

                $this->createOrderItem($user_order);
                if ($this->is_first_order == true && $this->payment_method == 'online') {
                    $user_order->total_bonus = $this->item_sum_discount;
                }
                $user_order->save();

                $order = razorPayPayment(ceil($this->finalTotal), Auth::user()->id ?? ($nonAuthUser['id'] ?? null), $user_order->id, 'orders', 'Order Placed Using Online Payment');

                $user = Auth::user() ?? (object) ['name' => $nonAuthUser['name']];

                $this->dispatch('initiate-razorpay', [
                    'transaction_id' => $order->transaction_id,
                    'razorpay_order_id' => $order->id,
                    'amount' => $order->amount,
                    'description' => $order->description,
                    'name' => $user->name,
                    'customer_name' => $user->name,
                    'id' => $user_order->id,
                    'success_url' => route('payment.success'),
                ]);
            } else {
                $user_order->paid_amount = 0;
                $user_order->remaining_amount = ceil($this->finalTotal);
                $user_order->cod_charges = (int) $this->cash_on_delivery_amount - $this->online_payment_amount;
                $user_order->is_cod = 1;
                $user_order->status = 1;
                $user_order->save();

                $this->createOrderItem($user_order);

                Cart::instance('cart')->destroy();
                if (Auth::check()) {
                    Cart::instance('cart')->store(Auth::user()->mobile);
                }

                session()->forget(['coupon_discount_amount', 'coupon_discount_id', 'coupon_code']);

                $this->dispatch('close-checkout-modal');

                return redirect('/order-completed?id=' . $user_order->id)->with('success', 'Your order placed successfully!');
            }
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        $giftAlreadyAdded = false;
        foreach (Cart::instance('cart')->content() as $item) {
            if (isset($item->options['is_gift_product']) && $item->options['is_gift_product'] == true) {
                $giftAlreadyAdded = true;
                break;
            }
        }

        $this->calculateTotals();
        $display_coupons = $this->fetchDisplayCoupons();

        return view('livewire.user.cart-component', compact('giftAlreadyAdded', 'display_coupons'))->layout('layouts.user.app');
    }
}
