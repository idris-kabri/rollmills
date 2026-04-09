<div>
    <div class="livewire-tracking-wrapper">

        {{-- TOP CENTER: DYNAMIC COD TO PREPAID OFFER BOX --}}
        @if ($order->is_cod == 1 && $order->status == 1)
            @php
                $conversion_discount = 0;
                foreach ($order->getOrderItems as $item) {
                    $conversion_discount += ($item->total * fetchDiscountPercentage()) / 100;
                }
                $new_payable = ceil($order->total - $conversion_discount - $order->cod_charges);
                $total_savings = ceil($conversion_discount + $order->cod_charges);
            @endphp

            <div class="cod-promo-banner">
                <div class="cod-promo-content">
                    <h3>🎉 Convert & Save!</h3>
                    <p>
                        Pay via UPI/Credit Card now to get an extra <strong>{{ fetchDiscountPercentage() }}%
                            off</strong>, waive the
                        <strong>₹{{ number_format($order->cod_charges) }} COD fee</strong>, and unlock <span
                            class="express-badge">⚡ Express Delivery</span>
                    </p>
                </div>
                <div class="cod-promo-action">
                    <div style="margin-bottom: 12px;">
                        <span class="payable-text">Payable Now:</span>
                        <span class="payable-amount">₹{{ number_format($new_payable) }}</span>
                    </div>
                    <button wire:click="payNow" class="related-add-btn btn-filled"
                        style="padding: 12px 20px; font-size: 15px; margin-top: 0;" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="payNow">Pay Now & Save
                            ₹{{ number_format($total_savings) }}</span>
                        <span wire:loading wire:target="payNow">Initiating Payment...</span>
                    </button>
                </div>
            </div>
        @endif
        {{-- END COD OFFER BOX --}}

        <div class="tracking-grid">

            {{-- ALPINE TOGGLE WRAPPER: Starts hidden if Delivered --}}
            <div class="tracking-left-col" x-data="{ showTimeline: {{ $order->status == 3 ? 'false' : 'true' }} }">

                {{-- NEW DELIVERED & PREMIUM COUPON CARD --}}
                @if ($order->status == 3)
                    <div x-show="!showTimeline" x-transition.opacity>

                        {{-- Clean Success Header --}}
                        <div class="success-delivery-banner">
                            <div class="success-delivery-info">
                                <div class="success-icon">✓</div>
                                <div class="success-text">
                                    <h2>Order Successfully Delivered!</h2>
                                    <p>Thank you for shopping with us. Enjoy your items!</p>
                                </div>
                            </div>
                            <button @click="showTimeline = true" class="btn-view-journey">
                                📍 View Order Journey
                            </button>
                        </div>

                        {{-- Premium Coupon Card --}}
                        @if (isset($coupon) && $coupon)
                            <div class="premium-coupon-card">
                                <div class="coupon-gold-strip"></div>

                                <div class="premium-coupon-content">
                                    <div class="coupon-gift-icon">🎁</div>
                                    <h3 class="premium-offer-title">Roll into Savings with <span>Roll Mills!</span></h3>

                                    <p class="premium-offer-desc">
                                        Congratulations! You've unlocked a
                                        <strong>
                                            @if ($coupon->discount_type == 'Percentage')
                                                {{ $coupon->discount_value }}%
                                            @else
                                                ₹{{ $coupon->discount_value }}
                                            @endif
                                            discount
                                        </strong>
                                        on your next purchase. Keep the savings rolling!
                                    </p>

                                    {{-- Dedicated Clean Code Box --}}
                                    <div class="code-display-wrapper">
                                        <h4 id="couponCode" class="the-actual-code">{{ $coupon->coupon_code }}</h4>
                                        <button id="copyCodeBtn" class="btn-copy-code">Copy Code</button>
                                    </div>

                                    <p class="coupon-footer-msg">Use this code at checkout and let the deals roll your
                                        way!</p>

                                    <hr class="dashed-divider-light">

                                    {{-- Clean Footer Terms --}}
                                    <div class="premium-terms">
                                        <h5>Terms & Conditions</h5>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <ul>
                                                    <li>Valid only on Roll Mills’ official website.</li>
                                                    <li>Must be applied at checkout.</li>
                                                    @if ($coupon->minimum_order_value > 0)
                                                        <li>Minimum purchase of ₹{{ $coupon->minimum_order_value }}
                                                            required.</li>
                                                    @else
                                                        <li>No minimum purchase required.</li>
                                                    @endif
                                                    <li>Valid after
                                                        {{ \Carbon\Carbon::parse($coupon->start_date)->format('d M Y') }}.
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-6">
                                                <ul>
                                                    @if ($coupon->maximum_discount_amount > 0)
                                                        <li>Maximum discount capped at
                                                            ₹{{ $coupon->maximum_discount_amount }}.</li>
                                                    @endif
                                                    <li>Non-transferable and cannot be redeemed for cash.</li>
                                                    <li>Offer valid till
                                                        {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M Y') }}.
                                                    </li>
                                                    <li>Roll Mills reserves the right to modify or cancel anytime.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif

                    </div>
                @endif
                {{-- END DELIVERED SECTION --}}

                {{-- Original Tracking Timeline Card (Wrapped in Alpine to toggle visibility) --}}
                <div class="card-container" x-show="showTimeline" x-transition.opacity>

                    <div class="tracking-header">
                        <h2>Order Tracking <br><span>#RM-{{ $order->id }}</span></h2>
                        @php
                            $statusMap = [
                                0 => ['name' => 'Pending', 'class' => 'bg-warning text-dark'],
                                1 => ['name' => 'Processed', 'class' => 'bg-primary text-white'],
                                2 => ['name' => 'Shipped', 'class' => 'bg-info text-white'],
                                3 => ['name' => 'Delivered', 'class' => 'bg-success text-white'],
                                4 => ['name' => 'Cancelled', 'class' => 'bg-danger text-white'],
                                5 => ['name' => 'Return', 'class' => 'bg-danger text-white'],
                                6 => ['name' => 'Lost', 'class' => 'bg-secondary text-white'],
                                7 => ['name' => 'OFD', 'class' => 'bg-purple text-white'],
                                8 => ['name' => 'Return Initiated', 'class' => 'bg-orange text-white'],
                                9 => ['name' => 'Undelivered', 'class' => 'bg-dark text-white'],
                                10 => ['name' => 'Rejected', 'class' => 'bg-danger text-white'],
                            ];

                            $currentBadge = $statusMap[$order->status] ?? [
                                'name' => 'Unknown',
                                'class' => 'bg-secondary text-white',
                            ];
                        @endphp

                        <span class="status-badge {{ $currentBadge['class'] }}">
                            {{ $currentBadge['name'] }}
                        </span>
                    </div>

                    @php
                        $progressLevel = 0;

                        if ($order->status >= 1) {
                            $progressLevel = 1;
                        }
                        if ($order->status >= 2) {
                            $progressLevel = 2;
                        }
                        if ($order->status == 7) {
                            $progressLevel = 3;
                        }
                        if ($order->status == 3) {
                            $progressLevel = 4;
                        }

                        $progressStep = max(0, $progressLevel - 1);
                        $progressWidth = $progressStep * 25;
                    @endphp

                    <div class="progress-tracker">
                        <div class="progress-bar-fill" style="width: {{ $progressWidth }}%;"></div>

                        <div class="progress-step {{ $progressLevel >= 1 ? 'completed' : '' }}">
                            <div class="step-icon">{{ $progressLevel >= 1 ? '✓' : '📝' }}</div>
                            <div class="step-text">Placed</div>
                        </div>

                        <div class="progress-step {{ $progressLevel >= 2 ? 'completed' : '' }}">
                            <div class="step-icon">{{ $progressLevel >= 2 ? '✓' : '📦' }}</div>
                            <div class="step-text">Shipped</div>
                        </div>

                        <div class="progress-step {{ $progressLevel >= 3 ? 'completed' : '' }}">
                            <div class="step-icon">{{ $progressLevel >= 3 ? '✓' : '🚚' }}</div>
                            <div class="step-text">Out for Delivery</div>
                        </div>

                        <div class="progress-step {{ $progressLevel >= 4 ? 'completed' : '' }}">
                            <div class="step-icon">{{ $progressLevel >= 4 ? '✓' : '🎁' }}</div>
                            <div class="step-text">Delivered</div>
                        </div>
                    </div>

                    {{-- NEW: ESTIMATED DELIVERY BOX --}}
                    {{-- Status 0 (Pending), 1 (Processed), 2 (Shipped), 7 (OFD) --}}
                    @if (in_array($order->status, [0, 1, 2, 7]))
                        <div class="estimated-delivery-box">
                            <div class="estimated-icon-wrapper">
                                <i class="fi-rs-calendar"></i>
                            </div>
                            <div class="estimated-text-wrapper">
                                <span class="estimated-label">Estimated Delivery By</span>
                                <span class="estimated-date">
                                    @if (!empty($order->estimated_delivery_date))
                                        {{ \Carbon\Carbon::parse($order->estimated_delivery_date)->format('l, d M Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($order->created_at)->addDays(8)->format('l, d M Y') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif
                    {{-- END NEW ESTIMATED DELIVERY BOX --}}

                    @php
                        $trackingUpdates = json_decode($order->tracking_updates, true) ?? [];
                        $hasDelivered = false;

                        $shortCodeMap = [
                            'DL' => 'Delivered',
                            'OFD' => 'Out For Delivery',
                            'RAD' => 'Reached At Destination',
                            'IT' => 'In Transit',
                            'N/A' => 'Processing',
                        ];

                        foreach ($trackingUpdates as $key => $update) {
                            $rawStatus = strtoupper(trim($update['status'] ?? ''));

                            if (array_key_exists($rawStatus, $shortCodeMap)) {
                                $displayStatus = $shortCodeMap[$rawStatus];

                                if ($rawStatus === 'N/A' && !empty($update['remark'])) {
                                    $displayStatus = ucwords(strtolower($update['remark']));
                                }
                            } else {
                                $displayStatus = ucwords(strtolower($update['status'] ?? ''));
                            }

                            $trackingUpdates[$key]['display_status'] = $displayStatus;

                            if ($rawStatus === 'DL' || strtolower($displayStatus) === 'delivered') {
                                $hasDelivered = true;
                            }
                        }

                        if (!$hasDelivered && $order->status == 3) {
                            $completedDate = !empty($order->completed_at) ? $order->completed_at : now();
                            $trackingUpdates[] = [
                                'display_status' => 'Delivered',
                                'date_time' => $completedDate,
                                'remark' => 'Order successfully delivered to customer',
                                'location' => '',
                                'reason' => '',
                            ];
                        }

                        usort($trackingUpdates, function ($a, $b) {
                            return strtotime($b['date_time']) <=> strtotime($a['date_time']);
                        });
                    @endphp

                    <div class="styled-title-wrapper" style="margin-top: 35px;">
                        <h3 class="styled-title">Tracking History</h3>
                        @if ($order->status == 3)
                            <button @click="showTimeline = false"
                                style="background: transparent; border: 1px solid #d1d5db; border-radius: 4px; padding: 4px 10px; font-size: 12px; color: #4b5563; cursor: pointer; transition: all 0.2s;">Hide
                                Journey</button>
                        @endif
                    </div>

                    <div class="timeline">
                        @foreach ($trackingUpdates as $index => $update)
                            <div class="timeline-item {{ $index === 0 ? 'newest' : '' }}">
                                <div class="timeline-icon"></div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <h4 class="timeline-status">{{ $update['display_status'] }}</h4>
                                        <span
                                            class="timeline-date">{{ \Carbon\Carbon::parse($update['date_time'])->format('d M Y, h:i A') }}</span>
                                    </div>
                                    @if (!empty($update['remark']))
                                        <p class="timeline-remark">Remark: {{ $update['remark'] }}</p>
                                    @endif
                                    @if (!empty($update['location']))
                                        <p class="timeline-location"><span>📍</span> {{ $update['location'] }}</p>
                                    @endif
                                    @if (!empty($update['reason']))
                                        <p class="timeline-remark">Reason: {{ $update['reason'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="timeline-item {{ empty($trackingUpdates) ? 'newest' : '' }}">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <h4 class="timeline-status">Order Placed</h4>
                                    <span
                                        class="timeline-date">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</span>
                                </div>
                                <p class="timeline-remark">Remark: Order successfully created</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="tracking-right-col">

                <div class="card-container">
                    <div class="styled-title-wrapper">
                        <h3 class="styled-title">Your Order</h3>
                        <span class="styled-title-right">Subtotal</span>
                    </div>
                    @php
                        $total_bonus = 0;
                    @endphp

                    @foreach ($order->getOrderItems as $item)
                        <div class="order-item-box">
                            <img src="{{ asset('storage/' . $item->getProduct->featured_image) }}"
                                alt="{{ $item->getProduct->name }}" class="item-image">
                            <div class="item-details">
                                <h4 class="item-title">{{ $item->getProduct->name }}</h4>
                                @php
                                    $new_product_reviews = \App\Models\ProductReview::where('status', 1)
                                        ->where('product_id', $item->item_id)
                                        ->get();

                                    $new_product_reviews_count = $new_product_reviews->count();
                                    $new_product_reviews_avg =
                                        $new_product_reviews_count > 0
                                            ? round($new_product_reviews->avg('ratings'), 1)
                                            : 0;
                                    $new_product_reviews_percentage = ($new_product_reviews_avg / 5) * 100;
                                    $total_bonus += $item->bonus;
                                @endphp

                                <div class="product-rate">
                                    <div class="product-rating"
                                        style="width: {{ $new_product_reviews_percentage }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="item-price-col">
                                <span class="item-qty">× {{ $item->quantity }}</span>
                                <span class="item-price">₹{{ $item->sale_default_price }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card-container">
                    <div class="styled-title-wrapper">
                        <h3 class="styled-title">Details</h3>
                    </div>

                    <div class="details-wrapper">
                        <div class="details-row">
                            <span class="details-label">Your Order Sub Total</span>
                            <span class="val-dark">₹{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if ($total_bonus > 0)
                            <div class="details-row">
                                <span class="badge-cyan">UPI Discount</span>
                                <span class="val-green">- ₹{{ number_format($total_bonus, 2) }}</span>
                            </div>
                        @endif
                        <div class="details-row">
                            <span class="details-label">Order Type</span>
                            <span
                                class="badge-{{ $order->is_cod == 1 ? 'warning' : 'cyan' }}">{{ $order->is_cod == 1 ? 'COD' : 'Prepaid' }}</span>
                        </div>
                        <div class="details-row">
                            <span class="details-label">Shipping Charges</span>
                            <span class="val-dark">FREE SHIPPING</span>
                        </div>
                        @if ($order->is_cod == 1)
                            <div class="details-row mb-0">
                                <span class="details-label">COD Charges</span>
                                <span class="val-dark">₹{{ number_format($order->cod_charges, 2) }}</span>
                            </div>
                        @endif

                        <div class="details-row total-row mt-0">
                            <span class="details-label">Your Total</span>
                            <span class="val-yellow">₹{{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="details-row">
                            <span class="details-label">Payable Amount</span>
                            <span
                                class="val-dark">₹{{ $order->is_cod == 1 ? number_format($order->total, 2) : number_format(0, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-container">
                    <div class="styled-title-wrapper">
                        <h3 class="styled-title">Related Products</h3>
                    </div>

                    @if ($related_products && $related_products->count() > 0)
                        @foreach ($related_products as $product)
                            @php
                                if ($product->slug) {
                                    $shop_detail_url = route('shop-detail', [
                                        'slug' => $product->slug,
                                        'id' => $product->id,
                                    ]);
                                } else {
                                    $shop_detail_url = route('shop-detail', [
                                        'slug' => 'no-slug',
                                        'id' => $product->id,
                                    ]);
                                }
                            @endphp
                            <div class="related-item">
                                <a href="{{ $shop_detail_url }}"><img
                                        src="{{ $product->featured_image ? asset('storage/' . $product->featured_image) : 'https://placehold.co/100x100/f3f4f6/a1a1aa?text=No+Image' }}"
                                        alt="{{ $product->name }}" class="related-img"></a>
                                <div class="related-info">
                                    <a href="{{ $shop_detail_url }}">
                                        <h4 class="related-title">
                                            {{ \Illuminate\Support\Str::limit($product->name, 25, '...') }}</h4>
                                    </a>
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
                                <button wire:click="addToCart({{ $product->id }})" class="related-add-btn"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">+
                                        Add</span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">...</span>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <p style="font-size: 13px; color: #6b7280; margin-top: 10px;">No related products found.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            window.addEventListener('initiate-razorpay', function(event) {
                const detail = event.detail[0] || event.detail;
                var options = {
                    "key": '{{ config('app.razorpay_key_id') }}',
                    "amount": detail.amount,
                    "currency": "INR",
                    "name": "Roll mills",
                    "description": detail.description,
                    "image": "https://rollmills.store/assets/frontend/imgs/theme/logo.png",
                    "order_id": detail.razorpay_order_id,
                    "handler": function(response) {
                        window.location.href =
                            `${detail.success_url}?transaction_id=${detail.transaction_id}&payment_id=${response.razorpay_payment_id}`;
                    },
                    "prefill": {
                        "name": detail.name,
                    },
                    "theme": {
                        "color": "#CF9007"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            });
        });

        // Copy Code Script mapped to the new button
        document.addEventListener('click', function(event) {
            if (event.target && event.target.id === 'copyCodeBtn') {
                const copyBtn = event.target;
                const couponText = document.getElementById('couponCode');

                if (couponText) {
                    let code = couponText.innerText.trim();
                    navigator.clipboard.writeText(code).then(() => {
                        const originalText = copyBtn.innerText;
                        copyBtn.innerText = "Copied!";
                        copyBtn.classList.add('copied'); // Turns green via CSS

                        setTimeout(() => {
                            copyBtn.innerText = "Copy Code";
                            copyBtn.classList.remove('copied'); // Back to yellow
                        }, 1500);
                    }).catch(err => {
                        console.error('Failed to copy text: ', err);
                    });
                }
            }
        });
    </script>
@endpush
