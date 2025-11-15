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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Product categories</h1>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Create Product categories</h1>
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
                                    <label class="form-label" for="name">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                        name="name" type="text" wire:model="name">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative" wire:ignore>
                                    <label class="form-label" for="parent_id">Parent</label>
                                    <select
                                        class="select-search-full form-select @error('parent_id') is-invalid @enderror"
                                        data-allow-clear="false" id="parent_id-select-34415"
                                        wire:model="parent_category_id" onchange="callFunction()" data-placeholder="Select Parent Category">
                                        <option value="">Selecty Parent Category</option>
                                        @foreach ($parent_categories as $parent_category)
                                        <option value="{{ $parent_category->id }}"
                                            {{ $parent_category->id == $this->parent_category_id ? 'selected' : '' }}>
                                            {{ $parent_category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative" wire:ignore>
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control form-control editor-ckeditor ays-ignore @error('description') is-invalid @enderror"
                                        rows="4" placeholder="Write Description" id="description" name="description" cols="50"
                                        wire:model="description"></textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label form-label required" for="status">Status</label>
                                    <select class="form-control form-select @error('status') is-invalid @enderror"
                                        name="status" wire:model="status">
                                        <option value="1">Published</option>
                                        <option value="2">Pending</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="image">Image</label>
                                    <div class="d-flex">
                                        <div class="image-box image-box-image" action="select-image" data-counter="250">
                                            <input class="image-data" name="images" multiple type="hidden"
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
                                            <input type="file" id="imageInput" wire:model="image"
                                                accept="image/*" style="display: none;" />
                                        </div>
                                    </div>
                                    @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="image">Icon Image</label>
                                    <div class="d-flex">
                                        <div class="image-box image-box-image" action="select-image"
                                            data-counter="250">
                                            <input class="image-data" name="images" multiple type="hidden"
                                                value="" />
                                            @if (!$icon && $defaultIcon)
                                            <div style="width: 8rem" class="preview-image-wrapper mb-1">
                                                <div class="preview-image-inner">
                                                    <img class="preview-image default-image"
                                                        data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                        src="{{ asset('storage/' . $defaultIcon) }}"
                                                        alt="Preview image" />
                                                    <span class="image-picker-backdrop"></span>
                                                </div>
                                            </div>
                                            @elseif($icon)
                                            <div style="width: 8rem" class="preview-image-wrapper mb-1">
                                                <div class="preview-image-inner">
                                                    <img class="preview-image default-image"
                                                        data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                        src="{{ $icon->temporaryUrl() }}" alt="Preview image" />
                                                    <span class="image-picker-backdrop"></span>
                                                </div>
                                            </div>
                                            @endif


                                            <a data-bb-toggle="image-picker-choose" data-target="popup"
                                                data-result="image" data-action="select-image" data-allow-thumb="1"
                                                href="javascript:void(0)" id="chooseIcon" onclick="openIcon()">
                                                Choose icon image
                                            </a>
                                            <input type="file" id="iconInput" wire:model="icon"
                                                accept="image/png" style="display: none;" />
                                            <br />
                                            <span class="text-danger">22 X 22px</span>
                                            <br />
                                        </div>
                                    </div>
                                    @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-check form-switch d-inline-block">
                                        <input name="is_featured" type="hidden" value="0" />
                                        <input class="form-check-input" wire:model="is_featured" type="checkbox"
                                            value="1" id="is_featured"
                                            {{ $is_featured == 1 ? 'checked' : '' }} />
                                        <span class="form-check-label">Is featured?</span>
                                    </label>
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="seo_title">SEO Title</label>
                                    <input class="form-control @error('seo_title') is-invalid @enderror"
                                        placeholder="SEO Title" name="seo_title" type="text"
                                        wire:model="seo_title">
                                    @error('seo_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="seo_keyword">Seo Keyword</label>
                                    <input class="form-control @error('seo_keyword') is-invalid @enderror"
                                        placeholder="Seo Keyword" name="seo_keyword" type="text"
                                        wire:model="seo_keyword">
                                    @error('seo_keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative" wire:ignore>
                                    <label class="form-label" for="seo_description">Seo Description</label>
                                    <textarea class="form-control form-control editor-ckeditor ays-ignore @error('seo_description') is-invalid @enderror"
                                        rows="4" placeholder="Write your Seo Description" id="seo_description" name="seo_description"
                                        cols="50" wire:model="seo_description"></textarea>
                                    @error('seo_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                        Copyright 2025 © Roll Mills Store.
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

    function callFunction() {
        var element = $('#parent_id-select-34415');
        @this.set('parent_category_id', element.val());
    }

    function openIcon() {
        $('#iconInput').click();
    }
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
</script>
@endsection