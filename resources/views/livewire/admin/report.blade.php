<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Order & Financial Report
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Filter Options</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">From Date</label>
                            <input type="date" wire:model.live="from_date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">To Date</label>
                            <input type="date" wire:model.live="to_date" class="form-control">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="text-muted small">
                                Showing data from <strong>{{ $from_date ?? '...' }}</strong> to
                                <strong>{{ $to_date ?? '...' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Detailed Breakdown (Website)</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap table-striped table-hover table-bordered">
                        <thead>
                            <tr class="bg-light">
                                <th rowspan="2" class="align-middle text-center w-1">Status</th>
                                <th rowspan="2" class="align-middle text-center">Orders</th>
                                <th colspan="2" class="text-center">Prepaid Metrics</th>
                                <th colspan="3" class="text-center">COD Metrics</th>
                                <th colspan="3" class="text-center">Fees & Commissions</th>
                            </tr>
                            <tr>
                                <th class="text-end">Count</th>
                                <th class="text-end">Amount</th>
                                <th class="text-end">Count</th>
                                <th class="text-end">Remitted</th>
                                <th class="text-end">Pending</th>
                                <th class="text-end">Razorpay</th>
                                <th class="text-end">SC (Cust)</th>
                                <th class="text-end">Real SC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-blue text-blue-fg">Processed</span></td>
                                <td class="text-center fw-bold">{{ $process_orders_array['processed_orders'] }}</td>
                                <td class="text-end">{{ $process_orders_array['prepaid_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($process_orders_array['prepaid_order_revenue'], 2) }}</td>
                                <td class="text-end">{{ $process_orders_array['cod_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($process_orders_array['cod_order_revenue_remitted'], 2) }}</td>
                                <td class="text-end text-warning">
                                    {{ number_format($process_orders_array['cod_order_revenue_not_remitted'], 2) }}</td>
                                <td class="text-end">{{ number_format($process_orders_array['commission'], 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($process_orders_array['sc_taken_from_customer'], 2) }}</td>
                                <td class="text-end">{{ number_format($process_orders_array['real_sc'], 2) }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-yellow text-yellow-fg">Shipped</span></td>
                                <td class="text-center fw-bold">{{ $shipped_orders_array['shipped_orders'] }}</td>
                                <td class="text-end">{{ $shipped_orders_array['prepaid_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($shipped_orders_array['prepaid_order_revenue'], 2) }}</td>
                                <td class="text-end">{{ $shipped_orders_array['cod_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($shipped_orders_array['cod_order_revenue_remitted'], 2) }}</td>
                                <td class="text-end text-warning">
                                    {{ number_format($shipped_orders_array['cod_order_revenue_not_remitted'], 2) }}
                                </td>
                                <td class="text-end">{{ number_format($shipped_orders_array['commission'], 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($shipped_orders_array['sc_taken_from_customer'], 2) }}</td>
                                <td class="text-end">{{ number_format($shipped_orders_array['real_sc'], 2) }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-green text-green-fg">Delivered</span></td>
                                <td class="text-center fw-bold">{{ $delivered_orders_array['delivered_orders'] }}</td>
                                <td class="text-end">{{ $delivered_orders_array['prepaid_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($delivered_orders_array['prepaid_order_revenue'], 2) }}</td>
                                <td class="text-end">{{ $delivered_orders_array['cod_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($delivered_orders_array['cod_order_revenue_remitted'], 2) }}</td>
                                <td class="text-end text-muted">
                                    {{ number_format($delivered_orders_array['cod_order_revenue_not_remitted'], 2) }}
                                </td>
                                <td class="text-end">{{ number_format($delivered_orders_array['commission'], 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($delivered_orders_array['sc_taken_from_customer'], 2) }}</td>
                                <td class="text-end">{{ number_format($delivered_orders_array['real_sc'], 2) }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-red text-red-fg">Cancelled</span></td>
                                <td class="text-center fw-bold">{{ $cancelled_orders_array['cancelled_orders'] }}</td>
                                <td class="text-end">{{ $cancelled_orders_array['prepaid_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($cancelled_orders_array['prepaid_order_revenue'], 2) }}</td>
                                <td class="text-end">{{ $cancelled_orders_array['cod_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($cancelled_orders_array['cod_order_revenue_remitted'], 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($cancelled_orders_array['cod_order_revenue_not_remitted'], 2) }}
                                </td>
                                <td class="text-end">{{ number_format($cancelled_orders_array['commission'], 2) }}
                                </td>
                                <td class="text-end">
                                    {{ number_format($cancelled_orders_array['sc_taken_from_customer'], 2) }}</td>
                                <td class="text-end">{{ number_format($cancelled_orders_array['real_sc'], 2) }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-orange text-orange-fg">Returned</span></td>
                                <td class="text-center fw-bold">{{ $returned_orders_array['returned_orders'] }}</td>
                                <td class="text-end">{{ $returned_orders_array['prepaid_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($returned_orders_array['prepaid_order_revenue'], 2) }}</td>
                                <td class="text-end">{{ $returned_orders_array['cod_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($returned_orders_array['cod_order_revenue_remitted'], 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($returned_orders_array['cod_order_revenue_not_remitted'], 2) }}
                                </td>
                                <td class="text-end">{{ number_format($returned_orders_array['commission'], 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($returned_orders_array['sc_taken_from_customer'], 2) }}</td>
                                <td class="text-end">{{ number_format($returned_orders_array['real_sc'], 2) }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary text-secondary-fg">Lost</span></td>
                                <td class="text-center fw-bold">{{ $lost_orders_array['lost_orders'] }}</td>
                                <td class="text-end">{{ $lost_orders_array['prepaid_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($lost_orders_array['prepaid_order_revenue'], 2) }}</td>
                                <td class="text-end">{{ $lost_orders_array['cod_orders'] }}</td>
                                <td class="text-end">
                                    {{ number_format($lost_orders_array['cod_order_revenue_remitted'], 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($lost_orders_array['cod_order_revenue_not_remitted'], 2) }}</td>
                                <td class="text-end">{{ number_format($lost_orders_array['commission'], 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($lost_orders_array['sc_taken_from_customer'], 2) }}</td>
                                <td class="text-end">{{ number_format($lost_orders_array['real_sc'], 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row row-cards mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Meesho Deductions</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="subheader">Total Deduction Events</div>
                                <div class="ms-auto lh-1">
                                    <span class="text-muted">{{ $meesho_deduction_array['count'] }} entries</span>
                                </div>
                            </div>
                            <div class="h1 mb-3 text-red">{{ number_format($meesho_deduction_array['amount'], 2) }}
                            </div>
                            <div class="text-muted">Total amount deducted by Meesho for penalties, returns, or
                                adjustments.</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Meesho Status Breakdown</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th class="text-end">Orders</th>
                                        <th class="text-end">Remitted</th>
                                        <th class="text-end">Pending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($meesho_orders_array as $status => $data)
                                        <tr>
                                            <td class="text-capitalize">{{ $status }}</td>
                                            <td class="text-end">{{ $data['count'] }}</td>
                                            <td class="text-end">{{ number_format($data['remmitted_amount'], 2) }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($data['going_to_be_remitted_amount'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No Meesho data found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Meesho Product Performance</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th class="text-end">Total Orders</th>
                                <th class="text-end">Items Qty</th>
                                <th class="text-end">Remitted Amount</th>
                                <th class="text-end">Pending Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($meesho_items as $product_name => $data)
                                <tr>
                                    <td class="text-wrap" style="max-width: 300px;">
                                        <span class="fw-medium">{{ $product_name }}</span>
                                    </td>
                                    <td class="text-end">{{ $data['count'] }}</td>
                                    <td class="text-end">{{ $data['items_count'] }}</td>
                                    <td class="text-end text-success">
                                        {{ number_format($data['remmitted_amount'], 2) }}</td>
                                    <td class="text-end text-warning">
                                        {{ number_format($data['going_to_be_remitted_amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted p-4">
                                        No product data available for the selected date range.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
