<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1" href="{{ url('/admin') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Ecommerce</h1>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{ route('admin.orders.index') }}">Orders</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Order #RM-{{ $order->id }}</h1>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body page-content">
        <div class="container-xl">
            <div id="main-order-content">
                <div class="row row-cards">
                    <div class="col-md-9">
                        <div class="card mb-3">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title m-0">
                                    Order Information
                                </h4>

                                <div class="d-flex align-items-center gap-2">
                                    {{-- Add Item Button (Only visible if order is pending or processed) --}}
                                    @if (in_array($order->status, [0, 1]))
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addItemModal">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-plus" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 5l0 14"></path>
                                                <path d="M5 12l14 0"></path>
                                            </svg>
                                            Add Item
                                        </button>
                                    @endif

                                    @switch($order->status)
                                        @case(0)
                                            <span class="badge bg-warning text-dark d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="M12 6v6l4 2"></path>
                                                </svg> Pending
                                            </span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-primary text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 12h18"></path>
                                                    <path d="M3 6h18"></path>
                                                    <path d="M3 18h18"></path>
                                                </svg> Processed
                                            </span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-info text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M22 7H2v10h20V7z"></path>
                                                    <path d="M7 7V4h10v3"></path>
                                                </svg> Shipped
                                            </span>
                                        @break

                                        @case(3)
                                            <span class="badge bg-success text-white d-flex align-items-center gap-1">
                                                <svg class="icon svg-icon-ti-ti-shopping-cart-check"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                    <path d="M11.5 17h-5.5v-14h-2"></path>
                                                    <path d="M6 5l14 1l-1 7h-13"></path>
                                                    <path d="M15 19l2 2l4 -4"></path>
                                                </svg> Complete
                                            </span>
                                        @break

                                        @case(4)
                                            <span class="badge bg-danger text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M18 6l-12 12"></path>
                                                    <path d="M6 6l12 12"></path>
                                                </svg> Cancelled
                                            </span>
                                        @break

                                        @case(5)
                                            <span class="badge bg-danger text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M9 14l-4 -4l4 -4"></path>
                                                    <path d="M5 10h11a4 4 0 1 1 0 8h-1"></path>
                                                </svg> Return
                                            </span>
                                        @break

                                        @case(6)
                                            <span class="badge bg-secondary text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="9"></circle>
                                                    <path d="M9 12l6 0"></path>
                                                </svg> Lost
                                            </span>
                                        @break

                                        @case(7)
                                            <span class="badge bg-purple text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5"></path>
                                                </svg> OFD
                                            </span>
                                        @break

                                        @case(8)
                                            <span class="badge bg-orange text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                                </svg> Return Initiated
                                            </span>
                                        @break

                                        @case(9)
                                            <span class="badge bg-dark text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                                                    <path d="M10 10l4 4m0 -4l-4 4"></path>
                                                </svg> Undelivered
                                            </span>
                                        @break

                                        @case(10)
                                            <span class="badge bg-danger text-white d-flex align-items-center gap-1">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                    <path d="M10 10l4 4m0 -4l-4 4"></path>
                                                </svg> Rejected
                                            </span>
                                        @break
                                    @endswitch
                                </div>
                            </div>

                            <table class="table table-vcenter card-table order-products-table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2">Product</th>
                                        <th>Price</th>
                                        <th></th>
                                        <th>Qty</th>
                                        <th>Offer Discount</th>
                                        <th>Total</th>
                                        @if (in_array($order->status, [0, 1]))
                                            <th class="text-end">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_qunatiyt = 0;
                                    @endphp
                                    @foreach ($order->getOrderItems as $item)
                                        <tr>
                                            <td style="width: 80px">
                                                <img src="{{ Storage::url($item->getProduct->featured_image) }}"
                                                    alt="{{ $item->getProduct->name }}" class="rounded border">
                                            </td>
                                            <td style="width: 35%" class="text-start">
                                                @if ($item->is_gift_item == 1)
                                                    <p class="badge bg-success py-1 quicksand text-white mb-1">
                                                        <i class="fi-rs-gift mr-5"></i> Surprise Gift
                                                    </p>
                                                @endif
                                                <div class="d-flex align-items-center flex-wrap">

                                                    <a href="{{ route('admin.product.edit', $item->getProduct->id) }}"
                                                        title="{{ $item->getProduct->name }}" target="_blank"
                                                        class="me-2 fw-bold text-decoration-none">
                                                        {{ $item->getProduct->name }}
                                                    </a>

                                                    <p class="mb-0 text-muted small">(SKU:
                                                        <strong>{{ $item->getProduct->SKU }}</strong>)
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($item->sale_default_price != null && $item->sale_default_price != 0)
                                                    <del
                                                        class="text-muted small">₹{{ number_format($item->regular_price, 2) }}</del><br>
                                                    @if ($item->is_gift_item == 1)
                                                        <span class="fw-bold">₹0</span>
                                                    @else
                                                        <span
                                                            class="fw-bold">₹{{ number_format($item->sale_default_price, 2) }}</span>
                                                    @endif
                                                @else
                                                    @if ($item->is_gift_item == 1)
                                                        <span class="fw-bold">₹0</span>
                                                    @else
                                                        <span
                                                            class="fw-bold">₹{{ number_format($item->sale_default_price, 2) }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-muted">x</td>
                                            <td class="fw-bold">
                                                @php
                                                    $total_qunatiyt += $item->quantity;
                                                @endphp
                                                {{ $item->quantity }}
                                            </td>
                                            <td>
                                                @if ($item->offer_discount > 0)
                                                    <span class="badge bg-success-lt">
                                                        -₹{{ $item->offer_discount }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold text-primary">
                                                @if ($item->is_gift_item == 1)
                                                    ₹0
                                                @else
                                                    ₹{{ number_format($item->total + $item->bonus, 2) }}
                                                @endif
                                            </td>

                                            {{-- ACTION BUTTONS FOR EDIT & DELETE --}}
                                            @if (in_array($order->status, [0, 1]))
                                                <td class="text-end">
                                                    @if ($item->is_gift_item != 1)
                                                        <div class="btn-group btn-group-sm">
                                                            <button type="button"
                                                                wire:click="editItem({{ $item->id }})"
                                                                data-bs-toggle="modal" data-bs-target="#editItemModal"
                                                                class="btn btn-outline-primary btn-icon"
                                                                title="Edit Quantity">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-pencil m-0"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none"></path>
                                                                    <path
                                                                        d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4">
                                                                    </path>
                                                                    <path d="M13.5 6.5l4 4"></path>
                                                                </svg>
                                                            </button>
                                                            <button type="button"
                                                                wire:click="removeItem({{ $item->id }})"
                                                                onclick="confirm('Are you sure you want to remove this item?') || event.stopImmediatePropagation()"
                                                                class="btn btn-outline-danger btn-icon"
                                                                title="Remove Item">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-trash m-0"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none"></path>
                                                                    <path d="M4 7l16 0"></path>
                                                                    <path d="M10 11l0 6"></path>
                                                                    <path d="M14 11l0 6"></path>
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12">
                                                                    </path>
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 offset-md-6">
                                        {{-- Edit Discounts Button at the top of Totals --}}
                                        @if (in_array($order->status, [0, 1]))
                                            <div class="text-end mb-2">
                                                <button type="button" wire:click="editDiscounts"
                                                    class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editDiscountsModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-discount2 me-1 m-0"
                                                        width="16" height="16" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M9 15l6 -6"></path>
                                                        <circle cx="9.5" cy="9.5" r=".5"
                                                            fill="currentColor"></circle>
                                                        <circle cx="14.5" cy="14.5" r=".5"
                                                            fill="currentColor"></circle>
                                                        <path
                                                            d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7a2.2 2.2 0 0 0 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1a2.2 2.2 0 0 0 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1z">
                                                        </path>
                                                    </svg>
                                                    Edit Discounts
                                                </button>
                                            </div>
                                        @endif

                                        <table class="table table-vcenter card-table table-borderless text-end fs-5">
                                            <tbody>
                                                <tr>
                                                    <td class="text-muted">Total Items Quantity</td>
                                                    <td class="fw-bold">{{ $total_qunatiyt }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Sub amount</td>
                                                    <td class="fw-bold">₹{{ number_format($order->subtotal, 2) }}</td>
                                                </tr>
                                                @if ($order->coupon_discount && $order->coupon_discount > 0)
                                                    <tr>
                                                        <td class="text-danger">Coupon Discount</td>
                                                        <td class="text-danger fw-bold">-
                                                            ₹{{ number_format($order->coupon_discount, 2) }}</td>
                                                    </tr>
                                                @endif

                                                @if ($order->special_discount && $order->special_discount > 0)
                                                    <tr>
                                                        <td class="text-success">Special Discount</td>
                                                        <td class="text-success fw-bold">-
                                                            ₹{{ number_format($order->special_discount, 2) }}</td>
                                                    </tr>
                                                @endif

                                                @if ($order->total_bonus && $order->total_bonus > 0)
                                                    <tr>
                                                        <td class="text-info">Bonus (First Order)</td>
                                                        <td class="text-info fw-bold">-
                                                            ₹{{ number_format($order->total_bonus, 2) }}</td>
                                                    </tr>
                                                @endif

                                                @if ($order->offer_discount && $order->offer_discount > 0)
                                                    <tr>
                                                        <td class="text-primary">Offer Discount</td>
                                                        <td class="text-primary fw-bold">-
                                                            ₹{{ number_format($order->offer_discount, 2) }}</td>
                                                    </tr>
                                                @endif

                                                @if ($order->gift_card_discount && $order->gift_card_discount > 0)
                                                    <tr>
                                                        <td class="text-purple">Gift Card Discount</td>
                                                        <td class="text-purple fw-bold">-
                                                            ₹{{ number_format($order->gift_card_discount, 2) }}</td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <td class="text-muted">Shipping fee</td>
                                                    <td class="fw-bold">
                                                        @if ($order->is_cod == 1)
                                                            ₹{{ number_format($order->shipping_charges - $order->cod_charges, 2) }}
                                                        @else
                                                            ₹{{ number_format($order->shipping_charges, 2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if ($order->is_cod == 1)
                                                    <tr>
                                                        <td class="text-muted">Cash on delivery charges</td>
                                                        <td class="fw-bold">
                                                            ₹{{ number_format($order->cod_charges, 2) }}</td>
                                                    </tr>
                                                @endif

                                                <tr class="border-top">
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <h3 class="mb-0 mt-2">Total amount</h3>
                                                            {{-- Edit Total Button --}}
                                                            @if (in_array($order->status, [0, 1]))
                                                                <button type="button" wire:click="editOrderTotal"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editTotalModal"
                                                                    class="btn btn-sm btn-outline-warning btn-icon ms-2 mt-2"
                                                                    title="Edit Total">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-pencil m-0"
                                                                        width="16" height="16"
                                                                        viewBox="0 0 24 24" stroke-width="2"
                                                                        stroke="currentColor" fill="none"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none"></path>
                                                                        <path
                                                                            d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4">
                                                                        </path>
                                                                        <path d="M13.5 6.5l4 4"></path>
                                                                    </svg>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h3 class="text-warning mb-0 mt-2">
                                                            ₹{{ number_format($order->total, 2) }}</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted pb-0">Paid amount</td>
                                                    <td class="pb-0">
                                                        <a href="javascript:void(0);"
                                                            class="fw-bold text-decoration-none">
                                                            ₹{{ number_format($order->paid_amount, 2) }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        @if ($order->additional_information)
                                            <div class="mt-4 position-relative p-3 bg-white border rounded">
                                                <label class="form-label fw-bold text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-note me-1" width="20"
                                                        height="20" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M13 20l7 -7"></path>
                                                        <path
                                                            d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7">
                                                        </path>
                                                    </svg>
                                                    Customer Note
                                                </label>
                                                <p class="mb-0 text-muted fst-italic">
                                                    {{ $order->additional_information }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        @if ($order_transaction != null)
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Transaction</h3>
                                </div>

                                <div class="card-table">
                                    <div class="table-responsive table-has-actions table-has-filter">
                                        <table class="table card-table table-vcenter table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Payment ID</th>
                                                    <th>Payer Name</th>
                                                    <th>Amount</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center text-muted">1</td>
                                                    <td>
                                                        <a href="{{ route('admin.transaction.edit', $order_transaction->id) }}"
                                                            target="_blank"
                                                            class="fw-bold">{{ $order_transaction->payment_id }}</a>
                                                    </td>
                                                    <td class="text-muted">{{ $order_transaction->getUser->name }}
                                                    </td>
                                                    <td class="fw-bold">
                                                        ₹{{ number_format($order_transaction->amount) }}</td>
                                                    <td class="text-muted">{{ $order_transaction->description }}</td>
                                                    <td>
                                                        @if ($order_transaction->status === 0)
                                                            <span
                                                                class="badge bg-warning text-warning-fg">Pending</span>
                                                        @elseif($order_transaction->status === 1)
                                                            <span
                                                                class="badge bg-success text-success-fg">Confirm</span>
                                                        @else
                                                            <span class="badge bg-danger text-danger-fg">Cancel</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-muted">
                                                        {{ \Carbon\Carbon::parse($order_transaction->created_at)->format('d-m-Y') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-3">

                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Order Status Change
                                </h4>
                            </div>

                            <div class="card-body p-3">
                                @if (!in_array($order->status, [3, 4, 5, 6, 9, 10]))
                                    <form wire:submit.prevent="orderStatusChange" class="mb-2">

                                        <div class="">
                                            <label for="statusSelect" class="form-label fw-bold">Change
                                                Status:</label>
                                            <select wire:model="status" id="statusSelect" class="form-select">
                                                <option value="">Select Status</option>
                                                <option value="0">Pending</option>
                                                <option value="1">Processed</option>
                                                <option value="2">Shipped</option>
                                                <option value="3">Complete</option>
                                                <option value="4">Cancelled</option>
                                                <option value="5">Return</option>
                                                <option value="6">Lost</option>
                                                <option value="7">OFD</option>
                                                <option value="8">Return Initiated</option>
                                                <option value="9">Undelivered</option>
                                                <option value="10">Rejected</option>
                                            </select>
                                        </div>

                                        <div class="d-flex justify-content-center mt-3">
                                            <button class="btn btn-primary w-100">Update Status</button>
                                        </div>
                                        @if ($order->status == 1 && $order->is_cod == 1)
                                            <button type="button" wire:click="sendConfirmationMessage"
                                                class="btn btn-outline-success w-100 mt-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-brand-whatsapp" width="20"
                                                    height="20" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                                                    <path
                                                        d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1">
                                                    </path>
                                                </svg>
                                                Send Confirmation
                                            </button>
                                        @endif
                                    </form>
                                @else
                                    <div class="mt-3">
                                        <label for="statusSelect" class="form-label fw-bold">Current Status</label>
                                        @php
                                            $statusMap = [
                                                0 => ['name' => 'Pending', 'class' => 'bg-warning text-dark'],
                                                1 => ['name' => 'Processed', 'class' => 'bg-primary text-white'],
                                                2 => ['name' => 'Shipped', 'class' => 'bg-info text-white'],
                                                3 => ['name' => 'Complete', 'class' => 'bg-success text-white'],
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
                                        <p class="badge fs-5 w-100 py-2 {{ $currentBadge['class'] }}">
                                            {{ $currentBadge['name'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title m-0">Logistics & AWB</h4>
                                    <small class="text-muted">Manage shipping details</small>
                                </div>
                                <button wire:click="addLogisticsRow" type="button"
                                    class="btn btn-sm btn-primary btn-icon" title="Add Tracking">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-plus m-0" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="card-body p-3" style="max-height: 500px; overflow-y: auto;">

                                @if (empty($logistics))
                                    <div class="text-center py-4">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-truck-delivery text-muted mb-2"
                                            width="48" height="48" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5"></path>
                                            <path d="M3 9l4 0"></path>
                                        </svg>
                                        <p class="text-muted small">No logistics info added yet.</p>
                                    </div>
                                @endif

                                @foreach ($logistics as $index => $row)
                                    <div class="card mb-3 border shadow-sm position-relative group-hover-btn">
                                        <button wire:click="removeLogisticsRow({{ $index }})" type="button"
                                            class="btn-close position-absolute top-0 end-0 m-2" aria-label="Close"
                                            style="z-index: 10; font-size: 0.75rem;" title="Remove"></button>

                                        <div class="card-body p-2">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label class="form-label small text-muted text-uppercase fw-bold"
                                                        style="font-size: 0.7rem;">Aggregator</label>
                                                    <select wire:model="logistics.{{ $index }}.aggregator"
                                                        class="form-control form-control-sm">
                                                        <option value="" disabled>Select Aggregator</option>
                                                        <option value="Ithink">Ithink</option>
                                                        <option value="XpressBees">XpressBees</option>
                                                        <option value="Custom">Custom</option>
                                                    </select>
                                                    @error('logistics.{{ $index }}.aggregator')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label small text-muted text-uppercase fw-bold"
                                                        style="font-size: 0.7rem;">Provider</label>
                                                    <input type="text"
                                                        wire:model="logistics.{{ $index }}.provider"
                                                        placeholder="Ex: BlueDart"
                                                        class="form-control form-control-sm">
                                                    @error('logistics.{{ $index }}.provider')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label small text-muted text-uppercase fw-bold"
                                                        style="font-size: 0.7rem;">AWB / Tracking ID</label>
                                                    <div class="input-group input-group-sm input-group-flat">
                                                        <span class="input-group-text bg-light">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-barcode"
                                                                width="18" height="18" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                                                                <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                                                                <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                                                                <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                                                                <path d="M5 11h1v2h-1z"></path>
                                                                <path d="M10 11l0 2"></path>
                                                                <path d="M14 11h1v2h-1z"></path>
                                                                <path d="M19 11l0 2"></path>
                                                            </svg>
                                                        </span>
                                                        <input type="text"
                                                            wire:model="logistics.{{ $index }}.awb_number"
                                                            placeholder="Enter AWB Number"
                                                            class="form-control font-monospace">
                                                        @error('logistics.{{ $index }}.awb_number')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label small text-muted text-uppercase fw-bold"
                                                        style="font-size: 0.7rem;">Shipping Charges</label>
                                                    <div class="input-group input-group-sm input-group-flat">
                                                        <span class="input-group-text bg-light">₹</span>
                                                        <input type="number" step="0.01"
                                                            wire:model="logistics.{{ $index }}.charges"
                                                            placeholder="0.00" class="form-control">
                                                        @error('logistics.{{ $index }}.charges')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="card-footer bg-light p-3">
                                <button wire:click="saveLogistics" class="btn btn-dark w-100">
                                    Save Logistics Details
                                </button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Customer
                                </h4>
                            </div>

                            <div class="card-body p-0">
                                <div class="p-3">

                                    <p class="mb-1">
                                        <svg class="icon svg-icon-ti-ti-inbox text-muted me-1"
                                            xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                                            </path>
                                            <path d="M4 13h3l3 3h4l3 -3h3"></path>
                                        </svg> <span
                                            class="fw-bold">{{ $order->getOrderItems->sum('quantity') }}</span> items
                                        ordered
                                    </p>

                                    <p class="mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-user text-muted me-1" width="18"
                                            height="18" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                        <span class="fw-bold text-primary">{{ $order->getUser->name }}</span>
                                    </p>

                                    <p class="mb-1">
                                        <a href="mailto:{{ $order->getUser->email }}"
                                            class="text-decoration-none text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-mail text-muted me-1"
                                                width="18" height="18" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z">
                                                </path>
                                                <path d="M3 7l9 6l9 -6"></path>
                                            </svg>
                                            {{ $order->getUser->email }}
                                        </a>
                                    </p>
                                </div>

                                <div class="hr my-1"></div>

                                <div class="p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="m-0">Shipping information</h4>
                                        <button type="button" wire:click="editAddress" data-bs-toggle="modal"
                                            data-bs-target="#editAddressModal"
                                            class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-pencil m-0" width="16"
                                                height="16" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                                                <path d="M13.5 6.5l4 4"></path>
                                            </svg>
                                            Edit
                                        </button>
                                    </div>
                                    @php
                                        $shippAddress = json_decode($order->ship_different_address_details);
                                    @endphp
                                    <dl class="shipping-address-info mb-0 text-muted">
                                        <dd class="fw-bold text-dark">{{ $shippAddress->name ?? 'N/A' }}</dd>
                                        <dd>
                                            @if (!empty($shippAddress->mobile))
                                                <a href="tel:+91{{ $shippAddress->mobile }}"
                                                    class="text-decoration-none">
                                                    <svg class="icon svg-icon-ti-ti-phone text-muted me-1"
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                                        </path>
                                                    </svg> <span dir="ltr" class="fw-bold">+91
                                                        {{ $shippAddress->mobile }}</span>
                                                </a>
                                            @endif
                                        </dd>

                                        <dd class="mt-2">
                                            @if (!empty($shippAddress->address_line_1))
                                                {{ $shippAddress->address_line_1 }}<br>
                                                @if (!empty($shippAddress->address_line_2))
                                                    {{ $shippAddress->address_line_2 }}<br>
                                                @endif
                                            @endif
                                            {{ $shippAddress->city ?? '' }}, {{ $shippAddress->state ?? '' }} <br>
                                            {{ $shippAddress->zipcode ?? '' }}
                                        </dd>

                                        @php
                                            $addressParts = [];
                                            if (!empty($shippAddress->address_line_1)) {
                                                $addressParts[] = $shippAddress->address_line_1;
                                            } elseif (!empty($shippAddress->address_line_2)) {
                                                $addressParts[] = $shippAddress->address_line_2;
                                            }

                                            if (!empty($shippAddress->city)) {
                                                $addressParts[] = $shippAddress->city;
                                            }
                                            if (!empty($shippAddress->state)) {
                                                $addressParts[] = $shippAddress->state;
                                            }
                                            if (!empty($shippAddress->zipcode)) {
                                                $addressParts[] = $shippAddress->zipcode;
                                            }

                                            $fullAddress = implode(', ', $addressParts);
                                        @endphp

                                        <dd class="mt-2">
                                            <a href="https://maps.google.com/?q={{ urlencode($fullAddress) }}"
                                                target="_blank" class="btn btn-sm btn-light border w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-map-pin text-primary"
                                                    width="18" height="18" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                                    <path
                                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                                                    </path>
                                                </svg>
                                                See on maps
                                            </a>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Edit Address --}}
    <div wire:ignore.self class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="updateAddress">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">Edit Shipping Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="edit_name"
                                    placeholder="Enter full name">
                                @error('edit_name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mobile <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">+91</span>
                                    <input type="text" class="form-control" wire:model="edit_mobile"
                                        placeholder="10-digit number">
                                </div>
                                @error('edit_mobile')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" wire:model="edit_email"
                                    placeholder="Email address (optional)">
                                @error('edit_email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Address Line 1 <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="edit_address_line_1"
                                    placeholder="House No., Building, Street">
                                @error('edit_address_line_1')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Address Line 2</label>
                                <input type="text" class="form-control" wire:model="edit_address_line_2"
                                    placeholder="Locality, Area, Landmark">
                                @error('edit_address_line_2')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="edit_city"
                                    placeholder="City">
                                @error('edit_city')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="edit_state"
                                    placeholder="State">
                                @error('edit_state')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Zipcode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="edit_zipcode"
                                    placeholder="6-digit PIN">
                                @error('edit_zipcode')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-link link-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <span wire:loading.remove wire:target="updateAddress">Save Address</span>
                            <span wire:loading wire:target="updateAddress">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL: Edit Discounts --}}
    <div wire:ignore.self class="modal fade" id="editDiscountsModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form wire:submit.prevent="updateDiscounts">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title">Edit Order Discounts</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Special Discount (₹)</label>
                            <input type="number" step="0.01" class="form-control"
                                wire:model="edit_special_discount" min="0">
                            @error('edit_special_discount')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Bonus / First Order Discount (₹)</label>
                            <input type="number" step="0.01" class="form-control" wire:model="edit_total_bonus"
                                min="0">
                            @error('edit_total_bonus')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-link link-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <span wire:loading.remove wire:target="updateDiscounts">Save Discounts</span>
                            <span wire:loading wire:target="updateDiscounts">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL: Edit Total --}}
    <div wire:ignore.self class="modal fade" id="editTotalModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form wire:submit.prevent="updateOrderTotal">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title">Edit Final Order Total</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Final Order Total (₹) <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="0.01"
                                class="form-control form-control-lg text-warning fw-bold"
                                wire:model="edit_order_total" min="0">
                            @error('edit_order_total')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                            <small class="form-hint mt-2">Note: Changing the total will directly impact the remaining
                                amount left to pay if the order is not yet fully paid.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-link link-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning ms-auto">
                            <span wire:loading.remove wire:target="updateOrderTotal">Save Total</span>
                            <span wire:loading wire:target="updateOrderTotal">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL: Add Item To Order --}}
    <div wire:ignore.self class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="addItemToOrder">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-shopping-cart-plus me-1 text-primary"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M12.5 17h-6.5v-14h-2"></path>
                                <path d="M6 5l14 1l-.86 6.017m-2.64 .983h-10.5"></path>
                                <path d="M16 19h6"></path>
                                <path d="M19 16v6"></path>
                            </svg>
                            Add Item to Order
                        </h5>
                        <button type="button" class="btn-close" wire:click="clearSelectedProduct"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4 pt-3">
                        {{-- Search Input Wrapper --}}
                        <div class="mb-4 position-relative">
                            <label class="form-label fw-bold">Search Product <span
                                    class="text-danger">*</span></label>

                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control form-control-lg bg-light"
                                    wire:model.live.debounce.300ms="searchKeyword"
                                    placeholder="Type product name or SKU..." autocomplete="off">
                            </div>

                            {{-- Dropdown Results --}}
                            @if (strlen($searchKeyword) > 1 && count($searchResults) > 0)
                                <div class="dropdown-menu show w-100 position-absolute shadow mt-1 border-0"
                                    style="max-height: 280px; overflow-y: auto; z-index: 1055; top: 100%;">
                                    <div class="px-2 pb-1 pt-1 text-muted small fw-bold">SEARCH RESULTS</div>
                                    @foreach ($searchResults as $result)
                                        <button type="button"
                                            class="dropdown-item d-flex align-items-center py-2 border-bottom"
                                            wire:click="selectProduct({{ $result->id }})">
                                            <img src="{{ Storage::url($result->featured_image) }}" alt="img"
                                                class="rounded border me-3"
                                                style="width: 45px; height: 45px; object-fit: cover;">
                                            <div class="flex-grow-1 text-truncate">
                                                <div class="fw-bold text-wrap" style="line-height: 1.2;">
                                                    {{ $result->name }}</div>
                                                <div class="mt-1 d-flex align-items-center justify-content-between">
                                                    <span class="badge bg-secondary-lt text-dark"
                                                        style="font-size: 10px;">SKU: {{ $result->SKU }}</span>
                                                    <span
                                                        class="text-success fw-bold">₹{{ $result->sale_default_price > 0 ? $result->sale_default_price : $result->price }}</span>
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            @elseif(strlen($searchKeyword) > 1 && !$selectedProductId)
                                <div class="dropdown-menu show w-100 position-absolute shadow mt-1 border-0 text-center py-3 text-muted"
                                    style="z-index: 1055; top: 100%;">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-mood-empty mb-2 opacity-50" width="32"
                                        height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                        <path d="M9 10l.01 0"></path>
                                        <path d="M15 10l.01 0"></path>
                                        <path d="M9 15l6 0"></path>
                                    </svg><br>
                                    No products found matching "{{ $searchKeyword }}"
                                </div>
                            @endif
                        </div>

                        {{-- Selected Product Display --}}
                        @if ($selectedProductId)
                            <div class="card bg-success-lt border-success mb-4 shadow-sm">
                                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="20"
                                                height="20" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="d-block text-success fw-bold"
                                                style="font-size: 10px; letter-spacing: 1px;">SELECTED PRODUCT</span>
                                            <span class="fw-bold text-dark fs-5">{{ $selectedProductName }}</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" wire:click="clearSelectedProduct"
                                        title="Remove selection"></button>
                                </div>
                            </div>

                            <div class="mb-3 p-3 bg-light rounded border">
                                <label class="form-label fw-bold">Quantity <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg w-50">
                                    <span class="input-group-text bg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-box-multiple" width="20"
                                            height="20" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M7 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z">
                                            </path>
                                            <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="number" class="form-control" wire:model="selectedProductQty"
                                        min="1">
                                </div>
                                @error('selectedProductQty')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-link link-secondary" wire:click="clearSelectedProduct"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-auto"
                            @if (!$selectedProductId) disabled @endif>
                            <span wire:loading.remove wire:target="addItemToOrder">Add to Order</span>
                            <span wire:loading wire:target="addItemToOrder">Adding...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL: Edit Item Quantity --}}
    <div wire:ignore.self class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form wire:submit.prevent="updateItem">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title">Edit Item Quantity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-3">
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold mb-1">Product</label>
                            <div class="p-3 bg-light rounded border fw-bold text-dark">{{ $editOrderItemName }}</div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">Update Quantity <span
                                    class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-box-multiple" width="20"
                                        height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M7 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z">
                                        </path>
                                        <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2">
                                        </path>
                                    </svg>
                                </span>
                                <input type="number" class="form-control" wire:model="editOrderItemQty"
                                    min="1">
                            </div>
                            @error('editOrderItemQty')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-link link-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <span wire:loading.remove wire:target="updateItem">Save Quantity</span>
                            <span wire:loading wire:target="updateItem">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            window.addEventListener('close-edit-address-modal', event => {
                if (window.jQuery) {
                    $('#editAddressModal').modal('hide');
                } else if (typeof bootstrap !== 'undefined') {
                    var editModalEl = document.getElementById('editAddressModal');
                    var editModal = bootstrap.Modal.getInstance(editModalEl);
                    if (editModal) {
                        editModal.hide();
                    }
                }
                cleanUpBackdrop();
            });

            window.addEventListener('close-add-item-modal', event => {
                if (window.jQuery) {
                    $('#addItemModal').modal('hide');
                } else if (typeof bootstrap !== 'undefined') {
                    var addModalEl = document.getElementById('addItemModal');
                    var addModal = bootstrap.Modal.getInstance(addModalEl);
                    if (addModal) {
                        addModal.hide();
                    }
                }
                cleanUpBackdrop();
            });

            window.addEventListener('close-edit-item-modal', event => {
                if (window.jQuery) {
                    $('#editItemModal').modal('hide');
                } else if (typeof bootstrap !== 'undefined') {
                    var itemModalEl = document.getElementById('editItemModal');
                    var itemModal = bootstrap.Modal.getInstance(itemModalEl);
                    if (itemModal) {
                        itemModal.hide();
                    }
                }
                cleanUpBackdrop();
            });

            window.addEventListener('close-edit-discounts-modal', event => {
                if (window.jQuery) {
                    $('#editDiscountsModal').modal('hide');
                } else if (typeof bootstrap !== 'undefined') {
                    var discModalEl = document.getElementById('editDiscountsModal');
                    var discModal = bootstrap.Modal.getInstance(discModalEl);
                    if (discModal) {
                        discModal.hide();
                    }
                }
                cleanUpBackdrop();
            });

            window.addEventListener('close-edit-total-modal', event => {
                if (window.jQuery) {
                    $('#editTotalModal').modal('hide');
                } else if (typeof bootstrap !== 'undefined') {
                    var totModalEl = document.getElementById('editTotalModal');
                    var totModal = bootstrap.Modal.getInstance(totModalEl);
                    if (totModal) {
                        totModal.hide();
                    }
                }
                cleanUpBackdrop();
            });

            function cleanUpBackdrop() {
                setTimeout(() => {
                    document.querySelector('body').classList.remove('modal-open');
                    document.querySelector('body').style.overflow = '';
                    document.querySelector('body').style.paddingRight = '';
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                }, 300);
            }
        });
    </script>
@endpush
