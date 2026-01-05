<main class="main home-page-main">
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

    <section class="popular-categories section-padding" wire:ignore>
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
    </section>

    <section class="banners feature-three-cards mb-25" wire:ignore>
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
                                <a href="{{ $banner->link ?? '#' }}"
                                    class="btn btn-xs btn-loop-animate">{{ $banner->button_text }}
                                    <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
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


    <section class="section-padding pb-5 pt-md-4 pt-0">
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
    </section>

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
