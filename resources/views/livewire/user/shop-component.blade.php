<main class="main">
    <div class="container">
        <div class="rm-ticket-banner wow animate__animated animate__fadeInDown">
            <div class="rm-ticket-content">
                <div class="rm-ticket-icon">
                    <i class="fi-rs-gift"></i>
                </div>

                <div class="rm-ticket-text">
                    Pay using UPI/Card and get <span class="rm-ticket-highlight">20% OFF</span>
                </div>

                <a href="/shop" class="rm-ticket-btn btn-loop-animate">
                    Shop Now
                </a>
            </div>
        </div>
    </div>
    @livewire('user.quick-view', ['id' => $selectedProductId], key('quickview'))

    <style>
        /* ... existing styles ... */

        :root {
            --color-1: #dca915;
            --color-2: #a36f02;
            --color-3: #543606;
            --color-light-1: #dcaa15b7;
        }

        /* Container Card Style */
        .custom-category-widget {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 25px;
            border: 1px solid #f0f0f0;
        }

        .category-list-item {
            border-bottom: 1px dashed #eee;
            margin-bottom: 5px;
        }

        .category-list-item:last-child {
            border-bottom: none;
        }

        /* Main Category Link Design */
        .cat-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 10px;
            border-radius: 6px;
            color: var(--color-3);
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.3s ease;
        }

        .cat-link:hover {
            background-color: #fff9e6;
            color: var(--color-2);
            padding-left: 15px;
        }

        .cat-link.active {
            background-color: #fff9e6;
            color: var(--color-2);
            border-left: 3px solid var(--color-1);
            padding-left: 15px;
        }

        .cat-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cat-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
            opacity: 0.8;
        }

        .cat-name {
            line-height: 1;
            margin-top: 2px;
        }

        .cat-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .count-badge {
            background-color: var(--color-1);
            color: #fff;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 10px;
            min-width: 24px;
            text-align: center;
        }

        /* Subcategory Styles */
        .sub-cat-container {
            background: #fbfbfb;
            margin: 0 10px 10px 10px;
            padding: 10px;
            border-radius: 8px;
            border-left: 2px solid #eee;
        }

        .sub-cat-item {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            color: #666;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.2s;
        }

        .sub-cat-item:hover {
            color: var(--color-2);
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .sub-cat-item.active {
            color: var(--color-2);
            font-weight: 700;
            background: #fff;
        }

        .custom-check {
            -webkit-appearance: none;
            appearance: none;
            min-width: 18px;
            width: 18px;
            height: 18px;
            border: 2px solid var(--color-2);
            border-radius: 50%;
            margin-right: 12px;
            cursor: pointer;
            position: relative;
            background-color: #fff;
            transition: all 0.3s ease;
            display: grid;
            place-content: center;
        }

        .custom-check:hover {
            border-color: var(--color-1);
            background-color: #fffdf5;
        }

        .custom-check:checked {
            border-color: var(--color-1);
        }

        .custom-check::before {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            transform: scale(0);
            transition: 0.2s transform ease-in-out;
            background-color: var(--color-1);
            box-shadow: 0 2px 5px rgba(220, 169, 21, 0.4);
        }

        .custom-check:checked::before {
            transform: scale(1);
        }

        .custom-check:focus {
            outline: none;
            box-shadow: 0 0 0 3px var(--color-light-1);
        }

        .toggle-arrow {
            font-size: 12px;
            color: #aaa;
        }

        /* =========================================
               NEW: COD to Prepaid Conversion Popup CSS
               ========================================= */
        .cod-modal-content {
            border-radius: 16px;
            border: none;
            font-family: 'Quicksand', sans-serif;
        }

        .cod-modal-header {
            background: linear-gradient(135deg, #fff9e6 0%, #fffdf5 100%);
            padding: 30px 20px 15px;
            text-align: center;
            border-bottom: none;
            position: relative;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .cod-discount-badge {
            position: absolute;
            top: -15px;
            right: 20px;
            background-color: #ff4757;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(255, 71, 87, 0.3);
            transform: rotate(5deg);
            animation: pulseBadge 2s infinite;
            z-index: 10;
        }

        @keyframes pulseBadge {
            0% {
                transform: scale(1) rotate(5deg);
            }

            50% {
                transform: scale(1.08) rotate(5deg);
            }

            100% {
                transform: scale(1) rotate(5deg);
            }
        }

        .cod-price-box {
            background: #fff;
            border: 2px dashed var(--color-1);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .cod-price-divider {
            width: 1px;
            height: 50px;
            background-color: #eee;
        }

        .btn-pay-prepaid {
            background-color: var(--color-1);
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 169, 21, 0.3);
        }

        .btn-pay-prepaid:hover {
            background-color: var(--color-2);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(163, 111, 2, 0.4);
        }

        .btn-continue-cod {
            color: #999;
            background: transparent;
            border: none;
            font-size: 13px;
            font-weight: 600;
            margin-top: 15px;
            text-decoration: underline;
            transition: 0.2s;
            width: 100%;
        }

        .btn-continue-cod:hover {
            color: var(--color-3);
        }

        .cod-benefits {
            padding-left: 0;
            list-style: none;
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }

        .cod-benefits li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cod-benefits i {
            color: #28a745;
            font-size: 16px;
            margin-right: 8px;
        }

        .gift-icon-bounce {
            width: 50px;
            margin-bottom: 10px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }
    </style>

    <style>
        .ui-widget.ui-widget-content {
            border: none;
            height: 0.4rem;
            background: #e9e9e985;
        }

        .price-filter .caption {
            font-size: 15px;
            font-weight: 500;
        }

        .ui-widget-header {
            border: 1px solid #dddddd;
            background: #dca915;
            color: #333333;
            font-weight: bold;
        }
    </style>

    <div class="container mb-40 mt-40">
        <div class="row">
            <div class="col-xl-3 primary-sidebar">
                <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10 d-none d-xl-block">
                    <h5 class="section-title style-1 mb-30">New products</h5>
                    @foreach ($new_products as $new_product)
                        @php
                            if ($new_product->slug) {
                                $new_product_shop_detail_url = route('shop-detail', [
                                    'slug' => $new_product->slug,
                                    'id' => $new_product->id,
                                ]);
                            } else {
                                $new_product_shop_detail_url = route('shop-detail', [
                                    'slug' => 'no-slug',
                                    'id' => $new_product->id,
                                ]);
                            }
                        @endphp
                        <div class="single-post clearfix">
                            <div class="image">
                                <img src="{{ asset('storage/' . $new_product->featured_image) }}"
                                    alt="{{ $new_product->seo_meta }}" />
                            </div>
                            <div class="content pt-10">
                                <h5><a href="{{ $new_product_shop_detail_url }}"
                                        class="two-liner-text">{{ $new_product->name }}</a></h5>

                                <div class="product-price">
                                    @if ($new_product->sale_price > 0 && now() >= $new_product->sale_start_date && now() <= $new_product->sale_end_date)
                                        <span class="price-transition mb-0 mt-5">₹{{ $new_product->sale_price }}</span>
                                        <span class="old-price mb-0 mt-5">
                                            <del>₹{{ $new_product->price }}</del></span>
                                    @elseif($new_product->sale_default_price > 0)
                                        <span
                                            class="price-transition mb-0 mt-5">₹{{ $new_product->sale_default_price }}</span>
                                        <span class="old-price mb-0 mt-5">
                                            <del>₹{{ $new_product->price }}</del></span>
                                    @else
                                        <span class="price-transition mb-0 mt-5">₹{{ $new_product->price }}</span>
                                    @endif
                                </div>

                                @php
                                    $new_product_reviews = \App\Models\ProductReview::where('status', 1)
                                        ->where('product_id', $new_product->id)
                                        ->get();

                                    $new_product_reviews_count = $new_product_reviews->count();
                                    $new_product_reviews_avg =
                                        $new_product_reviews_count > 0
                                            ? round($new_product_reviews->avg('ratings'), 1)
                                            : 0;
                                    $new_product_reviews_percentage = ($new_product_reviews_avg / 5) * 100;
                                @endphp

                                <div class="product-rate">
                                    <div class="product-rating" style="width: {{ $new_product_reviews_percentage }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($shop_page_banner != null)
                    <div class="banner-img wow fadeIn mb-lg-0 animated d-xl-block d-none">
                        <img src="{{ asset('storage/' . $shop_page_banner->image) }}" alt="" />
                        <div class="banner-text">
                            <span>{{ $shop_page_banner->heading }}</span>
                            <h4>
                                {!! preg_replace('/<\/?p>/', '', $shop_page_banner->sub_heading) !!}
                            </h4>

                        </div>
                    </div>
                @endif
            </div>

            <div class="col-xl-9">
                <div class="shop-product-fillter">
                    <div class="totall-product">
                        <p>We found <strong class="text-brand">{{ count($products) }}</strong> items for you!</p>
                    </div>
                    <div class="sort-by-product-area flex-wrap justify-content-center">
                        <div class="sort-by-cover mr-10 mt-2">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps"></i>Show:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> {{ $limit }} <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="{{ $limit == 50 ? 'active' : '' }}" href="#"
                                            wire:click.prevent="setLimit(50)">50</a></li>
                                    <li><a href="#" class="{{ $limit == 100 ? 'active' : '' }}"
                                            wire:click.prevent="setLimit(100)">100</a></li>
                                    <li><a href="#" class="{{ $limit == 150 ? 'active' : '' }}"
                                            wire:click.prevent="setLimit(150)">150</a></li>
                                    <li><a href="#" class="{{ $limit == 200 ? 'active' : '' }}"
                                            wire:click.prevent="setLimit(200)">200</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="sort-by-cover mt-2 mr-10">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> {{ ucfirst(str_replace('-', ' ', $sortBy)) }} <i
                                            class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="{{ $sortBy == 'featured' ? 'active' : '' }}" href="#"
                                            wire:click.prevent="setSortBy('featured')">Featured</a></li>
                                    <li><a href="#" class="{{ $sortBy == 'price-low-to-high' ? 'active' : '' }}"
                                            wire:click.prevent="setSortBy('price-low-to-high')">Price: Low to
                                            High</a></li>
                                    <li><a href="#" class="{{ $sortBy == 'price-high-to-low' ? 'active' : '' }}"
                                            wire:click.prevent="setSortBy('price-high-to-low')">Price: High to
                                            Low</a></li>
                                    <li><a href="#" class="{{ $sortBy == 'new' ? 'active' : '' }}"
                                            wire:click.prevent="setSortBy('new')">Release Date</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="sort-by-cover mt-2 d-block d-xl-none">
                            <div class="sort-by-product-wrap bg-brand text-white shop-filter">
                                <div class="sort-by">
                                    <span class="fw-700"><i class="fi-rs-apps-sort text-white fw-600"></i>Filter</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row product-grid">
                    @foreach ($products as $product)
                        <div class="col-xl-3 col-md-4 col-6">
                            @livewire('user.component.product-card', ['product' => $product], key($product->id . '-' . now()->timestamp))
                        </div>
                    @endforeach
                </div>
                <div class="pagination-area mt-20 mb-20">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="codConversionModal" tabindex="-1" aria-labelledby="codConversionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content cod-modal-content shadow-lg">

                <div class="cod-modal-header">
                    <div class="cod-discount-badge">
                        20% OFF
                    </div>
                    <img src="https://cdn-icons-png.flaticon.com/512/726/726182.png" alt="Gift"
                        class="gift-icon-bounce">
                    <h4 class="fw-bold mb-1" style="color: var(--color-3);">Wait! Don't pay full price.</h4>
                    <p class="text-muted small mb-0">Switch to Prepaid (UPI/Card) and save instantly on your order.</p>
                </div>

                <div class="modal-body p-4 pt-4">
                    <div class="cod-price-box">
                        <div class="cod-price-item w-50 pe-2 text-center">
                            <span class="d-block text-muted small fw-bold text-uppercase mb-1">Paying on
                                Delivery</span>
                            <span class="fs-5 fw-bold text-decoration-line-through text-danger">₹1,000</span>
                        </div>

                        <div class="cod-price-divider"></div>

                        <div class="cod-price-item w-50 ps-2 text-center">
                            <span class="d-block text-success small fw-bold text-uppercase mb-1">Paying Now</span>
                            <span class="fs-3 fw-bold" style="color: var(--color-2);">₹800</span>
                        </div>
                    </div>

                    <ul class="cod-benefits">
                        <li><i class="fi-rs-check-circle"></i> Instant 20% discount applied</li>
                        <li><i class="fi-rs-check-circle"></i> Faster, priority dispatch</li>
                        <li><i class="fi-rs-check-circle"></i> Secure payments via Razorpay/Stripe</li>
                    </ul>

                    <div class="text-center mt-4">
                        <button type="button" class="btn-pay-prepaid" wire:click="switchToPrepaid"
                            data-bs-dismiss="modal">
                            💳 Pay Now & Save 20%
                        </button>
                        <button type="button" class="btn-continue-cod" data-bs-dismiss="modal"
                            wire:click="continueWithCOD">
                            No thanks, I'll pay full price on delivery
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let componentMinPrice = @json($minPrice);
            let componentMaxPrice = @json($maxPrice);
            let initialMin = @json($minPrice);
            let initialMax = @json($maxPrice);
            let initialValues = [initialMin, initialMax];

            $("#shop-slider-range").slider({
                range: true,
                min: componentMinPrice,
                max: componentMaxPrice,
                values: initialValues,
                slide: function(event, ui) {
                    $("#shop-slider-range-value1").text(ui.values[0]);
                    $("#shop-slider-range-value2").text(ui.values[1]);
                },
                stop: function(event, ui) {
                    @this.set('minPrice', ui.values[0]);
                    @this.set('maxPrice', ui.values[1]);
                }
            });
            $("#shop-slider-range-value1").text($("#shop-slider-range").slider("values", 0));
            $("#shop-slider-range-value2").text($("#shop-slider-range").slider("values", 1));
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll("input[type=radio]").forEach(function(radio) {
                radio.addEventListener('click', function(e) {
                    if (this.wasChecked) {
                        this.checked = false;
                        this.wasChecked = false;
                        this.dispatchEvent(new Event('input'));
                        return;
                    }
                    document.querySelectorAll("input[name='" + this.name + "']").forEach(r => r
                        .wasChecked = false);
                    this.wasChecked = true;
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let minPrice = parseInt(@json($minPrice)) || 0;
            let maxPrice = parseInt(@json($maxPrice)) || 10000;
            let productMin = parseInt(@json($productsMinAmount)) || 0;
            let productMax = parseInt(@json($productsMaxAmount)) || 10000;

            $("#shop-slider-range").slider({
                range: true,
                min: productMin,
                max: productMax,
                values: [minPrice, maxPrice],
                slide: function(event, ui) {
                    $("#min-input").val(ui.values[0]);
                    $("#max-input").val(ui.values[1]);
                },
                stop: function(event, ui) {
                    @this.set('minPrice', ui.values[0]);
                    @this.set('maxPrice', ui.values[1]);
                }
            });

            $("#min-input, #max-input").on("change", function() {
                let currentMin = parseInt($("#min-input").val());
                let currentMax = parseInt($("#max-input").val());

                if (currentMin > currentMax) {
                    currentMin = currentMax;
                    $("#min-input").val(currentMin);
                }

                $("#shop-slider-range").slider("values", 0, currentMin);
                $("#shop-slider-range").slider("values", 1, currentMax);

                @this.set('minPrice', currentMin);
                @this.set('maxPrice', currentMax);
            });
        });
    </script>
    <script>
        document.addEventListener('openQuickView', function(e) {
            let modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            modal.show();
        });

        // Script to listen for Livewire event to trigger the COD Modal
        document.addEventListener('openCodModal', function(e) {
            let codModal = new bootstrap.Modal(document.getElementById('codConversionModal'));
            codModal.show();
        });
    </script>
@endpush
