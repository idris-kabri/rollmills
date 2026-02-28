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
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Orders</h1>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body page-content">
        <div class="container-xl">
            <div class="table-wrapper">
                <div class="card has-actions has-filter">
                    <div class="card-header">
                        <div class="w-100 justify-content-between d-flex flex-wrap align-items-center gap-1">
                            <div class="container-fluid">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label">Search</label>
                                        <input type="search" class="form-control" placeholder="Search..."
                                            style="min-width: 100px" wire:model.live.debounce.500ms="search" />
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label text-primary">FormDate:</label>
                                        <input type="date" class="form-control" wire:model.live="formDate" />
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label text-primary">ToDate:</label>
                                        <input type="date" class="form-control" wire:model.live="toDate" />
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label text-primary">Status:</label>
                                        <select class="form-select" wire:model.live="status">
                                            <option value="">--select--</option>
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
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-table">
                        <div class="table-responsive table-has-actions table-has-filter">
                            <table class="table card-table table-vcenter table-striped table-hover"
                                id="botble-ecommerce-tables-products-categories-table">
                                <thead>
                                    @php
                                        $i = ($orders->currentPage() - 1) * $orders->perPage() + 1;
                                    @endphp
                                    <tr>
                                        <th title="ID" width="20"
                                            class="text-center no-column-visibility column-key-0">
                                            ID
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            NAME/MOBILE
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            SUB TOTAL
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            COUPON DISCOUNT
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            ORDER TOTAL
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            PAID AMOUNT
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            PAYMENT METHOD
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            STATUS
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            ACTION
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        {{-- 
                                            LOGIC TO GENERATE TOOLTIP CONTENT
                                            Make sure your Order model has 'items' or 'orderItems' relationship loaded.
                                        --}}
                                        @php
                                            $tooltipContent =
                                                "<div class='text-start fw-bold mb-1'>Order Items:</div><ul class='ps-3 mb-0 text-start'>";
                                            // CHECK: Replace '$order->items' with your actual relationship (e.g., $order->orderItems)
                                            if ($order->getOrderItems && $order->getOrderItems->count() > 0) {
                                                foreach ($order->getOrderItems as $item) {
                                                    // Assumes item has product_name and qty
                                                    $name = $item->getProduct->name ?? 'Unknown Item';
                                                    $qty = $item->qty ?? 1;
                                                    $tooltipContent .= "<li>{$name} (x{$qty})</li>";
                                                }
                                            } else {
                                                $tooltipContent .= '<li>No items found</li>';
                                            }
                                            $tooltipContent .= '</ul>';
                                        @endphp

                                        {{-- ADDED TOOLTIP ATTRIBUTES HERE --}}
                                        <tr data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                            title="{{ $tooltipContent }}" style="cursor: pointer;">
                                            <td>{{ $i++ }}</td>
                                            @if ($order->getUser)
                                                <td>
                                                    {{ $order->getUser->name }}<br>
                                                    {{ $order->getUser->mobile }}
                                                </td>
                                            @endif
                                            <td>{{ $order->subtotal }}</td>
                                            <td>{{ $order->coupon_discount ?? 0 }}</td>
                                            <td>{{ $order->total ?? 0 }}</td>
                                            <td>{{ $order->paid_amount }}</td>
                                            <td>
                                                @if ($order->is_cod == 1)
                                                    <p class="text text-info mb-0">COD</p>
                                                @else
                                                    <p class="text text-success mb-0">Online</p>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    // Mapping array for clean and dynamic status output
                                                    $statusMap = [
                                                        0 => ['name' => 'Pending', 'class' => 'text-warning'],
                                                        1 => ['name' => 'Processed', 'class' => 'text-primary'],
                                                        2 => ['name' => 'Shipped', 'class' => 'text-info'],
                                                        3 => ['name' => 'Complete', 'class' => 'text-success'],
                                                        4 => ['name' => 'Cancelled', 'class' => 'text-danger'],
                                                        5 => ['name' => 'Return', 'class' => 'text-danger'],
                                                        6 => ['name' => 'Lost', 'class' => 'text-secondary'],
                                                        7 => ['name' => 'OFD', 'class' => 'text-purple'], // Custom class if you have it, else fallback to text-primary
                                                        8 => ['name' => 'Return Initiated', 'class' => 'text-warning'],
                                                        9 => ['name' => 'Undelivered', 'class' => 'text-dark'],
                                                        10 => ['name' => 'Rejected', 'class' => 'text-danger'],
                                                    ];
                                                    $currentStatus = $statusMap[$order->status] ?? [
                                                        'name' => 'Unknown',
                                                        'class' => 'text-muted',
                                                    ];
                                                @endphp
                                                <p class="text {{ $currentStatus['class'] }} mb-0 fw-bold">
                                                    {{ $currentStatus['name'] }}
                                                </p>
                                            </td>
                                            {{-- Use stopPropagation to prevent row click when clicking action button --}}
                                            <td onclick="event.stopPropagation()">
                                                <a href="{{ route('admin.orders.view', $order->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">
                                                <p class="text-center">No Data!</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer position-sticky footer-transparent d-print-none">
        <div class="container-xl">
            <div class="text-start">
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-between">
                    <div class="order-2 order-lg-1">
                        Copyright 2025 © Roll Mills Store.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize tooltips on initial page load
            initTooltips();

            // Re-initialize tooltips after Livewire updates the DOM (search, paginate, filter)
            document.addEventListener('livewire:updated', function() {
                initTooltips();
            });
        });

        function initTooltips() {
            // Disposes existing tooltips to prevent duplication ghosts
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

            // Check if bootstrap is defined (Standard in most Laravel/Admin templates)
            if (typeof bootstrap !== 'undefined') {
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    // Get existing instance
                    var existingTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                    if (existingTooltip) {
                        existingTooltip.dispose();
                    }
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }
    </script>

    <style>
        /* Optional: Improves tooltip readability for lists */
        .tooltip-inner {
            max-width: 350px !important;
            /* Wider tooltip for product lists */
            text-align: left !important;
        }

        /* Fallback color classes if they don't exist in your theme */
        .text-purple {
            color: #6f42c1 !important;
        }

        .text-orange {
            color: #fd7e14 !important;
        }
    </style>
</div>
