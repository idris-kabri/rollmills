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
                                        href="{{url('/admin')}}">Dashboard</a>
                                </li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        Products
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
                <div
                    class="card mb-3 table-configuration-wrap"
                    style="display: none">

                </div>

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

                                <div class="dropdown d-inline-block">
                                    <a
                                        href="{{route('admin.product.create')}}"
                                        class="btn buttons-collection action-item btn-primary">
                                        <i class="fa fa-plus"></i>
                                        Create
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-table">
                        <div
                            class="table-responsive table-has-actions table-has-filter">
                            <table
                                class="table card-table table-vcenter table-striped table-hover"
                                id="botble-ecommerce-tables-product-table">
                                <thead>
                                    <tr>
                                        <th
                                            title="ID"
                                            width="20"
                                            class="text-center no-column-visibility column-key-0">
                                            ID
                                        </th>
                                        <th title="Image" width="100" class="column-key-1">
                                            Image
                                        </th>
                                        <th
                                            title="Products"
                                            class="text-start column-key-2">
                                            Products
                                        </th>
                                        <th title="Price" class="text-start column-key-3">
                                            Price
                                        </th>
                                        
                                        <th title="Stock status" class="column-key-4">
                                            Stock status
                                        </th>
                                        <th
                                            title="Quantity"
                                            class="text-start column-key-5">
                                            Featured
                                        </th>
                                        <th
                                            title="Sort order"
                                            width="50"
                                            class="column-key-7">
                                            Categories
                                        </th>
                                        <th
                                            title="Created At"
                                            width="100"
                                            class="column-key-8">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp

                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            <img src="{{ Storage::url($product->featured_image) }}"
                                                alt="Product Image"
                                                class="rounded mx-auto d-block"
                                                style="height: 100px; width: 100px;" />
                                        </td>
                                        <td>{{$product->name}}</td>
                                        <td class=""> 
                                            @php 
                                                $priceInfo = getPrice($product->id)
                                            @endphp
                                            @if($priceInfo['original_price'])
                                            <span><del>{{$product->price}}</del></span> <br> 
                                            @endif
                                            <span>{{$priceInfo['price']}}</span>
                                            
                                        </td>
                                        <td class=" column-key-2">
                                            <span class="badge bg-{{ $product->out_of_stock == 1 ? 'danger' : 'success' }} text-{{ $product->out_of_stock == 1 ? 'danger' : 'success' }}-fg">{{ $product->out_of_stock == 1 ? 'Out Of Stock' : 'In Stock' }}</span>
                                        </td>
                                        <td class=" column-key-2">
                                            <span class="badge bg-{{ $product->is_featured == 1 ? 'success' : 'danger' }} text-{{ $product->is_featured == 1 ? 'success' : 'danger' }}-fg">{{ $product->is_featured == 1 ? 'Featured' : 'Not Featured' }}</span>
                                        </td>
                                        <td>
                                            @php
                                            $category_ids = App\Models\ProductCategoryAssign::where('product_id', $product->id)->pluck('category_id');
                                            $categories = App\Models\ProductCategory::whereIn('id', $category_ids)->pluck('name')->toArray();
                                            @endphp
                                            {{ implode(', ', $categories) }}
                                        </td>
                                        <td class="text-center no-column-visibility text-nowrap">
                                                <div class="table-actions">
                                                    <a href="/admin/product/edit/{{ $product->id }}"
                                                        class="me-2">
                                                        <i class="fa fa-edit"></i>
                                                        <span class="sr-only">Edit</span>
                                                    </a>

                                                </div>
                                            </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$products->links()}}
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
                        <span class="fw-medium">1.41.2</span>
                    </div>
                    <div class="order-1 order-lg-2">
                        Page loaded in 0.45 seconds
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>