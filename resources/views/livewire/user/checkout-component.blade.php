<main class="main">
    <style>
        /* --- GENERAL HELPER STYLES --- */
        .text-free-green {
            color: #25b579 !important;
            font-weight: bold;
        }

        /* --- GIFT ROW STYLES (ORDER SUMMARY) --- */
        .gift-row-summary {
            background-color: #fffbf0;
            border-left: 3px solid #ffbc0d;
        }

        .gift-badge-small {
            background-color: #ffbc0d;
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: bold;
            margin-right: 5px;
            vertical-align: middle;
        }

        /* --- UNIFIED ADDRESS CARD STYLES (Used for Billing & Shipping) --- */
        .coupon-card-cart {
            display: block;
            border: 1px solid #ececec;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
            transition: all 0.3s;
            background: #fff;
            cursor: pointer;
        }

        .coupon-card-cart:hover {
            border-color: #ffbc0d;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .coupon-card-cart.selected {
            border-color: #ffbc0d;
            background-color: #fffbf0;
        }

        .coupon-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .coupon-code-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Avatar Circle */
        .coupon-code-section span {
            width: 35px;
            height: 35px;
            background-color: #ffbc0d;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        .coupon-code-cart {
            font-weight: 700;
            color: #253D4E;
            font-size: 16px;
        }

        /* Checkmark Icon */
        .check-circle {
            display: none;
            width: 24px;
            height: 24px;
            background: #ffbc0d;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
        }

        .coupon-card-cart.selected .check-circle {
            display: flex;
        }
    </style>

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
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

                                <!-- Name -->
                                <div class="form-group col-lg-6">
                                    <input type="text" required name="billing_address.name" placeholder="Name *"
                                        wire:model="billing_address.name">
                                    @error('billing_address.name')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group col-lg-6">
                                    <input required type="text" name="billing_address.email" placeholder="Email address *"
                                        wire:model="billing_address.email">
                                    @error('billing_address.email')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">

                                <!-- State -->
                                <div class="form-group col-lg-6">
                                    <input type="text" required name="billing_address.state" placeholder="State *"
                                        wire:model="billing_address.state">
                                    @error('billing_address.state')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div class="form-group col-lg-6">
                                    <input type="text" required name="billing_address.city" placeholder="City *"
                                        wire:model="billing_address.city">
                                    @error('billing_address.city')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">

                                <!-- Address 1 -->
                                <div class="form-group col-lg-6">
                                    <input type="text" required name="billing_address.billing_address1" placeholder="Address *"
                                        wire:model="billing_address.billing_address1">
                                    @error('billing_address.billing_address1')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Address 2 -->
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_address.billing_address2" placeholder="Address line 2"
                                        wire:model="billing_address.billing_address2">
                                    @error('billing_address.billing_address2')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">

                                <!-- Zipcode -->
                                <div class="form-group col-lg-6">
                                    <input type="text" disabled name="billing_address.zipcode" placeholder="Postcode / ZIP *"
                                        wire:model="billing_address.zipcode">
                                    @error('billing_address.zipcode')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group col-lg-6">
                                    <input required type="text" name="billing_address.mobile" placeholder="Phone *"
                                        wire:model="billing_address.mobile">
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

                    {{-- 3. SHIPPING TO DIFFERENT ADDRESS TOGGLE --}}
                    <div class="ship_detail">
                        <div class="form-group">
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox"
                                        id="differentaddress" wire:click="ship_to_different_address_function">
                                    <label class="form-check-label label_info" for="differentaddress">
                                        <span>Ship to a different address?</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- 4. SHIPPING DETAILS SECTION --}}
                        @if ($ship_to_different_address_enabled)
                            <div id="collapseAddress" class="different_address collapse in show">

                                {{-- 4a. SAVED SHIPPING ADDRESSES (USING UNIFIED DESIGN) --}}
                                @if (count($fetch_user_address) > 0 && !$add_new_shipp_address)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-muted">Select Delivery Address:</h6>
                                        <button class="btn btn-sm btn-fill-out" wire:click="addNewShipAddress">
                                            <i class="fi-rs-plus mr-5"></i> Add New
                                        </button>
                                    </div>

                                    <div class="row">
                                        @foreach ($fetch_user_address as $address)
                                            {{-- Determine if selected --}}
                                            @php
                                                $isSelected =
                                                    isset($ship_to_different_address['id']) &&
                                                    $ship_to_different_address['id'] == $address->id;
                                            @endphp

                                            <div class="col-md-12 mb-3">
                                                <div class="default-address-div"
                                                    wire:click="storeAddressInToShipping({{ $address->id }})">
                                                    {{-- Reuse coupon-card-cart class for consistency --}}
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
                                            <input required="" type="email" name="email"
                                                placeholder="Email *" wire:model="ship_to_different_address.email">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="mobile"
                                                placeholder="Mobile *" wire:model="ship_to_different_address.mobile">
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
                                                disabled>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 5. ORDER SUMMARY SECTION --}}
            <div class="col-lg-5">
                <div class="border p-20 cart-totals ml-30 mb-3">
                    <div class="d-flex align-items-end justify-content-between mb-30">
                        <h4 class="underline">Your Order</h4>
                        <h6 class="text-muted">Subtotal</h6>
                    </div>
                    <div class="table-responsive order_table checkout">
                        <table class="table no-border">
                            <tbody>
                                @foreach (Cart::instance('cart')->content() as $item)
                                    @php
                                        $isGift = $item->options['is_gift_product'] ?? false;
                                        if ($item->model->slug) {
                                            $shop_detail_url = route('shop-detail', [
                                                'slug' => $item->model->slug,
                                                'id' => $item->model->id,
                                            ]);
                                        } else {
                                            $shop_detail_url = route('shop-detail', [
                                                'slug' => 'no-slug',
                                                'id' => $item->model->id,
                                            ]);
                                        }
                                    @endphp

                                    <tr class="{{ $isGift ? 'gift-row-summary' : '' }}">
                                        <td class="image product-thumbnail">
                                            <img src="{{ asset('storage/' . $item->model->featured_image) }}"
                                                alt="#">
                                        </td>
                                        <td>
                                            <h6 class="w-160 mb-5">
                                                @if ($isGift)
                                                    <span class="gift-badge-small">Gift</span>
                                                @endif
                                                <a href="{{ $shop_detail_url }}"
                                                    class="text-heading two-liner-text">{{ $item->model->name }}</a>
                                            </h6>
                                            @if (!$isGift)
                                                @php
                                                    $reviews = \App\Models\ProductReview::where('status', 1)
                                                        ->where('product_id', $item->model->id)
                                                        ->get();
                                                    $reviews_avg =
                                                        $reviews->count() > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                                    $reviews_percentage = ($reviews_avg / 5) * 100;
                                                @endphp
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating"
                                                            style="width: {{ $reviews_percentage }}%"></div>
                                                    </div>
                                                    <span
                                                        class="font-small ml-5 text-muted">({{ $reviews_avg }})</span>
                                                </div>
                                            @else
                                                <span class="font-xs text-muted">Surprise Offer Applied</span>
                                            @endif
                                        </td>
                                        <td>
                                            <h6 class="text-muted pl-20 pr-20">x {{ $item->qty }}</h6>
                                        </td>
                                        <td>
                                            @if ($isGift)
                                                <h4 class="text-free-green">FREE</h4>
                                                <span class="font-xs text-muted"
                                                    style="text-decoration: line-through;">₹{{ number_format($item->model->price) }}</span>
                                            @else
                                                <h4 class="text-brand">₹{{ number_format($item->price * $item->qty) }}
                                                </h4>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border p-20 cart-totals ml-30">
                    <h4 class="mb-30 pb-2 underline">Details</h4>
                    <div class="table-responsive">
                        <table class="table no-border">
                            <tbody>
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end fs-16">
                                            ₹{{ Cart::instance('cart')->subtotal() }}</h4>
                                    </td>
                                </tr>
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Shipping</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end fs-16">
                                            @if (floatval(session('shipping_charge')) == 0)
                                                Free Shipping
                                            @else
                                                {{ number_format(session('shipping_charge'), 2) }}
                                            @endif
                                        </h5>
                                    </td>
                                </tr>
                                @if ($mainDiscountAmount != 0)
                                    <tr class="d-flex justify-content-between border-0 align-items-center">
                                        <td class="cart_total_label text-start">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success me-2">Coupon Applied</span>
                                                <h6 class="text-success m-0">
                                                    ({{ strtoupper(session('coupon_code')) }})
                                                </h6>
                                            </div>
                                        </td>

                                        <td class="cart_total_amount">
                                            <h5 class="text-end fs-16 text-success fw-bold">
                                                - ₹{{ number_format($mainDiscountAmount, 2) }}
                                            </h5>
                                        </td>
                                    </tr>
                                @endif
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end fs-16">₹{{ number_format($finalTotal, 2) }}
                                        </h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="payment ml-30">
                    <button
                        class="btn btn-fill-out btn-block mt-20 w-100 d-flex justify-content-center align-items-center"
                        wire:click.prevent="placeOrder" wire:loading.attr="disabled" wire:target="placeOrder">
                        <span wire:loading.remove wire:target="placeOrder">
                            Place an Order
                            <i class="fi-rs-sign-out ml-15"></i>
                        </span>
                        <span wire:loading wire:target="placeOrder">
                            <span class="spinner-border spinner-border-sm mr-8"></span>
                            Processing...
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</main>

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('livewire:init', function() {
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
        });
    </script>
@endpush
