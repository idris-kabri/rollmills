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
                                    <a class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{ url('/admin/order-return') }}">Orders Return</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Orders Return View</h1>
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
                <div class="col-md-9">
                    <div class="card shadow rounded-4 border-2">
                        <div class="card-header justify-content-between">
                            <h1 class="mb-0">Order Return Request</h1>
                            @php
                                $status = '';
                                $class = '';
                                if ($orderRetrun->status == 0) {
                                    $status = 'Pending';
                                    $class = 'warning';
                                }elseif ($orderRetrun->status == 1) {
                                    $status = 'Accepted';
                                    $class = 'info';
                                }elseif ($orderRetrun->status == 2) {
                                    $status = 'Received';
                                    $class = 'info';
                                }elseif ($orderRetrun->status == 3) {
                                    $status = 'Approved';
                                    $class = 'success';
                                } else {
                                    $status = 'Reject';
                                    $class = 'danger';
                                }
                            @endphp
                            <span class="badge bg-{{ $class }} text-white d-flex align-items-center gap-1"><i
                                    class="fas fa-bars"></i> {{ ucfirst($status) }}</span>
                        </div>

                        <div class="card-body row gy-4">
                            {{-- User Details --}}
                            <div class="col-md-6">
                                <a href="{{ route('admin.customer.customer-detail', $orderRetrun->fetchCustomer->id) }}"
                                    target="_blank" class="text-decoration-none">
                                    <div class="px-3 py-4">
                                        <h6 class="fw-bold bb-section-title mb-3 pb-3">User Details</h6>
                                        <p class="mb-2 text-dark fs-15 order-return-hover"><strong
                                                class="text-secondary">Name &nbsp; :
                                                &nbsp;</strong>
                                            {{ $orderRetrun->fetchCustomer->name ?? 'N/A' }}</p>
                                        <p class="mb-2 text-dark fs-15 order-return-hover"><strong
                                                class="text-secondary">Email &nbsp; :
                                                &nbsp;</strong>
                                            {{ $orderRetrun->fetchCustomer->email ?? 'N/A' }}</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.product.edit', $orderRetrun->fetchOrderItem->getProduct->id) }}"
                                    target="_blank" class="text-decoration-none">
                                    <div class="px-3 py-4">
                                        <h6 class="fw-bold bb-section-title mb-3 pb-3">Product Details: </h6>
                                        <p class="text-dark fs-15 order-return-hover mb-2"><strong
                                                class="text-secondary">Name &nbsp; :
                                                &nbsp;</strong>
                                            {{ $orderRetrun->fetchOrderItem->getProduct->name ?? 'N/A' }}</p>
                                        <p class="text-dark fs-15 mb-2"><strong
                                                class="text-secondary">Reason &nbsp; : &nbsp;</strong>
                                            {{ $orderRetrun->reason }}</p>
                                        @if ($orderRetrun->remarks)
                                            <p class="text-dark fs-15 mb-2"><strong
                                                    class="text-secondary">Remarks &nbsp; : &nbsp;</strong>
                                                {{ $orderRetrun->remarks }}</p>
                                        @endif
                                        <p>
                                            <a href="{{ route('admin.orders.view', $orderRetrun->order_id) }}"
                                                target="_blank"
                                                class="text-secondary fs-15 order-return-hover fw-bold text-decoration-none">
                                                View Order Details
                                                <i class="fas fa-arrow-up-right-from-square"></i> </a>
                                        </p>
                                        <img src="{{ Storage::url($orderRetrun->fetchOrderItem->getProduct->featured_image ?? 'images/no-img.png') }}"
                                            class="img-fluid rounded border" alt="Product Image"
                                            style="max-height: 150px;">
                                    </div>
                                </a>
                            </div>

                            {{-- Product Details --}}
                            <div class="col-md-6">
                                {{-- Images Section --}}
                                @php
                                    $returnImages = json_decode($orderRetrun->images, true);
                                @endphp

                                @if (!empty($returnImages) && is_array($returnImages))
                                    <div class="px-3 py-4">
                                        <h6 class="fw-bold bb-section-title mb-3 pb-3">Return Images</h6>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach ($returnImages as $img)
                                                <div style="width: 120px;">
                                                    <a href="{{ Storage::url($img) }}" target="_blank">
                                                        <img src="{{ Storage::url($img) }}"
                                                            class="img-fluid rounded border" alt="Return Image">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-2 rounded-4">
                        <div class="card-header">
                            <h1 class="mb-0">
                                Return Info
                            </h1>
                        </div>

                        <div class="card-body p-0">
                            <div class="p-3">
                                {{-- Return Reason & Status --}}
                                

                                @if ($orderRetrun->status != 3 && $orderRetrun->status != 4)
                                <form wire:submit.prevent="orderReturnSubmit" class="mb-2">
                                        <div class="">
                                            <label for="statusSelect" class="form-label fw-bold">Change Status:</label>
                                            <select wire:model="status" id="statusSelect" class="form-select">
                                                <option value="">Select Status</option>
                                                <option value="0">Pending</option>
                                                <option value="1">Accepted</option>
                                                <option value="2">Received</option>
                                                <option value="3">Approved</option>
                                                <option value="4">Rejected</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <label for="statusSelect" class="form-label fw-bold">Change Remarks</label>
                                            <textarea name="" id="" wire:model="changed_remarks" class="form-control" rows="4"></textarea>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button class="btn btn-primary">Change</button>
                                        </div>
                                    </form>
                                    @else
                                        <div class="mt-2">
                                            <label for="statusSelect" class="form-label fw-bold">Status</label>
                                            @if ($orderRetrun->status == 3)
                                                <p class="badge bg-success text-white">Approved</p>
                                            @elseif($orderRetrun->status == 4)
                                                <p class="badge bg-danger text-white">Rejected</p>
                                            @endif
                                        </div>  
                                        @if ($orderRetrun->changed_remarks)
                                        <div class="mt-3">
                                            <label for="statusSelect" class="form-label fw-bold">Change Remarks</label>
                                            <textarea name="" id="" wire:model="changed_remarks" class="form-control" rows="4" readonly></textarea>
                                        </div>
                                        @endif
                                    @endif
                                {{-- <p><a href="{{ route('admin.orders.view', $orderRetrun->order_id) }}"
                                        target="_blank">👉
                                        Click here to view order details..</a></p> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>