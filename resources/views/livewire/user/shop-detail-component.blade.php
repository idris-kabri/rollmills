<main class="main">
    <style>
        @media (max-width: 1200px) {

            .container.shop-detail-page-main,
            .container.footer-strip,
            .container.footer-mid-inner,
            .container.footer-lower {
                padding: 0 1rem !important;
                max-width: 100%;
            }
        }

        /* --- TRUST BADGE STRIP --- */
        .trust-badge-strip {
            background-color: #eef2ff;
            border-radius: 12px;
            padding: 20px 10px;
            margin-top: 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            text-align: center;
            border: 1px solid #e0e6fd;
        }

        .trust-badge-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .trust-badge-item:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background-color: #d4dbf0;
        }

        .trust-icon-box {
            background-color: #ffffff;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .trust-icon-box i {
            font-size: 20px;
        }

        .icon-price,
        .icon-cod {
            color: #00b59c;
        }

        .icon-return {
            color: #fd7e14;
        }

        .trust-badge-title {
            font-size: 13px;
            font-weight: 700;
            color: #333;
            margin: 0;
            line-height: 1.2;
        }

        /* --- SPECS TOGGLE STYLES (SIDEBAR VERSION) --- */
        .specs-container {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .specs-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        .specs-wrapper {
            position: relative;
            overflow: hidden;
            transition: max-height 0.5s ease-in-out;
        }

        /* Collapsed: Shows ~3 rows */
        .specs-wrapper.collapsed {
            max-height: 140px;
        }

        /* Expanded */
        .specs-wrapper.expanded {
            max-height: 2000px;
        }

        .gradient-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50px;
            /* Shorter gradient for side column */
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1));
            pointer-events: none;
            transition: opacity 0.3s;
            opacity: 1;
        }

        .specs-wrapper.expanded .gradient-overlay {
            opacity: 0;
        }

        /* Table adjustments for Sidebar */
        .specs-table {
            width: 100%;
            font-size: 13px;
            /* Slightly smaller for sidebar */
        }

        .specs-table td {
            padding: 8px 5px;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: top;
        }

        .specs-table td:first-child {
            color: #777;
            font-weight: 600;
            width: 45%;
        }

        .specs-table td:last-child {
            color: #333;
            font-weight: 500;
            text-align: right;
        }

        .specs-toggle-btn {
            background: none;
            border: none;
            color: #00b59c;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            padding: 10px 0 0 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            width: 100%;
            justify-content: center;
        }

        .specs-toggle-btn:hover {
            text-decoration: underline;
        }
    </style>

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
        <div class="rm-ticket-banner wow animate__animated animate__fadeInDown">
            <div class="rm-ticket-content">
                <div class="rm-ticket-icon">
                    <i class="fi-rs-gift"></i>
                </div>

                <div class="rm-ticket-text">
                    Pay online and get <span class="rm-ticket-highlight">10% OFF</span> on 1st order
                </div>

                <a href="/shop" class="rm-ticket-btn btn-loop-animate">
                    Shop Now
                </a>
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
                                    <div class="product-price primary-color float-left">
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
                                    <div class="product-price primary-color float-left">
                                        <span
                                            class="current-price text-brand">${{ number_format($mainProduct->price) }}</span>
                                    </div>
                                @endif
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
                                    <div class="detail-qty border radius ps-4 pt-10 pb-10 me-0">
                                        <a href="#" class="qty-down" wire:click.prevent="decrementQuantity()"><i
                                                class="fi-rs-angle-small-down"></i></a>
                                        <input type="text" name="quantity" class="qty-val fw-600 fs-18"
                                            value="1" min="1" wire:model.lazy="quantity">
                                        <a href="#" class="qty-up" wire:click.prevent="incrementQuantity()"><i
                                                class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        @php
                                            $wishlist = Cart::instance('wishlist')->search(function (
                                                $wishlistItem,
                                                $rowId,
                                            ) use ($mainProduct) {
                                                return $wishlistItem->model->id === $mainProduct->id;
                                            });
                                        @endphp
                                        <button type="button" class="button button-add-to-cart"
                                            wire:click="addToCart()"><i class="fi-rs-shopping-cart"></i>Add to
                                            cart</button>
                                        @if ($wishlist->isNotEmpty())
                                            <a href="javascript:void(0);" aria-label="Add To Wishlist"
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
                                        <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn hover-up"
                                            href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                    </div>
                                @endif
                            </div>

                            <div class="trust-badge-strip">
                                <div class="trust-badge-item">
                                    <div class="trust-icon-box">
                                        <i class="fi-rs-label icon-price"></i>
                                    </div>
                                    <p class="trust-badge-title">Lowest<br>Price</p>
                                </div>
                                <div class="trust-badge-item">
                                    <div class="trust-icon-box">
                                        <i class="fi-rs-money icon-cod"></i>
                                    </div>
                                    <p class="trust-badge-title">Cash on<br>Delivery</p>
                                </div>
                                <div class="trust-badge-item">
                                    <div class="trust-icon-box">
                                        <i class="fi-rs-refresh icon-return"></i>
                                    </div>
                                    @if ($mainProduct->product_return_days > 0)
                                        <p class="trust-badge-title">
                                            {{ $mainProduct->product_return_days }}-day<br>Returns</p>
                                    @else
                                        <p class="trust-badge-title">Easy<br>Returns</p>
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
                                                                        {{-- Profile Image Logic --}}
                                                                        <img src="{{ asset('assets/frontend/imgs/blog/author-2.png') }}"
                                                                            alt="">
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0 font-heading text-brand"
                                                                            style="font-size: 14px; font-weight: bold;">
                                                                            {{ $review->name }}
                                                                        </h6>
                                                                    </div>
                                                                </div>

                                                                {{-- 2. Star Ratings Section --}}
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="stars me-2">
                                                                        {{-- Loop to display 5 stars --}}
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @if ($i <= $rating)
                                                                                {{-- Filled Star (Orange) --}}
                                                                                <i
                                                                                    class="fas fa-star text-warning"></i>
                                                                            @else
                                                                                {{-- Empty Star (Grey) --}}
                                                                                <i class="far fa-star text-muted"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </div>
                                                                </div>

                                                                <div class="desc">
                                                                    <p class="mb-0 text-secondary fs-14"
                                                                        style="line-height: 1.3;">
                                                                        {{ $review->remarks }}
                                                                    </p>
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
                                            <span data-value="{{ $i }}">
                                                <i
                                                    class="{{ $review_rating >= $i ? 'fas' : 'far' }} fa-star fs-22"></i>
                                            </span>
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
        // --- JS FUNCTION FOR TABLE TOGGLE ---
        function toggleSpecs(btnElement) {
            const wrapper = document.getElementById('specsWrapper');

            if (wrapper.classList.contains('collapsed')) {
                // Open it
                wrapper.classList.remove('collapsed');
                wrapper.classList.add('expanded');
                btnElement.innerHTML = 'Show Less <i class="fi-rs-angle-up ms-1"></i>';
            } else {
                // Close it
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

                    // Update Livewire property
                    @this.set('review_rating', rating);

                    // Update star colors visually
                    stars.forEach((s, index) => {
                        const starIcon = s.querySelector('i');
                        if (index < rating) {
                            starIcon.classList.remove('far');
                            starIcon.classList.add('fas', 'text-warning'); // gold color
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

                    // active class handling
                    document.querySelectorAll(".product_gallery_item").forEach(el => el.classList
                        .remove("active"));
                    this.classList.add("active");
                });
            });
        });
    </script>
@endpush
