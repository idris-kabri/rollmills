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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Banner</h1>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Edit Banner</h1>
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
                <div class="col-md-12">
                    <div class="card tree-form-container">
                        <div class="card-body tree-form-body">
                            <form enctype="multipart/form-data" wire:submit.prevent="update">
                                @csrf
                                <div class="mb-3 position-relative">
                                    <label class="form-label required" for="banner_type">Banner Type</label>
                                    <select name="banner_type"
                                        class="form-control form-select @error('banner_type') is-invalid @enderror"
                                        wire:model.live="banner_type">
                                        <option value="">--select--</option>
                                        <option value="slider_banner">Slider Banner</option>
                                        <option value="top_side_banner">Top Side Banner</option>
                                        <option value="middle_page_banner">Middle Page Banner</option>
                                        <option value="daily_best_deals">Daily Best Deals</option>
                                        <option value="user_looks_for">User looks for</option>
                                        <option value="shop_page_banner">Shop Page Banner</option>
                                    </select>
                                    @error('banner_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- heading div  -->
                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="heading">Heading</label>
                                    <input name="heading" class="form-control @error('heading') is-invalid @enderror"
                                        placeholder="Heading" type="text" wire:model="heading">
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- sub heading div  -->
                                <div class="mb-3 position-relative" wire:ignore>
                                    <label class="form-label" for="sub_heading">Sub Heading</label>
                                    <textarea name="sub_heading" class="form-control editor-ckeditor @error('sub_heading') is-invalid @enderror"
                                        rows="4" placeholder="Write Sub Heading" name="sub_heading" id="sub_heading" cols="50"
                                        wire:model="sub_heading">{{ $sub_heading }}</textarea>
                                    @error('sub_heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- button text div  -->
                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="heading">Button Text</label>
                                    <input name="button_text"
                                        class="form-control @error('button_text') is-invalid @enderror"
                                        placeholder="Button Text" type="text" wire:model="button_text">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label form-label required" for="status">Status</label>
                                    <select name="status"
                                        class="form-control form-select @error('status') is-invalid @enderror"
                                        wire:model="status">
                                        <option value="" selected disabled>Plase Select Status</option>
                                        <option value="0">In Active</option>
                                        <option value="1">Active</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label required" for="banner_type">Audience</label>
                                    <select name="audience"
                                        class="form-control form-select @error('banner_type') is-invalid @enderror"
                                        wire:model="audience" multiple>
                                        <option value="guest"
                                            @if (in_array('guest', $audience)) {{ 'selected' }} @endif>Guest</option>
                                        <option value="premium_customer"
                                            @if (in_array('premium_customer', $audience)) {{ 'selected' }} @endif>Premium
                                            Customer</option>
                                        <option value="registered_user"
                                            @if (in_array('registered_user', $audience)) {{ 'selected' }} @endif>Registered User
                                        </option>
                                    </select>
                                    @error('audience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="image">Image</label>
                                    <div class="image-box image-box-image" action="select-image" data-counter="250">
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
                                                        src="{{ $image->temporaryUrl() }}" alt="Preview image" />
                                                    <span class="image-picker-backdrop"></span>
                                                </div>
                                            </div>
                                        @endif

                                        <a data-bb-toggle="image-picker-choose" data-target="popup"
                                            data-result="image" data-action="select-image" data-allow-thumb="1"
                                            href="javascript:void(0)" id="chooseImage" onclick="openImage()">
                                            Choose image
                                        </a>
                                        <input name="image" type="file" id="imageInput" wire:model="image"
                                            accept="image/*" style="display: none;" />
                                        <br />
                                        @if ($banner_type == 'slider_banner')
                                            <span class="text-danger">1200 X 615px</span>
                                        @elseif($banner_type == 'top_side_banner')
                                            <span class="text-danger">1024 X 1076px</span>
                                        @elseif($banner_type == 'middle_page_banner')
                                            <span class="text-danger">443 X 259px</span>
                                        @elseif($banner_type == 'daily_best_deals')
                                            <span class="text-danger">540 X 769px</span>
                                        @elseif($banner_type == 'user_looks_for')
                                            <span class="text-danger">540 X 769px</span>
                                        @elseif($banner_type == 'shop_page_banner')
                                            <span class="text-danger">1024 X 1076px</span>
                                        @endif
                                        <br />
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="link">Link</label>
                                    <input name="link" class="form-control @error('link') is-invalid @enderror"
                                        placeholder="Link" type="text" wire:model="link">
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-check form-switch d-inline-block">
                                        <input name="is_default" type="hidden" value="0" />
                                        <input class="form-check-input" wire:model="is_default" type="checkbox"
                                            value="1" id="is_featured"
                                            {{ $is_default == 1 ? 'checked' : '' }} />
                                        <span class="form-check-label">Is Default?</span>
                                    </label>
                                </div>

                                @if ($is_default == 0)
                                    <div class="row">
                                        <div class="col-md-6 mb-3 position-relative">
                                            <label class="form-label" for="start-date">Start Date</label>
                                            <input class="form-control @error('start_time') is-invalid @enderror"
                                                type="date" wire:model="start_time">
                                            @error('start_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3 position-relative">
                                            <label class="form-label" for="end-date">End Date</label>
                                            <input class="form-control @error('end_time') is-invalid @enderror"
                                                type="date" wire:model="end_time">
                                            @error('end_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

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
                        Copyright 2025 © Roll Mills Store.
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

@section('scripts')
    <script type="module">
        import {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Font
        } from 'ckeditor5';

        document.querySelectorAll('.editor-ckeditor').forEach(element => {
            ClassicEditor
                .create(element, {
                    plugins: [Essentials, Paragraph, Bold, Italic, Font],
                    toolbar: [
                        'undo', 'redo', '|', 'bold', 'italic', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                    ],
                    // Set custom height
                    height: '400px' // You can change this value to your desired height
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        const data = editor.getData();
                        @this.set(element.getAttribute('id'), data);
                        $(element.getAttribute('id')).val(data); // Sync with the textarea
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <script>
        function openImage() {
            $('#imageInput').click();
        }
    </script>
@endsection
