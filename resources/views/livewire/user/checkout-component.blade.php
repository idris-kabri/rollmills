<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
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
                    <h4 class="mb-30">Billing Details</h4>
                    <form method="post">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" required="" name="name" placeholder="Name *"
                                    wire:model="billing_address.name">
                            </div>
                            <div class="form-group col-lg-6">
                                <input required="" type="text" name="email" placeholder="Email address *"
                                    wire:model="billing_address.email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" name="state" required="" placeholder="State *"
                                    wire:model="billing_address.state">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="city" required="" placeholder="City *"
                                    wire:model="billing_address.city">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" name="billing_address" required="" placeholder="Address *"
                                    wire:model="billing_address.billing_address1">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="billing_address2" required="" placeholder="Address line2"
                                    wire:model="billing_address.billing_address2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" disabled name="zipcode" placeholder="Postcode / ZIP *"
                                    wire:model="billing_address.zipcode">
                            </div>
                            <div class="form-group col-lg-6">
                                <input required="" type="text" name="phone" placeholder="Phone *"
                                    wire:model="billing_address.mobile">
                            </div>
                        </div>
                        <div class="form-group mb-30">
                            <textarea rows="5" placeholder="Additional information" wire:model="billing_address.additional_info"></textarea>
                        </div>
                        <div class="ship_detail">
                            <div class="form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="differentaddress" wire:change="ship_to_different_address_function()">
                                        <label class="form-check-label label_info" data-bs-toggle="collapse"
                                            data-target="#collapseAddress" href="#collapseAddress"
                                            aria-controls="collapseAddress" for="differentaddress"><span>Ship to a
                                                different address?</span></label>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="default-address-div">
                                <a class="coupon-card-cart selected">
                                    <div class="coupon-header">
                                        <div class="d-flex coupon-code-section">
                                            <span>Y</span>
                                            <div class="coupon-code-cart">yahya japan</div>
                                        </div>
                                        <div class="check-circle">
                                            <svg fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="coupon-description">
                                        <ul class="list-unstyled">
                                            <li class="mb-2 fw-500"><strong>Phone &nbsp; : &nbsp; </strong>
                                                8290062652</li>
                                            <li class="mb-2 fw-500"><strong>Email &nbsp; : &nbsp; </strong>
                                                murtaza774@gmail.com</li>
                                            <li class="mb-2 fw-500"><strong>Address &nbsp; : &nbsp; </strong>
                                                Sagwara </li>
                                        </ul>
                                    </div>
                                </a>
                            </div> --}}

                            <div id="collapseAddress" class="different_address collapse in">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <input type="text" required="" name="name" placeholder="Name *"
                                            wire:model="ship_to_different_address.name">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="text" name="billing_address" required=""
                                            placeholder="Address *"
                                            wire:model="ship_to_different_address.billing_address1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <input type="text" name="billing_address2" required=""
                                            placeholder="Address line2"
                                            wire:model="ship_to_different_address.billing_address2">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input required="" type="text" name="state" placeholder="State *"
                                            wire:model="ship_to_different_address.state">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <input required="" type="text" name="city"
                                            placeholder="City / Town *" wire:model="ship_to_different_address.city">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input required="" type="text" name="zipcode"
                                            placeholder="Postcode / ZIP *"
                                            wire:model="ship_to_different_address.zipcode" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="border p-20 cart-totals ml-30 mb-3">
                    <div class="d-flex align-items-end justify-content-between mb-30">
                        <h4 class="underline">Your Order</h4>
                        <h6 class="text-muted">Subtotal</h6>
                    </div>
                    <div class="table-responsive order_table checkout">
                        <table class="table no-border">
                            <tbody>
                                @php
                                    $totalOfferDiscountedPrice = 0;
                                @endphp
                                @foreach (Cart::instance('cart')->content() as $item)
                                    @php
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
                                    <tr>
                                        <td class="image product-thumbnail"><img
                                                src="{{ asset('storage/' . $item->model->featured_image) }}"
                                                alt="#"></td>
                                        <td>
                                            <h6 class="w-160 mb-5"><a href="{{ $shop_detail_url }}"
                                                    class="text-heading">{{ $item->model->name }}</a></h6></span>
                                            @php
                                                $reviews = \App\Models\ProductReview::where('status', 1)
                                                    ->where('product_id', $item->model->id)
                                                    ->get();

                                                $reviews_count = $reviews->count();
                                                $reviews_avg =
                                                    $reviews_count > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                                $reviews_percentage = ($reviews_avg / 5) * 100;
                                            @endphp
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating"
                                                        style="width: {{ $reviews_percentage }}%">
                                                    </div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> ({{ $reviews_avg }})</span>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="text-muted pl-20 pr-20">x {{ $item->qty }}</h6>
                                        </td>
                                        <td>
                                            <h4 class="text-brand">₹{{ number_format($item->price * $item->qty) }}
                                            </h4>
                                        </td>
                                    </tr>
                                    @php
                                        if ($item->options && isset($item->options['discount_price'])) {
                                            $totalOfferDiscountedPrice +=
                                                $item->price * $item->qty -
                                                (($item->options ?? [])['discount_price'] ?? 0);
                                        }
                                    @endphp
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
                                            {{ number_format(session('shipping_charge'), 2) }}</h4>
                                    </td>
                                </tr>
                                @if (session('latest_etd') != null)
                                    <tr class="d-flex justify-content-between border-0">
                                        <td class="cart_total_label text-start">
                                            <h6 class="text-muted">Etd</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end fs-16">{{ session('latest_etd') }}</h4>
                                        </td>
                                    </tr>
                                @endif
                                @php
                                    $discount = $mainDiscountAmount;
                                @endphp
                                @if ($discount != 0)
                                    <tr class="d-flex justify-content-between border-0">
                                        <td class="cart_total_label text-start">
                                            <h6 class="text-muted">Discount</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end fs-16 text-success">
                                                ₹{{ number_format($discount, 2) }}</h4>
                                        </td>
                                    </tr>
                                @endif
                                @php
                                    $cartTotal = (float) str_replace(',', '', Cart::total());
                                    $amountAfterDiscount = $cartTotal - $discount + (float) session('shipping_charge');
                                @endphp
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end fs-16">
                                            ₹{{ number_format($amountAfterDiscount, 2) }}
                                        </h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="payment ml-30">
                    <a href="#" class="btn btn-fill-out btn-block mt-20 w-100" wire:click.prevent="placeOrder()">Place an Order<i
                            class="fi-rs-sign-out ml-15"></i></a>
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
                "name": "EFakhri Electric Store",
                "description": detail.description,
                "image": "https://example.com/logo.png",
                "order_id": detail.razorpay_order_id,
                "handler": function(response) {
                    window.location.href =
                        `${detail.success_url}?transaction_id=${detail.transaction_id}&payment_id=${response.razorpay_payment_id}&order_id=${detail.razorpay_order_id}&title=${detail.title}&customer_name=${detail.customer_name}&customer_email=${detail.customer_email}&type=order_payment`;
                },
                "prefill": {
                    "name": detail.name,
                    "email": detail.email
                },
                "theme": {
                    "color": "#F37254"
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
        });
    });
</script>
@endpush
