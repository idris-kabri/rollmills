<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> My Account
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
                                        @csrf
                                        <div class="form-group mb-20">
                                            <label for="" class="ps-2 fw-600 quicksand fs-16 mb-2"> Enter Mobile
                                                Number</label>
                                            <input type="text" required="" wire:model="email"
                                                placeholder="Enter Number" class="login-input" />
                                        </div>
                                        <div class="form-group mb-20">
                                            <label for="" class="ps-2 fw-600 quicksand fs-16 mb-2"> Enter Mobile
                                                Number</label>
                                            <input type="text" required="" wire:model="password"
                                                placeholder="Enter Number" class="login-input" />
                                        </div>
                                        <div class="form-group mb-20">
                                            <label for="" class="ps-2 fw-600 quicksand fs-16 mb-2"> Enter
                                                OTP</label>
                                            <div class="d-flex justify-content-between"> 
                                                <input required="" type="password"
                                                    wire:model="password" placeholder="1"
                                                    class="login-input text-center" style="width: 24%" />
                                                <input required="" type="password" wire:model="password"
                                                    placeholder="2" class="login-input text-center" style="width: 24%" />
                                                <input required="" type="password" wire:model="password"
                                                    placeholder="3" class="login-input text-center" style="width: 24%" />
                                                <input required="" type="password" wire:model="password"
                                                    placeholder="4" class="login-input text-center" style="width: 24%" />
                                            </div>

                                        </div>
                                        <div class="login_footer form-group mb-30 ps-2">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox"
                                                        id="exampleCheckbox1" value="" />
                                                    <label class="form-check-label"
                                                        for="exampleCheckbox1"><span>Remember me</span></label>
                                                </div>
                                            </div>
                                            <a class="text-muted" href="#">Resend OTP?</a>
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
