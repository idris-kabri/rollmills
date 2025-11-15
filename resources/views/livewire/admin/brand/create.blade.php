<div class="page-wrapper"> 
    <div wire:loading.delay wire:target="create" class="loader-overlay" style="display: none !important;">
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
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{ url('/admin/ecommerce/brands') }}">Brands</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">New brand</h1>
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


            <form method="POST" wire:submit.prevent="create" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="gap-3 col-md-9">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="mb-3 position-relative">
                                        <label class="form-label" for="name">
                                            Name
                                        </label>

                                        <input class="form-control" data-counter="250" placeholder="Name"
                                            wire:model="name" type="text" id="name" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <label class="form-label" for="name">
                                            Link
                                        </label>

                                        <input class="form-control" data-counter="250" placeholder="Enter Link"
                                            wire:model="link" type="text" id="link" required>
                                        @error('link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 position-relative" wire:ignore>
                                        <label class="form-label" for="description">
                                            Description
                                        </label>
                                        <textarea class="form-control editor-ckeditor" placeholder="Short description" id="description"
                                            wire:model="description"></textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="advanced-sortables" class="meta-box-sortables">
                            <div class="card meta-boxes mb-3" id="seo_wrap">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Search Engine Optimize
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <div class="seo-preview" v-pre>
                                        <p class="default-seo-description">
                                            Setup meta title &amp; description to make your site easy to
                                            discovered on search engines such as Google
                                        </p>
                                    </div>

                                    <div class="seo-edit-section" v-pre>
                                        <hr class="my-4">
                                        </hr>

                                        <div class="mb-3 position-relative">

                                            <label class="form-label" for="seo_meta[seo_title]">
                                                SEO Title
                                            </label>
                                            <input class="form-control" data-counter="70" placeholder="SEO Title"
                                                wire:model="seo_title" type="text" id="seo_tile">
                                            @error('seo_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 position-relative">

                                            <label class="form-label" for="seo_meta[seo_title]">
                                                SEO Meta
                                            </label>
                                            <input class="form-control" data-counter="70" placeholder="SEO Meta"
                                                wire:model="seo_meta" type="text" id="seo_meta">
                                            @error('seo_meta')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 position-relative" wire:ignore>

                                            <label class="form-label" for="seo_meta[seo_description]">
                                                SEO description
                                            </label>
                                            <textarea class="form-control editor-ckeditor" rows="3" placeholder="SEO description" id="seo_description"
                                                wire:model="seo_description" cols="50"></textarea>
                                            @error('seo_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3 gap-3 d-flex flex-column-reverse flex-md-column mb-md-0 mb-5">
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
                                <select
                                    class="form-control form-select @error('status')
                                    is_invalid
                                @enderror"
                                    required id="status-select-42819" wire:model="status">
                                    <option value="1">Published</option>
                                    <option value="2">Pending</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card meta-boxes">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <label class="form-label" for="logo">
                                        Logo
                                    </label>
                                </h4>
                            </div>


                            <div class=" card-body">
                                <div class="image-box image-box-logo" action="select-image" data-counter="250">
                                    <div style="width: 8rem" class="preview-image-wrapper mb-1">
                                        <div class="preview-image-inner">
                                            @if ($image)
                                                <img class="preview-image default-image"
                                                    data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                    src="{{ $image->temporaryUrl() }}" alt="Preview image" />
                                            @else
                                                <img class="preview-image default-image"
                                                    data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                    src="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                                                    alt="Preview image" />
                                            @endif
                                        </div>
                                    </div>

                                        <a href="javascript:void(0);" id="choose-image" onclick="selectImage();">
                                            Choose image
                                        </a>
                                        <input type="file" id="image-input" style="display: none;"
                                            accept="image/*" wire:model="image"> 
                                        <br/> 
                                        <span class="text-danger">163 X 85px</span>
                                        <br/> 
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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
                                    <input name="is_featured" type="hidden" value="0" />
                                    <input class="form-check-input" wire:model="is_featured" type="checkbox"
                                        value="1" id="is_featured" />
                                </label>
                                @error('is_featured')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                        Copyright 2025 © Roll Mills Store.
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

@section('scripts')
    <script>
        function selectImage() {
            $("#image-input").click();
        };
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
@endsection
