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
                                        href="{{ route("admin.dashboard") }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        Transaction
                                    </h1>
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
                            <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-1">
                                <div class="table-search-input">
                                    <label>
                                        <input type="search" class="form-control input-sm" placeholder="Search..."
                                            style="min-width: 120px" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-table">
                        <div class="table-responsive table-has-actions table-has-filter">
                            <table class="table card-table table-vcenter table-striped table-hover"
                                id="botble-payment-tables-payment-table">
                                <thead>
                                    <tr>
                                        <th title="ID" width="20"
                                            class="text-center no-column-visibility column-key-0">
                                            ID
                                        </th>
                                        <th title="Charge ID" class="column-key-1">
                                            Payment ID
                                        </th>
                                        <th title="Payer Name" class="text-start column-key-2">
                                            Payer Name
                                        </th>
                                        <th title="Amount" class="text-start column-key-3">
                                            Amount
                                        </th>
                                        <th title="Status" class="text-start column-key-5">
                                            Status
                                        </th>
                                        <th title="Created At" class="column-key-6">
                                            Created At
                                        </th>
                                        <th title="Operations">Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td class="text-center no-column-visibility column-key-0 sorting_1">
                                                {{ $transactions->firstItem() + $loop->index }}</td>
                                            <td class="   column-key-1"><a href="{{ route('admin.transaction.edit',$transaction->id) }}">{{ $transaction->payment_id }}</a>
                                            </td>
                                            <td class="column-key-2">{{ $transaction->getUser->name }}</td>
                                            <td class="column-key-3">₹{{ number_format($transaction->amount) }}</td>
                                            <td class="column-key-5">
                                                @if ($transaction->status === 0)
                                                    <span class="badge bg-warning text-warning-fg">
                                                        Pending
                                                    </span>
                                                @elseif($transaction->status === 1)
                                                    <span class="badge bg-success text-success-fg">
                                                        Confirm
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger text-danger-fg">
                                                        Cancel
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="column-key-6">
                                                {{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}
                                            </td>
                                            <td class="no-column-visibility text-nowrap">
                                                <div class="table-actions">
                                                    <a href="{{ route('admin.transaction.edit',$transaction->id) }}">
                                                        <i class="fa fa-eye"></i>
                                                        <span class="sr-only">Edit</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        Copyright 2025 © Fakhri Electric Store.
                        <span class="fw-medium">1.41.2</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
