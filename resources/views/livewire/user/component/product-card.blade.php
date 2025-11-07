<div class="col-lg-1-5 col-md-4 col-6">
    <div class="product-cart-wrap mb-30">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="shop-product-right.html">
                    <img class="default-img" src="{{ asset('storage/' . $product->featured_image) }}" alt="" />
                    @php
                        $product_images = json_decode($product->images, true);
                    @endphp
                    <img class="hover-img" src="{{ asset('storage/' . $product_images[0]) }}" alt="" />
                </a>
            </div>
            <div class="product-action-1">
                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                        class="fi-rs-heart"></i></a>
                <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                        class="fi-rs-eye"></i></a>
            </div>
            <div class="product-badges product-badges-position product-badges-mrg">
                @if ($parameter == 'hot')
                    <span class="hot">Hot</span>
                @endif
            </div>
        </div>
        <div class="product-content-wrap mt-2">
            <h2><a href="shop-product-right.html">{{ $product->name }}</a></h2>
            <div class="product-rate-cover">
                <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width: 90%"></div>
                </div>
                <span class="font-small ml-5 text-muted"> (4.0)</span>
            </div>
            <div class="product-card-bottom">
                <div class="product-price">
                    @if ($product->sale_price > 0 && now() >= $product->sale_start_date && now() <= $product->sale_end_date)
                        <span>₹{{ $product->sale_price }}</span>
                        <span class="old-price">₹{{ $product->price }}</span>
                    @elseif($product->sale_default_price > 0)
                        <span>₹{{ $product->sale_default_price }}</span>
                        <span class="old-price">₹{{ $product->price }}</span>
                    @else
                        <span>₹{{ $product->price }}</span>
                    @endif
                </div>
                @if ($get_sold == false)
                    <div class="add-cart">
                        <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                    </div>
                @endif
            </div>
            @if ($get_sold == true)
                <div class="sold mt-15 mb-15">
                    <div class="progress mb-5">
                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                    <span class="font-xs text-heading"> Sold: 90/120</span>
                </div>
                <a href="shop-cart.html" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To
                    Cart</a>
            @endif
        </div>
    </div>
</div>
