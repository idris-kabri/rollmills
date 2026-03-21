<div>
    <style>
        /* --- Base & Responsive Grid --- */
        .livewire-tracking-wrapper {
            max-width: 100%;
            margin: 15px auto;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1f2937;
            padding: 0 10px;
        }

        .tracking-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            align-items: start;
        }

        @media (min-width: 992px) {
            .livewire-tracking-wrapper {
                max-width: 1100px;
                padding: 0 20px;
                margin: 30px auto;
            }

            .tracking-grid {
                grid-template-columns: 1.8fr 1.2fr;
                gap: 20px;
            }

            .tracking-right-col {
                position: sticky;
                top: 20px;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .tracking-left-col {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
        }

        /* --- Global Card Styles --- */
        .card-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            padding: 15px;
            border: 1px solid #f3f4f6;
            margin-bottom: 15px;
        }

        @media (min-width: 992px) {
            .card-container {
                padding: 24px;
                margin-bottom: 0;
            }
        }

        /* --- Section Titles --- */
        .styled-title-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 15px;
        }

        .styled-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            position: relative;
            padding-bottom: 6px;
        }

        .styled-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 35px;
            height: 3px;
            background-color: #eab308;
            border-radius: 2px;
        }

        .styled-title-right {
            font-size: 13px;
            font-weight: 600;
            color: #9ca3af;
        }

        @media (min-width: 992px) {
            .styled-title {
                font-size: 20px;
                padding-bottom: 8px;
            }

            .styled-title::after {
                width: 45px;
            }

            .styled-title-right {
                font-size: 14px;
            }
        }

        /* --- COD TO PREPAID TOP BANNER --- */
        .cod-promo-banner {
            background: #fffbf0;
            border: 2px dashed #eab308;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(234, 179, 8, 0.1);
        }

        .cod-promo-content h3 {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 800;
            color: #1f2937;
            margin: 0 0 10px 0;
        }

        .cod-promo-content p {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 0;
            line-height: 1.5;
        }

        .express-badge {
            background-color: #ef4444;
            color: #ffffff;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            vertical-align: middle;
            margin-left: 5px;
            white-space: nowrap;
            display: inline-block;
        }

        .cod-promo-action {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #e5e7eb;
        }

        .cod-promo-action .payable-text {
            color: #6b7280;
            font-size: 14px;
            font-weight: 600;
        }

        .cod-promo-action .payable-amount {
            color: #eab308;
            font-size: 24px;
            font-weight: 800;
            margin-left: 8px;
        }

        @media (min-width: 992px) {
            .cod-promo-banner {
                display: flex;
                align-items: center;
                justify-content: space-between;
                text-align: left;
                padding: 25px 30px;
            }

            .cod-promo-content h3 {
                justify-content: flex-start;
                font-size: 22px;
            }

            .cod-promo-content p {
                font-size: 15px;
            }

            .cod-promo-action {
                margin-top: 0;
                padding-top: 0;
                border-top: none;
                border-left: 1px dashed #eab308;
                padding-left: 30px;
                min-width: 300px;
                text-align: center;
            }
        }

        /* --- NEW: DELIVERED SUCCESS BANNER --- */
        .success-delivery-banner {
            background-color: #ecfdf5;
            /* Light emerald */
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            text-align: center;
        }

        .success-delivery-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .success-icon {
            width: 40px;
            height: 40px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .success-text h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #065f46;
        }

        .success-text p {
            margin: 0;
            font-size: 13px;
            color: #047857;
        }

        .btn-view-journey {
            background: #ffffff;
            border: 1px solid #d1d5db;
            color: #374151;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            white-space: nowrap;
        }

        .btn-view-journey:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        @media (min-width: 768px) {
            .success-delivery-banner {
                flex-direction: row;
                justify-content: space-between;
                text-align: left;
            }

            .success-text h2 {
                font-size: 20px;
            }

            .success-text p {
                font-size: 14px;
            }
        }

        /* --- NEW: PREMIUM COUPON CARD --- */
        .premium-coupon-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
            overflow: hidden;
            position: relative;
            text-align: center;
        }

        .coupon-gold-strip {
            height: 6px;
            background: linear-gradient(90deg, #eab308 0%, #fef08a 50%, #eab308 100%);
            width: 100%;
        }

        .premium-coupon-content {
            padding: 30px 20px;
        }

        .coupon-gift-icon {
            font-size: 40px;
            margin-bottom: 10px;
            display: inline-block;
        }

        .premium-offer-title {
            font-size: 24px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .premium-offer-title span {
            color: #eab308;
        }

        .premium-offer-desc {
            font-size: 15px;
            color: #6b7280;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .premium-offer-desc strong {
            color: #1f2937;
            font-weight: 700;
        }

        /* Code Box */
        .code-display-wrapper {
            background: #fffdf5;
            border: 2px dashed #eab308;
            border-radius: 8px;
            padding: 10px 10px 10px 20px;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 15px;
            max-width: 100%;
            width: fit-content;
        }

        .the-actual-code {
            font-size: 22px;
            font-weight: 800;
            color: #1f2937;
            letter-spacing: 1px;
            margin: 0;
        }

        .btn-copy-code {
            background: #eab308;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
        }

        .btn-copy-code:hover {
            background: #ca9a07;
        }

        .btn-copy-code.copied {
            background: #10b981;
        }

        .coupon-footer-msg {
            font-size: 14px;
            color: #9ca3af;
            font-style: italic;
            margin-bottom: 25px;
        }

        .dashed-divider-light {
            border-top: 1px dashed #e5e7eb;
            margin: 0 0 20px 0;
        }

        /* Terms */
        .premium-terms {
            text-align: left;
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
        }

        .premium-terms h5 {
            font-size: 15px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .premium-terms ul {
            padding-left: 20px;
            margin: 0;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
        }

        .premium-terms li {
            margin-bottom: 6px;
        }

        @media (min-width: 768px) {
            .premium-coupon-content {
                padding: 40px;
            }

            .premium-offer-title {
                font-size: 28px;
            }

            .the-actual-code {
                font-size: 26px;
            }
        }


        /* --- LEFT COLUMN: TRACKING PROGRESS --- */
        .tracking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed #e5e7eb;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .tracking-header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .tracking-header h2 span {
            color: #6b7280;
            font-weight: 500;
            font-size: 13px;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 11px;
        }

        .progress-tracker {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 20px 0 35px 0;
        }

        .progress-tracker::before {
            content: '';
            position: absolute;
            top: 15px;
            transform: translateY(-50%);
            left: 12.5%;
            width: 75%;
            height: 3px;
            background: #e5e7eb;
            z-index: 1;
        }

        .progress-bar-fill {
            position: absolute;
            top: 15px;
            transform: translateY(-50%);
            left: 12.5%;
            height: 3px;
            background: #10b981;
            z-index: 1;
            transition: width 0.4s ease-in-out;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 25%;
        }

        .step-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ffffff;
            color: #9ca3af;
            line-height: 26px;
            margin: 0 auto 6px;
            font-weight: bold;
            border: 2px solid #e5e7eb;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .step-text {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
        }

        .progress-step.completed .step-icon {
            background: #10b981;
            border-color: #10b981;
            color: #fff;
        }

        .progress-step.completed .step-text {
            color: #111827;
        }

        @media (min-width: 992px) {
            .tracking-header {
                padding-bottom: 15px;
            }

            .tracking-header h2 {
                font-size: 18px;
            }

            .tracking-header h2 span {
                font-size: 14px;
            }

            .status-badge {
                font-size: 12px;
                padding: 6px 12px;
            }

            .progress-tracker {
                margin: 25px 0 40px 0;
            }

            .progress-tracker::before,
            .progress-bar-fill {
                top: 20px;
                height: 4px;
            }

            .step-icon {
                width: 40px;
                height: 40px;
                line-height: 36px;
                font-size: 15px;
                border-width: 3px;
            }

            .step-text {
                font-size: 12px;
            }
        }

        /* --- TIMELINE REDESIGN --- */
        .timeline {
            position: relative;
            padding-left: 30px;
            margin-top: 20px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 25px;
            bottom: 30px;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 16px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            left: -30px;
            top: 24px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #d1d5db;
            z-index: 2;
        }

        .timeline-item.newest .timeline-icon {
            background: #10b981;
            border: none;
            width: 16px;
            height: 16px;
            left: -30px;
            top: 24px;
        }

        .timeline-content {
            background: #ffffff;
            padding: 16px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .timeline-item.newest .timeline-content {
            border-color: #6ee7b7;
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .timeline-status {
            font-weight: 700;
            color: #111827;
            margin: 0;
            font-size: 14px;
        }

        .timeline-date {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
        }

        .timeline-remark {
            font-size: 13px;
            color: #6b7280;
            margin: 0 0 10px 0;
        }

        .timeline-location {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .timeline-location span {
            color: #ef4444;
            margin-right: 6px;
            font-size: 14px;
        }


        /* --- RIGHT COLUMN: ORDER SUMMARY & DETAILS --- */
        .order-item-box {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px dashed #f3f4f6;
        }

        .order-item-box:last-of-type {
            border-bottom: none;
            padding-bottom: 0;
        }

        .item-image {
            width: 55px;
            height: 55px;
            border-radius: 6px;
            object-fit: cover;
            margin-right: 12px;
            border: 1px solid #e5e7eb;
        }

        .item-details {
            flex-grow: 1;
            line-height: 1.2;
            overflow: hidden;
        }

        .item-title {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin: 0 0 4px 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-price-col {
            text-align: right;
            min-width: 50px;
            flex-shrink: 0;
        }

        .item-qty {
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            display: block;
            margin-bottom: 4px;
        }

        .item-price {
            font-weight: 700;
            color: #eab308;
            font-size: 15px;
        }

        @media (min-width: 992px) {
            .order-item-box {
                padding: 15px;
                border: 1px solid #f3f4f6;
                border-radius: 8px;
                margin-bottom: 10px;
            }

            .item-image {
                width: 70px;
                height: 70px;
                margin-right: 15px;
            }

            .item-title {
                font-size: 14px;
            }

            .item-price-col {
                display: flex;
                gap: 20px;
                align-items: center;
            }

            .item-qty {
                font-size: 14px;
                margin-bottom: 0;
            }

            .item-price {
                font-size: 18px;
            }
        }

        .details-wrapper {
            background: #ffffff;
            padding: 5px 0 0 0;
        }

        .details-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .details-label {
            color: #9ca3af;
            font-weight: 600;
        }

        .badge-cyan {
            background-color: #06b6d4;
            color: #ffffff;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        .badge-warning {
            background-color: #eab308;
            color: #ffffff;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        .val-dark {
            color: #1f2937;
            font-weight: 700;
        }

        .val-green {
            color: #65a30d;
            font-weight: 700;
        }

        .val-yellow {
            color: #eab308;
            font-weight: 700;
        }

        .total-row {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #e5e7eb;
        }

        .total-row .details-label {
            font-size: 14px;
            color: #1f2937;
        }

        .total-row .val-yellow {
            font-size: 16px;
        }

        @media (min-width: 992px) {
            .details-row {
                font-size: 15px;
                margin-bottom: 14px;
            }

            .badge-cyan {
                font-size: 11px;
            }

            .total-row {
                border-top: none;
            }

            .total-row .val-yellow {
                font-size: 18px;
            }
        }

        /* --- RELATED PRODUCTS SECTION --- */
        .related-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed #f3f4f6;
        }

        .related-item:first-of-type {
            padding-top: 5px;
        }

        .related-item:last-of-type {
            border-bottom: none;
            padding-bottom: 0;
        }

        .related-img {
            width: 48px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #e5e7eb;
            flex-shrink: 0;
        }

        .related-info {
            flex-grow: 1;
            padding: 0 12px;
            overflow: hidden;
        }

        .related-title {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 0 0 4px 0;
        }

        .price-transition {
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            margin-right: 5px;
        }

        .old-price {
            font-size: 12px;
            font-weight: 500;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .related-add-btn {
            background-color: transparent;
            color: #eab308;
            border: 1px solid #eab308;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .related-add-btn:hover {
            background-color: #eab308;
            color: #ffffff;
        }

        .related-add-btn.btn-filled {
            background-color: #eab308;
            color: #ffffff;
            font-size: 14px;
            padding: 10px;
            width: 100%;
            text-align: center;
            margin-top: 5px;
        }

        .related-add-btn.btn-filled:hover {
            background-color: #c99a07;
        }
    </style>

    <div class="livewire-tracking-wrapper">

        {{-- TOP CENTER: DYNAMIC COD TO PREPAID OFFER BOX --}}
        @if ($order->is_cod == 1 && $order->status == 1)
            @php
                $conversion_discount = 0;
                foreach ($order->getOrderItems as $item) {
                    $conversion_discount += ($item->total * 20) / 100;
                }
                $new_payable = ceil($order->total - $conversion_discount - $order->cod_charges);
                $total_savings = ceil($conversion_discount + $order->cod_charges);
            @endphp

            <div class="cod-promo-banner">
                <div class="cod-promo-content">
                    <h3>🎉 Convert & Save!</h3>
                    <p>
                        Pay via UPI/Card now to get an extra <strong>20% off</strong>, waive the
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
                                    <div class="product-rating" style="width: {{ $new_product_reviews_percentage }}%">
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
                        "email": detail.email
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
