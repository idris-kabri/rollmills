<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop <span></span> Fillter
            </div>
        </div>
    </div>
    <div class="container mb-30 mt-50">
        <div class="row">
            <div class="col-xl-11 col-lg-12 m-auto">
                <div class="content mb-50">
                    <h1 class="title style-3 mb-20 text-center">Your Wishlist</h1>
                    <h6 class="text-body text-center">There are <span
                            class="text-brand">{{ Cart::instance('wishlist')->count() }}</span> products in this list
                    </h6>
                </div>
                {{-- <div class="mb-50">
                    <h1 class="heading-2 mb-10">Your Wishlist</h1>
                    <h6 class="text-body">There are <span class="text-brand">5</span> products in this list</h6>
                </div> --}}
                <div class="table-responsive shopping-summery table-responsive-custom">
                    <table class="table table-wishlist">
                        <thead>
                            <tr class="main-heading">
                                <th scope="col" colspan="2" class="ps-3">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                                <th scope="col" class="end">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::instance('wishlist')->content() as $item)
                                @php
                                    if ($item->model->slug) {
                                        $shop_detail_url = route('shop-detail', [
                                            'slug' => $item->model->slug,
                                            'id' => $item->model->id,
                                        ]);
                                    } else {
                                        $shop_detail_url = route('shop-detail', [
                                            'slug' => 'no-slug',
                                            'id' => $item->model->id,
                                        ]);
                                    }
                                @endphp
                                <tr class="pt-30">
                                    <td class="image product-thumbnail pt-40 position-relative ps-3">
                                        <img src="{{ asset('storage/' . $item->model->featured_image) }}"
                                            alt="#" />
                                        <div class="display-visible-480 d-none">
                                            <a href="#" wire:click.prevent="removeWishlist('{{ $item->rowId }}')"
                                                wire:confirm="Are you sure you want to remove this item from your wishlist?"
                                                class="text-body fs-16 rounded-pill p-2 bg-brand d-flex align-items-center justify-content-center fit-content">
                                                <i class="fi-rs-trash text-white"></i></a>
                                        </div>
                                    </td>
                                    <td class="product-des product-name">
                                        <h6><a class="product-name mb-10"
                                                href="{{$shop_detail_url}}">{{ $item->model->name }}</a>
                                        </h6>
                                        @php
                                            $reviews = \App\Models\ProductReview::where('status', 1)
                                                ->where('product_id', $item->model->id)
                                                ->get();

                                            $reviews_count = $reviews->count();
                                            $reviews_avg = $reviews_count > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                            $reviews_percentage = ($reviews_avg / 5) * 100;
                                        @endphp
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $reviews_percentage }}%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{ $reviews_count }})</span>
                                        </div>
                                    </td>
                                    <td class="price small-screen-table-td" data-title="Price">
                                        @if ($item->model->sale_price > 0 && now() >= $item->model->sale_start_date && now() <= $item->model->sale_end_date)
                                            <h3 class="text-brand small-screen-table-td-content">
                                                ₹{{ $item->model->sale_price }}</h3>
                                            <del class="old-price">₹{{ $item->model->price }}</del>
                                        @elseif($item->model->sale_default_price > 0)
                                            <h3 class="text-brand small-screen-table-td-content">
                                                ₹{{ $item->model->sale_default_price }}</h3>
                                            <del class="old-price">₹{{ $item->model->price }}</del>
                                        @else
                                            <h3 class="text-brand small-screen-table-td-content">
                                                ₹{{ $item->model->price }}</h3>
                                        @endif
                                    </td>
                                    <td class="small-screen-table-td before-remove" data-title="">
                                        <button class="btn btn-sm custom-btn-table-responsive"
                                            wire:click="addToCart('{{ $item->rowId }}')"
                                            wire:confirm="Are you sure you want to add this item to your cart?">Add to
                                            cart</button>
                                    </td>
                                    <td class="action text-center small-screen-table-td remove-btn" data-title="Remove">
                                        <a href="#" wire:click.prevent="removeWishlist('{{ $item->rowId }}')"
                                            wire:confirm="Are you sure you want to remove this item from your wishlist?"
                                            class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
