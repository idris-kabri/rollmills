    <main class="main">
        <div class="page-header mt-30 mb-50">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <h1 class="mb-15">Snack</h1>
                            <div class="breadcrumb">
                                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                                <span></span> Shop <span></span> Snack
                            </div>
                        </div>
                        <div class="col-xl-9 text-end d-none d-xl-block">
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
                        </div>
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
                            @foreach ($categories as $category)
                                <li>
                                    <a href="shop-grid-right.html"> <img
                                            src="{{ asset('storage/' . $category->image) }}') }}"
                                            alt="" />{{ $category->name }}</a><span
                                        class="count">{{ $category->getProductCategoryAssign->count() ?? 0 }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Fillter By Price -->
                    <div class="sidebar-widget price_range range mb-30 d-none d-xl-block">
                        <h5 class="section-title style-1 mb-30">Filter by price</h5>
                        <div class="price-filter">
                            <div class="price-filter-inner">
                                <div id="slider-range" class="mb-20"></div>
                                <div class="d-flex justify-content-between">
                                    <div class="caption">From: <strong id="slider-range-value1"
                                            class="text-brand"></strong></div>
                                    <div class="caption">To: <strong id="slider-range-value2"
                                            class="text-brand"></strong></div>
                                </div>
                            </div>
                        </div>
                        <a href="shop-grid-right.html" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i>
                            Fillter</a>
                    </div>
                    <!-- Product sidebar Widget -->
                    <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10 d-none d-xl-block">
                        <h5 class="section-title style-1 mb-30">New products</h5>
                        @foreach ($new_products as $new_product)
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="{{ asset('storage/' . $new_product->featured_image) }}" alt="#" />
                                </div>
                                <div class="content pt-10">
                                    <h5><a href="shop-product-detail.html">{{ $new_product->name }}</a></h5>
                                    <p class="price mb-0 mt-5">₹{{ $new_product->price }}</p>
                                    <div class="product-rate">
                                        <div class="product-rating" style="width: 90%"></div>
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
                                        <li><a class="{{ $sortby == 'featured' ? 'active' : '' }}" href="#" wire:click.prevent="setSortBy('featured')">Featured</a></li>
                                        <li><a href="#">Price: Low to High</a></li>
                                        <li><a href="#">Price: High to Low</a></li>
                                        <li><a href="#" class="{{ $sortby == 'new' ? 'active' : '' }}" wire:click.prevent="setSortBy('new')">Release Date</a></li>
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
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="#">6</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                                </li>
                            </ul>
                        </nav>
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
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="product-cart-wrap style-2">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img">
                                                <a href="shop-product-right.html">
                                                    <img src="{{ asset('storage/' . $deals_of_the_day_product->featured_image) }}"
                                                        alt="" />
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
                                                        href="shop-product-right.html">{{ $deals_of_the_day_product->name }}</a>
                                                </h2>
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
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
                                                alt="#" />
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
