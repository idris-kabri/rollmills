<div class="search-style-2">
    <form action="#" class="border-1 rounded-pill overflow-hidden w-100 mx-auto" wire:ignore>
        <input type="text" placeholder="Search for items..."
            class="placeholder-font-family-quicksand placeholder-style w-100" wire:model.live="search" />
    </form>
    @if ($search)
        <div class="panel--search-result custom-search rounded_input custom-width">
            <div class="panel__content">
                <div class="row mx-0">
                    @foreach ($products as $query)
                        @php
                            if ($query->slug) {
                                $shop_detail_url = route('shop-detail', [
                                    'slug' => $query->slug,
                                    'id' => $query->id,
                                ]);
                            } else {
                                $shop_detail_url = route('shop-detail', ['slug' => 'no-slug', 'id' => $query->id]);
                            }
                        @endphp
                        <div
                            class="col-12 px-1 px-md-2 py-1 py-md-2 product_wrap mb-0 border border-top-0 border-gray shadow-none rounded-0">
                            <div class="row gx-md-2 gx-1 justify-content-center align-items-center">
                                <div class="col-lg-1 col-3">
                                    <div class="product-img search-result-img mx-auto">
                                        <a href="{{ $shop_detail_url }}" class="d-flex">
                                            <img src="{{ '/storage/' . $query->featured_image }}"
                                                alt="{{ '/storage/' . $query->featured_image }}" loading="lazy">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-11 col-9">
                                    <div class="product_info px-2">
                                        <div class="product_title mb-1"><a href="{{ $shop_detail_url }}"
                                                class="two-liner-text fw-500"
                                                style="line-height: 1.2em">{{ $query->name }}</a>
                                        </div>
                                        <div class="product-rate-cover" style="line-height: 1.1em">
                                            @php
                                                $reviews = \App\Models\ProductReview::where('status', 1)
                                                    ->where('product_id', $query->id)
                                                    ->get();

                                                $reviews_count = $reviews->count();
                                                $reviews_avg =
                                                    $reviews_count > 0 ? round($reviews->avg('ratings'), 1) : 0;
                                                $reviews_percentage = ($reviews_avg / 5) * 100;
                                            @endphp

                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $reviews_percentage }}%;">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted fs-12">
                                                ({{ $reviews_avg }})
                                            </span>
                                        </div>
                                        <div class="product_price d-flex">
                                            @php
                                                $priceInfo = getPrice($query->id);
                                            @endphp

                                            <span class="price">₹{{ number_format($priceInfo['price']) }}</span>

                                            @if ($priceInfo['original_price'])
                                                <del>₹{{ number_format($priceInfo['original_price']) }}</del>
                                            @endif

                                            @if ($priceInfo['discount'])
                                                <div class="on_sale">
                                                    <span>{{ $priceInfo['discount'] }}%
                                                        Off</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if (count($products) > 0)
                <div class="panel__footer py-3 px-3 text-center">
                    @if (!empty($category) && !empty($search))
                        <a href="{{ url('shop?category=' . $category . '&search=' . $search) }}">See
                            all
                            results</a>
                    @elseif(!empty($category))
                        <a href="{{ url('shop?category_id=' . $category) }}">See all
                            results</a>
                    @elseif(!empty($search))
                        <a href="{{ url('shop?search=' . $search) }}">See all
                            results</a>
                    @endif

                </div>
            @else
                <div
                    class="panel__content rounded_input custom-box-shadow py-2 px-2 row mx-0 bg-white w-100 text-center">
                    <div class="text-center">No products found.</div>
                </div>
            @endif
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Or for Livewire 2: window.livewire.hook('message.processed', () => { ... });

            // Attach the change event handler
            $('#category-search').on('change', function() {
                @this.set('category', this.value);
            });
        });
    </script>
@endpush
