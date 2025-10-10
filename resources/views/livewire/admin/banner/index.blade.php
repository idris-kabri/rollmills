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
                                        href="{{url("/admin")}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Banner</h1>
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
                                    href="{{ route("admin.banner.create") }}" aria-haspopup="dialog"
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
                                        <th title="Name" class="text-start column-key-2">
                                            Image
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            Heading
                                        </th>
                                        <th title="Name" class="text-start column-key-2">
                                            Sub Heading
                                        </th>
                                        <th title="Is featured" width="100" class="text-start column-key-3">
                                            Button Text
                                        </th>
                                        <th title="Is featured" width="100" class="text-start column-key-3">
                                            Status
                                        </th>
                                        <th title="Is featured" width="100" class="text-start column-key-3">
                                            Link
                                        </th>
                                        <th title="Created At" width="100" class="column-key-4">
                                            Is default
                                        </th>
                                        <th title="Created At" width="100" class="column-key-4">
                                            Start Date
                                        </th>
                                        <th title="Created At" width="100" class="column-key-4">
                                            End Date
                                        </th>
                                        <th title="Created At" width="200" class="column-key-4">
                                            Banner Type
                                        </th>
                                        <th title="Created At" width="100" class="column-key-4">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $banner)
                                    <tr wire:key="{{$banner->id}}">
                                        <td>{{ $i++ }}</td>
                                        <td><img src="{{ asset("storage/".$banner->image) }}" width="50" alt="Image"></td>
                                        <td>{{ $banner->heading }}</td>
                                        <td>{!! $banner->sub_heading !!}</td>
                                        <td>{{ $banner->button_text }}</td>
                                        <td>
                                            @if($banner->status == 0)
                                            <span class="badge bg-warning text-white">In Active</span>
                                            @elseif($banner->status == 1)
                                            <span class="badge bg-success text-white">Active</span>
                                            @endif
                                        </td>
                                        <td><a href="{{ $banner->link }}">Link</a></td>
                                        <td> 
                                            @if($banner->is_default  == 0)
                                            <span class="badge bg-danger text-white">Not Default</span>
                                            @elseif($banner->is_default  == 1)
                                            <span class="badge bg-success text-white">Default</span>
                                            @endif
                                        </td>
                                        <td>{{ $banner->start_time }}</td>
                                        <td>{{ $banner->end_time }}</td>
                                        <td>{{ ucwords(implode(' ',explode('_',$banner->banner_type))) }}</td>
                                        <td class="text-center no-column-visibility text-nowrap">
                                            <div class="table-actions">
                                                <a href="{{ route("admin.banner.edit",$banner->id) }}"
                                                    class="me-2">
                                                    <i class="fa fa-edit"></i>
                                                    <span class="sr-only">Edit</span>
                                                </a>

                                                <a wire:click="delete({{ $banner->id }})"
                                                    wire:confirm="Are you sure you want to delete?"
                                                    class="cursor-pointer">
                                                    <i class="fa fa-trash"></i>
                                                    <span class="sr-only">Delete</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $banners->links('vendor.pagination.bootstrap-5') }}
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