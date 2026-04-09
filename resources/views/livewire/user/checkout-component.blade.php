<main class="main">
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
                                                    <li class="mb-1 fw-500 font-sm"><strong>Email:</strong>
                                                        {{ $address->email }}</li>
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
                                    <input required type="email" name="billing_address.email"
                                        placeholder="Email address" wire:model="billing_address.email">
                                    @error('billing_address.email')
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

                                <div class="form-group col-lg-6">
                                    <input required type="text" name="billing_address.mobile" placeholder="Phone *"
                                        wire:model="billing_address.mobile"
                                        wire:keyup.debounce.800ms="billingAddressMobile">
                                    @error('billing_address.mobile')
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
                                            <input type="email" name="email" placeholder="Email *"
                                                wire:model="ship_to_different_address.email">
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

            {{-- 5. ORDER SUMMARY SECTION (REDESIGNED) --}}
            <div class="col-lg-5">
                {{-- Dynamic Discount Offer Progress Widget (Sidebar) --}}
                @php
                    $cartSubtotalNumeric = 0;
                    foreach (Cart::instance('cart')->content() as $item) {
                        if (isset($item->options['is_gift_product']) && $item->options['is_gift_product'] == true) {
                            continue;
                        }
                        $cartSubtotalNumeric += $item->price * $item->qty;
                    }
                    $remainingAmount = max(0, $minimum_order_value - $cartSubtotalNumeric);
                    $progressPercentage =
                        $cartSubtotalNumeric >= $minimum_order_value
                            ? 100
                            : ($cartSubtotalNumeric / $minimum_order_value) * 100;
                @endphp

                <div class="shipping-widget-checkout mb-4"
                    style="background: {{ $cartSubtotalNumeric >= $minimum_order_value ? '#f0fdf4' : '#fdfaf3' }}; border-color: {{ $cartSubtotalNumeric >= $minimum_order_value ? '#28a745' : '#f5c518' }};">
                    <div class="shipping-text">
                        @if ($cartSubtotalNumeric >= $minimum_order_value)
                            <i class="fi-rs-check-circle" style="color: #28a745; font-size: 18px;"></i>
                            <span style="font-size:13px; line-height:1.2">Congratulations! You've unlocked <span
                                    class="shipping-highlight" style="color:#28a745">{{ $discount_percentage }}% OFF
                                    (Up to ₹{{ $maximum_extra_discount_amount }})</span>!</span>
                        @else
                            <i class="fi-rs-shopping-bag" style="color: #e6b400; font-size: 18px;"></i>
                            <span style="font-size:13px; line-height:1.2">Add <span class="shipping-highlight"
                                    style="color:#d32f2f">₹{{ number_format($remainingAmount) }}</span> more for
                                <span class="shipping-highlight" style="color:#d32f2f">{{ $discount_percentage }}%
                                    OFF (Up to ₹{{ $maximum_extra_discount_amount }})</span>!</span>
                        @endif
                    </div>
                    <div class="shipping-progress-bg">
                        <div class="shipping-progress-bar"
                            style="width: {{ $progressPercentage }}%; background-color: {{ $cartSubtotalNumeric >= $minimum_order_value ? '#28a745' : '#f5c518' }};">
                        </div>
                    </div>
                    @if ($cartSubtotalNumeric < $minimum_order_value)
                        <div style="text-align: right; font-size: 11px; margin-top: 5px; color: #888;">
                            Total: ₹{{ number_format($cartSubtotalNumeric) }} /
                            ₹{{ number_format($minimum_order_value) }}
                        </div>
                    @endif
                </div>

                {{-- REPLACED CHECKOUT BLOCK --}}
                <div class="co-wrap">
                    {{-- Products List --}}
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

                    {{-- Details / Totals section --}}
                    <div class="co-details">
                        <div class="co-details-title">Details</div>
                        <div class="co-row muted"><span>Cart Total
                                (MRP)</span><span>₹{{ number_format($total_original_price, 2) }}</span></div>

                        @php
                            $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
                            $customer_save_amount = $total_original_price - $cartSubtotal;
                        @endphp
                        <div class="co-row green"><span>You Save</span><span>-
                                ₹{{ number_format($customer_save_amount, 2) }}</span></div>

                        <div class="co-row muted">
                            <span>Subtotal</span><span>₹{{ Cart::instance('cart')->subtotal() }}</span></div>

                        {{-- Extra Discount --}}
                        @if ($extra_discount > 0)
                            <div class="co-row green">
                                <span>Special Discount ({{ $discount_percentage }}% OFF)</span>
                                <span>- ₹{{ number_format($extra_discount, 2) }}</span>
                            </div>
                        @endif

                        {{-- Coupon Discount --}}
                        @php
                            $discount = $mainDiscountAmount;
                            $couponCode = session()->get('coupon_code');
                        @endphp
                        @if ($discount != 0)
                            <div class="co-row green">
                                <span>Coupon Applied @if ($couponCode)
                                        ({{ strtoupper($couponCode) }})
                                    @endif
                                </span>
                                <span>- ₹{{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        {{-- Prepaid Discount --}}
                        @if ($is_first_order && $payment_method == 'online')
                            <div class="co-row green" id="prepaid-disc-row">
                                <span>Prepaid Discount<span class="co-badge-inline">AUTO</span></span>
                                <span>- ₹{{ number_format($onlineDiscountAmount, 2) }}</span>
                            </div>
                        @endif

                        {{-- COD Fee --}}
                        @if ($payment_method == 'cod')
                            <div class="co-row red" id="cod-fee-row">
                                <span>COD charges<span class="co-badge-inline warn">COD</span></span>
                                <span>+
                                    ₹{{ number_format(ceil($cash_on_delivery_amount - $online_payment_amount), 2) }}</span>
                            </div>
                        @endif

                        {{-- Shipping Charges --}}
                        <div class="co-row muted">
                            <span>Shipping Charges</span>
                            @if (session('flat_rate_charge') != null)
                                <span>₹{{ number_format(session('flat_rate_charge'), 2) }}</span>
                            @elseif (floatval($online_payment_amount) == 0)
                                <span style="color:#1a8a3c;font-weight:700;">Free Shipping</span>
                            @else
                                <span>₹{{ number_format(ceil($online_payment_amount), 2) }}</span>
                            @endif
                        </div>

                        {{-- Total --}}
                        <div class="co-row total">
                            <span>Your Total</span>
                            <span>
                                @if ($payment_method == 'online')
                                    ₹{{ number_format(ceil($finalTotal + $online_payment_amount), 2) }}
                                @else
                                    ₹{{ number_format(ceil($finalTotal + $cash_on_delivery_amount), 2) }}
                                @endif
                            </span>
                        </div>

                        @if ($is_first_order && $payment_method == 'online')
                            <div class="co-saved-msg">🎉 You have saved 20% on every product!!</div>
                        @endif
                    </div>

                    {{-- Compare Box Calculation --}}
                    @php
                        $cartTotalRaw = (float) str_replace(',', '', Cart::instance('cart')->total());
                        $potentialOnlineTotal =
                            $cartTotalRaw -
                            $offerDiscount -
                            $couponDiscount -
                            round($cartTotalRaw * 0.2, 2) -
                            $extra_discount +
                            $online_payment_amount;
                        $potentialCodTotal =
                            $cartTotalRaw -
                            $offerDiscount -
                            $couponDiscount -
                            $extra_discount +
                            $cash_on_delivery_amount;
                        $savings = $potentialCodTotal - $potentialOnlineTotal;
                    @endphp
                    @if ($is_first_order && $potentialOnlineTotal > 0)
                        <div class="co-compare-box mt-3">
                            <div class="co-compare-row">
                                <div class="co-compare-col prepaid-col">
                                    <div class="co-compare-label">✅ Pay Online</div>
                                    <div class="co-compare-price green">
                                        ₹{{ number_format(ceil($potentialOnlineTotal)) }}</div>
                                    <div class="co-compare-note">After 20% off · Free delivery</div>
                                </div>
                                <div class="co-compare-col cod-col">
                                    <div class="co-compare-label">🚚 Cash on Delivery</div>
                                    <div class="co-compare-price red">₹{{ number_format(ceil($potentialCodTotal)) }}
                                    </div>
                                    <div class="co-compare-note">No discount · +₹15 COD fee</div>
                                </div>
                            </div>
                            <div class="co-compare-winner">⭐ Save ₹{{ number_format(ceil($savings)) }} by choosing
                                Online Payment</div>
                        </div>

                        <div class="co-social">
                            <div class="co-social-pill">✅ Most customers choose Prepaid & save more</div>
                            <div class="co-social-pill">✅ Extra discount on online payment</div>
                        </div>
                    @endif

                    {{-- Payment Section --}}
                    <div class="co-payment-section">
                        <div class="co-payment-title">Select Payment Method</div>

                        <div class="co-option {{ $payment_method == 'online' ? 'selected' : '' }}"
                            wire:click="paymentMethod('online')">
                            <div class="co-option-header">
                                <div class="co-radio {{ $payment_method == 'online' ? 'on' : '' }}">
                                    <div class="co-radio-dot"></div>
                                </div>
                                <span class="co-option-label">Pay via UPI / Credit Card</span>
                                <span class="co-express-badge">⚡ FREE EXPRESS DELIVERY</span>
                            </div>
                            @if ($is_first_order)
                                <div class="co-option-sub green">Get instant 20% off on each product</div>
                            @endif
                        </div>

                        <div class="co-option {{ $payment_method == 'cod' ? 'selected-cod' : '' }}"
                            wire:click="paymentMethod('cod')">
                            <div class="co-option-header">
                                <div class="co-radio {{ $payment_method == 'cod' ? 'on-cod' : '' }}">
                                    <div class="co-radio-dot"></div>
                                </div>
                                <span class="co-option-label">Cash on Delivery</span>
                            </div>
                            @if ($is_first_order)
                                <div class="co-option-sub red">
                                    ₹{{ number_format(ceil($cash_on_delivery_amount - $online_payment_amount)) }}
                                    handling fee applies · No 20% discount</div>
                            @endif
                        </div>
                    </div>

                    {{-- CTA Section --}}
                    <div class="co-cta">
                        <button class="co-cta-btn" wire:click.prevent="verifyCheckout" wire:loading.attr="disabled"
                            wire:target="verifyCheckout, placeOrder">
                            <span wire:loading.remove wire:target="verifyCheckout, placeOrder">
                                Place an Order {{ $payment_method == 'online' ? '(Prepaid)' : '(COD)' }} →
                            </span>
                            <span wire:loading wire:target="verifyCheckout, placeOrder">
                                <span class="spinner-border spinner-border-sm me-2"></span> Processing...
                            </span>
                        </button>
                        <div class="co-secure">🔒 100% Secure · UPI · Card · Net Banking</div>
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
