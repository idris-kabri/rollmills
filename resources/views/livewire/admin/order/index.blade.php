<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{url("/admin")}}">Dashboard</a>
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
                                    <!-- Search -->
                                    <div class="col-md-3">
                                        <label class="form-label">Search</label>
                                        <input type="search" class="form-control" placeholder="Search..." style="min-width: 100px"
                                            wire:model.live.debounce.500ms="search" />
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-md-2">
                                        <label class="form-label text-primary">FormDate:</label>
                                        <input type="date" class="form-control" wire:model.live="formDate" />
                                    </div>

                                    <!-- To Date -->
                                    <div class="col-md-2">
                                        <label class="form-label text-primary">ToDate:</label>
                                        <input type="date" class="form-control" wire:model.live="toDate" />
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-2">
                                        <label class="form-label text-primary">Status:</label>
                                        <select class="form-select" wire:model.live="status">
                                            <option value="">--select--</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Processed</option>
                                            <option value="2">Shipped</option>
                                            <option value="3">Complete</option>
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
                                            NAME/EMAIL
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            SUB TOTAL
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            COUPON DISCOUNT
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            OFFER DISCOUNT
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            GIFT CARD DISCOUNT
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
                                    <tr>
                                        <td>{{$i++}}</td> 
                                        @if($order->getUser)
                                        <td>
                                            {{$order->getUser->name}}<br>
                                            {{$order->getUser->email}}
                                        </td> 
                                        @endif
                                        <td>{{$order->subtotal}}</td>
                                        <td>{{$order->coupon_discount ?? 0}}</td>
                                        <td>{{$order->offer_discount ?? 0}}</td>
                                        <td>{{$order->gift_card_discount ?? 0}}</td>
                                        <td>{{$order->paid_amount}}</td>
                                        <td>
                                            @if($order->is_cod == 1)
                                            <p class="text text-info">COD</p>
                                            @else
                                            <p class="text text-success">Online</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->status == 0)
                                            <p class="text text-warning">Pending</p>
                                            @elseif($order->status == 1)
                                            <p class="text text-warning">Processed..</p>
                                            @elseif($order->status == 2)
                                            <p class="text text-info">Shipped</p>
                                            @elseif($order->status == 3)
                                            <p class="text text-success">Complete</p>
                                            @elseif($order->status == 4)
                                            <p class="text text-danger">Cancelled</p>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('admin.orders.view', $order->id) }}"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">
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
</div>