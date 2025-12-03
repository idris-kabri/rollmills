<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span>  My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                            <img class="border-radius-15 h-100"
                                src="{{ asset('assets/frontend/imgs/page/istockphoto-1478421401-612x612.jpg') }}"
                                alt="" style="object-fit: cover" />
                        </div>
                        <div class="col-lg-6 col-md-8 pl-20">
                            <div class="login_wrap widget-taber-content background-white py-4">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1 ps-md-2">
                                        <h2 class="mb-30">Welcome Back !!</h2>

                                    </div>
                                    <form method="post" wire:submit.prevent="loginCheck">
                                        <div class="form-group mb-20">
                                            <label for="" class="ps-2 fw-600 quicksand fs-16 mb-2"> Enter Mobile
                                                Number</label>
                                            <input
                                                type="number"
                                                required
                                                wire:model.live="mobile"
                                                placeholder="Enter 10-digit Number"
                                                class="login-input"
                                                inputmode="numeric"
                                                pattern="[0-9]*"
                                                min="0"
                                                @if($otp_section_show || $password_section_show ) readonly @endif
                                                oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                        </div>

                                        @if($password_section_show)
                                        <div class="form-group mb-20">
                                            <label for="" class="ps-2 fw-600 quicksand fs-16 mb-2">Enter Password</label>
                                            <input type="password" class="login-input" wire:model="password" />
                                            @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        @endif

                                        @if ($otp_section_show)
                                        <div class="form-group mb-20"
                                            x-data="{
        next(i, e) {
          // keep only one digit
          e.target.value = e.target.value.replace(/\D/g,'').slice(0,1);
          if (e.target.value && i < 3) this.$refs['o' + (i+1)].focus();
        },
        prev(i, e) {
          if (!e.target.value && i > 0) this.$refs['o' + (i-1)].focus();
        },
        paste(e) {
          const val = (e.clipboardData || window.clipboardData).getData('text')
            .replace(/\D/g,'').slice(0,4);
          [...val].forEach((d, idx) => {
            const r = this.$refs['o' + idx];
            if (r) {
              r.value = d;
              $wire.set(`otp.${idx}`, d); // sync Livewire when pasting
            }
          });
          if (val.length) this.$refs['o' + Math.min(val.length-1, 3)].focus();
        }
     }">
                                            <label class="ps-2 fw-600 quicksand fs-16 mb-2">Enter OTP</label>

                                            <div class="d-flex justify-content-between" x-on:paste.prevent="paste($event)">
                                                <input type="text" id="otp1" x-ref="o0"
                                                    class="otp-input login-input text-center"
                                                    style="width: 24%" maxlength="1"
                                                    inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code"
                                                    wire:model.live="otp.0"
                                                    x-on:input="next(0, $event)"
                                                    x-on:keydown.backspace="prev(0, $event)">

                                                <input type="text" id="otp2" x-ref="o1"
                                                    class="otp-input login-input text-center"
                                                    style="width: 24%" maxlength="1"
                                                    inputmode="numeric" pattern="[0-9]*"
                                                    wire:model.live="otp.1"
                                                    x-on:input="next(1, $event)"
                                                    x-on:keydown.backspace="prev(1, $event)">

                                                <input type="text" id="otp3" x-ref="o2"
                                                    class="otp-input login-input text-center"
                                                    style="width: 24%" maxlength="1"
                                                    inputmode="numeric" pattern="[0-9]*"
                                                    wire:model.live="otp.2"
                                                    x-on:input="next(2, $event)"
                                                    x-on:keydown.backspace="prev(2, $event)">

                                                <input type="text" id="otp4" x-ref="o3"
                                                    class="otp-input login-input text-center"
                                                    style="width: 24%" maxlength="1"
                                                    inputmode="numeric" pattern="[0-9]*"
                                                    wire:model.live="otp.3"
                                                    x-on:input="next(3, $event)"
                                                    x-on:keydown.backspace="prev(3, $event)">
                                            </div>

                                            @error('otp')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @endif

                                        <div class="login_footer form-group mb-30 ps-2">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox"
                                                        id="exampleCheckbox1" value="" />
                                                    <label class="form-check-label"
                                                        for="exampleCheckbox1"><span>Remember me</span></label>
                                                </div>
                                            </div>
                                            {{--<a class="text-muted" href="#">Resend OTP?</a>--}}
                                        </div>
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-heading btn-block fs-18 hover-up hover-brand"
                                                name="login">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('scripts')
<script>
</script>
@endpush