<div class="page-wrapper">
    <div wire:loading.delay wire:target="submit" class="loader-overlay" style="display: none !important;">
        <img src="{{ asset('assets/images/loading.gif') }}" alt="Loading..." class="loader-img">
    </div>
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
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Create Offer</h1>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body page-content">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="my-2 text-end">
                    </div>
                </div>
                <form enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="card tree-form-container">
                            <div class="card-body tree-form-body">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-3 position-relative" wire:ignore>
                                        <label class="form-label required" for="name">Start Date Time</label>
                                        <input class="form-control @error('start_rage') is-invalid @enderror"
                                            name="start_rage" type="datetime-local" wire:model="start_rage">
                                        @error('start_rage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3 position-relative" wire:ignore>
                                        <label class="form-label required" for="name">End Date Time</label>
                                        <input class="form-control @error('end_rage') is-invalid @enderror"
                                            name="end_rage" type="datetime-local" wire:model="end_rage">
                                        @error('end_rage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-2 position-relative" wire:ignore>
                                        <label class="form-label form-label required" for="status">Target
                                            Audience</label>
                                        <select class="form-control form-select @error('audience') is-invalid @enderror"
                                            name="audience" wire:model="audience">
                                            <option value="" selected disabled>Select Target Audience</option>
                                            <option value="1">All</option>
                                            <option value="2">Registered Customer</option>
                                            <option value="3">Premium Customer</option>
                                            <option value="4">Standard</option>
                                        </select>
                                        @error('audience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3 position-relative" wire:ignore>
                                        <label class="form-label required">Discount</label>
                                        <div class="input-group">
                                            <select class="form-select @error('discount_type') is-invalid @enderror"
                                                wire:model.live="discount_type"
                                                style="max-width: 100px; background-color: #f1f1f1;">
                                                <option value="" disabled>Select</option>
                                                <option value="Percentage">%</option>
                                                <option value="Amount">₹</option>
                                            </select>

                                            <input type="number"
                                                class="form-control @error('discount_value') is-invalid @enderror"
                                                placeholder="Value" wire:model="discount_value">
                                        </div>

                                        @error('discount_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        @error('discount_value')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3 position-relative" wire:ignore>
                                        <label class="form-label required">Item Is Returnable</label>
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                id="flexSwitchCheckDefault"
                                                wire:model="item_returnable"
                                                value="1"
                                                @if($item_returnable) checked @endif
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="card tree-form-container">
                            <div class="card-body tree-form-body">
                                <div class="row">
                                    <div class="mb-3 col-md-3 position-relative" wire:ignore>
                                        <label class="form-label form-label required" for="status">Trigger
                                            Type</label>
                                        <select wire:model.live="trigger_type"
                                            class="form-control form-select @error('trigger_type') is-invalid @enderror"
                                            wire:change="changeTriggerType('')" name="trigger_type">
                                            <option value="" selected disabled>Select Trigger Type</option>
                                            <option value="1">Product</option>
                                            <option value="2">Brand</option>
                                            <option value="3">Category</option>
                                        </select>
                                        @error('trigger_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3 position-relative {{ $trigger_type == '' ? '' : 'd-none'}}">
                                        <div wire:ignore>
                                            <label class="form-label required">Select
                                                {{ $trigger_value_label == '' ? 'Option' : $trigger_value_label }}</label>
                                            <select wire:model="tigger_refrence_id"
                                                class="select-search-full form-select select2 @error('tigger_refrence_id') is-invalid @enderror"
                                                name="tigger_refrence_id" id="tigger_refrences_id">
                                                <option value="" selected disabled>Select
                                                    {{ $trigger_value_label == '' ? 'Option' : $trigger_value_label }}
                                                </option>
                                                @if ($trigger_type == 1)
                                                @foreach ($trigger_products as $product)
                                                <option value="{{ $product->id }}developer{{ $product->name }}"
                                                    {{ $this->tigger_refrence_id == $product->id . 'developer' . $product->name ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                                @endforeach
                                                @elseif ($trigger_type == 2)
                                                @foreach ($trigger_brands as $brand)
                                                <option value="{{ $brand->id }}developer{{ $brand->name }}"
                                                    {{ $this->tigger_refrence_id == $brand->id . 'developer' . $brand->name ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                                @endforeach
                                                @elseif ($trigger_type == 3)
                                                @foreach ($trigger_categories as $category)
                                                <option value="{{ $category->id }}developer{{ $category->name }}"
                                                    {{ $this->tigger_refrence_id == $category->id . 'developer' . $category->name ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @error('tigger_refrence_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- product  -->
                                    <div class="mb-3 col-md-3 position-relative {{ $trigger_type == 1 ? '' : 'd-none'}}">
                                        <label class="form-label required">
                                            Select {{ $trigger_value_label == '' ? 'Option' : $trigger_value_label }}
                                        </label>
                                        <div wire:ignore>
                                            <select wire:model="tigger_refrence_id"
                                                class="select-search-full form-select select2 @error('tigger_refrence_id') is-invalid @enderror"
                                                name="tigger_refrence_id" id="tigger_product_refrence_id">
                                                <option value="" selected disabled>
                                                    Select {{ $trigger_value_label == '' ? 'Option' : $trigger_value_label }}
                                                </option>

                                                @foreach ($trigger_products as $product)
                                                <option value="{{ $product->id }}developer{{ $product->name }}"
                                                    {{ $this->tigger_refrence_id == $product->id . 'developer' . $product->name ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('tigger_refrence_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- brand  -->
                                    <div class="mb-3 col-md-3 position-relative {{ $trigger_type == 2 ? '' : 'd-none'}}">
                                        <label class="form-label required">
                                            Select {{ $trigger_value_label == '' ? 'Option' : $trigger_value_label }}
                                        </label>
                                        <div wire:ignore>
                                            <select wire:model="tigger_refrence_id"
                                                class="select-search-full form-select select2 @error('tigger_refrence_id') is-invalid @enderror"
                                                name="tigger_refrence_id" id="tigger_brand_refrences_id">
                                                <option value="" selected disabled>
                                                    Select {{ $trigger_value_label == '' ? 'Option' : $trigger_value_label }}
                                                </option>
                                                @foreach ($trigger_brands as $brand)
                                                <option value="{{ $brand->id }}developer{{ $brand->name }}"
                                                    {{ $this->tigger_refrence_id == $brand->id . 'developer' . $brand->name ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('tigger_refrence_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- category  -->
                                    <div class="mb-3 col-md-3 position-relative {{ $trigger_type == 3 ? '' : 'd-none'}}">
                                        <label class="form-label required">
                                            Select {{ $trigger_value_label == '' ? 'Option' : $trigger_value_label }}
                                        </label>
                                        <div wire:ignore>
                                            <select wire:model="tigger_refrence_id"
                                                class="select-search-full form-select select2 @error('tigger_refrence_id') is-invalid @enderror"
                                                name="tigger_refrence_id" id="tigger_category_refrences_id">
                                                <option value="" selected disabled>
                                                    Select {{ $trigger_value_label == '' ? 'Option' : $trigger_value_label }}
                                                </option>
                                                @foreach ($trigger_categories as $category)
                                                <option value="{{ $category->id }}developer{{ $category->name }}"
                                                    {{ $this->tigger_refrence_id == $category->id . 'developer' . $category->name ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('tigger_refrence_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3 col-md-3 position-relative" wire:ignore>
                                        <label class="form-label" for="name">Min Quantity</label>
                                        <input class="form-control @error('trigger_min_qty') is-invalid @enderror"
                                            placeholder="Min Quantity" name="trigger_min_qty" type="text"
                                            wire:model="trigger_min_qty">
                                        @error('trigger_min_qty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-2 position-relative" wire:ignore>
                                        <label class="form-label" for="name">Min Amount</label>
                                        <input class="form-control @error('trigger_min_amount') is-invalid @enderror"
                                            placeholder="Min Amount" name="trigger_min_amount" type="text"
                                            wire:model="trigger_min_amount">
                                        @error('trigger_min_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-auto col-md-1 position-relative">
                                        <button class="btn btn-primary" type="button" name="submitter"
                                            wire:click="addTriggerType">
                                            {{ $this->trigger_edit_index == '' ? 'Add' : 'Edit' }}
                                        </button>
                                    </div>
                                </div>
                                @if (count($trigger_list) > 0)
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
                                                    Sr No
                                                </th>
                                                <th title="Name" class="text-start column-key-2">
                                                    Trigger Type
                                                </th>
                                                <th title="Name" class="text-start column-key-2">
                                                    Name
                                                </th>
                                                <th title="Name" class="text-start column-key-2">
                                                    Min Quantity
                                                </th>
                                                <th title="Is featured" width="100"
                                                    class="text-start column-key-3">
                                                    Min Amount
                                                </th>
                                                <th width="200" class="column-key-4">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trigger_list as $key2 => $item)
                                            <tr wire:key="{{ $key2 }}">
                                                <td>{{ (int) $key2 + 1 }}</td>

                                                <td>
                                                    @if ($item['trigger_type'] == '1')
                                                    Products
                                                    @elseif ($item['trigger_type'] == '2')
                                                    Brand
                                                    @else
                                                    Category
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item['name'] }}
                                                </td>
                                                <td>
                                                    {{ $item['min_qty'] }}
                                                </td>
                                                <td>
                                                    {{ $item['min_amount'] }}
                                                </td>
                                                <td class="text-center no-column-visibility text-nowrap">
                                                    <div class="table-actions">
                                                        <a href="javascript:void(0);"
                                                            wire:click="editTrigger('{{ $key2 }}')"
                                                            class="me-2">
                                                            <i class="fa fa-edit"></i>
                                                            <span class="sr-only">Edit</span>
                                                        </a>

                                                        <a wire:confirm="Are you sure you want to delete?"
                                                            wire:click="triggerDelete('{{ $key2 }}')"
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
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="card tree-form-container">
                            <div class="card-body tree-form-body">
                                <div class="row">
                                    <div class="mb-3 col-md-3 position-relative" wire:ignore>
                                        <label class="form-label form-label required" for="status">Applies
                                            To</label>
                                        <select wire:model.live="applies" name="applies"
                                            class="form-control form-select @error('applies') is-invalid @enderror"
                                            wire:change="changeApplies('')">
                                            <option value="" selected disabled>Select Applies Type</option>
                                            <option value="1">Product</option>
                                            <option value="2">Brand</option>
                                            <option value="3">Category</option>
                                            <option value="4">Least Prices</option>
                                        </select>
                                        @error('applies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if ($applies !== '4')
                                    <div class="mb-3 col-md-3 position-relative {{$applies == ''? '' : 'd-none'}}">
                                        <label class="form-label required">Select
                                            {{ $applies_value_label == '' ? 'Option' : $applies_value_label }}</label> 
                                        <div wire:ignore>
                                            <select wire:model="applies_refrence_id"
                                                class="select-search-full form-select select2 @error('applies_refrence_id') is-invalid @enderror"
                                                name="applies_refrence_id">
                                                <option value="" selected disabled>Select
                                                    {{ $applies_value_label == '' ? 'Option' : $applies_value_label }}
                                                </option>
                                                @if ($applies == 1)
                                                @foreach ($applies_products as $product)
                                                <option
                                                    value="{{ $product->id }}developer{{ $product->name }}"
                                                    {{ $this->applies_refrence_id == $product->id . 'developer' . $product->name ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                                @endforeach
                                                @elseif ($applies == 2)
                                                @foreach ($applies_brands as $brand)
                                                <option
                                                    value="{{ $brand->id }}developer{{ $brand->name }}"
                                                    {{ $this->applies_refrence_id == $brand->id . 'developer' . $brand->name ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                                @endforeach
                                                @elseif ($applies == 3)
                                                @foreach ($applies_categories as $category)
                                                <option
                                                    value="{{ $category->id }}developer{{ $category->name }}"
                                                    {{ $this->applies_refrence_id == $category->id . 'developer' . $category->name ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select> 
                                        </div>
                                        @error('applies_refrence_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- applies product  -->
                                    <div class="mb-3 col-md-3 position-relative {{$applies == 1 ? '' : 'd-none'}}">
                                        <label class="form-label required">Select
                                            {{ $applies_value_label == '' ? 'Option' : $applies_value_label }}</label>
                                        <div wire:ignore>
                                            <select wire:model="applies_refrence_id"
                                                class="select-search-full form-select select2 @error('applies_refrence_id') is-invalid @enderror"
                                                name="applies_product_refrence_id" id="applies_product_refrence_id">
                                                <option value="" selected disabled>Select
                                                    {{ $applies_value_label == '' ? 'Option' : $applies_value_label }}
                                                </option>
                                                @foreach ($applies_products as $product)
                                                <option
                                                    value="{{ $product->id }}developer{{ $product->name }}"
                                                    {{ $this->applies_refrence_id == $product->id . 'developer' . $product->name ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('applies_refrence_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- applies brand  -->
                                    <div class="mb-3 col-md-3 position-relative {{$applies == 2 ? '' : 'd-none'}}">
                                        <label class="form-label required">Select
                                            {{ $applies_value_label == '' ? 'Option' : $applies_value_label }}</label>
                                        <div wire:ignore>
                                            <select wire:model="applies_refrence_id"
                                                class="select-search-full form-select select2 @error('applies_refrence_id') is-invalid @enderror"
                                                name="applies_brand_refrence_id" id="applies_brand_refrence_id">
                                                <option value="" selected disabled>Select
                                                    {{ $applies_value_label == '' ? 'Option' : $applies_value_label }}
                                                </option>
                                                @foreach ($applies_brands as $brand)
                                                <option
                                                    value="{{ $brand->id }}developer{{ $brand->name }}"
                                                    {{ $this->applies_refrence_id == $brand->id . 'developer' . $brand->name ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('applies_refrence_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- applies category  -->
                                    <div class="mb-3 col-md-3 position-relative {{$applies == 3 ? '' : 'd-none'}}">
                                        <label class="form-label required">Select
                                            {{ $applies_value_label == '' ? 'Option' : $applies_value_label }}</label>
                                        <div wire:ignore>
                                            <select wire:model="applies_refrence_id"
                                                class="select-search-full form-select select2 @error('applies_refrence_id') is-invalid @enderror"
                                                name="applies_category_refrence_id" id="applies_category_refrence_id">
                                                <option value="" selected disabled>Select
                                                    {{ $applies_value_label == '' ? 'Option' : $applies_value_label }}
                                                </option>
                                                @foreach ($applies_categories as $category)
                                                <option
                                                    value="{{ $category->id }}developer{{ $category->name }}"
                                                    {{ $this->applies_refrence_id == $category->id . 'developer' . $category->name ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('applies_refrence_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3 position-relative">
                                        <label class="form-label" for="name">Min Quantity</label>
                                        <input
                                            class="form-control @error('applies_min_qnty') is-invalid @enderror"
                                            placeholder="Min Quantity" name="applies_min_qnty" type="text"
                                            wire:model="applies_min_qnty">
                                        @error('applies_min_qnty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-2 position-relative">
                                        <label class="form-label" for="name">Min Amount</label>
                                        <input
                                            class="form-control @error('applies_min_amount') is-invalid @enderror"
                                            placeholder="Min Amount" name="applies_min_amount" type="text"
                                            wire:model="applies_min_amount">
                                        @error('applies_min_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @endif
                                    <div class="mb-3 mt-auto col-md-1 position-relative">
                                        <button class="btn btn-primary" type="button" name="submitter"
                                            wire:click="addAppliesTo">
                                            {{ $this->applies_edit_index == '' ? 'Add' : 'Edit' }}
                                        </button>
                                    </div>
                                </div>
                                @if (count($applies_list) > 0)
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
                                                    Sr No
                                                </th>
                                                <th title="Name" class="text-start column-key-2">
                                                    Applies To
                                                </th>
                                                <th title="Name" class="text-start column-key-2">
                                                    Name
                                                </th>
                                                <th title="Name" class="text-start column-key-2">
                                                    Min Quantity
                                                </th>
                                                <th title="Is featured" width="100"
                                                    class="text-start column-key-3">
                                                    Min Amount
                                                </th>
                                                <th title="Created At" width="200" class="column-key-4">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applies_list as $key1 => $item)
                                            <tr wire:key="{{ $key1 }}">
                                                <td>{{ (int) $key1 + 1 }}</td>
                                                <td>
                                                    @if ($item['applies'] == '1')
                                                    Products
                                                    @elseif ($item['applies'] == '2')
                                                    Brand
                                                    @elseif($item['applies'] == '3')
                                                    Category
                                                    @else
                                                    Least Prices
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item['applies'] == '4' ? 'N/A' : $item['name'] }}
                                                </td>
                                                <td>
                                                    {{ $item['applies'] == '4' ? 'N/A' : $item['min_qnty'] }}
                                                </td>
                                                <td>
                                                    {{ $item['applies'] == '4' ? 'N/A' : $item['min_amount'] }}
                                                </td>
                                                <td class="text-center no-column-visibility text-nowrap">
                                                    <div class="table-actions">
                                                        <a href="javascript:void(0);"
                                                            wire:click="editApplies('{{ $key1 }}')"
                                                            class="me-2">
                                                            <i class="fa fa-edit"></i>
                                                            <span class="sr-only">Edit</span>
                                                        </a>

                                                        <a wire:confirm="Are you sure you want to delete?"
                                                            wire:click="appliesDelete('{{ $key1 }}')"
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
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 position-relative">
                        <button class="btn btn-primary" type="submit" name="submitter" wire:click.prevent="submit">
                            save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <footer class="footer position-sticky footer-transparent d-print-none">
        <div class="container-xl">
            <div class="text-start">
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-between">
                    <div class="order-2 order-lg-1">
                        Copyright 2025 © Roll Mills Store.
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
@section('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        const initSelect2 = () => {
            $('#tigger_product_refrence_id').select2().on('change', function() {
                @this.set('tigger_refrence_id', $(this).val());
            });

            $('#tigger_brand_refrences_id').select2().on('change', function() {
                @this.set('tigger_refrence_id', $(this).val());
            });

            $('#tigger_category_refrences_id').select2().on('change', function() {
                @this.set('tigger_refrence_id', $(this).val());
            });
        };

        // Re-init after every DOM update (when trigger_type changes)
        Livewire.hook('message.processed', () => {
            initSelect2();
        });

        initSelect2(); // Initial call
    });

    //for applies 
    document.addEventListener('livewire:init', () => {
        const initSelect2 = () => {
            $('#applies_product_refrence_id').select2().on('change', function() {
                @this.set('applies_refrence_id', $(this).val());
            });

            $('#applies_brand_refrence_id').select2().on('change', function() {
                @this.set('applies_refrence_id', $(this).val());
            });

            $('#applies_category_refrence_id').select2().on('change', function() {
                @this.set('applies_refrence_id', $(this).val());
            });
        };

        // Re-init after every DOM update (when trigger_type changes)
        Livewire.hook('message.processed', () => {
            initSelect2();
        });

        initSelect2(); // Initial call
    });
</script>
@endsection