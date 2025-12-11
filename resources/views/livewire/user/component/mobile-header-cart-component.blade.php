<div class="header-action-2">
    {{-- <div class="header-action-icon-2">
    </div> --}}
    <div class="header-action-icon-2">
        <a href="/wishlist">
            <img alt="Roll Mills" src="{{ asset('assets/frontend/imgs/theme/icons/icon-heart.svg') }}" />
            <span class="pro-count white">{{ Cart::instance('wishlist')->count() }}</span>
        </a>
    </div>
    <div class="header-action-icon-2" wire:poll.750ms>
        <a class="" href="/cart">
            <img alt="Nest" src="{{ asset('assets/frontend/imgs/theme/icons/icon-cart.svg') }}" />
            <span class="pro-count white">{{ Cart::instance('cart')->count() }}</span>
        </a>
        <div class="cart-dropdown-wrap cart-dropdown-hm2">
            <ul
                style="max-height: 200px; overflow: auto; scrollbar-color: var(--color-1) #fcfcfc; scrollbar-width: thin; scroll-behavior: smooth;">
                @foreach (Cart::instance('cart')->content() as $item)
                    <li>
                        <div class="shopping-cart-img">
                            <a href="shop-product-right.html"><img alt="{{ $item->model->seo_meta }}"
                                    src="{{ asset('storage/' . $item->model->featured_image) }}" /></a>
                        </div>
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
                        <div class="shopping-cart-title">
                            <h4><a href="{{ $shop_detail_url }}">{{ Str::limit($item->model->name, 20) }}</a>
                            </h4>
                            <h3><span>{{ $item->qty }} × </span>₹{{ number_format($item->price) }}</h3>
                        </div>
                        <div class="shopping-cart-delete">
                            {{-- <a href="#" wire:click.prevent="removeFromCart('{{ $item->rowId }}')"><i class="fi-rs-cross-small"></i></a> --}}
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="shopping-cart-footer">
                <div class="shopping-cart-total">
                    <h4>Total <span>₹{{ Cart::instance('cart')->total() }}</span></h4>
                </div>
                <div class="shopping-cart-button">
                    <a href="/cart">View cart</a>
                </div>
            </div>
        </div>
    </div>
</div>
