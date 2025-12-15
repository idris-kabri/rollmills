<main class="main pages">
    {{-- Custom Styles for this page --}}
    <style>
        /* Order Card Styles (Mobile) */
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
    </style>

    @if ($user_id != null)
    {{-- STEP 4: COUPON DISPLAY --}}
    <div wire:ignore.self class="modal fade" id="CouponClaimModal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content-custom w-100">
                <div class="mb-4">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/frontend/imgs/page/coupon-claim.png') }}"
                            class="img-fluid mb-3 mt-4 modal-logo" style="height: 130px" />
                    </div>

                    <h1 class="fs-3 text-center">Are you Sure?</h1>
                    <p class="fs-6 mx-auto text-center quicksand">
                        {{ $confirmMessage }}
                    </p>
                </div>

                <div class="pb-4 d-flex flex-column justify-content-center">
                    <button class="btn mb-3 w-90-per pt-10 pb-10" wire:click.prevent="{{ $confirmAction }}" style="background-color: #1e9663;">
                        🎉 Claim Your Coupon
                    </button>

                    <button class="btn mx-auto pt-10 pb-10 w-90-per" data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if ($step === 4)
    <div class="page-content pt-50 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-11 m-auto">

                    <div class="coupon-card p-4 text-center position-relative">
                        
                        {{-- BACK BUTTON --}}
                        {{-- Added position-relative and z-index: 1000 to ensure clickable --}}
                        <div class="w-100 text-start mb-4 position-relative" style="z-index: 1000;">
                            <button
                                type="button"
                                class="btn btn-sm btn-light border rounded-pill shadow-sm px-3 d-inline-flex align-items-center gap-2"
                                wire:click="backMain">
                                <i class="fas fa-arrow-left"></i> <span>Back to Orders</span>
                            </button>
                        </div>

                        <h1 class="title-bg">OFFER</h1>
                        <h2 class="offer-title text-uppercase mt-35 text-center">Roll into Savings with <br>
                            <span class="fw-900">Roll Mills!</span>
                        </h2>

                        {{-- DYNAMIC DISCOUNT MESSAGE --}}
                        <div class="discount-amount fw-600 text-secondary mt-2 fs-18 mb-4">
                            Congratulations! You've unlocked a
                            @if ($coupon->discount_type == 'Percentage')
                            {{ $coupon->discount_value }}%
                            @else
                            ₹{{ $coupon->discount_value }}
                            @endif
                            discount on your next purchase. <br>
                            <span>Keep the savings rolling with Roll Mills!</span>
                        </div>

                        <div class="result-display mt-0">
                            <p id="copyCodeBtn" class="position-absolute end-0 top-0 fs-12 copy-code">Copy Code
                            </p>
                            <p id="couponCode" class="result-numbers">{{ $couponCode }}</p>
                        </div>

                        <p class="discount-amount fw-600 text-secondary mt-4 fs-16 fst-italic">
                            Use this code on checkout and let the deals roll your way!
                        </p>

                        <div class="row">
                            <div class="col-12">
                                <h5 class="mt-3 fs-24 text-brand">Terms & Conditions</h5>
                            </div>
                            <div class="col-lg-6">
                                <ul class="terms-list text-muted small text-start mt-3 mx-auto">
                                    <li>Valid only on Roll Mills’ official website.</li>
                                    <li>Coupon code <strong>{{ $couponCode }}</strong> must be applied at checkout.</li>
                                    @if ($coupon->minimum_order_value > 0)
                                    <li>Minimum purchase of ₹{{ $coupon->minimum_order_value }} required to avail discount.</li>
                                    @else
                                    <li>No minimum purchase required.</li>
                                    @endif
                                    <li>You can use these coupon code after <strong>{{ \Carbon\Carbon::parse($coupon->start_date)->format('d M Y') }}</strong></li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="terms-list text-muted small text-start mt-lg-3 mt-0 mx-auto">
                                    @if ($coupon->maximum_discount_amount > 0)
                                    <li>Maximum discount capped at ₹{{ $coupon->maximum_discount_amount }}.</li>
                                    @endif
                                    <li>Non-transferable and cannot be redeemed for cash.</li>
                                    <li>Offer valid till {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M Y') }}.</li>
                                    <li>Roll Mills reserves the right to modify or cancel the offer anytime.</li>
                                </ul>
                            </div>
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
                <div class="content mb-40 text-center">
                    <h1 class="title style-3 mb-10">Select an Order</h1>
                    <p class="text-muted quicksand">Choose a previous order to unlock your exclusive rewards!</p>
                </div>

                @if($user_orders->count() > 0)
                {{-- DESKTOP VIEW: TABLE --}}
                <div class="table-responsive table-custom-responsive d-none d-md-block shadow-sm rounded-3 bg-white border">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr class="main-heading">
                                <th scope="col" class="pl-30 py-4 rounded-start">Order Details</th>
                                <th scope="col" class="py-4">Product List</th>
                                <th scope="col" class="py-4">Total</th>
                                <th scope="col" class="py-4 text-end pr-30 rounded-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_orders as $user_order)
                            <tr class="align-middle">
                                <td class="pl-30 py-4">
                                    <div class="d-flex flex-column">
                                        <span class="fw-700 text-brand fs-16">#{{ $user_order->id }}</span>
                                        <span class="text-muted fs-13">{{ $user_order->created_at->format('d M Y') }}</span>
                                        <span class="text-muted fs-12">{{ $user_order->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="product-des product-name py-4">
                                    <div class="product-list-scroll">
                                        @foreach ($user_order->getOrderItems as $item)
                                        @php $product = $item->getProduct; @endphp
                                        <div class="d-flex align-items-center mb-3">
                                            {{-- Thumbnail --}}
                                            <img src="{{ $product->featured_image ? asset('storage/'.$product->featured_image) : asset('assets/frontend/imgs/shop/product-1-1.jpg') }}"
                                                class="product-thumb-sm me-3" alt="img">

                                            <div>
                                                <h6 class="mb-0 fs-14 fw-600 text-heading">
                                                    <a href="/shop-detail" class="text-heading hover-up">{{ Str::limit($product->name, 35) }}</a>
                                                </h6>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    <span class="badge-qty">Qty: {{ $item->quantity }}</span>

                                                    {{-- Rating (Optional) --}}
                                                    @php
                                                    $reviews = \App\Models\ProductReview::where('status', 1)->where('product_id', $item->item_id)->get();
                                                    $avg = $reviews->count() > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                                    @endphp
                                                    @if($avg > 0)
                                                    <div class="d-flex align-items-center">
                                                        <i class="fi-rs-star text-warning fs-10 me-1"></i>
                                                        <span class="fs-11 text-muted">{{ $avg }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="price py-4">
                                    <h4 class="text-brand fs-18 fw-700">₹{{ number_format($user_order->total, 2) }}</h4>
                                </td>
                                <td class="text-end pr-30 py-4">
                                    @if ($user_order->is_coupon_avail == 0)
                                    <button type="button"
                                        wire:click="askClaim({{ $user_order->id }})"
                                        class="btn btn-claim shadow-sm">
                                        <i class="fi-rs-gift mr-5"></i> Claim Coupon
                                    </button>
                                    @else
                                    <button type="button"
                                        wire:click="applyCoupon({{ $user_order->id }})"
                                        class="btn btn-view-coupon shadow-sm">
                                        <i class="fi-rs-eye mr-5"></i> View Coupon
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE VIEW: CARDS --}}
                <div class="d-block d-md-none">
                    @foreach ($user_orders as $user_order)
                    <div class="order-card-mobile">
                        <div class="order-card-header">
                            <div>
                                <span class="fw-700 text-dark">Order #{{ $user_order->id }}</span>
                                <div class="fs-12 text-muted">{{ $user_order->created_at->format('d M, Y') }}</div>
                            </div>
                            <div>
                                @if($user_order->is_coupon_avail == 0)
                                <span class="badge bg-danger-light text-danger rounded-pill px-2">Pending Claim</span>
                                @else
                                <span class="badge bg-success-light text-success rounded-pill px-2">Claimed</span>
                                @endif
                            </div>
                        </div>

                        <div class="order-card-body">
                            @foreach ($user_order->getOrderItems as $item)
                            @php $product = $item->getProduct; @endphp
                            <div class="d-flex align-items-start mb-3 last:mb-0">
                                <img src="{{ $product->featured_image ? asset('storage/'.$product->featured_image) : asset('assets/frontend/imgs/shop/product-1-1.jpg') }}"
                                    class="product-thumb-sm me-3" alt="img">
                                <div>
                                    <p class="mb-0 fs-14 fw-600 text-dark lh-sm">{{ Str::limit($product->name, 40) }}</p>
                                    <span class="fs-12 text-muted">Qty: {{ $item->quantity }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="order-card-footer">
                            <div>
                                <span class="fs-12 text-muted d-block">Total Amount</span>
                                <span class="text-brand fs-18 fw-800">₹{{ number_format($user_order->total) }}</span>
                            </div>

                            @if ($user_order->is_coupon_avail == 0)
                            <button type="button"
                                wire:click="applyCoupon({{ $user_order->id }})"
                                wire:confirm="Avail coupon for Order #{{$user_order->id}}?"
                                class="btn btn-claim">
                                Claim <i class="fi-rs-arrow-right ml-5"></i>
                            </button>
                            @else
                            <button type="button"
                                wire:click="applyCoupon({{ $user_order->id }})"
                                class="btn btn-view-coupon">
                                View <i class="fi-rs-eye ml-5"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                {{-- EMPTY STATE --}}
                <div class="text-center py-5">
                    <img src="{{ asset('assets/frontend/imgs/theme/icons/icon-cart.svg') }}" alt="Empty" style="width: 60px; opacity: 0.5; margin-bottom: 20px;">
                    <h4 class="mb-2">No Eligible Orders Found</h4>
                    <p class="text-muted mb-4">You need to make a purchase before you can claim rewards!</p>
                    <a href="/shop" class="btn btn-brand">Shop Now</a>
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
                            <p class="quicksand text-light">Enter your number → Get your OTP → Claim your exclusive
                                coupon.</p>
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
@if(!auth()->check())
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
    });
</script>
@endpush