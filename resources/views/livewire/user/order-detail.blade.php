 <main class="main pages">
     <div class="page-header breadcrumb-wrap">
         <div class="container">
             <div class="breadcrumb">
                 <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                 <span></span> <a href="/my-account">My Account</a> <span></span> Order Detail #{{ $order->id }}
             </div>
         </div>
     </div>
     <div class="page-content pt-50 pb-50">
         <div class="container">
             <div class="row">
                 <div class="col-xl-11 col-12 m-auto">
                     <div class="content mb-50">
                         <h1 class="title style-3 mb-20 text-center">Order Details</h1>
                     </div>
                     <div class="row">
                         <div class="col-xl-9">
                             <div class="order-tabs">
                                 <div class="card border-2 rounded-15 overflow-hidden mb-30">
                                     <div class="card-header border-bottom">
                                         <div class="d-flex justify-content-between align-items-center">
                                             <h5 class="fs-24">Order ID <span class="text-brand">#{{ $order->id }}</span></h5>
                                             <div class="options position-relative">
                                                 {{-- <a class="categories-button-active custom-dropdown-home gap-2 hover-bg 
                                                             text-white"
                                                     href="#">
                                                     <span class="fi-rs-apps text-white fs-12 d-sm-flex d-none"></span>
                                                     Order Options
                                                     <i class="fi-rs-angle-down fs-12"></i>
                                                 </a>
                                                 <div
                                                     class="categories-dropdown-wrap categories-dropdown-active-large-2 categories-dropdown-active-large font-heading">
                                                     <div class="categori-dropdown-inner">
                                                         <ul>
                                                             <li>
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
                                                                     Warranty
                                                                 </a>
                                                             </li>
                                                         </ul>
                                                     </div>
                                                 </div> --}}
                                             </div>
                                         </div>
                                     </div>
                                     <div class="card-content p-3 py-4">
                                         <div class="d-sm-flex justify-content-between">
                                         </div>
                                         <div class="product-cards">
                                             <h5 class="underline pb-10 mb-25 d-sm-flex d-none">Products</h5>
                                             <div class="row">
                                                 @foreach ($order->getOrderItems as $order_item)
                                                     <div class="col-lg-12">
                                                         <div class="card p-3 mb-3 rounded-15">
                                                             <div class="d-flex gap-3">
                                                                 <a class="align-items-center border d-flex img-section p-1 rounded-3"
                                                                     href="#">
                                                                     <img src="{{ asset('storage/' . $order_item->getProduct->featured_image) }}"
                                                                         alt="img" class="img-fluid">
                                                                 </a>
                                                                 <div class="content py-2">
                                                                     <h6>
                                                                         @php
                                                                             if ($order_item->getProduct->slug) {
                                                                                 $shop_detail_url = route(
                                                                                     'shop-detail',
                                                                                     [
                                                                                         'slug' =>
                                                                                             $order_item->getProduct
                                                                                                 ->slug,
                                                                                         'id' =>
                                                                                             $order_item->getProduct
                                                                                                 ->id,
                                                                                     ],
                                                                                 );
                                                                             } else {
                                                                                 $shop_detail_url = route(
                                                                                     'shop-detail',
                                                                                     [
                                                                                         'slug' => 'no-slug',
                                                                                         'id' =>
                                                                                             $order_item->getProduct
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
                                                                             ->where('product_id', $order_item->item_id)
                                                                             ->get();

                                                                         $reviews_count = $reviews->count();
                                                                         $reviews_avg =
                                                                             $reviews_count > 0
                                                                                 ? round($reviews->avg('ratings'), 1)
                                                                                 : 0;
                                                                         $reviews_percentage = ($reviews_avg / 5) * 100;
                                                                     @endphp
                                                                     <div class="product-rate-cover">
                                                                         <div class="product-rate d-inline-block">
                                                                             <div class="product-rating"
                                                                                 style="width: {{ $reviews_percentage }}%">
                                                                             </div>
                                                                         </div>
                                                                         <span class="font-small ml-5 text-muted">
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
                             </div>
                         </div>
                         <div class="col-xl-3 primary-sidebar sticky-sidebar">
                             <div class="border p-20 cart-totals mb-25">
                                 <h4 class="mb-20 pb-2 underline">Details</h4>
                                 <div class="table-responsive">
                                     <table class="table no-border">
                                         <tbody>
                                             <tr class="d-flex justify-content-between border-0">
                                                 <td class="px-0 cart_total_label text-start">
                                                     <h6 class="text-muted">Order ID</h6>
                                                 </td>
                                                 <td class="px-0 cart_total_amount">
                                                     <h4 class="text-brand text-end fs-16">#{{ $order->id }}</h4>
                                                 </td>
                                             </tr>
                                             <tr class="d-flex justify-content-between border-0">
                                                 <td class="px-0 cart_total_label text-start">
                                                     <h6 class="text-muted">Order status</h6>
                                                 </td>
                                                 @php
                                                     $text = '';
                                                     $class = '';
                                                     if($order->status == 1){
                                                        $text = 'Processing';
                                                        $class = 'text-warning';
                                                     }else if($order->status == 2){
                                                        $text = 'Shipped';
                                                        $class = 'text-info';
                                                     }else if($order->status == 3){
                                                        $text = 'Completed';
                                                        $class = 'text-success';
                                                     }else if($order->status == 4){
                                                         $text = 'Cancelled';
                                                         $class = 'text-danger';
                                                     }
                                                 @endphp    
                                                 <td class="px-0 cart_total_amount">
                                                     <h5 class="{{ $class }} text-end fs-16">{{ $text }}</h4>
                                                 </td>
                                             </tr>
                                             <tr class="d-flex justify-content-between border-0">
                                                 <td class="px-0 cart_total_label text-start">
                                                     <h6 class="text-muted">Products</h6>
                                                 </td>
                                                 <td class="px-0 cart_total_amount">
                                                     <h5 class="text-heading text-end fs-16">{{count($order->getOrderItems)}}</h4>
                                                 </td>
                                             </tr>
                                             <tr class="d-flex justify-content-between border-0">
                                                 <td class="px-0 cart_total_label text-start">
                                                     <h6 class="text-muted">Order Placed</h6>
                                                 </td>
                                                 <td class="px-0 cart_total_amount">
                                                     <h5 class="text-heading text-end fs-16">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</h4>
                                                 </td>
                                             </tr>
                                             <tr class="d-flex justify-content-between border-0">
                                                 <td class="px-0 cart_total_label text-start">
                                                     <h6 class="text-muted">Shipping (₹)</h6>
                                                 </td>
                                                 <td class="px-0 cart_total_amount">
                                                     <h5 class="text-heading text-end fs-16">₹{{number_format($order->shipping_charges, 2)}}</h4>
                                                 </td>
                                             </tr>
                                             <tr class="d-flex justify-content-between border-0">
                                                 <td class="px-0 cart_total_label text-start">
                                                     <h6 class="text-muted">Discount (₹)</h6>
                                                 </td>
                                                 <td class="px-0 cart_total_amount">
                                                     <h5 class="text-success text-end fs-16">₹{{(float)$order->coupon_discount + (float)$order->offer_discount}}</h4>
                                                 </td>
                                             </tr>
                                             <tr class="d-flex justify-content-between mt-2 pt-2"
                                                 style="border-width: 2px 0px 0px 0px; border-style: dashed">
                                                 <td class="px-0 cart_total_label text-start">
                                                     <h6 class="text-heading fs-18">Total (₹)</h6>
                                                 </td>
                                                 <td class="px-0 cart_total_amount">
                                                     <h4 class="text-brand text-end fs-18">₹{{number_format($order->total, 2)}}</h4>
                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                             @php
                                 $address = json_decode($order->ship_different_address_details, true);
                             @endphp
                             <div class="border p-20 cart-totals">
                                 <h4 class="mb-20 pb-2 underline">Delivery Address</h4>
                                 <div class="address-details mb-4 px-1">
                                     <div class="align-items-center flex-wrap mb-10">
                                         <span class="me-2 text-muted fw-600 fs-16 quicksand">
                                             Name :
                                         </span>
                                         <span class="text-heading fw-600 fs-16 quicksand">
                                             {{ $address['name'] }}
                                         </span>
                                     </div>
                                     <div class="align-items-center flex-wrap mb-10">
                                         <span class="me-2 text-muted fw-600 fs-16 quicksand">
                                             Mobile :
                                         </span>
                                         <span class="text-heading fw-600 fs-16 quicksand">
                                             +91 {{ $address['mobile'] }}
                                         </span>
                                     </div>
                                     <div class="align-items-center flex-wrap mb-10">
                                         <span class="me-2 text-muted fw-600 fs-16 quicksand">
                                             State :
                                         </span>
                                         <span class="text-heading fw-600 fs-16 quicksand">
                                             {{ $address['state'] }}
                                         </span>
                                     </div>
                                     <div class="align-items-center flex-wrap mb-10">
                                         <span class="me-2 text-muted fw-600 fs-16 quicksand">
                                             Pincode :
                                         </span>
                                         <span class="text-heading fw-600 fs-16 quicksand">
                                             {{ $address['zipcode'] }}
                                         </span>
                                     </div>
                                     <div class="align-items-center flex-wrap mb-10">
                                         <span class="me-2 text-muted fw-600 fs-16 quicksand">
                                             Address :
                                         </span>
                                         <span class="text-heading fw-600 fs-16 quicksand">
                                             {{ $address['address_line_1'] }} {{ $address['address_line_2'] }}
                                         </span>
                                     </div>
                                     <div class="align-items-center flex-wrap mb-1">
                                         <span class="me-2 text-muted fw-600 fs-16 quicksand">
                                             Locality / Town :
                                         </span>
                                         <span class="text-heading fw-600 fs-16 quicksand">
                                             {{ $address['city'] }}
                                         </span>
                                     </div>
                                 </div>
                                 {{-- <a href="#"
                                     class="btn mb-20 w-100 d-flex justify-content-center align-items-center">Change
                                     Address<i class="fi-rs-marker ml-5"></i></a> --}}
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </main>
