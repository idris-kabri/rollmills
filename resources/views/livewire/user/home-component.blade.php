<main class="main">
    <section class="home-slider style-2 position-relative mb-3" wire:ignore>
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-12">
                    <div class="home-slide-cover">
                        <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                            @foreach ($slider_banner as $slider)
                                @php
                                    $image = 'storage/' . $slider->image;
                                    $words = explode(' ', $slider->heading);
                                    if (count($words) > 2) {
                                        $firstPart = implode(' ', array_slice($words, 0, 2));
                                        $secondPart = implode(' ', array_slice($words, 2));
                                        $newHeading = $firstPart . ' <br> ' . $secondPart;
                                    } else {
                                        $newHeading = $slider->heading;
                                    }
                                @endphp
                                <div class="single-hero-slider single-animation-wrap"
                                    style="background-image: url('{{ asset($image) }}')">
                                    <div class="slider-content">
                                        <h1 class="display-2 mb-40">
                                            {!! $newHeading !!}
                                        </h1>
                                        <p class="mb-65">{{ $slider->sub_heading }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="slider-arrow hero-slider-1-arrow"></div>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-xl-block">
                    @php
                        $second_banner_heading = explode(' ', $top_side_banner->heading);
                        if (count($second_banner_heading) > 1) {
                            $firstPart = implode(' ', array_slice($second_banner_heading, 0, 1));
                            $secondPart = implode(' ', array_slice($second_banner_heading, 1));
                            $newHeadingSide = $firstPart . ' <br> ' . $secondPart;
                        } else {
                            $newHeadingSide = $top_side_banner->heading;
                        }
                        $second_banner_sub_heading = explode(' ', $top_side_banner->sub_heading);
                        if (count($second_banner_sub_heading) > 1) {
                            $firstPart_subheading = implode(' ', array_slice($second_banner_sub_heading, 0, 1));
                            $secondPart_subheading = implode(' ', array_slice($second_banner_sub_heading, 1));
                            $newSubHeadingSide = $firstPart_subheading . ' <br> ' . $secondPart_subheading;
                        } else {
                            $newSubHeadingSide = $top_side_banner->sub_heading;
                        }
                    @endphp
                    <div class="banner-img style-3 animated animated">
                        <div class="banner-text mt-50">
                            <h2 class="mb-50">
                                {!! $newHeadingSide !!}
                                <span class="text-brand">{!! $newSubHeadingSide !!}</span>
                            </h2>
                            <a href="{{ $top_side_banner->link ?? '#' }}"
                                class="btn btn-xs">{{ $top_side_banner->button_text }} <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End hero slider-->
    <section class="popular-categories section-padding" wire:ignore>
        <div class="container wow animate__animated animate__fadeIn">
            <div class="section-title">
                <div class="title">
                    <h3>Featured Categories</h3>
                </div>
                <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow"
                    id="carausel-10-columns-arrows"></div>
            </div>
            <div class="carausel-10-columns-cover position-relative">
                <div class="carausel-10-columns" id="carausel-10-columns">
                    @foreach ($parentCategory as $index => $category)
                        <div class="card-2 wow animate__animated animate__fadeInUp"
                            data-wow-delay=".{{ $index + 1 }}s">
                            <figure class="img-hover-scale overflow-hidden w-100 h-100">
                                <a href="/shop" class="w-100 h-100"><img
                                        src="{{ asset('storage/' . $category->image) }}" alt="" /></a>
                            </figure>
                            <h6><a href="/shop">{{ $category->name }}</a></h6>
                            <span class="fw-600 fs-12 quicksand">{{ $category->product_sum }} items</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="banners mb-25" wire:ignore>
        <div class="container">
            <div class="row">
                @foreach ($middle_page_banner as $index => $banner)
                    @php
                        $class = '';
                        $i = $index + 1;
                        $count = count($middle_page_banner);
                        if ($i == $count) {
                            $class = 'd-md-none d-lg-flex';
                        } else {
                            $class = 'col-md-6';
                        }
                    @endphp
                    <div class="col-lg-4 {{ $class }}">
                        <div class="banner-img">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="" />
                            <div class="banner-text">
                                <h4>
                                    @php
                                        $h_tag = str_replace('<p>', '', $banner->sub_heading);
                                        $h_tag = str_replace('</p>', '', $h_tag);
                                        $h_tag = str_replace('<strong>', '', $h_tag);
                                        $h_tag = str_replace('</strong>', '', $h_tag);
                                    @endphp
                                    {!! $h_tag !!}
                                </h4>
                                <a href="{{ $banner->link ?? '#' }}" class="btn btn-xs">{{ $banner->button_text }}
                                    <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--End banners-->

    <!-- Popular Products Section  -->
    <section class="product-tabs section-padding position-relative">
        <div class="container" wire:ignore.self>
            <div class="section-title style-2">
                <h3>Popular Products</h3>
                <ul class="nav nav-tabs links d-none d-xl-flex" id="">
                    <li class="nav-item">
                        <button wire:click="setPopularProductCategory('all')"
                            class="nav-link {{ $seleted_popular_product_category == 'all' ? 'active' : '' }}"
                            id="" type="button">
                            All
                        </button>
                    </li>
                    @foreach ($parentCategory as $popular_category)
                        <li class="nav-item">
                            <button wire:click="setPopularProductCategory('{{ $popular_category->id }}')"
                                class="nav-link {{ $seleted_popular_product_category == $popular_category->id ? 'active' : '' }}"
                                type="button" wire:key="popular-category-{{ $popular_category->id }}">
                                {{ $popular_category->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-end d-xl-none">
                    <a class="categories-button-active custom-dropdown-home gap-2" href="#">
                        <span class="fi-rs-apps text-white fs-12"></span> All Categories
                        <i class="fi-rs-angle-down fs-12"></i>
                    </a>
                    <div
                        class="categories-dropdown-wrap categories-dropdown-active-large-2 categories-dropdown-active-large font-heading">
                        <div class="categori-dropdown-inner" wire:ignore.self>
                            <ul>
                                @foreach ($parentCategory as $popular_category)
                                    <li>
                                        <a href="javascript:void(0)"
                                            wire:click="setPopularProductCategory('{{ $popular_category->id }}')">
                                            <img src="{{ asset('storage/' . $popular_category->image) }}"
                                                alt="">
                                            {{ $popular_category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--End nav-tabs-->
            <div class="row product-grid-4">
                @if (count($popular_products) > 0)
                    @foreach ($popular_products as $popular_product)
                        <div class="col-lg-1-5 col-md-4 col-6">
                            @livewire('user.component.product-card', ['product' => $popular_product, 'parameter' => 'hot'], key($popular_product->id . '-' . now()->timestamp))
                        </div>
                    @endforeach
                @else
                    <h4 class="text-danger text-center">No Item Found!</h4>
                @endif
            </div>
            <!--End tab-content-->
        </div>
    </section>


    <!--Daily Best Sells Tabs-->
    <section class="section-padding pb-5">
        <div class="container">
            <div class="section-title">
                <h3 class="">Daily Best Sells</h3>
            </div>
            <div class="row">
                <div class="col-lg-3 d-none d-lg-flex">
                    <div class="banner-img style-2"
                        style="background: url('{{ asset('storage/' . $best_deal_banner->image) }}');">
                        <div class="banner-text">
                            <h2 class="mb-100">{{ $best_deal_banner->heading }}</h2>
                            <a href="{{ $best_deal_banner->link ?? '#' }}"
                                class="btn btn-xs">{{ $best_deal_banner->button_text }} <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img"
                                                src="http://127.0.0.1:8000/storage/product/ZfI0KNnFPmNbTq21ZWpM9qbVp7uUkQNyiWbE85qc.jpg"
                                                alt="">
                                            <img class="hover-img"
                                                src="http://127.0.0.1:8000/storage/product/kf8XtFfszLmAeEDUCP5RwgdN20iYVUBDPgUvbjVL.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Hot</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap mt-2">
                                    <h2><a href="shop-product-right.html">Sturlite Prima High Bay 6000K</a></h2>
                                    <div class="product-rate-cover">

                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 0%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            (0)
                                        </span>
                                    </div>

                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <!--[if BLOCK]><![endif]--> <span>₹3465</span>
                                            <span class="old-price">₹6790</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]-->
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img"
                                                src="http://127.0.0.1:8000/storage/product/ZfI0KNnFPmNbTq21ZWpM9qbVp7uUkQNyiWbE85qc.jpg"
                                                alt="">
                                            <img class="hover-img"
                                                src="http://127.0.0.1:8000/storage/product/kf8XtFfszLmAeEDUCP5RwgdN20iYVUBDPgUvbjVL.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Hot</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap mt-2">
                                    <h2><a href="shop-product-right.html">Sturlite Prima High Bay 6000K</a></h2>
                                    <div class="product-rate-cover">

                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 0%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            (0)
                                        </span>
                                    </div>

                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <!--[if BLOCK]><![endif]--> <span>₹3465</span>
                                            <span class="old-price">₹6790</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]-->
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img"
                                                src="http://127.0.0.1:8000/storage/product/ZfI0KNnFPmNbTq21ZWpM9qbVp7uUkQNyiWbE85qc.jpg"
                                                alt="">
                                            <img class="hover-img"
                                                src="http://127.0.0.1:8000/storage/product/kf8XtFfszLmAeEDUCP5RwgdN20iYVUBDPgUvbjVL.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Hot</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap mt-2">
                                    <h2><a href="shop-product-right.html">Sturlite Prima High Bay 6000K</a></h2>
                                    <div class="product-rate-cover">

                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 0%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            (0)
                                        </span>
                                    </div>

                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <!--[if BLOCK]><![endif]--> <span>₹3465</span>
                                            <span class="old-price">₹6790</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]-->
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img"
                                                src="http://127.0.0.1:8000/storage/product/ZfI0KNnFPmNbTq21ZWpM9qbVp7uUkQNyiWbE85qc.jpg"
                                                alt="">
                                            <img class="hover-img"
                                                src="http://127.0.0.1:8000/storage/product/kf8XtFfszLmAeEDUCP5RwgdN20iYVUBDPgUvbjVL.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Hot</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap mt-2">
                                    <h2><a href="shop-product-right.html">Sturlite Prima High Bay 6000K</a></h2>
                                    <div class="product-rate-cover">

                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 0%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            (0)
                                        </span>
                                    </div>

                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <!--[if BLOCK]><![endif]--> <span>₹3465</span>
                                            <span class="old-price">₹6790</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]-->
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--End Best Sales-->
    <section class="section-padding pb-5 mt-25" wire:ignore>
        <div class="container">
            <div class="section-title">
                <h3 class="">Deals Of The Day</h3>
                <a class="show-all" href="shop-grid-right.html">
                    All Deals
                    <i class="fi-rs-angle-right"></i>
                </a>
            </div>
            <div class="row">
                @foreach ($deals_of_the_day_products as $deals_of_the_day_product)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-20">
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
                                    <h2><a href="shop-product-right.html">{{ $deals_of_the_day_product->name }}</a>
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
                                                <span class="old-price">₹{{ $deals_of_the_day_product->price }}</span>
                                            @elseif($deals_of_the_day_product->sale_default_price > 0)
                                                <span>₹{{ $deals_of_the_day_product->sale_default_price }}</span>
                                                <span class="old-price">₹{{ $deals_of_the_day_product->price }}</span>
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
                @foreach ($deals_of_the_day_products as $deals_of_the_day_product)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-20">
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
                                    <h2><a href="shop-product-right.html">{{ $deals_of_the_day_product->name }}</a>
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
                                                <span class="old-price">₹{{ $deals_of_the_day_product->price }}</span>
                                            @elseif($deals_of_the_day_product->sale_default_price > 0)
                                                <span>₹{{ $deals_of_the_day_product->sale_default_price }}</span>
                                                <span class="old-price">₹{{ $deals_of_the_day_product->price }}</span>
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
        </div>
    </section>
    <!--End Deals-->


    <!--Daily Best Sells Tabs-->
    <section class="section-padding pb-25">
        <div class="container">
            <div class="section-title">
                <h3 class="">Daily Best Sells</h3>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img"
                                                src="http://127.0.0.1:8000/storage/product/ZfI0KNnFPmNbTq21ZWpM9qbVp7uUkQNyiWbE85qc.jpg"
                                                alt="">
                                            <img class="hover-img"
                                                src="http://127.0.0.1:8000/storage/product/kf8XtFfszLmAeEDUCP5RwgdN20iYVUBDPgUvbjVL.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <!--[if BLOCK]><![endif]--> <!--[if BLOCK]><![endif]--> <span
                                            class="hot">Hot</span>
                                        <!--[if ENDBLOCK]><![endif]-->
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                                <div class="product-content-wrap mt-2">
                                    <h2><a href="shop-product-right.html">Sturlite Prima High Bay 6000K</a></h2>
                                    <div class="product-rate-cover">

                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 0%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            (0)
                                        </span>
                                    </div>

                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <!--[if BLOCK]><![endif]--> <span>₹3465</span>
                                            <span class="old-price">₹6790</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]-->
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div wire:snapshot="{&quot;data&quot;:{&quot;product&quot;:[null,{&quot;class&quot;:&quot;App\\Models\\Product&quot;,&quot;key&quot;:479,&quot;s&quot;:&quot;mdl&quot;}],&quot;parameter&quot;:&quot;hot&quot;,&quot;get_sold&quot;:false},&quot;memo&quot;:{&quot;id&quot;:&quot;Q2zK7Z18o92xXQ67P0Ly&quot;,&quot;name&quot;:&quot;user.component.product-card&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;45091f99a0a187e36d7c6f22e8b4f56f311654d4068c5d0d1b8bbdd1e73e72d1&quot;}"
                                wire:effects="[]" wire:id="Q2zK7Z18o92xXQ67P0Ly" class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img"
                                                src="http://127.0.0.1:8000/storage/product/ETFuxZr0pIPee64snV6MTLa7ATZT6KoPCzteRn7j.jpg"
                                                alt="">
                                            <img class="hover-img"
                                                src="http://127.0.0.1:8000/storage/product/qIWBeem4ONffdaBXljCmJExx6Wp7eXgI5LgVs6bf.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <!--[if BLOCK]><![endif]--> <!--[if BLOCK]><![endif]--> <span
                                            class="hot">Hot</span>
                                        <!--[if ENDBLOCK]><![endif]-->
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                                <div class="product-content-wrap mt-2">
                                    <h2><a href="shop-product-right.html">Cera Gayle Sink Mixer F1014501</a></h2>
                                    <div class="product-rate-cover">

                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 0%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            (0)
                                        </span>
                                    </div>

                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <!--[if BLOCK]><![endif]--> <span>₹3849</span>
                                            <span class="old-price">₹5920</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]-->
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div wire:snapshot="{&quot;data&quot;:{&quot;product&quot;:[null,{&quot;class&quot;:&quot;App\\Models\\Product&quot;,&quot;key&quot;:432,&quot;s&quot;:&quot;mdl&quot;}],&quot;parameter&quot;:&quot;hot&quot;,&quot;get_sold&quot;:false},&quot;memo&quot;:{&quot;id&quot;:&quot;mextcZ66rcBARL3jUmZh&quot;,&quot;name&quot;:&quot;user.component.product-card&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;78c12063ae42410b0e5e58f6207e0f1fca2f071747626879dabce2a73a3c6a4c&quot;}"
                                wire:effects="[]" wire:id="mextcZ66rcBARL3jUmZh" class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img"
                                                src="http://127.0.0.1:8000/storage/product/8qrQcYnUcW9BX2O8DRfQyOa0heTljqq5DI0SnGrn.jpg"
                                                alt="">
                                            <img class="hover-img"
                                                src="http://127.0.0.1:8000/storage/product/rYzW2KGcEUh8Q8PFbM7hxxs1uFkASC5AipGjJuZg.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <!--[if BLOCK]><![endif]--> <!--[if BLOCK]><![endif]--> <span
                                            class="hot">Hot</span>
                                        <!--[if ENDBLOCK]><![endif]-->
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                                <div class="product-content-wrap mt-2">
                                    <h2><a href="shop-product-right.html">Cera Chromo Wall Mixer 3-In 1 F1019403</a>
                                    </h2>
                                    <div class="product-rate-cover">

                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 0%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            (0)
                                        </span>
                                    </div>

                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <!--[if BLOCK]><![endif]--> <span>₹4249</span>
                                            <span class="old-price">₹6500</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]-->
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div wire:snapshot="{&quot;data&quot;:{&quot;product&quot;:[null,{&quot;class&quot;:&quot;App\\Models\\Product&quot;,&quot;key&quot;:415,&quot;s&quot;:&quot;mdl&quot;}],&quot;parameter&quot;:&quot;hot&quot;,&quot;get_sold&quot;:false},&quot;memo&quot;:{&quot;id&quot;:&quot;Jr5GuJd1bkI0YmF9tIMV&quot;,&quot;name&quot;:&quot;user.component.product-card&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;4907aa88c79fc689a84dd7001926f07b979d922680bd3ac95f5470cdb550b1e6&quot;}"
                                wire:effects="[]" wire:id="Jr5GuJd1bkI0YmF9tIMV" class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img"
                                                src="http://127.0.0.1:8000/storage/product/2YE4UlS7IqZf2CkxM1TS0j8hzbeKM5CAOKDYaoUB.jpg"
                                                alt="">
                                            <img class="hover-img"
                                                src="http://127.0.0.1:8000/storage/product/8lq6n0NJWQwyUThaLkOQQfkeQF2MmvsBuksIghEh.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <!--[if BLOCK]><![endif]--> <!--[if BLOCK]><![endif]--> <span
                                            class="hot">Hot</span>
                                        <!--[if ENDBLOCK]><![endif]-->
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                                <div class="product-content-wrap mt-2">
                                    <h2><a href="shop-product-right.html">Cera Chromo 2-Way Angle Cock F1019211</a>
                                    </h2>
                                    <div class="product-rate-cover">

                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 0%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            (0)
                                        </span>
                                    </div>

                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <!--[if BLOCK]><![endif]--> <span>₹1299</span>
                                            <span class="old-price">₹2000</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]-->
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-none d-lg-flex">
                    <div class="banner-img style-2"
                        style="background: url('{{ asset('storage/' . $best_deal_banner->image) }}');">
                        <div class="banner-text">
                            <h2 class="mb-100">{{ $best_deal_banner->heading }}</h2>
                            <a href="{{ $best_deal_banner->link ?? '#' }}"
                                class="btn btn-xs">{{ $best_deal_banner->button_text }} <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section-padding mb-30" wire:ignore>
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0">
                    <h4 class="section-title style-1 mb-30 animated animated">Top Selling</h4>
                    <div class="product-list-small animated animated">
                        @foreach ($top_selling as $product)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="shop-product-right.html"><img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="shop-product-right.html">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        @if ($product->sale_price > 0 && now() >= $product->sale_start_date && now() <= $product->sale_end_date)
                                            <span>₹{{ $product->sale_price }}</span>
                                            <span class="old-price">₹{{ $product->price }}</span>
                                        @elseif($product->sale_default_price > 0)
                                            <span>₹{{ $product->sale_default_price }}</span>
                                            <span class="old-price">₹{{ $product->price }}</span>
                                        @else
                                            <span>₹{{ $product->price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0">
                    <h4 class="section-title style-1 mb-30 animated animated">Trending Products</h4>
                    <div class="product-list-small animated animated">
                        @foreach ($trending_products as $product)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="shop-product-right.html"><img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="shop-product-right.html">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        @if ($product->sale_price > 0 && now() >= $product->sale_start_date && now() <= $product->sale_end_date)
                                            <span>₹{{ $product->sale_price }}</span>
                                            <span class="old-price">₹{{ $product->price }}</span>
                                        @elseif($product->sale_default_price > 0)
                                            <span>₹{{ $product->sale_default_price }}</span>
                                            <span class="old-price">₹{{ $product->price }}</span>
                                        @else
                                            <span>₹{{ $product->price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block">
                    <h4 class="section-title style-1 mb-30 animated animated">Recently added</h4>
                    <div class="product-list-small animated animated">
                        @foreach ($latest_products as $product)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="shop-product-right.html"><img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="shop-product-right.html">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        @if ($product->sale_price > 0 && now() >= $product->sale_start_date && now() <= $product->sale_end_date)
                                            <span>₹{{ $product->sale_price }}</span>
                                            <span class="old-price">₹{{ $product->price }}</span>
                                        @elseif($product->sale_default_price > 0)
                                            <span>₹{{ $product->sale_default_price }}</span>
                                            <span class="old-price">₹{{ $product->price }}</span>
                                        @else
                                            <span>₹{{ $product->price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block">
                    <h4 class="section-title style-1 mb-30 animated animated">Top Rated</h4>
                    <div class="product-list-small animated animated">
                        @foreach ($top_rated_products as $product)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="shop-product-right.html"><img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="shop-product-right.html">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        @if ($product->sale_price > 0 && now() >= $product->sale_start_date && now() <= $product->sale_end_date)
                                            <span>₹{{ $product->sale_price }}</span>
                                            <span class="old-price">₹{{ $product->price }}</span>
                                        @elseif($product->sale_default_price > 0)
                                            <span>₹{{ $product->sale_default_price }}</span>
                                            <span class="old-price">₹{{ $product->price }}</span>
                                        @else
                                            <span>₹{{ $product->price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End 4 columns-->
    <section class="popular-categories section-padding" wire:ignore>
        <div class="container">
            <div class="section-title">
                <div class="title">
                    <h3>Shop by Categories</h3>
                    <a class="show-all" href="shop-grid-right.html">
                        All Categories
                        <i class="fi-rs-angle-right"></i>
                    </a>
                </div>
                <div class="slider-arrow slider-arrow-2 flex-right carausel-8-columns-arrow"
                    id="carausel-8-columns-arrows"></div>
            </div>
            <div class="carausel-8-columns-cover position-relative">
                <div class="carausel-8-columns" id="carausel-8-columns">
                    @foreach ($parentCategory as $index => $category)
                        <div class="card-1">
                            <figure class="img-hover-scale overflow-hidden">
                                <a href="shop-grid-right.html"><img src="{{ asset('storage/' . $category->image) }}"
                                        alt="" /></a>
                            </figure>
                            <h6>
                                <a href="shop-grid-right.html">{{ $category->name }}</a>
                            </h6>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!--End category slider-->
</main>

{{-- @push('scripts')
    <script>
        $(document).ready(function() {
            $("#product-owl-carousel").owlCarousel({
                loop: true,
                margin: 15,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    1200: {
                        items: 4,
                    },
                },
                navText: [
                    '<i class="fi-rs-arrow-small-left"></i>',
                    '<i class="fi-rs-arrow-small-right"></i>',
                ],
            });
        });
    </script>
@endpush --}}
