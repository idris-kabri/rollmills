<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rollmills-modal">

            <div class="row g-0">

                <!-- LEFT SECTION -->
                <div class="col-lg-6 p-4 left-box text-white">
                    <h2 class="fw-bold">Welcome to Rollmills</h2>
                    <p class="mt-2 mb-4 tagline">
                        Smart solutions for logistics & supply chain excellence.
                    </p>

                    <div class="d-flex flex-column gap-3">

                        <div class="feature-box">
                            <span class="emoji">🚛</span>
                            <div>
                                <h5 class="fw-bold m-0">Fast Delivery</h5>
                                <p class="m-0 small">Safe & reliable transportation</p>
                            </div>
                        </div>

                        <div class="feature-box">
                            <span class="emoji">📦</span>
                            <div>
                                <h5 class="fw-bold m-0">Secure Handling</h5>
                                <p class="m-0 small">Your goods, our responsibility</p>
                            </div>
                        </div>

                        <div class="feature-box">
                            <span class="emoji">⭐</span>
                            <div>
                                <h5 class="fw-bold m-0">Trusted Service</h5>
                                <p class="m-0 small">Serving industries nationwide</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT SECTION -->
                <div class="col-lg-6 p-4 bg-white right-box">

                    <!-- STEP 1: MOBILE NUMBER -->
                    <div id="stepMobile">
                        <h4 class="fw-bold text-dark mb-3">Login to Continue</h4>

                        <label class="form-label fw-semibold">Mobile Number (WhatsApp)</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">🇮🇳 +91</span>
                            <input type="tel" id="mobileInput" class="form-control"
                                placeholder="Enter mobile number" maxlength="10" wire:model.live="mobile">
                        </div>

                        @if ($password_section_show)
                            <div class="form-group mb-20">
                                <label for="" class="ps-2 fw-600 quicksand fs-16 mb-2">Enter Password</label>
                                <input type="password" class="login-input" wire:model="password" />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="notifyCheck">
                            <label class="form-check-label" for="notifyCheck">
                                Notify me with offers & updates
                            </label>
                        </div>

                        <button type="button" class="btn btn-login w-100 mb-3" wire:click="sendOTP">Send OTP</button>

                        <p class="small text-muted text-center">
                            By continuing, you agree to our
                            <a href="#" class="policy-link">Privacy Policy</a> &
                            <a href="#" class="policy-link">Terms & Conditions</a>.
                        </p>
                    </div>

                    <!-- STEP 2: OTP SCREEN -->
                    @if ($otp_section_show)
                    <div id="stepOtp" class="d-none">

                        <h4 class="fw-bold text-dark mb-3">Enter OTP</h4>
                        <p class="text-muted">We have sent a 4-digit OTP to your WhatsApp number.</p>

                        <div class="d-flex gap-2 mb-3 otp-container">
                            <input type="text" maxlength="1" class="form-control otp-input" wire:model.live="otp.0">
                            <input type="text" maxlength="1" class="form-control otp-input" wire:model.live="otp.1">
                            <input type="text" maxlength="1" class="form-control otp-input" wire:model.live="otp.2">
                            <input type="text" maxlength="1" class="form-control otp-input" wire:model.live="otp.3">
                        </div>

                        <button class="btn btn-login w-100 mb-3">Verify OTP</button>

                        <p class="text-center small">
                            Didn’t receive OTP?
                            <a href="#" class="policy-link">Resend</a>
                        </p>

                    </div>
                    @endif

                </div>

            </div>

        </div>
    </div>
</div>


<script>
    document.getElementById("sendOtpBtn").addEventListener("click", function() {
        document.getElementById("stepMobile").classList.add("d-none");
        document.getElementById("stepOtp").classList.remove("d-none");
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
