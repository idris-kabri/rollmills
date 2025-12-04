<div class="product-cart-wrap mb-30">
    <div class="product-img-action-wrap">
        <div class="product-img product-img-zoom">
            @php
                if ($product->slug) {
                    $shop_detail_url = route('shop-detail', ['slug' => $product->slug, 'id' => $product->id]);
                } else {
                    $shop_detail_url = route('shop-detail', ['slug' => 'no-slug', 'id' => $product->id]);
                }
            @endphp

            <a href="{{ $shop_detail_url }}">
                <img class="default-img" src="{{ asset('storage/' . $product->featured_image) }}"
                    alt="{{ $product->seo_meta }}" />
                @php
                    $product_images = json_decode($product->images, true);
                @endphp
                <img class="hover-img" src="{{ asset('storage/' . $product_images[0]) }}" alt="{{ $product->seo_meta }}" />
            </a>
        </div>
        <div class="product-action-1">
            @if (!isInWishlist($product->id))
                <a aria-label="Add To Wishlist" class="action-btn" href="#"
                    wire:click.prevent="addToWhishlist({{ $product->id }})"><i class="fi-rs-heart"></i></a>
            @else
                <a aria-label="Add To Wishlist" class="action-btn bg-brand" href="javascript:void(0);"><i
                        class="fi-rs-heart text-danger text-white"></i></a>
            @endif
             <a aria-label="Quick view"
   class="action-btn quick-view"
   wire:click="addPreviewProduct({{ $product->id }})">
    <i class="fi-rs-eye"></i>
</a>

            <a class="d-none" data-bs-toggle="modal" data-bs-target="#quickViewModal"></a> 
        </div>
        <div class="product-badges product-badges-position product-badges-mrg">
            @if ($parameter)
                @if ($parameter == 'sale')
                    @php
                        $original_price = $product->price;
                        $sale_price = 0;
                        $currentDate = \Carbon\Carbon::now();
                        $sale_from_date = \Carbon\Carbon::parse($product->sale_from_date);
                        $sale_to_date = \Carbon\Carbon::parse($product->sale_to_date);

                        if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
                            $sale_price = $product->sale_price;
                        } else {
                            $sale_price = $product->sale_default_price;
                        }
                        $percentage =
                            $original_price > 0 ? (($original_price - $sale_price) / $original_price) * 100 : 0;
                    @endphp
                    <span class="product-cart-componet-badge save">Save {{ number_format($percentage) }}%</span>
                @elseif ($parameter == 'hot')
                    <span class="product-cart-componet-badge hot">Hot</span>
                @endif
            @else
                @php
                    $original_price = $product->price;
                    $sale_price = 0;
                    $check_type = '';

                    $currentDate = \Carbon\Carbon::now();
                    $sale_from_date = \Carbon\Carbon::parse($product->sale_from_date);
                    $sale_to_date = \Carbon\Carbon::parse($product->sale_to_date);

                    if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
                        $sale_price = $product->sale_price;
                        $check_type = 'sale_product';
                    } elseif ($product->sale_default_price > 0) {
                        $sale_price = $product->sale_default_price;
                        $check_type = 'sale_default_product';
                    } elseif ($product->is_featured == 1 && $check_type == '') {
                        $check_type = 'featured_product';
                    }
                    $percentage = $original_price > 0 ? (($original_price - $sale_price) / $original_price) * 100 : 0;
                @endphp

                @if ($check_type == 'sale_product')
                    <span class="product-cart-componet-badge save">Save {{ number_format($percentage) }}%</span>
                @elseif($check_type == 'featured_product')
                    <span class="product-cart-componet-badge hot">Hot</span>
                @else
                    <span class="product-cart-componet-badge save">Save {{ number_format($percentage) }}%</span>
                @endif
            @endif
        </div>
    </div>
    <div class="product-content-wrap mt-2">
        <h2><a href="{{ $shop_detail_url }}">{{ $product->name }}</a></h2>
        <div class="product-rate-cover">
            @php
                $reviews = \App\Models\ProductReview::where('status', 1)->where('product_id', $product->id)->get();

                $reviews_count = $reviews->count();
                $reviews_avg = $reviews_count > 0 ? round($reviews->avg('ratings'), 1) : 0;
                $reviews_percentage = ($reviews_avg / 5) * 100;
            @endphp

            <div class="product-rate d-inline-block">
                <div class="product-rating" style="width: {{ $reviews_percentage }}%;"></div>
            </div>
            <span class="font-small ml-5 text-muted">
                ({{ $reviews_avg }})
            </span>
        </div>

        <div class="product-card-bottom">
            <div class="product-price">
                @if ($product->sale_price > 0 && now() >= $product->sale_start_date && now() <= $product->sale_end_date)
                    <span class="price-transition">₹{{ $product->sale_price }}</span>
                    <span class="old-price">₹{{ $product->price }}</span>
                @elseif($product->sale_default_price > 0)
                    <span class="price-transition">₹{{ $product->sale_default_price }}</span>
                    <span class="old-price">₹{{ $product->price }}</span>
                @else
                    <span class="price-transition">₹{{ $product->price }}</span>
                @endif
            </div>
            @if ($get_sold == false)
                @if (!isInCart($product->id))
                    @if (count($product->getVarietion) > 0)
                        <div class="add-cart">
                            <a href="{{ $shop_detail_url }}" class="add" style="white-space: nowrap;">
                                See Options
                            </a>

                        </div>
                    @else
                        <div class="add-cart">
                            <a href="#" wire:click.prevent="addToCart({{ $product->id }})" class="add"><i
                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                        </div>
                    @endif
                @else
                    <div class="add-cart">
                        <a href="javascript:void(0);" class="add"><i class="fi-rs-shopping-cart mr-5"></i>Added
                        </a>
                    </div>
                @endif
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
            @if (!isInCart($product->id))
                <a href="#" wire:click.prevent="addToCart({{ $product->id }})" class="btn w-100 hover-up"><i
                        class="fi-rs-shopping-cart mr-5"></i>Add To
                    Cart</a>
            @else
                <a href="javascript:void(0);" class="btn w-100 hover-up"><i
                        class="fi-rs-shopping-cart mr-5"></i>Added</a>
            @endif
        @endif
    </div>
</div>
