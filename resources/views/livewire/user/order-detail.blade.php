<main class="main pages">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- CSS Styles --}}
    <style>
        /* Modal & Review Styles */
        .product-review-modal {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .product-review-modal .review-left-box {
            background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            color: #ffffff;
        }

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

        .product-review-modal .review-right-box {
            background-color: #ffffff;
            height: 100%;
            color: #2c3e50;
        }

        .review-right-box h4 {
            color: #2c3e50;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .form-label {
            color: #4ca1af;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .product-review-modal textarea.form-control {
            resize: none;
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
            box-shadow: 0 0 0 4px rgba(76, 161, 175, 0.1);
        }

        .star-rating-group {
            display: flex;
            gap: 8px;
            cursor: pointer;
        }

        .star-icon {
            font-size: 2.2rem;
            color: #e9ecef;
            transition: transform 0.2s, color 0.2s;
        }

        .star-icon.active,
        .star-icon.hovered {
            color: #ffc107;
            transform: scale(1.1);
        }

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
        }

        .upload-box .icon-container {
            font-size: 2rem;
            color: #4ca1af;
            margin-bottom: 10px;
        }

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

        .btn-gradient {
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
                                            <h5 class="fs-24">Order ID <span
                                                    class="text-brand">#{{ $order->id }}</span></h5>
                                            @if ($order->status == 0 || $order->status == 1)
                                                @php
                                                    $number = '918764766553';
                                                    $orderId = $order->id;
                                                    $message = "I want to cancel this Order (Order ID: $orderId)";
                                                    $whatsappUrl = "https://wa.me/$number?text=" . urlencode($message);
                                                @endphp


                                                <div class="review-btn-section mt-2 mt-md-0">
                                                    <a href="{{ $whatsappUrl }}" target="_blank"
                                                        class="btn btn-sm btn-outline-brand hover-up font-xs">
                                                        <i class="fi-rs-star mr-1"></i> Cancel
                                                        Product
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-content p-3 py-4">
                                        <div class="product-cards">
                                            <h5 class="underline pb-10 mb-25 d-sm-flex d-none">Products</h5>
                                            <div class="row">
                                                @foreach ($order->getOrderItems as $order_item)
                                                    <div class="col-lg-12">
                                                        <div class="card p-3 mb-3 rounded-15">
                                                            <div class="d-flex gap-3 align-items-center flex-wrap">
                                                                <a class="align-items-center border d-flex img-section p-1 rounded-3"
                                                                    href="#">
                                                                    <img src="{{ asset('storage/' . $order_item->getProduct->featured_image) }}"
                                                                        alt="img" class="img-fluid w-100 h-100 rounded-3"
                                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                                </a>

                                                                <div class="content py-2 flex-grow-1">
                                                                    <h6>
                                                                        <a href="#"
                                                                            class="fs-17">{{ $order_item->getProduct->name }}</a>
                                                                    </h6>

                                                                    {{-- Rating Stars Display --}}
                                                                    @php
                                                                        $reviews = \App\Models\ProductReview::where(
                                                                            'status',
                                                                            1,
                                                                        )
                                                                            ->where('product_id', $order_item->item_id)
                                                                            ->get();
                                                                        $reviews_avg =
                                                                            $reviews->count() > 0
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
                                                                        <span
                                                                            class="font-small ml-5 text-muted">({{ number_format($reviews_avg, 1) }})</span>
                                                                    </div>

                                                                    <div class="product-price pt-2">
                                                                        <span
                                                                            class="fs-18 fw-bold">₹{{ number_format($order_item->regular_price, 2) }}</span>
                                                                        <span
                                                                            class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x{{ $order_item->quantity }}</span>
                                                                    </div>
                                                                </div>

                                                                @php
                                                                    $order = $order_item->getOrder;
                                                                    $product = $order_item->getProduct;

                                                                    $completeAt = $order->complete_at
                                                                        ? \Carbon\Carbon::parse($order->complete_at)
                                                                        : null;
                                                                    $today = \Carbon\Carbon::now();

                                                                    // product return / replacement days
                                                                    $returnDays = (int) $product->product_return_days;
                                                                    $replacementDays =
                                                                        (int) $product->product_replacement_days;

                                                                    $showReturn = false;
                                                                    $showReplace = false;

                                                                    if ($order->status == 3 && $completeAt) {
                                                                        // ====== CHECK RETURN ======
                                                                        if ($returnDays > 0) {
                                                                            $returnLastDate = $completeAt
                                                                                ->copy()
                                                                                ->addDays($returnDays);
                                                                            if (
                                                                                $today->lessThanOrEqualTo(
                                                                                    $returnLastDate,
                                                                                )
                                                                            ) {
                                                                                $showReturn = true;
                                                                            }
                                                                        }

                                                                        // ====== CHECK REPLACEMENT (only if return expired or not allowed) ======
                                                                        if (!$showReturn && $replacementDays > 0) {
                                                                            $replaceLastDate = $completeAt
                                                                                ->copy()
                                                                                ->addDays($replacementDays);
                                                                            if (
                                                                                $today->lessThanOrEqualTo(
                                                                                    $replaceLastDate,
                                                                                )
                                                                            ) {
                                                                                $showReplace = true;
                                                                            }
                                                                        }
                                                                    }

                                                                    // ====== WHATSAPP LOGIC ======
                                                                    $number = '918764766553'; // WhatsApp number without +
                                                                    $productName = $product->name ?? '';
                                                                    $orderId = $order->id ?? '';

                                                                    // Dynamic message for each case
                                                                    if ($showReturn) {
                                                                        $message = "I want to return this product: $productName (Order ID: $orderId)";
                                                                    } elseif ($showReplace) {
                                                                        $message = "I want to replace this product: $productName (Order ID: $orderId)";
                                                                    } else {
                                                                        $message = null; // no return or replace
                                                                    }

                                                                    $whatsappUrl = $message
                                                                        ? "https://wa.me/$number?text=" .
                                                                            urlencode($message)
                                                                        : null;
                                                                @endphp


                                                                @if ($order->status == 3)
                                                                    <div class="review-btn-section mt-2 mt-md-0">

                                                                        {{-- Write Review --}}
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-brand hover-up font-xs"
                                                                            wire:click.prevent="openReviewModalForProduct({{ $order_item->item_id }})">
                                                                            <i class="fi-rs-star mr-1"></i> Write Review
                                                                        </button>

                                                                        {{-- Return --}}
                                                                        @if ($showReturn && $whatsappUrl)
                                                                            <a href="{{ $whatsappUrl }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-outline-warning hover-up font-xs">
                                                                                <i class="fi-rs-rotate-left mr-1"></i>
                                                                                Return
                                                                            </a>
                                                                        @endif

                                                                        {{-- Replace --}}
                                                                        @if ($showReplace && $whatsappUrl)
                                                                            <a href="{{ $whatsappUrl }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-outline-info hover-up font-xs">
                                                                                <i class="fi-rs-refresh mr-1"></i>
                                                                                Replace
                                                                            </a>
                                                                        @endif

                                                                    </div>
                                                                @endif

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
                                            {{-- ... Other rows ... --}}
                                            <tr class="d-flex justify-content-between mt-2 pt-2"
                                                style="border-width: 2px 0px 0px 0px; border-style: dashed">
                                                <td class="px-0 cart_total_label text-start">
                                                    <h6 class="text-heading fs-18">Total (₹)</h6>
                                                </td>
                                                <td class="px-0 cart_total_amount">
                                                    <h4 class="text-brand text-end fs-18">
                                                        ₹{{ number_format($order->total, 2) }}</h4>
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
                                        <span class="me-2 text-muted fw-600 fs-16 quicksand">Name :</span>
                                        <span class="text-heading fw-600 fs-16 quicksand">{{ $address['name'] }}</span>
                                    </div>
                                    <div class="align-items-center flex-wrap mb-10">
                                        <span class="me-2 text-muted fw-600 fs-16 quicksand">Address :</span>
                                        <span class="text-heading fw-600 fs-16 quicksand">
                                            {{ $address['address_line_1'] }} {{ $address['address_line_2'] }},
                                            {{ $address['city'] }}, {{ $address['zipcode'] }}
                                        </span>
                                    </div>
                                </div>

                                <a href="https://wa.me/918764766553?text=Order%20ID:%20%23{{ $order->id }}%20I%20want%20to%20change%20address"
                                    target="_blank"
                                    class="btn btn-success w-100 d-flex justify-content-center align-items-center gap-2"
                                    style="background-color: #25D366; border-color: #25D366;">
                                    <i class="bi bi-whatsapp"></i> Change Address
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content product-review-modal">
                <div class="row g-0">
                    <div class="col-md-5 p-5 review-left-box text-center">
                        <div class="mb-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/1484/1484560.png" class="img-fluid"
                                alt="Review Graphic"
                                style="max-width: 200px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.25));">
                        </div>
                        <h3 class="fw-bold mb-2 text-white">Your Opinion Matters!</h3>
                        <p class="mb-4 text-white-50 fs-6">Share your experience with this specific product.</p>
                        <div class="guidelines-box text-start">
                            <h6 class="fw-bold text-uppercase small mb-3 text-warning"><i
                                    class="bi bi-lightbulb-fill me-2"></i>Tips</h6>
                            <ul class="small mb-0 ps-3 text-white" style="opacity: 0.9; line-height: 1.7;">
                                <li>Be specific about features.</li>
                                <li>Mention quality & durability.</li>
                                <li>Photos help others greatly.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-7 p-5 review-right-box">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="m-0">Write a Review</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <form id="reviewForm" wire:submit.prevent="submitReview">
                            <div class="mb-4">
                                <label class="form-label">Overall Rating</label>
                                <div class="star-rating-group" id="starContainer">
                                    <i class="bi bi-star-fill star-icon" data-value="1"></i>
                                    <i class="bi bi-star-fill star-icon" data-value="2"></i>
                                    <i class="bi bi-star-fill star-icon" data-value="3"></i>
                                    <i class="bi bi-star-fill star-icon" data-value="4"></i>
                                    <i class="bi bi-star-fill star-icon" data-value="5"></i>
                                </div>
                                <input type="hidden" name="rating" id="ratingInput" wire:model="rating">
                                @error('rating')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <div id="ratingText" class="small mt-2 fw-bold"
                                    style="color: #ffc107; height: 20px;"></div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Your Feedback</label>
                                <textarea class="form-control" rows="6" wire:model="remarks"
                                    placeholder="Tell us what you liked about this item..."></textarea>
                                @error('remarks')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Add Photos</label>
                                <div class="upload-box" onclick="document.getElementById('reviewImages').click()">
                                    <input type="file" id="reviewImages" multiple accept="image/*" class="d-none"
                                        onchange="previewFiles(this)" wire:model="review_images">
                                    <div class="icon-container"><i class="bi bi-camera"></i></div>
                                    <h6 class="fw-bold text-dark mb-1">Drop images here</h6>
                                    <p class="text-muted small mb-0">or click to browse</p>
                                </div>
                                <div id="previewContainer" class="preview-grid" wire:ignore></div>
                                @error('review_images.*')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-gradient w-100 py-3 fw-bold rounded-3 shadow-sm"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>Submit Review</span>
                                <span wire:loading><span
                                        class="spinner-border spinner-border-sm me-2"></span>Processing...</span>
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
            let reviewModal;

            window.addEventListener('open-review-modal', () => {
                const el = document.getElementById('reviewModal');
                reviewModal = new bootstrap.Modal(el);
                reviewModal.show();
            });

            window.addEventListener('close-review-modal', () => {
                const el = document.getElementById('reviewModal');
                const modal = bootstrap.Modal.getInstance(el);
                if (modal) modal.hide();
                document.getElementById('previewContainer').innerHTML = '';
            });
        });

        /* --- Star Rating Logic --- */
        const stars = document.querySelectorAll('.star-icon');
        const ratingText = document.getElementById('ratingText');
        const ratingLabels = ["Poor", "Fair", "Good", "Very Good", "Excellent"];

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const val = parseInt(star.getAttribute('data-value'));
                highlightStars(val);
            });

            star.addEventListener('click', () => {
                const val = parseInt(star.getAttribute('data-value'));
                @this.set('rating', val);
                ratingText.textContent = ratingLabels[val - 1];
                highlightStars(val);
                stars.forEach(s => s.classList.remove('active'));
                for (let i = 0; i < val; i++) {
                    stars[i].classList.add('active');
                }
            });
        });

        document.getElementById('starContainer').addEventListener('mouseleave', () => {
            const currentRating = @this.get('rating');
            highlightStars(currentRating || 0);
        });

        function highlightStars(count) {
            stars.forEach(star => {
                const val = parseInt(star.getAttribute('data-value'));
                if (val <= count) {
                    star.classList.add('hovered');
                } else {
                    star.classList.remove('hovered');
                }
            });
        }

        /* --- Image Preview Logic --- */
        function previewFiles(input) {
            const container = document.getElementById('previewContainer');
            container.innerHTML = '';

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
    </script>
@endpush
