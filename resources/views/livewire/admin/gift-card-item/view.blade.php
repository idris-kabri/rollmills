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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        Gift Card Item Details
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
                    <div class="card shadow rounded-4 border-2">
                        <div class="card-header justify-content-between">
                            <h1 class="mb-0">Gift Card Item Details </h1>
                        </div>

                        <div class="card-body py-4 px-4">


                            {{-- User Details --}}
                            <div class="row mt-4"> 
                                @if($order)
                                <div class="col-md-4">

                                    <div class="px-3 py-4">
                                        <h6 class="fw-bold bb-section-title mb-3 pb-3">Order Id &nbsp; : &nbsp;
                                            <span class="fw-bold">{{ $order->id }}</span>
                                        </h6>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Name &nbsp; : &nbsp;</strong>
                                            <a class="order-return-hover"
                                                href="{{ route('admin.customer.customer-detail', $order->getUser->id) }}" target="_blank">{{ $order->getUser->name }}
                                            </a>
                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Email &nbsp; :
                                                &nbsp;</strong>
                                            <a class="order-return-hover"
                                                href="{{ route('admin.customer.customer-detail', $order->getUser->id) }}" target="_blank">
                                                {{ $order->getUser->email }}
                                            </a>
                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Gift card Discount &nbsp; :
                                                &nbsp;</strong>
                                            {{ $order->gift_card_discount }}

                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Paid Amount &nbsp; :
                                                &nbsp;</strong>
                                            {{ $order->paid_amount }}

                                        </p>
                                        <p>
                                            <a href="{{ route('admin.orders.view', $order->id) }}" target="_blank"
                                                class="text-secondary fs-15 order-return-hover fw-bold text-decoration-none">
                                                Order Id Details
                                                <i class="fas fa-arrow-up-right-from-square ms-1"></i> </a>
                                        </p>
                                    </div>
                                </div> 
                                @endif

                                <div class="col-md-8">

                                    <div class="px-3 py-4">
                                        <h6 class="fw-bold bb-section-title mb-3 pb-3">Gift Card Title &nbsp; : &nbsp;
                                            <span class="fw-bold">{{ $gift_card_item->title }}</span>
                                        </h6>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Code &nbsp; : &nbsp;</strong>
                                            <span class="order-return-hover text-primary">{{ $gift_card_item->gift_code }}</span>
                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Used At &nbsp; :
                                                &nbsp;</strong>
                                            <span class="order-return-hover text-primary">
                                                {{ \Carbon\Carbon::parse($gift_card_item->used_at)->format('Y-m-d H:i:s') }}
                                            </span>
                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Gift card Group Price &nbsp; :
                                                &nbsp;</strong>
                                            <span class="order-return-hover text-primary">
                                                {{ $gift_card_item->getGiftCardGroupId->price }}
                                            </span>

                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-9">
                        <div class="row">
                            <div class="col dashboard-widget-item col-12 col-md-6 col-lg-4">
                                <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none"
                                    href="#" style="background-color: #1280f5">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                            <div class="desc fw-medium">Total User Use</div>
                                            <div class="number fw-bolder">
                                                <p>{{ $total_user_count }}</p>
            </div>
        </div>
        <div class="visual ps-1 position-absolute end-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                viewBox="0 0 24 24" fill="currentColor" role="img"
                aria-labelledby="title-users-solid"
                style="opacity: 0.1; --bb-icon-size: 80px">
                <title id="title-users-solid">Users</title>
                <path d="M16 11a4 4 0 1 0-8 0 4 4 0 0 0 8 0z" />
                <path d="M2 20c0-2.2 2.7-4 6-4h8c3.3 0 6 1.8 6 4v1H2v-1z" />
            </svg>

        </div>
    </div>
    </a>
</div>
<div class="col dashboard-widget-item col-12 col-md-6 col-lg-4">
    <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none"
        href="#" style="background-color: #12dbf5ff">
        <div class="d-flex justify-content-between align-items-center">
            <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                <div class="desc fw-medium">Total Order Amount</div>
                <div class="number fw-bolder">
                    <p>{{ $total_order_amount }}</p>
                </div>
            </div>
            <div class="visual ps-1 position-absolute end-0">
                <svg xmlns="http://www.w3.org/2000/svg"
                    style="opacity: 0.1; --bb-icon-size: 80px" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="icon icon-order">
                    <!-- Receipt/order sheet -->
                    <path d="M6 2h12a2 2 0 0 1 2 2v18l-4-2-4 2-4-2-4 2V4a2 2 0 0 1 2-2z" />
                    <!-- Order lines -->
                    <line x1="8" y1="7" x2="16" y2="7" />
                    <line x1="8" y1="11" x2="16" y2="11" />
                    <line x1="8" y1="15" x2="13" y2="15" />
                </svg>

            </div>
        </div>
    </a>
</div>
<div class="col dashboard-widget-item col-12 col-md-6 col-lg-4">
    <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none"
        href="#" style="background-color: #2ce6b7ab">
        <div class="d-flex justify-content-between align-items-center">
            <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                <div class="desc fw-medium">Total Discount Amount</div>
                <div class="number fw-bolder">
                    <p>{{ $total_discount_amount }}</p>
                </div>
            </div>
            <div class="visual ps-1 position-absolute end-0">
                <!-- Total Discount Amount -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    style="opacity: 0.1; --bb-icon-size: 80px" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-total-discount" role="img"
                    aria-labelledby="title-total-discount">

                    <!-- tag shape -->
                    <path d="M3 11l8-8 9 9-8 8L3 11z" />
                    <!-- hole in tag -->
                    <circle cx="11.5" cy="3.5" r="1" fill="currentColor"
                        stroke="none" />
                    <!-- percent sign -->
                    <circle cx="9.5" cy="9.5" r="1" />
                    <circle cx="15.5" cy="15.5" r="1" />
                    <path d="M10.7 10.7l5.6 5.6" />
                </svg>

            </div>
        </div>
    </a>
</div>
</div>

<div class="table-responsive table-has-actions table-has-filter mt-5">
    <table class="table card-table table-vcenter table-striped table-hover">
        <thead>
            <tr>
                <th>Order id</th>
                <th>User Name / Email</th>
                <th>Offer Discount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user_orders as $order)
            <tr>
                <td>
                    <a href="{{ route('admin.orders.view', $order->id) }}" target="_blank">
                        {{ $order->id }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('admin.customer.customer-detail', $order->getUser->id) }}"
                        target="_blank">
                        {{ $order->getUser->name }}<br>
                        {{ $order->getUser->email }}
                    </a>
                </td>
                <td>
                    {{ $order->offer_discount }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div> --}}
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