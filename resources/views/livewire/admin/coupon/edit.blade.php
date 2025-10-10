<div class="page-wrapper"> 
    <div wire:loading.delay wire:target="update" class="loader-overlay" style="display: none !important;">
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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Coupon</h1>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Edit Coupon</h1>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body page-content" wire:ignore>
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="my-2 text-end">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card tree-form-container">
                        <div class="card-body tree-form-body">
                            <form enctype="multipart/form-data" wire:submit.prevent="update">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="image">Image</label>
                                        <div class="d-flex">
                                            <div class="image-box image-box-image" action="select-image"
                                                data-counter="250">
                                                <input class="image-data" name="image" type="hidden"
                                                    value="" />
                                                @if (!$image && $defaultImage)
                                                    <div style="width: 8rem" class="preview-image-wrapper mb-1">
                                                        <div class="preview-image-inner">
                                                            <img class="preview-image default-image"
                                                                data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                                src="{{ asset('storage/' . $defaultImage) }}"
                                                                alt="Preview image" />
                                                            <span class="image-picker-backdrop"></span>
                                                        </div>
                                                    </div>
                                                @elseif($image)
                                                    <div style="width: 8rem" class="preview-image-wrapper mb-1">
                                                        <div class="preview-image-inner">
                                                            <img class="preview-image default-image"
                                                                data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                                src="{{ $image->temporaryUrl() }}"
                                                                alt="Preview image" />
                                                            <span class="image-picker-backdrop"></span>
                                                        </div>
                                                    </div>
                                                @endif


                                                <a data-bb-toggle="image-picker-choose" data-target="popup"
                                                    data-result="image" data-action="select-image" data-allow-thumb="1"
                                                    href="javascript:void(0)" id="chooseImage" onclick="openImage()">
                                                    Choose image
                                                </a>
                                                <input type="file" id="imageInput" wire:model="image"
                                                    accept="image/*" style="display: none;" />
                                            </div>
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3 position-relative col-md-6" wire:ignore>
                                        <label class="form-label" for="seo_title">Category</label>
                                        <select id="category_select"
                                            class="form-control select-search-full form-1select select2 @error('category') is-invalid @enderror"
                                            wire:model="category" multiple name="category[]">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror


                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="name">Coupon Code</label>
                                        <input class="form-control @error('coupon_code') is-invalid @enderror"
                                            placeholder="Coupon Code" name="coupon_code" type="text"
                                            wire:model="coupon_code">
                                        @error('coupon_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="name">Title</label>
                                        <input class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Title" name="title" type="text" wire:model="title">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label form-label required" for="status">Discount
                                            Type</label>
                                        <select
                                            class="form-control form-select @error('discount_type') is-invalid @enderror"
                                            name="discount_type" wire:model="discount_type">
                                            {{-- <option value="" selected disabled>Select Discount Type</option> --}}
                                            <option value="Percentage">Percentage</option>
                                            <option value="Amount">Amount</option>
                                        </select>
                                        @error('discount_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="seo_keyword">Min Order Value</label>
                                        <input class="form-control @error('minimum_order_value') is-invalid @enderror"
                                            placeholder="Min Order Value" name="minimum_order_value" type="text"
                                            wire:model="minimum_order_value">
                                        @error('minimum_order_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="seo_keyword">Discount Value</label>
                                        <input class="form-control @error('discount_value') is-invalid @enderror"
                                            placeholder="Discount Value" name="discount_value" type="text"
                                            wire:model="discount_value">
                                        @error('discount_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="seo_keyword">Max Discount Amount</label>
                                        <input
                                            class="form-control @error('maximum_discount_amount') is-invalid @enderror"
                                            placeholder="Max Discount Amount" name="maximum_discount_amount" type="text"
                                            wire:model="maximum_discount_amount">
                                        @error('maximum_discount_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="seo_keyword">Usage Limit</label>
                                        <input class="form-control @error('usage_limit') is-invalid @enderror"
                                            placeholder="Usage Limit" name="usage_limit" type="text"
                                            wire:model="usage_limit">
                                        @error('usage_limit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="seo_keyword">Total Usage</label>
                                        <input class="form-control @error('total_usage') is-invalid @enderror"
                                            placeholder="Total Usage" name="total_usage" type="text"
                                            wire:model="total_usage">
                                        @error('total_usage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 position-relative">
                                        <label class="form-label" for="seo_keyword">Expiry Date</label>
                                        <input class="form-control @error('expiry_date') is-invalid @enderror"
                                            placeholder="Expiry Date" name="expiry_date" type="date"
                                            wire:model="expiry_date">
                                        @error('expiry_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" value="apply" name="submitter">
                                    Save
                                </button>
                            </form>
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
        function openImage() {
            $('#imageInput').click();
        }
        document.addEventListener('livewire:init', () => {
            // Initialize Select2
            $('#category_select').select2({
                placeholder: "Select categories",
                allowClear: true
            });

            // Livewire hook to update Select2 when Livewire updates
            Livewire.hook('element.updated', (el, component) => {
                if (el.id === 'category_select') {
                    $('#category_select').select2();
                }
            });

            // Update Livewire when Select2 changes
            $('#category_select').on('change', function() {
                let data = $(this).val();
                @this.set('category', data, true); // The 'true' parameter ensures Livewire updates
            });
        });
    </script>
@endsection
