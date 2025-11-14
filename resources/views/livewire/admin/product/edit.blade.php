<div class="page-wrapper">
    <div wire:loading.delay wire:target="formSubmit" class="loader-overlay" style="display: none !important;">
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
                                    <a class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>

                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{ route('admin.product.index') }}">Products</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">New product</h1>
                                </li>
                            </ol>
                        </nav>

                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body page-content">
        <div class="container-xl">

            <form method="POST" wire:submit.prevent="formSubmit" enctype="multipart/form-data">
                @csrf
                <div class="row" wire:key="main-content-row" wire:ignore.self>
                    <div class="gap-3 col-md-9" wire:key="main-content">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="mb-3 position-relative" wire:ignore>
                                        <label class="form-label form-label required" for="name">
                                            Name
                                        </label>
                                        <input class="form-control @error('name') is-invalid @enderror"
                                            data-counter="250" placeholder="Name" name="name" required="required" wire:model.live='name'
                                            type="text" id="name">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <label class="form-label form-label required" for="slug">
                                            Slug
                                        </label>
                                        <input class="form-control @error('slug') is-invalid @enderror"
                                            data-counter="250" placeholder="Slug" name="slug" wire:model='slug'
                                            type="text" id="slug">
                                        @error('slug')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 position-relative" wire:ignore>
                                        <label class="form-label required" for="description">
                                            Description
                                        </label>

                                        <textarea class="form-control form-control editor-ckeditor ays-ignore @error('main_description') is-invalid @enderror"
                                            data-counter="100000" rows="4" placeholder="Short main_description" id="main_description" wire:model='main_description'
                                            cols="50" name="main_description"></textarea>
                                        @error('main_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 position-relative" wire:ignore>
                                        <label class="form-label required" for="content">
                                            Short Description
                                        </label>
                                        <textarea class="form-control editor-ckeditor ays-ignore @error('short_description') is-invalid @enderror"
                                            data-counter="100000" name="short_description" rows="4" placeholder="Write your content" id="short_description"
                                            wire:model='short_description' cols="50"></textarea>

                                        @error('short_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 position-relative" wire:ignore>
                                        <label class="form-label form-label" for="youtube">
                                            Youtube Video Link
                                        </label>
                                        <input class="form-control @error('youtube_link') is-invalid @enderror"
                                            data-counter="250" placeholder="Please Enter Youtube Video Link"
                                            wire:model='youtube_link' name="youtube_link" type="text" id="youtube">

                                        @error('youtube_link')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <label class="form-label" for="images[]">
                                            Images
                                        </label>

                                        <div class="gallery-images-wrapper list-images form-fieldset">
                                            <div class="images-wrapper mb-2">
                                                <div data-bb-toggle="gallery-add"
                                                    class="text-center cursor-pointer default-placeholder-gallery-image"
                                                    data-name="images[]">
                                                    <div class="">
                                                        <!-- Show default images -->
                                                        <div class="row">
                                                            @foreach ($default_gallery_images as $key => $image)
                                                            <div class="col-md-2 col-4 mb-3 position-relative">
                                                                <img src="{{ Storage::url($image) }}" alt="Product Image" style="width: 100px; height: 100px" />
                                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-temp-image" wire:click="removeGallaryImage('existing', {{ $key }})">
                                                                    ×
                                                                </button>
                                                            </div>
                                                            @endforeach


                                                            <!-- Show uploaded images -->
                                                            @foreach ($gallery_images as $key => $image)
                                                            <div class="col-md-2 col-4 mb-3 position-relative">
                                                                <img src="{{ $image->temporaryUrl() }}" alt="Preview image" style="width: 100px; height: 100px" />
                                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-temp-image" wire:click="removeGallaryImage('new', {{ $key }})">
                                                                    ×
                                                                </button>
                                                            </div>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                    <p class="text-danger mb-0">1100 x 1100px</p>
                                                    <a href="javascript:void(0);" id="choose-image"
                                                        onclick="selectImage('gallery-input');"
                                                        class="mb-0 text-body">
                                                        Click here
                                                        to add more images.
                                                    </a>
                                                </div>

                                                <input name="images[]" type="file" name="gallery_images" id="gallery-input"
                                                    style="display: none;" accept="image/*"
                                                    wire:model="gallery_images" multiple>
                                                @error('gallery_images')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="main-manage-product-type">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Overview
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row price-group">
                                        <input class="detect-schedule d-none" name="sale_type" type="hidden"
                                            value="0">
                                        <div class="col-md-4">
                                            <div class="mb-3 position-relative">
                                                <label class="form-label" for="sku">
                                                    SKU
                                                </label>

                                                <input class="form-control @error('sku') is-invalid @enderror"
                                                    type="text" name="sku" id="sku" wire:model='sku'
                                                    placeholder="SKU" />
                                                @error('sku')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4" wire:ignore>
                                            <div class="mb-3 position-relative">
                                                <label class="form-label" for="price">
                                                    MRP Price
                                                </label>
                                                <div class="input-group input-group-flat">
                                                    <span class="input-group-text">₹</span>
                                                    <input class="form-control input-mask-number @error('price') is-invalid @enderror" name="price" type="number" wire:model='price' id="price" />
                                                    @error('price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3 position-relative">
                                                <label class="form-label" for="default_sale_price">
                                                    Default Sale Price
                                                </label>
                                                <div class="input-group input-group-flat">
                                                    <span class="input-group-text">₹</span>
                                                    <input
                                                        class="form-control input-mask-number @error('sale_default_price') is-invalid @enderror"
                                                        type="text" name="sale_default_price" wire:model='sale_default_price' id="default_sale_price" />
                                                    @error('sale_default_price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3 position-relative">
                                                <label class="form-label" for="sale_price">
                                                    Sale Price

                                                    <span class="form-label-description">
                                                        <a class="turn-on-schedule" href="javascript:void(0)"
                                                            id="turn-on-schedule">
                                                            Choose Discount Period
                                                        </a>
                                                        <a class="turn-off-schedule" style="display: none;"
                                                            href="javascript:void(0)" id="turn-off-schedule">
                                                            Cancel
                                                        </a>
                                                    </span>

                                                </label>

                                                <div class="input-group input-group-flat">

                                                    <span class="input-group-text">₹</span>

                                                    <input
                                                        class="form-control input-mask-number @error('discount') is-invalid @enderror" name="discount"
                                                        type="text" wire:model='discount' id="sale_price" />

                                                    @error('discount')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 scheduled-time" style="display: none;">
                                            <div class="mb-3 position-relative">
                                                <label class="form-label" for="start_date">
                                                    From date
                                                </label>
                                                <input name="discount_start_date"
                                                    class="form-control form-date-time @error('discount_start_date') is-invalid @enderror"
                                                    type="date" wire:model='discount_start_date' id="start_date"
                                                    placeholder="Y-m-d H:i:s" />
                                                @error('discount_start_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 scheduled-time" style="display: none;">
                                            <div class="mb-3 position-relative">
                                                <label class="form-label" for="end_date">
                                                    To date
                                                </label>
                                                <input name="discount_end_date"
                                                    class="form-control form-date-time @error('discount_end_date') is-invalid @enderror"
                                                    type="date" wire:model='discount_end_date' id="end_date"
                                                    placeholder="Y-m-d H:i:s" />

                                                @error('discount_end_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <fieldset class="form-fieldset stock-status-wrapper">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label" for="stock_status">
                                                    Stock status
                                                </label>
                                                <label class="form-check form-check-inline mb-3">
                                                    <input type="checkbox" wire:model='stock_status'
                                                        {{$stock_status == 1 ? 'checked' : ''}}
                                                        class="form-check-input storehouse-management-status @error('stock_status') is-invalid @enderror"
                                                        id="stockCheck" name="stock_status">

                                                    @error('stock_status')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror

                                                    <span class="form-check-label stock-text">
                                                        Out Of stock
                                                    </span>

                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="stock_status">
                                                    Is Bulk Inquiry Spported
                                                </label>
                                                <label
                                                    class="form-check form-check-inline mb-3 @error('is_bulk_inquiry_supported') is-invalid @enderror">
                                                    <input type="checkbox" wire:model='is_bulk_inquiry_supported'
                                                        class="form-check-input" name="is_bulk_inquiry_supported" {{$is_bulk_inquiry_supported == 1 ? 'checked' : ''}} id="stockCheck">

                                                    @error('is_bulk_inquiry_supported')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror

                                                    <span class="form-check-label stock-text">
                                                        Is Bulk Inquiry Spported?
                                                    </span>

                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-fieldset">
                                        <legend>
                                            <h3>Shipping</h3>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-3 col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="weight">
                                                        Weight (g)
                                                    </label>

                                                    <div class="input-group input-group-flat">
                                                        <span class="input-group-text">g</span>

                                                        <input
                                                            class="form-control input-mask-number @error('weight') is-invalid @enderror"
                                                            type="text" wire:model='weight' name="weight" id="weight" />
                                                        @error('weight')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="length">
                                                        Length (cm)
                                                    </label>

                                                    <div class="input-group input-group-flat">

                                                        <span class="input-group-text">cm</span>

                                                        <input name="length"
                                                            class="form-control input-mask-number @error('length') is-invalid @enderror"
                                                            type="text" wire:model='length' id="length" />

                                                        @error('length')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="wide">
                                                        Wide (cm)
                                                    </label>

                                                    <div class="input-group input-group-flat">

                                                        <span class="input-group-text">cm</span>

                                                        <input name="width"
                                                            class="form-control input-mask-number @error('width') is-invalid @enderror"
                                                            type="text" wire:model='width' id="wide" />
                                                        @error('width')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="height">
                                                        Height (cm)
                                                    </label>

                                                    <div class="input-group input-group-flat">

                                                        <span class="input-group-text">cm</span>

                                                        <input name="height"
                                                            class="form-control input-mask-number @error('height') is-invalid @enderror"
                                                            type="text" wire:model='height' id="height" />
                                                        @error('height')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="shipping_margin">
                                                        Shipping Bear Margin Charges
                                                    </label>

                                                    <div class="input-group input-group-flat">
                                                        <input name="shipping_margin"
                                                            class="form-control input-mask-number @error('shipping_margin') is-invalid @enderror"
                                                            type="number" wire:model='shipping_margin_br'
                                                            id="shipping_margin" />

                                                        @error('shipping_margin_br')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="pincode_excluded">
                                                        Pincode Excluded
                                                    </label>

                                                    <div class="input-group input-group-flat">
                                                        <textarea class="form-control @error('pincode_excluded') is-invalid @enderror" name="pincode_excluded" wire:model='pincode_excluded'
                                                            id="pincode_excluded" rows="3"></textarea>
                                                        @error('pincode_excluded')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-fieldset">
                                        <legend>
                                            <h3>Warranty</h3>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-3 col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="product_warranty">
                                                        Product Warranty Days
                                                    </label>

                                                    <div class="input-group input-group-flat">
                                                        <input name="product_warranty"
                                                            class="form-control input-mask-number @error('product_warranty') is-invalid @enderror"
                                                            type="text" wire:model='product_warranty'
                                                            id="product_warranty" />
                                                        @error('product_warranty')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="return_days">
                                                        Products Return Days
                                                    </label>

                                                    <div class="input-group input-group-flat">
                                                        <input name="return_days"
                                                            class="form-control input-mask-number @error('return_days') is-invalid @enderror"
                                                            type="text" wire:model='return_days'
                                                            id="return_days" />
                                                        @error('return_days')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label class="form-label" for="replacement_days">
                                                        Product Replacement Days
                                                    </label>

                                                    <div class="input-group input-group-flat">
                                                        <input name="replacement_days"
                                                            class="form-control input-mask-number @error('replacement_days') is-invalid @enderror"
                                                            type="text" wire:model='replacement_days'
                                                            id="replacement_days" />
                                                        @error('replacement_days')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Attributes
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <div class="add-new-product-attribute-wrap">
                                        <input id="is_added_attributes" name="is_added_attributes" type="hidden"
                                            value="0">
                                        <div class="row">
                                            <div class="col-12">
                                                <div
                                                    class="d-flex gap-2 align-items-start justify-content-start justify-content-md-end">
                                                    <div class="mb-3 position-relative">
                                                        <select
                                                            class="form-select @error('selectedAttribute') is-invalid @enderror" name="selectedAttribute"
                                                            wire:model="selectedAttribute" id="global-option">
                                                            <option value="">Select Global Option</option>
                                                            @foreach ($productAttributes as $productAttribute)
                                                            <option value="{{ $productAttribute->id }}">
                                                                {{ $productAttribute->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('selectedAttribute')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror

                                                    </div>
                                                    <button class="btn   add-from-global-option" type="button"
                                                        wire:click="addOption">
                                                        Add Global Option
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-product-attribute-values-wrap" style="display: none">
                                                <div class="product-select-attribute-item-template"></div>
                                            </div>
                                            <div class="accordion" id="">

                                                @foreach ($selectedOptions as $key => $option)
                                                <div class="accordion-item mb-3">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button" type="button"
                                                            wire:click="toggleAccordion('{{ $key }}')"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-option-{{ $option['id'] }}"
                                                            aria-expanded="true">
                                                            #{{ $option['name'] }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse-option-{{ $option['id'] }}"
                                                        class="accordion-collapse collapse {{ isset($openAccordions[$key]) && $openAccordions[$key] ? 'show' : '' }}">
                                                        <div class="accordion-body">
                                                            <table
                                                                class="table table-bordered setting-option mt-3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th class="">Label</th>
                                                                        @if($option['remove'] == true)
                                                                        <th>Delete</th>
                                                                        @endif
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($option['items'] as $index => $item)
                                                                    <tr>
                                                                        <td class="align-middle text-center">
                                                                            {{ $index + 1 }}
                                                                        </td>
                                                                        <td>
                                                                            <input
                                                                                class="form-check-input @error('selectedOptions.' . $option['id'] . '.is_default') is-invalid @enderror"
                                                                                type="radio"
                                                                                name="selectedOptions_{{ $option['id'] }}_is_default"
                                                                                wire:model="selectedOptions.{{ $option['id'] }}.is_default"
                                                                                value="{{ $index }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                wire:model="selectedOptions.{{ $option['id'] }}.items.{{ $index }}">
                                                                        </td>
                                                                        @if($option['remove'] == true)
                                                                        <td class="align-middle">
                                                                            <button class="btn btn-danger"
                                                                                type="button"
                                                                                wire:click="removeOption({{ $option['id'] }}, {{ $index }})">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </td>
                                                                        @endif
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <button type="button" class="btn add-new-row mt-3"
                                                                id="add-new-row"
                                                                wire:click="addRow({{ $option['id'] }})">Add new
                                                                row
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Variations
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <div class="add-new-product-attribute-wrap">
                                        <input id="is_added_attributes" name="is_added_attributes" type="hidden"
                                            value="0">
                                        <div class="row jsutify-content-end">
                                            <div class="col-12">
                                                <div
                                                    class="d-flex gap-2 align-items-start justify-content-start justify-content-md-end">
                                                    @foreach ($selectedOptions as $selectedOption)
                                                    <div class="mb-3 position-relative">
                                                        <select name="selectedVariation"
                                                            class="form-select @error('selectedVariation') is-invalid @enderror"
                                                            id="global-option"
                                                            wire:model="selectedVariation.{{ $selectedOption['id'] }}">
                                                            <option value="">Select Global Option</option>
                                                            @foreach ($selectedOption['items'] as $key => $item)
                                                            <option
                                                                value="{{ $selectedOption['id'] . ',' . $key }}">
                                                                {{ $item }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('selectedVariation')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    @endforeach
                                                    <button class="btn add-from-global-option" type="button"
                                                        wire:click="addOptionFromGlobal">
                                                        Add Global Option
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-product-attribute-values-wrap" style="display: none">
                                            <div class="product-select-attribute-item-template"></div>
                                        </div>

                                        <fieldset class="form-fieldset list-product-attribute-wrap"
                                            style="display: none;">
                                            <div class="list-product-attribute-items-wrap"></div>

                                            <div class="btn-list">
                                                <button class="btn   btn-trigger-add-attribute-item" type="button">
                                                    Add more attribute
                                                </button>
                                            </div>
                                        </fieldset>
                                        @php
                                        $i = 1;
                                        @endphp
                                        <div class="accordion" id="">
                                            @foreach ($selectedVariationOption as $key => $variationOption)

                                            @php
                                            $name = '';
                                            $keys_array = explode('|', $key);

                                            foreach ($keys_array as $value) {
                                            $value_array = explode(',', $value);
                                            if (isset($value_array[0]) && isset($value_array[1])) {
                                            $name .= $selectedOptions[$value_array[0]]['items'][$value_array[1]] . ' ';
                                            }
                                            }
                                            @endphp

                                            <div class="accordion-item mb-3">

                                                <!-- done  -->
                                                <div class="accordion-header d-flex align-items-center justify-content-between">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse"
                                                        wire:click="toggleAccordion('{{ $key }}')"
                                                        data-bs-target="#collapse-product-option-{{ $i }}"
                                                        aria-expanded="false">
                                                        {{ $name }}
                                                    </button>
                                                    @if($variationOption['details']['remove'] == true)
                                                    <a class="text-danger mx-2"
                                                        href="javascript:void(0);"
                                                        wire:click.prevent="removeVariation('{{ $key}}',{{$variationOption['details']['id'] }})">
                                                        Remove
                                                    </a>
                                                    @endif
                                                </div>

                                                <div id="collapse-product-option-{{ $i }}"
                                                    class="accordion-collapse collapse {{ isset($openAccordions[$key]) && $openAccordions[$key] ? 'show' : '' }}"
                                                    aria-labelledby="product-option-3"
                                                    data-bs-parent="#accordion-product-option">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class=" card-body">
                                                                    <div class="image-box image-box-image"
                                                                        action="select-image" data-counter="250">
                                                                        <input class="image-data" name="image"
                                                                            type="hidden" value=""
                                                                            data-counter="250">
                                                                        <label class="form-label">Featured image</label>
                                                                        <div style="width: 8rem"
                                                                            class="preview-image-wrapper mb-1">
                                                                            <div class="preview-image-inner">
                                                                                <a data-bb-toggle="image-picker-choose"
                                                                                    data-target="popup"
                                                                                    class="image-box-actions"
                                                                                    data-result="image"
                                                                                    data-action="select-image"
                                                                                    data-allow-thumb="1"
                                                                                    href="#">
                                                                                    @if(isset($selectedVariationOption[$key]))
                                                                                    @if(isset($selectedVariationOption[$key]['details']['image']) &&
                                                                                    $selectedVariationOption[$key]['details']['image'] instanceof \Illuminate\Http\UploadedFile)
                                                                                    <!-- Show temporary uploaded image -->
                                                                                    <img class="preview-image default-image"
                                                                                        data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                                                        src="{{ $selectedVariationOption[$key]['details']['image']->temporaryUrl() }}"
                                                                                        alt="Preview image">
                                                                                    @elseif(isset($selectedVariationOption[$key]['details']['existing_featured_image']) &&
                                                                                    !empty($selectedVariationOption[$key]['details']['existing_featured_image']))
                                                                                    <!-- Show existing image -->
                                                                                    <img class="preview-image default-image"
                                                                                        data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                                                        src="{{ Storage::url($selectedVariationOption[$key]['details']['existing_featured_image']) }}"
                                                                                        alt="Preview image">
                                                                                    @else
                                                                                    <!-- Show default placeholder -->
                                                                                    <img class="preview-image default-image"
                                                                                        data-default="{{ asset('vendor/core/core/core/base/images/placeholder.png') }}"
                                                                                        src="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                                                        alt="Preview image">
                                                                                    @endif
                                                                                    @endif
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <p class="text-danger mb-0">1100 x 1100px</p>
                                                                        <a href="javascript:void(0);"
                                                                            id="choose-image"
                                                                            onclick="selectImage('variation-image-{{ $i }}');">
                                                                            Choose image
                                                                        </a>
                                                                        <input type="file"
                                                                            id="variation-image-{{ $i }}"
                                                                            wire:model="selectedVariationOption.{{ $key }}.details.image"
                                                                            name="selectedVariationOption[{{ $key }}][details][image]"
                                                                            accept="image/*"
                                                                            style="display: none;">
                                                                        @error('selectedVariationOption.{{ $key }}.details.image')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mb-3">

                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label m-0">SKU</label>
                                                                    <input type="text" name="selectedVariationOption[{{ $key }}][details][sku]"
                                                                        class="form-control @error('selectedVariationOption.{{ $key }}.details.sku') is-invalid @enderror"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.sku">
                                                                    @error('selectedVariationOption.{{ $key }}.details.sku')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="stock_status">
                                                                    Stock status
                                                                </label>
                                                                <label class="form-check form-check-inline mb-3">
                                                                    <input type="checkbox" name="stock_status"
                                                                        wire:model='selectedVariationOption.{{ $key }}.details.stock_status'
                                                                        class="form-check-input storehouse-management-status @error('selectedVariationOption.{{ $key }}.details.stock_status') is-invalid @enderror"
                                                                        id="stockCheck">
                                                                    @error('selectedVariationOption.{{ $key }}.details.stock_status')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                    <span class="form-check-label stock-text">
                                                                        Out Of stock
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="stock_status">
                                                                    Is Active?
                                                                </label>
                                                                <label class="form-check form-switch d-inline-block ">
                                                                    <input wire:model="is_active" name="is_active" type="hidden" />
                                                                    <input name="is_active" class="form-check-input" wire:model="selectedVariationOption.{{ $key }}.details.is_active" type="checkbox"
                                                                        value="1" {{ (isset($selectedVariationOption[$key]['details']['is_active']) && $selectedVariationOption[$key]['details']['is_active'] == 1) ? 'checked' : '' }} id="selectedVariationOption.{{ $key }}.details.is_active" />
                                                                    @error('selectedVariationOption.{{ $key }}.details.is_active')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 position-relative">

                                                            <label class="form-label" for="images[]">
                                                                Images
                                                            </label>


                                                            <div
                                                                class="gallery-images-wrapper list-images form-fieldset">
                                                                <div class="images-wrapper mb-2">
                                                                    <div data-bb-toggle="gallery-add"
                                                                        class="text-center cursor-pointer default-placeholder-gallery-image"
                                                                        data-name="images[]">
                                                                        <div class="">
                                                                            <div class="row">
                                                                                @if(count($selectedVariationOption[$key]['details']['existing_gallery_images']) > 0 || count($selectedVariationOption[$key]['details']['gallery_images']) > 0)
                                                                                @foreach ($selectedVariationOption[$key]['details']['existing_gallery_images'] as $key1 => $image)
                                                                                <div
                                                                                    class="col-md-2 mb-2 position-relative">
                                                                                    <img src="{{Storage::url($image)}}"
                                                                                        alt="Product Image"
                                                                                        style="width: 100px; height: 100px" />
                                                                                    <button type="button"
                                                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-temp-image"
                                                                                        wire:click="removeGallaryImage('variationsExisting', '{{ $key }}', {{ $key1 }})">
                                                                                        ×
                                                                                    </button>
                                                                                </div>
                                                                                @endforeach

                                                                                @foreach ($selectedVariationOption[$key]['details']['gallery_images'] as $key1 => $image)
                                                                                <div class="col-md-2 col-4 mb-3 position-relative">
                                                                                    <div class="gallery-image-wrapper">
                                                                                        @if (is_object($image))
                                                                                        <img src="{{ $image->temporaryUrl() }}" alt="Product Image" class="img-fluid rounded shadow-sm" />
                                                                                        @else
                                                                                        <img src="{{ Storage::url($image) }}" alt="Product Image" class="img-fluid rounded shadow-sm" />
                                                                                        @endif
                                                                                        <button type="button"
                                                                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-temp-image"
                                                                                            wire:click="removeGallaryImage('variationsNew', '{{ $key }}', {{ $key1 }})">
                                                                                            ×
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                                @endforeach


                                                                                @else
                                                                                <div class="mb-3">
                                                                                    <svg class="icon icon-md text-secondary svg-icon-ti-ti-photo-plus"
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24"
                                                                                        height="24"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round">
                                                                                        <path stroke="none"
                                                                                            d="M0 0h24v24H0z"
                                                                                            fill="none" />
                                                                                        <path d="M15 8h.01" />
                                                                                        <path
                                                                                            d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5" />
                                                                                        <path
                                                                                            d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4" />
                                                                                        <path
                                                                                            d="M14 14l1 -1c.67 -.644 1.45 -.824 2.182 -.54" />
                                                                                        <path d="M16 19h6" />
                                                                                        <path d="M19 16v6" />
                                                                                    </svg>
                                                                                </div>
                                                                                @endif
                                                                            </div>

                                                                        </div>
                                                                        <p class="text-danger mb-0">1100 x 1100px</p>
                                                                        <a href="javascript:void(0);"
                                                                            id="choose-image"
                                                                            onclick="selectImage('gallery-input-{{ $i }}');"
                                                                            class="mb-0 text-body">
                                                                            Click here
                                                                            to add more images.
                                                                        </a>
                                                                    </div>
                                                                    @php
                                                                    $count = count(
                                                                    $selectedVariationOption[$key][
                                                                    'details'
                                                                    ]['gallery_images'],
                                                                    );
                                                                    @endphp
                                                                    <input type="file"
                                                                        id="gallery-input-{{ $i }}"
                                                                        style="display: none;" accept="image/*"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.gallery_images" multiple name="selectedVariationOption[{{ $key }}][details][gallery_images]">

                                                                    @error('selectedVariationOption.{{ $key }}.details.gallery_images')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label ">Mrp Price</label>
                                                                    <input type="text" name="selectedVariationOption"
                                                                        class="form-control @error('selectedVariationOption.{{ $key }}.details.regular_price') is-invalid @enderror"
                                                                        id="exampleInputEmail1"
                                                                        aria-describedby="emailHelp"
                                                                        name="selectedVariationOption[{{ $key }}][details][regular_price]"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.regular_price"
                                                                        placeholder="Variation Price (required)">
                                                                    @error('selectedVariationOption.{{ $key }}.details.regular_price')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">

                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label ">Sale Default Price</label>
                                                                    <input type="text" name="selectedVariationOption"
                                                                        class="form-control @error('selectedVariationOption.{{ $key }}.details.sale_default_price') is-invalid @enderror"
                                                                        id="exampleInputEmail1"
                                                                        name="selectedVariationOption[{{ $key }}][details][sale_default_price]"
                                                                        aria-describedby="emailHelp"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.sale_default_price"
                                                                        placeholder="Variation Price (required)">
                                                                    @error('selectedVariationOption.{{ $key }}.details.sale_default_price')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <div class="form-label d-flex justify-content-between">Sale Price
                                                                        <div class="d-flex justify-content-end">
                                                                            <a class="variations-turn-on-schedule" href="javascript:void(0)"
                                                                                id="variations-turn-on-schedule-{{ $i }}">
                                                                                Choose Discount Period
                                                                            </a>
                                                                            <a class="variations-turn-off-schedule"
                                                                                style="display: none;" href="javascript:void(0)"
                                                                                id="variations-turn-off-schedule-{{ $i }}">
                                                                                Cancel
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <input type="text" name="selectedVariationOption.{{ $key }}.details.sale_price"
                                                                        class="form-control @error('selectedVariationOption.{{ $key }}.details.sale_price') is-invalid @enderror"
                                                                        id="exampleInputPassword1"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.sale_price">
                                                                    @error('selectedVariationOption.{{ $key }}.details.sale_price')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"
                                                                id="variations-scheduled-time-start-{{$i}}"
                                                                style="display: none;">
                                                                <div class="mb-3 position-relative">
                                                                    <label class="form-label" for="start_date_1">
                                                                        From date
                                                                    </label>
                                                                    <input name="selectedVariationOption[{{ $key }}][details][from_date]"
                                                                        class="form-control form-date-time @error('selectedVariationOption.{{ $key }}.details.from_date') is-invalid @enderror"
                                                                        type="date" id="start_date_1"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.from_date"
                                                                        placeholder="Y-m-d H:i:s" />
                                                                    @error('selectedVariationOption.{{ $key }}.details.from_date')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6"
                                                                id="variations-scheduled-time-end-{{$i}}"
                                                                style="display: none;">
                                                                <div class="mb-3 position-relative">
                                                                    <label class="form-label" for="end_date_1">
                                                                        To date
                                                                    </label>
                                                                    <input name="selectedVariationOption[{{ $key }}][details][sale_date]"
                                                                        class="form-control form-date-time @error('selectedVariationOption.{{ $key }}.details.sale_date') is-invalid @enderror"
                                                                        type="date" id="end_date_1"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.sale_date"
                                                                        placeholder="Y-m-d H:i:s" />
                                                                    @error('selectedVariationOption.{{ $key }}.details.sale_date')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label @error('name') is-invalid @enderror">Weight(gm)</label>
                                                                    <input type="text"
                                                                        name="selectedVariationOption[{{ $key }}][details][weight]"
                                                                        class="form-control @error('selectedVariationOption.{{ $key }}.details.weight') is-invalid @enderror"
                                                                        id="exampleInputEmail1"
                                                                        aria-describedby="emailHelp"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.weight">
                                                                    @error('selectedVariationOption.{{ $key }}.details.weight')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="exampleInputEmail1"
                                                                    class="form-label ">Dimensions (L x W x
                                                                    H)(cm)
                                                                </label>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <input type="text"
                                                                                name="selectedVariationOption[{{ $key }}][details][length]"
                                                                                class="form-control @error('selectedVariationOption.{{ $key }}.details.length') is-invalid @enderror"
                                                                                id="exampleInputEmail1"
                                                                                aria-describedby="emailHelp"
                                                                                placeholder="Length"
                                                                                wire:model="selectedVariationOption.{{ $key }}.details.length">
                                                                            @error('selectedVariationOption.{{ $key }}.details.length')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <input type="text"
                                                                                name="selectedVariationOption[{{ $key }}][details][width]"
                                                                                class="form-control @error('selectedVariationOption.{{ $key }}.details.width') is-invalid @enderror"
                                                                                id="exampleInputEmail1"
                                                                                aria-describedby="emailHelp"
                                                                                wire:model="selectedVariationOption.{{ $key }}.details.width"
                                                                                placeholder="Width">
                                                                            @error('selectedVariationOption.{{ $key }}.details.width')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <input type="text"
                                                                                name="selectedVariationOption[{{ $key }}][details][height]"
                                                                                class="form-control @error('selectedVariationOption.{{ $key }}.details.height') is-invalid @enderror"
                                                                                id="exampleInputEmail1"
                                                                                aria-describedby="emailHelp"
                                                                                wire:model="selectedVariationOption.{{ $key }}.details.height"
                                                                                placeholder="Height">
                                                                            @error('selectedVariationOption.{{ $key }}.details.height')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label @error('name') is-invalid @enderror">Shipping Bear Margin Charges</label>
                                                                    <input type="number"
                                                                        name="selectedVariationOption[{{ $key }}][details][weight]"
                                                                        class="form-control @error('selectedVariationOption.{{ $key }}.details.shipping_margin_br') is-invalid @enderror"
                                                                        id="exampleInputEmail1"
                                                                        aria-describedby="emailHelp"
                                                                        wire:model="selectedVariationOption.{{ $key }}.details.shipping_margin_br">
                                                                    @error('selectedVariationOption.{{ $key }}.details.shipping_margin_br')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 position-relative" wire:ignore>

                                                                <label class="form-label" for="description">
                                                                    Description
                                                                </label>
                                                                <textarea
                                                                    name="selectedVariationOption[{{ $key }}][details][description]"
                                                                    class="form-control @error('selectedVariationOption.{{ $key }}.details.description') is-invalid @enderror"
                                                                    data-counter="100000" rows="4" placeholder="Short description"
                                                                    wire:model="selectedVariationOption.{{ $key }}.details.description" cols="50"></textarea>
                                                                @error('selectedVariationOption.{{ $key }}.details.description')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                            $i++;
                                            @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3 product-specification-table">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Specification Tables
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <div class="specification-table">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-vcenter card-table table-hover table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Attribute
                                                        </th>
                                                        <th>
                                                            Attribute value
                                                        </th>
                                                        <th class="text-center" style="width: 40px;">
                                                            Actions
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="ui-sortable">
                                                    @foreach ($specifications as $key => $specification)
                                                    <tr class="ui-sortable-handle">
                                                        <td>
                                                            <input class="form-control" type="text"
                                                                wire:model="specifications.{{ $key }}.name">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text"
                                                                wire:model="specifications.{{ $key }}.value">
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="javascript:void(0);"
                                                                wire:click.prevent="removeSpecificationAttribute({{ $key }})"
                                                                class="remove-item text-decoration-none text-danger"><i
                                                                    class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <button class="btn mt-2" type="button"
                                        wire:click="addSpecificationAttribute">Add new Specification</button>
                                </div>
                            </div>
                        </div>

                        <div id="advanced-sortables" class="meta-box-sortables">

                            <div class="card meta-boxes mb-3" id="seo_wrap">

                                <div class="card-header">
                                    <h4 class="card-title">
                                        <label class="form-label" for="seo_meta[seo_title]">
                                            SEO Configuration
                                        </label>
                                    </h4>
                                </div>
                                <div class="card-body">

                                    <div class="seo-edit-section" v-pre>

                                        <div class="mb-3 position-relative">

                                            <label class="form-label" for="seo_meta[seo_title]">
                                                SEO Title
                                            </label>

                                            <input class="form-control @error('seo_title') is-invalid @enderror"
                                                data-counter="70" placeholder="SEO Title" data-allow-over-limit
                                                type="text" id="seo_meta[seo_title]" name="seo_title" wire:model="seo_title">
                                            @error('seo_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 position-relative">

                                            <label class="form-label" for="seo_meta[seo_meta]">
                                                SEO Meta
                                            </label>

                                            <input name="seo_meta" class="form-control @error('seo_meta') is-invalid @enderror"
                                                data-counter="70" placeholder="SEO Meta" data-allow-over-limit
                                                wire:model="seo_meta" type="text" id="seo_meta">
                                            @error('seo_meta')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 position-relative" wire:ignore>

                                            <label class="form-label" for="seo_meta[seo_description]">
                                                SEO description
                                            </label>
                                            <textarea name="seo_description" class="form-control editor-ckeditor @error('seo_description') is-invalid @enderror" id="seo_description"
                                                data-counter="160" rows="3" placeholder="SEO description" data-allow-over-limit id="seo_description"
                                                wire:model="seo_description" cols="2"></textarea>
                                            @error('seo_description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3 gap-3 d-flex flex-column-reverse flex-md-column mb-md-0 mb-5" wire:key="second-content" wire:ignore>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Publish
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="btn-list">
                                    <button class="btn btn-primary" type="submit" value="apply" name="submitter">
                                        Save
                                    </button>

                                </div>
                            </div>
                        </div>

                        <div data-bb-waypoint data-bb-target="#form-actions"></div>

                        <header class="top-0 w-100 position-fixed end-0 z-1000" id="form-actions"
                            style="display: none;">
                            <div class="navbar">
                                <div class="container-xl">
                                    <div class="row g-2 align-items-center w-100">
                                        <div class="col">
                                            <div class="page-pretitle">
                                                <nav aria-label="breadcrumb">
                                                    <ol class="breadcrumb">
                                                    </ol>
                                                </nav>
                                            </div>
                                        </div>
                                        <div class="col-auto ms-auto d-print-none">
                                            <div class="btn-list">
                                                <button class="btn btn-primary" type="submit" value="apply"
                                                    name="submitter">
                                                    Save
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>

                        <div class="card meta-boxes">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <label class="form-label form-label required" for="status">
                                        Status
                                    </label>
                                </h4>
                            </div>


                            <div class=" card-body">
                                <select name="status" class="form-control form-select @error('status') is-invalid @enderror"
                                    required="required" id="status-select-10813" wire:model="status">
                                    <option {{$status == 1 ? 'selected' : ''}} value="published">Published</option>
                                    <option {{$status == 0 ? 'selected' : ''}} value="draft">Draft</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="card meta-boxes">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <label class="form-label" for="is_featured">
                                        Is featured?
                                    </label>
                                </h4>
                            </div>

                            <div class=" card-body">
                                <label class="form-check form-switch d-inline-block ">
                                    <input wire:model="is_featured" name="is_featured" type="hidden" value="0" />
                                    <input name="is_featured" class="form-check-input" wire:model="is_featured" type="checkbox"
                                        value="1" {{ $is_featured == 1 ? 'checked' : '' }} id="is_featured" />
                                    @error('is_featured')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </label>
                            </div>
                        </div>

                        <div class="card meta-boxes">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <label class="form-label" for="is_active">
                                        Is Active?
                                    </label>
                                </h4>
                            </div>

                            <div class=" card-body">
                                <label class="form-check form-switch d-inline-block ">
                                    <input wire:model="is_active" name="is_active" type="hidden" />
                                    <input name="is_active" class="form-check-input" wire:model="is_active" type="checkbox"
                                        value="1" {{ $is_active == 1 ? 'checked' : '' }} id="is_active" />
                                    @error('is_active')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </label>
                            </div>
                        </div>
                        <div class="card meta-boxes">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <label class="form-label" for="categories[]">
                                        Categories
                                    </label>
                                </h4>
                            </div>


                            <div class=" card-body">
                                <div class="mb-3">
                                    <div class="input-icon">
                                        <input type="text" id="search-category-input-1676138032"
                                            class="form-control" placeholder="Search..."
                                            wire:model.live="categoriesSearch" />
                                        <span class="input-icon-addon">
                                            <svg class="icon  svg-icon-ti-ti-search"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg> </span>
                                    </div>
                                </div>

                                <div class="">
                                    <ul class="list-unstyled ms-4 mt-2">
                                        @foreach ($productCategories as $productCategory)
                                        <li>
                                            <label class="form-check mt-2">

                                                <input type="checkbox" name="selectedCategories" wire:model="selectedCategories"
                                                    wire:change="updateCategories({{ $productCategory['id'] }})"
                                                    class="form-check-input"
                                                    value="{{ $productCategory['id'] }}"
                                                    @if (in_array($productCategory['id'], $selectedCategories)) {{ 'checked' }} @endif>
                                                <span class="form-check-label">
                                                    {{ $productCategory['name'] }}
                                                </span>
                                            </label>

                                            @if (!empty($productCategory['items']))
                                            <ul class="list-unstyled ms-4 mt-2">
                                                @foreach ($productCategory['items'] as $childCategory)
                                                <li>
                                                    <label class="form-check mt-2">

                                                        <input type="checkbox" name="selectedCategories"
                                                            wire:model="selectedCategories"
                                                            wire:change="updateCategories({{ $childCategory['id'] }})"
                                                            class="form-check-input"
                                                            value="{{ $childCategory['id'] }}"
                                                            @if (in_array($childCategory['id'], $selectedCategories)) {{ 'checked' }} @endif>
                                                        <span class="form-check-label">
                                                            {{ $childCategory['name'] }}
                                                        </span>
                                                    </label>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card meta-boxes" wire:ignore>
                            <div class="card-header">
                                <h4 class="card-title">
                                    <label class="form-label" for="brand_select">
                                        Brands
                                    </label>
                                </h4>
                            </div>
                            <div class="card-body">
                                <select name="brand_id"
                                    class="select-search-full form-select select2 @error('brand_id') is-invalid @enderror"
                                    data-placeholder="Select a brand..."
                                    data-allow-clear="true"
                                    id="brand_select"
                                    multiple>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ in_array($brand->id, $brand_id ?? []) ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- Products Section -->
                        <div class="card meta-boxes">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <label class="form-label">Products</label>
                                </h4>
                            </div>
                            <div class="card-body">
                                <!-- Related Products -->
                                <div class="form-group" wire:ignore>
                                    <label for="related_products_select">Select Related Product</label>
                                    <select class="select-search-full form-select select2 @error('related_products') is-invalid @enderror" name="related_products"
                                        id="related_products_select" multiple>
                                        @foreach ($all_products as $related_product)
                                        <option value="{{ $related_product->id }}"
                                            @if(in_array($related_product->id, $related_products ?? [])) selected @endif>
                                            {{ $related_product->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('related_products')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Linked Products -->
                                <div class="form-group" wire:ignore>
                                    <label for="linked_products_select">Select Linked Product</label>
                                    <select class="select-search-full form-select select2 @error('linked_products') is-invalid @enderror" name="linked_products"
                                        id="linked_products_select" multiple>
                                        @foreach ($all_products as $linked_product)
                                        <option value="{{ $linked_product->id }}"
                                            @if(in_array($linked_product->id, $linked_products ?? [])) selected @endif>
                                            {{ $linked_product->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('linked_products')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card meta-boxes">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <label class="form-label" for="image">
                                        Featured image
                                    </label>
                                </h4>
                            </div>


                            <div class=" card-body">
                                <div class="image-box image-box-image" action="select-image" data-counter="250">
                                    <input class="image-data" name="image" type="hidden" value=""
                                        class="" data-counter="250" />
                                    <div style="width: 8rem" class="preview-image-wrapper mb-1">
                                        <div class="preview-image-inner">
                                            <a data-bb-toggle="image-picker-choose" data-target="popup"
                                                class="image-box-actions" data-result="image"
                                                data-action="select-image" data-allow-thumb="1" href="#">

                                                @if ( !$featured_image && $defaultFeaturedImage)

                                                <img src="{{ Storage::url($defaultFeaturedImage) }}"
                                                    alt="Product Image"
                                                    class="rounded mx-auto d-block"
                                                    style="height: 100px; width: 100px;" />
                                                <span class="image-picker-backdrop"></span>
                                                @else
                                                <img class="preview-image default-image"
                                                    data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                    src="{{ $featured_image->temporaryUrl() }}"
                                                    alt="Preview image" />
                                                <span class="image-picker-backdrop"></span>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                    <p class="text-danger mb-0">1100 x 1100px</p>
                                    <a href="javascript:void(0);" id="choose-image"
                                        onclick="selectImage('featured-image-input');">
                                        Choose image
                                    </a>
                                    <input type="file" id="featured-image-input" style="display: none;"
                                        accept="image/*" name="featured_image           " wire:model="featured_image">
                                    @error('featured_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    function selectImage(id) {
        $(`#${id}`).click();
    };

    function select2Function(id) {
        var value = $(id).val();
        @this.call(updateValues, id, value);
    }
</script>
<script>
    $(document).ready(function() {
        $("#turn-on-schedule").click(function() {
            $(".scheduled-time").show();
            $(this).hide();
            $("#turn-off-schedule").show();
        });

        $("#turn-off-schedule").click(function() {
            $(".scheduled-time").hide();
            $(this).hide();
            $("#turn-on-schedule").show();
        });

        //variations
        $(document).on("click", "[id^='variations-turn-on-schedule-']", function() {
            let index = $(this).attr("id").split("-").pop();
            $("#variations-scheduled-time-start-" + index).show();
            $("#variations-scheduled-time-end-" + index).show();
            $("#variations-turn-on-schedule-" + index).hide();
            $("#variations-turn-off-schedule-" + index).show();
        });

        $(document).on("click", "[id^='variations-turn-off-schedule-']", function() {
            let index = $(this).attr("id").split("-").pop();
            $("#variations-scheduled-time-start-" + index).hide();
            $("#variations-scheduled-time-end-" + index).hide();
            $("#variations-turn-off-schedule-" + index).hide();
            $("#variations-turn-on-schedule-" + index).show();
        });
    });
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font
    } from 'ckeditor5';

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.editor-ckeditor').forEach(element => {
            ClassicEditor
                .create(element, {
                    plugins: [Essentials, Paragraph, Bold, Italic, Font],
                    toolbar: [
                        'undo', 'redo', '|', 'bold', 'italic', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                    ]
                })
                .then(editor => {
                    // Set initial content from Livewire
                    editor.setData(@this.get(element.getAttribute('id')));

                    // Sync Livewire when data changes
                    editor.model.document.on('change:data', () => {
                        const data = editor.getData();
                        @this.set(element.getAttribute('id'), data);
                    });

                    // Listen for Livewire updates and sync CKEditor
                    Livewire.hook('message.processed', (message, component) => {
                        if (document.getElementById(element.getAttribute('id'))) {
                            editor.setData(@this.get(element.getAttribute('id')));
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
    document.addEventListener('livewire:init', () => {
        // Initialize Select2 for all selects
        $('#brand_select').select2();
        $('#related_products_select').select2();
        $('#linked_products_select').select2();

        // Handle brand select changes
        $('#brand_select').on('change', function() {
            @this.set('brand_id', $(this).val());
        });

        // Handle related products select changes
        $('#related_products_select').on('change', function() {
            @this.set('related_products', $(this).val());
        });

        // Handle linked products select changes
        $('#linked_products_select').on('change', function() {
            @this.set('linked_products', $(this).val());
        });

        // Optional: Reset handlers if needed
        Livewire.on('resetSelects', () => {
            $('#brand_select').val(null).trigger('change');
            $('#related_products_select').val(null).trigger('change');
            $('#linked_products_select').val(null).trigger('change');
        });
    });
</script>
@endsection