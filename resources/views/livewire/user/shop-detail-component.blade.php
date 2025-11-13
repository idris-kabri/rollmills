<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                @php
                $count_category_assign = count($mainProduct->categoryAssigns);
                @endphp
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                @if ($count_category_assign > 1)
                <span></span> <a
                    href="shop-grid-right.html">{{ $mainProduct->categoryAssigns[$count_category_assign - 1]->category->name }}</a>
                <span></span> {{ $mainProduct->categoryAssigns[0]->category->name }}
                @else
                <span></span> <a
                    href="shop-grid-right.html">{{ $mainProduct->categoryAssigns[0]->category->name }}</a>
                @endif
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row">
            <div class="col-xl-11 col-lg-12 m-auto">
                <div class="product-detail accordion-detail">
                    <div class="row mb-50 mt-30">
                        <div class="col-lg-6 col-sm-12 col-xs-12 mb-lg-0 mb-sm-5">
                            <div class="detail-gallery">
                                @php
                                $gallaryImages = json_decode($mainProduct->images, true);
                                @endphp
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider">
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('storage/' . $mainProduct->featured_image) }}"
                                            alt="{{$mainProduct->seo_meta}}" />
                                    </figure>
                                    @foreach ($gallaryImages as $gallaryImage)
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('storage/' . $gallaryImage) }}" alt="{{$mainProduct->seo_meta}}" />
                                    </figure>
                                    @endforeach
                                </div>
                                <!-- THUMBNAILS -->
                                <div class="slider-nav-thumbnails">
                                    <div><img src="{{ asset('storage/' . $mainProduct->featured_image) }}"
                                            alt="{{$mainProduct->seo_meta}}" /></div>
                                    @foreach ($gallaryImages as $gallaryImage)
                                    <div><img src="{{ asset('storage/' . $gallaryImage) }}" alt="{{$mainProduct->seo_meta}}" />
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- End Gallery -->
                        </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                            @php
                            $original_price = $mainProduct->price;
                            $sale_price = 0;
                            $check_type = '';

                            $currentDate = \Carbon\Carbon::now();
                            $sale_from_date = \Carbon\Carbon::parse($mainProduct->sale_from_date);
                            $sale_to_date = \Carbon\Carbon::parse($mainProduct->sale_to_date);

                            if (
                            $mainProduct->sale_price > 0 &&
                            $currentDate->between($sale_from_date, $sale_to_date)
                            ) {
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
                            <div class="detail-info pr-30 pl-30">
                                @if ($check_type == 'sale_product')
                                <span class="product-cart-componet-badge save">Save
                                    {{ number_format($percentage) }}%</span>
                                @elseif($check_type == 'featured_product')
                                <span class="product-cart-componet-badge hot">Hot</span>
                                @else
                                <span class="product-cart-componet-badge save">Save
                                    {{ number_format($percentage) }}%</span>
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
                                        <span
                                            class="current-price text-brand">₹{{ number_format($sale_price) }}</span>
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
                                    <strong class="mr-10">{{ $attributes['name'] }} </strong>
                                    <ul class="list-filter size-filter font-small">
                                        @foreach ($attributes['items'] as $item)
                                        <li><a href="#"
                                                class="{{ $selectedAttribute[$key] == $item ? 'active' : '' }}"
                                                wire:click.prevent="handleAttributeClick({{ $key }}, '{{ $item }}')">{{ $item }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                                <div
                                    class="d-flex detail-extralink flex-wrap gap-3 justify-content-sm-start justify-content-center mb-50">
                                    <div class="detail-qty border radius ps-4 pt-10 pb-10 me-0">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <input type="text" name="quantity" class="qty-val fw-600 fs-18"
                                            value="1" min="1">
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"><i
                                                class="fi-rs-shopping-cart"></i>Add to cart</button>
                                        <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                    </div>
                                </div>
                                <div class="font-xs">
                                    <ul class="mr-50 float-start">
                                        <li class="mb-5 fw-600">Type: <span class="text-brand ms-2">Organic</span>
                                        </li>
                                        <li class="mb-5 fw-600">MFG:<span class="text-brand ms-2"> Jun 4.2022</span>
                                        </li>
                                        <li class="mb-5 fw-600">LIFE: <span class="text-brand ms-2">70 days</span>
                                        </li>
                                    </ul>
                                    <ul class="float-start">
                                        <li class="mb-5 fw-600">SKU: <a href="#"
                                                class="text-brand ms-2">FWM15VKT</a></li>
                                        <li class="mb-5 fw-600">Tags: <a href="#" rel="tag"
                                                class="text-brand ms-2">Snack</a>,
                                            <a href="#" rel="tag">Organic</a>, <a href="#"
                                                rel="tag">Brown</a>
                                        </li>
                                        <li class="mb-5 fw-600">Stock:<span class="in-stock text-brand ms-2 ml-5">8
                                                Items In Stock</span></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Detail Info -->
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
                                    <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                        href="#Additional-info">Additional info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab"
                                        href="#Reviews">Reviews ({{ $mainProduct_reviews_count }})</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <div class="">
                                        <p>{!! $mainProduct->description !!}</p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Additional-info">
                                    <table class="font-md">
                                        <tbody>
                                            @foreach (json_decode($mainProduct->specifications) as $specification)
                                            <tr>
                                                <td>{{ $specification->name }}</td>
                                                <td>{{ $specification->value }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="Reviews">
                                    <!--Comments-->
                                    @if(count($mainProduct_reviews) > 0)
                                    <div class="comments-area">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4 class="mb-30">Customer questions & answers</h4>
                                                <div class="comment-list">
                                                    @foreach ($mainProduct_reviews as $mainProduct_review)
                                                    @php
                                                    $rating = $mainProduct_review->ratings ?? 0;
                                                    $rating_percentage = ($rating / 5) * 100;
                                                    @endphp
                                                    <div class="single-comment justify-content-between d-flex mb-30">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="{{ Storage::url($mainProduct_review->image) }}" alt="">
                                                                <a href=" #" class="font-heading text-brand">{{$mainProduct->getUsers->name ?? ''}}</a>
                                                            </div>
                                                            <div class="desc">
                                                                <div class="d-flex justify-content-between mb-10 align-items-center">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="font-xs text-muted">{{ $mainProduct_review->created_at->format('F j, Y \\a\\t g:i a') }}
                                                                            <div class="product-rate">
                                                                                <div class="product-rating" style="width: {{$rating_percentage}}%"></div>
                                                                            </div>
                                                                        </span>
                                                                    </div>

                                                                </div>
                                                                <p class="mb-10">{{ $mainProduct_review->remarks }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                @php
                                                $total_reviews = $mainProduct_reviews->count();
                                                $average_rating = $total_reviews > 0 ? $mainProduct_reviews->avg('ratings') : 0;

                                                $star_counts = [
                                                5 => $mainProduct_reviews->where('ratings', 5)->count(),
                                                4 => $mainProduct_reviews->where('ratings', 4)->count(),
                                                3 => $mainProduct_reviews->where('ratings', 3)->count(),
                                                2 => $mainProduct_reviews->where('ratings', 2)->count(),
                                                1 => $mainProduct_reviews->where('ratings', 1)->count(),
                                                ];

                                                $star_percentages = [];
                                                foreach ($star_counts as $star => $count) {
                                                $star_percentages[$star] = $total_reviews > 0 ? round(($count / $total_reviews) * 100, 1) : 0;
                                                }

                                                $average_percentage = ($average_rating / 5) * 100;
                                                @endphp
                                                <h4 class="mb-30">Customer reviews</h4>

                                                <div class="d-flex mb-30 align-items-center">
                                                    <div class="product-rate d-inline-block mr-15">
                                                        <div class="product-rating" style="width: {{ $average_percentage }}%"></div>
                                                    </div>
                                                    <h6>{{ number_format($average_rating, 1) }} out of 5</h6>
                                                </div>

                                                @foreach ([5,4,3,2,1] as $star)
                                                <div class="progress mb-2">
                                                    <span>{{ $star }} star</span>
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $star_percentages[$star] }}%"
                                                        aria-valuenow="{{ $star_percentages[$star] }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $star_percentages[$star] }}%
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <!--comment form-->
                                    <div class="comment-form">
                                        <h4 class="mb-15">Add a review</h4>
                                        <div class="star_rating" id="star_rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span data-value="{{ $i }}">
                                                <i
                                                    class="{{ $review_rating >= $i ? 'fas' : 'far' }} fa-star"></i>
                                                </span>
                                                @endfor
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12">
                                                <form class="form-contact comment_form" action="#"
                                                    id="commentForm" wire:submit.prevent="reviewStore">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                    placeholder="Write Comment" wire:model="review_remark"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="name"
                                                                    id="name" type="text"
                                                                    placeholder="Name" wire:model="review_name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email"
                                                                    id="email" type="email"
                                                                    placeholder="Email" wire:model="review_email" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input class="form-control" name="review_image" type="file"
                                                                    wire:model="review_image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit"
                                                            class="button button-contactForm">Submit Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-60">
                        <div class="col-12">
                            <h2 class="section-title style-1 mb-30">Related products</h2>
                        </div>
                        <div class="col-12">
                            <div class="row related-products">
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap hover-up">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html" tabindex="0">
                                                    <img class="default-img"
                                                        src="{{ asset('assets/frontend/imgs/shop/product-2-1.jpg') }}"
                                                        alt="" />
                                                    <img class="hover-img"
                                                        src="{{ asset('assets/frontend/imgs/shop/product-2-2.jpg') }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                        class="fi-rs-search"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                    href="shop-wishlist.html" tabindex="0"><i
                                                        class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up"
                                                    href="shop-compare.html" tabindex="0"><i
                                                        class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="shop-product-right.html" tabindex="0">Ulstra Bass
                                                    Headphone</a></h2>
                                            <div class="rating-result" title="90%">
                                                <span> </span>
                                            </div>
                                            <div class="product-price">
                                                <span>$238.85 </span>
                                                <span class="old-price">$245.8</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap hover-up">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html" tabindex="0">
                                                    <img class="default-img"
                                                        src="{{ asset('assets/frontend/imgs/shop/product-3-1.jpg') }}"
                                                        alt="" />
                                                    <img class="hover-img"
                                                        src="{{ asset('assets/frontend/imgs/shop/product-4-2.jpg') }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                        class="fi-rs-search"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                    href="shop-wishlist.html" tabindex="0"><i
                                                        class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up"
                                                    href="shop-compare.html" tabindex="0"><i
                                                        class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">-12%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="shop-product-right.html" tabindex="0">Smart Bluetooth
                                                    Speaker</a></h2>
                                            <div class="rating-result" title="90%">
                                                <span> </span>
                                            </div>
                                            <div class="product-price">
                                                <span>$138.85 </span>
                                                <span class="old-price">$145.8</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap hover-up">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html" tabindex="0">
                                                    <img class="default-img"
                                                        src="{{ asset('assets/frontend/imgs/shop/product-4-1.jpg') }}"
                                                        alt="" />
                                                    <img class="hover-img"
                                                        src="{{ asset('assets/frontend/imgs/shop/product-4-2.jpg') }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                        class="fi-rs-search"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                    href="shop-wishlist.html" tabindex="0"><i
                                                        class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up"
                                                    href="shop-compare.html" tabindex="0"><i
                                                        class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="shop-product-right.html" tabindex="0">HomeSpeak 12UEA
                                                    Goole</a></h2>
                                            <div class="rating-result" title="90%">
                                                <span> </span>
                                            </div>
                                            <div class="product-price">
                                                <span>$738.85 </span>
                                                <span class="old-price">$1245.8</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6 d-lg-block d-none">
                                    <div class="product-cart-wrap hover-up mb-0">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html" tabindex="0">
                                                    <img class="default-img"
                                                        src="{{ asset('assets/frontend/imgs/shop/product-5-1.jpg') }}"
                                                        alt="" />
                                                    <img class="hover-img"
                                                        src="{{ asset('assets/frontend/imgs/shop/product-3-2.jpg') }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                        class="fi-rs-search"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                    href="shop-wishlist.html" tabindex="0"><i
                                                        class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up"
                                                    href="shop-compare.html" tabindex="0"><i
                                                        class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="shop-product-right.html" tabindex="0">Dadua Camera 4K
                                                    2022EF</a></h2>
                                            <div class="rating-result" title="90%">
                                                <span> </span>
                                            </div>
                                            <div class="product-price">
                                                <span>$89.8 </span>
                                                <span class="old-price">$98.8</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('scripts')
<script>
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
    });
</script>
@endpush