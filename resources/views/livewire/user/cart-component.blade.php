<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Cart
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-12 mb-40">
                <div class="content mb-10">
                    <h1 class="title style-3 mb-20 text-center">Your Cart</h1>
                    <h6 class="text-body text-center">There are <span
                            class="text-brand">{{ Cart::instance('cart')->count() }}</span> products in your cart
                    </h6>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mb-md-5 mb-4">
                        <div class="gift-progress-container">
                            <div class="gift-text-measure">
                                <div class="progress-title">Grab Your Offer Now!!</div>
                                {{-- <div class="progress-title">Offer!! Offer!! Offer!!</div> --}}
                                <p class="quicksand fw-500">Shop ₹500 and get exclusive offer only on RollMills. Let the
                                    offers Roll-In !!</p>
                            </div>
                            <div class="gift-scroll-bar">
                                <div class="progress-bar-cart" id="" data-width="100">
                                    <div class="bar-circle">
                                        <i class="fa-solid fa-gift"></i>
                                    </div>
                                </div>
                                <div class="milestone-marker">
                                    <img src="{{ asset('assets/frontend/imgs/shop/istockphoto-2172206741-612x612-removebg-preview__1_-removebg-preview.png') }}"
                                        alt="" class="img-fluid">
                                </div>
                                <div class="milestone-marker-open">
                                    <img src="{{ asset('assets/frontend/imgs/shop/surprise-gift-box-vector-with-white-bow-suitable-for-use-on-birthday-party-new-year-and-marry-christmas-2R4YDP3-removebg-preview__1_-removebg-preview.png') }}"
                                        alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="content">
                                <p class="text-center mt-4 fs-20 fw-500">
                                    You are ₹200 away from your gift &nbsp;<a href="/shop">Shop Now </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-9">
                <div class="table-responsive shopping-summery table-responsive-custom">
                    <table class="table table-wishlist mb-0">
                        <thead>
                            <tr class="main-heading">
                                <th scope="col" colspan="2" class="ps-3">Product</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col" class="end">Remove</th>
                            </tr>
                        </thead>
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
                                <tr class="pt-3">
                                    <td class="image product-thumbnail pt-40 position-relative ps-3"><img
                                            src="{{ asset('storage/' . $item->model->featured_image) }}"
                                            alt="{{ $item->model->seo_meta }}">
                                        <div class="display-visible-480 d-none">
                                            <a href="#"
                                                class="text-body fs-16 rounded-pill p-2 bg-brand d-flex align-items-center justify-content-center fit-content"
                                                wire:click.prevent="removeFromCart('{{ $item->rowId }}')"
                                                wire:confirm="Are you sure you want to remove this item from your cart?">
                                                <i class="fi-rs-trash text-white"></i></a>
                                        </div>
                                    </td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading"
                                                href="{{ $shop_detail_url }}">{{ $item->model->name }}
                                                {{ $item->id }}</a>
                                        </h6>
                                        @php
                                            $reviews = \App\Models\ProductReview::where('status', 1)
                                                ->where('product_id', $item->model->id)
                                                ->get();

                                            $reviews_count = $reviews->count();
                                            $reviews_avg = $reviews_count > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                            $reviews_percentage = ($reviews_avg / 5) * 100;
                                        @endphp
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $reviews_percentage }}%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{ $reviews_avg }})</span>
                                        </div>
                                    </td>
                                    <td class="price small-screen-table-td me-3" data-title="Price">
                                        <h4 class="text-body small-screen-table-td-content">
                                            ₹{{ number_format($item->price) }}</h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15 display-hide-480">
                                            <div class="detail-qty border radius">
                                                <a href="#"
                                                    wire:click.prevent="decrementQuantity('{{ $item->rowId }}')"
                                                    class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">{{ $item->qty }}</span>
                                                <a href="#"
                                                    wire:click.prevent="incrementQuantity('{{ $item->rowId }}')"
                                                    class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                        </div>
                                        <div class="quantity d-none">
                                            <button type="button" class="minus"
                                                wire:click.prevent="decrementQuantity('{{ $item->rowId }}')">-</button>
                                            <input type="number" min="1" value="{{ $item->qty }}"
                                                class="qty" size="4" title="Qty"
                                                wire:change="updateQuantity('{{ $item->rowId }}')"
                                                wire:model.lazy="quantities.{{ $item->rowId }}">
                                            <button type="button" class="plus"
                                                wire:click.prevent="incrementQuantity('{{ $item->rowId }}')">+</button>
                                        </div>
                                    </td>
                                    <td class="price small-screen-table-td" data-title="Total Price">
                                        <h4 class="text-brand small-screen-table-td-content">
                                            ₹{{ number_format($item->price * $item->qty) }}</h4>
                                    </td>
                                    <td class="action text-center small-screen-table-td remove-btn"
                                        data-title="Remove">
                                        <a href="#" wire:click.prevent="removeFromCart('{{ $item->rowId }}')"
                                            wire:confirm="Are you sure you want to remove this item from your cart?"
                                            class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                                @php
                                    if ($item->options && isset($item->options['discount_price'])) {
                                        $totalOfferDiscountedPrice +=
                                            $item->price * $item->qty - (($item->options ?? [])['discount_price'] ?? 0);
                                    }
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="divider-2 mb-30"></div> --}}
                <div class="cart-action d-flex justify-content-between mt-3 mb-40 mb-xl-0">
                    <a href="/shop" class="btn d-flex align-items-center custom-pad"><i
                            class="fi-rs-arrow-left mr-10"></i>Continue
                        Shopping</a>
                </div>
            </div>
            <div class="col-xl-3">

                <div class="calculate-shiping p-20 border-radius-15 border mb-20">
                    <h4 class="mb-10 underline pb-2">Calculate Shipping</h4>
                    {{-- <p class="mb-30"><span class="font-lg text-muted">Flat rate:</span><strong
                            class="text-brand">5%</strong></p> --}}
                    <form class="field_form shipping_calculator mt-30" method="POST"
                        wire:submit.prevent="pincodeCheckFunction">
                        <div class="form-row row">
                            <div class="form-group col-lg-12">
                                <input placeholder="PostCode / ZIP" name="name" type="text" class="pl-15"
                                    wire:model="pincode">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn">Update Zip Code</button>
                        </div>
                    </form>
                </div>
                <div class="p-20 border-radius-15 border mb-20">
                    <h4 class="mb-30 pb-2 underline">Apply Coupon</h4>
                    <div class="d-flex justify-content-between mb-4">
                        <input class="font-medium pl-15 mr-15 coupon" name="Coupon" placeholder="Enter Code"
                            wire:model="couponCode">
                        <button class="btn d-flex justify-content-center align-items-center"
                            wire:click="applyCoupon"><i class="fi-rs-label mr-10"></i>Apply</button>
                    </div>
                    @foreach ($global_coupons as $global_coupon)
                        <a class="coupon-card-cart {{ $couponCode == $global_coupon->coupon_code ? 'selected' : '' }}"
                            wire:click.prevent="checkCoupon('{{ $global_coupon->coupon_code }}')">
                            <div class="coupon-header">
                                <div class="coupon-code-section">
                                    <div class="coupon-code-cart">{{ $global_coupon->coupon_code }}</div>
                                    {{-- <div class="discount-badge">20% OFF</div> --}}
                                </div>
                                <div class="check-circle">
                                    <svg fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="coupon-description">
                                {{ $global_coupon->description }}
                            </div>
                            <div class="coupon-footer">
                                <div class="discount-badge">{{ $global_coupon->discount_value }}% OFF</div>
                                <div class="min-order">Valid till:
                                    {{ \Carbon\Carbon::parse($global_coupon->expiry_date)->format('M d, Y') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="border p-20 cart-totals">
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
                                    $discount = $totalOfferDiscountedPrice + $mainDiscountAmount;
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
                                    $amountAfterDiscount = $cartTotal - $totalOfferDiscountedPrice;
                                    $allCouponandOfferDiscount =
                                        $cartTotal - $totalOfferDiscountedPrice - $mainDiscountAmount;
                                @endphp
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        @if ($totalOfferDiscountedPrice != 0 && $mainDiscountAmount != 0)
                                            <h4 class="text-brand text-end fs-16">
                                                ₹{{ number_format($allCouponandOfferDiscount + ((float) session('shipping_charge') ?? 0), 2) }}
                                            </h4>
                                        @elseif($totalAfterDiscount != 0)
                                            <h4 class="text-brand text-end fs-16">
                                                ₹{{ number_format($totalAfterDiscount + ((float) session('shipping_charge') ?? 0), 2) }}
                                            </h4>
                                        @elseif($totalOfferDiscountedPrice != 0)
                                            <h4 class="text-brand text-end fs-16">
                                                ₹{{ number_format($amountAfterDiscount + ((float) session('shipping_charge') ?? 0), 2) }}
                                            </h4>
                                        @else
                                            @php
                                                $shippingCharge = (float) (session('shipping_charge') ?? 0);
                                                $total =
                                                    floatval(str_replace(',', '', Cart::total())) + $shippingCharge;
                                            @endphp
                                            <h4 class="text-brand text-end fs-16">
                                                ₹{{ number_format($total, 2) }}
                                            </h4>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($checkout_button)
                        <a href="/checkout"
                            class="btn mb-20 w-100 d-flex justify-content-center align-items-center">Proceed
                            To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        function showCongratsOffer() {
            confetti({
                particleCount: 500,
                spread: 100,
                origin: {
                    y: 0.6
                }
            });
        }
        window.addEventListener('coupon-applied', event => {
            showCongratsOffer();
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const bar = document.querySelector(".progress-bar-cart");
            const markerClosed = document.querySelector(".milestone-marker");
            const markerOpen = document.querySelector(".milestone-marker-open");

            let finalWidth = parseInt(bar.getAttribute("data-width"));

            // Start bar animation (0 -> finalWidth)
            bar.style.width = finalWidth + "%";

            // When the width animation finishes
            bar.addEventListener("transitionend", function() {

                let reachedWidth = parseInt(bar.style.width);

                if (reachedWidth >= 100) {
                    showCongratsOffer();
                    // Show open box
                    setTimeout(() => {
                        if (markerClosed) markerClosed.style.display = "none";
                        if (markerOpen) markerOpen.style.display = "block";
                    }, 800);

                    // 🎉 Trigger confetti here
                } else {
                    // Show closed box
                    if (markerClosed) markerClosed.style.display = "block";
                    if (markerOpen) markerOpen.style.display = "none";
                }

            });

        });

        // Your confetti code
        function showCongratsOffer() {
            confetti({
                particleCount: 800,
                spread: 200,
                origin: {
                    y: 0.6
                }
            });
        }

        // Optional: fire from Livewire event also
        window.addEventListener('coupon-applied', event => {
            showCongratsOffer();
        });
    </script>
@endpush
