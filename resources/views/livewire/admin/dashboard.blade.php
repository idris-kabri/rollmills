<div class="page-wrapper">
    <style>
        .dataTables_length,
        .dataTables_filter,
        .dataTables_info {
            padding: 0.5rem !important;
        }
    </style>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        Dashboard
                                    </h1>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                {{-- <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button class="btn btn-outline-primary manage-widget" type="button" data-bs-toggle="modal"
                            data-bs-target="#widgets-management-modal">
                            <svg class="icon icon-left svg-icon-ti-ti-layout-dashboard"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                                <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                                <path
                                    d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                                <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                            </svg>
                            Manage Widgets
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="page-body page-content">
        <div class="container-xl">
            <div class="row mb-3">

                <div class="col-12 mb-3 mb-lg-2">
                    <div class="row row-cards">
                        <div class="col dashboard-widget-item col-12 col-md-6 col-lg-3">
                            <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none"
                                href="{{ url('admin/orders') }}" style="background-color: #32c5d2" target="_blank">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                        <div class="desc fw-medium">Orders</div>
                                        <div class="number fw-bolder">
                                            <span>{{ $orderCount }}</span>
                                        </div>
                                    </div>
                                    <div class="visual ps-1 position-absolute end-0">
                                        <i class="fas fa-users me-n2 me-n2"
                                            style="opacity: 0.1; --bb-icon-size: 80px"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col dashboard-widget-item col-12 col-md-6 col-lg-3">
                            <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none"
                                href="{{ url('admin/product') }}" style="background-color: #1280f5" target="_blank">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                        <div class="desc fw-medium">Products</div>
                                        <div class="number fw-bolder">
                                            <span>{{ $productCount }}</span>
                                        </div>
                                    </div>
                                    <div class="visual ps-1 position-absolute end-0">
                                        <svg class="icon me-n2 svg-icon-ti-ti-shopping-cart"
                                            style="opacity: 0.1; --bb-icon-size: 80px"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 17h-11v-14h-2" />
                                            <path d="M6 5l14 1l-1 7h-13" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col dashboard-widget-item col-12 col-md-6 col-lg-3">
                            <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none"
                                href="{{ url('admin/customer') }}" style="background-color: #75b6f9" target="_blank">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                        <div class="desc fw-medium">Customers</div>
                                        <div class="number fw-bolder">
                                            <span>{{ $customerCount }}</span>
                                        </div>
                                    </div>
                                    <div class="visual ps-1 position-absolute end-0">
                                        <svg class="icon me-n2 svg-icon-ti-ti-user"
                                            style="opacity: 0.1; --bb-icon-size: 80px"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col dashboard-widget-item col-12 col-md-6 col-lg-3">
                            <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none"
                                href="{{ url('admin/reviews') }}" style="background-color: #074f9d" target="_blank">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                        <div class="desc fw-medium">Reviews</div>
                                        <div class="number fw-bolder">
                                            <span>{{ $reviewCount }}</span>
                                        </div>
                                    </div>
                                    <div class="visual ps-1 position-absolute end-0">
                                        <svg class="icon me-n2 svg-icon-ti-ti-messages"
                                            style="opacity: 0.1; --bb-icon-size: 80px"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                            <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3 mb-lg-2">
                    <div id="list_widgets" class="row row-cards" data-bb-toggle="widgets-list"
                        data-url="">

                        <div class="widget-item col-12 d-flex col-lg-12 mb-3 mb-lg-2" id="widget_analytics_page"
                            data-url="">
                            <div class="card card-sm flex-fill hover-shadow-md shadow-sm rounded-4">
                                <div class="card-header">
                                    <h2 class="mb-0">
                                        Current Date Orders
                                    </h2>
                                </div>
                                <div class="d-flex flex-column justify-content-between h-auto widget-content">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table table-hover table-striped" id="dashboard-current-order-table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        # Order Id
                                                    </th>
                                                    <th>
                                                        User Name/Email
                                                    </th>
                                                    <th class="text-center">
                                                        Paid Amount
                                                    </th>
                                                    <th class="text-end">
                                                        Status
                                                    </th>
                                                    <th class="text-end">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody style="font-size: 14px">
                                                @foreach($current_date_orders as $order)
                                                <tr>
                                                    <td>
                                                        {{$order->id}}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.customer.customer-detail',$order->logged_in_user_id) }}" target="_blank">
                                                            {{$order->getUser->name}}</br>
                                                            {{$order->getUser->email}}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        {{$order->paid_amount}}
                                                    </td>
                                                    <td class="text-end">
                                                        @if($order->status == 0)
                                                        <span class="text text-warning">Pending</span>
                                                        @elseif($order->status == 1)
                                                        <span class="text text-success">Processed..</span>
                                                        @elseif($order->status == 2)
                                                        <span class="text text-success">Shipped</span>
                                                        @elseif($order->status == 3)
                                                        <span class="text text-success">Complete</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-end">
                                                        <a href="{{ route('admin.orders.view', $order->id) }}" target="_blank">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="widget-item col-12 d-flex col-lg-12 mb-3 mb-lg-2" id="widget_posts_recent">
                            <div class="card card-sm flex-fill hover-shadow-md shadow-sm rounded-4">
                                <div class="card-header">
                                    <h2 class="mb-0">
                                        Current Date Register User
                                    </h2>

                                    <div class="card-actions btn-actions"></div>
                                </div>
                                <div class="d-flex flex-column justify-content-between h-auto widget-content">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table table-hover table-striped" id="dashboard-current-user-table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <th>
                                                        Name
                                                    </th>
                                                    <th>
                                                        Email
                                                    </th>
                                                    <th class="text-end">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody style="font-size: 14px">
                                                @php
                                                $i = 1;
                                                @endphp
                                                @foreach($current_register_user as $user)
                                                <tr>
                                                    <td>
                                                        {{$i++}}
                                                    </td>
                                                    <td>
                                                        {{$user->name}}
                                                    </td>
                                                    <td>
                                                        {{$user->email}}
                                                    </td>
                                                    <td class="text-end text-nowrap">
                                                        <a href="{{ route('admin.customer.customer-detail',$user->id) }}" target="_blank">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-item col-12 d-flex col-lg-12 mb-3 mb-lg-2" id="widget_audit_logs">
                            <div class="card card-sm flex-fill hover-shadow-md shadow-sm rounded-4">
                                <div class="card-header">
                                    <h2 class="mb-0">
                                        Current Guest User Register
                                    </h2>

                                    <div class="card-actions btn-actions"></div>
                                </div>
                                <div class="d-flex flex-column justify-content-between h-auto widget-content">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table table-hover table-striped" id="dashboard-current-guest-user-table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <th>
                                                        Name
                                                    </th>
                                                    <th>
                                                        Email
                                                    </th>
                                                    <th class="text-end">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody style="font-size: 14px">
                                                @php
                                                $i = 1;
                                                @endphp
                                                @foreach($current_guest_user_register as $guest_user)
                                                <tr>
                                                    <td>
                                                        {{$i++}}
                                                    </td>
                                                    <td>
                                                        {{$guest_user->name}}
                                                    </td>
                                                    <td>
                                                        {{$guest_user->email}}
                                                    </td>
                                                    <td class="text-end text-nowrap">
                                                        <a href="{{ route('admin.customer.customer-detail',$guest_user->id) }}" target="_blank">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
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
@section('scripts')
<script>
    $(document).ready(function() {
        $('#dashboard-current-order-table').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 100],
            "ordering": true,
            "searching": true,
            "margin": 5
        });
        $('#dashboard-current-user-table').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 100],
            "ordering": true,
            "searching": true
        });
        $('#dashboard-current-guest-user-table').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 100],
            "ordering": true,
            "searching": true
        });

    });
</script>

@endsection