 <main class="main pages">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
     <style>
         /* --- Custom Modal Styling --- */
         .product-review-modal {
             border: none;
             border-radius: 24px;
             overflow: hidden;
             box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
         }

         /* --- Left Side (Dark Gradient Background) --- */
         .product-review-modal .review-left-box {
             /* The main gradient background */
             background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
             display: flex;
             flex-direction: column;
             justify-content: center;
             align-items: center;
             position: relative;
             color: #ffffff;
             /* Explicit White Text for Contrast */
         }

         /* Guidelines/Tips Box */
         .guidelines-box {
             background: rgba(255, 255, 255, 0.15);
             border: 1px solid rgba(255, 255, 255, 0.2);
             border-radius: 16px;
             padding: 25px;
             backdrop-filter: blur(10px);
             width: 100%;
             max-width: 350px;
             box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
         }

         /* --- Right Side (White Background) --- */
         .product-review-modal .review-right-box {
             background-color: #ffffff;
             height: 100%;
             color: #2c3e50;
             /* Matches the dark slate of the left gradient */
         }

         /* Headings on the right side */
         .review-right-box h4 {
             color: #2c3e50;
             font-weight: 800;
             letter-spacing: -0.5px;
         }

         /* Labels on the right side */
         .form-label {
             color: #4ca1af;
             /* Teal accent from the gradient */
             font-weight: 700;
             font-size: 0.8rem;
             letter-spacing: 0.5px;
             text-transform: uppercase;
         }

         /* --- Input & Textarea Styling --- */
         .product-review-modal textarea.form-control {
             resize: none;
             /* Removes resize handle */
             border-radius: 12px;
             background-color: #f8f9fa;
             border: 2px solid #e9ecef;
             color: #2c3e50;
             font-size: 0.95rem;
             transition: all 0.3s ease;
         }

         .product-review-modal textarea.form-control:focus {
             background-color: #fff;
             border-color: #4ca1af;
             /* Focus color matches gradient */
             box-shadow: 0 0 0 4px rgba(76, 161, 175, 0.1);
         }

         .product-review-modal textarea.form-control::placeholder {
             color: #adb5bd;
         }

         /* --- Star Rating --- */
         .star-rating-group {
             display: flex;
             gap: 8px;
             cursor: pointer;
         }

         .star-icon {
             font-size: 2.2rem;
             color: #e9ecef;
             /* Inactive gray */
             transition: transform 0.2s, color 0.2s;
         }

         /* Gold for active/hover */
         .star-icon.active,
         .star-icon.hovered {
             color: #ffc107;
             transform: scale(1.1);
         }

         /* --- Image Upload Area --- */
         .upload-box {
             border: 2px dashed #cbd5e0;
             border-radius: 12px;
             padding: 25px;
             text-align: center;
             cursor: pointer;
             transition: all 0.3s ease;
             background: #f8f9fa;
             position: relative;
             overflow: hidden;
         }

         .upload-box:hover {
             border-color: #4ca1af;
             background: #f0fdfa;
             /* Very light teal tint */
         }

         .upload-box .icon-container {
             font-size: 2rem;
             color: #4ca1af;
             margin-bottom: 10px;
         }

         /* Image Previews */
         .preview-grid {
             display: grid;
             grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
             gap: 10px;
             margin-top: 15px;
         }

         .preview-img {
             width: 100%;
             height: 70px;
             object-fit: cover;
             border-radius: 8px;
             border: 2px solid #e9ecef;
             box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
             transition: transform 0.2s;
         }

         .preview-img:hover {
             transform: scale(1.05);
             border-color: #4ca1af;
         }

         /* --- Submit Button --- */
         .btn-gradient {
             /* Matches the Left Side Gradient */
             background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
             border: none;
             color: white;
             transition: all 0.3s ease;
         }

         .btn-gradient:hover {
             transform: translateY(-2px);
             box-shadow: 0 5px 15px rgba(44, 62, 80, 0.4);
             color: white;
         }
     </style>
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
                                                             <h5 class="fs-24">
                                                                 Order ID <span
                                                                     class="text-brand">#{{ $user_order->id }}</span>
                                                             </h5>

                                                             <div class="d-flex align-items-center gap-2">
                                                                 <!-- FIX STARTS HERE -->

                                                                 <button type="button"
                                                                     class="btn btn-sm btn-outline-brand hover-up font-xs"
                                                                     wire:click.prevent="openReviewModalForOrder({{ $user_order->id }})">
                                                                     <i class="fi-rs-star mr-5"></i> Add Review for
                                                                     Order
                                                                 </button>

                                                                 <div class="position-relative">
                                                                     <a class="categories-button-active custom-dropdown-home gap-2 hover-bg text-white"
                                                                         href="#">
                                                                         <span
                                                                             class="fi-rs-apps text-white fs-12"></span>
                                                                         Order Options
                                                                         <i class="fi-rs-angle-down fs-12"></i>
                                                                     </a>

                                                                     <div
                                                                         class="categories-dropdown-wrap categories-dropdown-active-large-2 font-heading">
                                                                         <div class="categori-dropdown-inner">
                                                                             <ul>
                                                                                 <li>
                                                                                     <a
                                                                                         href="{{ route('user-order-detail', $user_order->id) }}">
                                                                                         View Order Details
                                                                                     </a>
                                                                                 </li>
                                                                             </ul>
                                                                         </div>
                                                                     </div>
                                                                 </div>

                                                             </div> <!-- FIX ENDS HERE -->
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
                                                     $item_reviews = \App\Models\ProductReview::where('status', 1)
                                                         ->where('product_id', $item->id)
                                                         ->get();

                                                     $item_reviews_count = $item_reviews->count();
                                                     $item_reviews_avg =
                                                         $item_reviews_count > 0
                                                             ? round($item_reviews->avg('ratings'), 1)
                                                             : 0;
                                                     $item_reviews_percentage = ($item_reviews_avg / 5) * 100;
                                                 @endphp
                                                 <div class="product-rate">
                                                     <div class="product-rating"
                                                         style="width: {{ $item_reviews_percentage }}%"></div>
                                                 </div>
                                             </div>
                                         </div>
                                     @endforeach
                                 </div>
                                 @if ($banner != null)
                                     <div class="banner-img wow fadeIn mb-40 animated d-lg-block d-none">
                                         <img src="{{ asset('storage/' . $banner->image) }}" alt="" />
                                         <div class="banner-text">
                                             <span>{{ $banner->heading }}</span>
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

     <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-xl modal-dialog-centered">
             <div class="modal-content product-review-modal">
                 <div class="row g-0">

                     <!-- LEFT SIDE: Visuals & Tips -->
                     <div class="col-md-5 p-5 review-left-box text-center">

                         <!-- Illustration -->
                         <div class="mb-4">
                             <img src="https://cdn-icons-png.flaticon.com/512/1484/1484560.png" class="img-fluid"
                                 alt="Review Graphic"
                                 style="max-width: 200px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.25));">
                         </div>

                         <h3 class="fw-bold mb-2 text-white">Your Opinion Matters!</h3>
                         <p class="mb-4 text-white-50 fs-6">Help us improve by sharing your honest feedback.</p>

                         <!-- Glassmorphism Box -->
                         <div class="guidelines-box text-start">
                             <h6 class="fw-bold text-uppercase small mb-3 text-warning">
                                 <i class="bi bi-lightbulb-fill me-2"></i>Review Tips
                             </h6>
                             <ul class="small mb-0 ps-3 text-white" style="opacity: 0.9; line-height: 1.7;">
                                 <li>Be specific about features you liked.</li>
                                 <li>Mention build quality & delivery.</li>
                                 <li>Photos help others visualize the product.</li>
                             </ul>
                         </div>
                     </div>

                     <!-- RIGHT SIDE: Form -->
                     <div class="col-md-7 p-5 review-right-box">
                         <div class="d-flex justify-content-between align-items-center mb-4">
                             <h4 class="m-0">Write a Review</h4>
                             <button type="button" class="btn-close" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                         </div>

                         <form id="reviewForm" onsubmit="handleReviewSubmit(event)">

                             <!-- Star Rating -->
                             <div class="mb-4">
                                 <label class="form-label">Overall Rating</label>
                                 <div class="star-rating-group" id="starContainer">
                                     <!-- Stars generated by HTML or JS, adding data-value -->
                                     <i class="bi bi-star-fill star-icon" data-value="1"></i>
                                     <i class="bi bi-star-fill star-icon" data-value="2"></i>
                                     <i class="bi bi-star-fill star-icon" data-value="3"></i>
                                     <i class="bi bi-star-fill star-icon" data-value="4"></i>
                                     <i class="bi bi-star-fill star-icon" data-value="5"></i>
                                 </div>
                                 <input type="hidden" name="rating" id="ratingInput">
                                 <div id="ratingText" class="small mt-2 fw-bold"
                                     style="color: #ffc107; height: 20px;"></div>
                             </div>

                             <!-- Comment Area -->
                             <div class="mb-4">
                                 <label class="form-label">Your Feedback</label>
                                 <textarea class="form-control" rows="6" placeholder="Tell us what you liked or disliked about this product..."
                                     required></textarea>
                             </div>

                             <!-- Photo Upload -->
                             <div class="mb-4">
                                 <label class="form-label">Add Photos</label>
                                 <div class="upload-box" onclick="document.getElementById('reviewImages').click()">
                                     <input type="file" id="reviewImages" multiple accept="image/*"
                                         class="d-none" onchange="previewFiles(this)">

                                     <div class="icon-container">
                                         <i class="bi bi-camera"></i>
                                     </div>
                                     <h6 class="fw-bold text-dark mb-1">Drop images here</h6>
                                     <p class="text-muted small mb-0">or click to browse</p>
                                 </div>
                                 <div id="previewContainer" class="preview-grid"></div>
                             </div>

                             <!-- Submit Button -->
                             <button type="submit" class="btn btn-gradient w-100 py-3 fw-bold rounded-3 shadow-sm">
                                 Submit Review
                             </button>
                         </form>
                     </div>

                 </div>
             </div>
         </div>
     </div>
 </main>

 @push('scripts')
     <script>
         document.addEventListener('DOMContentLoaded', () => {
             window.addEventListener('open-review-modal', () => {
                 let modal = new bootstrap.Modal(document.getElementById('reviewModal'));
                 modal.show();
             });

             window.addEventListener('close-review-modal', () => {
                 let modal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
                 if (modal) modal.hide();
             });
         });
     </script>
     <script>
         /* --- Star Rating Logic --- */
         const stars = document.querySelectorAll('.star-icon');
         const ratingInput = document.getElementById('ratingInput');
         const ratingText = document.getElementById('ratingText');
         const ratingLabels = ["Poor", "Fair", "Good", "Very Good", "Excellent"];

         stars.forEach(star => {
             // Hover Effect
             star.addEventListener('mouseover', () => {
                 const val = parseInt(star.getAttribute('data-value'));
                 highlightStars(val);
             });

             // Click Effect
             star.addEventListener('click', () => {
                 const val = parseInt(star.getAttribute('data-value'));
                 ratingInput.value = val;
                 ratingText.textContent = ratingLabels[val - 1];
                 highlightStars(val);
                 // Lock the visual state by adding a 'selected' class logic if needed, 
                 // but for simplicity we rely on the input value in a real app.
                 // Here we just keep the highlight based on click for the demo.
                 stars.forEach(s => s.classList.remove('active'));
                 for (let i = 0; i < val; i++) {
                     stars[i].classList.add('active');
                 }
             });
         });

         // Reset hover on mouse leave (if not clicked)
         document.getElementById('starContainer').addEventListener('mouseleave', () => {
             const currentRating = ratingInput.value;
             if (currentRating) {
                 highlightStars(currentRating);
             } else {
                 highlightStars(0);
             }
         });

         function highlightStars(count) {
             stars.forEach(star => {
                 const val = parseInt(star.getAttribute('data-value'));
                 if (val <= count) {
                     star.classList.add('hovered');
                 } else {
                     star.classList.remove('hovered');
                     // Keep active class if it was clicked
                     if (!ratingInput.value || val > ratingInput.value) {
                         star.classList.remove('active');
                     }
                 }
             });
         }

         /* --- Image Preview Logic --- */
         function previewFiles(input) {
             const container = document.getElementById('previewContainer');
             container.innerHTML = ''; // Clear previous

             if (input.files) {
                 Array.from(input.files).forEach(file => {
                     const reader = new FileReader();
                     reader.onload = function(e) {
                         const img = document.createElement('img');
                         img.src = e.target.result;
                         img.classList.add('preview-img');
                         container.appendChild(img);
                     }
                     reader.readAsDataURL(file);
                 });
             }
         }

         /* --- Form Submit Logic --- */
         function handleReviewSubmit(e) {
             e.preventDefault();
             const btn = e.target.querySelector('button[type="submit"]');
             const originalText = btn.innerText;

             // Simulate loading
             btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
             btn.disabled = true;

             setTimeout(() => {
                 btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Review Submitted!';
                 btn.classList.remove('btn-gradient');
                 btn.classList.add('btn-success');

                 setTimeout(() => {
                     // Close modal using Bootstrap instance
                     const modalEl = document.getElementById('reviewModal');
                     const modal = bootstrap.Modal.getInstance(modalEl);
                     modal.hide();

                     // Reset form
                     e.target.reset();
                     document.getElementById('previewContainer').innerHTML = '';
                     ratingInput.value = '';
                     stars.forEach(s => s.classList.remove('active', 'hovered'));
                     ratingText.textContent = '';

                     // Reset button
                     btn.disabled = false;
                     btn.innerText = originalText;
                     btn.classList.remove('btn-success');
                     btn.classList.add('btn-gradient');
                 }, 1500);
             }, 1500);
         }
     </script>
 @endpush
