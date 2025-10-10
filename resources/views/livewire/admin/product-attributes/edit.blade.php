<div class="page-wrapper"> 
    <div wire:loading.delay wire:target="store" class="loader-overlay" style="display: none !important;">
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
                                    <a class="mb-0 d-inline-block fs-6 lh-1" href="/admin">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1" href="/admin/product-attributes">Product
                                        attributes</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        New product attribute
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
            <form wire:submit.prevent="store" method="POST">
                @csrf
                <div class="row">
                    <div class="gap-3 col-md-9">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="mb-3 position-relative">
                                        <label class="form-label form-label required" for="title">
                                            Title
                                        </label>

                                        <input class="form-control @error('name'){{ 'is-invalid' }}@enderror" required
                                            type="text" id="title" wire:model='name' />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title">Attributes list</h4>

                                <div class="card-actions">
                                    <button type="button" class="btn js-add-new-attribute"
                                        wire:click="addNewAttributes">
                                        Add new attribute
                                    </button>
                                </div>
                            </div>

                            <table
                                class="table table-vcenter card-table table-hover table-striped swatches-container text-center">
                                <thead class="header">
                                    <tr>
                                        <th width="5%">Is default?</th>

                                        <th>Title</th>

                                        <th width="5%">Remove</th>
                                    </tr>
                                </thead>

                                <tbody class="swatches-list">
                                    @if (count($attributes_lists) > 0)
                                        @foreach ($attributes_lists as $key => $attribute_list)
                                            <tr data-id="0">
                                                <td width="5%">
                                                    <input type="hidden" wire:model="attributes_lists.{{ $key }}.id">
                                                    <label class="form-check form-check-inline form-check-single">
                                                        <input class="form-check-input @error("attributes_lists.{{ $key }}.is_default")
                                                            is-invalid
                                                        @enderror" 
                                                               type="radio"
                                                               name="related_attribute_is_default" 
                                                               wire:model="attributes_lists.{{ $key }}.is_default" 
                                                               value="1" 
                                                               {{ $attribute_list['is_default'] == 1 ? 'checked' : '' }}>
                                                        <span class="form-check-label"></span>
                                                        @error("attributes_lists.{{ $key }}.is_default")
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </label>
                                                </td>

                                                <td>
                                                    <input type="text" name="swatch-title" class="form-control @error("attributes_lists.{{ $key }}.name")
                                                            is-invalid
                                                        @enderror"
                                                        wire:model="attributes_lists.{{ $key }}.name">
                                                        @error("attributes_lists.{{ $key }}.name")
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" wire:click.prevent="removeArray({{$key}})"
                                                        class="remove-item text-decoration-none text-danger">
                                                        <i class="fa fa-trash"></i> </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3 gap-3 d-flex flex-column-reverse flex-md-column mb-md-0 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Publish</h4>
                            </div>
                            <div class="card-body">
                                <div class="btn-list">
                                    <button class="btn btn-primary" type="submit" name="submitter">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div data-bb-waypoint data-bb-target="#form-actions"></div>

                        <header class="top-0 w-100 position-fixed end-0 z-1000" id="form-actions" style="display: none">
                            <div class="navbar">
                                <div class="container-xl">
                                    <div class="row g-2 align-items-center w-100">
                                        <div class="col">
                                            <div class="page-pretitle">
                                                <nav aria-label="breadcrumb">
                                                    <ol class="breadcrumb"></ol>
                                                </nav>
                                            </div>
                                        </div>
                                        <div class="col-auto ms-auto d-print-none">
                                            <div class="btn-list">
                                                <button class="btn btn-primary" type="submit"
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

                            <div class="card-body">
                                <select class="form-control form-select @error('status')
                                    is_invalid
                                @enderror" required id="status-select-42819"
                                    wire:model="status">
                                    <option value="1">Published</option>
                                    <option value="2">Pending</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 
