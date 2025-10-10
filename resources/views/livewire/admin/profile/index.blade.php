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
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">
                                        Profile
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
            <div class="user-profile">
                <div class="card">
                    <div class="card-header">
                        <ul data-bs-toggle="tabs" class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="#profile" class="nav-link active" data-bs-toggle="tab">
                                    <svg class="icon me-2 svg-icon-ti-ti-user" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    </svg>
                                    User profile
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="profile">
                                <form>
                                    @csrf
                                    <div class="row row-cols-lg-2">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label form-label required" for="first_name">
                                                First Name
                                            </label>
                                            <input class="form-control" type="text" wire:model="name" />
                                        </div>

                                        <div class="mb-3 position-relative">
                                            <label class="form-label form-label required" for="email">
                                                Email
                                            </label>

                                            <input class="form-control" type="email" disabled wire:model="email" />
                                        </div>
                                    </div>
                                </form>

                                <form>
                                    @csrf
                                    <div class="row row-cols-lg-2">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label required" for="password">
                                                New Password
                                            </label>
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                name="password" type="password" wire:model="password" id="password" />
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 position-relative">
                                            <label class="form-label required" for="password_confirmation">
                                                Confirm New Password
                                            </label>
                                            <input
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" type="password"
                                                wire:model="password_confirmation" id="password_confirmation" />

                                            @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="card-footer bg-transparent mt-3 p-0 pt-3">
                                        <div class="btn-list justify-content-end">
                                            <button class="btn btn-primary" type="submit"
                                                wire:click.prevent="updateUser">
                                                <svg class="icon icon-left svg-icon-ti-ti-circle-check"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                    <path d="M9 12l2 2l4 -4" />
                                                </svg>
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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