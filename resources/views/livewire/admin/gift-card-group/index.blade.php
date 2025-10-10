<div class="page-wrapper">
    @include('livewire.admin.gift-card-group.createEditModel')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a
                                        class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{route('admin.dashboard')}}">Dashboard</a>
                                </li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Gift Cards</h1>
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
                        <div
                            class="w-100 justify-content-between d-flex flex-wrap align-items-center gap-1">
                            <div
                                class="d-flex flex-wrap flex-md-nowrap align-items-center gap-1">


                                <div class="table-search-input">
                                    <label>
                                        <input
                                            wire:model.live.debounse.500ms="search"
                                            type="search"
                                            class="form-control input-sm"
                                            placeholder="Search..."
                                            style="min-width: 120px" />
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button
                                    class="btn action-item btn-primary"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#gitcardCreateModal"
                                    aria-haspopup="dialog"
                                    aria-expanded="false">
                                    <span
                                        data-action="create"
                                        data-href=""><i class="fa fa-plus"></i> Create
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-table">
                        <div
                            class="table-responsive table-has-actions table-has-filter">
                            <table
                                class="table card-table table-vcenter table-striped table-hover"
                                id="botble-ecommerce-tables-brand-table">
                                <thead>
                                    <tr>
                                        <th title="Sr no">
                                            Sr no.
                                        </th>
                                        <th title="Name" class="text-start column-key-1">
                                            Price
                                        </th>

                                        <th title="Status" width="100" class="text-center column-key-2">
                                            Customer Show
                                        </th>

                                        <th title="Items" width="100" class="text-center column-key-3">
                                            Status
                                        </th>

                                        <th title="Items" width="100" class="text-center column-key-3">
                                            Is Custom
                                        </th>
                                        <th title="Actions" class="text-center column-key-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $srNo = ($giftCardGroups->currentPage() - 1) * $giftCardGroups->perPage() + 1;
                                    @endphp
                                    @foreach($giftCardGroups as $giftCardGroup)
                                    <tr>
                                        <td>{{ $srNo++ }}</td>
                                        <td>{{$giftCardGroup->price}}</td>
                                        <td class="text-center">
                                            @if($giftCardGroup->show_customer == 1)
                                            <p class="text-success">Yes</p>
                                            @else
                                            <p class="text-danger">No</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($giftCardGroup->status == 1)
                                            <p class="text-success">Active</p>
                                            @else
                                            <p class="text-danger">In Active</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($giftCardGroup->is_custom == 1)
                                            <p class="text-success">Yes</p>
                                            @else
                                            <p class="text-danger">No</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('admin.gift-card-items.index',$giftCardGroup->id)}}" class="text-center">
                                                <i class="fa fa-eye fa-md"></i>
                                            </a>
                                            <a wire:click="giftCardGroupEdit({{$giftCardGroup->id}})" href="#" data-bs-toggle="modal"
                                                data-bs-target="#gitcardEditModal"
                                                aria-haspopup="dialog"
                                                aria-expanded="false">
                                                <i class="fa fa-pencil fa-md"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 pagination-div">
                            {{$giftCardGroups->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer
        class="footer position-sticky footer-transparent d-print-none">
        <div class="container-xl">
            <div class="text-start">
                <div
                    class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-between">
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
    window.addEventListener('model-close', event => {
        $('#gitcardCreateModal').modal('hide');
        $('#gitcardEditModal').modal('hide');
    });
</script>
@endsection