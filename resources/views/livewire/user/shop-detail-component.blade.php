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
                                            <a href="#" class="product_gallery_item d-flex active"
                                                data-image="{{ asset('storage/' . $mainProduct->featured_image) }}"
                                                data-zoom-image="{{ asset('storage/' . $mainProduct->featured_image) }}">
                                                <img src="{{ asset('storage/' . $mainProduct->featured_image) }}"
                                                    alt="img" class="img-fluid" />
                                            </a>
                                        </div>
                                        @php
                                            $gallary_images = json_decode($mainProduct->images) ?? [];
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
                                $sale_price = $mainProduct->sale_default_price;
                            } else {
                                $sale_price = $mainProduct->sale_default_price;
                                $check_type = 'sale_default_product';
                            }
                            $percentage =
                                $original_price > 0 ? (($original_price - $sale_price) / $original_price) * 100 : 0;

                            $active_price = $sale_price > 0 ? $sale_price : $mainProduct->price;
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
                                    $review_percentage = ($mainProduct_reviews_avg / 5) * 100;
                                @endphp
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: {{ $review_percentage }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> ({{ $mainProduct_reviews_count }}
                                            reviews)</span>
                                    </div>
                                </div>
                            @endif

                            <div class="clearfix product-price-cover mb-2">
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

                            <div class="mb-20">
                                <div class="shipping-tag">
                                    <span class="tag-icon"><i class="fi-rs-shield-check"></i></span>
                                    <span class="tag-text">Free Shipping and COD Available</span>
                                </div>
                            </div>

                            <div class="short-desc mb-30 mt-20">
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

                            @php
                                $itemInCart =
                                    \Cart::instance('cart')->content()->where('id', $mainProduct->id)->count() > 0;
                            @endphp

                            <div class="d-flex detail-extralink flex-wrap gap-3 justify-content-sm-start mb-15">
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

                                    <div class="product-extra-link2 d-flex gap-2 w-100-mobile">
                                        @if ($itemInCart)
                                            <a href="{{ route('cart') }}" class="btn-view-cart-detail">
                                                <i class="fi-rs-eye"></i> View Cart
                                            </a>
                                        @else
                                            <button type="button" class="button button-add-to-cart-outline"
                                                wire:click="addToCart()" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="addToCart"><i
                                                        class="fi-rs-shopping-cart"></i>Add to Cart</span>
                                                <span wire:loading wire:target="addToCart"><span
                                                        class="spinner-border spinner-border-sm mr-5"></span>Adding...</span>
                                            </button>

                                            <button type="button" class="button button-buy-now"
                                                wire:click="addToCart('checkout')" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="addToCart('checkout')"><i
                                                        class="fi-rs-bolt"></i>Buy Now</span>
                                                <span wire:loading wire:target="addToCart('checkout')"><span
                                                        class="spinner-border spinner-border-sm mr-5"></span>Processing...</span>
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

                            @php
                                $discount_percent = fetchDiscountPercentage();
                                $prepaid_price = ceil($active_price * ((100 - $discount_percent) / 100));
                                $savings = $active_price - $prepaid_price;
                            @endphp

                            @if ($mainProduct->out_of_stock == 0 && !$itemInCart)
                                <div class="theme-prepaid-box">
                                    <div class="theme-prepaid-badges">
                                        <div class="theme-prepaid-badge-yellow">SAVE {{ $discount_percent }}%</div>
                                    </div>

                                    <div class="theme-prepaid-text">
                                        <div class="theme-prepaid-title">Pay Online at <span
                                                class="theme-prepaid-highlight">₹{{ number_format($prepaid_price) }}</span>
                                        </div>
                                        <div class="theme-prepaid-desc">Extra {{ $discount_percent }}% discount</div>
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
                                    <span class="cart-sb-trust-pill"><i class="fi-rs-check"></i> Extra discount on
                                        online payment</span>
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
                                        @include('partials.reviews_block')
                                    </div>
                                @endif
                                <div class="comment-form">
                                    <h3 class="mb-20">Add a review</h3>
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

    @if ($mainProduct->out_of_stock == 0 && !$itemInCart)
        <div class="mobile-sticky-bar d-lg-none">
            <div class="sticky-left">
                <div class="sticky-price">₹{{ number_format($active_price) }}</div>
                <div class="sticky-shipping">Free Delivery and COD available</div>
            </div>
            <div class="sticky-right">
                <button type="button" wire:click="addToCart()" class="btn-sticky-cart">
                    <i class="fi-rs-shopping-cart"></i>
                </button>
                <button type="button" wire:click="addToCart('checkout')" class="btn-sticky-buy">
                    BUY NOW
                </button>
            </div>
        </div>
    @endif

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
