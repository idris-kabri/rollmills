<?php

namespace App\Livewire\User;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\GiftCardItem;
use App\Models\Order;
use App\Models\ProductCategoryAssign;
use App\Models\OrderItems;
use App\Models\Setting;
use App\Models\User;
use App\Models\Transaction;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class CheckoutComponent extends Component
{
    use HasToastNotification;

    public $billing_address = [];
    public $ship_to_different_address = [];
    public $fetch_user_address = [];
    public $additional_information;
    public $gift_cards_items = [];
    public $applied_gift_card_ids;
    public $gift_card_amount = 0;
    public $finalTotal = 0;
    public $offerDiscount = 0;
    public $couponDiscount = 0;
    public $payment_method = 'online';
    public $gift_card_item;
    public $coupon_discount_id;
    public $add_new_address = false;
    public $add_new_shipp_address = false;
    public $ship_to_different_address_enabled = false;
    public $gift_card_code;
    public $mainDiscountAmount = 0;
    public $onlineDiscountAmount = 0;
    public $items_checkout_event_array = [];
    public $out_of_stock_id = [];
    public $pincode_validation_id = [];
    public $payment_button;
    public $free_shipping;
    public $is_first_order = true;
    public $item_sum;
    public $item_sum_discount;
    public $cash_on_delivery_amount;
    public $online_payment_amount;
    public $cash_on_delivery_user_additional_pay;

    public $minimum_order_value = 1000;
    public $discount_percentage = 15;
    public $maximum_extra_discount_amount = 500;
    public $extra_discount = 0;

    // --- CANCEL & RAZORPAY VARIABLES ---
    public $pending_order_id = null;
    public $cancel_reason = 'cod';
    public $cancel_reason_text = '';
    public $potentialCodTotal = 0;

    public function mount()
    {
        session()->forget('first_order');
        $this->payment_method = session()->get('selected_payment_method', 'online');
        $this->minimum_order_value = Setting::where('label', 'extra_discount_order_value')->first()->value;
        $this->discount_percentage = Setting::where('label', 'extra_discount')->first()->value;
        $this->maximum_extra_discount_amount = Setting::where('label', 'maximum_extra_discount')->first()->value;
        $this->billing_address['zipcode'] = session('shipping_pincode');
        $this->billing_address['email'] = '';
        $this->ship_to_different_address['zipcode'] = session('shipping_pincode');

        if (Auth::check()) {
            $this->fetch_user_address = Address::where('user_id', Auth::user()->id)->get();
            $this->billing_address['email'] = Auth::user()->email;

            // Auto-select the first address if available
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

        $this->checkBillingEmail();

        if (count(Cart::instance('cart')->content()) > 0) {
            $items = [];
            foreach (Cart::instance('cart')->content() as $item) {
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
                        // FIXED: Added parentheses to prevent Fatal TypeError in PHP 8+
                        $item['item_category' . ($key + 1)] = $category->category->name;
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
            $this->defaultShippingCharge();
            $this->checkPlaceOrderFunction();
            $this->calculateTotals();
            $this->dispatch('initiate-checkout', ['items' => $items, 'total' => Cart::instance('cart')->total()]);
        } else {
            return redirect()->route('cart');
        }
    }

    public function defaultShippingCharge()
    {
        $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $cod_charges = (int) Setting::where('label', 'cod_charges')->first()->value ?? 0;
        $free_delivery_order_amount = (int) Setting::where('label', 'free_delivery_order_amount')->first()->value ?? 0;
        $shipping_charges = 0;

        if ($cartSubtotal > $free_delivery_order_amount) {
            $this->online_payment_amount = 0;
        } else {
            $this->online_payment_amount = $shipping_charges;
        }

        $this->cash_on_delivery_amount = $cod_charges + $this->online_payment_amount;
    }

    public function checkPlaceOrderFunction()
    {
        if (Auth::check()) {
            if (
                Order::where('logged_in_user_id', Auth::user()->id)
                    ->whereNotIn('status', [0, 4])
                    ->count() > 0
            ) {
                $this->is_first_order = false;
            } else {
                $this->is_first_order = true;
            }
        } else {
            $mobile_number = '';
            $address_type = '';
            if (isset($this->billing_address['mobile']) && $this->billing_address['mobile'] != null) {
                $mobile_number = $this->billing_address['mobile'];
                $address_type = 'billing';
            } else {
                if (isset($this->ship_to_different_address['mobile']) && $this->ship_to_different_address['mobile'] != null) {
                    $mobile_number = $this->ship_to_different_address['mobile'];
                    $address_type = 'shipping';
                }
            }

            if ($mobile_number != null && $mobile_number != '') {
                $order_count = 0;
                if ($address_type == 'billing') {
                    $order_count = Order::where('billing_address_details', 'LIKE', "%$mobile_number%")
                        ->whereNotIn('status', [0, 4])
                        ->count();
                } else {
                    $order_count = Order::where('ship_different_address_details', 'LIKE', "%$mobile_number%")
                        ->whereNotIn('status', [0, 4])
                        ->count();
                }

                if ($order_count > 0) {
                    $this->is_first_order = false;
                } else {
                    $this->is_first_order = true;
                }
            }
        }
    }

    public function calculateTotals()
    {
        $cartTotal = (float) str_replace(',', '', Cart::instance('cart')->total());
        $totalOfferDiscount = 0;
        $currentCartTotal = 0;

        foreach (Cart::instance('cart')->content() as $item) {
            if (!empty($item->options['discount_price'])) {
                $totalOfferDiscount += $item->price * $item->qty - $item->options['discount_price'];
            }

            // Skip gift products for discount threshold calculation
            if (isset($item->options['is_gift_product']) && $item->options['is_gift_product'] == true) {
                continue;
            }
            $currentCartTotal += $item->price * $item->qty;
        }

        // --- DYNAMIC EXTRA DISCOUNT LOGIC ---
        if ($currentCartTotal >= $this->minimum_order_value) {
            $calculated_discount = ($currentCartTotal * $this->discount_percentage) / 100;
            $this->extra_discount = min($calculated_discount, $this->maximum_extra_discount_amount);
            session()->put('extra_discount', $this->extra_discount);
        } else {
            $this->extra_discount = 0;
            session()->forget('extra_discount');
        }

        $this->offerDiscount = (float) ($totalOfferDiscount ?? 0);
        $this->couponDiscount = (float) (session('coupon_discount_amount') ?? 0);
        $this->coupon_discount_id = (int) session('coupon_discount_id');

        $shippingCharge = (float) session('flat_rate_charge') ?? (float) session('shipping_charge');

        // First Order on Online Payment
        if ($this->is_first_order && $this->payment_method == 'online') {
            $discountPercentage = fetchDiscountPercentage();
            $this->onlineDiscountAmount = round($cartTotal * ($discountPercentage / 100), 2);
        } else {
            $this->onlineDiscountAmount = 0;
        }

        // Calculate potential COD total for the modal interface
        $this->potentialCodTotal = ceil($cartTotal - $this->offerDiscount - $this->extra_discount + $this->cash_on_delivery_amount);

        if ($this->payment_method == 'online') {
            $this->finalTotal = $cartTotal - $this->offerDiscount - $this->couponDiscount - $this->onlineDiscountAmount - $this->extra_discount + $shippingCharge;
        } else {
            $this->finalTotal = $cartTotal - $this->offerDiscount - $this->onlineDiscountAmount - $this->extra_discount + $shippingCharge;
        }

        if ($this->finalTotal < 0) {
            $this->finalTotal = 0;
        }

        if ($this->payment_method == 'online') {
            $this->mainDiscountAmount = (float) session('coupon_discount_amount');
        } else {
            $this->mainDiscountAmount = 0;
        }
    }

    public function addNewAddress()
    {
        $this->add_new_address = true;
        $this->billing_address = [];
        $this->billing_address['zipcode'] = session('shipping_pincode');
        if (Auth::check()) {
            $this->billing_address['email'] = Auth::user()->email;
        }
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
                'email' => $address->email,
                'mobile' => $address->mobile,
                'billing_address1' => $address->address_line_1,
                'billing_address2' => $address->address_line_2,
                'city' => $address->city,
                'state' => $address->state,
                'zipcode' => $address->zipcode,
                'ip_address' => $address->ip_address,
                'is_user_logged_in_user' => $address->is_user_logged_in_user,
                'user_id' => $address->user_id,
            ];
            $this->add_new_address = false;
        }
        $this->checkBillingEmail();
    }

    public function storeAddressInToShipping($address_id)
    {
        $address = Address::find($address_id);
        if ($address) {
            $this->ship_to_different_address = [
                'id' => $address->id,
                'name' => $address->name,
                'email' => $address->email,
                'mobile' => $address->mobile,
                'billing_address1' => $address->address_line_1,
                'billing_address2' => $address->address_line_2,
                'city' => $address->city,
                'state' => $address->state,
                'zipcode' => $address->zipcode,
            ];
            $this->add_new_shipp_address = false;
        }
    }

    public function checkBillingEmail()
    {
        $email = Auth::check() ? Auth::user()->email : $this->billing_address['email'] ?? null;

        if ($email) {
            $gift_card_item_query = GiftCardItem::where('customer_email', $email)
                ->where('used_at', null)
                ->when($this->applied_gift_card_ids, function ($query) {
                    $query->where('id', '!=', $this->applied_gift_card_ids);
                })
                ->get();
            if ($gift_card_item_query) {
                $this->gift_cards_items = $gift_card_item_query;
            } else {
                $this->gift_cards_items = collect([]);
            }

            $user = User::where('email', $email)->first();
            if ($user) {
                $coupon_id = session()->get('coupon_discount_id');
                if ($coupon_id) {
                    $coupon_get = Coupon::find($coupon_id);
                    if ($coupon_get) {
                        $order_count = Order::where('logged_in_user_id', $user->id)->where('coupon_id', $coupon_id)->where('status', 1)->count();
                        if ($coupon_get->usage_limit <= $order_count) {
                            session()->forget('coupon_discount_amount');
                            session()->forget('coupon_discount_id');
                            session()->forget('coupon_code');

                            $this->toastError('This coupon code usage limit is exceeded!');
                            $this->couponDiscount = 0;
                        }
                    }
                }
            }
        } else {
            $this->gift_cards_items = collect([]);
        }
    }

    public function applyGiftCard($gift_card_item_id = null)
    {
        if ($this->gift_card_code && $gift_card_item_id == null) {
            // Unrestricted so guests can apply manual codes without an email field
            $this->gift_card_item = GiftCardItem::where('gift_code', $this->gift_card_code)->first();
        } else {
            $this->gift_card_item = GiftCardItem::find($gift_card_item_id);
        }

        if (!$this->gift_card_item) {
            $this->toastError('Invalid Gift Card Code');
            return;
        }

        $order_find = Order::where('gift_card_item_id', $this->gift_card_item->id)->count();
        if ($order_find > 0) {
            $this->toastError('This Gift Card has already been used.');
            return;
        }

        $gift_card_item = $this->gift_card_item;
        if ($gift_card_item) {
            if ($this->applied_gift_card_ids != $gift_card_item->id) {
                $this->applied_gift_card_ids = $gift_card_item->id;
            }

            $this->gift_cards_items = $this->gift_cards_items
                ->reject(function ($item) use ($gift_card_item) {
                    return $item->id == $gift_card_item->id;
                })
                ->values();

            $this->gift_card_amount = $gift_card_item->getGiftCardGroupId->price;
            $cartTotal = (float) str_replace(',', '', Cart::instance('cart')->total());
            $final_total = $cartTotal - $this->offerDiscount - $this->extra_discount - $this->couponDiscount - $this->gift_card_amount;
            if ($final_total < 0) {
                $this->finalTotal = 0;
                $gift_card_amount = $this->gift_card_amount - ($cartTotal - $this->offerDiscount - $this->extra_discount - $this->couponDiscount);
                $this->gift_card_amount = $this->gift_card_amount - $gift_card_amount;
            } else {
                $this->finalTotal = $cartTotal - $this->offerDiscount - $this->extra_discount - $this->couponDiscount - $this->gift_card_amount + (float) session('flat_rate_charge') ?? (float) session('shipping_charge');
            }
        }
    }

    public function createBillingAddress($userId = null)
    {
        $address = isset($this->billing_address['id']) ? Address::find($this->billing_address['id']) ?? new Address() : new Address();
        $address->name = $this->billing_address['name'];
        $address->email = Auth::check() ? Auth::user()->email : null; // Safe fallback
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
            'email' => $address->email,
            'mobile' => $address->mobile,
            'address_line_1' => $address->address_line_1,
            'address_line_2' => $address->address_line_2,
            'city' => $address->city,
            'state' => $address->state,
            'zipcode' => $address->zipcode,
            'ip_address' => $address->ip_address,
            'is_user_logged_in_user' => $address->is_user_logged_in_user,
            'user_id' => $address->user_id,
        ];
    }

    public function createShippingAddress($userId = null)
    {
        $ship_different_address = isset($this->ship_to_different_address['id']) ? Address::find($this->ship_to_different_address['id']) ?? new Address() : new Address();
        $ship_different_address->name = $this->ship_to_different_address['name'];
        $ship_different_address->email = Auth::check() ? Auth::user()->email : null;
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
            'email' => $ship_different_address->email,
            'mobile' => $ship_different_address->mobile,
            'address_line_1' => $ship_different_address->address_line_1,
            'address_line_2' => $ship_different_address->address_line_2,
            'city' => $ship_different_address->city,
            'state' => $ship_different_address->state,
            'zipcode' => $ship_different_address->zipcode,
            'ip_address' => $ship_different_address->ip_address,
            'is_user_logged_in_user' => $ship_different_address->is_user_logged_in_user,
            'user_id' => $ship_different_address->user_id,
        ];
    }

    public function createOrderItem($user_order)
    {
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
            // Added safe grouping for calculation
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
            // Assign null if guest, input is removed
            $user->email = null;
            $user->mobile = $this->billing_address['mobile'] ? $this->billing_address['mobile'] : $this->ship_to_different_address['mobile'];
            $user->password = Hash::make($password);
            $user->password_view = $password;
            $user->is_guest_user = 1;
        }
        $user->name = $this->billing_address['name'];
        $user->role = 'User';

        $user->save();
        wawiContact($user);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
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
        $this->validate([
            'billing_address.name' => 'required|string|max:255',
            'billing_address.state' => 'required|string|max:255',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.billing_address1' => 'required|string|max:255',
            'billing_address.billing_address2' => 'nullable|string|max:255',
            'billing_address.zipcode' => 'required',
            'billing_address.mobile' => 'required|digits_between:10,15',
        ]);

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

            if ($this->couponDiscount > 0 && $this->payment_method == 'online') {
                $user_order->coupon_discount = $this->couponDiscount;
                $user_order->coupon_id = $this->coupon_discount_id;
            } else {
                $user_order->coupon_discount = 0;
            }

            if ($this->offerDiscount > 0) {
                $user_order->offer_discount = $this->offerDiscount;
            } else {
                $user_order->offer_discount = 0;
            }

            if ($this->extra_discount > 0) {
                $user_order->special_discount = $this->extra_discount;
            } else {
                $user_order->special_discount = 0;
            }

            if ($this->payment_method == 'online') {
                $user_order->total = ceil($this->finalTotal + $this->online_payment_amount);
                $user_order->shipping_charges = (float) $this->online_payment_amount;
            } else {
                $user_order->total = ceil($this->finalTotal + $this->cash_on_delivery_amount);
                $user_order->shipping_charges = (float) $this->cash_on_delivery_amount;
            }
            $user_order->status = 0;

            if (session('free_shipping_pincode')) {
                $user_order->is_manual_pickup = 1;
            } else {
                $user_order->is_manual_pickup = 0;
            }

            $user_order->additional_information = $this->additional_information;
            $user_order->billing_address_id = $billingAddress['id'];
            $user_order->billing_address_details = $encdoeBillingAddress;
            $user_order->etd = session('latest_etd');
            $user_order->shipping_bearable = session('shipping_bear_margin') ?? 0;

            if ($this->gift_card_amount > 0) {
                $user_order->gift_card_item_id = $this->applied_gift_card_ids;
                $user_order->gift_card_discount = $this->gift_card_amount;
            }

            if ($this->payment_method == 'online') {
                $user_order->paid_amount = ceil($this->finalTotal + $this->online_payment_amount);
                $user_order->remaining_amount = 0;
                $user_order->is_cod = 0;

                $user_order->save();

                $this->createOrderItem($user_order);
                if ($this->is_first_order == true && $this->payment_method == 'online') {
                    $user_order->total_bonus = $this->item_sum_discount;
                }
                $user_order->save();

                // STORE PENDING ORDER ID FOR CANCELLATION LOGIC
                $this->pending_order_id = $user_order->id;

                $coupon = Coupon::find($this->coupon_discount_id);

                $order = razorPayPayment(ceil($this->finalTotal + $this->online_payment_amount), Auth::user()->id ?? ($nonAuthUser['id'] ?? null), $user_order->id, 'orders', 'Order Placed Using Online Payment');

                // Provided dummy email if null to prevent Razorpay crashes
                $user =
                    Auth::user() ??
                    (object) [
                        'name' => $nonAuthUser['name'],
                        'email' => $nonAuthUser['email'] ?? 'guest@rollmills.store',
                    ];

                $this->dispatch('initiate-razorpay', [
                    'transaction_id' => $order->transaction_id,
                    'razorpay_order_id' => $order->id,
                    'amount' => $order->amount,
                    'description' => $order->description,
                    'name' => $user->name,
                    'email' => $user->email,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'id' => $user_order->id,
                    'success_url' => route('payment.success'),
                ]);
            } else {
                $user_order->paid_amount = 0;
                $user_order->remaining_amount = ceil($this->finalTotal + $this->cash_on_delivery_amount);
                $user_order->cod_charges = (int) ($this->cash_on_delivery_amount - $this->online_payment_amount);
                $user_order->is_cod = 1;
                $user_order->status = 1;
                $user_order->save();

                $this->createOrderItem($user_order);

                Cart::instance('cart')->destroy();
                if (Auth::check()) {
                    Cart::instance('cart')->store(Auth::user()->mobile);
                }

                session()->forget('coupon_discount_amount');
                session()->forget('coupon_discount_id');
                session()->forget('coupon_code');

                return redirect('/order-completed?id=' . $user_order->id)->with('success', 'Your order placed successfully!');
            }
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function handleCancelPayment()
    {
        if (!$this->pending_order_id) {
            $this->dispatch('close-cancel-modal');
            return;
        }

        $order = Order::find($this->pending_order_id);
        if (!$order) {
            $this->dispatch('close-cancel-modal');
            return;
        }

        if ($this->cancel_reason == 'cod') {
            // 1. Remove previous online order items since prices/discounts might be changing
            OrderItems::where('order_id', $order->id)->delete();

            // Clear old transaction if any exists
            if (class_exists(Transaction::class)) {
                Transaction::where('refrence_table', 'orders')->where('refrence_id', $order->id)->delete();
            }

            // 2. Set payment method to COD and RUN CALCULATETOTALS
            $this->paymentMethod('cod');
            $this->calculateTotals();

            // 3. Update the order with the freshly calculated COD totals
            $order->subtotal = (float) str_replace(',', '', Cart::instance('cart')->total());
            $order->coupon_discount = 0; // Clear online-only coupon
            $order->coupon_id = null;
            $order->offer_discount = $this->offerDiscount > 0 ? $this->offerDiscount : 0;
            $order->special_discount = $this->extra_discount > 0 ? $this->extra_discount : 0;

            $order->total = ceil($this->finalTotal + $this->cash_on_delivery_amount); // Uses the updated COD total
            $order->shipping_charges = (float) $this->cash_on_delivery_amount;
            $order->paid_amount = 0;
            $order->remaining_amount = ceil($this->finalTotal + $this->cash_on_delivery_amount);
            $order->cod_charges = (int) ($this->cash_on_delivery_amount - $this->online_payment_amount);
            $order->is_cod = 1;
            $order->status = 1; // Order success status
            $order->total_bonus = 0; // Clear online bonus
            $order->gift_card_discount = $this->gift_card_amount > 0 ? $this->gift_card_amount : 0;

            $order->save();

            // Create items based on COD calculations
            $this->createOrderItem($order);

            Cart::instance('cart')->destroy();
            if (Auth::check()) {
                Cart::instance('cart')->store(Auth::user()->mobile);
            }
            session()->forget(['coupon_discount_amount', 'coupon_discount_id', 'coupon_code']);

            $this->dispatch('close-cancel-modal');

            return redirect('/order-completed?id=' . $order->id)->with('success', 'Your order was successfully placed with Cash on Delivery!');
        } else {
            $appendInfo = "\nCancel Reason (Payment Exit): " . $this->cancel_reason_text;
            $order->additional_information = $order->additional_information . $appendInfo;
            $order->save();

            $this->toastError('Payment process cancelled.');
            $this->dispatch('close-cancel-modal');
        }
    }

    public function billingAddressMobile()
    {
        if (isset($this->billing_address['mobile']) && $this->billing_address['mobile'] != null) {
            $value = $this->billing_address['mobile'];
            $value = str_replace(' ', '', $value);
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
            $this->checkPlaceOrderFunction();
            $this->calculateTotals();
        }
    }

    public function shippingAddressMobile()
    {
        if (isset($this->ship_to_different_address['mobile']) && $this->ship_to_different_address['mobile'] != null) {
            $value = $this->ship_to_different_address['mobile'];
            $value = str_replace(' ', '', $value);
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
            $this->checkPlaceOrderFunction();
            $this->calculateTotals();
        }
    }

    public function placeFirstOrder()
    {
        $this->placeOrder();
    }

    public function placeNewFirstOrder()
    {
        $this->placeOrder();
    }

    public function paymentMethod($method)
    {
        $this->payment_method = $method;

        if ($method == 'cod') {
            session()->put('shipping_charge', ceil($this->cash_on_delivery_amount));
        } else {
            session()->put('shipping_charge', ceil($this->online_payment_amount));
        }

        $this->calculateTotals();
    }

    public function render()
    {
        return view('livewire.user.checkout-component')->layout('layouts.user.app');
    }
}
