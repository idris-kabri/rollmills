<div class="search-style-2">
    <form action="#" class="border-1 rounded-pill overflow-hidden w-100" wire:ignore>
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
                            class="col-12 px-1 px-md-2 py-1 product_wrap mb-0 border border-top-0 border-gray shadow-none rounded-0">
                            <div class="row mx-md-2 gx-md-2 gx-1 justify-content-center align-items-center">
                                <div class="col-xl-2 col-3">
                                    <div class="product-img">
                                        <a href="{{ $shop_detail_url }}">
                                            <img src="{{ '/storage/' . $query->featured_image }}"
                                                alt="{{ '/storage/' . $query->featured_image }}" loading="lazy">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-10 col-9">
                                    <div class="product_info">
                                        <div class="product_title"><a
                                                href="{{ $shop_detail_url }}">{{ $query->name }}</a>
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
