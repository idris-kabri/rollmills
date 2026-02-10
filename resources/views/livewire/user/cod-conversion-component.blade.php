<main class="main pages">
    <style>
        .order-card-mobile {
            border: 1px solid #eee;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            background: #fff;
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .order-card-header {
            background: #f8f9fa;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .order-card-body {
            padding: 15px;
        }

        .order-card-footer {
            padding: 12px 15px;
            background: #fff;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-thumb-sm {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        /* Buttons */
        .btn-claim {
            background-color: #ffbc0d;
            /* Brand Gold */
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .btn-claim:hover {
            background-color: #e0a500;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-view-coupon {
            background-color: #25b579;
            /* Success Green */
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }

        .btn-view-coupon:hover {
            background-color: #1e9663;
            color: #fff;
            transform: translateY(-2px);
        }

        .badge-qty {
            background: #f1f1f1;
            color: #333;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
        }

        /* Desktop Table Tweaks */
        .table-custom-responsive thead th {
            font-family: 'Quicksand', sans-serif;
            font-weight: 700;
            color: #253D4E;
        }

        .product-list-scroll {
            max-height: 150px;
            overflow-y: auto;
            padding-right: 5px;
        }

        /* Custom Scrollbar for product list */
        .product-list-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .product-list-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .product-list-scroll::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        /* --- NEW STYLES FOR EMPTY STATE PROMO (UPDATED COLOR) --- */
        .empty-promo-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            padding: 50px 30px;
            position: relative;
            border: 1px solid #eee;
            overflow: hidden;
        }

        .dashed-offer-box {
            /* Updated to Brand Color rgb(220, 169, 22) */
            border: 2px dashed rgb(220, 169, 22);
            background-color: rgba(220, 169, 22, 0.05);
            /* Very light gold background */
            border-radius: 12px;
            padding: 20px;
            margin: 25px auto;
            max-width: 400px;
        }

        .discount-big-text {
            font-size: 3rem;
            font-weight: 800;
            /* Updated to Brand Color */
            color: rgb(220, 169, 22);
            line-height: 1;
        }

        .shop-now-btn-lg {
            padding: 12px 40px;
            font-size: 16px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            /* Updated to Brand Color */
            background-color: rgb(220, 169, 22);
            box-shadow: 0 4px 15px rgba(220, 169, 22, 0.3);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .shop-now-btn-lg:hover {
            transform: translateY(-3px);
            /* Slightly darker gold for hover */
            background-color: rgb(195, 149, 19);
            box-shadow: 0 8px 20px rgba(220, 169, 22, 0.4);
            color: white;
        }

        .text-brand-custom {
            color: rgb(220, 169, 22) !important;
        }
    </style>

    @if ($user_id != null)

        {{-- STEP 4: PAYMENT SUCCESS SCREEN --}}
        @if ($step === 4)
            <div class="page-content pt-50 pb-50">
                <div class="section">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="text-center order_complete mb-50">

                                    <i class="fas fa-check-circle" style="font-size:70px; color:#28a745;"></i>

                                    <div class="heading_s1 mt-20">
                                        <h3>Congratulation! You have Successfully Avail the discount for these order.
                                        </h3>
                                    </div>

                                    <p class="mt-10" style="font-size:18px;">
                                        We got your payment successfully.
                                        <br>
                                        <strong>Order ID: #{{ $id }}</strong>
                                    </p>

                                    <p>Your order is being processed. We will update you shortly with further details.
                                    </p>

                                    <a href="{{ url('/shop') }}" class="btn btn-fill-out mt-10">
                                        Continue Shopping
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- STEP 3: ORDER SELECTION (Responsive Table/Cards) --}}
        @if ($step === 3)
            <div class="container-lg mb-30 mt-50">
                <div class="row">
                    <div class="col-xl-10 col-lg-12 m-auto">

                        @if ($user_orders->count() > 0)
                            <div class="content mb-40 text-center">
                                <h1 class="title style-3 mb-10">Select an Order</h1>
                                <p class="text-muted quicksand">Choose a previous order to unlock your exclusive
                                    rewards!
                                </p>
                            </div>

                            {{-- DESKTOP VIEW: TABLE --}}
                            <div
                                class="table-responsive table-custom-responsive d-none d-md-block shadow-sm rounded-3 bg-white border">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr class="main-heading">
                                            <th scope="col" class="pl-30 py-4 rounded-start">Order Details</th>
                                            <th scope="col" class="py-4">Product List</th>
                                            <th scope="col" class="py-4">Order Amount</th>
                                            <th scope="col" class="py-4">Final Payable</th>
                                            <th scope="col" class="py-4 text-end pr-30 rounded-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user_orders as $user_order)
                                            <tr class="align-middle">
                                                <td class="pl-30 py-4">
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="fw-700 text-brand fs-16">#{{ $user_order->id }}</span>
                                                        <span
                                                            class="text-muted fs-13">{{ $user_order->created_at->format('d M Y') }}</span>
                                                        <span
                                                            class="text-muted fs-12">{{ $user_order->created_at->format('h:i A') }}</span>
                                                    </div>
                                                </td>
                                                <td class="product-des product-name py-4">
                                                    <div class="product-list-scroll">
                                                        @php
                                                            $discount = 0;
                                                        @endphp
                                                        @foreach ($user_order->getOrderItems as $item)
                                                            @php
                                                                $product = $item->getProduct;
                                                                $discount += ($item->total * 10) / 100;
                                                            @endphp
                                                            <div class="d-flex align-items-center mb-3">
                                                                {{-- Thumbnail --}}
                                                                <img src="{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('assets/frontend/imgs/shop/product-1-1.jpg') }}"
                                                                    class="product-thumb-sm me-3" alt="img">

                                                                <div>
                                                                    <h6 class="mb-0 fs-14 fw-600 text-heading">
                                                                        @php
                                                                            $shop_detail_url = $product->slug
                                                                                ? route('shop-detail', [
                                                                                    'slug' => $product->slug,
                                                                                    'id' => $product->id,
                                                                                ])
                                                                                : route('shop-detail', [
                                                                                    'slug' => 'no-slug',
                                                                                    'id' => $product->id,
                                                                                ]);
                                                                        @endphp
                                                                        <a href="{{ $item->is_gift_item == 1 ? 'javascripti:void(0);' : $shop_detail_url }}"
                                                                            class="text-heading hover-up">{{ Str::limit($product->name, 35) }}</a>
                                                                    </h6>
                                                                    <div class="d-flex align-items-center gap-2 mt-1">
                                                                        <span class="badge-qty">Qty:
                                                                            {{ $item->quantity }}</span>

                                                                        {{-- Rating (Optional) --}}
                                                                        @php
                                                                            $reviews = \App\Models\ProductReview::where(
                                                                                'status',
                                                                                1,
                                                                            )
                                                                                ->where('product_id', $item->item_id)
                                                                                ->get();
                                                                            $avg =
                                                                                $reviews->count() > 0
                                                                                    ? round($reviews->avg('ratings'), 1)
                                                                                    : 0;
                                                                        @endphp
                                                                        @if ($avg > 0)
                                                                            <div class="d-flex align-items-center">
                                                                                <i
                                                                                    class="fi-rs-star text-warning fs-10 me-1"></i>
                                                                                <span
                                                                                    class="fs-11 text-muted">{{ $avg }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="price py-4">
                                                    <h4 class="text-brand fs-18 fw-700">
                                                        ₹{{ number_format($user_order->total, 2) }}</h4>
                                                </td>
                                                <td class="price py-4">
                                                    <h4 class="text-brand fs-18 fw-700">
                                                        ₹{{ ceil($user_order->total - $discount - $user_order->cod_charges) }}
                                                    </h4>
                                                    {{-- Mentioning the deductions explicitly --}}
                                                    <span class="d-block text-muted fs-11 mt-1">10% Off Applied</span>
                                                    <span class="d-block text-success fs-11 fw-700">+ COD Fee
                                                        Waived</span>
                                                </td>
                                                <td class="text-end pr-30 py-4">
                                                    <button type="button"
                                                        wire:click="payNow({{ $user_order->id }}, {{ ceil($user_order->total - $discount - $user_order->cod_charges) }})"
                                                        class="btn btn-view-coupon shadow-sm"
                                                        wire:loading.attr="disabled">

                                                        <span wire:loading.remove wire:target="payNow">
                                                            <i class="fi-rs-money mr-5"></i> Pay Now
                                                        </span>

                                                        <span wire:loading wire:target="payNow">
                                                            <span class="spinner-border spinner-border-sm"
                                                                role="status" aria-hidden="true"></span>
                                                            Processing...
                                                        </span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- MOBILE VIEW: CARDS --}}
                            <div class="d-block d-md-none">
                                @foreach ($user_orders as $user_order)
                                    @php
                                        // Calculate Discount for Mobile View (Same logic as Desktop)
                                        $discount = 0;
                                        foreach ($user_order->getOrderItems as $item) {
                                            $discount += ($item->total * 10) / 100;
                                        }
                                        $final_amount = ceil($user_order->total - $discount - $user_order->cod_charges);
                                    @endphp

                                    <div class="order-card-mobile">
                                        <div class="order-card-header">
                                            <div>
                                                <span class="fw-700 text-dark">#{{ $user_order->id }}</span>
                                                <div class="fs-12 text-muted">
                                                    {{ $user_order->created_at->format('d M, Y h:i A') }}
                                                </div>
                                            </div>
                                            <div>
                                                <span
                                                    class="badge bg-warning-light text-warning rounded-pill px-2">COD</span>
                                            </div>
                                        </div>

                                        <div class="order-card-body">
                                            @foreach ($user_order->getOrderItems as $item)
                                                @php $product = $item->getProduct; @endphp
                                                <div class="d-flex align-items-start mb-3 last:mb-0">
                                                    <img src="{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('assets/frontend/imgs/shop/product-1-1.jpg') }}"
                                                        class="product-thumb-sm me-3" alt="img">
                                                    <div>
                                                        <p class="mb-0 fs-14 fw-600 text-dark lh-sm">
                                                            {{ Str::limit($product->name, 40) }}
                                                        </p>
                                                        <span class="fs-12 text-muted">Qty:
                                                            {{ $item->quantity }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="order-card-footer">
                                            <div class="d-flex flex-column">
                                                <span class="fs-12 text-muted text-decoration-line-through">
                                                    ₹{{ number_format($user_order->total) }}
                                                </span>
                                                <span class="text-brand fs-18 fw-800">
                                                    ₹{{ $final_amount }}
                                                </span>
                                                {{-- Mentioning the deductions explicitly in mobile --}}
                                                <span class="fs-10 text-success fw-bold">10% OFF + COD Waived</span>
                                            </div>

                                            <button type="button"
                                                wire:click="payNow({{ $user_order->id }}, {{ $final_amount }})"
                                                class="btn btn-view-coupon" wire:loading.attr="disabled">

                                                <span wire:loading.remove wire:target="payNow">
                                                    Pay Now <i class="fi-rs-money ml-5"></i>
                                                </span>

                                                <span wire:loading wire:target="payNow">
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- NEW: EMPTY STATE 10% DISCOUNT PROMO (GOLD THEME) --}}
                            <div class="row">
                                <div class="col-lg-8 col-md-10 m-auto">
                                    <div class="empty-promo-card text-center">

                                        {{-- Icon/Image --}}
                                        <div class="mb-4">
                                            <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-cart.svg') }}"
                                                alt="Shopping Bag"
                                                style="width: 80px; filter: hue-rotate(30deg) sepia(100%) saturate(1000%) hue-rotate(350deg) opacity(0.8);">
                                        </div>

                                        <h2 class="mb-2 fw-800 text-dark">Welcome to Roll Mills!</h2>
                                        <p class="text-muted quicksand fs-16 mb-0">
                                            It looks like you haven't placed an order yet. <br
                                                class="d-none d-md-block">
                                            Start your journey with us today and grab a special welcome reward.
                                        </p>

                                        {{-- The Offer Box --}}
                                        <div class="dashed-offer-box">
                                            <span class="text-uppercase text-muted fs-12 fw-700 ls-1">Exclusive First
                                                Order
                                                Offer</span>
                                            <div class="discount-big-text my-2">10% OFF</div>
                                        </div>

                                        {{-- CTA Button --}}
                                        <a href="/shop" class="shop-now-btn-lg quicksand fw-700">
                                            Shop Now & Save 10% <i class="fi-rs-arrow-right ms-2"></i>
                                        </a>

                                        <p class="mt-4 fs-12 text-muted fst-italic">
                                            *Terms and conditions apply. Valid on your first purchase only.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{-- MODAL --}}
    <div wire:ignore.self class="modal fade" id="giftCouponModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="rollmills-modal">

                    <div class="left-box">
                        <div class="left-box-content">
                            <h1 class="text-left">Roll into Rewards with Rollmills!</h1>
                            <p class="quicksand text-light">Enter your number → Get your OTP → Pay your discounted
                                order amount.</p>
                            <div class="feature-list mt-4">
                                <div class="feature-item">
                                    <span class="feature-emoji">✓</span>
                                    <span class="quicksand">Spin great deals your way</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-emoji">✓</span>
                                    <span class="quicksand">Quick & secure WhatsApp verification</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-emoji">✓</span>
                                    <span class="quicksand">Unlock savings that truly thrill</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="right-box">

                        {{-- STEP 1: MOBILE ENTRY --}}
                        @if ($step === 1)
                            <div class="form-step active">
                                <div class="form-header">
                                    <h2>Your code is now few step away!!</h2>
                                    <p>Enter your WhatsApp mobile number to get OTP.</p>
                                </div>

                                <form wire:submit.prevent="sendOTP">
                                    <div class="custom-input-group">
                                        <div class="phone-prefix">
                                            <span>🇮🇳</span><span>+91</span>
                                        </div>
                                        <input type="text"
                                            class="phone-input @error('mobile') is-invalid @enderror quicksand"
                                            wire:model="mobile" placeholder="Enter mobile number" maxlength="10"
                                            inputmode="numeric">
                                    </div>
                                    @error('mobile')
                                        <span class="text-danger quicksand">{{ $message }} !!</span>
                                    @enderror

                                    <button type="submit" class="btn-brand w-100 text-center mt-3 quicksand">
                                        <span wire:loading.remove wire:target="sendOTP">Send OTP</span>
                                        <span wire:loading wire:target="sendOTP">Sending...</span>
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- STEP 2: OTP VERIFICATION --}}
                        @if ($step === 2)
                            <div class="form-step active" x-data="{
                                timeLeft: 30,
                                startTimer() {
                                    this.timeLeft = 30;
                                    let interval = setInterval(() => {
                                        this.timeLeft--;
                                        if (this.timeLeft <= 0) clearInterval(interval);
                                    }, 1000);
                            
                                    // Listen for livewire resend event to reset
                                    Livewire.on('reset-timer', () => {
                                        this.timeLeft = 30;
                                        clearInterval(interval);
                                        this.startTimer();
                                    });
                                },
                                focusNext(index) {
                                    let nextInput = document.getElementById('otp-' + (index + 1));
                                    if (nextInput && $el.value.length > 0) nextInput.focus();
                                }
                            }" x-init="startTimer()">
                                <div class="form-header">
                                    <h2>Enter OTP</h2>
                                    <p class="position-relative">We've sent a code to
                                        <span class="color-1 fw-500">
                                            +91 {{ $mobile }}
                                        </span>
                                        <span class="edit-link d-inline-block fs-10 position-relative mb-0"
                                            style="top: -3px" wire:click="$set('step', 1)">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </span>
                                    </p>
                                </div>

                                <form wire:submit.prevent="verifyOTP">
                                    <div class="otp-container">
                                        @foreach ($otp as $index => $digit)
                                            <input type="text" id="otp-{{ $index }}"
                                                class="otp-input @error('otp') is-invalid @enderror"
                                                wire:model="otp.{{ $index }}" maxlength="1"
                                                inputmode="numeric" x-on:input="focusNext({{ $index }})"
                                                x-on:keydown.backspace="$el.value.length == 0 ? document.getElementById('otp-{{ $index - 1 }}')?.focus() : ''">
                                        @endforeach
                                    </div>
                                    @error('otp')
                                        <div class="text-center"><span
                                                class="text-danger quicksand fw-500">{{ $message }} !!</span>
                                        </div>
                                    @enderror

                                    <div class="timer-container">
                                        <span x-show="timeLeft > 0">Resend OTP in <strong
                                                x-text="timeLeft + 's'"></strong></span>
                                        <a class="resend-link" wire:click="resend" x-show="timeLeft <= 0"
                                            style="cursor:pointer; color:var(--color-1);">Resend OTP</a>
                                    </div>

                                    <button type="submit" class="btn-brand w-100 text-center">
                                        <span wire:loading.remove wire:target="verifyOTP">Verify OTP</span>
                                        <span wire:loading wire:target="verifyOTP">Verifying...</span>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
    @if (!auth()->check())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modalElement = document.getElementById('giftCouponModal');

                if (modalElement) {
                    var myModal = new bootstrap.Modal(modalElement, {
                        backdrop: 'static',
                        keyboard: false
                    });

                    myModal.show();
                }
            });
        </script>
    @endif
    <script>
        // Livewire Close Modal Trigger
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', () => {
                const modalEl = document.getElementById('giftCouponModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);

                if (modalInstance) {
                    modalInstance.hide();
                }
            });
        });

        // Extra Protection: Block Any Forced Closing unless allowed
        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('giftCouponModal');

            if (modalEl) {
                modalEl.addEventListener('hide.bs.modal', function(event) {
                    if (!modalEl.dataset.allowClose) {
                        event.preventDefault();
                    } else {
                        modalEl.dataset.allowClose = "";
                    }
                });

                Livewire.on('close-modal', () => {
                    const modalEl = document.getElementById('giftCouponModal');
                    modalEl.dataset.allowClose = "true";
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();
                });
            }
        });

        // Copy Code Script
        document.addEventListener('click', function(event) {
            if (event.target && event.target.id === 'copyCodeBtn') {
                const copyBtn = event.target;
                const couponText = document.getElementById('couponCode');

                if (couponText) {
                    let code = couponText.innerText.trim();
                    navigator.clipboard.writeText(code).then(() => {
                        const originalText = copyBtn.innerText;
                        copyBtn.innerText = "Copied!";
                        copyBtn.classList.add('text-success');

                        setTimeout(() => {
                            copyBtn.innerText = "Copy Code";
                            copyBtn.classList.remove('text-success');
                        }, 1500);
                    }).catch(err => {
                        console.error('Failed to copy text: ', err);
                    });
                }
            }
        });
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            let wishlistModal = null;

            Livewire.on('open-coupon-claim-modal', () => {
                wishlistModal = new bootstrap.Modal(document.getElementById('CouponClaimModal'), {
                    backdrop: 'static', // ← important
                    keyboard: false // ← important
                });
                wishlistModal.show();
            });

            Livewire.on('close-coupon-claim-modal', () => {
                if (wishlistModal) {
                    wishlistModal.hide();
                }
            });

            window.addEventListener('initiate-razorpay', function(event) {
                const detail = event.detail[0] || event.detail;
                var options = {
                    "key": '{{ config('app.razorpay_key_id') }}',
                    "amount": detail.amount,
                    "currency": "INR",
                    "name": "Roll mills",
                    "description": detail.description,
                    "image": "https://rollmills.store/assets/frontend/imgs/theme/logo.png",
                    "order_id": detail.razorpay_order_id,
                    "handler": function(response) {
                        window.location.href =
                            `${detail.success_url}?transaction_id=${detail.transaction_id}&payment_id=${response.razorpay_payment_id}&order_id=${detail.razorpay_order_id}&title=${detail.title}&customer_name=${detail.customer_name}&customer_email=${detail.customer_email}&type=order_payment&id=${detail.id}`;
                    },
                    "prefill": {
                        "name": detail.name,
                        "email": detail.email
                    },
                    "theme": {
                        "color": "#CF9007"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            });
        });
    </script>
@endpush
