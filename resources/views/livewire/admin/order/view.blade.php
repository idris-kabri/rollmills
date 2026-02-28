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
                            <div class="card-header justify-content-between">
                                <h4 class="card-title">
                                    Order Information
                                </h4>

                                @switch($order->status)
                                    @case(0)
                                        <span class="badge bg-warning text-dark d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="M12 6v6l4 2"></path>
                                            </svg>
                                            Pending
                                        </span>
                                    @break

                                    @case(1)
                                        <span class="badge bg-primary text-white d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M3 12h18"></path>
                                                <path d="M3 6h18"></path>
                                                <path d="M3 18h18"></path>
                                            </svg>
                                            Processed
                                        </span>
                                    @break

                                    @case(2)
                                        <span class="badge bg-info text-white d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M22 7H2v10h20V7z"></path>
                                                <path d="M7 7V4h10v3"></path>
                                            </svg>
                                            Shipped
                                        </span>
                                    @break

                                    @case(3)
                                        <span class="badge bg-success text-white d-flex align-items-center gap-1">
                                            <svg class="icon svg-icon-ti-ti-shopping-cart-check"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M11.5 17h-5.5v-14h-2"></path>
                                                <path d="M6 5l14 1l-1 7h-13"></path>
                                                <path d="M15 19l2 2l4 -4"></path>
                                            </svg>
                                            Complete
                                        </span>
                                    @break

                                    @case(4)
                                        <span class="badge bg-danger text-white d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6l-12 12"></path>
                                                <path d="M6 6l12 12"></path>
                                            </svg>
                                            Cancelled
                                        </span>
                                    @break

                                    @case(5)
                                        <span class="badge bg-danger text-white d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M9 14l-4 -4l4 -4"></path>
                                                <path d="M5 10h11a4 4 0 1 1 0 8h-1"></path>
                                            </svg>
                                            Return
                                        </span>
                                    @break

                                    @case(6)
                                        <span class="badge bg-secondary text-white d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <path d="M9 12l6 0"></path>
                                            </svg>
                                            Lost
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
                                            </svg>
                                            OFD
                                        </span>
                                    @break

                                    @case(8)
                                        <span class="badge bg-orange text-white d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                            </svg>
                                            Return Initiated
                                        </span>
                                    @break

                                    @case(9)
                                        <span class="badge bg-dark text-white d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                                                <path d="M10 10l4 4m0 -4l-4 4"></path>
                                            </svg>
                                            Undelivered
                                        </span>
                                    @break

                                    @case(10)
                                        <span class="badge bg-danger text-white d-flex align-items-center gap-1">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                <path d="M10 10l4 4m0 -4l-4 4"></path>
                                            </svg>
                                            Rejected
                                        </span>
                                    @break
                                @endswitch
                            </div>

                            <table class="table table-vcenter card-table order-products-table">
                                <tbody>
                                    @php
                                        $total_qunatiyt = 0;
                                    @endphp
                                    @foreach ($order->getOrderItems as $item)
                                        <tr>
                                            <td style="width: 80px">
                                                <img src="{{ Storage::url($item->getProduct->featured_image) }}"
                                                    alt="{{ $item->getProduct->name }}">
                                            </td>
                                            <td style="width: 45%" class="text-start">
                                                @if ($item->is_gift_item == 1)
                                                    <p class="badge bg-success py-1 quicksand text-white mb-0">
                                                        <i class="fi-rs-gift mr-5"></i> Surprise Gift
                                                    </p>
                                                @endif
                                                <div class="d-flex align-items-center flex-wrap">

                                                    <a href="{{ route('admin.product.edit', $item->getProduct->id) }}"
                                                        title="{{ $item->getProduct->name }}" target="_blank"
                                                        class="me-2">
                                                        {{ $item->getProduct->name }}
                                                    </a>

                                                    <p class="mb-0">(SKU:
                                                        <strong>{{ $item->getProduct->SKU }}</strong>)
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($item->sale_default_price != null || $item->sale_default_price != 0)
                                                    <del>₹{{ number_format($item->regular_price, 2) }}</del>
                                                    @if ($item->is_gift_item == 1)
                                                        <span class="">₹0</span>
                                                    @else
                                                        <span
                                                            class="">₹{{ number_format($item->sale_default_price, 2) }}</span>
                                                    @endif
                                                @else
                                                    @if ($item->is_gift_item == 1)
                                                        <span class="">₹0</span>
                                                    @else
                                                        <span
                                                            class="">₹{{ number_format($item->sale_default_price, 2) }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                x
                                            </td>
                                            <td>
                                                @php
                                                    $total_qunatiyt += $item->quantity;
                                                @endphp
                                                {{ $item->quantity }}
                                            </td>
                                            @if ($item->offer_discount > 0)
                                                <td>
                                                    Offer Discount: <span class="text-success">
                                                        {{ $item->offer_discount }}</span>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>
                                                @if ($item->is_gift_item == 1)
                                                    ₹0
                                                @else
                                                    ₹{{ number_format($item->total, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 offset-md-6">
                                        <table class="table table-vcenter card-table table-borderless text-end">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        Quantity
                                                    </td>
                                                    <td>
                                                        {{ $total_qunatiyt }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Sub amount
                                                    </td>
                                                    <td>
                                                        ₹{{ $order->subtotal }}
                                                    </td>
                                                </tr>
                                                @if ($order->coupon_discount && $order->coupon_discount > 0)
                                                    <tr>
                                                        <td>Coupon Discount</td>
                                                        <td>₹{{ number_format($order->coupon_discount, 2) }}</td>
                                                    </tr>
                                                @endif
                                                @if ($order->total_bonus && $order->total_bonus > 0)
                                                    <tr>
                                                        <td>Bonus(on First Order)</td>
                                                        <td>₹{{ number_format($order->total_bonus, 2) }}</td>
                                                    </tr>
                                                @endif

                                                @if ($order->offer_discount && $order->offer_discount > 0)
                                                    <tr>
                                                        <td>Offer Discount</td>
                                                        <td>₹{{ number_format($order->offer_discount, 2) }}</td>
                                                    </tr>
                                                @endif

                                                @if ($order->gift_card_discount && $order->gift_card_discount > 0)
                                                    <tr>
                                                        <td>Gift Card Discount</td>
                                                        <td>₹{{ number_format($order->gift_card_discount, 2) }}</td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <td>
                                                        Shipping fee
                                                    </td>
                                                    <td>
                                                        @if ($order->is_cod == 1)
                                                            <p>₹{{ number_format($order->shipping_charges - $order->cod_charges, 2) }}
                                                            </p>
                                                        @else
                                                            <p>₹{{ number_format($order->shipping_charges, 2) }}</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if ($order->is_cod == 1)
                                                    <tr>
                                                        <td>
                                                            Cash on delivery charges
                                                        </td>
                                                        <td>
                                                            <p>₹{{ number_format($order->cod_charges, 2) }}</p>
                                                        </td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <td>
                                                        Total amount
                                                    </td>
                                                    <td>
                                                        <span class="text-warning">
                                                            ₹{{ $order->total }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Paid amount
                                                    </td>
                                                    <td>
                                                        <a href="https://shopwise.botble.com/admin/payments/transactions/19"
                                                            target="_blank">
                                                            <span>₹{{ $order->paid_amount }}</span>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Payment status
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $order->status == 0 ? 'bg-warning text-warning-fg' : 'bg-success text-success-fg' }}">
                                                            @if ($order->status == 0)
                                                                Pending
                                                            @else
                                                                Confirmed
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Payment method
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $order->is_cod == 0 ? 'bg-success text-success-fg' : 'bg-info text-info-fg' }}">
                                                            @if ($order->status == 0)
                                                                Remaining
                                                            @else
                                                                @if ($order->is_cod == 1)
                                                                    COD
                                                                @else
                                                                    Online
                                                                @endif
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Ordered Date
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr class="my-0">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        @if ($order->additional_information)
                                            <div class="mb-3 position-relative">
                                                <label class="form-label" for="description">
                                                    Note (from customer at the checkout page)
                                                </label>

                                                <textarea class="form-control textarea-auto-height" name="description" id="description" placeholder="Add note...">{{ $order->additional_information }}</textarea>

                                                <small class="form-hint">Note about order, ex: time or shipping
                                                    instruction. This note is added by customer at the checkout page,
                                                    you should not change it.</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="list-group list-group-flush">
                                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                    <div class="text-uppercase">
                                        <svg class="icon text-success svg-icon-ti-ti-check"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12l5 5l10 -10"></path>
                                        </svg> Order was confirmed
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($order_transaction != null)
                            <div class="card">

                                <div class="crad-header">
                                    <h3 class="m-3">Transaction</h3>
                                </div>

                                <div class="card-table">
                                    <div class="table-responsive table-has-actions table-has-filter">
                                        <table class="table card-table table-vcenter table-striped table-hover"
                                            id="botble-payment-tables-payment-table">
                                            <thead>
                                                <tr>
                                                    <th title="ID" width="20"
                                                        class="text-center no-column-visibility column-key-0">#</th>
                                                    <th title="Charge ID" class="column-key-1">Payment ID</th>
                                                    <th title="Payer Name" class="text-start column-key-2">Payer Name
                                                    </th>
                                                    <th title="Amount" class="text-start column-key-3">Amount</th>
                                                    <th title="Description" class="text-start column-key-3">
                                                        Description</th>
                                                    <th title="Status" class="text-start column-key-5">Status</th>
                                                    <th title="Created At" class="column-key-6">Created At</th>
                                                    <th title="Operations">Operations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td
                                                        class="text-center no-column-visibility column-key-0 sorting_1">
                                                        1</td>
                                                    <td class=" column-key-1"><a
                                                            href="{{ route('admin.transaction.edit', $order_transaction->id) }}"
                                                            target="_blank">{{ $order_transaction->payment_id }}</a>
                                                    </td>
                                                    <td class="column-key-2">{{ $order_transaction->getUser->name }}
                                                    </td>
                                                    <td class="column-key-3">
                                                        ₹{{ number_format($order_transaction->amount) }}</td>
                                                    <td class="column-key-3">{{ $order_transaction->description }}
                                                    </td>
                                                    <td class="column-key-5">
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
                                                    <td class="column-key-6">
                                                        {{ \Carbon\Carbon::parse($order_transaction->created_at)->format('d-m-Y') }}
                                                    </td>
                                                    <td class="no-column-visibility text-nowrap">
                                                        <div class="table-actions">
                                                            <a href="{{ route('admin.transaction.edit', $order_transaction->id) }}"
                                                                target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
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
                                {{-- Updated condition to hide the edit form on final status states --}}
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
                                            <button class="btn btn-primary me-2">Change</button>
                                        </div>
                                        @if ($order->status == 1 && $order->is_cod == 1)
                                            <button type="button" wire:click="sendConfirmationMessage"
                                                class="btn btn-primary mt-2">Send Confirmation message</button>
                                        @endif
                                    </form>
                                @else
                                    <div class="mt-3">
                                        <label for="statusSelect" class="form-label fw-bold">Current Status</label>
                                        @php
                                            // Dynamic mapping to prevent long if/else chains
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
                                        <p class="badge {{ $currentBadge['class'] }}">{{ $currentBadge['name'] }}</p>
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
                                <button wire:click="addLogisticsRow" type="button" class="btn btn-sm btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    Add New
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
                                    <div class="card mb-3 border position-relative group-hover-btn">
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
                                                        <span class="input-group-text">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-barcode"
                                                                width="24" height="24" viewBox="0 0 24 24"
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
                                                        <span class="input-group-text">₹</span>
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
                                        <svg class="icon svg-icon-ti-ti-inbox" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                                            </path>
                                            <path d="M4 13h3l3 3h4l3 -3h3"></path>
                                        </svg> {{ $order->getOrderItems->sum('quantity') }}
                                        order(s)
                                    </p>

                                    <p class="mb-1 fw-semibold">{{ $order->getUser->name }}</p>

                                    <p class="mb-1">
                                        <a href="mailto:{{ $order->getUser->email }}">
                                            {{ $order->getUser->email }}
                                        </a>
                                    </p>

                                    <p class="mb-1">Have an account already</p>
                                </div>

                                <div class="hr my-1"></div>

                                <div class="p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Shipping information</h4>

                                    </div>
                                    @php
                                        $shippAddress = json_decode($order->ship_different_address_details);
                                    @endphp
                                    <dl class="shipping-address-info mb-0">
                                        <dd>{{ $shippAddress->name }}</dd>
                                        <dd>
                                            <a href="tel:+91{{ $shippAddress->mobile }}">
                                                <svg class="icon svg-icon-ti-ti-phone"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                                    </path>
                                                </svg> <span dir="ltr">+91{{ $shippAddress->mobile }}</span>
                                            </a>
                                        </dd>

                                        <dd><a
                                                href="mailto:{{ $shippAddress->email }}">{{ $shippAddress->email }}</a>
                                        </dd>
                                        <dd>
                                            @if ($shippAddress->address_line_1 != '')
                                                {{ $shippAddress->address_line_1 }}
                                                {{ $shippAddress->address_line_2 }}
                                            @endif
                                        </dd>
                                        <dd>{{ $shippAddress->state }} </dd>
                                        <dd>{{ $shippAddress->city }} </dd>
                                        <dd>{{ $shippAddress->zipcode }} </dd>
                                        @php
                                            $addressParts = [];
                                            if (!empty($shippAddress->address_line_1)) {
                                                $addressParts[] = $shippAddress->address_line_1;
                                            } elseif (!empty($shippAddress->address_line_2)) {
                                                $addressParts[] = $shippAddress->address_line_2;
                                            }

                                            $addressParts[] = $shippAddress->city;
                                            $addressParts[] = $shippAddress->state;
                                            $addressParts[] = $shippAddress->zipcode;

                                            $fullAddress = implode(', ', $addressParts);
                                        @endphp

                                        <dd>
                                            <a href="https://maps.google.com/?q={{ urlencode($fullAddress) }}"
                                                target="_blank">
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
</div>
