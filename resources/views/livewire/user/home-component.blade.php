<main class="main home-page-main">
    <style>
        /* --- GIFT ROW STYLES (ORDER SUMMARY) --- */
        .gift-row {
            background: linear-gradient(90deg, #fffbf0 0%, #ffffff 100%);
            border: 1px solid #f7e3a6;
            border-left: 5px solid #ffbc0d;
        }

        .gift-badge {
            background-color: #ffbc0d;
            color: #fff;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 5px;
        }

        .price-free {
            color: #25b579;
            font-weight: 800;
            font-size: 18px;
        }

        .gift-icon-container {
            color: #ffbc0d;
            font-size: 20px;
            margin-right: 5px;
        }

        /* --- DISCOUNT PROGRESS WIDGET STYLES --- */
        .shipping-widget-cart {
            padding: 15px;
            border-radius: 10px;
            border: 1px dashed;
        }

        .shipping-progress-bg {
            background-color: #e9ecef;
            border-radius: 10px;
            height: 8px;
            width: 100%;
            margin-top: 8px;
            overflow: hidden;
        }

        .shipping-progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 0.6s ease;
            position: relative;
            background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
            background-size: 1rem 1rem;
            animation: progress-bar-stripes 1s linear infinite;
        }

        @keyframes progress-bar-stripes {
            0% {
                background-position: 1rem 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        .shipping-text {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .shipping-highlight {
            font-weight: 700;
        }

        /* --- PREMIUM OFFER BANNER STYLES --- */
        .premium-offer-banner {
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            border-radius: 16px;
            padding: 20px 30px;
            margin: 10px 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 25px rgba(0, 176, 155, 0.25);
            color: #ffffff;
            flex-wrap: wrap;
            gap: 20px;
        }

        .premium-offer-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .premium-offer-icon {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #ffffff;
            box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .premium-offer-text h4 {
            color: #ffffff;
            margin: 0 0 4px 0;
            font-weight: 800;
            font-size: 22px;
            letter-spacing: 0.5px;
            line-height: 1.2;
            font-family: 'Quicksand', sans-serif;
        }

        .premium-offer-text p {
            color: rgba(255, 255, 255, 0.95);
            margin: 0;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.3px;
        }

        .premium-payment-pill {
            background: #ffffff;
            padding: 10px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .premium-payment-pill .secure-text {
            color: #25b579;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
            border-right: 2px solid #f0f0f0;
            padding-right: 15px;
            letter-spacing: 0.5px;
        }

        .premium-payment-icons {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .premium-payment-icons img {
            height: 20px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        @media (max-width: 768px) {
            .premium-offer-banner {
                flex-direction: column;
                justify-content: center;
                text-align: center;
                padding: 20px;
            }

            .premium-offer-left {
                flex-direction: column;
                gap: 12px;
            }

            .premium-offer-text h4 {
                font-size: 20px;
            }

            .premium-payment-pill {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                padding: 12px;
            }

            .premium-payment-pill .secure-text {
                border-right: none;
                border-bottom: 2px solid #f0f0f0;
                padding-right: 0;
                padding-bottom: 8px;
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    <div class="container">
        <div class="premium-offer-banner wow animate__animated animate__fadeInDown mt-4">
            <div class="premium-offer-left">
                <div class="premium-offer-icon">
                    <i class="fi-rs-badge"></i>
                </div>
                <div class="premium-offer-text">
                    <h4>Get 20% OFF Instantly!</h4>
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
                    <img src="{{ asset('assets/frontend/imgs/theme/rupay.png') }}" alt="RuPay" style="height: 16px;">
                </div>
            </div>
        </div>
    </div>
    @livewire('user.quick-view', ['id' => $selectedProductId], key('quickview'))
    @php
        $array_random_parameter = ['hot', 'sale'];
    @endphp

    <section class="home-slider style-2 position-relative mb-md-3" wire:ignore>
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-12 px-0 px-sm-3">
                    <div class="home-slide-cover">
                        <div class="hero-slider-1 hero-slider-1-custom style-4 dot-style-1 dot-style-1-position-1">
                            @foreach ($slider_banner as $slider)
                                @php
                                    $image = 'storage/' . $slider->image;
                                    $words = explode(' ', $slider->heading);
                                    if (count($words) > 2) {
                                        $firstPart = implode(' ', array_slice($words, 0, 3));
                                        $secondPart = implode(' ', array_slice($words, 3));
                                        $newHeading = $firstPart . ' <br> ' . $secondPart;
                                    } else {
                                        $newHeading = $slider->heading;
                                    }
                                @endphp
                                <div class="single-hero-slider overflow-hidden single-animation-wrap single-hero-slider-custom"
                                    style="background-image: url('{{ asset($image) }}')">
                                    <div class="slider-content custom-width-home-banner">
                                        <h1 class="display-2 mb-25">
                                            {!! $newHeading !!}
                                        </h1>
                                        <p class="hidden-p-banner">{!! $slider->sub_heading !!}</p>
                                        <a href="{{ $slider->link ?? '#' }}"
                                            class="btn btn-ls mt-20 btn-loop-animate">{{ $slider->button_text }} <i
                                                class="fi-rs-arrow-small-right"></i></a>
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
                    <div class="banner-img style-3 animated animated"
                        style="background: url({{ asset('storage/' . $top_side_banner->image) }}) no-repeat center bottom; background-size: cover">
                        <div class="banner-text mt-50">
                            <h2 class="mb-50">
                                {!! $newHeadingSide !!}
                                <span class="text-brand">{!! $newSubHeadingSide !!}</span>
                            </h2>
                            <a href="{{ $top_side_banner->link ?? '#' }}"
                                class="btn btn-xs btn-loop-animate">{{ $top_side_banner->button_text }} <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="popular-categories section-padding" wire:ignore>
        <div class="container wow animate__animated animate__fadeIn">
            <div class="section-title">
                <div class="title">
                    <h3 class="m-0">Featured Categories</h3>
                </div>
            </div>
            <div class="home-categories-cards-section">
                <div class="row justify-content-center">
                    @foreach ($parentCategory as $index => $category)
                        <div class="col-xl-1 col-lg-2 col-md-2 col-sm-3 col-4 px-2">
                            <div class="card-2 wow animate__animated animate__fadeInUp"
                                data-wow-delay=".{{ $index + 1 }}s" style="min-height: fit-content">
                                <figure class="img-hover-scale overflow-hidden">
                                    <a href="/shop?category_id={{ $category->id }}&category_slug={{ $category->slug ?? 'no-slug' }}"
                                        class="w-100 h-100"><img src="{{ asset('storage/' . $category->image) }}"
                                            alt="" /></a>
                                </figure>
                                <h6><a class="fs-15 one-liner-text"
                                        href="/shop?category_id={{ $category->id }}&category_slug={{ $category->slug ?? 'no-slug' }}">{{ $category->name }}</a>
                                </h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section> --}}

    <section class="banners feature-three-cards mb-25 mt-50" wire:ignore>
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
                        <a href="{{ $banner->link ?? '#' }}">
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
                                    {{-- <a href="{{ $banner->link ?? '#' }}"
                                    class="btn btn-xs btn-loop-animate">{{ $banner->button_text }}
                                    <i class="fi-rs-arrow-small-right"></i></a> --}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @php
        $priority_ids = [29, 1];

        $sortedCategories = $parentCategory->sortBy(function ($cat) use ($priority_ids) {
            $index = array_search($cat->id, $priority_ids);
            return $index === false ? 999 : $index;
        });
    @endphp
    @foreach ($sortedCategories as $popular_category)
        <section class="product-tabs section-padding position-relative pt-md-4 pt-0">
            <div class="container" wire:ignore.self>
                <div class="section-title style-2">
                    <h3>{{ $popular_category->name }}</h3>
                </div>
                <div class="row product-grid-4">
                    @php
                        $all_sub_category = \App\Models\ProductCategory::where('parent_id', $popular_category->id)
                            ->pluck('id')
                            ->toArray();
                        $all_sub_category[] = $popular_category->id;
                        $category_product_category_assign = \App\Models\ProductCategoryAssign::whereIn(
                            'category_id',
                            $all_sub_category,
                        )->pluck('product_id');
                        $category_popular_products = \App\Models\Product::where('status', 1)
                            ->where('is_featured', 1)
                            ->whereIn('id', $category_product_category_assign)
                            ->where('parent_id', null)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get();
                    @endphp
                    @if (count($category_popular_products) > 0)
                        @foreach ($category_popular_products as $popular_product)
                            <div class="col-lg-1-5 col-md-4 col-6 small-screen-padding">
                                @php
                                    $parameter = $array_random_parameter[array_rand($array_random_parameter)];
                                @endphp
                                @livewire('user.component.product-card', ['product' => $popular_product, 'parameter' => $parameter], key($popular_product->id . '-' . now()->timestamp))
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-danger text-center">No Item Found!</h4>
                    @endif
                </div>
            </div>
        </section>
    @endforeach


    {{-- <section class="section-padding pb-5 pt-md-4 pt-0">
        <div class="container">
            <div class="section-title">
                <h3 class="">Daily Best Sells</h3>
            </div>
            <div class="row">
                <div class="col-xl-3 d-none d-xl-flex">
                    <div class="banner-img style-2"
                        style="background: url('{{ asset('storage/' . $best_deal_banner->image) }}');">
                        <div class="banner-text">
                            <h2 class="mb-100">{{ $best_deal_banner->heading }}</h2>
                            <a href="{{ $best_deal_banner->link ?? '#' }}"
                                class="btn btn-xs btn-loop-animate">{{ $best_deal_banner->button_text }} <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-12">
                    <div class="row">
                        @foreach ($sale_products as $sale_product)
                            <div class="col-md-3 col-lg-3 col-6 small-screen-padding">
                                @php
                                    $parameter = $array_random_parameter[array_rand($array_random_parameter)];
                                @endphp
                                @livewire('user.component.product-card', ['product' => $sale_product, 'parameter' => $parameter], key($sale_product->id . '-' . now()->timestamp))
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="section-padding pb-25 pt-md-4 pt-0">
        <div class="container">
            <div class="section-title">
                <h3 class="">Product Users look for</h3>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="row">
                        @foreach ($users_look_for as $user_look_for)
                            <div class="col-md-3 col-lg-3 col-6 small-screen-padding">
                                @php
                                    $parameter = $array_random_parameter[array_rand($array_random_parameter)];
                                @endphp
                                @livewire('user.component.product-card', ['product' => $user_look_for, 'parameter' => $parameter], key($user_look_for->id . '-' . now()->timestamp))
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section-padding mb-30 pt-md-4 pt-0" wire:ignore>
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0">
                    <h4 class="section-title style-1 mb-30 animated animated">Top Selling</h4>
                    <div class="product-list-small animated animated">
                        @foreach ($top_selling as $product)
                            @php
                                if ($product->slug) {
                                    $top_selling_shop_detail_url = route('shop-detail', [
                                        'slug' => $product->slug,
                                        'id' => $product->id,
                                    ]);
                                } else {
                                    $top_selling_shop_detail_url = route('shop-detail', [
                                        'slug' => 'no-slug',
                                        'id' => $product->id,
                                    ]);
                                }
                            @endphp
                            <article class="row align-items-center hover-up">
                                <figure class="col-sm-3 col-md-4 mb-0">
                                    <a href="{{ $top_selling_shop_detail_url }}"><img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="{{ $product->seo_meta }}" /></a>
                                </figure>
                                <div class="col-sm-9 col-md-8 mb-0">
                                    <h6 class="two-liner-text">
                                        <a href="{{ $top_selling_shop_detail_url }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        @php
                                            $top_selling_reviews = \App\Models\ProductReview::where('status', 1)
                                                ->where('product_id', $product->id)
                                                ->get();

                                            $top_selling_reviews_count = $top_selling_reviews->count();
                                            $top_selling_reviews_avg =
                                                $top_selling_reviews_count > 0
                                                    ? round($top_selling_reviews->avg('ratings'), 1)
                                                    : 0;
                                            $top_selling_reviews_percentage = ($top_selling_reviews_avg / 5) * 100;
                                        @endphp
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating"
                                                style="width: {{ $top_selling_reviews_percentage }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            ({{ $top_selling_reviews_avg }})
                                        </span>
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
                            @php
                                if ($product->slug) {
                                    $trending_products_shop_detail_url = route('shop-detail', [
                                        'slug' => $product->slug,
                                        'id' => $product->id,
                                    ]);
                                } else {
                                    $trending_products_shop_detail_url = route('shop-detail', [
                                        'slug' => 'no-slug',
                                        'id' => $product->id,
                                    ]);
                                }
                            @endphp
                            <article class="row align-items-center hover-up">
                                <figure class="col-sm-3 col-md-4 mb-0">
                                    <a href="{{ $trending_products_shop_detail_url }}"><img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="{{ $product->seo_meta }}" /></a>
                                </figure>
                                <div class="col-sm-9 col-md-8 mb-0">
                                    <h6 class="two-liner-text">
                                        <a href="{{ $trending_products_shop_detail_url }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        @php
                                            $trending_products_reviews = \App\Models\ProductReview::where('status', 1)
                                                ->where('product_id', $product->id)
                                                ->get();

                                            $trending_products_reviews_count = $trending_products_reviews->count();
                                            $trending_products_reviews_avg =
                                                $trending_products_reviews_count > 0
                                                    ? round($trending_products_reviews->avg('ratings'), 1)
                                                    : 0;
                                            $trending_products_reviews_percentage =
                                                ($trending_products_reviews_avg / 5) * 100;
                                        @endphp
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating"
                                                style="width: {{ $trending_products_reviews_percentage }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            ({{ $trending_products_reviews_avg }})</span>
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
                            @php
                                if ($product->slug) {
                                    $latest_products_shop_detail_url = route('shop-detail', [
                                        'slug' => $product->slug,
                                        'id' => $product->id,
                                    ]);
                                } else {
                                    $latest_products_shop_detail_url = route('shop-detail', [
                                        'slug' => 'no-slug',
                                        'id' => $product->id,
                                    ]);
                                }
                            @endphp
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ $latest_products_shop_detail_url }}"><img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="{{ $product->seo_meta }}" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6 class="two-liner-text">
                                        <a href="{{ $latest_products_shop_detail_url }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        @php
                                            $latest_products_reviews = \App\Models\ProductReview::where('status', 1)
                                                ->where('product_id', $product->id)
                                                ->get();

                                            $latest_products_reviews_count = $latest_products_reviews->count();
                                            $latest_products_reviews_avg =
                                                $latest_products_reviews_count > 0
                                                    ? round($latest_products_reviews->avg('ratings'), 1)
                                                    : 0;
                                            $latest_products_reviews_percentage =
                                                ($latest_products_reviews_avg / 5) * 100;
                                        @endphp
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating"
                                                style="width: {{ $latest_products_reviews_percentage }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            ({{ $latest_products_reviews_avg }})</span>
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
                            @php
                                if ($product->slug) {
                                    $top_rated_products_shop_detail_url = route('shop-detail', [
                                        'slug' => $product->slug,
                                        'id' => $product->id,
                                    ]);
                                } else {
                                    $top_rated_products_shop_detail_url = route('shop-detail', [
                                        'slug' => 'no-slug',
                                        'id' => $product->id,
                                    ]);
                                }
                            @endphp
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ $top_rated_products_shop_detail_url }}"><img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="{{ $product->seo_meta }}" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6 class="two-liner-text">
                                        <a href="{{ $top_rated_products_shop_detail_url }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        @php
                                            $top_rated_products_reviews = \App\Models\ProductReview::where('status', 1)
                                                ->where('product_id', $product->id)
                                                ->get();

                                            $top_rated_products_reviews_count = $top_rated_products_reviews->count();
                                            $top_rated_products_reviews_avg =
                                                $top_rated_products_reviews_count > 0
                                                    ? round($top_rated_products_reviews->avg('ratings'), 1)
                                                    : 0;
                                            $top_rated_products_reviews_percentage =
                                                ($top_rated_products_reviews_avg / 5) * 100;
                                        @endphp
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating"
                                                style="width: {{ $top_rated_products_reviews_percentage }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">
                                            ({{ $top_rated_products_reviews_avg }})</span>
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
</main>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            const quickViewButtons = document.querySelectorAll('.quick-view');

            quickViewButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    const productId = this.dataset.id;
                    alert('Quick view button clicked for product with ID: ' + productId);
                    console.log('Button clicked!', this);
                });
            })
        })
    </script>
    <script>
        document.addEventListener('openQuickView', function(e) {
            let modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            modal.show();

            console.log("Modal opened for product:", e.detail.productId);
        });
    </script>
    <script>
        // Auto-show modal on page load
        window.addEventListener('load', function() {
            setTimeout(function() {
                var modalElement = document.getElementById('saleModal');
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }, 500);
        });

        // Countdown Timer
        let totalSeconds = 240; // 15 minutes = 900 seconds

        function updateCountdown() {
            const m1 = document.getElementById('minutes1');
            const m2 = document.getElementById('minutes2');
            const s1 = document.getElementById('seconds1');
            const s2 = document.getElementById('seconds2');

            if (!m1 || !m2 || !s1 || !s2) return;

            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;

            const min1 = Math.floor(minutes / 10);
            const min2 = minutes % 10;
            const sec1 = Math.floor(seconds / 10);
            const sec2 = seconds % 10;

            m1.textContent = min1;
            m2.textContent = min2;
            s1.textContent = sec1;
            s2.textContent = sec2;

            if (totalSeconds > 0) {
                totalSeconds--;
            } else {
                totalSeconds = 900; // Reset to 15 minutes
            }
        }

        setInterval(updateCountdown, 1000);
    </script>
@endpush
