<main class="main pages">
    <style>
        /* --- GENERAL & UTILS --- */
        .text-brand-custom {
            color: rgb(220, 169, 22) !important;
        }

        .bg-brand-custom {
            background-color: rgb(220, 169, 22) !important;
            color: #fff;
        }

        /* --- STEP 3: SINGLE ORDER SUMMARY CARD --- */
        .single-order-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #eee;
        }

        .order-header-strip {
            background: #f8f9fa;
            padding: 15px 25px;
            border-bottom: 1px dashed #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Product List Area */
        .order-items-container {
            padding: 25px;
            max-height: 400px;
            overflow-y: auto;
        }

        .order-item-row {
            display: flex;
            align-items: center;
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .item-thumb {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #eee;
        }

        /* Payment Summary Area (Right Side) */
        .payment-summary-box {
            background: #fffbf0;
            /* Light Gold Tint */
            padding: 30px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-left: 1px dashed #e0e0e0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
            color: #555;
        }

        .summary-row.savings {
            color: #25b579;
            font-weight: 600;
        }

        .divider-line {
            height: 1px;
            background: #ddd;
            margin: 15px 0;
        }

        .final-amount-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .final-price-text {
            font-size: 28px;
            font-weight: 800;
            color: rgb(220, 169, 22);
        }

        .btn-pay-now-lg {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            background-color: rgb(220, 169, 22);
            color: #fff;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(220, 169, 22, 0.3);
        }

        .btn-pay-now-lg:hover {
            transform: translateY(-2px);
            background-color: rgb(195, 149, 19);
            box-shadow: 0 8px 20px rgba(220, 169, 22, 0.4);
            color: #fff;
        }

        /* Mobile Responsiveness for Step 3 */
        @media (max-width: 991px) {
            .payment-summary-box {
                border-left: none;
                border-top: 1px dashed #e0e0e0;
                padding: 20px;
            }

            .order-header-strip {
                padding: 15px;
            }

            .order-items-container {
                padding: 15px;
                max-height: 300px;
            }
        }

        /* --- EMPTY STATE STYLES --- */
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
            border: 2px dashed rgb(220, 169, 22);
            background-color: rgba(220, 169, 22, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin: 25px auto;
            max-width: 400px;
        }

        .discount-big-text {
            font-size: 3rem;
            font-weight: 800;
            color: rgb(220, 169, 22);
            line-height: 1;
        }

        .shop-now-btn-lg {
            padding: 12px 40px;
            font-size: 16px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: rgb(220, 169, 22);
            box-shadow: 0 4px 15px rgba(220, 169, 22, 0.3);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .shop-now-btn-lg:hover {
            transform: translateY(-3px);
            background-color: rgb(195, 149, 19);
            box-shadow: 0 8px 20px rgba(220, 169, 22, 0.4);
            color: white;
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

        {{-- STEP 3: SINGLE ORDER PAYMENT SUMMARY OR LATE MESSAGE --}}
        @if ($step === 3)
            <div class="container-lg mb-30 mt-50">
                <div class="row">
                    <div class="col-xl-10 col-lg-12 m-auto">

                        @php
                            $order = $user_orders;
                        @endphp

                        {{-- CHECK IF ORDER STATUS IS VALID FOR PAYMENT --}}
                        @if (!$order || $order->status > 1)
                            {{-- LATE / EXPIRED VIEW --}}
                            <div class="empty-promo-card text-center">
                                <div class="mb-20">
                                    <i class="fas fa-history text-brand-custom"
                                        style="font-size: 80px; opacity: 0.8;"></i>
                                </div>
                                <h2 class="fw-800 mb-10">Payment Window Closed</h2>
                                <p class="quicksand text-muted fs-18">
                                    We are sorry, but you are late. You can't pay for this order now
                                    <br>as the status has changed or the time limit has expired.
                                </p>

                                <div class="dashed-offer-box">
                                    <p class="mb-0 quicksand fw-600">Don't worry! You can still explore our latest
                                        collection.</p>
                                </div>

                                <a href="{{ url('/shop') }}" class="shop-now-btn-lg btn mt-20">
                                    Return to Shop
                                </a>
                            </div>
                        @else
                            {{-- NORMAL PAYMENT VIEW --}}
                            @php
                                // Calculate Totals
                                $discount = 0;
                                foreach ($order->getOrderItems as $item) {
                                    $discount += ($item->total * 10) / 100;
                                }
                                $final_amount = ceil($order->total - $discount - $order->cod_charges);
                            @endphp

                            <div class="content mb-40 text-center">
                                <h1 class="title style-3 mb-10">Complete Your Order</h1>
                                <p class="text-muted quicksand">Review your order details and proceed to payment.</p>
                            </div>

                            <div class="single-order-card">
                                <div class="row g-0">
                                    {{-- Left Side: Order Details & Items --}}
                                    <div class="col-lg-8">
                                        <div class="order-header-strip">
                                            <div>
                                                <h5 class="mb-1 fw-700">Order #{{ $order->id }}</h5>
                                                <span
                                                    class="text-muted fs-13">{{ $order->created_at->format('d M, Y h:i A') }}</span>
                                            </div>
                                            <span
                                                class="badge bg-warning-light text-warning rounded-pill px-3 py-2">Payment
                                                Pending</span>
                                        </div>

                                        <div class="order-items-container">
                                            @foreach ($order->getOrderItems as $item)
                                                @php $product = $item->getProduct; @endphp
                                                <div class="order-item-row">
                                                    <img src="{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('assets/frontend/imgs/shop/product-1-1.jpg') }}"
                                                        class="item-thumb me-3" alt="img">

                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fs-15 fw-600 text-heading">
                                                            {{ Str::limit($product->name, 50) }}
                                                        </h6>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="badge-qty">Qty: {{ $item->quantity }}</span>
                                                            <span
                                                                class="text-brand fs-14 fw-700">₹{{ number_format($item->total) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Right Side: Payment Summary --}}
                                    <div class="col-lg-4">
                                        <div class="payment-summary-box">
                                            <h5 class="mb-20 fw-700">Payment Summary</h5>

                                            <div class="summary-row">
                                                <span>Current Order Amount</span>
                                                <span class="">₹{{ number_format($order->total) }}</span>
                                            </div>

                                            <div class="summary-row savings">
                                                <span><i class="fi-rs-check-circle me-1"></i> 10% Discount</span>
                                                <span>- ₹{{ number_format($discount, 2) }}</span>
                                            </div>

                                            @if ($order->cod_charges > 0)
                                                <div class="summary-row savings">
                                                    <span><i class="fi-rs-check-circle me-1"></i> COD Fee Waived</span>
                                                    <span>- ₹{{ number_format($order->cod_charges) }}</span>
                                                </div>
                                            @endif

                                            <div class="divider-line"></div>

                                            <div class="final-amount-row">
                                                <span class="fw-700 fs-16 text-dark">Total Payable</span>
                                                <span class="final-price-text">₹{{ $final_amount }}</span>
                                            </div>

                                            <button type="button"
                                                wire:click="payNow({{ $order->id }}, {{ $final_amount }})"
                                                class="btn-pay-now-lg shadow-sm" wire:loading.attr="disabled">

                                                <span wire:loading.remove wire:target="payNow">
                                                    Pay Now <i class="fi-rs-arrow-right ml-10"></i>
                                                </span>

                                                <span wire:loading wire:target="payNow">
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span>
                                                    Processing...
                                                </span>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{-- MODAL (Login/OTP) --}}
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
