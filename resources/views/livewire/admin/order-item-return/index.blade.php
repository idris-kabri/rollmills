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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Orders Return</h1>
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
                        <div class="container-fluid">
                            <div class="row g-2 align-items-end">

                                <!-- Search -->
                                <div class="col-md-3">
                                    <label class="form-label">Search</label>
                                    <input type="search" class="form-control" placeholder="Search..."
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
                                        <option value="1">Accepted</option>
                                        <option value="2">Received</option>
                                        <option value="3">Approved</option>
                                        <option value="4">Rejected</option>
                                    </select>
                                </div>

                                <!-- Button aligned to right -->
                                <div class="col-md-3 text-end">
                                    <a class="btn action-item btn-primary"
                                        href="{{ route('admin.order-return.create') }}">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
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
                                        $i = 1;
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
                                            PRODUCT NAME
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            REASON
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            REMARKS
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
                                    @forelse($orderReturns as $orderReturn)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <a href="{{ route('admin.customer.customer-detail', $orderReturn->fetchCustomer->id) }}"
                                                    target="_blank">
                                                    {{ $orderReturn->fetchCustomer->name }}<br>
                                                    {{ $orderReturn->fetchCustomer->mobile }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.product.edit', $orderReturn->fetchOrderItem->getProduct->id) }}"
                                                    target="_blank">
                                                    {{ $orderReturn->fetchOrderItem->getProduct->name }}
                                                </a>
                                            </td>
                                            <td>{{ $orderReturn->reason }}</td>
                                            <td>{{ $orderReturn->remarks }}</td>
                                            <td>
                                                @if ($orderReturn->status == 0)
                                                    <p class="text text-warning">Pending</p>
                                                @elseif($orderReturn->status == 1)
                                                    <p class="text text-info">Accepted</p>
                                                @elseif($orderReturn->status == 2)
                                                    <p class="text text-info">Received</p>
                                                @elseif($orderReturn->status == 3)
                                                    <p class="text text-success">Approved</p>
                                                @elseif($orderReturn->status == 4)
                                                    <p class="text text-danger">Rejected</p>
                                                @endif
                                            </td>
                                            <td><a href="{{ route('admin.order-return.view', $orderReturn->id) }}"><i
                                                        class="fa fa-eye"></i></a></td>
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
                            {{ $orderReturns->links() }}
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
