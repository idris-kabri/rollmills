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
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
    public $payment_method;
    public $gift_card_item;
    public $coupon_discount_id;
    public $add_new_address = false;
    public $add_new_shipp_address = false;
    public $ship_to_different_address_enabled = false;
    public $gift_card_code;
    public $mainDiscountAmount = 0;
    public $items_checkout_event_array = [];
    public $out_of_stock_id = [];
    public $pincode_validation_id = [];
    public $payment_button;
    public $free_shipping;

    public function mount()
    {
        $this->billing_address['zipcode'] = session('shipping_pincode');
        $this->billing_address['email'] = '';
        $this->ship_to_different_address['zipcode'] = session('shipping_pincode');

        $cartTotal = (float) str_replace(',', '', Cart::instance('cart')->total());
        $totalOfferDiscount = 0;

        foreach (Cart::instance('cart')->content() as $item) {
            if (!empty($item->options['discount_price'])) {
                $totalOfferDiscount = $item->price * $item->qty - $item->options['discount_price'];
            }
        }

        $this->offerDiscount = (float) ($totalOfferDiscount ?? 0);
        $this->couponDiscount = (float) (session('coupon_discount_amount') ?? 0);
        $this->coupon_discount_id = (int) session('coupon_discount_id');
        $this->finalTotal = $cartTotal - $this->offerDiscount - $this->couponDiscount + (float) session('flat_rate_charge') ?? (float) session('shipping_charge');
        $this->mainDiscountAmount = (float) session('coupon_discount_amount');

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
            $this->dispatch('initiate-checkout', ['items' => $items, 'total' => Cart::instance('cart')->total()]);
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
        // Re-select first address to prevent empty array state if needed
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

        // Reset shipping address state when toggled
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
            $this->add_new_address = false; // Close form view
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
            $this->add_new_shipp_address = false; // Close form view
        }
    }

    public function checkBillingEmail()
    {
        if (isset($this->billing_address['email']) && $this->billing_address['email'] != '') {
            $email = $this->billing_address['email'];
            $gift_card_item_query = GiftCardItem::where('customer_email', $email)
                ->where('used_at', null)
                ->when($this->applied_gift_card_ids, function ($query) {
                    $query->where('id', '!=', $this->applied_gift_card_ids);
                })
                ->get();
            if ($gift_card_item_query) {
                $this->gift_cards_items = $gift_card_item_query;
            } else {
                $this->gift_cards_items = [];
            }

            $user = User::where('email', $email)->first();
            if ($user) {
                $coupon_id = session()->get('coupon_discount_id');
                if ($coupon_id) {
                    $coupon_get = Coupon::find($coupon_id);
                    // Check if coupon exists before accessing properties to prevent crash
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
            $this->gift_cards_items = [];
        }
    }

    // ... [Rest of your existing methods: applyGiftCard, createBillingAddress, createShippingAddress, createOrderItem, userCreate, placeOrder, render] ...

    public function applyGiftCard($gift_card_item_id = null)
    {
        if ($this->gift_card_code && $gift_card_item_id == null) {
            if (isset($this->billing_address['email']) && $this->billing_address['email'] != '') {
                $this->gift_card_item = GiftCardItem::where('gift_code', $this->gift_card_code)->first();
            } else {
                $this->toastError('Please fill the Billing Details Email field!');
                return;
            }
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
            $final_total = $cartTotal - $this->offerDiscount - $this->couponDiscount - $this->gift_card_amount;
            if ($final_total < 0) {
                $this->finalTotal = 0;
                $gift_card_amount = $this->gift_card_amount - ($cartTotal - $this->offerDiscount - $this->couponDiscount);
                $this->gift_card_amount = $this->gift_card_amount - $gift_card_amount;
            } else {
                $this->finalTotal = $cartTotal - $this->offerDiscount - $this->couponDiscount - $this->gift_card_amount + (float) session('flat_rate_charge') ?? (float) session('shipping_charge');
            }
        }
    }

    public function createBillingAddress($userId = null)
    {
        $address = isset($this->billing_address['id']) ? Address::find($this->billing_address['id']) ?? new Address() : new Address();
        $address->name = $this->billing_address['name'];
        $address->email = $this->billing_address['email'];
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
        $ship_different_address->email = $this->ship_to_different_address['email'] ?? $this->billing_address['email'];
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
            // $orderItem->courier_id = $item->options['courier_id'];
            // $orderItem->courier = $item->options['courier'];
            // $orderItem->overall_rate = $item->options['overall_rate'];
            // $orderItem->rate = $item->options['rate'];
            // $orderItem->shipping_margin_bear = $item->options['shipping_margin_bear'];
            // $orderItem->etd = $item->options['etd'];

            $orderItem->subtotal = $item->qty * $productPrice['price'];
            $offerPrice = 0;
            if (!empty($item->options['discount_price'])) {
                $offerPrice = $item->price * $item->qty - $item->options['discount_price'];
                $orderItem->offer_id = $item->options['offer_id'];
            } else {
                $orderItem->offer_id = null;
            }
            $orderItem->offer_discount = $offerPrice;
            $orderItem->total = $orderItem->subtotal - $orderItem->offer_discount;
            $orderItem->item_return_days = $item->model->product_return_days;
            $orderItem->item_replacement_days = $item->model->product_replacement_days;
            $orderItem->delivery_at = now();
            $orderItem->save();
        }
    }

    public function userCreate()
    {
        $password = Str::random(8);
        $user = User::where('mobile', $this->billing_address['mobile'])->first();

        if (!$user) {
            // Create new user
            $user = new User();
            $user->email = $this->billing_address['email'];
            $user->mobile = $this->billing_address['mobile'];
            $user->password = Hash::make($password);
            $user->password_view = $password;
            $user->is_guest_user = 1;
        }

        $user->name = $this->billing_address['name'];
        $user->role = 'User';
        $user->email = $this->billing_address['email'];
        $user->save();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
        ];
    }
    public function placeOrder()
    {
        $this->validate(
            [
                'billing_address.name' => 'required|string|max:255',
                'billing_address.email' => 'required|email',
                'billing_address.state' => 'required|string|max:255',
                'billing_address.city' => 'required|string|max:255',
                'billing_address.billing_address1' => 'required|string|max:255',
                'billing_address.billing_address2' => 'nullable|string|max:255',
                'billing_address.zipcode' => 'required',
                'billing_address.mobile' => 'required|digits_between:10,15',
            ],
            [],
            [
                'billing_address.name' => 'name',
                'billing_address.email' => 'email address',
                'billing_address.state' => 'state',
                'billing_address.city' => 'city',
                'billing_address.billing_address1' => 'address',
                'billing_address.billing_address2' => 'address line 2',
                'billing_address.zipcode' => 'zipcode',
                'billing_address.mobile' => 'phone number',
            ],
        );

        try {
            $this->payment_method = 'upi';
            $nonAuthUser = null;

            // Create billing address
            if (!Auth::check()) {
                $nonAuthUser = $this->userCreate();
                $billingAddress = $this->createBillingAddress($nonAuthUser['id']);
            } else {
                $billingAddress = $this->createBillingAddress();
            }

            $encdoeBillingAddress = json_encode($billingAddress);
            //order create
            $user_order = new Order();

            //ship to different address create
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

            if ($this->couponDiscount > 0) {
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

            $user_order->total = $this->finalTotal;
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
            $user_order->shipping_charges = (float) session('flat_rate_charge') ?? (float) session('shipping_charge');
            $user_order->shipping_bearable = session('shipping_bear_margin') ?? 0;

            if ($this->gift_card_amount > 0) {
                $user_order->gift_card_item_id = $this->applied_gift_card_ids;
                $user_order->gift_card_discount = $this->gift_card_amount;
            }

            if ($this->payment_method == 'upi') {
                $user_order->paid_amount = $this->finalTotal;
                $user_order->remaining_amount = 0;

                $user_order->save();

                $this->createOrderItem($user_order);
                $coupon = Coupon::find($this->coupon_discount_id);

                $order = razorPayPayment($this->finalTotal, Auth::user()->id ?? ($nonAuthUser['id'] ?? null), $user_order->id, 'orders', 'Order Placed Using UPI');

                $user =
                    Auth::user() ??
                    (object) [
                        'name' => $nonAuthUser['name'],
                        'email' => $nonAuthUser['email'],
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
                $walletBalance = (int) Auth::user()->wallet_balance;

                if ($walletBalance >= $this->finalTotal) {
                    updateWalletBalance(Auth::user()->id, 'deduct', $this->finalTotal);
                    $user_order->paid_amount = $this->finalTotal;
                    $user_order->remaining_amount = 0;
                    $user_order->save();

                    $this->createOrderItem($user_order);

                    walletPayment(Auth::user()->id, $user_order->id, 'orders', $this->finalTotal, 'WALLET-ORDER-' . Str::upper(Str::random(10)), 'Order Placed Using Wallet', 1);

                    Cart::instance('cart')->destroy();
                    if (Auth::check()) {
                        Cart::instance('cart')->store(Auth::user()->mobile);
                    }

                    return redirect('/')->with('success', 'Order successful, and the details have been sent to ' . $billingAddress['name'] . ' email address.');
                } else {
                    $remainingAmount = $this->finalTotal - $walletBalance;
                    $user_order->paid_amount = $remainingAmount;
                    $user_order->remaining_amount = 0;
                    $user_order->save();

                    //hh
                    $this->createOrderItem($user_order);

                    if ($walletBalance > 0) {
                        walletPayment(Auth::user()->id, $user_order->id, 'orders', $walletBalance, 'WALLET-ORDER-' . Str::upper(Str::random(10)), 'Order Placed Using Wallet', 1);
                    }

                    $order = razorPayPayment($remainingAmount, Auth::user()->id, $user_order->id, 'orders', 'Partial Wallet + Razorpay for Custom Gift Card');

                    $this->dispatch('initiate-razorpay', [
                        'transaction_id' => $order->transaction_id,
                        'razorpay_order_id' => $order->id,
                        'amount' => $order->amount,
                        'description' => $order->description,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        // 'title' => $this->gift_card_item['title'],
                        'customer_name' => Auth::user()->name,
                        'customer_email' => Auth::user()->email,
                        'success_url' => route('payment.success'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // dd($e);
            $this->toastError($e->getMessage());
        }
    }

    public function pincodeCheckFunction($show_toast = 'no')
    {
        $checkoutconditionFail = false;
        $setting = Setting::where('label', 'Pincode Out Of Delhivery')->first();
        if ($setting) {
            $outOfDeliveryPincodes = explode(',', $setting->value);

            if (in_array($this->billing_address['zipcode'], $outOfDeliveryPincodes)) {
                $this->free_shipping = true;
                session()->put('free_shipping_pincode', $this->billing_address['zipcode']);
                session()->forget('show_deleviery_time');
                session()->put('shipping_pincode', $this->billing_address['zipcode']);
                session()->forget('flat_rate_charge');
                $this->mount();
            }
        }
    }

    public function render()
    {
        return view('livewire.user.checkout-component')->layout('layouts.user.app');
    }
}
