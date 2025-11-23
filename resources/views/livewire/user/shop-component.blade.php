    <main class="main">
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
                    <div class="sidebar-widget widget-category-2 mb-30 d-none d-xl-block">
                        <h5 class="section-title style-1 mb-30">Category</h5>
                        <ul>
                            @foreach ($productCategorys as $category)
                                @php
                                    $subCategories = \App\Models\ProductCategory::where(
                                        'parent_id',
                                        $category->id,
                                    )->get();
                                @endphp
                                <li>
                                    <a href="#"
                                        wire:click.prevent="categoryWiseProduct({{ $category->id }}, 'change')"
                                        class="fw-600 quicksand">
                                        @if ($subCategories->count() > 0)
                                            @if ($selectedCategory == $category->id)
                                                <span class="me-2"><i class="fi-rs-angle-small-up"></i></span>
                                            @else
                                                <span class="me-2"><i class="fi-rs-angle-small-down"></i></span>
                                            @endif
                                        @endif
                                        <img src="{{ asset('storage/' . $category->image) }}') }}"
                                            alt="" />{{ $category->name }}
                                    </a>
                                    <span class="count">{{ $category->getProductCategoryAssign->count() ?? 0 }}</span>
                                </li>
                                @if ($subCategories->count() > 0)
                                    @php
                                        $ids = $subCategories->pluck('id')->toArray();
                                        $ids[] = $category->id;
                                    @endphp
                                    <div class="pl-25 py-3{{ in_array($selectedCategory, $ids) ? ' d-block' : ' d-none' }}">
                                        @foreach ($subCategories as $sub_category)
                                            <a href="#" wire:click.prevent="categoryWiseProduct({{ $sub_category->id }}, 'change')" class="form-check">
                                                <input class="form-check-input cart-checkbox-custom" type="checkbox"
                                                    value="" id="flexCheckDefault1" {{ $selectedCategory == $sub_category->id ? 'checked' : '' }}>
                                                <label class="form-check-label hover-a text-heading quicksand fw-600"
                                                    for="flexCheckDefault1">
                                                    {{ $sub_category->name }}
                                                </label>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <!-- Filter By Price -->
                    <div class="sidebar-widget range mb-30 d-none d-xl-block">
                        <h5 class="section-title style-1 mb-30">Filter by price</h5>
                        <div class="price-filter">
                            <div class="price-filter-inner">
                                <div id="shop-slider-range" class="mb-20"></div>

                                <div class="d-flex justify-content-between align-items-center caption mt-20">
                                    <div class="">
                                        <strong class="text-muted fw-600 fs-17 me-1">From :</strong>
                                        <span id="shop-slider-range-value1"
                                            class="text-brand fw-600 fs-17">{{ $minPrice }}</span>
                                    </div>
                                    <div class="">
                                        <strong class="text-muted fw-600 fs-17 me-1">To :</strong>
                                        <span id="shop-slider-range-value2"
                                            class="text-brand fw-600 fs-17">{{ $maxPrice }}</span>
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
                                    <h5><a href="{{ $new_product_shop_detail_url }}">{{ $new_product->name }}</a></h5>

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
                                                wire:click.prevent="setsortBy('featured')">Featured</a></li>
                                        <li><a href="#">Price: Low to High</a></li>
                                        <li><a href="#">Price: High to Low</a></li>
                                        <li><a href="#" class="{{ $sortBy == 'new' ? 'active' : '' }}"
                                                wire:click.prevent="setsortBy('new')">Release Date</a></li>
                                        <li><a href="#">Avg. Rating</a></li>
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

                <div class="col-12 mt-30">
                    <section class="section-padding pb-5">
                        <div class="section-title mb-20">
                            <h3 class="">Deals Of The Day</h3>
                            <a class="show-all" href="shop-grid-right.html">
                                All Deals
                                <i class="fi-rs-angle-right"></i>
                            </a>
                        </div>
                        <div class="row">
                            @foreach ($deals_of_the_day_products as $deals_of_the_day_product)
                                @php
                                    if ($deals_of_the_day_product->slug) {
                                        $deals_of_the_day_product_shop_detail_url = route('shop-detail', [
                                            'slug' => $deals_of_the_day_product->slug,
                                            'id' => $deals_of_the_day_product->id,
                                        ]);
                                    } else {
                                        $deals_of_the_day_product_shop_detail_url = route('shop-detail', [
                                            'slug' => 'no-slug',
                                            'id' => $deals_of_the_day_product->id,
                                        ]);
                                    }
                                @endphp
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="product-cart-wrap style-2">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img">
                                                <a href="{{ $deals_of_the_day_product_shop_detail_url }}">
                                                    <img src="{{ asset('storage/' . $deals_of_the_day_product->featured_image) }}"
                                                        alt="{{ $deals_of_the_day_product->seo_meta }}" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="deals-countdown-wrap">
                                                <div class="deals-countdown"
                                                    data-countdown="{{ \Carbon\Carbon::parse($deals_of_the_day_product->sale_to_date)->format('Y/m/d') }} 00:00:00">
                                                </div>
                                            </div>
                                            <div class="deals-content">
                                                <h2><a
                                                        href="{{ $deals_of_the_day_product_shop_detail_url }}">{{ $deals_of_the_day_product->name }}</a>
                                                </h2>
                                                <div class="product-rate-cover">
                                                    @php
                                                        $deals_of_the_day_product_reviews = \App\Models\ProductReview::where(
                                                            'status',
                                                            1,
                                                        )
                                                            ->where('product_id', $deals_of_the_day_product->id)
                                                            ->get();

                                                        $deals_of_the_day_product_reviews_count = $deals_of_the_day_product_reviews->count();
                                                        $deals_of_the_day_product_reviews_avg =
                                                            $deals_of_the_day_product_reviews_count > 0
                                                                ? round(
                                                                    $deals_of_the_day_product_reviews->avg('ratings'),
                                                                    1,
                                                                )
                                                                : 0;
                                                        $deals_of_the_day_product_reviews_percentage =
                                                            ($deals_of_the_day_product_reviews_avg / 5) * 100;
                                                    @endphp

                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating"
                                                            style="width: {{ $deals_of_the_day_product_reviews_percentage }}%;">
                                                        </div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted">
                                                        ({{ $deals_of_the_day_product_reviews_avg }})
                                                    </span>
                                                </div>
                                                <div class="product-card-bottom">
                                                    <div class="product-price">
                                                        @if (
                                                            $deals_of_the_day_product->sale_price > 0 &&
                                                                now() >= $deals_of_the_day_product->sale_start_date &&
                                                                now() <= $deals_of_the_day_product->sale_end_date)
                                                            <span>₹{{ $deals_of_the_day_product->sale_price }}</span>
                                                            <span
                                                                class="old-price">₹{{ $deals_of_the_day_product->price }}</span>
                                                        @elseif($deals_of_the_day_product->sale_default_price > 0)
                                                            <span>₹{{ $deals_of_the_day_product->sale_default_price }}</span>
                                                            <span
                                                                class="old-price">₹{{ $deals_of_the_day_product->price }}</span>
                                                        @else
                                                            <span>₹{{ $deals_of_the_day_product->price }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="add-cart">
                                                        <a class="add" href="shop-cart.html"><i
                                                                class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- Product sidebar Widget -->
                    <div
                        class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10 d-block d-xl-none card border-2 rounded-20">
                        <h5 class="section-title style-1 mb-30 border-0">New products</h5>
                        <div class="row">
                            @foreach ($new_products as $new_product)
                                <div class="col-md-6">
                                    <div class="single-post clearfix mb-20">
                                        <div class="image">
                                            <img src="{{ asset('storage/' . $new_product->featured_image) }}"
                                                alt="{{ $new_product->seo_meta }}" />
                                        </div>
                                        <div class="content pt-10">
                                            <h5><a href="shop-product-detail.html">{{ $new_product->name }}</a></h5>
                                            <p class="price mb-0 mt-5">₹{{ $new_product->price }}</p>
                                            <div class="product-rate">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="banner-img wow fadeIn mb-lg-0 animated d-xl-none d-block">
                        <img src="{{ asset('storage/' . $shop_page_banner->image) }}" alt="" />
                        <div class="banner-text">
                            <span>{{ $shop_page_banner->heading }}</span>
                            <h4>
                                {{ $shop_page_banner->sub_heading }}
                            </h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    @push('scripts')
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let minPrice = @json($minPrice);
                let maxPrice = @json($maxPrice);

                $("#shop-slider-range").slider({
                    range: true,
                    min: minPrice,
                    max: maxPrice,
                    values: [0, 1000],
                    slide: function(event, ui) {
                        $("#shop-slider-range-value1").text(ui.values[0]);
                        $("#shop-slider-range-value2").text(ui.values[1]);
                    }
                });

                // Set initial text
                $("#shop-slider-range-value1").text($("#shop-slider-range").slider("values", 0));
            });
        </script>
    @endpush
