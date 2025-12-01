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
                                <li class="breadcrumb-item">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Posts</h1>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form class="add-locale-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Post ID</label>
                                        <input type="text"
                                            class="form-control @error('post_id') is-invalid @enderror"
                                            wire:model="post_id" {{ $disable ? 'disabled' : '' }}>
                                        @error('post_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Keyword</label>
                                        <input type="text"
                                            class="form-control @error('keyword') is-invalid @enderror"
                                            wire:model="keyword">
                                        @error('keyword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Number of Comments</label>
                                        <input type="number"
                                            class="form-control @error('number_of_comment') is-invalid @enderror"
                                            wire:model="number_of_comment">
                                        @error('number_of_comment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required">
                                            Select Product
                                        </label>
                                        <div wire:ignore>
                                            <select wire:model="product_id"
                                                class="select-search-full form-select select2 @error('product_id') is-invalid @enderror"
                                                name="product_id" id="product_id">
                                                <option value="">Select Product</option>

                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('product_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Platform</label>
                                        <select class="form-control @error('platform') is-invalid @enderror"
                                            wire:model="platform">
                                            <option value="">Select</option>
                                            <option value="Instagram">Instagram</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Youtube">Youtube</option>
                                        </select>
                                        @error('platform')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control editor-ckeditor @error('message') is-invalid @enderror" wire:model="message" rows="4"></textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button class="btn btn-primary" wire:click.prevent="store">
                                    {{ $postId ? 'Update' : 'Save' }}
                                </button>

                                @if ($postId)
                                    <button class="btn btn-secondary" wire:click="cancelEdit" type="button">
                                        Clear
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Settings</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-hover table-language">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Post ID</th>
                                        <th>Keyword</th>
                                        <th>Message</th>
                                        <th>Comments</th>
                                        <th>Product ID</th>
                                        <th>Platform</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $post->post_id }}</td>
                                            <td>{{ $post->keyword }}</td>
                                            <td>{{ $post->message }}</td>
                                            <td>{{ $post->number_of_comment }}</td>
                                            <td>{{ $post->getProduct->name }}</td>
                                            <td>{{ $post->platform }}</td>
                                            <td class="text-end">
                                                <a class="btn btn-icon btn-primary btn-sm"
                                                    wire:click.prevent="loadSetting({{ $post->id }})"
                                                    title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-pencil-square"
                                                        viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459
                    3.69l-2-2L13.502.646a.5.5 0 0
                    1 .707 0l1.293 1.293zm-1.75
                    2.456-2-2L4.939 9.21a.5.5 0 0
                    0-.121.196l-.805 2.414a.25.25 0 0
                    0 .316.316l2.414-.805a.5.5 0 0
                    0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5
                        15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5
                        0 0 0-1 0v6a.5.5 0 0
                        1-.5.5h-11a.5.5 0 0
                        1-.5-.5v-11a.5.5 0 0
                        1 .5-.5H9a.5.5 0 0
                        0 0-1H2.5A1.5 1.5 0 0 0
                        1 2.5z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        document.addEventListener("livewire:init", () => {

            function initSelect2() {
                $('#product_id').select2({
                    placeholder: "Search Product",
                    allowClear: true,
                    width: '100%',
                });

                $('#product_id').on('change', function() {
                    @this.set('product_id', $(this).val());
                });
            }

            // Initialize only once
            initSelect2();

            // When editing → select the correct product
            Livewire.on('refreshSelect2', () => {
                $('#product_id').val(@this.get('product_id')).trigger('change');
            });

            // When form resets → clear select2 UI
            Livewire.on('clearSelect2', () => {
                $('#product_id').val('').trigger('change');
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
