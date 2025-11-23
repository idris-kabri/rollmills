<div class="header-action-right ms-4">
    <div class="header-action-2">
        <div class="header-action-icon-2" wire:poll.750ms>
            <a href="/wishlist">
                <img class="svgInject" alt="Roll Mills"
                    src="{{ asset('assets/frontend/imgs/theme/icons/icon-heart.svg') }}" />
                <span class="pro-count blue">{{ Cart::instance('wishlist')->count() }}</span>
            </a>
            <a href="/wishlist"><span class="lable">Wishlist</span></a>
        </div>
        <div class="header-action-icon-2" wire:poll.750ms>
            <a class="cart-img" href="/cart">
                <img alt="Nest" src="{{ asset('assets/frontend/imgs/theme/icons/icon-cart.svg') }}" />
                <span class="pro-count blue">{{ Cart::instance('cart')->count() }}</span>
            </a>
            <a href="/cart"><span class="lable">Cart</span></a>
            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                <ul wire:poll.750ms>
                    @foreach (Cart::instance('cart')->content() as $item)
                        <li>
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
                            <div class="shopping-cart-img">
                                <a href="{{ $shop_detail_url }}"><img alt="{{ $item->model->seo_meta }}"
                                        src="{{ asset('storage/' . $item->model->featured_image) }}" /></a>
                            </div>
                            <div class="shopping-cart-title">
                                <h4><a href="{{ $shop_detail_url }}">{{ Str::words($item->model->name, 2, ' ...') }}</a></h4>
                                <h4 class="fs-14 text-secondary fw-500"><span>{{ $item->qty }} ×
                                        ₹{{ number_format($item->price) }}</span>
                                </h4>
                            </div>
                            <div class="shopping-cart-delete">
                                <a href="#" wire:click.prevent="removeFromCart('{{ $item->rowId }}')"><i class="fi-rs-cross-small"></i></a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="shopping-cart-footer">
                    <div class="shopping-cart-total">
                        <h4>Total <span>₹{{ Cart::instance('cart')->total() }}</span></h4>
                    </div>
                    <div class="shopping-cart-button">
                        <a href="/cart" class="outline">View cart</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-action-icon-2">
            <a href="{{ auth()->check() ? '/my-account' : '/' }}">
                <img class="svgInject" alt="Nest"
                    src="{{ asset('assets/frontend/imgs/theme/icons/icon-user.svg') }}" />
            </a>
            <a href="/my-account"><span class="lable">Account</span></a>
        </div>
    </div>
</div>
