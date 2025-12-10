<main class="main pages">
    @if ($user_id != null)
        @if ($step === 4)
            <div class="page-content pt-50 pb-30">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-11 m-auto">
                            <div class="coupon-card p-4 text-center">
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

                                            {{-- DYNAMIC COUPON CODE IN T&C --}}
                                            <li>Coupon code <strong>{{ $couponCode }}</strong> must be applied at
                                                checkout.</li>

                                            {{-- DYNAMIC MINIMUM ORDER VALUE --}}
                                            @if ($coupon->minimum_order_value > 0)
                                                <li>Minimum purchase of ₹{{ $coupon->minimum_order_value }} required to
                                                    avail discount.</li>
                                            @else
                                                <li>No minimum purchase required.</li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="terms-list text-muted small text-start mt-lg-3 mt-0 mx-auto">
                                            {{-- DYNAMIC MAX DISCOUNT (Usually for percentages) --}}
                                            @if ($coupon->maximum_discount_amount > 0)
                                                <li>Maximum discount capped at ₹{{ $coupon->maximum_discount_amount }}.
                                                </li>
                                            @endif

                                            <li>Non-transferable and cannot be redeemed for cash.</li>

                                            {{-- OPTIONAL: DYNAMIC EXPIRY DATE (If you have it) --}}
                                            <li>Offer valid till 30 November 2025 or while stocks last.</li>

                                            <li>Roll Mills reserves the right to modify or cancel the offer anytime.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($step === 3)
            <div class="container-lg mb-30 mt-50">
                <div class="row">
                    <div class="col-xl-11 col-lg-12 m-auto">
                        <div class="content mb-50">
                            <h1 class="title style-3 mb-20 text-center">Your Orders</h1>
                        </div>
                        <div class="table-responsive shopping-summery table-responsive-custom">
                            <table class="table table-wishlist mb-0">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col" class="custome-checkbox start pl-20">
                                            Order ID
                                        </th>
                                        <th scope="col">Product(s)</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Date Purchased</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user_orders as $user_order)
                                        <tr class="pt-30">
                                            <td class="custome-checkbox pl-30">
                                                <p class="small-screen-table-index">#{{ $user_order->id }}</p>
                                            </td>
                                            <td class="product-des product-name">
                                                <h5 class="mb-3 fs-18 underline">Product List</h5>
                                                @foreach ($user_order->getOrderItems as $item)
                                                    @php
                                                        $product = $item->getProduct;
                                                    @endphp
                                                    <div class="mb-2 order-list-divider">
                                                        <h6>
                                                            <a class="product-name hover-a fw-600 fs-15 mb-10"
                                                                href="/shop-detail">1.
                                                                {{ $product->name }}
                                                                <span
                                                                    class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x{{ $item->quantity }}</span>
                                                            </a>
                                                        </h6>
                                                        @php
                                                            $reviews = \App\Models\ProductReview::where('status', 1)
                                                                ->where('product_id', $item->item_id)
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
                                                                    style="width: {{ $reviews_percentage }}%"></div>
                                                            </div>
                                                            <span class="font-small ml-5 text-muted">
                                                                ({{ number_format($reviews_avg, 1) }})
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td class="price small-screen-table-td" data-title="Price">
                                                <h3 class="text-brand small-screen-table-td-content">
                                                    ₹{{ $user_order->total }}</h3>
                                            </td>
                                            <td class="detail-info small-screen-table-td" data-title="Date Purchased">
                                                <p class="fs-17 fw-700 small-screen-table-td-content">
                                                    {{ $user_order->created_at->format('d M Y') }}</p>
                                            </td>
                                            @if ($user_order->is_coupon_avail == 0)
                                                <td class="text-right">
                                                    <button type="button"
                                                        wire:click="applyCoupon({{ $user_order->id }})"
                                                        wire:confirm="Are you sure you want to avail coupon for these Order?"
                                                        class="btn btn-sm custom-btn-table-responsive">
                                                        Avail Coupon
                                                    </button>
                                                </td>
                                            @else
                                                <td class="text-right">
                                                    <button class="btn btn-sm custom-btn-table-responsive" wire:click="applyCoupon({{ $user_order->id }})">View Coupon</button>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{-- model --}}
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
                                    {{-- <h2>Enter Your mobile Number</h2> --}}
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

                                    <button type="submit" class="btn-brand w-100  text-center mt-3 quicksand">
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
                                        // Clear existing interval if needed and restart
                                        clearInterval(interval);
                                        this.startTimer();
                                    });
                                },
                                focusNext(index) {
                                    // Simple logic to move focus to next input
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

                                {{-- <div class="edit-link" wire:click="$set('step', 1)">
                                    <span>📱</span><span>+91 {{ $mobile }}</span>
                                    <span style="color: var(--color-1); font-weight: 600;">(Edit)</span>
                                </div> --}}

                                <form wire:submit.prevent="verifyOTP">
                                    <div class="otp-container">
                                        {{-- Use wire:model.defer to prevent constant network requests while typing --}}
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
                    backdrop: 'static', // Prevent close on outside click
                    keyboard: false // Prevent ESC close
                });

                myModal.show();
            }
        });
        </script>
    @endif
    <script>
        // --- 1. Auto-Open Modal on Page Load ---

        // --- 2. Livewire Close Modal Trigger ---
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', () => {
                const modalEl = document.getElementById('giftCouponModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);

                if (modalInstance) {
                    modalInstance.hide(); // Allowed close
                }
            });
        });

        // --- 3. Extra Protection: Block Any Forced Closing ---
        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('giftCouponModal');

            modalEl.addEventListener('hide.bs.modal', function(event) {
                // Allow closing ONLY if triggered by Livewire event
                if (!modalEl.dataset.allowClose) {
                    event.preventDefault(); // Block accidental close
                } else {
                    modalEl.dataset.allowClose = "";
                }
            });

            // When Livewire wants to close it
            Livewire.on('close-modal', () => {
                const modalEl = document.getElementById('giftCouponModal');
                modalEl.dataset.allowClose = "true"; // Allow close once
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                modalInstance.hide();
            });
        });



        // --- 2. Modal Logic (Steps, Timer, etc.) ---
        let currentStep = 1;
        let timerInterval = null;
        const otpInputs = document.querySelectorAll('.otp-input');

        // Phone Input Logic
        const phoneInput = document.getElementById('phone-input');
        if (phoneInput) {
            phoneInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') sendOTP();
            });
        }

        function sendOTP() {
            const phone = document.getElementById('phone-input').value;
            if (phone.length !== 10) {
                alert('Please enter a valid 10-digit mobile number');
                return;
            }
            // Mask phone number
            const masked = '••' + phone.slice(2);
            document.getElementById('phone-display').textContent = `+91 ${masked}`;

            // Note: goToStep(2) is handled by Livewire view, 
            // but we start the JS timer here
            startTimer();
        }

        function editPhone() {
            goToStep(1);
            document.getElementById('phone-input').focus();
            clearOTPInputs();
            if (timerInterval) clearInterval(timerInterval);
        }

        // OTP Input Logic
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (!/^\d*$/.test(e.target.value)) {
                    e.target.value = '';
                    return;
                }
                if (e.target.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
                if (e.key === 'Enter' && index === otpInputs.length - 1) {
                    verifyOTP();
                }
            });
        });

        function clearOTPInputs() {
            otpInputs.forEach(input => input.value = '');
        }

        function getOTPValue() {
            return Array.from(otpInputs).map(input => input.value).join('');
        }

        // Timer Logic
        function startTimer() {
            let time = 30;
            const timerEl = document.getElementById('timer');
            const resendBtn = document.getElementById('resend-btn');

            if (timerEl) timerEl.textContent = `${time}s`;
            if (resendBtn) resendBtn.style.display = 'none';

            if (timerInterval) clearInterval(timerInterval);

            timerInterval = setInterval(() => {
                time--;
                if (timerEl) timerEl.textContent = `${time}s`;

                if (time <= 0) {
                    clearInterval(timerInterval);
                    if (resendBtn) resendBtn.style.display = 'inline';
                }
            }, 1000);
        }

        function resendOTP() {
            clearOTPInputs();
            startTimer();
            otpInputs[0].focus();
        }

        function verifyOTP() {
            const otp = getOTPValue();
            if (otp.length !== 4) {
                alert('Please enter a valid 4-digit OTP');
                return;
            }
            if (timerInterval) clearInterval(timerInterval);
            goToStep(3);
        }

        function goToStep(step) {
            document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
            document.getElementById(`step-${step}`).classList.add('active');
            currentStep = step;
        }

        function copyCoupon(element) {
            const code = document.getElementById('coupon-code-text').textContent;
            navigator.clipboard.writeText(code).then(() => {
                const original = element.textContent;
                element.textContent = '✓ COPIED';
                setTimeout(() => {
                    element.textContent = original;
                }, 2000);
            });
        }
    </script>
    <script>
        document.addEventListener('click', function(event) {
            // Check if the clicked element has the ID 'copyCodeBtn'
            if (event.target && event.target.id === 'copyCodeBtn') {

                const copyBtn = event.target;
                const couponText = document.getElementById('couponCode');

                if (couponText) {
                    let code = couponText.innerText.trim();

                    // Copy to clipboard
                    navigator.clipboard.writeText(code).then(() => {
                        // UI Feedback
                        const originalText = copyBtn.innerText;
                        copyBtn.innerText = "Copied!";

                        // Optional: Change color using Bootstrap class or style
                        copyBtn.classList.add('text-success');

                        setTimeout(() => {
                            copyBtn.innerText = "Copy Code";
                            copyBtn.classList.remove('text-success');
                        }, 1500);
                    }).catch(err => {
                        console.error('Failed to copy text: ', err);
                        alert("Failed to copy. Please copy manually.");
                    });
                }
            }
        });
    </script>
@endpush
