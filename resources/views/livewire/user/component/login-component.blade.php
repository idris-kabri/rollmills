<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rollmills-modal">
            <div class="row g-0">
                
                <div class="col-md-7 p-4 left-box text-white">
                    
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
                            <span class="emoji">👱</span>
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

                <div class="col-md-5 p-4 bg-white right-box position-relative">

                    <button type="button" 
                            class="position-absolute top-0 end-0 m-3 border-0 bg-transparent text-secondary fs-4" 
                            style="z-index: 1050; cursor: pointer;"
                            data-bs-dismiss="modal" 
                            data-dismiss="modal" 
                            aria-label="Close">
                        <span aria-hidden="true" class="fw-bold">✖</span>
                    </button>

                    @if (!$otp_section_show)
                        <div id="stepMobile">
                            <h4 class="fw-bold text-dark mb-sm-3 quicksand">Login to Continue</h4>
                            <label class="form-label fw-semibold pb-sm-4">Mobile Number (WhatsApp)</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">🇮🇳 +91</span>
                                <input type="tel" id="mobileInput" class="form-control"
                                    placeholder="Enter mobile number" maxlength="10" wire:model.live="mobile"
                                    wire:keydown.enter="sendOTP ">
                            </div>
                            @error('mobile')
                                <span class="text-danger small d-block mb-2">{{ $message }}</span>
                            @enderror

                            @if ($password_section_show)
                                <div class="form-group mb-20" id="password-login">
                                    <label for="" class="ps-2 fw-600 quicksand fs-16 mb-2">Enter
                                        Password</label>
                                    <input type="password" class="form-control" wire:model="password"
                                        wire:keydown.enter="loginCheck" />
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-login w-100 mb-3 mt-3" wire:click="loginCheck">
                                    <span wire:loading.remove wire:target="loginCheck">Login</span>
                                    <span wire:loading wire:target="loginCheck">Logging in...</span>
                                </button>
                            @else
                                <button type="button" class="btn btn-login w-100 mb-3" wire:click="sendOTP">
                                    <span wire:loading.remove wire:target="sendOTP">Send OTP</span>
                                    <span wire:loading wire:target="sendOTP">Sending...</span>
                                </button>
                            @endif
                        </div>
                    @endif

                    @if ($otp_section_show)
                        <div id="stepOtp">
                            <h4 class="fw-bold text-dark mb-sm-3 quicksand">Enter OTP</h4>

                            <p class="text-muted mb-3">
                                We have sent a 4-digit OTP to <br>
                                <span class="fw-bold text-brand">+91 {{ $mobile }}</span>
                                <a href="#" wire:click.prevent="$set('otp_section_show', false)"
                                    class="quicksand text-decoration-none small ms-1"
                                    title="Wrong number? Click to edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </p>

                            <div class="d-flex gap-2 mb-3 otp-container">
                                <input type="number" maxlength="1" class="form-control otp-input text-center"
                                    wire:model.live="otp.0">
                                <input type="number" maxlength="1" class="form-control otp-input text-center"
                                    wire:model.live="otp.1">
                                <input type="number" maxlength="1" class="form-control otp-input text-center"
                                    wire:model.live="otp.2">
                                <input type="number" maxlength="1" class="form-control otp-input text-center"
                                    wire:model.live="otp.3" wire:keydown.enter="loginCheck">
                            </div>
                            @error('otp')
                                <span class="text-danger small d-block mb-2">{{ $message }}</span>
                            @enderror

                            <button type="button" class="btn btn-login w-100 mb-3" wire:click="loginCheck">
                                <span wire:loading.remove wire:target="loginCheck">Verify OTP</span>
                                <span wire:loading wire:target="loginCheck">Verifying...</span>
                            </button>

                            <div x-data="{
                                timeLeft: 60,
                                canResend: false,
                                timer: null,
                                startTimer() {
                                    this.timeLeft = 60;
                                    this.canResend = false;
                                    if (this.timer) clearInterval(this.timer);
                                    this.timer = setInterval(() => {
                                        this.timeLeft--;
                                        if (this.timeLeft <= 0) {
                                            clearInterval(this.timer);
                                            this.canResend = true;
                                        }
                                    }, 1000);
                                }
                            }" x-init="startTimer()" @resend-otp.window="startTimer()"
                                class="text-center small mt-3">

                                <span x-show="!canResend" class="text-muted quicksand">
                                    Didn’t receive OTP? Resend in <span class="fw-bold text-brand"
                                        x-text="timeLeft"></span>s
                                </span>

                                <a href="#" x-show="canResend" wire:click.prevent="resend"
                                    class="policy-link fw-bold quicksand" style="display: none;">
                                    Resend OTP
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Auto-move cursor for OTP fields
        // Using event delegation so it works even after Livewire DOM updates
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('otp-input')) {
                const inputs = document.querySelectorAll(".otp-input");
                const index = Array.from(inputs).indexOf(e.target);

                // Move to next input if value entered
                if (e.target.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
        });

        // Handle Backspace to move previous
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && e.target.classList.contains('otp-input')) {
                const inputs = document.querySelectorAll(".otp-input");
                const index = Array.from(inputs).indexOf(e.target);

                if (!e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            }
        });
    </script>
@endpush