<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{ url("/admin") }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1"
                                        href="{{ url("admin/contact-us") }}">Contact</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        View contact
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
            <div class="row">
                <div class="gap-3 col-md-9">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="card-title">Contact information</h4>
                        </div>

                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Full Name</div>
                                    <div class="datagrid-content">{{ $name }}</div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Email</div>
                                    <div class="datagrid-content">
                                        <div class="datagrid-content">{{ $email }}</div>
                                    </div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Phone</div>
                                    <div class="datagrid-content">
                                        <a href="tel:{{ $phone }}">{{ $phone }}</a>
                                    </div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Time</div>
                                    <div class="datagrid-content">
                                        {{ $time }}
                                    </div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Subject</div>
                                    <div class="datagrid-content">{{ $subject }}</div>
                                </div>

                                <div class="datagrid-item">
                                    <div class="datagrid-title">Messege</div>
                                    <div class="datagrid-content">{{ $messege }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 gap-3 d-flex flex-column-reverse flex-md-column mb-md-0 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Publish</h4>
                        </div>
                        <div class="card-body">
                            <div class="btn-list">
                                <button class="btn btn-primary" type="submit" wire:click.prevent="update"
                                    value="apply" name="submitter">
                                    <svg class="icon icon-left svg-icon-ti-ti-device-floppy"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M14 4l0 4l-6 0l0 -4" />
                                    </svg>
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                    <div data-bb-waypoint data-bb-target="#form-actions"></div>

                    <div class="card meta-boxes">
                        <div class="card-header">
                            <h4 class="card-title">
                                <label class="form-label form-label required" for="status">
                                    Status
                                </label>
                            </h4>
                        </div>

                        <div class="card-body">
                            <select class="form-control form-select" id="status-select-61246" name="status"
                                wire:model="status">
                                <option value="1">Read</option>
                                <option value="0" selected="selected">
                                    Unread
                                </option>
                            </select>
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
