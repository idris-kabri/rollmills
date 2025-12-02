    <main class="main">
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
                /* Key for alignment */
                align-items: center;
                /* Vertically center items */
                justify-content: space-between;
                padding: 12px 10px;
                border-radius: 6px;
                color: var(--color-3);
                font-family: 'Quicksand', sans-serif;
                font-weight: 600;
                text-decoration: none !important;
                transition: all 0.3s ease;
            }

            /* Hover & Active Effects */
            .cat-link:hover {
                background-color: #fff9e6;
                /* Very light gold */
                color: var(--color-2);
                padding-left: 15px;
                /* Slide effect */
            }

            .cat-link.active {
                background-color: #fff9e6;
                color: var(--color-2);
                border-left: 3px solid var(--color-1);
                padding-left: 15px;
            }

            /* Left Side (Icon + Text) */
            .cat-left {
                display: flex;
                align-items: center;
                gap: 12px;
                /* Space between icon and text */
            }

            .cat-icon {
                width: 24px;
                height: 24px;
                object-fit: contain;
                opacity: 0.8;
            }

            .cat-name {
                line-height: 1;
                /* Fixes vertical text alignment */
                margin-top: 2px;
                /* Slight adjustment for visual optical center */
            }

            /* Right Side (Count + Toggle) */
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
                /* Remove default browser appearance */
                -webkit-appearance: none;
                appearance: none;
                /* Define size */
                min-width: 18px;
                width: 18px;
                height: 18px;
                /* Border style (Unchecked) */
                border: 2px solid var(--color-2);
                /* Brownish Gold */
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
                /* Bright Gold */
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
                /* Hidden by default */
                transition: 0.2s transform ease-in-out;
                background-color: var(--color-1);
                /* Bright Gold Dot */
                box-shadow: 0 2px 5px rgba(220, 169, 21, 0.4);
                /* Soft glow */
            }

            .custom-check:checked::before {
                transform: scale(1);
                /* Show dot when checked */
            }

            /* Focus Ring for Accessibility */
            .custom-check:focus {
                outline: none;
                box-shadow: 0 0 0 3px var(--color-light-1);
            }

            .toggle-arrow {
                font-size: 12px;
                color: #aaa;
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
        <div class="page-header mt-30 mb-50">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <h1 class="mb-15">Shop</h1>
                            <div class="breadcrumb">
                                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                                <span></span> Shop
                            </div>
                        </div>
                        {{-- <div class="col-xl-9 text-end d-none d-xl-block">
                            <ul class="tags-list">
                                <li class="hover-up">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Cabbage</a>
                                </li>
                                <li class="hover-up active">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Broccoli</a>
                                </li>
                                <li class="hover-up">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Artichoke</a>
                                </li>
                                <li class="hover-up">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Celery</a>
                                </li>
                                <li class="hover-up mr-0">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Spinach</a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-40">
            <div class="row">
                <div class="col-xl-3 primary-sidebar">
                    <div class="sidebar-widget custom-category-widget mb-30 d-none d-xl-block">
                        <h5 class="section-title style-1 mb-30"
                            style="color: var(--color-3); border-bottom: 2px solid var(--color-1); display: inline-block; padding-bottom: 5px;">
                            Category</h5>

                        <div class="category-list">
                            @foreach ($productCategorys as $category)
                                @php
                                    $subCategories = \App\Models\ProductCategory::where(
                                        'parent_id',
                                        $category->id,
                                    )->get();
                                    // Logic to keep menu open if a child is active
                                    $isActive = $selectedCategory == $category->id;
                                    $isChildActive = $subCategories->contains('id', $selectedCategory);
                                    $isOpen = $isActive || $isChildActive;
                                @endphp

                                <div class="category-list-item" x-data="{ open: @json($isOpen) }">

                                    <a href="#" class="cat-link {{ $isActive ? 'active' : '' }}"
                                        @if ($subCategories->count() > 0) @click.prevent="open = !open" 
                   @else
                       wire:click.prevent="categoryWiseProduct({{ $category->id }}, 'change')" @endif>
                                        <div class="cat-left">
                                            @if ($category->icon)
                                                <img src="{{ asset('storage/' . $category->icon) }}" class="cat-icon"
                                                    alt="{{ $category->name }}" />
                                            @endif
                                            <span class="cat-name">{{ $category->name }}</span>
                                        </div>

                                        <div class="cat-right">
                                            @if ($subCategories->count() > 0)
                                                <i class="fi-rs-angle-small-down toggle-arrow"
                                                    :style="open ? 'transform: rotate(180deg); color: var(--color-2);' :
                                                        'transition: 0.3s;'"></i>
                                            @endif
                                        </div>
                                    </a>

                                    @if ($subCategories->count() > 0)
                                        <div class="sub-cat-container" x-show="open" x-collapse style="display: none;">

                                            <div
                                                class="sub-cat-item {{ $selectedCategory == $category->id ? 'active' : '' }}">
                                                <input type="radio" id="all-cat-{{ $category->id }}"
                                                    name="category_group" class="custom-check"
                                                    wire:click="categoryWiseProduct({{ $category->id }}, 'change')"
                                                    {{ $selectedCategory == $category->id ? 'checked' : '' }}>

                                                <label for="all-cat-{{ $category->id }}"
                                                    style="cursor: pointer; width: 100%; margin: 0;">
                                                    All {{ $category->name }}
                                                </label>
                                            </div>

                                            @foreach ($subCategories as $sub_category)
                                                <div
                                                    class="sub-cat-item {{ $selectedCategory == $sub_category->id ? 'active' : '' }}">
                                                    <input type="radio" id="sub-{{ $sub_category->id }}"
                                                        name="category_group" class="custom-check"
                                                        wire:click="categoryWiseProduct({{ $sub_category->id }}, 'change')"
                                                        {{ $selectedCategory == $sub_category->id ? 'checked' : '' }}>

                                                    <label for="sub-{{ $sub_category->id }}"
                                                        style="cursor: pointer; width: 100%; margin: 0;">
                                                        {{ $sub_category->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter By Price -->
                    <div class="sidebar-widget range mb-30 d-none d-xl-block">
                        <h5 class="section-title style-1 mb-20">Filter by price</h5>
                        <div class="price-filter">
                            <div class="price-filter-inner">

                                <div id="shop-slider-range" class="mb-20" wire:ignore></div>

                                <div class="d-flex justify-content-between align-items-center caption mt-20">
                                    <div class="input-group-price">
                                        <label for="min-input">Min:</label>
                                        <input type="number" class="quicksand form-control" id="min-input"
                                            wire:model.blur="minPrice" min="0" max="10000"
                                            style="width: 80px; padding: 5px; height: 35px;" />
                                    </div>

                                    <div class="input-group-price">
                                        <label for="max-input">Max:</label>
                                        <input type="number" class="quicksand form-control" id="max-input"
                                            wire:model.blur="maxPrice" min="0" max="10000"
                                            style="width: 80px; padding: 5px; height: 35px;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Product sidebar Widget -->
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
                                            <span
                                                class="price-transition mb-0 mt-5">₹{{ $new_product->sale_price }}</span>
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
                                        <div class="product-rating"
                                            style="width: {{ $new_product_reviews_percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="banner-img wow fadeIn mb-lg-0 animated d-xl-block d-none">
                        <img src="{{ asset('storage/' . $shop_page_banner->image) }}" alt="" />
                        <div class="banner-text">
                            <span>{{ $shop_page_banner->heading }}</span>
                            <h4>
                                {!! preg_replace('/<\/?p>/', '', $shop_page_banner->sub_heading) !!}
                            </h4>

                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>We found <strong class="text-brand">{{ $product_count }}</strong> items for you!</p>
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
                                        <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="{{ $sortBy == 'featured' ? 'active' : '' }}" href="#"
                                                wire:click.prevent="setSortBy('featured')">Featured</a></li>
                                        <li><a href="#"
                                                class="{{ $sortBy == 'price-low-to-high' ? 'active' : '' }}"
                                                wire:click.prevent="setSortBy('price-low-to-high')">Price: Low to
                                                High</a></li>
                                        <li><a href="#"
                                                class="{{ $sortBy == 'price-high-to-low' ? 'active' : '' }}"
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
                                        <span class="fw-700"><i
                                                class="fi-rs-apps-sort text-white fw-600"></i>Filter</span>
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
                    <!--product grid-->
                    <div class="pagination-area mt-20 mb-20">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    @push('scripts')
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let componentMinPrice = @json($minPrice);
                let componentMaxPrice = @json($maxPrice);

                // Use the current component values for the slider handles' starting position
                let initialMin = @json($minPrice);
                let initialMax = @json($maxPrice);
                let initialValues = [initialMin, initialMax];

                $("#shop-slider-range").slider({
                    range: true,
                    min: componentMinPrice,
                    max: componentMaxPrice,
                    values: initialValues,

                    // 1. "slide" event: Only update the visual text (No Server Request)
                    slide: function(event, ui) {
                        $("#shop-slider-range-value1").text(ui.values[0]);
                        $("#shop-slider-range-value2").text(ui.values[1]);
                    },

                    // 2. "stop" event: Update Livewire only when user releases the handle
                    stop: function(event, ui) {
                        @this.set('minPrice', ui.values[0]);
                        @this.set('maxPrice', ui.values[1]);
                    }
                });

                // Set initial text based on the slider's starting values
                $("#shop-slider-range-value1").text($("#shop-slider-range").slider("values", 0));
                $("#shop-slider-range-value2").text($("#shop-slider-range").slider("values", 1));
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll("input[type=radio]").forEach(function(radio) {
                    radio.addEventListener('click', function(e) {
                        // If already selected → unselect it
                        if (this.wasChecked) {
                            this.checked = false;
                            this.wasChecked = false;

                            // Trigger Livewire manually if needed
                            this.dispatchEvent(new Event('input'));
                            return;
                        }

                        // Unselect all other radios with same name
                        document.querySelectorAll("input[name='" + this.name + "']").forEach(r => r
                            .wasChecked = false);

                        // Mark this radio as selected
                        this.wasChecked = true;
                    });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // 1. Initial Values from PHP
                let minPrice = parseInt(@json($minPrice)) || 0;
                let maxPrice = parseInt(@json($maxPrice)) || 10000;
                let productMin = parseInt(@json($productsMinAmount)) || 0;
                let productMax = parseInt(@json($productsMaxAmount)) || 10000;

                // 2. Initialize jQuery UI Slider
                $("#shop-slider-range").slider({
                    range: true,
                    min: productMin,
                    max: productMax,
                    values: [minPrice, maxPrice],

                    // Slide: Update inputs visually ONLY (no server request yet)
                    slide: function(event, ui) {
                        $("#min-input").val(ui.values[0]);
                        $("#max-input").val(ui.values[1]);
                    },

                    // Stop: When user releases mouse, update Livewire
                    stop: function(event, ui) {
                        @this.set('minPrice', ui.values[0]);
                        @this.set('maxPrice', ui.values[1]);
                    }
                });

                // 3. Handle Manual Input Changes
                $("#min-input, #max-input").on("change", function() {
                    let currentMin = parseInt($("#min-input").val());
                    let currentMax = parseInt($("#max-input").val());

                    // Validate logic
                    if (currentMin > currentMax) {
                        // If user types min > max, swap them or cap them
                        currentMin = currentMax;
                        $("#min-input").val(currentMin);
                    }

                    // Update Slider Visuals
                    $("#shop-slider-range").slider("values", 0, currentMin);
                    $("#shop-slider-range").slider("values", 1, currentMax);

                    // Update Livewire Manually
                    @this.set('minPrice', currentMin);
                    @this.set('maxPrice', currentMax);
                });
            });

            // 4. Re-initialize slider if Livewire updates other parts of DOM
            // This hook ensures slider stays correct if you filter by Category/Brand
            document.addEventListener('livewire:navigated', () => {
                // Logic to re-run slider setup if needed in SPA mode
            });
        </script>
    @endpush
