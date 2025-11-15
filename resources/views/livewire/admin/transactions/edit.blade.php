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
                                        href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        Transaction Detail
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Information</h4>
                            {{-- <div class="card-actions">
                                <a class="btn" type="button"
                                    href="https://shopwise.botble.com/admin/ecommerce/invoices/generate-invoice/20?type=print"
                                    target="_blank">
                                    <svg class="icon icon-left svg-icon-ti-ti-printer"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                        <path
                                            d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                    </svg>
                                    Print Invoice
                                </a>

                                <a class="btn" type="button"
                                    href="https://shopwise.botble.com/admin/ecommerce/invoices/generate-invoice/20?type=download"
                                    target="_blank">
                                    <svg class="icon icon-left svg-icon-ti-ti-download"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                        <path d="M7 11l5 5l5 -5" />
                                        <path d="M12 4l0 12" />
                                    </svg>
                                    Download Invoice
                                </a>
                            </div> --}}
                        </div>

                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Payment ID</div>
                                    <div class="datagrid-content">{{ $transaction->payment_id }}</div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Payer Name</div>
                                    <div class="datagrid-content">
                                        <div class="d-flex align-items-center">
                                            {{ $transaction->getUser->name }}
                                        </div>
                                    </div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Email</div>
                                    <div class="datagrid-content">
                                        <span>
                                            {{ $transaction->getUser->email }}
                                        </span>
                                    </div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Total</div>
                                    <div class="datagrid-content">₹{{ number_format($transaction->amount) }}</div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Created At</div>
                                    <div class="datagrid-content">
                                        {{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}
                                    </div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Status</div>
                                    <div class="datagrid-content">
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
                                    </div>
                                </div>
                            </div>
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
                        <span class="fw-medium">1.41.2</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
