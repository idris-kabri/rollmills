<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ strip_tags($og_title ?? ($meta_title ?? 'RollMills - Household & Decoration')) }}</title>

    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    {{-- 2. Dynamic Description & Keywords --}}
    <meta name="description"
        content="{{ strip_tags($meta_description ?? 'Welcome to Roll Mills - Your trusted destination for high quality Household And Decoration products.') }}" />

    <meta name="keywords"
        content="{{ strip_tags($meta_keywords ?? 'household, decoration, rollmills, home decor, hanging Perfume, candles') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- 3. Dynamic Open Graph (Social Media) Tags --}}
    <meta property="og:title" content="{{ strip_tags($og_title ?? ($meta_title ?? 'RollMills')) }}" />
    <meta property="og:type" content="{{ $og_type ?? 'website' }}" />
    <meta property="og:url" content="{{ $og_url ?? url()->current() }}" />
    <meta property="og:image" content="{{ $og_image ?? asset('assets/frontend/imgs/theme/logo.png') }}" />

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/frontend/imgs/theme/logo.png') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main.css') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/plugins/slider-range.css') }}" />
    <!-- Custom New CSS -->
    <link rel="stylesheet" href="{{ asset('assets/custom_css/index.css') }}" />
    @if (Request::is('coupon-claim'))
        <link rel="stylesheet" href="{{ asset('assets/frontend/css/apply_coupon.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('assets/custom_css/improve.css') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Font Family Courier Prime --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    {{-- OwlCarousel --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        crossorigin="anonymous" />

    {{-- flaticon icons --}}
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MDW5GGDD');
    </script>
    <!-- End Google Tag Manager -->


    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MDW5GGDD" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>

    @livewireStyles
</head>

<body>
    @livewire('user.component.login-component')

    @php
        $categories = \App\Models\ProductCategory::where('status', 1)->where('parent_id', null)->get();
    @endphp
    <header class="header-area header-style-1 header-height-2">
        <div class="mobile-promotion">
            <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-xl-block">
            <div class="container">
                <div class="header-wrap justify-content-between">
                    <div class="logo logo-width-1 ms-3">
                        <a href="/"><img src="{{ asset('assets/frontend/imgs/theme/logo.png') }}" alt="logo"
                                class="img-fluid" /></a>
                    </div>
                    {{-- <div class="header-right"> --}}
                    @livewire('user.component.search-component')
                    @livewire('user.component.header-cart-component')
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container h-100">
                <div class="header-wrap header-space-between position-relative h-100">
                    <div class="logo logo-width-1 d-block d-xl-none h-100">
                        <a href="/" class="h-100 align-items-center d-flex"><img
                                src="{{ asset('assets/frontend/imgs/theme/logo.png') }}" alt="logo"
                                class="img-fluid" /></a>
                    </div>
                    <div class="header-nav d-none d-xl-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active" href="#">
                                <span class="fi-rs-apps"></span> <span class="et">Browse</span> All Categories
                                <i class="fi-rs-angle-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                                <div class="d-flex categori-dropdown-inner">
                                    @php
                                        $firstTen = $categories->take(10);
                                        $remaining = $categories->skip(10);
                                    @endphp
                                    @foreach ($firstTen->split(2) as $chunk)
                                        <ul>
                                            @foreach ($chunk as $category)
                                                <li>
                                                    {{-- Replace 'category.show' with your actual route name --}}
                                                    <a
                                                        href="{{ route('shop') }}?category_id={{ $category->id }}&category_slug={{ $category->slug ?? 'no-slug' }}">
                                                        <img src="{{ asset('storage/' . $category->icon) }}"
                                                            alt="{{ $category->name }}" />
                                                        {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                                @if ($categories->count() > 10)
                                    <div class="more_slide_open" style="display: none">
                                        <div class="d-flex categori-dropdown-inner">
                                            @foreach ($remaining->split(2) as $chunk)
                                                <ul>
                                                    @foreach ($chunk as $category)
                                                        <li>
                                                            <a href="shop-grid-right.html"> <img
                                                                    src="{{ asset('storage/' . $category->icon) }}"
                                                                    alt="" />{{ $category->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="more_categories"><span class="icon"></span> <span
                                            class="heading-sm-1">Show more...</span></div>
                                @endif
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    {{-- <li class="hot-deals"><img
                                            src="{{ asset('assets/frontend/imgs/theme/icons/icon-hot.svg') }}"
                                            alt="hot deals" /><a href="shop-grid-right.html">Deals</a>
                                    </li> --}}
                                    <li>
                                        <a class="{{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
                                    </li>

                                    <li>
                                        <a href="/shop" class="{{ Request::is('shop') ? 'active' : '' }}">Shop </a>
                                    </li>
                                    {{-- <li class="position-static">
                                        <a href="#">Mega menu <i class="fi-rs-angle-down"></i></a>
                                        <ul class="mega-menu">
                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                <a class="menu-title" href="#">Fruit & Vegetables</a>
                                                <ul>
                                                    <li><a href="shop-product-right.html">Meat & Poultry</a></li>
                                                    <li><a href="shop-product-right.html">Fresh Vegetables</a></li>
                                                    <li><a href="shop-product-right.html">Herbs & Seasonings</a></li>
                                                    <li><a href="shop-product-right.html">Cuts & Sprouts</a></li>
                                                    <li><a href="shop-product-right.html">Exotic Fruits & Veggies</a>
                                                    </li>
                                                    <li><a href="shop-product-right.html">Packaged Produce</a></li>
                                                </ul>
                                            </li>
                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                <a class="menu-title" href="#">Breakfast & Dairy</a>
                                                <ul>
                                                    <li><a href="shop-product-right.html">Milk & Flavoured Milk</a>
                                                    </li>
                                                    <li><a href="shop-product-right.html">Butter and Margarine</a></li>
                                                    <li><a href="shop-product-right.html">Eggs Substitutes</a></li>
                                                    <li><a href="shop-product-right.html">Marmalades</a></li>
                                                    <li><a href="shop-product-right.html">Sour Cream</a></li>
                                                    <li><a href="shop-product-right.html">Cheese</a></li>
                                                </ul>
                                            </li>
                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                <a class="menu-title" href="#">Meat & Seafood</a>
                                                <ul>
                                                    <li><a href="shop-product-right.html">Breakfast Sausage</a></li>
                                                    <li><a href="shop-product-right.html">Dinner Sausage</a></li>
                                                    <li><a href="shop-product-right.html">Chicken</a></li>
                                                    <li><a href="shop-product-right.html">Sliced Deli Meat</a></li>
                                                    <li><a href="shop-product-right.html">Wild Caught Fillets</a></li>
                                                    <li><a href="shop-product-right.html">Crab and Shellfish</a></li>
                                                </ul>
                                            </li>
                                            <li class="sub-mega-menu sub-mega-menu-width-34">
                                                <div class="menu-banner-wrap">
                                                    <a href="shop-product-right.html"><img
                                                            src="{{ asset('assets/frontend/imgs/banner/banner-menu.png') }}"
                                                            alt="Nest" /></a>
                                                    <div class="menu-banner-content">
                                                        <h4>Hot deals</h4>
                                                        <h3>
                                                            Don't miss<br />
                                                            Trending
                                                        </h3>
                                                        <div class="menu-banner-price">
                                                            <span class="new-price text-success">Save to 50%</span>
                                                        </div>
                                                        <div class="menu-banner-btn">
                                                            <a href="shop-product-right.html">Shop now</a>
                                                        </div>
                                                    </div>
                                                    <div class="menu-banner-discount">
                                                        <h3>
                                                            <span>25%</span>
                                                            off
                                                        </h3>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="/blog">Blog</a>
                                    </li> --}}
                                    <li>
                                        <a href="/about" class="{{ Request::is('about') ? 'active' : '' }}">About
                                            Us</a>
                                    </li>
                                    <li>
                                        <a href="/contact"
                                            class="{{ Request::is('contact') ? 'active' : '' }}">Contact Us</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-xl-flex align-items-center">
                        <a href="tel:+91 87647 66553" class="d-flex align-items-center">
                            <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-headphone.svg') }}"
                                alt="hotline" style="width: 32px" class="img-color" />
                            <p class="fs-18 text-dark fw-600">+91 87647 66553</p>
                        </a>
                    </div>
                    <div class="d-none d-md-flex d-xl-none mx-auto">
                        <div class="header-wrap justify-content-between">
                            @livewire('user.component.search-component')
                        </div>
                    </div>
                    <div class="header-action-icon-2 d-block d-xl-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-xl-none">
                        @livewire('user.component.mobile-header-cart-component')
                    </div>
                </div>
                <div
                    class="d-flex justify-content-between d-md-none mobile-category-options header-style-1 mt-15 mb-10 px-1">
                    <div class="main-categori-wrap mr-15">
                        <a class="categories-button-active p-15" href="#">
                            <span class="fi-rs-apps m-0"></span>
                        </a>
                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="d-flex categori-dropdown-inner">
                                @php
                                    $firstTen = $categories->take(10);
                                    $remaining = $categories->skip(10);
                                @endphp
                                @foreach ($firstTen->split(2) as $chunk)
                                    <ul>
                                        @foreach ($chunk as $category)
                                            <li>
                                                {{-- Replace 'category.show' with your actual route name --}}
                                                <a
                                                    href="{{ route('shop') }}?category_id={{ $category->id }}&category_slug={{ $category->slug ?? 'no-slug' }}">
                                                    <img src="{{ asset('storage/' . $category->icon) }}"
                                                        alt="{{ $category->name }}" />
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                            @if ($categories->count() > 10)
                                <div class="more_slide_open" style="display: none">
                                    <div class="d-flex categori-dropdown-inner">
                                        @foreach ($remaining->split(2) as $chunk)
                                            <ul>
                                                @foreach ($chunk as $category)
                                                    <li>
                                                        <a href="shop-grid-right.html"> <img
                                                                src="{{ asset('storage/' . $category->icon) }}"
                                                                alt="" />{{ $category->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="more_categories"><span class="icon"></span> <span
                                        class="heading-sm-1">Show more...</span></div>
                            @endif
                        </div>
                    </div>
                    <div class="header-wrap justify-content-between w-100">
                        @livewire('user.component.search-component')
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="/"><img src="{{ asset('assets/frontend/imgs/theme/logo.png') }}"
                            alt="logo" /></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="/shop" method="get">
                        <input type="text" name="search" placeholder="Search for items…" />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li class="menu-item-has-children">
                                <a href="/">Home</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="/shop">shop</a>
                                {{-- <ul class="dropdown">
                                    <li><a href="shop-grid-right.html">Shop Grid – Right Sidebar</a></li>
                                    <li><a href="shop-grid-left.html">Shop Grid – Left Sidebar</a></li>
                                    <li><a href="shop-list-right.html">Shop List – Right Sidebar</a></li>
                                    <li><a href="shop-list-left.html">Shop List – Left Sidebar</a></li>
                                    <li><a href="shop-fullwidth.html">Shop - Wide</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Single Product</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Product – Right Sidebar</a></li>
                                            <li><a href="shop-product-left.html">Product – Left Sidebar</a></li>
                                            <li><a href="shop-product-full.html">Product – No sidebar</a></li>
                                            <li><a href="shop-product-vendor.html">Product – Vendor Infor</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="shop-filter.html">Shop – Filter</a></li>
                                    <li><a href="shop-wishlist.html">Shop – Wishlist</a></li>
                                    <li><a href="shop-cart.html">Shop – Cart</a></li>
                                    <li><a href="shop-checkout.html">Shop – Checkout</a></li>
                                    <li><a href="shop-compare.html">Shop – Compare</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Shop Invoice</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-invoice-1.html">Shop Invoice 1</a></li>
                                            <li><a href="shop-invoice-2.html">Shop Invoice 2</a></li>
                                            <li><a href="shop-invoice-3.html">Shop Invoice 3</a></li>
                                            <li><a href="shop-invoice-4.html">Shop Invoice 4</a></li>
                                            <li><a href="shop-invoice-5.html">Shop Invoice 5</a></li>
                                            <li><a href="shop-invoice-6.html">Shop Invoice 6</a></li>
                                        </ul>
                                    </li>
                                </ul> --}}
                            </li>
                            {{-- REMOVED 'menu-item-has-children' class --}}
                            <li>
                                @if (Auth::check())
                                    <a href="/my-account">My Account</a>
                                @else
                                    <a href="javascript:void(0)" class="mobile-login-trigger" data-bs-toggle="modal"
                                        data-bs-target="#loginModal">
                                        Sign In
                                    </a>
                                @endif
                            </li>
                            {{-- <li class="menu-item-has-children">
                                <a href="#">Vendors</a>
                                <ul class="dropdown">
                                    <li><a href="vendors-grid.html">Vendors Grid</a></li>
                                    <li><a href="vendors-list.html">Vendors List</a></li>
                                    <li><a href="vendor-details-1.html">Vendor Details 01</a></li>
                                    <li><a href="vendor-details-2.html">Vendor Details 02</a></li>
                                    <li><a href="vendor-dashboard.html">Vendor Dashboard</a></li>
                                    <li><a href="vendor-guide.html">Vendor Guide</a></li>
                                </ul>
                            </li> --}}
                            {{-- <li class="menu-item-has-children">
                                <a href="#">Mega menu</a>
                                <ul class="dropdown">
                                    <li class="menu-item-has-children">
                                        <a href="#">Women's Fashion</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Dresses</a></li>
                                            <li><a href="shop-product-right.html">Blouses & Shirts</a></li>
                                            <li><a href="shop-product-right.html">Hoodies & Sweatshirts</a></li>
                                            <li><a href="shop-product-right.html">Women's Sets</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Men's Fashion</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Jackets</a></li>
                                            <li><a href="shop-product-right.html">Casual Faux Leather</a></li>
                                            <li><a href="shop-product-right.html">Genuine Leather</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Technology</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Gaming Laptops</a></li>
                                            <li><a href="shop-product-right.html">Ultraslim Laptops</a></li>
                                            <li><a href="shop-product-right.html">Tablets</a></li>
                                            <li><a href="shop-product-right.html">Laptop Accessories</a></li>
                                            <li><a href="shop-product-right.html">Tablet Accessories</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="/blog">Blogs</a>
                                <ul class="dropdown">
                                    <li><a href="blog-category-grid.html">Blog Category Grid</a></li>
                                    <li><a href="blog-category-list.html">Blog Category List</a></li>
                                    <li><a href="blog-category-big.html">Blog Category Big</a></li>
                                    <li><a href="blog-category-fullwidth.html">Blog Category Wide</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Single Product Layout</a>
                                        <ul class="dropdown">
                                            <li><a href="blog-post-left.html">Left Sidebar</a></li>
                                            <li><a href="blog-post-right.html">Right Sidebar</a></li>
                                            <li><a href="blog-post-fullwidth.html">No Sidebar</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li> --}}
                            <li class="menu-item-has-children">
                                <a href="/about">About Us</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="/contact">Contact Us</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap border border-1 rounded-3">
                    <div class="single-mobile-header-info">
                        <a href="/contact"><i class="fi-rs-marker"></i> 02 Floor, Taheri Complex, Opp. <br>
                            Gopi Restaurant, Sagwara, India </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fi-rs-user"></i>Log In / Sign Up
                        </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="tel:+91 87647 66553"><i class="fi-rs-headphones"></i>+91 87647 66553</a>
                    </div>
                </div>
                <div class="mobile-social-icon mb-50">
                    <h6 class="mb-15">Follow Us</h6>

                    <a href="https://www.instagram.com/roll.mills/" target="_blank"><img
                            src="{{ asset('assets/frontend/imgs/theme/icons/icon-instagram-white.svg') }}"
                            alt="" /></a>
                </div>
                <div class="site-copyright">Copyright 2025 © RollMills. All rights reserved.</div>
            </div>
        </div>
    </div>

    <div class="mobile-header-active-filter mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="/"><img src="{{ asset('assets/frontend/imgs/theme/logo.png') }}"
                            alt="logo" /></a>
                </div>
                <div class="mobile-menu-close-filter close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- mobile menu start -->
                    <div class="sidebar-widget widget-category-2 mb-40">
                        <h5 class="section-title style-1 mb-30 underline"
                            style="color: var(--color-3); display: inline-block;">Category</h5>
                        <div class="category-list">
                            @foreach ($categories as $category)
                                @php
                                    $selectedCategory = 1;
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
                                        <div class="sub-cat-container" x-show="open" x-collapse
                                            style="display: none;">

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
                    <!-- Fillter By Price -->
                    <div class="sidebar-widget range mb-40">
                        <h5 class="section-title style-1 mb-30 underline"
                            style="color: var(--color-3); display: inline-block;">Filter by price</h5>
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
                    <a href="" class="btn btn-sm btn-default mt-20 d-inline-flex align-items-center"><i
                            class="fi-rs-filter mr-5 d-flex align-items-center"></i>Apply
                        Fillters</a>
                    <!-- mobile menu end -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal custom-modal-new" id="onloadModal" tabindex="-1"
        aria-labelledby="onloadModalLabel" aria-modal="true" role="dialog"
        style="padding-right: 0px; display: block;">
        <div class="modal-dialog">
            <div class="modal-content bg-white">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="deal background-none" style="min-height: max-content">
                        <div class="deal-top">
                            <h6 class="mb-10 text-brand">Welcome To RollMills</h6>
                        </div>
                        <div class="deal-content detail-info first-popup-modal">
                            <h4 class="product-title" style="max-width: 100%">
                                Shop
                                with thrill, save at will — Let Smart Deals Roll In!!
                            </h4>
                            <p class="text-secondary w-md-75 w-50 quicksand fw-600 fst-italic">
                                "You just rolled into the land of deals!
                                Every click brings joy, every buy brings Thrills — at Rollmills!"
                            </p>
                            <p class="text-secondary w-md-75 w-50 quicksand fw-500">
                                We Offer <span class="text-brand fw-600">Thank You Card</span> on every purchase you
                                make. By
                                the this card you recieve a coupon which can be use in your next purchase to enjoy
                                great discounts.
                                Deals and Offers are rolling towards you to make your purchase more Thrilling.
                            </p>

                            <div class="clearfix product-price-cover">
                                <div class="product-price primary-color float-left mt-15 mb-10">
                                    <span class="current-price fs-3 text-brand">Surprize Gift Offer!!</span>
                                    {{-- <span>
                                        <span class="save-price font-md color3 ml-15">Surprize Gift!!</span>
                                        <span class="old-price font-md ml-15">$52</span>
                                    </span> --}}
                                </div>
                            </div>
                            <p class="mb-15 text-secondary w-md-75 w-50 fw-500 quicksand">Grab The Exclusive Gift Now!!
                                <br> Shop
                                <span class="text-brand fw-600">₹800</span>
                                and get a Surprize Gift. Only On RollMills.
                                Hurry up! grab your Gift Now!!
                            </p>
                        </div>
                        <div class="deal-bottom">
                            {{-- <p class="mb-10 quicksand fw-500">Hurry Up! Offer Ends In:</p> --}}
                            {{-- <div class="deals-countdown pl-5" data-countdown="2026/01/1 00:00:00">
                                <span class="countdown-section"><span class="countdown-amount hover-up">00</span>
                                    <span class="countdown-period"> days </span></span><span
                                    class="countdown-section"><span class="countdown-amount hover-up">00</span>
                                    <span class="countdown-period"> hours </span></span>
                                <span class="countdown-section"><span class="countdown-amount hover-up">00</span>
                                    <span class="countdown-period"> mins </span></span>
                                <span class="countdown-section"><span class="countdown-amount hover-up">00</span>
                                    <span class="countdown-period"> sec </span>
                                </span>
                            </div> --}}
                            {{-- <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (32 rates)</span>
                                </div>
                            </div> --}}
                            <a href="/shop"
                                class="align-items-center btn d-flex fit-content gap-1 mt-10 hover-up">Shop
                                Now <i class="fi-rs-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
