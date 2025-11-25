<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rollmills-modal">
            <div class="row g-0">
                <!-- LEFT SECTION -->
                <div class="col-md-6 p-4 left-box text-white">
                    <img class="img-fluid" src="{{ asset('assets/frontend/imgs/theme/logo.png') }}" alt="">
                    <p class="tagline">
                        Pay online & get FLAT 20% OFF.
                    </p>

                    <div class="d-flex gap-3">
                        <div class="feature-box">
                            <span class="emoji">🚛</span>
                            <div>
                                <h5 class="fw-bold ">Fast Delivery</h5>
                                <p class=" small">Safe & reliable transportation</p>
                            </div>
                        </div>

                        <div class="feature-box">
                            <span class="emoji">📦</span>
                            <div>
                                <h5 class="fw-bold ">Customer First</h5>
                                <p class=" small">Your goods, our responsibility</p>
                            </div>
                        </div>

                        <div class="feature-box">
                            <span class="emoji">⭐</span>
                            <div>
                                <h5 class="fw-bold ">Quality Products</h5>
                                <p class=" small">Provides hand picked products</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT SECTION -->
                <div class="col-md-6 p-4 bg-white right-box">

                    <!-- STEP 1: MOBILE NUMBER -->
                    <div id="stepMobile">
                        <h4 class="fw-bold text-dark mb-3">Login to Continue</h4>

                        <label class="form-label fw-semibold">Mobile Number (WhatsApp)</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">🇮🇳 +91</span>
                            <input type="tel" id="mobileInput" class="form-control"
                                placeholder="Enter mobile number" maxlength="10" wire:model.live="mobile">
                        </div>

                        <div class="form-group mb-20" id="password-login">
                            <label for="" class="ps-2 fw-600 quicksand fs-16 mb-2">Enter Password</label>
                            <input type="password" class="login-input" wire:model="password" />
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="button" class="btn btn-login w-100 mb-3" id="send-otp-button" wire:click="sendOTP">Send OTP</button>
                        <button type="button" class="btn btn-login w-100 mb-3" id="login-button" wire:click="loginCheck">Login</button>
                    </div>

                    <div id="stepOtp" class="d-none">

                        <h4 class="fw-bold text-dark mb-3">Enter OTP</h4>
                        <p class="text-muted">We have sent a 4-digit OTP to your WhatsApp number.</p>

                        <div class="d-flex gap-2 mb-3 otp-container">
                            <input type="text" maxlength="1" class="form-control otp-input" wire:model.live="otp.0">
                            <input type="text" maxlength="1" class="form-control otp-input" wire:model.live="otp.1">
                            <input type="text" maxlength="1" class="form-control otp-input" wire:model.live="otp.2">
                            <input type="text" maxlength="1" class="form-control otp-input" wire:model.live="otp.3">
                        </div>

                        <button type="button" class="btn btn-login w-100 mb-3" wire:click="loginCheck">Verify OTP</button>

                        <p class="text-center small">
                            Didn’t receive OTP?
                            <a href="#" class="policy-link">Resend</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // The '?' prevents the crash if the element isn't found
            document.getElementById('password-login')?.classList.add('d-none');
            document.getElementById('login-button')?.classList.add('d-none');
        });
        // Auto-move cursor for OTP fields
        const inputs = document.querySelectorAll(".otp-input");
        inputs.forEach((input, index) => {
            input.addEventListener("input", () => {
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });
    </script>
@endpush
