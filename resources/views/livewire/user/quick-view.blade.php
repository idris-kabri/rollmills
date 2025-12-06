<div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel"
    aria-hidden="true" wire:ignore.self>
    <style>
        .custom-modal .modal-dialog {
            max-width: 60% !important;
        }

        .main-image {
            max-width: 80%;
            height: auto;
            object-fit: contain;
        }

        .custom-mar {
            margin: 8px !important;
        }

        .detail-extralink {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 15px;
        }

        .active-ietm {
            color: #fff !important;
            background-color: #dca915 !important;
            border-color: #dca915 !important;
        }

        @media (max-width: 991px) {
            .custom-modal .modal-dialog {
                max-width: 95% !important;
                margin: 0.5rem auto;
            }

            .modal-body {
                padding: 15px !important;
                overflow-y: auto;
            }

            .product-image-slider {
                margin-bottom: 5px !important;
            }

            .main-image {
                max-height: 180px;
                width: auto;
            }

            .detail-info {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .title-detail {
                font-size: 16px;
                margin-bottom: 5px;
            }

            .product-price-cover {
                margin-bottom: 8px;
            }

            .detail-extralink {
                margin-bottom: 12px !important;
                gap: 8px !important;
                flex-wrap: nowrap !important;
            }

            .detail-qty {
                padding: 4px 10px !important;
                max-width: 70px !important;
                margin-right: 0 !important;
            }

            .detail-qty .qty-val {
                line-height: 1;
            }

            .button-add-to-cart {
                padding: 5px 15px !important;
                height: 36px !important;
                font-size: 12px !important;
                line-height: 1.2 !important;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                white-space: nowrap;
            }

            .button-add-to-cart i {
                margin-right: 5px;
            }

            .product-extra-link2 {
                flex-grow: 1;
            }

            .product-delivery-icons div {
                display: flex;
                align-items: center;
                gap: 5px;
                margin-bottom: 4px;
            }

            .product-delivery-icons img {
                width: 16px !important;
                height: auto;
            }

            .product-delivery-icons p {
                font-size: 10px !important;
                margin: 0 !important;
                line-height: 1.1;
            }

            .row.pt-3 {
                padding-top: 0.5rem !important;
            }

            .thumbnail-item {
                width: 40px;
                height: 40px;
            }
        }
    </style>

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        @if ($mainProduct)
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="$dispatch('closeQuickView')"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-3">
                            <div class="detail-gallery">

                                <div class="product-image-slider mb-3 text-center">
                                    <img id="main-quickview-image"
                                        src="{{ $main_image ? Storage::url($main_image) : Storage::url($mainProduct->featured_image) }}"
                                        alt="{{ $mainProduct->seo_meta }}"
                                        class="img-fluid rounded border main-image" />
                                </div>

                                <div class="thumbnail-gallery d-flex gap-2 flex-wrap justify-content-center">
                                    {{-- Featured Image --}}
                                    <a class="thumbnail-item {{ $main_image == $mainProduct->featured_image || !$main_image ? 'active-thumb' : '' }}"
                                        wire:click="changeMainImage('{{ $mainProduct->featured_image }}')"
                                        wire:mouseover="changeMainImage('{{ $mainProduct->featured_image }}')">
                                        <img src="{{ Storage::url($mainProduct->featured_image) }}"
                                            class="thumbnail-img" alt="Featured">
                                    </a>

                                    {{-- Gallery Images --}}
                                    @php
                                        $gallery_images = json_decode($mainProduct->images, true) ?? [];
                                    @endphp

                                    @foreach ($gallery_images as $image)
                                        <a class="thumbnail-item {{ $main_image == $image ? 'active-thumb' : '' }}"
                                            wire:click="changeMainImage('{{ $image }}')"
                                            wire:mouseover="changeMainImage('{{ $image }}')">
                                            <img src="{{ Storage::url($image) }}" class="thumbnail-img"
                                                alt="Gallery Image">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                @php
                                    $original_price = $mainProduct->price;
                                    $sale_price = 0;
                                    $check_type = '';

                                    $currentDate = now();
                                    $sale_from_date = $mainProduct->sale_start_date
                                        ? \Carbon\Carbon::parse($mainProduct->sale_start_date)
                                        : null;
                                    $sale_to_date = $mainProduct->sale_end_date
                                        ? \Carbon\Carbon::parse($mainProduct->sale_end_date)
                                        : null;

                                    if (
                                        $mainProduct->sale_price > 0 &&
                                        $sale_from_date &&
                                        $sale_to_date &&
                                        $currentDate->between($sale_from_date, $sale_to_date)
                                    ) {
                                        $sale_price = $mainProduct->sale_price;
                                        $check_type = 'sale_product';
                                    } elseif ($mainProduct->sale_default_price > 0) {
                                        $sale_price = $mainProduct->sale_default_price;
                                        $check_type = 'sale_default_product';
                                    } elseif ($mainProduct->is_featured == 1) {
                                        $check_type = 'featured_product';
                                    }

                                    $percentage =
                                        $original_price > 0
                                            ? (($original_price - $sale_price) / $original_price) * 100
                                            : 0;
                                @endphp

                                @if ($check_type == 'sale_product')
                                    <span class="stock-status out-stock">Save {{ number_format($percentage) }}%</span>
                                @elseif ($check_type == 'sale_default_product')
                                    <span class="stock-status out-stock">Save {{ number_format($percentage) }}%</span>
                                @elseif ($check_type == 'featured_product')
                                    <span class="stock-status hot">Hot</span>
                                @endif

                                <h5 class="title-detail"><a href="shop-product-right.html"
                                        class="text-heading">{{ $mainProduct->name }}</a></h5>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating"
                                                style="width: {{ $mainProduct_reviews_percentage }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> ({{ $mainProduct_reviews_count }}
                                            reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left custom-mar">
                                        @php
                                            $original_price = $mainProduct->price;
                                            $sale_price = null;
                                            $discount_percentage = 0;

                                            $currentDate = now();
                                            if (
                                                $mainProduct->sale_price > 0 &&
                                                $mainProduct->sale_start_date &&
                                                $mainProduct->sale_end_date &&
                                                $currentDate >= $mainProduct->sale_start_date &&
                                                $currentDate <= $mainProduct->sale_end_date
                                            ) {
                                                $sale_price = $mainProduct->sale_price;
                                            } elseif ($mainProduct->sale_default_price > 0) {
                                                $sale_price = $mainProduct->sale_default_price;
                                            }

                                            if ($sale_price) {
                                                $discount_percentage =
                                                    $original_price > 0
                                                        ? round(
                                                            (($original_price - $sale_price) / $original_price) * 100,
                                                        )
                                                        : 0;
                                            }
                                        @endphp

                                        <span class="current-price text-brand" style="font-size: 24px">
                                            ₹{{ $sale_price ?? $original_price }}
                                        </span>

                                        @if ($sale_price)
                                            <span>
                                                <span class="save-price font-md color3 ml-15" style="font-size: 16px">
                                                    {{ $discount_percentage }}% Off
                                                </span>

                                                <span class="old-price font-md ml-15" style="font-size: 16px">
                                                    <del>₹{{ $original_price }}</del>
                                                </span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @foreach ($groupedAttributes as $key => $attributes)
                                    <div class="attr-detail attr-size mb-16" wire:ignore>
                                        <strong class="mr-10">{{ $attributes['name'] }}: </strong>
                                        <ul class="list-filter size-filter font-small">
                                            @foreach ($attributes['items'] as $item)
                                                <li class="{{ $selectedAttribute[$key] == $item ? 'active-ietm' : '' }} mb-2"
                                                    style="border: 1px solid #dca915; border-radius: 5px;">
                                                    <a href="#" class="quicksand"
                                                        wire:click.prevent="handleAttributeClick({{ $key }}, '{{ $item }}')">{{ $item }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach

                                <div class="detail-extralink mb-24">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down" wire:click.prevent="decrementQuantity()"><i
                                                class="fi-rs-angle-small-down"></i></a>
                                        <span class="qty-val">{{ $quantity }}</span>
                                        <a href="#" class="qty-up" wire:click.prevent="incrementQuantity()"><i
                                                class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"
                                            wire:click="addToCart()"><i class="fi-rs-shopping-cart"></i>Add to
                                            cart</button>
                                    </div>
                                </div>

                                <div class="row pt-md-2 pt-3">
                                    <div class="col-6">
                                        <div class="product-delivery-icons">
                                            <div>
                                                <img src="{{ asset('assets/frontend/imgs/theme/home-delivery.png') }}"
                                                    alt="">
                                                <p>Home Delivery</p>
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/frontend/imgs/theme/top-brands.png') }}"
                                                    alt="">
                                                <p>Top Brands</p>
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/frontend/imgs/theme/secure-transaction.png') }}"
                                                    alt="">
                                                <p>Secure Transaction</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="product-delivery-icons">
                                            <div>
                                                <img src="{{ asset('assets/frontend/imgs/theme/genuine-product.png') }}"
                                                    alt="">
                                                <p>High Quality</p>
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/frontend/imgs/theme/replacement.png') }}"
                                                    alt="">
                                                @if ($mainProduct->product_return_days > 0)
                                                    <p>{{ $mainProduct->product_return_days }} Day Return</p>
                                                @elseif($mainProduct->product_replacement_days > 0)
                                                    <p>{{ $mainProduct->product_replacement_days }} Day Replacement</p>
                                                @else
                                                    <p>No Return Policy</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        @endif
    </div>
</div>
</div>
</div>
