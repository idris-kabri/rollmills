 <main class="main pages">
     <div class="page-header breadcrumb-wrap">
         <div class="container">
             <div class="breadcrumb">
                 <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                 <span></span> <a href="/my-account">My Account</a> <span></span> Orders
             </div>
         </div>
     </div>
     <div class="page-content pt-50 pb-50">
         <div class="container">
             <div class="row">
                 <div class="col-lg-11 m-auto">
                     <div class="content mb-50">
                         <h1 class="title style-3 mb-20 text-center">Orders</h1>
                     </div>
                     <div class="row">
                         <div class="col-lg-9">
                             <div class="order-tabs">
                                 <div class="tab-style3">
                                     {{-- <ul class="nav nav-tabs text-uppercase">
                                         <li class="nav-item">
                                             <a class="nav-link active" id="Orders-tab" data-bs-toggle="tab"
                                                 href="#Orders">Orders List</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="Buy-Again-tab" data-bs-toggle="tab"
                                                 href="#Buy-Again">Buy Agian</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="Arriving-Orders-tab" data-bs-toggle="tab"
                                                 href="#Arriving-Orders">Arriving Orders</a>
                                         </li>
                                     </ul> --}}
                                     <div class="tab-content shop_info_tab entry-main-content mt-30">
                                         <div class="tab-pane fade show active" id="Orders">
                                             @foreach ($user_orders as $user_order)
                                                 <div class="card border-2 rounded-15 overflow-hidden mb-30">
                                                     <div class="card-header border-bottom">
                                                         <div class="d-flex justify-content-between align-items-center">
                                                             <h5 class="fs-24">Order ID <span
                                                                     class="text-brand">#{{ $user_order->id }}</span>
                                                             </h5>
                                                             <div class="options position-relative">
                                                                 <a class="categories-button-active custom-dropdown-home gap-2 hover-bg 
                                                            text-white"
                                                                     href="#">
                                                                     <span class="fi-rs-apps text-white fs-12"></span>
                                                                     Order Options
                                                                     <i class="fi-rs-angle-down fs-12"></i>
                                                                 </a>
                                                                 <div
                                                                     class="categories-dropdown-wrap categories-dropdown-active-large-2 categories-dropdown-active-large font-heading">
                                                                     <div class="categori-dropdown-inner">
                                                                         <ul>
                                                                             <li>
                                                                                 <a href="{{ route('user-order-detail', $user_order->id) }}">
                                                                                     View Order Details
                                                                                 </a>
                                                                             </li>
                                                                             {{-- <li>
                                                                            <a href="#">
                                                                                Track Order
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Add Review
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Delivery Feedback
                                                                            </a>
                                                                        </li> --}}
                                                                         </ul>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="card-content p-3 py-4">
                                                         <div class="d-sm-flex justify-content-between">
                                                             <div class="content mb-2 mb-md-0">
                                                                 <p
                                                                     class="border rounded-pill px-3 py-1 fs-14 text-secondary fw-600 quicksand
                                                                d-flex align-items-center fit-content">
                                                                     <i class="fa-solid fa-box-open me-1"></i>
                                                                     Order placed : &nbsp; <span
                                                                         class="text-muted">{{ \Carbon\Carbon::parse($user_order->created_at)->format('d M Y') }}</span>
                                                                 </p>
                                                             </div>

                                                             <div class="content">
                                                                 <p
                                                                     class="border rounded-pill px-3 py-1 fs-14 text-secondary fw-600 quicksand d-flex align-items-center fit-content">
                                                                     <i class="fa-solid fa-indian-rupee-sign mr-1"></i>
                                                                     Total Amount : &nbsp; <span
                                                                         class="text-muted">₹{{ number_format($user_order->total, 2) }}
                                                                         ({{ count($user_order->getOrderItems) }}
                                                                         Items)</span>
                                                                 </p>
                                                             </div>
                                                         </div>
                                                         <div class="product-cards mt-30">
                                                             <h5 class="underline pb-10 mb-25">Products</h5>
                                                             <div class="row">
                                                                 @foreach ($user_order->getOrderItems as $order_item)
                                                                     <div class="col-lg-6">
                                                                         <div class="card p-3 mb-3 rounded-15">
                                                                             <div class="d-flex gap-3">
                                                                                 <a class="align-items-center border d-flex img-section p-1 rounded-3"
                                                                                     href="#">
                                                                                     <img src="{{ asset('storage/' . $order_item->getProduct->featured_image) }}"
                                                                                         alt="img"
                                                                                         class="img-fluid">
                                                                                 </a>
                                                                                 <div class="content py-2">
                                                                                     <h6>
                                                                                         @php
                                                                                             if (
                                                                                                 $order_item->getProduct
                                                                                                     ->slug
                                                                                             ) {
                                                                                                 $shop_detail_url = route(
                                                                                                     'shop-detail',
                                                                                                     [
                                                                                                         'slug' =>
                                                                                                             $order_item
                                                                                                                 ->getProduct
                                                                                                                 ->slug,
                                                                                                         'id' =>
                                                                                                             $order_item
                                                                                                                 ->getProduct
                                                                                                                 ->id,
                                                                                                     ],
                                                                                                 );
                                                                                             } else {
                                                                                                 $shop_detail_url = route(
                                                                                                     'shop-detail',
                                                                                                     [
                                                                                                         'slug' =>
                                                                                                             'no-slug',
                                                                                                         'id' =>
                                                                                                             $order_item
                                                                                                                 ->getProduct
                                                                                                                 ->id,
                                                                                                     ],
                                                                                                 );
                                                                                             }
                                                                                         @endphp
                                                                                         <a href="{{ $shop_detail_url }}"
                                                                                             class="fs-17">{{ $order_item->getProduct->name }}</a>
                                                                                     </h6>
                                                                                     @php
                                                                                         $reviews = \App\Models\ProductReview::where(
                                                                                             'status',
                                                                                             1,
                                                                                         )
                                                                                             ->where(
                                                                                                 'product_id',
                                                                                                 $order_item->item_id,
                                                                                             )
                                                                                             ->get();

                                                                                         $reviews_count = $reviews->count();
                                                                                         $reviews_avg =
                                                                                             $reviews_count > 0
                                                                                                 ? round(
                                                                                                     $reviews->avg(
                                                                                                         'ratings',
                                                                                                     ),
                                                                                                     1,
                                                                                                 )
                                                                                                 : 0;
                                                                                         $reviews_percentage =
                                                                                             ($reviews_avg / 5) * 100;
                                                                                     @endphp
                                                                                     <div class="product-rate-cover">
                                                                                         <div
                                                                                             class="product-rate d-inline-block">
                                                                                             <div class="product-rating"
                                                                                                 style="width: {{ $reviews_percentage }}%">
                                                                                             </div>
                                                                                         </div>
                                                                                         <span
                                                                                             class="font-small ml-5 text-muted">
                                                                                             ({{ number_format($reviews_avg, 1) }})
                                                                                         </span>
                                                                                     </div>
                                                                                     <div class="product-price pt-5">
                                                                                         @if (
                                                                                             $order_item->sale_price > 0 &&
                                                                                                 now() >= $order_item->sale_price_start_date &&
                                                                                                 now() <= $order_item->sale_price_end_date)
                                                                                             <span
                                                                                                 class="fs-18 fw-bold">₹{{ number_format($order_item->sale_price, 2) }}</span>
                                                                                             <span
                                                                                                 class="old-price ms-1 fs-14 text-secondary text-decoration-line-through">₹{{ number_format($order_item->regular_price, 2) }}</span>
                                                                                         @elseif($order_item->sale_default_price > 0)
                                                                                             <span
                                                                                                 class="fs-18 fw-bold">₹{{ number_format($order_item->sale_default_price, 2) }}</span>
                                                                                             <span
                                                                                                 class="old-price ms-1 fs-14 text-secondary text-decoration-line-through">₹{{ number_format($order_item->regular_price, 2) }}</span>
                                                                                         @else
                                                                                             <span
                                                                                                 class="price-transition">₹{{ number_format($order_item->regular_price, 2) }}</span>
                                                                                         @endif
                                                                                         <span
                                                                                             class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x{{ $order_item->quantity }}</span>
                                                                                     </div>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 @endforeach
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             @endforeach
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-3 primary-sidebar sticky-sidebar">
                             <div class="widget-area">
                                 <div class="sidebar-widget widget-category-2 mb-30">
                                     <h5 class="section-title style-1 mb-30">Category</h5>
                                     <ul>
                                         @foreach ($productCategorys as $category)
                                             <li>
                                                 <a href="/shop?category_id={{ $category->id }}"> <img
                                                         src="{{ asset('storage/' . $category->icon) }}"
                                                         alt="" />{{ $category->name }}</a><span
                                                     class="count">{{ $category->getProductCategoryAssign->count() ?? 0 }}</span>
                                             </li>
                                         @endforeach
                                     </ul>
                                 </div>
                                 <!-- Product sidebar Widget -->
                                 <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
                                     <h5 class="section-title style-1 mb-30">Previously Order Items</h5>
                                     @foreach ($previously_order_items as $item)
                                         <div class="single-post clearfix">
                                             <div class="image">
                                                 <img src="{{ asset('storage/' . $item->featured_image) }}"
                                                     alt="#" />
                                             </div>
                                             @php
                                                 if ($item->slug) {
                                                     $item_shop_detail_url = route('shop-detail', [
                                                         'slug' => $item->slug,
                                                         'id' => $item->id,
                                                     ]);
                                                 } else {
                                                     $item_shop_detail_url = route('shop-detail', [
                                                         'slug' => 'no-slug',
                                                         'id' => $item->id,
                                                     ]);
                                                 }
                                             @endphp
                                             <div class="content pt-10">
                                                 <h5><a href="{{ $item_shop_detail_url }}"
                                                         class="two-liner-text">{{ $item->name }}</a></h5>
                                                 @if ($item->sale_price > 0 && now() >= $item->sale_start_date && now() <= $item->sale_end_date)
                                                     <span
                                                         class="price-transition mb-0 mt-5">₹{{ $item->sale_price }}</span>
                                                     <span class="old-price mb-0 mt-5">
                                                         <del>₹{{ $item->price }}</del></span>
                                                 @elseif($item->sale_default_price > 0)
                                                     <span
                                                         class="price-transition mb-0 mt-5">₹{{ $item->sale_default_price }}</span>
                                                     <span class="old-price mb-0 mt-5">
                                                         <del>₹{{ $item->price }}</del></span>
                                                 @else
                                                     <span
                                                         class="price-transition mb-0 mt-5">₹{{ $item->price }}</span>
                                                 @endif
                                                 @php
                                                     $item_reviews = \App\Models\ProductReview::where(
                                                         'status',
                                                         1,
                                                     )
                                                         ->where('product_id', $item->id)
                                                         ->get();

                                                     $item_reviews_count = $item_reviews->count();
                                                     $item_reviews_avg =
                                                         $item_reviews_count > 0
                                                             ? round($item_reviews->avg('ratings'), 1)
                                                             : 0;
                                                     $item_reviews_percentage =
                                                         ($item_reviews_avg / 5) * 100;
                                                 @endphp
                                                 <div class="product-rate">
                                                     <div class="product-rating" style="width: {{ $item_reviews_percentage }}%"></div>
                                                 </div>
                                             </div>
                                         </div>
                                     @endforeach
                                 </div>
                                 @if($banner != null)
                                 <div class="banner-img wow fadeIn mb-40 animated d-lg-block d-none">
                                     <img src="{{ asset('storage/' . $banner->image) }}"
                                         alt="" />
                                     <div class="banner-text">
                                         <span>{{$banner->heading}}</span>
                                         <h4 class="mb-2 mt-40">
                                             {!! preg_replace('/<\/?p>/', '', $banner->sub_heading) !!}
                                         </h4>
                                     </div>
                                 </div>
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </main>
