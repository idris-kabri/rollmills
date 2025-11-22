<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Checkout
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Checkout</h1>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are <span
                            class="text-brand">{{ Cart::instance('cart')->count() }}</span> products in your cart</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <h4 class="mb-30">Billing Details</h4>
                    <form method="post">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" required="" name="name" placeholder="Name *" wire:model="billing_address.name">
                            </div>
                            <div class="form-group col-lg-6">
                                <input required="" type="text" name="email" placeholder="Email address *" wire:model="billing_address.email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" name="billing_address" required="" placeholder="Address *" wire:model="billing_address.address_line_1">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="billing_address2" required=""
                                    placeholder="Address line2" wire:model="billing_address.address_line_2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" disabled name="zipcode" placeholder="Postcode / ZIP *" wire:model="billing_address.zipcode">
                            </div>
                            <div class="form-group col-lg-6">
                                <input required="" type="text" name="phone" placeholder="Phone *" wire:model="billing_address.phone">
                            </div>
                        </div>
                        <div class="form-group mb-30">
                            <textarea rows="5" placeholder="Additional information" wire:model="billing_address.additional_info"></textarea>
                        </div>
                        <div class="ship_detail">
                            <div class="form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="differentaddress" wire:change="ship_to_different_address_function()">
                                        <label class="form-check-label label_info" data-bs-toggle="collapse"
                                            data-target="#collapseAddress" href="#collapseAddress"
                                            aria-controls="collapseAddress" for="differentaddress"><span>Ship to a
                                                different address?</span></label>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseAddress" class="different_address collapse in">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <input type="text" required="" name="name"
                                            placeholder="Name *" wire:model="shipping_address.name">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="text" name="billing_address" required=""
                                            placeholder="Address *" wire:model="shipping_address.address_line_1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <input type="text" name="billing_address2" required=""
                                            placeholder="Address line2" wire:model="shipping_address.address_line_2">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input required="" type="text" name="state"
                                            placeholder="State *" wire:model="shipping_address.state">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <input required="" type="text" name="city"
                                            placeholder="City / Town *" wire:model="shipping_address.city">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input required="" type="text" name="zipcode"
                                            placeholder="Postcode / ZIP *" wire:model="shipping_address.zipcode">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="border p-40 cart-totals ml-30 mb-50">
                    <div class="d-flex align-items-end justify-content-between mb-30">
                        <h4>Your Order</h4>
                        <h6 class="text-muted">Subtotal</h6>
                    </div>
                    <div class="divider-2 mb-30"></div>
                    <div class="table-responsive order_table checkout">
                        <table class="table no-border">
                            <tbody>
                                @foreach (Cart::instance('cart')->content() as $item)
                                    <tr>
                                        <td class="image product-thumbnail"><img
                                                src="{{ asset('storage/' . $item->model->featured_image) }}"
                                                alt="#"></td>
                                        <td>
                                            <h6 class="w-160 mb-5"><a href="shop-product-full.html"
                                                    class="text-heading">{{ $item->model->name }}</a></h6></span>
                                            @php
                                                $reviews = \App\Models\ProductReview::where('status', 1)
                                                    ->where('product_id', $item->model->id)
                                                    ->get();

                                                $reviews_count = $reviews->count();
                                                $reviews_avg =
                                                    $reviews_count > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                                $reviews_percentage = ($reviews_avg / 5) * 100;
                                            @endphp
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: {{ $reviews_percentage }}%">
                                                    </div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> ({{ $reviews_avg }})</span>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="text-muted pl-20 pr-20">x {{ $item->qty }}</h6>
                                        </td>
                                        <td>
                                            <h4 class="text-brand">₹{{ number_format($item->price * $item->qty) }}</h4>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="payment ml-30">
                    <h4 class="mb-30">Payment</h4>
                    <div class="payment_option">
                        <div class="custome-radio">
                            <input class="form-check-input" required="" type="radio" name="payment_option"
                                id="exampleRadios3" checked="">
                            <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse"
                                data-target="#bankTranfer" aria-controls="bankTranfer">Direct Bank Transfer</label>
                        </div>
                        <div class="custome-radio">
                            <input class="form-check-input" required="" type="radio" name="payment_option"
                                id="exampleRadios4" checked="">
                            <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse"
                                data-target="#checkPayment" aria-controls="checkPayment">Cash on delivery</label>
                        </div>
                        <div class="custome-radio">
                            <input class="form-check-input" required="" type="radio" name="payment_option"
                                id="exampleRadios5" checked="">
                            <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse"
                                data-target="#paypal" aria-controls="paypal">Online Getway</label>
                        </div>
                    </div>
                    <div class="payment-logo d-flex">
                        <img class="mr-15" src="{{ asset('assets/frontend/imgs/theme/icons/payment-paypal.svg') }}"
                            alt="">
                        <img class="mr-15" src="{{ asset('assets/frontend/imgs/theme/icons/payment-visa.svg') }}"
                            alt="">
                        <img class="mr-15" src="{{ asset('assets/frontend/imgs/theme/icons/payment-master.svg') }}"
                            alt="">
                        <img src="{{ asset('assets/frontend/imgs/theme/icons/payment-zapper.svg') }}" alt="">
                    </div>
                    <a href="#" class="btn btn-fill-out btn-block mt-30">Place an Order<i
                            class="fi-rs-sign-out ml-15"></i></a>
                </div>
            </div>
        </div>
    </div>
</main>
