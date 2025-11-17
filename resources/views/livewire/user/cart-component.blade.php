<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Cart
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-12 mb-40">
                <div class="content mb-10">
                    <h1 class="title style-3 mb-20 text-center">Your Cart</h1>
                    <h6 class="text-body text-center">There are <span class="text-brand">{{ Cart::instance('cart')->count() }}</span> products in your cart
                    </h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-9">
                <div class="table-responsive shopping-summery table-responsive-custom">
                    <table class="table table-wishlist mb-0">
                        <thead>
                            <tr class="main-heading">
                                <th scope="col" colspan="2" class="ps-2">Product</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col" class="end">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::instance('cart')->content() as $item)
                                <tr class="pt-3">
                                    <td class="image product-thumbnail pt-40 position-relative ps-2"><img
                                            src="{{ asset('storage/' . $item->model->featured_image) }}" alt="{{ $item->model->seo_meta }}">
                                        <div class="display-visible-480 d-none">
                                            <a href="#"
                                                class="text-body fs-16 rounded-pill p-2 bg-brand d-flex align-items-center justify-content-center fit-content">
                                                <i class="fi-rs-trash text-white"></i></a>
                                        </div>
                                    </td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading"
                                                href="/shop-detail">{{ $item->model->name }} {{$item->id}}</a>
                                        </h6>
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
                                    <td class="price small-screen-table-td me-3" data-title="Price">
                                        <h4 class="text-body small-screen-table-td-content">₹{{ number_format($item->price) }}</h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15 display-hide-480">
                                            <div class="detail-qty border radius">
                                                <a href="#" wire:click.prevent="decrementQuantity('{{ $item->rowId }}')" class="qty-down"><i
                                                        class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">{{$item->qty}}</span>
                                                <a href="#" wire:click.prevent="incrementQuantity('{{ $item->rowId }}')" class="qty-up"><i
                                                        class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                        </div>
                                        <div class="quantity d-none">
                                            <button type="button" class="minus" wire:click.prevent="decrementQuantity('{{ $item->rowId }}')">-</button>
                                            <input type="number" min="1" value="{{ $item->qty }}" class="qty"
                                            size="4" title="Qty" wire:change="updateQuantity('{{ $item->rowId }}')" wire:model.lazy="quantities.{{ $item->rowId }}">
                                            <button type="button" class="plus" wire:click.prevent="incrementQuantity('{{ $item->rowId }}')">+</button>
                                        </div>
                                    </td>
                                    <td class="price small-screen-table-td" data-title="Total Price">
                                        <h4 class="text-brand small-screen-table-td-content">₹{{ number_format($item->price * $item->qty) }}</h4>
                                    </td>
                                    <td class="action text-center small-screen-table-td remove-btn" data-title="Remove">
                                        <a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="divider-2 mb-30"></div> --}}
                <div class="cart-action d-flex justify-content-between mt-3 mb-40 mb-xl-0">
                    <a href="/shop" class="btn d-flex align-items-center custom-pad"><i class="fi-rs-arrow-left mr-10"></i>Continue
                        Shopping</a>
                </div>
            </div>
            <div class="col-xl-3">

                <div class="calculate-shiping p-20 border-radius-15 border mb-20">
                    <h4 class="mb-10 underline pb-2">Calculate Shipping</h4>
                    {{-- <p class="mb-30"><span class="font-lg text-muted">Flat rate:</span><strong
                            class="text-brand">5%</strong></p> --}}
                    <form class="field_form shipping_calculator mt-30">
                        <div class="form-row row">
                            <div class="form-group col-lg-12">
                                <input required="required" placeholder="PostCode / ZIP" name="name"
                                    type="text" class="pl-15">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-20 border-radius-15 border mb-20">
                    <h4 class="mb-30 pb-2 underline">Apply Coupon</h4>
                    <form action="#">
                        <div class="d-flex justify-content-between mb-4">
                            <input class="font-medium pl-15 mr-15 coupon" name="Coupon" placeholder="Enter Code">
                            <button class="btn d-flex justify-content-center align-items-center"><i
                                    class="fi-rs-label mr-10"></i>Apply</button>
                        </div>
                        <div class="coupon-card-cart" onclick="toggleCoupon(this)">
                            <div class="coupon-header">
                                <div class="coupon-code-section">
                                    <div class="coupon-code-cart">SAVE20</div>
                                    {{-- <div class="discount-badge">20% OFF</div> --}}
                                </div>
                                <div class="check-circle">
                                    <svg fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="coupon-description">
                                Get 20% instant discount on your first order. Valid on all products.
                            </div>
                            <div class="coupon-footer">
                                <div class="discount-badge">20% OFF</div>
                                <div class="min-order">Valid till: Nov 30, 2025</div>
                            </div>
                        </div>
                        <div class="coupon-card-cart selected" onclick="toggleCoupon(this)">
                            <div class="coupon-header">
                                <div class="coupon-code-section">
                                    <div class="coupon-code-cart">FRESH50</div>
                                    {{-- <div class="discount-badge">$5 OFF</div> --}}
                                </div>
                                <div class="check-circle">
                                    <svg fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="coupon-description">
                                Save $5 on fresh organic products. Perfect for your healthy lifestyle!
                            </div>
                            <div class="coupon-footer">
                                <div class="discount-badge">50% OFF</div>
                                <div class="min-order">Valid till: Nov 30, 2025</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="border p-20 cart-totals">
                    <h4 class="mb-30 pb-2 underline">Details</h4>
                    <div class="table-responsive">
                        <table class="table no-border">
                            <tbody>
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end fs-16">₹{{ Cart::instance('cart')->subtotal() }}</h4>
                                    </td>
                                </tr>
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Shipping</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end fs-16">Free</h4>
                                    </td>
                                </tr>
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Estimate for</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end fs-16">United Kingdom</h4>
                                    </td>
                                </tr>
                                <tr class="d-flex justify-content-between border-0">
                                    <td class="cart_total_label text-start">
                                        <h6 class="text-muted">Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end fs-16">₹{{ Cart::instance('cart')->total() }}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="#" class="btn mb-20 w-100 d-flex justify-content-center align-items-center">Proceed
                        To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
    <script>
        function toggleCoupon(card) {
            document.querySelectorAll('.coupon-card-cart').forEach(c => {
                if (c !== card) {
                    c.classList.remove('selected');
                }
            });
            card.classList.toggle('selected');
        }
    </script>
@endpush
