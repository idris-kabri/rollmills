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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Settings</h1>
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
                <div class="col-md-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form class="add-locale-form">
                                @csrf
                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="locale">Label</label>
                                    <input class="form-control @error('label') is-invalid @enderror" placeholder="Label"
                                        {{ $disable ? 'disabled' : '' }} type="text" wire:model="label">
                                    @error('label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 position-relative">
                                    <label class="form-label" for="locale">Value</label>
                                    <input class="form-control @error('name') is-invalid @enderror" placeholder="Value"
                                        type="text" wire:model="value">
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary" wire:click.prevent="store" type="submit">
                                    {{ $settingId ? 'Update' : 'Save' }}
                                </button>
                                @if ($settingId)
                                    <button class="btn btn-primary" wire:click="cancelEdit"
                                        type="button">Clear</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Settings</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-hover table-language">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Label</th>
                                        <th>value</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($settings as $setting)
                                        <tr data-locale="ar">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $setting->label }}</td>
                                            <td>{{ $setting->value }}</td>
                                            <td>
                                                <div class="btn-list justify-content-end">
                                                    <a class="btn btn-icon btn-primary btn-sm download-locale-button"
                                                        type="button"
                                                        wire:click.prevent="loadSetting({{ $setting->id }})"
                                                        href="javascript:void(0)" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Edit">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                        </svg>
                                                    </a>
                                                </div>
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
