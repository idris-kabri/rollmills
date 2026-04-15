<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Cart
            </div>
        </div>
    </div>

    @php
        $shippingCharge = (float) (session('shipping_charge') ?? 0);
        $total = floatval(str_replace(',', '', Cart::total()));

        $remain_amount = 0;
        if ($surprise_gift_amount <= 0) {
            $percentage = 0;
            $remain_amount = 0;
        } elseif ($total >= $surprise_gift_amount) {
            $percentage = 100;
            $remain_amount = 0;
        } else {
            $percentage = ($total / $surprise_gift_amount) * 100;
            $remain_amount = $surprise_gift_amount - $total;
        }
    @endphp

    <div wire:ignore.self class="modal fade" id="CartRemoveItemModal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content-custom w-100">
                <div class="mb-4">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/frontend/imgs/icon&images/complain.png') }}"
                            class="img-fluid mb-3 mt-4 modal-logo" />
                    </div>
                    <h1 class="fs-3 text-center">Are you Sure?</h1>
                    <p class="fs-6 mx-auto text-center quicksand">{{ $confirmMessage }}</p>
                </div>
                <div class="pb-4 d-flex flex-column justify-content-center">
                    <button class="btn mb-3 w-90-per pt-10 pb-10" wire:click.prevent="{{ $confirmAction }}">Yes,
                        Continue</button>
                    <button class="btn btn-brand-outline mx-auto pt-10 pb-10 w-90-per"
                        data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    @if (count(Cart::instance('cart')->content()) > 0)
        <div class="container mb-24 mt-md-5 mt-4">
            <div class="row">
                <div class="col-lg-12 mb-md-4 mb-0">
                    <div class="content mb-10">
                        <h1 class="title style-3 mb-20 text-center">Your Cart</h1>
                    </div>
                </div>
            </div>

            <div class="container-sm mb-3 mb-md-0" wire:ignore>
                <div class="row">
                    <div class="col-12 px-0 px-sm-3">
                        <div class="mb-md-5 mb-2">
                            <div class="gift-progress-container">
                                <div class="gift-text-measure">
                                    <div class="progress-title d-none d-sm-block">Grab Your Gift Now!!</div>
                                    <h6 class="d-block d-sm-none text-start text-brand">Shop
                                        ₹{{ $surprise_gift_amount }} & Grab Your Gift Now!!</h6>
                                    <p class="quicksand fw-500 quicksand d-none d-sm-block">Shop
                                        ₹{{ $surprise_gift_amount }} and get exclusive surprise gift only on RollMills.
                                        Let the offers Roll-In !!</p>
                                </div>
                                <div class="gift-scroll-bar">
                                    <div class="progress-bar-cart" id=""
                                        data-width="{{ $giftAlreadyAdded ? 100 : $percentage }}"
                                        data-skip="{{ $giftAlreadyAdded ? 'true' : 'false' }}">
                                        <div class="bar-circle">
                                            <i class="fa-solid fa-gift d-none d-sm-block"></i>
                                            @php $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal()); @endphp
                                            <span class="d-block d-sm-none fs-12 fw-600"
                                                style="line-height: 1em">₹{{ $cartSubtotal }}</span>
                                        </div>
                                    </div>
                                    <div class="milestone-marker"
                                        style="{{ $giftAlreadyAdded ? 'display:none;' : '' }}">
                                        <img src="{{ asset('assets/frontend/imgs/shop/istockphoto-2172206741-612x612-removebg-preview__1_-removebg-preview.png') }}"
                                            alt="" class="img-fluid">
                                    </div>
                                    <div class="milestone-marker-open"
                                        style="{{ $giftAlreadyAdded ? 'display:block;' : '' }}">
                                        <img src="{{ asset('assets/frontend/imgs/shop/surprise-gift-box-vector-with-white-bow-suitable-for-use-on-birthday-party-new-year-and-marry-christmas-2R4YDP3-removebg-preview__1_-removebg-preview.png') }}"
                                            alt="" class="img-fluid">
                                    </div>
                                </div>
                                <div class="content">
                                    <p class="text-center mt-md-4 mt-3 quicksand fs-20 fw-500 d-none d-sm-block">
                                        @if ($remain_amount > 0)
                                            You are ₹{{ $remain_amount }} away from your gift &nbsp;<a
                                                href="/shop">Shop Now </a>
                                        @else
                                            Your Surprise gift has been successfully added to your cart
                                        @endif
                                    </p>
                                    <span class="text-center mt-md-4 mt-3 quicksand fs-13 fw-600 d-block d-sm-none"
                                        style="line-height: 1.2em">
                                        @if ($remain_amount > 0)
                                            You are ₹{{ $remain_amount }} away from your gift &nbsp;<a
                                                href="/shop">Shop Now </a>
                                        @else
                                            Your Surprise gift has been successfully added to your cart
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="table-responsive shopping-summery table-responsive-custom d-none d-sm-block">
                        @php $total_original_price = 0; @endphp
                        <table class="table table-wishlist mb-0">
                            <thead>
                                <tr class="main-heading">
                                    <th scope="col" colspan="2" class="ps-3">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col" class="end pe-2">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::instance('cart')->content() as $item)
                                    @php
                                        $isGift = $item->options['is_gift_product'] ?? false;
                                        $shop_detail_url = route('shop-detail', [
                                            'slug' => $item->model->slug ? $item->model->slug : 'no-slug',
                                            'id' => $item->model->id,
                                        ]);
                                    @endphp
                                    <tr class="pt-3 {{ $isGift ? 'gift-row' : '' }}">
                                        <td class="image product-thumbnail pt-40 position-relative ps-3">
                                            <img src="{{ asset('storage/' . $item->model->featured_image) }}"
                                                alt="{{ $item->model->seo_meta }}">
                                            @if (!$isGift)
                                                <div class="display-visible-480 d-none custom-remove-item">
                                                    <a href="#"
                                                        class="text-body fs-16 rounded-pill p-2 bg-brand d-flex align-items-center justify-content-center fit-content"
                                                        wire:click.prevent="askRemove('{{ $item->rowId }}')">
                                                        <i class="fi-rs-trash text-white"></i></a>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="product-des product-name px-sm-3">
                                            @if ($isGift)
                                                <span class="gift-badge badge py-1 quicksand"><i
                                                        class="fi-rs-gift mr-5"></i> Surprise Gift</span>
                                            @endif
                                            <h6 class="mb-5">
                                                <a class="product-name mb-10 text-heading two-liner-text"
                                                    href="{{ !$isGift ? $shop_detail_url : 'javascript:void(0);' }}">
                                                    {{ $item->model->name }}
                                                </a>
                                            </h6>
                                            @php
                                                $reviews = \App\Models\ProductReview::where('status', 1)
                                                    ->where('product_id', $item->model->id)
                                                    ->get();
                                                $reviews_avg =
                                                    $reviews->count() > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                            @endphp
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating"
                                                        style="width: {{ ($reviews_avg / 5) * 100 }}%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> ({{ $reviews_avg }})</span>
                                            </div>
                                            @if ($item->model->out_of_stock == 1)
                                                <div class="badge bg-danger text-white rounded-pill quicksand">Out Of
                                                    Stock</div>
                                            @endif
                                        </td>
                                        <td class="price small-screen-table-td me-3" data-title="Price">
                                            @if ($isGift)
                                                <h4 class="text-body small-screen-table-td-content">
                                                    <del
                                                        class="text-muted fs-6">₹{{ number_format($item->model->price) }}</del><br>
                                                    <span class="price-free">FREE</span>
                                                </h4>
                                            @else
                                                @php
                                                    $originalPrice = $item->model->price;
                                                    $total_original_price += $item->model->price * $item->qty;
                                                    $cartPrice = $item->price;
                                                @endphp
                                                <h4 class="text-body small-screen-table-td-content">
                                                    @if ($cartPrice < $originalPrice)
                                                        <del
                                                            class="text-muted fs-6">₹{{ number_format($originalPrice) }}</del><br>
                                                        <span
                                                            class="price-transition">₹{{ number_format($cartPrice) }}</span>
                                                    @else
                                                        <span
                                                            class="price-transition">₹{{ number_format($cartPrice) }}</span>
                                                    @endif
                                                </h4>
                                            @endif
                                        </td>
                                        <td class="text-center detail-info" data-title="Stock">
                                            @if ($isGift)
                                                <div class="detail-qty border radius bg-light disabled"
                                                    style="cursor: not-allowed; opacity: 0.7;"><span
                                                        class="qty-val">1</span></div>
                                            @else
                                                <div class="detail-extralink mr-15 display-hide-480">
                                                    <div class="detail-qty border radius">
                                                        <a href="#"
                                                            wire:click.prevent="decrementQuantity('{{ $item->rowId }}')"
                                                            class="qty-down"><i
                                                                class="fi-rs-angle-small-down"></i></a>
                                                        <span class="qty-val">{{ $item->qty }}</span>
                                                        <a href="#"
                                                            wire:click.prevent="incrementQuantity('{{ $item->rowId }}')"
                                                            class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="price small-screen-table-td" data-title="Total Price">
                                            @if ($isGift)
                                                <h4 class="price-free small-screen-table-td-content">₹0</h4>
                                            @else
                                                <h4 class="text-brand small-screen-table-td-content">
                                                    ₹{{ number_format($item->price * $item->qty) }}</h4>
                                            @endif
                                        </td>
                                        <td class="action text-center small-screen-table-td remove-btn pe-sm-2"
                                            data-title="Remove">
                                            @if ($isGift)
                                                <span class="text-muted" title="Automatic Gift"><i
                                                        class="fi-rs-lock"></i></span>
                                            @else
                                                <a href="#"
                                                    wire:click.prevent="askRemove('{{ $item->rowId }}')"
                                                    class="text-body"><i class="fi-rs-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="product-detail-small-screen d-block d-sm-none">
                        @foreach (Cart::instance('cart')->content() as $item)
                            @php
                                $isGift = $item->options['is_gift_product'] ?? false;
                                $shop_detail_url = route('shop-detail', [
                                    'slug' => $item->model->slug ? $item->model->slug : 'no-slug',
                                    'id' => $item->model->id,
                                ]);
                            @endphp
                            <div class="product-card">
                                <div class="d-flex gap-3 align-items-center py-4 px-2">
                                    <div class="img-section position-relative">
                                        <img src="{{ asset('storage/' . $item->model->featured_image) }}"
                                            alt="{{ $item->model->seo_meta }}" class="img-fluid">
                                        @if (!$isGift)
                                            <div class="d-block d-sm-none custom-remove-item">
                                                <a href="#"
                                                    class="text-body fs-16 rounded-pill p-1 bg-brand d-flex align-items-center justify-content-center fit-content"
                                                    wire:click.prevent="askRemove('{{ $item->rowId }}')">
                                                    <i class="fi-rs-trash text-white fs-13"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="content-section">
                                        @if ($isGift)
                                            <span
                                                class="gift-badge fs-10 badge px-2 text-capitalize quicksand">Surprise
                                                Gift</span>
                                        @endif
                                        <a class="product-name fw-600 quicksand text-dark hover-a two-liner-text mb-1"
                                            style="line-height: 1.2em"
                                            href="{{ !$isGift ? $shop_detail_url : 'javascript:void(0);' }}">
                                            {{ $item->model->name }}
                                        </a>
                                        @php
                                            $reviews = \App\Models\ProductReview::where('status', 1)
                                                ->where('product_id', $item->model->id)
                                                ->get();
                                            $reviews_avg =
                                                $reviews->count() > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                        @endphp
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-price">
                                                @if ($isGift)
                                                    <h4 class="text-body small-screen-table-td-content">
                                                        <del
                                                            class="text-muted fs-14 fw-500">₹{{ number_format($item->model->price) }}</del><br>
                                                        <span class="price-free">FREE</span>
                                                    </h4>
                                                @else
                                                    @if ($item->model->sale_price > 0 && now() >= $item->model->sale_start_date && now() <= $item->model->sale_end_date)
                                                        <h3
                                                            class="text-brand small-screen-table-td-content d-inline-block me-1">
                                                            ₹{{ $item->model->sale_price * $item->qty }}</h3>
                                                        <del
                                                            class="old-price fw-600 text-muted">₹{{ $item->model->price }}</del>
                                                    @elseif($item->model->sale_default_price > 0)
                                                        <h3
                                                            class="text-brand small-screen-table-td-content d-inline-block me-1">
                                                            ₹{{ $item->model->sale_default_price * $item->qty }}</h3>
                                                        <del
                                                            class="old-price fw-600 text-muted">₹{{ $item->model->price }}</del>
                                                    @else
                                                        <h3
                                                            class="text-brand small-screen-table-td-content d-inline-block me-1">
                                                            ₹{{ $item->model->price * $item->qty }}</h3>
                                                    @endif
                                                @endif
                                            </div>

                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating"
                                                        style="width: {{ ($reviews_avg / 5) * 100 }}%"></div>
                                                </div>
                                                <span
                                                    class="font-xs ml-5 text-muted fw-500 quicksand">({{ $reviews_avg }})</span>
                                            </div>
                                        </div>

                                        @if ($isGift)
                                            <div class="detail-qty border radius bg-light disabled"
                                                style="cursor: not-allowed; opacity: 0.7;"><span
                                                    class="qty-val">1</span></div>
                                        @else
                                            @if ($item->model->out_of_stock != 1)
                                                <div class="detail-extralink mr-15 display-hide-480">
                                                    <div class="detail-qty border radius">
                                                        <a href="#"
                                                            wire:click.prevent="decrementQuantity('{{ $item->rowId }}')"
                                                            class="qty-down"><i
                                                                class="fi-rs-angle-small-down"></i></a>
                                                        <span class="qty-val">{{ $item->qty }}</span>
                                                        <a href="#"
                                                            wire:click.prevent="incrementQuantity('{{ $item->rowId }}')"
                                                            class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                        @if ($item->model->out_of_stock == 1)
                                            <div class="badge bg-danger fs-10 text-white rounded-pill quicksand">Out Of
                                                Stock</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="cart-action d-flex justify-content-between mt-3 mb-40 mb-xl-0">
                        <a href="/shop" class="btn d-flex align-items-center custom-pad"
                            style="max-width: fit-content"><i class="fi-rs-add mr-10"></i>Add More</a>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="cart-sb-wrap">

                        <div class="co-wrap p-3">
                            <h3 class="cart-sb-title">Details</h3>

                            <div class="mb-4">
                                <div class="cart-sb-row muted">
                                    <span class="cart-sb-label">Cart Total (MRP)</span>
                                    <span class="cart-sb-val">₹{{ number_format($total_original_price) }}</span>
                                </div>

                                @php
                                    $cartSubtotalRaw = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
                                    $customer_save_amount = max(0, $total_original_price - $cartSubtotalRaw);
                                @endphp

                                @if ($customer_save_amount > 0)
                                    <div class="cart-sb-row green">
                                        <span class="cart-sb-label">You Save</span>
                                        <span class="cart-sb-val">- ₹{{ number_format($customer_save_amount) }}</span>
                                    </div>
                                @endif

                                <div class="cart-sb-row muted">
                                    <span class="cart-sb-label">Subtotal</span>
                                    <span class="cart-sb-val">₹{{ Cart::instance('cart')->subtotal() }}</span>
                                </div>

                                @if ($extra_discount > 0)
                                    <div class="cart-sb-row green">
                                        <span class="cart-sb-label">Special Discount ({{ $discount_percentage }}%
                                            OFF)</span>
                                        <span class="cart-sb-val">- ₹{{ number_format($extra_discount) }}</span>
                                    </div>
                                @endif

                                @if ($mainDiscountAmount != 0)
                                    <div class="cart-sb-row green">
                                        <span class="cart-sb-label">Coupon Applied @if ($couponCode)
                                                ({{ strtoupper($couponCode) }})
                                            @endif
                                        </span>
                                        <span class="cart-sb-val">- ₹{{ number_format($mainDiscountAmount) }}</span>
                                    </div>
                                @endif

                                @if ($is_first_order && $payment_method == 'online')
                                    <div class="cart-sb-row green">
                                        <span class="cart-sb-label">Prepaid Discount
                                            ({{ fetchDiscountPercentage() }}%) <span
                                                class="cart-sb-auto-badge">AUTO</span></span>
                                        <span class="cart-sb-val">- ₹{{ number_format($onlineDiscountAmount) }}</span>
                                    </div>
                                @endif

                                @if ($payment_method == 'cod')
                                    <div class="cart-sb-row red">
                                        <span class="cart-sb-label">COD Handling Fee</span>
                                        <span class="cart-sb-val">+
                                            ₹{{ number_format(ceil($cash_on_delivery_amount - $online_payment_amount)) }}</span>
                                    </div>
                                @endif

                                <div class="cart-sb-row muted">
                                    <span class="cart-sb-label">Shipping</span>
                                    @if (session('flat_rate_charge'))
                                        <span class="cart-sb-val">₹{{ session('flat_rate_charge') }}</span>
                                    @elseif($online_payment_amount == 0 && $payment_method == 'online')
                                        <span class="cart-sb-val text-success fw-bold"
                                            style="color: #16a34a;">Free</span>
                                    @else
                                        <span class="cart-sb-val">
                                            @if ($payment_method == 'online')
                                                ₹{{ $online_payment_amount }}
                                            @else
                                                ₹{{ $cash_on_delivery_amount }}
                                            @endif
                                        </span>
                                    @endif
                                </div>

                                <div class="cart-sb-divider"></div>

                                <div class="cart-sb-total-row">
                                    <span class="cart-sb-label">Your Total</span>
                                    <span class="cart-sb-val">₹{{ number_format($finalTotal) }}</span>
                                </div>

                                @if ($is_first_order && $payment_method == 'online')
                                    <div class="cart-sb-saved-msg">🎉 You have saved {{ fetchDiscountPercentage() }}%
                                        on every product!!</div>
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
                                    $extra_discount = \App\Models\Setting::where('label', 'extra_discount')->first()
                                        ->value;
                                @endphp
                                <div class="cart-sb-promo-text">Order above ₹{{ $minimum_order_value }}? Get
                                    <b>extra {{ $extra_discount }}% off (upto
                                        ₹{{ $maximum_extra_discount }})</b>
                                </div>
                            </div>

                            @if ($is_first_order)
                                @php
                                    $savings = $potentialCodTotal - $potentialOnlineTotal;
                                @endphp
                                <div class="cart-sb-compare">
                                    <div class="cart-sb-compare-inner">
                                        <div class="cart-sb-compare-half prepaid"
                                            wire:click="paymentMethod('online')">
                                            <div class="cart-sb-compare-title green"><i
                                                    class="fi-rs-check-circle"></i>
                                                Pay Online</div>
                                            <div class="cart-sb-compare-price green">
                                                ₹{{ number_format(ceil($potentialOnlineTotal)) }}</div>
                                            <div class="cart-sb-compare-sub">After {{ fetchDiscountPercentage() }}%
                                                off · Free delivery</div>
                                        </div>
                                        <div class="cart-sb-compare-half cod" wire:click="paymentMethod('cod')">
                                            <div class="cart-sb-compare-title red"><i class="fi-rs-truck"></i> Cash on
                                                Delivery</div>
                                            <div class="cart-sb-compare-price red">
                                                ₹{{ number_format(ceil($potentialCodTotal)) }}</div>
                                            <div class="cart-sb-compare-sub">No discount ·
                                                +₹{{ number_format(ceil($cash_on_delivery_amount - $online_payment_amount)) }}
                                                COD fee</div>
                                        </div>
                                    </div>
                                    <div class="cart-sb-compare-footer">
                                        <i class="fi-rs-star"></i> Save ₹{{ number_format(ceil($savings)) }} by
                                        choosing
                                        Online Payment
                                    </div>
                                </div>

                                <div class="cart-sb-trust-pills">
                                    <span class="cart-sb-trust-pill"><i class="fi-rs-check"></i> Extra discount on
                                        online
                                        payment</span>
                                </div>
                            @endif

                            <h3 class="cart-sb-title mt-2">Select Payment Method</h3>

                            <div class="cart-sb-payment-box {{ $payment_method == 'online' ? 'active' : '' }}"
                                wire:click="paymentMethod('online')">
                                <div class="cart-sb-payment-header">
                                    <div class="cart-sb-radio"></div>
                                    <span class="cart-sb-payment-method-name">Pay via UPI / Credit Card</span>
                                    <span class="cart-sb-express-badge">FREE EXPRESS DELIVERY</span>
                                </div>
                                @if ($is_first_order)
                                    <div class="cart-sb-payment-sub green">Get instant
                                        {{ fetchDiscountPercentage() }}% off on each product</div>
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
                                        handling fee applies · No {{ fetchDiscountPercentage() }}% discount</div>
                                @endif
                            </div>

                            <a href="/checkout"
                                class="btn btn-proceed-checkout mt-3 d-flex justify-content-center align-items-center">
                                Proceed To Checkout <i class="fi-rs-sign-out ms-2"></i>
                            </a>
                        </div>

                        <div class="p-3 border-radius-15 border mt-4 shadow-sm bg-white">
                            <h5 class="mb-3 pb-2 border-bottom">Apply Coupon</h5>
                            <div class="d-flex justify-content-between mb-3">
                                <input class="font-medium pl-15 mr-15 coupon form-control" name="Coupon"
                                    placeholder="Enter Code" wire:model="couponCode">
                                <button class="btn btn-sm" wire:click="applyCoupon('yes')">Apply</button>
                            </div>
                            <div style="max-height: 200px; overflow-y: auto; padding-right: 5px;">
                                @foreach ($display_coupons as $global_coupon)
                                    <div class="border rounded p-2 mb-2" style="background:#f8f9fa; cursor:pointer;"
                                        wire:click.prevent="checkCoupon('{{ $global_coupon->coupon_code }}')">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong
                                                class="{{ $couponCode == $global_coupon->coupon_code ? 'text-success' : 'text-dark' }}">{{ $global_coupon->coupon_code }}</strong>
                                            @if ($couponCode == $global_coupon->coupon_code)
                                                <i class="fi-rs-check text-success"></i>
                                            @endif
                                        </div>
                                        <div class="font-xs text-muted">{{ $global_coupon->description }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @else
            <livewire:user.component.no-item-found-component />
    @endif
    </div>

    <div class="position-fixed bottom-0 bg-white shadow-lg p-3 checkout-btn-fixed w-100 d-block d-sm-none"
        style="z-index: 999">
        <div class="d-flex justify-content-between mb-10">
            <div class="d-flex gap-2 border-0">
                <span class="text-muted fs-14 fw-600">Subtotal:</span>
                <span class="text-brand fs-14 fw-700">₹{{ Cart::instance('cart')->subtotal() }}</span>
            </div>
            <div class="d-flex gap-2 border-0">
                <span class="text-muted fs-14 fw-600">Payable Amount:</span>
                <span class="text-brand fs-14 fw-800">₹{{ number_format($finalTotal) }}</span>
            </div>
        </div>
        <a href="/checkout" class="btn w-100 d-flex justify-content-center align-items-center">
            Proceed To Checkout <i class="fi-rs-sign-out ml-15"></i>
        </a>
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

            if (bar && markerClosed && markerOpen) {
                let finalWidth = parseInt(bar.getAttribute("data-width"));
                let skipAnimation = bar.getAttribute("data-skip") === "true";

                if (skipAnimation) {
                    bar.style.transition = "none";
                    bar.style.width = "100%";
                    markerClosed.style.display = "none";
                    markerOpen.style.display = "block";
                    return;
                }

                if (finalWidth == 0) {
                    bar.style.width = "4%";
                } else {
                    bar.style.width = finalWidth + "%";
                }

                bar.addEventListener("transitionend", function() {
                    let reachedWidth = parseInt(bar.style.width);

                    if (reachedWidth >= 100) {
                        showCongratsOffer();
                        setTimeout(() => {
                            markerClosed.style.display = "none";
                            markerOpen.style.display = "block";
                        }, 800);
                    } else {
                        markerClosed.style.display = "block";
                        markerOpen.style.display = "none";
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            let wishlistModal = null;

            Livewire.on('open-cart-remove-item-modal', () => {
                wishlistModal = new bootstrap.Modal(document.getElementById('CartRemoveItemModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                wishlistModal.show();
            });

            Livewire.on('close-cart-remove-item-modal', () => {
                if (wishlistModal) {
                    wishlistModal.hide();
                }
            });
        });
    </script>
@endpush
