<div class="page-wrapper">
    <div wire:ignore.self class="modal fade" id="reviewChangeStatusModel" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Review Status Change</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetField"></button>
                </div>
                <form action="" wire:submit.prevent="reviewChangeStatus">
                    <div class="modal-body">
                        @csrf
                        <h2 class="text-danger">Are You Sure You Want To Change This Review Status?</h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            wire:click="resetField">No</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Reviews</h1>
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
                                            style="min-width: 120px" wire:model.live.debounce.500ms="search" />
                                    </label>
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
                                        <th title="Product" class="text-start column-key-2">
                                            PRODUCT
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            NAME/EMAIL
                                        </th>

                                        <th title="Name" class="text-start column-key-2">
                                            START
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            COMMENT
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            IMAGE
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
                                    @forelse($reviews as $review)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            <a href="{{ url('/shop-product-detail/' . $review->product_id) }}" target="_blank">
                                                {{ $review->getProducts->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ $review->user_id ? url('/admin/customer/customer-detail/' . $review->user_id) : '#' }}" @if($review->user_id) target="_blank" @endif>
                                                {{ $review->name }}<br>
                                                {{ $review->email }}
                                            </a>
                                        </td>
                                        <td style="width: 150px;">
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
                                        <td>
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
                                            <a href="#" data-bs-toggle="modal"
                                                wire:click="reviewIdSet({{$review->id}})"
                                                data-bs-target="#reviewChangeStatusModel"
                                                aria-haspopup="dialog"
                                                aria-expanded="false">
                                                <i class="fa fa-pencil fa-md"></i>
                                            </a>
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
                            {{ $reviews->links() }}
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
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div> 
@section('scripts')
<script>
    window.addEventListener('review-change-status-model-close',event => { 
        $('#reviewChangeStatusModel').modal('hide');
    });
</script> 
@endsection