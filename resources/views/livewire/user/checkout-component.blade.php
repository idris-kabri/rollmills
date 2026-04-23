<main class="main">
    @php
        $discount_percentage = fetchDiscountPercentage();
    @endphp
    {{-- CANCEL PAYMENT MODAL --}}
    <div wire:ignore.self class="modal fade cancel-payment-modal" id="RazorpayCancelModal" tabindex="-1"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg modal-custom-radius">

                <div class="modal-header border-0 pb-0 justify-content-end">
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body pt-0 px-sm-5 px-4 pb-16">
                    <div class="text-center">
                        <img src="{{ asset('assets/frontend/imgs/icon&images/complain.png') }}" alt="Alert"
                            class="img-fluid cancel-modal-icon" />
                        <h4 class="cancel-modal-title">Payment Cancelled</h4>
                        <p class="cancel-modal-subtitle">Don't leave empty-handed! Why are you cancelling?</p>
                    </div>

                    <div class="d-flex flex-column gap-3 mb-4">
                        <label class="cancel-reason-label {{ $cancel_reason === 'cod' ? 'active-cod' : '' }}">
                            <div class="form-check me-3 mt-1">
                                <input class="form-check-input custom-radio-lg" type="radio" name="cancelReason"
                                    value="cod" wire:model.live="cancel_reason">
                            </div>
                            <div class="w-100">
                                <span class="reason-title text-success">
                                    <i class="fi-rs-truck me-2"></i> Switch to Cash on Delivery
                                </span>
                                <span class="reason-desc">Skip the online payment and seamlessly place your order using
                                    Cash on Delivery right now.</span>
                            </div>
                        </label>

                        <label class="cancel-reason-label {{ $cancel_reason === 'other' ? 'active-other' : '' }}">
                            <div class="form-check me-3">
                                <input class="form-check-input custom-radio-lg" type="radio" name="cancelReason"
                                    value="other" wire:model.live="cancel_reason">
                            </div>
                            <div>
                                <span class="reason-title text-dark">Other reason</span>
                            </div>
                        </label>
                    </div>

                    @if ($cancel_reason === 'other')
                        <div class="mb-4 slide-down">
                            <textarea class="form-control custom-textarea" rows="3" placeholder="Please specify your reason for cancelling..."
                                wire:model="cancel_reason_text"></textarea>
                        </div>
                    @endif

                    <div class="cancel-modal-actions">
                        <button type="button" class="btn btn-outline-secondary flex-grow-1"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button"
                            class="btn btn-golden flex-grow-1 fw-bold d-flex align-items-center justify-content-center"
                            wire:click.prevent="handleCancelPayment" wire:loading.attr="disabled"
                            wire:target="handleCancelPayment">
                            <span wire:loading.remove wire:target="handleCancelPayment">
                                @if ($cancel_reason === 'cod')
                                    Place COD Order (₹{{ number_format($potentialCodTotal) }})
                                @else
                                    Submit
                                @endif
                                <i class="fi-rs-arrow-right ms-2"></i>
                            </span>
                            <span wire:loading wire:target="handleCancelPayment">
                                <span class="spinner-border spinner-border-sm me-2"></span> Processing...
                            </span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Checkout
            </div>
        </div>
    </div>

    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Checkout</h1>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are <span
                            class="text-brand">{{ Cart::instance('cart')->count() }}</span> products in your cart</h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    {{-- BILLING HEADER & TOGGLE BUTTON --}}
                    <div class="d-flex justify-content-between align-items-center mb-30">
                        <h4 class="mb-0">Billing Details</h4>
                        @if (count($fetch_user_address) > 0 && $add_new_address == false)
                            <button class="btn btn-sm btn-fill-out" wire:click="addNewAddress"><i
                                    class="fi-rs-plus mr-5"></i>Add New</button>
                        @elseif($add_new_address && count($fetch_user_address) > 0)
                            <button class="btn btn-sm btn-outline" wire:click="cancelNewAddress">Cancel</button>
                        @endif
                    </div>

                    {{-- 1. BILLING ADDRESS LIST VIEW --}}
                    @if (count($fetch_user_address) > 0 && $add_new_address == false)
                        <div class="row">
                            @foreach ($fetch_user_address as $address)
                                <div class="col-md-12 mb-3">
                                    <div class="default-address-div"
                                        wire:click="storeAddressInToBilling({{ $address->id }})">
                                        <a
                                            class="coupon-card-cart {{ isset($billing_address['id']) && $billing_address['id'] == $address->id ? 'selected' : '' }}">
                                            <div class="coupon-header">
                                                <div class="d-flex coupon-code-section">
                                                    <div class="coupon-code-cart">Address {{ $loop->index + 1 }}</div>

                                                </div>
                                                <div class="check-circle">
                                                    <svg fill="none" stroke="white" stroke-width="3"
                                                        viewBox="0 0 24 24" width="16" height="16">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="coupon-description">
                                                <ul class="list-unstyled">
                                                    <li class="mb-1 fw-500 font-sm"><strong>Phone:</strong>
                                                        {{ $address->mobile }}</li>
                                                    @if ($address->email)
                                                        <li class="mb-1 fw-500 font-sm"><strong>Email:</strong>
                                                            {{ $address->email }}</li>
                                                    @endif
                                                    <li class="mb-1 fw-500 font-sm"><strong>Address:</strong>
                                                        {{ $address->address_line_1 }}, {{ $address->city }},
                                                        {{ $address->state }} - {{ $address->zipcode }}</li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- 2. BILLING ADDRESS FORM VIEW --}}
                    @else
                        <form method="post">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" required name="billing_address.name" placeholder="Name *"
                                        wire:model="billing_address.name">
                                    @error('billing_address.name')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required type="text" name="billing_address.mobile"
                                        placeholder="Phone *" wire:model="billing_address.mobile"
                                        wire:keyup.debounce.800ms="billingAddressMobile">
                                    @error('billing_address.mobile')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" required name="billing_address.state" placeholder="State *"
                                        wire:model="billing_address.state">
                                    @error('billing_address.state')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <input type="text" required name="billing_address.city" placeholder="City *"
                                        wire:model="billing_address.city">
                                    @error('billing_address.city')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" required name="billing_address.billing_address1"
                                        placeholder="Address *" wire:model="billing_address.billing_address1">
                                    @error('billing_address.billing_address1')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_address.billing_address2"
                                        placeholder="Address line 2" wire:model="billing_address.billing_address2">
                                    @error('billing_address.billing_address2')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" @if (session('shipping_charge'))  @endif
                                        name="billing_address.zipcode" placeholder="Postcode / ZIP *"
                                        wire:model="billing_address.zipcode">
                                    @error('billing_address.zipcode')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </form>

                    @endif

                    <div class="form-group mb-30">
                        <textarea rows="5" placeholder="Additional information" wire:model="additional_information"></textarea>
                    </div>

                    {{-- 4. SHIPPING DETAILS SECTION --}}
                    <div class="ship_detail">
                        @if ($ship_to_different_address_enabled)
                            <div id="collapseAddress" class="different_address collapse in show">

                                {{-- 4a. SAVED SHIPPING ADDRESSES --}}
                                @if (count($fetch_user_address) > 0 && !$add_new_shipp_address)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-muted">Select Delivery Address:</h6>
                                        <button class="btn btn-sm btn-fill-out" wire:click="addNewShipAddress">
                                            <i class="fi-rs-plus mr-5"></i> Add New
                                        </button>
                                    </div>

                                    <div class="row">
                                        @foreach ($fetch_user_address as $address)
                                            @php
                                                $isSelected =
                                                    isset($ship_to_different_address['id']) &&
                                                    $ship_to_different_address['id'] == $address->id;
                                            @endphp

                                            <div class="col-md-12 mb-3">
                                                <div class="default-address-div"
                                                    wire:click="storeAddressInToShipping({{ $address->id }})">
                                                    <a class="coupon-card-cart {{ $isSelected ? 'selected' : '' }}">
                                                        <div class="coupon-header">
                                                            <div class="d-flex coupon-code-section">
                                                                <span>{{ strtoupper(substr($address->name, 0, 1)) }}</span>
                                                                <div class="coupon-code-cart">{{ $address->name }}
                                                                </div>
                                                            </div>
                                                            <div class="check-circle">
                                                                <svg fill="none" stroke="white" stroke-width="3"
                                                                    viewBox="0 0 24 24" width="16"
                                                                    height="16">
                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="coupon-description">
                                                            <ul class="list-unstyled">
                                                                <li class="mb-1 fw-500 font-sm"><strong>Phone:</strong>
                                                                    {{ $address->mobile }}</li>
                                                                <li class="mb-1 fw-500 font-sm">
                                                                    <strong>Address:</strong>
                                                                    {{ $address->address_line_1 }},
                                                                    {{ $address->city }}
                                                                </li>
                                                                <li class="mb-1 fw-500 font-sm">{{ $address->state }}
                                                                    - {{ $address->zipcode }}</li>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- 4b. NEW SHIPPING ADDRESS FORM --}}
                                @else
                                    <div class="row mb-3">
                                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">New Shipping Address</h6>
                                            @if (count($fetch_user_address) > 0)
                                                <button class="btn btn-outline btn-sm"
                                                    wire:click="cancelNewShipAddress">
                                                    Cancel
                                                </button>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" required="" name="name" placeholder="Name *"
                                                wire:model="ship_to_different_address.name">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="mobile"
                                                placeholder="Mobile *" wire:model="ship_to_different_address.mobile"
                                                wire:keyup.debounce.800ms="shippingAddressMobile">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="billing_address" required=""
                                                placeholder="Address Line 1 *"
                                                wire:model="ship_to_different_address.billing_address1">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="billing_address2"
                                                placeholder="Address Line 2 (Optional)"
                                                wire:model="ship_to_different_address.billing_address2">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="city"
                                                placeholder="City / Town *"
                                                wire:model="ship_to_different_address.city">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="state"
                                                placeholder="State *" wire:model="ship_to_different_address.state">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="zipcode"
                                                placeholder="Zipcode *" wire:model="ship_to_different_address.zipcode"
                                                @if (session('shipping_charge')) disabled @endif>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 5. ORDER SUMMARY SECTION (REDESIGNED USING CART STYLE) --}}
            <div class="col-lg-5">
                <div class="cart-sb-wrap">
                    <div class="co-wrap p-3">

                        <h3 class="cart-sb-title mb-3">Order Items</h3>

                        {{-- Products List --}}
                        <div class="mb-4 pb-3 border-bottom">
                            @php
                                $total_original_price = 0;
                            @endphp
                            @foreach (Cart::instance('cart')->content() as $item)
                                @php
                                    $isGift = $item->options['is_gift_product'] ?? false;
                                    $shop_detail_url = $item->model->slug
                                        ? route('shop-detail', [
                                            'slug' => $item->model->slug,
                                            'id' => $item->model->id,
                                        ])
                                        : route('shop-detail', ['slug' => 'no-slug', 'id' => $item->model->id]);
                                    $total_original_price += $item->model->price * $item->qty;
                                @endphp

                                <div class="co-order-row {{ $isGift ? 'gift-row-summary' : '' }}">
                                    <div class="co-thumb">
                                        <img src="{{ asset('storage/' . $item->model->featured_image) }}"
                                            alt="{{ $item->model->name }}">
                                    </div>
                                    <div style="flex-grow: 1;">
                                        <div class="co-prod-name">
                                            @if ($isGift)
                                                <span class="co-badge-inline"
                                                    style="background:#ffbc0d;margin-left:0;margin-right:5px;">Gift</span>
                                            @endif
                                            <a href="{{ !$isGift ? $shop_detail_url : 'javascript:void(0)' }}"
                                                style="color: inherit;">{{ $item->model->name }}</a>
                                        </div>
                                        <div class="co-prod-sub">Qty: {{ $item->qty }}</div>
                                    </div>
                                    <div class="co-prod-price">
                                        @if ($isGift)
                                            <span style="color:#25b579;">FREE</span>
                                        @else
                                            ₹{{ number_format($item->price * $item->qty) }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <h3 class="cart-sb-title">Details</h3>

                        <div class="mb-4">
                            <div class="cart-sb-row muted">
                                <span class="cart-sb-label">Cart Total (MRP)</span>
                                <span class="cart-sb-val">₹{{ number_format($total_original_price, 2) }}</span>
                            </div>

                            @php
                                $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
                                $customer_save_amount = $total_original_price - $cartSubtotal;
                            @endphp

                            @if ($customer_save_amount > 0)
                                <div class="cart-sb-row green">
                                    <span class="cart-sb-label">You Save</span>
                                    <span class="cart-sb-val">- ₹{{ number_format($customer_save_amount, 2) }}</span>
                                </div>
                            @endif

                            <div class="cart-sb-row muted">
                                <span class="cart-sb-label">Subtotal</span>
                                <span class="cart-sb-val">₹{{ Cart::instance('cart')->subtotal() }}</span>
                            </div>

                            {{-- Extra Discount --}}
                            @if ($extra_discount > 0)
                                @php
                                    $extra_discount_percentage = \App\Models\Setting::where(
                                        'label',
                                        'extra_discount',
                                    )->first();
                                @endphp
                                <div class="cart-sb-row green">
                                    <span class="cart-sb-label">Special Discount
                                        ({{ $extra_discount_percentage->value }}%
                                        OFF)</span>
                                    <span class="cart-sb-val">- ₹{{ number_format($extra_discount, 2) }}</span>
                                </div>
                            @endif

                            {{-- Coupon Discount --}}
                            @php
                                $discount = $mainDiscountAmount;
                                $couponCode = session()->get('coupon_code');
                            @endphp
                            @if ($discount != 0)
                                <div class="cart-sb-row green">
                                    <span class="cart-sb-label">Coupon Applied @if ($couponCode)
                                            ({{ strtoupper($couponCode) }})
                                        @endif
                                    </span>
                                    <span class="cart-sb-val">- ₹{{ number_format($discount, 2) }}</span>
                                </div>
                            @endif

                            {{-- Prepaid Discount --}}
                            @if ($is_first_order && $payment_method == 'online')
                                <div class="cart-sb-row green">
                                    <span class="cart-sb-label">Prepaid Discount <span
                                            class="cart-sb-auto-badge">AUTO</span></span>
                                    <span class="cart-sb-val">- ₹{{ number_format($onlineDiscountAmount, 2) }}</span>
                                </div>
                            @endif

                            {{-- COD Fee --}}
                            @if ($payment_method == 'cod')
                                <div class="cart-sb-row red">
                                    <span class="cart-sb-label">COD Handling Fee</span>
                                    <span class="cart-sb-val">+
                                        ₹{{ number_format(ceil($cash_on_delivery_amount - $online_payment_amount), 2) }}</span>
                                </div>
                            @endif

                            {{-- Shipping Charges --}}
                            <div class="cart-sb-row muted">
                                <span class="cart-sb-label">Shipping</span>
                                @if (session('flat_rate_charge') != null)
                                    <span
                                        class="cart-sb-val">₹{{ number_format(session('flat_rate_charge'), 2) }}</span>
                                @elseif (floatval($online_payment_amount) == 0 && $payment_method == 'online')
                                    <span class="cart-sb-val text-success fw-bold" style="color: #16a34a;">Free</span>
                                @else
                                    <span class="cart-sb-val">
                                        @if ($payment_method == 'online')
                                            ₹{{ number_format(ceil($online_payment_amount), 2) }}
                                        @else
                                            ₹{{ number_format(ceil($cash_on_delivery_amount), 2) }}
                                        @endif
                                    </span>
                                @endif
                            </div>

                            <div class="cart-sb-divider"></div>

                            {{-- Total --}}
                            <div class="cart-sb-total-row">
                                <span class="cart-sb-label">Your Total</span>
                                <span class="cart-sb-val">
                                    @if ($payment_method == 'online')
                                        ₹{{ number_format(ceil($finalTotal + $online_payment_amount), 2) }}
                                    @else
                                        ₹{{ number_format(ceil($finalTotal + $cash_on_delivery_amount), 2) }}
                                    @endif
                                </span>
                            </div>

                            @if ($is_first_order && $payment_method == 'online')
                                <div class="cart-sb-saved-msg">🎉 You have saved {{ $discount_percentage }}% on every
                                    product!!</div>
                            @endif
                        </div>

                        <div class="cart-sb-promo-strip">
                            <div class="cart-sb-promo-icon">🎫</div>
                            @php
                                $minimum_order_value = \App\Models\Setting::where(
                                    'label',
                                    'extra_discount_order_value',
                                )->first()->value;
                                $maximum_extra_discount = \App\Models\Setting::where(
                                    'label',
                                    'maximum_extra_discount',
                                )->first()->value;
                                $extra_discount_val = \App\Models\Setting::where('label', 'extra_discount')->first()
                                    ->value;
                            @endphp
                            <div class="cart-sb-promo-text">Order above ₹{{ $minimum_order_value }}? Get
                                <b>extra {{ $extra_discount_val }}% off (upto ₹{{ $maximum_extra_discount }})</b>
                            </div>
                        </div>

                        {{-- Compare Box Calculation --}}
                        @php
                            $cartTotalRaw = (float) str_replace(',', '', Cart::instance('cart')->total());
                            $potentialOnlineTotalLocal =
                                $cartTotalRaw -
                                $offerDiscount -
                                $couponDiscount -
                                round($cartTotalRaw * ($discount_percentage / 100), 2) -
                                $extra_discount +
                                $online_payment_amount;
                            $potentialCodTotalLocal =
                                $cartTotalRaw -
                                $offerDiscount -
                                $couponDiscount -
                                $extra_discount +
                                $cash_on_delivery_amount;
                            $savings = $potentialCodTotalLocal - $potentialOnlineTotalLocal;
                        @endphp
                        @if ($is_first_order && $potentialOnlineTotalLocal > 0)
                            <div class="cart-sb-compare mt-3">
                                <div class="cart-sb-compare-inner">
                                    <div class="cart-sb-compare-half prepaid {{ $payment_method == 'online' ? 'active' : '' }}"
                                        style="cursor:pointer;" wire:click="paymentMethod('online')">
                                        <div class="cart-sb-compare-title green"><i class="fi-rs-check-circle"></i>
                                            Pay Online</div>
                                        <div class="cart-sb-compare-price green">
                                            ₹{{ number_format(ceil($potentialOnlineTotalLocal)) }}</div>
                                        <div class="cart-sb-compare-sub">After {{ $discount_percentage }}% off · Free
                                            delivery</div>
                                    </div>
                                    <div class="cart-sb-compare-half cod {{ $payment_method == 'cod' ? 'active' : '' }}"
                                        style="cursor:pointer;" wire:click="paymentMethod('cod')">
                                        <div class="cart-sb-compare-title red"><i class="fi-rs-truck"></i> Cash on
                                            Delivery</div>
                                        <div class="cart-sb-compare-price red">
                                            ₹{{ number_format(ceil($potentialCodTotalLocal)) }}</div>
                                        <div class="cart-sb-compare-sub">No discount ·
                                            +₹{{ number_format(ceil($cash_on_delivery_amount - $online_payment_amount)) }}
                                            COD fee</div>
                                    </div>
                                </div>
                                <div class="cart-sb-compare-footer">
                                    <i class="fi-rs-star"></i> Save ₹{{ number_format(ceil($savings)) }} by choosing
                                    Online Payment
                                </div>
                            </div>

                            <div class="cart-sb-trust-pills mt-2">
                                <span class="cart-sb-trust-pill"><i class="fi-rs-check"></i> Extra discount on online
                                    payment</span>
                            </div>
                        @endif

                        <h3 class="cart-sb-title mt-4">Select Payment Method</h3>

                        <div class="cart-sb-payment-box {{ $payment_method == 'online' ? 'active' : '' }}"
                            wire:click="paymentMethod('online')">
                            <div class="cart-sb-payment-header">
                                <div class="cart-sb-radio"></div>
                                <span class="cart-sb-payment-method-name">Pay via UPI / Credit Card</span>
                                <span class="cart-sb-express-badge">FREE EXPRESS DELIVERY</span>
                            </div>
                            @if ($is_first_order)
                                <div class="cart-sb-payment-sub green">Get instant {{ $discount_percentage }}% off on
                                    each product</div>
                            @endif
                        </div>

                        <div class="cart-sb-payment-box {{ $payment_method == 'cod' ? 'active' : '' }}"
                            wire:click="paymentMethod('cod')">
                            <div class="cart-sb-payment-header">
                                <div class="cart-sb-radio"></div>
                                <span class="cart-sb-payment-method-name">Cash on Delivery</span>
                            </div>
                            @if ($is_first_order)
                                <div class="cart-sb-payment-sub red">
                                    ₹{{ number_format(ceil($cash_on_delivery_amount - $online_payment_amount)) }}
                                    handling fee applies · No {{ $discount_percentage }}% discount
                                </div>
                            @endif
                        </div>

                        <button
                            class="btn btn-proceed-checkout mt-4 w-100 d-flex justify-content-center align-items-center"
                            wire:click.prevent="verifyCheckout" wire:loading.attr="disabled"
                            wire:target="verifyCheckout, placeOrder">
                            <span wire:loading.remove wire:target="verifyCheckout, placeOrder">
                                Place Order {{ $payment_method == 'online' ? '(Prepaid)' : '(COD)' }} <i
                                    class="fi-rs-arrow-right ms-2"></i>
                            </span>
                            <span wire:loading wire:target="verifyCheckout, placeOrder">
                                <span class="spinner-border spinner-border-sm me-2"></span> Processing...
                            </span>
                        </button>
                        <div class="text-center mt-3 text-muted" style="font-size: 0.85rem;">🔒 100% Secure · UPI ·
                            Card · Net Banking</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        let totalSeconds = 240;
        document.addEventListener('livewire:init', function() {

            // --- CANCEL MODAL LOGIC ---
            let cancelModal = null;
            window.addEventListener('open-cancel-modal', () => {
                cancelModal = new bootstrap.Modal(document.getElementById('RazorpayCancelModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                cancelModal.show();
            });

            Livewire.on('close-cancel-modal', () => {
                if (cancelModal) {
                    cancelModal.hide();
                } else {
                    var cancelModalEl = document.getElementById('RazorpayCancelModal');
                    if (cancelModalEl) {
                        var cModal = bootstrap.Modal.getInstance(cancelModalEl);
                        if (cModal) {
                            cModal.hide();
                        }
                    }
                }
            });

            // --- SCROLL TO VALIDATION ERROR ---
            window.addEventListener('validation-failed', function(event) {
                setTimeout(() => {
                    const firstError = document.querySelector('.text-danger.small.d-block');

                    if (firstError) {
                        const formGroup = firstError.closest('.form-group');

                        if (formGroup) {
                            formGroup.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        } else {
                            firstError.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }
                }, 100);
            });

            // --- RAZORPAY INITIALIZATION ---
            window.addEventListener('initiate-razorpay', function(event) {
                const detail = event.detail[0] || event.detail;
                var options = {
                    "key": '{{ config('app.razorpay_key_id') }}',
                    "amount": detail.amount,
                    "currency": "INR",
                    "name": "Roll mills",
                    "description": detail.description,
                    "image": "https://rollmills.store/assets/frontend/imgs/theme/logo.png",
                    "order_id": detail.razorpay_order_id,
                    "handler": function(response) {
                        window.location.href =
                            `${detail.success_url}?transaction_id=${detail.transaction_id}&payment_id=${response.razorpay_payment_id}&order_id=${detail.razorpay_order_id}&title=${detail.title}&customer_name=${detail.customer_name}&customer_email=${detail.customer_email}&type=order_payment&id=${detail.id}`;
                    },
                    "prefill": {
                        "name": detail.name,
                        "email": detail.email
                    },
                    "theme": {
                        "color": "#CF9007"
                    },
                    "modal": {
                        "ondismiss": function() {
                            // Automatically trigger modal when payment window is closed by the user
                            setTimeout(() => {
                                window.dispatchEvent(new CustomEvent('open-cancel-modal'));
                            }, 400);
                        }
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            });

            window.addEventListener('trigger-first-order-modal', function(event) {
                updateCountdown();
                totalSeconds = 240
                $("#saleModal").modal('show');
            });

            function updateCountdown() {
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;

                const min1 = Math.floor(minutes / 10);
                const min2 = minutes % 10;
                const sec1 = Math.floor(seconds / 10);
                const sec2 = seconds % 10;

                if (document.getElementById('minutes1')) {
                    document.getElementById('minutes1').textContent = min1;
                    document.getElementById('minutes2').textContent = min2;
                    document.getElementById('seconds1').textContent = sec1;
                    document.getElementById('seconds2').textContent = sec2;
                }

                if (totalSeconds > 0) {
                    totalSeconds--;
                } else {
                    totalSeconds = 900;
                }
            }

            setInterval(updateCountdown, 1000);
        });
    </script>
@endpush
