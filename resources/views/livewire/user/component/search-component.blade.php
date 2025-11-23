<div class="search-style-2">
    <form action="#" class="border-1 rounded-pill overflow-hidden" wire:ignore>
        <select class="select-active" id="category-search">
            <option value="">All Categories</option>
            @foreach ($categories as $product_category)
                <option value="{{ $product_category->id }}">
                    {{ $product_category->name }}</option>

                @php
                    $sub_categories = App\Models\ProductCategory::where('parent_id', $product_category->id)->get();
                @endphp

                @foreach ($sub_categories as $sub_category)
                    <option value="{{ $sub_category->id }}">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_category->name }}
                    </option>
                @endforeach
            @endforeach
        </select>
        <input type="text" placeholder="Search for items..."
            class="placeholder-font-family-quicksand placeholder-style" wire:model.live="search" />
    </form>
    @if ($search)
        <div class="panel--search-result custom-search rounded_input custom-width">
            <div class="panel__content">
                <div class="row mx-0">
                    @foreach ($products as $query)
                        <div
                            class="col-12 px-1 px-md-2 py-1 product_wrap mb-0 border border-top-0 border-gray shadow-none rounded-0">
                            <div class="row mx-md-2 gx-md-2 gx-1 justify-content-center align-items-center">
                                <div class="col-xl-2 col-3">
                                    <div class="product-img">
                                        <a href="">
                                            <img src="{{ '/storage/' . $query->featured_image }}"
                                                alt="{{ '/storage/' . $query->featured_image }}" loading="lazy">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-10 col-9">
                                    <div class="product_info">
                                        <div class="product_title"><a href="#">{{ $query->name }}</a>
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
