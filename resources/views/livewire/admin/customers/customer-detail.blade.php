<div>
    <div id="app">
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
                                                href="{{ url('/admin') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                                Customer Detail
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
                    <form method="POST" action="./edit.html" accept-charset="UTF-8"
                        id="botble-ecommerce-forms-customer-form" class="js-base-form dirty-check">
                        <input name="_token" type="hidden" value="5zel3M7QmYmkNbsc4dPXrhcmmwR4KVthTkrQ8W8y" />

                        <div class="row">
                            <div class="col-md-12 gap-3">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <ul data-bs-toggle="tabs" class="nav nav-tabs card-header-tabs">
                                            <li class="nav-item">
                                                <a href="#tabs-detail" class="nav-link active" data-bs-toggle="tab">
                                                    Detail
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="tabs-detail">
                                                <div class="row row-col-lg-2">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3 position-relative">
                                                            <label class="form-label" for="name">
                                                                Name
                                                            </label>

                                                            <input disabled class="form-control" data-counter="120"
                                                                placeholder="Name" name="name" type="text"
                                                                value="Millie Willms" id="name"
                                                                wire:model="name" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3 position-relative">
                                                            <label class="form-label form-label required"
                                                                for="email">
                                                                Email
                                                            </label>

                                                            <input disabled class="form-control" data-counter="60"
                                                                placeholder="e.g: example@domain.com"
                                                                required="required" name="email" type="text"
                                                                value="kcollins@example.net" id="email"
                                                                wire:model="email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 position-relative">
                                                            <label class="form-label" for="private_notes">
                                                                Private notes
                                                            </label>

                                                            <textarea class="form-control" data-counter="10000" rows="2" id="private_notes" name="private_notes"
                                                                cols="50"></textarea>

                                                            <small class="form-hint">
                                                                Private notes are only visible to admins.
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Addresses</h4>
                                    </div>

                                    <div id="address-histories">
                                        <table class="table table-vcenter card-table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Address</th>
                                                    <th>State</th>
                                                    <th>City</th>
                                                    <th>Zipcode</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $i = 1;
                                                @endphp
                                                @foreach($get_address as $address)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td class="text-start">
                                                        @if($address->address_line_1 != null)
                                                        {{$address->address_line_1}}
                                                        @else
                                                        {{$address->address_line_2}}
                                                        @endif
                                                    </td>
                                                    <td>{{$address->state}}</td>
                                                    <td>{{$address->city}}</td>
                                                    <td>{{$address->zipcode}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Wishlist</h4>
                                    </div>

                                    <table class="table table-vcenter card-table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @forelse($get_whislist as $wishlist)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>
                                                    <a href="{{ url('/shop-product-detail/' . $wishlist->id) }}" target="_blank">
                                                        {{$wishlist->name}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($wishlist->model->created_at)->format('jS F Y')}}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr class="text-center text-muted">
                                                <td colspan="7">No data to display</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Cart</h4>
                                    </div>

                                    <table class="table table-vcenter card-table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @forelse($get_cart as $cart)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>
                                                    <a href="{{ url('/shop-product-detail/' . $cart->id) }}" target="_blank">
                                                        {{$cart->name}}
                                                    </a>
                                                </td>
                                                @php
                                                $priceInfo = getPrice($cart->id);
                                                @endphp
                                                <td>
                                                    ₹{{number_format($priceInfo['price'],2)}}
                                                </td>
                                                <td>
                                                    {{$cart->qty}}
                                                </td>
                                                <td>
                                                    @if(!empty($cart->options['discount_price']))
                                                    @php
                                                    $totalOfferDiscountedPrice += $cart->price * $cart->qty - $cart->options['discount_price'];
                                                    @endphp
                                                    <del>₹{{ number_format($cart->price * $cart->qty, 2) }}</del>
                                                    <span class="text-success">
                                                        ₹{{ number_format($cart->options['discount_price'], 2) }}
                                                    </span>
                                                    @else
                                                    ₹{{ number_format($cart->price * $cart->qty, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr class="text-center text-muted">
                                                <td colspan="7">No data to display</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card mb-3 p-3">
                                    <div class="">
                                        <h4 class="card-title">Payments</h4>
                                    </div>

                                    <table id="transaction-table" class="table table-vcenter card-table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Payment ID</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                            $transaction_i = 1;
                                            @endphp
                                            @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction_i++ }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}
                                                </td>
                                                <td>₹{{ number_format($transaction->amount) }}</td>
                                                <td class="text-start">
                                                    <a href="#" target="_blank">
                                                        {{ $transaction->payment_id }}
                                                        <svg class="icon svg-icon-ti-ti-external-link"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                fill="none" />
                                                            <path
                                                                d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                                            <path d="M11 13l9 -9" />
                                                            <path d="M15 4h5v5" />
                                                        </svg>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success text-success-fg">
                                                        {{ $transaction->status == 0 ? 'Pending' : ($transaction->status == 1 ? 'Confirm' : 'Cancel') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-icon btn-sm" type="button" href="#"
                                                        target="_blank" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="View in new tab">
                                                        <svg class="icon icon-sm icon-left svg-icon-ti-ti-external-link"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                fill="none" />
                                                            <path
                                                                d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                                            <path d="M11 13l9 -9" />
                                                            <path d="M15 4h5v5" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Reviews</h4>
                                    </div>

                                    <div>
                                        <div class="table-wrapper">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="btn-list">
                                                        <div class="table-search-input">
                                                            <label><input type="search" class="form-control input-sm"
                                                                    placeholder="Search..." wire:model.live.debounce.500ms="review_search" /></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-table">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table card-table table-vcenter table-striped table-hover"
                                                            id="botble-ecommerce-tables-customer-review-table">
                                                            <thead>
                                                                <tr>
                                                                    <th title="ID" width="20">ID</th>
                                                                    <th title="Product">PRODUCT</th>
                                                                    <th title="User">NAME/EMAIL</th>
                                                                    <th title="Star" width="150">START</th>
                                                                    <th title="Comment">COMMENT</th>
                                                                    <th title="Images" width="150">IMAGE</th>
                                                                    <th title="Status" width="100">STATUS</th>
                                                                    <th title="Created At" width="100">
                                                                        CREATED AT
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                $review_i = 1;
                                                                @endphp
                                                                @forelse($reviews as $review)
                                                                <tr>
                                                                    <td>{{$review_i++}}</td>
                                                                    <td>
                                                                        <a href="{{ url('/shop-product-detail/' . $review->product_id) }}" target="_blank">
                                                                            {{ $review->getProducts->name }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        {{ $review->name }}<br>
                                                                        {{ $review->email }}
                                                                    </td>
                                                                    <td style="min-width: 100px; white-space: nowrap;">
                                                                        @php
                                                                        $rating = round($review->ratings);
                                                                        @endphp

                                                                        <div class="rating_wrap">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($i <=$rating)
                                                                                <i class="fas fa-star" style="color:#F6BC3E;"></i>
                                                                                @else
                                                                                <i class="far fa-star" style="color:#ccc;"></i>
                                                                                @endif
                                                                                @endfor
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        {{$review->remarks}}
                                                                    </td>
                                                                    <td style="min-width: 100px; white-space: nowrap;">
                                                                        @if($review->image)
                                                                        <a href="{{Storage::url($review->image)}}" target="_blank">
                                                                            <img src="{{Storage::url($review->image)}}" alt="" style="height: 100px; width: 100px;">
                                                                        </a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($review->status == 1)
                                                                        <span class="badge bg-success text-success-fg">Publish</span>
                                                                        @else
                                                                        <span class="badge bg-warning text-warning-fg">Not Publish</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ \Carbon\Carbon::parse($review->created_at)->format('jS F Y') }}
                                                                    </td>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Order Product History</h4>
                                    </div>

                                    <div>
                                        <div class="table-wrapper">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="btn-list">
                                                        <div class="table-search-input">
                                                            <label><input type="search" class="form-control input-sm"
                                                                    placeholder="Search..." wire:model.live.debounce.500ms="oredr_search" /></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-table">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table card-table table-vcenter table-striped table-hover"
                                                            id="botble-ecommerce-tables-customer-review-table">
                                                            <thead>
                                                                <tr>
                                                                    <th title="ID" width="20">ID</th>
                                                                    <th title="User">SUB TOTAL</th>
                                                                    <th title="Star">COUPON DISCOUNT</th>
                                                                    <th title="Comment">OFFER DISCOUNT</th>
                                                                    <th title="Images">GIFT CARD DISCOUNT</th>
                                                                    <th title="Images">PAID AMOUNT</th>
                                                                    <th title="Status" width="100">Status</th>
                                                                    <th title="Created At" width="100">
                                                                        Created At
                                                                    </th>
                                                                    <th title="Created At" width="150">
                                                                        ACTION
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                $i = 1;
                                                                @endphp
                                                                @forelse($orders as $order)
                                                                <tr>
                                                                    <td>{{$i++}}</td>

                                                                    <td>{{$order->subtotal}}</td>
                                                                    <td>{{$order->coupon_discount}}</td>
                                                                    <td>{{$order->offer_discount}}</td>
                                                                    <td>{{$order->gift_card_discount}}</td>
                                                                    <td>{{$order->paid_amount}}</td>
                                                                    <td>
                                                                        @if($order->status == 0)
                                                                        <p class="text text-warning">Pending</p>
                                                                        @elseif($order->status == 1)
                                                                        <p class="text text-success">Processed..</p>
                                                                        @elseif($order->status == 2)
                                                                        <p class="text text-success">Shipped</p>
                                                                        @elseif($order->status == 3)
                                                                        <p class="text text-success">Complete</p>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('jS F Y') }}</td>
                                                                    <td><a href="{{ route('admin.orders.view', $order->id) }}" target="_blank"><i class="fa fa-eye"></i></a></td>
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
                                                        {{ $orders->links('pagination::bootstrap-5') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-3 gap-3 d-flex flex-column-reverse flex-md-column mb-md-0 mb-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Publish</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="btn-list">
                                            <button class="btn btn-primary" type="submit" value="apply"
                                                name="submitter">
                                                <svg class="icon icon-left svg-icon-ti-ti-device-floppy"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                    <path d="M14 4l0 4l-6 0l0 -4" />
                                                </svg>
                                                Save
                                            </button>

                                            <button class="btn" type="submit" name="submitter" value="save">
                                                <svg class="icon icon-left svg-icon-ti-ti-transfer-in"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 18v3h16v-14l-8 -4l-8 4v3" />
                                                    <path d="M4 14h9" />
                                                    <path d="M10 11l3 3l-3 3" />
                                                </svg>
                                                Save &amp; Exit
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div data-bb-waypoint data-bb-target="#form-actions"></div>

                                <header class="top-0 w-100 position-fixed end-0 z-1000" id="form-actions"
                                    style="display: none">
                                    <div class="navbar">
                                        <div class="container-xl">
                                            <div class="row g-2 align-items-center w-100">
                                                <div class="col">
                                                    <div class="page-pretitle">
                                                        <nav aria-label="breadcrumb">
                                                            <ol class="breadcrumb"></ol>
                                                        </nav>
                                                    </div>
                                                </div>
                                                <div class="col-auto ms-auto d-print-none">
                                                    <div class="btn-list">
                                                        <button class="btn btn-primary" type="submit" value="apply"
                                                            name="submitter">
                                                            <svg class="icon icon-left svg-icon-ti-ti-device-floppy"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                    fill="none" />
                                                                <path
                                                                    d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                <path d="M14 4l0 4l-6 0l0 -4" />
                                                            </svg>
                                                            Save
                                                        </button>

                                                        <button class="btn" type="submit" name="submitter"
                                                            value="save">
                                                            <svg class="icon icon-left svg-icon-ti-ti-transfer-in"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                    fill="none" />
                                                                <path d="M4 18v3h16v-14l-8 -4l-8 4v3" />
                                                                <path d="M4 14h9" />
                                                                <path d="M10 11l3 3l-3 3" />
                                                            </svg>
                                                            Save &amp; Exit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </header>

                                <div class="card meta-boxes">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <label class="form-label form-label required" for="status">
                                                Status
                                            </label>
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <select class="form-control form-select" required="required"
                                            id="status-select-31490" name="status">
                                            <option value="activated" selected="selected">
                                                Activated
                                            </option>
                                            <option value="locked">Locked</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card meta-boxes">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <label class="form-label" for="avatar">
                                                Avatar
                                            </label>
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="image-box image-box-avatar" action="select-image"
                                            data-counter="250">
                                            <input class="image-data" name="avatar" type="hidden"
                                                value="customers/8.jpg" class="" data-counter="250" />

                                            <div style="width: 8rem" class="preview-image-wrapper mb-1">
                                                <div class="preview-image-inner">
                                                    <a data-bb-toggle="image-picker-choose" data-target="popup"
                                                        class="image-box-actions" data-result="avatar"
                                                        data-action="select-image" data-allow-thumb="1"
                                                        href="#">
                                                        <img class="preview-image"
                                                            data-default="https://shopwise.botble.com/vendor/core/core/base/images/placeholder.png"
                                                            src="https://shopwise.botble.com/storage/customers/8-150x150.jpg"
                                                            alt="Preview image" />
                                                        <span class="image-picker-backdrop"></span>
                                                    </a>
                                                    <button
                                                        class="btn btn-pill btn-icon btn-sm image-picker-remove-button p-0"
                                                        style="--bb-btn-font-size: 0.5rem" type="button"
                                                        data-bb-toggle="image-picker-remove" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Remove image">
                                                        <svg class="icon icon-sm icon-left svg-icon-ti-ti-x"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M18 6l-12 12" />
                                                            <path d="M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <a data-bb-toggle="image-picker-choose" data-target="popup"
                                                data-result="avatar" data-action="select-image" data-allow-thumb="1"
                                                href="#">
                                                Choose image
                                            </a>

                                            <div data-bb-toggle="upload-from-url">
                                                <span class="text-muted">or</span>
                                                <a href="javascript:void(0)" class="mt-1" data-bs-toggle="modal"
                                                    data-bs-target="#image-picker-add-from-url"
                                                    data-bb-target=".image-box-avatar">
                                                    Add from URL
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </form>
                </div>
            </div>

            <footer class="footer position-sticky footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="text-start">
                        <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-between">
                            <div class="order-2 order-lg-1">
                                Copyright 2025 © Fakhri Electric Store.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        $('#transaction-table').DataTable({
            "order": [], // disables initial sorting
            "pageLength": 10 // optional: number of rows per page
        });
    });
</script>
@endsection