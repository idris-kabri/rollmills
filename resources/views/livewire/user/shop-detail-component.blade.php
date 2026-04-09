<main class="main">

    <div class="page-header breadcrumb-wrap">
        <div class="">
            <div class="breadcrumb">
                @php
                    $count_category_assign = count($mainProduct->categoryAssigns);
                @endphp
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                @if ($count_category_assign > 1)
                    <span></span> <a
                        href="/shop?category_id={{ $mainProduct->categoryAssigns[$count_category_assign - 1]->category->id }}&category_slug={{ $mainProduct->categoryAssigns[$count_category_assign - 1]->category->slug ?? 'no-slug' }}">{{ $mainProduct->categoryAssigns[$count_category_assign - 1]->category->name }}</a>
                    <span></span> <a
                        href="/shop?category_id={{ $mainProduct->categoryAssigns[0]->category->id }}&category_slug={{ $mainProduct->categoryAssigns[0]->category->slug ?? 'no-slug' }}">{{ $mainProduct->categoryAssigns[0]->category->name }}</a>
                @else
                    <span></span> <a
                        href="/shop?category_id={{ $mainProduct->categoryAssigns[0]->category->id }}&category_slug={{ $mainProduct->categoryAssigns[0]->category->slug ?? 'no-slug' }}">{{ $mainProduct->categoryAssigns[0]->category->name }}</a>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <div class="premium-offer-banner wow animate__animated animate__fadeInDown mt-4">
            <div class="premium-offer-left">
                <div class="premium-offer-icon">
                    <i class="fi-rs-badge"></i>
                </div>
                <div class="premium-offer-text">
                    <h4>Get {{ fetchDiscountPercentage() }}% OFF Instantly!</h4>
                    <p>Pay online via UPI or Card to unlock this exclusive offer.</p>
                </div>
            </div>

            <div class="premium-payment-pill">
                <div class="secure-text">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    100% Secure
                </div>
                <div class="premium-payment-icons">
                    <img src="{{ asset('assets/frontend/imgs/theme/upi_logo.webp') }}" alt="UPI"
                        style="height: 18px;">
                    <img src="{{ asset('assets/frontend/imgs/theme/mastercard_logo.png') }}" alt="MasterCard">
                    <img src="{{ asset('assets/frontend/imgs/theme/rupay.png') }}" alt="RuPay"
                        style="height: 16px;">
                </div>
            </div>
        </div>
    </div>

    <div class="shop-detail-page-main container mb-30">
        <div class="m-auto">
            <div class="product-detail accordion-detail">
                <div class="row mb-50 mt-30">
                    <div class="col-md-5 col-lg-6 col-sm-12 col-xs-12 mb-lg-0 mb-sm-5">
                        <div class="detail-gallery d-xl-inline-block">
                            <div class="d-flex flex-column-reverse flex-xl-row">
                                <div class="col-xl-2 product-slider-main" style='overflow-x: overlay;'>
                                    <div class="product-slider-nav-thumbnails">
                                        <div class="d-flex overflow-hidden img-card">
                                            <a href="#" class="product_gallery_item d-flex"
                                                data-image="{{ asset('storage/' . $mainProduct->featured_image) }}"
                                                data-zoom-image="{{ asset('storage/' . $mainProduct->featured_image) }}">
                                                <img src="{{ asset('storage/' . $mainProduct->featured_image) }}"
                                                    alt="img" class="img-fluid" />
                                            </a>
                                        </div>
                                        @php
                                            $gallary_images = json_decode($mainProduct->images);
                                        @endphp
                                        @foreach ($gallary_images as $image)
                                            <div class="d-flex overflow-hidden img-card">
                                                <a href="#" class="product_gallery_item d-flex"
                                                    data-image="{{ asset('storage/' . $image) }}"
                                                    data-zoom-image="{{ asset('storage/' . $image) }}">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="img"
                                                        class="img-fluid" />
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xl-10 ps-xl-0">
                                    <div class="product-img-fill">
                                        <div class="product-image">
                                            <figure class="border-radius-10 d-flex">
                                                <img src="{{ asset('storage/' . $mainProduct->featured_image) }}"
                                                    alt="img" class="w-100" id="product_img" />
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 col-lg-6 col-sm-12 col-xs-12">
                        @php
                            $original_price = $mainProduct->price;
                            $sale_price = 0;
                            $check_type = '';

                            $currentDate = \Carbon\Carbon::now();
                            $sale_from_date = \Carbon\Carbon::parse($mainProduct->sale_from_date);
                            $sale_to_date = \Carbon\Carbon::parse($mainProduct->sale_to_date);

                            if ($mainProduct->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
                                $sale_price = $mainProduct->sale_price;
                                $check_type = 'sale_product';
                            } elseif ($mainProduct->is_featured == 1 && $check_type == '') {
                                $check_type = 'featured_product';
                            } else {
                                $sale_price = $mainProduct->sale_default_price;
                                $check_type = 'sale_default_product';
                            }
                            $percentage =
                                $original_price > 0 ? (($original_price - $sale_price) / $original_price) * 100 : 0;
                        @endphp

                        <div class="detail-info">
                            @if ($mainProduct->out_of_stock == 0)
                                @if ($check_type == 'sale_product')
                                    <span class="product-cart-componet-badge save">Save
                                        {{ number_format($percentage) }}%</span>
                                @elseif($check_type == 'featured_product')
                                    <span class="product-cart-componet-badge hot">Hot</span>
                                @else
                                    <span class="product-cart-componet-badge save">Save
                                        {{ number_format($percentage) }}%</span>
                                @endif
                            @else
                                <span class="product-cart-componet-badge hot">Out of Stock</span>
                            @endif

                            <h2 class="title-detail">{{ $mainProduct->name }}</h2>

                            @php
                                $review = checkReview();
                            @endphp
                            @if ($review)
                                @php
                                    $percentage = ($mainProduct_reviews_avg / 5) * 100;
                                @endphp
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> ({{ $mainProduct_reviews_count }}
                                            reviews)</span>
                                    </div>
                                </div>
                            @endif

                            @php
                                $original_price = $mainProduct->price;
                                $sale_price = 0;
                                $currentDate = \Carbon\Carbon::now();
                                $sale_from_date = \Carbon\Carbon::parse($mainProduct->sale_from_date);
                                $sale_to_date = \Carbon\Carbon::parse($mainProduct->sale_to_date);
                                $percentage = 0;

                                if (
                                    $mainProduct->sale_price > 0 &&
                                    $currentDate->between($sale_from_date, $sale_to_date)
                                ) {
                                    $sale_price = $mainProduct->sale_price;
                                } elseif ($mainProduct->sale_default_price > 0) {
                                    $sale_price = $mainProduct->sale_default_price;
                                }
                                if ($sale_price > 0) {
                                    $percentage =
                                        $original_price > 0
                                            ? (($original_price - $sale_price) / $original_price) * 100
                                            : 0;
                                }
                            @endphp

                            <div class="clearfix product-price-cover">
                                @if ($sale_price > 0)
                                    <div class="product-price primary-color float-left mb-0">
                                        <span class="current-price text-brand">₹{{ number_format($sale_price) }}</span>
                                        <span>
                                            <span
                                                class="save-price font-md color3 ml-15 fw-700">{{ round($percentage) }}%
                                                Off</span>
                                            <span
                                                class="old-price font-md ml-15">₹{{ number_format($original_price) }}</span>
                                        </span>
                                    </div>
                                @else
                                    <div class="product-price primary-color float-left mb-0">
                                        <span
                                            class="current-price text-brand">₹{{ number_format($mainProduct->price) }}</span>
                                    </div>
                                @endif
                            </div>

                            @php
                                // 1. Get the COD charge from settings
                                $cod_price = (float) \App\Models\Setting::where('label', 'cod_charges')->first()->value;

                                // 2. Determine the active item price (use sale price if available, otherwise regular price)
                                $active_price = $sale_price > 0 ? $sale_price : $mainProduct->price;

                                // 3. Calculate COD Total (Item Price + COD Fee)
                                $cod_total = $active_price;

                                $discount_percent = fetchDiscountPercentage();

                                $prepaid_price = ceil($active_price * ((100 - $discount_percent) / 100));

                                // 5. Calculate Savings (Difference between COD Total and Prepaid Total)
                                $savings = $cod_total - $prepaid_price;

                                // Check if item is already in cart globally here
                                $itemInCart =
                                    \Cart::instance('cart')->content()->where('id', $mainProduct->id)->count() > 0;
                            @endphp

                            @if ($mainProduct->out_of_stock == 0 && !$itemInCart)
                                <div class="theme-prepaid-box">
                                    <div class="theme-prepaid-badges">
                                        <div class="theme-prepaid-badge-yellow">SAVE {{ $discount_percent }}%</div>
                                        <div class="theme-prepaid-badge-green">Free Delivery</div>
                                    </div>

                                    <div class="theme-prepaid-text">
                                        <div class="theme-prepaid-title">Pay Online at <span
                                                class="theme-prepaid-highlight">₹{{ number_format($prepaid_price) }}</span>
                                        </div>
                                        <div class="theme-prepaid-desc">Extra {{ $discount_percent }}% discount + Free
                                            Shipping</div>
                                    </div>

                                    <div class="theme-prepaid-action">
                                        <button type="button" class="theme-prepaid-btn"
                                            wire:click="addToCart('prepaid')" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="addToCart('prepaid')"
                                                style="display: flex; align-items: center; gap: 6px;">
                                                <span class="theme-prepaid-btn-main">PAY ONLINE</span>
                                                <span class="theme-prepaid-btn-sub">Save
                                                    ₹{{ number_format($savings) }}</span>
                                            </span>
                                            <span wire:loading wire:target="addToCart('prepaid')">
                                                <span class="spinner-border spinner-border-sm me-1"></span>
                                                Processing...
                                            </span>
                                        </button>

                                        <div class="theme-prepaid-icons">
                                            <span class="theme-prepaid-icons-text">Via</span>
                                            <img src="{{ asset('assets/frontend/imgs/theme/upi_logo.webp') }}"
                                                alt="UPI">
                                            <img src="{{ asset('assets/frontend/imgs/theme/mastercard_logo.png') }}"
                                                alt="MasterCard">
                                            <img src="{{ asset('assets/frontend/imgs/theme/rupay.png') }}"
                                                alt="RuPay">
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-sb-trust-pills">
                                    <span class="cart-sb-trust-pill"><i class="fi-rs-check"></i> Most customers choose
                                        Prepaid & save more</span>
                                    <span class="cart-sb-trust-pill"><i class="fi-rs-check"></i> Extra discount on
                                        online
                                        payment</span>
                                </div>
                            @endif

                            @php
                                $cart_subtotal = (float) str_replace(',', '', \Cart::instance('cart')->subtotal());
                                $remaining_amount = max(0, $minimum_order_value - $cart_subtotal);
                                $progress_percentage =
                                    $cart_subtotal >= $minimum_order_value
                                        ? 100
                                        : ($cart_subtotal / $minimum_order_value) * 100;
                            @endphp

                            <div
                                class="shipping-widget-container {{ $cart_subtotal >= $minimum_order_value ? 'success' : '' }}">
                                <div class="shipping-text">
                                    @if ($cart_subtotal >= $minimum_order_value)
                                        <div class="shipping-icon-wrapper"
                                            style="background: #dcfce7; color: #16a34a; box-shadow: 0 2px 5px rgba(22, 163, 74, 0.15);">
                                            <i class="fi-rs-check"></i>
                                        </div>
                                        <span>Congratulations! You've unlocked <span
                                                class="shipping-highlight">{{ $discount_percentage }}% OFF</span> your
                                            order!</span>
                                    @else
                                        <div class="shipping-icon-wrapper">
                                            <i class="fi-rs-shopping-bag"></i>
                                        </div>
                                        <span>Add <span
                                                class="shipping-highlight">₹{{ number_format($remaining_amount) }}</span>
                                            more to your cart to get <span
                                                class="shipping-highlight">{{ $discount_percentage }}%
                                                OFF</span>!</span>
                                    @endif
                                </div>
                                <div class="shipping-progress-bg">
                                    <div class="shipping-progress-bar"
                                        style="width: {{ $progress_percentage }}%; background-color: {{ $cart_subtotal >= $minimum_order_value ? '#16a34a' : '#eab308' }};">
                                    </div>
                                </div>
                                @if ($cart_subtotal < $minimum_order_value)
                                    <div class="shipping-status-text">
                                        <div class="current-total-pill">
                                            Current Total: <strong>₹{{ number_format($cart_subtotal) }}</strong> /
                                            ₹{{ number_format($minimum_order_value) }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="theme-single-promo mt-30 mb-30">
                                <div class="promo-content">
                                    <div class="promo-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                                            </path>
                                            <line x1="7" y1="7" x2="7.01" y2="7">
                                            </line>
                                        </svg>
                                    </div>
                                    <div class="promo-text">
                                        <h4>SPECIAL COMBO: BUY 2 AT ₹429</h4>
                                    </div>
                                </div>
                                <div class="promo-action">
                                    <a href="/your-combo-page" class="btn-promo">
                                        BUY NOW &rarr;
                                    </a>
                                </div>
                            </div>
                            <div class="short-desc mb-30">
                                <p class="font-lg">{!! $mainProduct->short_description !!}</p>
                            </div>

                            @foreach ($groupedAttributes as $key => $attributes)
                                <div class="attr-detail attr-size mb-30" wire:ignore>
                                    <strong class="mr-10">{{ $attributes['name'] }}: </strong>
                                    <ul class="list-filter size-filter font-small">
                                        @foreach ($attributes['items'] as $item)
                                            <li class="{{ $selectedAttribute[$key] == $item ? 'active' : '' }}">
                                                <a href="#" class="quicksand"
                                                    wire:click.prevent="handleAttributeClick({{ $key }}, '{{ $item }}')">{{ $item }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach

                            <div class="d-flex detail-extralink flex-wrap gap-3 justify-content-sm-start mb-30">
                                @if ($mainProduct->out_of_stock == 0)
                                    @php
                                        $wishlist = \Cart::instance('wishlist')->search(function (
                                            $wishlistItem,
                                            $rowId,
                                        ) use ($mainProduct) {
                                            return $wishlistItem->model->id === $mainProduct->id;
                                        });
                                    @endphp

                                    @if (!$itemInCart)
                                        <div class="detail-qty border radius ps-4 pt-10 pb-10 me-0">
                                            <a href="#" class="qty-down"
                                                wire:click.prevent="decrementQuantity()"><i
                                                    class="fi-rs-angle-small-down"></i></a>
                                            <input type="text" name="quantity" class="qty-val fw-600 fs-18"
                                                value="1" min="1" wire:model.lazy="quantity">
                                            <a href="#" class="qty-up"
                                                wire:click.prevent="incrementQuantity()"><i
                                                    class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                    @endif

                                    <div class="product-extra-link2">
                                        @if ($itemInCart)
                                            <a href="{{ route('cart') }}" class="btn-view-cart-detail">
                                                <i class="fi-rs-eye"></i> View Cart
                                            </a>
                                        @else
                                            <button type="button" class="button button-add-to-cart"
                                                wire:click="addToCart()" wire:loading.class="disabled">
                                                <span wire:loading.remove wire:target="addToCart"><i
                                                        class="fi-rs-shopping-cart"></i>Add to cart</span>
                                                <span wire:loading wire:target="addToCart"><span
                                                        class="spinner-border spinner-border-sm mr-5"></span>Adding...</span>
                                            </button>
                                        @endif

                                        @if ($wishlist->isNotEmpty())
                                            <a href="/wishlist" aria-label="Add To Wishlist"
                                                class="action-btn hover-up wishlist-detail-active"><i
                                                    class="fi-rs-heart"></i></a>
                                        @else
                                            <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                href="#" wire:click.prevent="addToWhishlist()"><i
                                                    class="fi-rs-heart"></i></a>
                                        @endif
                                    </div>
                                @else
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button btn" disabled><i
                                                class="fi-rs-shopping-cart me-2"></i>Out of Stock</button>
                                    </div>
                                @endif
                            </div>

                            <div class="trust-badge-strip">
                                <div class="trust-badge-item">
                                    <div class="trust-icon-box"><i class="fi-rs-label icon-price"></i></div>
                                    <p class="trust-badge-title">Lowest<br>Price</p>
                                </div>
                                <div class="trust-badge-item">
                                    <div class="trust-icon-box"><i class="fi-rs-rocket icon-express"></i></div>
                                    <p class="trust-badge-title">Express<br>Delivery</p>
                                </div>
                                <div class="trust-badge-item">
                                    <div class="trust-icon-box"><i class="fi-rs-money icon-cod"></i></div>
                                    <p class="trust-badge-title">Cash on<br>Delivery</p>
                                </div>
                                <div class="trust-badge-item">
                                    <div class="trust-icon-box"><i class="fi-rs-refresh icon-return"></i></div>
                                    @if ($mainProduct->product_return_days > 0)
                                        <p class="trust-badge-title">
                                            {{ $mainProduct->product_return_days }}-day<br>Returns</p>
                                    @elseif($mainProduct->product_replacement_days > 0)
                                        <p class="trust-badge-title">
                                            {{ $mainProduct->product_replacement_days }}-day<br>Replacement</p>
                                    @else
                                        <p class="trust-badge-title">No Return <br> Policy</p>
                                    @endif
                                </div>
                            </div>

                            @if (json_decode($mainProduct->specifications))
                                <div class="specs-container">
                                    <h4 class="specs-title">Specifications</h4>
                                    <div class="specs-wrapper collapsed" id="specsWrapper">
                                        <table class="specs-table">
                                            <tbody>
                                                @foreach (json_decode($mainProduct->specifications) as $specification)
                                                    <tr>
                                                        <td>{{ $specification->name }}</td>
                                                        <td>{{ $specification->value }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="gradient-overlay"></div>
                                    </div>

                                    <button type="button" class="specs-toggle-btn" onclick="toggleSpecs(this)">
                                        Show More <i class="fi-rs-angle-down ms-1"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="product-info">
                    <div class="tab-style3" wire:ignore>
                        <ul class="nav nav-tabs text-uppercase">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                    href="#Description">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews
                                    ({{ $mainProduct_reviews_count }})</a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab entry-main-content">
                            <div class="tab-pane fade show active" id="Description">
                                <div class="">
                                    <p>{!! $mainProduct->description !!}</p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="Reviews">
                                @if (count($mainProduct_reviews) > 0)
                                    <div class="comments-area">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4 class="mb-30">Customer questions & answers</h4>
                                                <div class="comment-list comment-list-custom row">
                                                    @foreach ($mainProduct_reviews as $review)
                                                        @php
                                                            $rating = $review->ratings ?? 0;
                                                        @endphp
                                                        <div class="col-md-6">
                                                            <div class="single-comment mb-3 border-bottom">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="me-2 d-flex">
                                                                        <img src="{{ asset('assets/frontend/imgs/blog/author-2.png') }}"
                                                                            alt="">
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0 font-heading text-brand"
                                                                            style="font-size: 14px; font-weight: bold;">
                                                                            {{ $review->name }}</h6>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="stars me-2">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @if ($i <= $rating)
                                                                                <i
                                                                                    class="fas fa-star text-warning"></i>
                                                                            @else
                                                                                <i class="far fa-star text-muted"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </div>
                                                                </div>

                                                                <div class="desc">
                                                                    <p class="mb-0 text-secondary fs-14"
                                                                        style="line-height: 1.3;">
                                                                        {{ $review->remarks }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                @php
                                                    $total_reviews = $mainProduct_reviews->count();
                                                    $average_rating =
                                                        $total_reviews > 0 ? $mainProduct_reviews->avg('ratings') : 0;

                                                    $star_counts = [
                                                        5 => $mainProduct_reviews->where('ratings', 5)->count(),
                                                        4 => $mainProduct_reviews->where('ratings', 4)->count(),
                                                        3 => $mainProduct_reviews->where('ratings', 3)->count(),
                                                        2 => $mainProduct_reviews->where('ratings', 2)->count(),
                                                        1 => $mainProduct_reviews->where('ratings', 1)->count(),
                                                    ];

                                                    $star_percentages = [];
                                                    foreach ($star_counts as $star => $count) {
                                                        $star_percentages[$star] =
                                                            $total_reviews > 0
                                                                ? round(($count / $total_reviews) * 100, 1)
                                                                : 0;
                                                    }

                                                    $average_percentage = ($average_rating / 5) * 100;
                                                @endphp
                                                <div class="position-sticky" style="top: 13%">
                                                    <h4 class="mb-30">Customer reviews</h4>

                                                    <div class="d-flex mb-30 align-items-center">
                                                        <div class="product-rate d-inline-block mr-15">
                                                            <div class="product-rating"
                                                                style="width: {{ $average_percentage }}%"></div>
                                                        </div>
                                                        <h6>{{ number_format($average_rating, 1) }} out of 5</h6>
                                                    </div>

                                                    @foreach ([5, 4, 3, 2, 1] as $star)
                                                        <div class="progress mb-2">
                                                            <span>{{ $star }} star</span>
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $star_percentages[$star] }}%"
                                                                aria-valuenow="{{ $star_percentages[$star] }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                {{ $star_percentages[$star] }}%
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="comment-form">
                                    <h3 class="mb-20">Add a review</h3>
                                    <div class="star_rating mb-20" id="star_rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span data-value="{{ $i }}"><i
                                                    class="{{ $review_rating >= $i ? 'fas' : 'far' }} fa-star fs-22"></i></span>
                                        @endfor
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-12">
                                            <form class="form-contact comment_form" action="#" id="commentForm"
                                                wire:submit.prevent="reviewStore">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label text-secondary fw-600 quicksand mb-1">Enter
                                                                Your Name</label>
                                                            <input class="form-control" name="name" id="name"
                                                                type="text" placeholder="Name"
                                                                wire:model="review_name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label text-secondary fw-600 quicksand mb-1">Upload
                                                                Product Image</label>
                                                            <input class="form-control" name="review_image"
                                                                type="file" wire:model="review_image">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label text-secondary fw-600 quicksand mb-1">Add
                                                                Remarks</label>
                                                            <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                placeholder="Write Comment" wire:model="review_remark"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit"
                                                        class="button button-contactForm fw-600 quicksand">Submit
                                                        Review</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($relatedProducts->count() > 0)
                    <div class="row mt-md-5 mt-4">
                        <div class="col-12">
                            <h2 class="section-title style-1 mb-30">Related products</h2>
                        </div>
                        <div class="col-12">
                            <div class="row related-products">
                                @foreach ($relatedProducts as $relatedProduct)
                                    <div class="col-lg-3 col-md-4 col-6 col-sm-6 small-screen-padding">
                                        @livewire('user.component.product-card', ['product' => $relatedProduct], key($relatedProduct->id . '-' . now()->timestamp))
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

@push('scripts')
    <script>
        function toggleSpecs(btnElement) {
            const wrapper = document.getElementById('specsWrapper');

            if (wrapper.classList.contains('collapsed')) {
                wrapper.classList.remove('collapsed');
                wrapper.classList.add('expanded');
                btnElement.innerHTML = 'Show Less <i class="fi-rs-angle-up ms-1"></i>';
            } else {
                wrapper.classList.remove('expanded');
                wrapper.classList.add('collapsed');
                btnElement.innerHTML = 'Show More <i class="fi-rs-angle-down ms-1"></i>';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#star_rating span');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-value'));
                    @this.set('review_rating', rating);
                    stars.forEach((s, index) => {
                        const starIcon = s.querySelector('i');
                        if (index < rating) {
                            starIcon.classList.remove('far');
                            starIcon.classList.add('fas', 'text-warning');
                        } else {
                            starIcon.classList.remove('fas', 'text-warning');
                            starIcon.classList.add('far');
                        }
                    });
                });
            });
            const mainImage = document.getElementById("product_img");

            document.querySelectorAll(".product_gallery_item").forEach(item => {
                item.addEventListener("mouseover", function(e) {
                    e.preventDefault();
                    const newImage = this.getAttribute("data-image");
                    const zoomImage = this.getAttribute("data-zoom-image");
                    mainImage.src = newImage;
                    mainImage.setAttribute("data-zoom-image", zoomImage);
                    document.querySelectorAll(".product_gallery_item").forEach(el => el.classList
                        .remove("active"));
                    this.classList.add("active");
                });
            });
        });
    </script>
@endpush
