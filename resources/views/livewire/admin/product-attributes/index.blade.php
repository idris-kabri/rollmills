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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        Product attributes
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
            <div class="table-wrapper">
                <div class="card mb-3 table-configuration-wrap" style="display: none">
                    <div class="card-body">
                    </div>
                </div>

                <div class="card has-actions has-filter">
                    <div class="card-header">
                        <div class="w-100 justify-content-end d-flex flex-wrap align-items-center gap-1">
                            <div class="d-flex align-items-center gap-1">
                                <a class="btn action-item btn-primary" tabindex="0"
                                    aria-controls="botble-ecommerce-tables-product-attribute-sets-table"
                                    href="{{ url('admin/product-attributes/create') }}" aria-haspopup="dialog"
                                    aria-expanded="false">
                                    <span data-action="create" data-href=""><i class="fa fa-plus"></i>Create
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-table">
                        <div class="table-responsive table-has-actions table-has-filter">
                            <table class="table card-table table-vcenter table-striped table-hover"
                                id="botble-ecommerce-tables-product-attribute-sets-table">
                                <thead>
                                    <tr>
                                        <th title="Sr no">
                                            Sr no.
                                        </th>
                                        <th title="Name" class="text-start column-key-1">
                                            Name
                                        </th>
                                        <th title="Status" width="100" class="text-center column-key-2">
                                            Status
                                        </th>
                                        <th title="Items" width="100" class="text-center column-key-3">
                                            Attribute Items
                                        </th>
                                        <th title="Actions" class="text-center column-key-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @if (count($product_attributes) > 0)
                                        @foreach ($product_attributes as $product_attribute)
                                            <tr class="odd">
                                                <td>
                                                    {{ $i++ }}
                                                </td>
                                                <td class="text-start column-key-1"><a
                                                        href="/admin/product-attributes/edit/{{ $product_attribute->id }}"
                                                        title="{{ $product_attribute->name }}">{{ $product_attribute->name }}</a>
                                                </td>
                                                <td class="text-center column-key-2"><span
                                                        class="badge bg-{{ $product_attribute->status == 1 ? 'success' : 'danger' }} text-{{ $product_attribute->status == 1 ? 'success' : 'danger' }}-fg">{{ $product_attribute->status == 1 ? 'Published' : 'Pending' }}</span>
                                                </td>
                                                <td class="text-start column-key-3">
                                                    @foreach ($product_attribute->getAttibuteItems as $item)
                                                        <p class="mb-0">{{ $item->name }}</p>
                                                    @endforeach
                                                </td>
                                                <td class="text-center no-column-visibility text-nowrap">
                                                    <div class="table-actions">
                                                        <a href="/admin/product-attributes/edit/{{ $product_attribute->id }}"
                                                            class="me-2">
                                                            <i class="fa fa-edit"></i>
                                                            <span class="sr-only">Edit</span>
                                                        </a>

                                                        {{--<a wire:click.prevent="deleteProductAttributes({{ $product_attribute->id }})"
                                                            wire:confirm="Are you sure you want to delete?"
                                                            class="cursor-pointer">
                                                            <i class="fa fa-trash"></i>
                                                            <span class="sr-only">Delete</span>
                                                        </a>--}}

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr class="odd">
                                        <td colspan="5" class="text-center">No data Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $product_attributes->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>