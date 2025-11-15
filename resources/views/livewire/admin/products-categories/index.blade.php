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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Products Categories</h1>
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
                                    href="{{ url('admin/products-categories/create') }}" aria-haspopup="dialog"
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
                                            Name
                                        </th>
                                        
                                        <th title="Name" class="text-start column-key-2">
                                            Status
                                        </th>
                                        <th title="Parent" class="text-start column-key-2">
                                            Parent Category
                                        </th>
                                        <th title="Is featured" width="100" class="text-start column-key-3">
                                            Is featured
                                        </th>
                                        
                                        <th title="Created At" width="100" class="column-key-4">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_categories as $product_catagory)
                                    <tr wire:key="$product_catagory->id">
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $product_catagory->name }}</td>
                                        <td>
                                            @if($product_catagory->status == 1)
                                            <span class="badge bg-success text-white">Publish</span>
                                            @elseif($product_catagory->status == 2)
                                            <span class="badge bg-warning text-white">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product_catagory->parent_id != null && $product_catagory->parent_id != '')
                                            {{$product_catagory->getParentProductCategory->name}}
                                            @endif
                                        </td>
                                        <td> 
                                            @if($product_catagory->is_featured  == 0)
                                            <span class="badge bg-danger text-white">Off</span>
                                            @elseif($product_catagory->is_featured  == 1)
                                            <span class="badge bg-success text-white">On</span>
                                            @endif
                                        </td>
                                        <td class="text-center no-column-visibility text-nowrap">
                                            <div class="table-actions">
                                                <a href="{{ route("admin.products-categories.edit",$product_catagory->id) }}"
                                                    class="me-2">
                                                    <i class="fa fa-edit"></i>
                                                    <span class="sr-only">Edit</span>
                                                </a>

                                                {{--<a wire:click="deleteProductCategory({{ $product_catagory->id }})"
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
                        {{ $product_categories->links() }}
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
                        <span class="fw-medium">1.41.2</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
