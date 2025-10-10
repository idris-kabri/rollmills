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
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Offer</h1>
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
                            <div class="d-flex align-items-center gap-1">
                                <a class="btn action-item btn-primary" tabindex="0"
                                    aria-controls="botble-ecommerce-tables-products-categories-table"
                                    href="{{ route('admin.offer.create') }}" aria-haspopup="dialog"
                                    aria-expanded="false">
                                    <span data-action="create" data-href=""><i class="fa fa-add"></i>Create</span>
                                </a>
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
                                        <th title="Name" class=" column-key-2">
                                            Start Date
                                        </th>
                                        <th title="Name" class=" column-key-2">
                                            End Title
                                        </th>
                                        <th title="Name" class=" column-key-2">
                                            Target
                                        </th>
                                        <th title="Is featured" width="100" class=" column-key-3">
                                            Discount
                                        </th>
                                        <th title="Is featured" width="100" class=" column-key-3">
                                            Status
                                        </th>
                                        <th title="Created At" width="200" class="column-key-4">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offers as $offer)
                                        <tr wire:key="{{ $offer->id }}">
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                {{ $offer->start_rage }}
                                            </td>
                                            <td>
                                                {{ $offer->end_rage }}
                                            </td>
                                            <td>
                                                @if ($offer->audience === 1)
                                                    All
                                                @elseif($offer->audience === 2)
                                                    Registered Customer
                                                @elseif($offer->audience === 3)
                                                    Premium Customer
                                                @else
                                                    Standard
                                                @endif
                                            </td>
                                            <td>
                                                @if ($offer->discount_type === 1)
                                                    Percentage
                                                @else
                                                    Amount
                                                @endif
                                            </td>
                                            <td>
                                                @if ($offer->status === 0)
                                                    <span class="text-warning">Pending</span>
                                                @elseif ($offer->status === 1)
                                                    <span class="text-success">Active</span>
                                                @elseif ($offer->status === 2)
                                                    <span class="text-success">Completed</span>
                                                @else
                                                    <span class="text-danger">Canceled</span>
                                                @endif

                                            </td>
                                            <td class="no-column-visibility text-nowrap">
                                                <div class="table-actions">
                                                    <a href="{{ route('admin.offer.detail', $offer->id) }}"
                                                        class="me-2">
                                                        <i class="fa fa-eye"></i>
                                                        <span class="sr-only">View</span>
                                                    </a>

                                                    <a href="{{ route('admin.offer.edit', $offer->id) }}"
                                                        class="me-2">
                                                        <i class="fa fa-edit"></i>
                                                        <span class="sr-only">Edit</span>
                                                    </a>

                                                    {{--<a wire:click="delete({{ $offer->id }})"
                                                        wire:confirm="Are you sure you want to delete?"
                                                        class="cursor-pointer">
                                                        <i class="fa fa-trash"></i>
                                                        <span class="sr-only">Delete</span>
                                                    </a>--}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $offers->links('vendor.pagination.bootstrap-5') }}
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
