<div class="page-wrapper">
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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">User Quotation</h1>
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
                                            Name
                                        </th>
                                        <th title="Name" class="text-start column-key-1">
                                            Email
                                        </th>
                                        <th title="Name" class="text-start column-key-1">
                                            Mobile
                                        </th>
                                        <th title="Items" width="100" class="text-center column-key-3">
                                            Status
                                        </th>
                                        <th title="Items" width="100" class="text-center column-key-3">
                                            Created At
                                        </th>
                                        <th title="Actions" class="text-center column-key-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = ($quotations->currentPage() - 1) * $quotations->perPage() + 1;
                                    @endphp
                                    @if (count($quotations) > 0)
                                    @foreach ($quotations as $item)
                                    <tr class="odd">
                                        <td>
                                            {{ $i++ }}
                                        </td>
                                        <td class="text-start column-key-1">{{ $item->name }}</td>
                                        <td class="text-start column-key-1">{{ $item->email }}</td>
                                        <td class="text-start column-key-1">{{ $item->mobile_number }}</td>

                                        <td class="text-center column-key-2"><span class="badge bg-{{ $item->status == 1 ? 'success' : ($item->status == 0 ? 'warning':  'danger') }} text-{{ $item->status == 1 ? 'success' : ($item->status == 0 ? 'warning':  'danger') }}-fg">{{ $item->status == 1 ? 'Converted' : ($item->status == 0 ? 'Pending':  'Lost') }}</span></td> 
                                        <td class="text-start column-key-1">{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center no-column-visibility text-nowrap">
                                            <div class="table-actions">
                                                <a href="{{route('admin.user-quotation.view',$item->id)}}"
                                                    class="me-2">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr class="odd">
                                        <td colspan="8" class="text-center">No data Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $quotations->links() }}
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