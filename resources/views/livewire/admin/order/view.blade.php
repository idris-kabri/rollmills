<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1" href="{{url('/admin')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Ecommerce</h1>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1" href="{{route('admin.orders.index')}}">Orders</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Order #EF-{{$order->id}}</h1>
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
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 6v6l4 2"></path>
                                    </svg>
                                    Pending
                                </span>
                                @break

                                @case(1)
                                <span class="badge bg-primary text-white d-flex align-items-center gap-1">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 12h18"></path>
                                        <path d="M3 6h18"></path>
                                        <path d="M3 18h18"></path>
                                    </svg>
                                    Processed
                                </span>
                                @break

                                @case(2)
                                <span class="badge bg-info text-white d-flex align-items-center gap-1">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 7H2v10h20V7z"></path>
                                        <path d="M7 7V4h10v3"></path>
                                    </svg>
                                    Shipped
                                </span>
                                @break

                                @case(3)
                                <span class="badge bg-success text-white d-flex align-items-center gap-1">
                                    <svg class="icon svg-icon-ti-ti-shopping-cart-check" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M11.5 17h-5.5v-14h-2"></path>
                                        <path d="M6 5l14 1l-1 7h-13"></path>
                                        <path d="M15 19l2 2l4 -4"></path>
                                    </svg>
                                    Completed
                                </span>
                                @break
                                @endswitch

                            </div>

                            <table class="table table-vcenter card-table order-products-table">
                                <tbody>
                                    @php
                                    $total_qunatiyt = 0;
                                    @endphp
                                    @foreach($order->getOrderItems as $item)
                                    <tr>
                                        <td style="width: 80px">
                                            <img src="{{Storage::url($item->getProduct->featured_image)}}" alt="{{$item->getProduct->name}}">
                                        </td>
                                        <td style="width: 45%" class="text-start">
                                            @if($item->is_gift_item == 1)
                                            <p class="badge bg-success py-1 quicksand text-white mb-0">
                                                <i class="fi-rs-gift mr-5"></i> Surprise Gift
                                            </p>
                                            @endif
                                            <div class="d-flex align-items-center flex-wrap">

                                                <a href="{{route('admin.product.edit',$item->getProduct->id)}}" title="{{$item->getProduct->name}}" target="_blank" class="me-2">
                                                    {{$item->getProduct->name}}
                                                </a>

                                                <p class="mb-0">(SKU: <strong>{{$item->getProduct->SKU}}</strong>)</p>
                                            </div>
                                        </td>
                                        <td>
                                            @if($item->sale_default_price != null || $item->sale_default_price != 0)
                                            <del>₹{{number_format($item->regular_price,2)}}</del>
                                            @if($item->is_gift_item == 1)
                                            <span class="">₹0</span>
                                            @else 
                                            <span class="">₹{{number_format($item->sale_default_price,2)}}</span>
                                            @endif
                                            @else
                                            @if($item->is_gift_item == 1)
                                            <span class="">₹0</span>
                                            @else 
                                            <span class="">₹{{number_format($item->sale_default_price,2)}}</span>
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
                                            {{$item->quantity}}
                                        </td>
                                        @if($item->offer_discount > 0)
                                        <td>
                                            Offer Discount: <span class="text-success"> {{$item->offer_discount}}</span>
                                        </td>
                                        @else
                                        <td></td>
                                        @endif
                                        <td> 
                                            @if($item->is_gift_item == 1)
                                                ₹0
                                            @else
                                                ₹{{number_format($item->total,2)}}
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
                                                        {{$total_qunatiyt}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Sub amount
                                                    </td>
                                                    <td>
                                                        ₹{{$order->subtotal}}
                                                    </td>
                                                </tr>
                                                @if($order->coupon_discount && $order->coupon_discount > 0)
                                                <tr>
                                                    <td>Coupon Discount</td>
                                                    <td>₹{{ number_format($order->coupon_discount, 2) }}</td>
                                                </tr>
                                                @endif
                                                @if($order->total_bonus && $order->total_bonus > 0)
                                                <tr>
                                                    <td>Bonus(on First Order)</td>
                                                    <td>₹{{ number_format($order->total_bonus, 2) }}</td>
                                                </tr>
                                                @endif

                                                @if($order->offer_discount && $order->offer_discount > 0)
                                                <tr>
                                                    <td>Offer Discount</td>
                                                    <td>₹{{ number_format($order->offer_discount, 2) }}</td>
                                                </tr>
                                                @endif

                                                @if($order->gift_card_discount && $order->gift_card_discount > 0)
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
                                                        @if($order->is_cod == 1)
                                                        <p>₹{{ number_format($order->shipping_charges - $order->cod_charges, 2) }}</p>
                                                        @else
                                                        <p>₹{{ number_format($order->shipping_charges, 2) }}</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($order->is_cod == 1)
                                                <tr>
                                                    <td>
                                                        Cash on delivery charges
                                                    </td>
                                                    <td>
                                                        <p>₹{{ number_format($order->cod_charges, 2) }}</p>
                                                    </td>
                                                </tr>
                                                @endif

                                                {{--<tr>
                                                    <td>
                                                        <p class="mb-1">Shipping fee</p>
                                                        <span class="small d-block">Free delivery</span>
                                                        <span class="small d-block">10,108 grams</span>
                                                    </td>
                                                    <td>
                                                        $0.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tax
                                                    </td>
                                                    <td>
                                                        $180.50
                                                    </td>
                                                </tr>--}}

                                                <tr>
                                                    <td>
                                                        Total amount
                                                    </td>
                                                    <td>
                                                        <span class="text-warning">
                                                            ₹{{$order->total}}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Paid amount
                                                    </td>
                                                    <td>
                                                        <a href="https://shopwise.botble.com/admin/payments/transactions/19" target="_blank">
                                                            <span>₹{{$order->paid_amount}}</span>
                                                        </a>
                                                    </td>
                                                </tr>

                                                {{--<tr>
                                                    <td>
                                                        Payment method
                                                    </td>
                                                    <td>
                                                        <a href="https://shopwise.botble.com/admin/payments/transactions/19" target="_blank">
                                                            Cash on delivery (COD)

                                                            <svg class="icon  svg-icon-ti-ti-external-link" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"></path>
                                                                <path d="M11 13l9 -9"></path>
                                                                <path d="M15 4h5v5"></path>
                                                            </svg> </a>
                                                    </td>
                                                </tr>--}}

                                                <tr>
                                                    <td>
                                                        Payment status
                                                    </td>
                                                    <td>
                                                        <span class="badge {{$order->status == 0 ? 'bg-warning text-warning-fg' : 'bg-success text-success-fg'}}">
                                                            @if($order->status == 0 )
                                                            Pending
                                                            @else
                                                            confirmed
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Payment method
                                                    </td>
                                                    <td>
                                                        <span class="badge {{$order->is_cod == 0 ? 'bg-success text-success-fg' : 'bg-info text-info-fg'}}">
                                                            @if($order->status == 0)
                                                            Remaining
                                                            @else
                                                            @if($order->is_cod == 1)
                                                            COD
                                                            @else
                                                            Online
                                                            @endif
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr class="my-0">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- invoice print  -->
                                        {{--<div class="btn-list justify-content-end my-3">
                                            <a class="btn" type="button" href="https://shopwise.botble.com/admin/ecommerce/orders/generate-invoice/19?type=print" target="_blank">
                                                <svg class="icon icon-left svg-icon-ti-ti-printer" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                                                </svg>
                                                Print invoice

                                            </a>
                                            <a class="btn" type="button" href="https://shopwise.botble.com/admin/ecommerce/orders/generate-invoice/19" target="_blank">
                                                <svg class="icon icon-left svg-icon-ti-ti-download" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                    <path d="M7 11l5 5l5 -5"></path>
                                                    <path d="M12 4l0 12"></path>
                                                </svg>
                                                Download invoice

                                            </a>
                                        </div>--}}

                                        @if($order->additional_information)
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="description">
                                                Note (from customer at the checkout page)


                                            </label>

                                            <textarea class="form-control textarea-auto-height" name="description" id="description" placeholder="Add note...">{{$order->additional_information}}</textarea>

                                            <small class="form-hint">Note about order, ex: time or shipping instruction. This note is added by customer at the checkout page, you should not change it.</small>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="list-group list-group-flush">
                                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                    <div class="text-uppercase">
                                        <svg class="icon text-success svg-icon-ti-ti-check" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12l5 5l10 -10"></path>
                                        </svg> Order was confirmed
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($order_transaction != null)
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
                                                    class="text-center no-column-visibility column-key-0">
                                                    #
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
                                                <th title="Description" class="text-start column-key-3">
                                                    Description
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
                                            <tr>
                                                <td class="text-center no-column-visibility column-key-0 sorting_1">
                                                    1
                                                </td>
                                                <td class="   column-key-1"><a href="{{ route('admin.transaction.edit',$order_transaction->id) }}" target="_blank">{{ $order_transaction->payment_id }}</a>
                                                </td>
                                                <td class="column-key-2">{{ $order_transaction->getUser->name }}</td>
                                                <td class="column-key-3">₹{{ number_format($order_transaction->amount) }}</td>
                                                <td class="column-key-3">{{ $order_transaction->description }}</td>
                                                <td class="column-key-5">
                                                    @if ($order_transaction->status === 0)
                                                    <span class="badge bg-warning text-warning-fg">
                                                        Pending
                                                    </span>
                                                    @elseif($order_transaction->status === 1)
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
                                                    {{ \Carbon\Carbon::parse($order_transaction->created_at)->format('d-m-Y') }}
                                                </td>
                                                <td class="no-column-visibility text-nowrap">
                                                    <div class="table-actions">
                                                        <a href="{{ route('admin.transaction.edit',$order_transaction->id) }}" target="_blank">
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
                                @if ($order->status !== 3 && $order->status !== 4)
                                <form wire:submit.prevent="orderStatusChange" class="mb-2">

                                    <div class="">
                                        <label for="statusSelect" class="form-label fw-bold">Change Status:</label>
                                        <select wire:model="status" id="statusSelect" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="1">Processed</option>
                                            <option value="2">Shipped</option>
                                            <option value="3">Complete</option>
                                            <option value="4">Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-center mt-3">
                                        <button class="btn btn-primary">Change</button>
                                    </div>
                                </form>
                                @else
                                <div class="mt-3">
                                    <label for="statusSelect" class="form-label fw-bold">Status</label>
                                    @if ($order->status == 2)
                                    <p class="badge bg-info text-white">Shipped</p>
                                    @elseif($order->status == 3)
                                    <p class="badge bg-success text-white">Complete</p>
                                    @elseif($order->status == 4)
                                    <p class="badge bg-danger text-white">Cancelled</p>
                                    @endif
                                </div>
                                @endif
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
                                        <svg class="icon  svg-icon-ti-ti-inbox" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                            <path d="M4 13h3l3 3h4l3 -3h3"></path>
                                        </svg> {{$order->getOrderItems->sum('quantity')}}
                                        order(s)
                                    </p>

                                    <p class="mb-1 fw-semibold">{{$order->getUser->name}}</p>

                                    <p class="mb-1">
                                        <a href="mailto:{{$order->getUser->email}}">
                                            {{$order->getUser->email}}
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
                                        <dd>{{$shippAddress->name}}</dd>
                                        <dd>
                                            <a href="tel:+91{{$shippAddress->mobile}}">
                                                <svg class="icon  svg-icon-ti-ti-phone" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                                </svg> <span dir="ltr">+91{{$shippAddress->mobile}}</span>
                                            </a>
                                        </dd>

                                        <dd><a href="mailto:{{$shippAddress->email}}">{{$shippAddress->email}}</a></dd>
                                        <dd>
                                            @if($shippAddress->address_line_1 != '')
                                            {{$shippAddress->address_line_1}}
                                            {{$shippAddress->address_line_2}}
                                            @endif
                                        </dd>
                                        <dd>{{$shippAddress->state}} </dd>
                                        <dd>{{$shippAddress->city}} </dd>
                                        <dd>{{$shippAddress->zipcode}} </dd>
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
                                            <a href="https://maps.google.com/?q={{ urlencode($fullAddress) }}" target="_blank">
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