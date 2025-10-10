<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler d-none d-lg-block me-2 ms-n1" type="button" data-bb-toggle="navbar-minimal"
            data-bb-target="#sidebar-menu-main" aria-controls="navbar-menu" aria-expanded="false"
            aria-label="Toggle navigation"
            data-url="/admin" data-method="PATCH">
            <svg class="icon svg-icon-ti-ti-menu-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 6l16 0" />
                <path d="M4 12l16 0" />
                <path d="M4 18l16 0" />
            </svg>
        </button>

        <h1 class="navbar-brand navbar-brand-autodark me-4">
            <a href="/admin">
                <img src="{{ asset('assets/images/white-logo.png') }}" style="max-height: 32px; height: auto"
                    alt="Botble Technologies" class="navbar-brand-image" />
            </a>
        </h1>

        <div class="flex-row navbar-nav order-md-last">
            {{-- <div class="d-flex align-items-center me-3">
                <div class="">
                    <label class="form-label sr-only" for="global-search-input">
                        Search
                    </label>

                    <div class="input-group input-group-flat">
                        <input
                            class="form-control"
                            type="text"
                            name="keyword"
                            id="global-search-input"
                            placeholder="Search"
                            tabindex="0"
                            data-bb-toggle="gs-navbar-input"
                            autocomplete="off" />

                        <div class="input-group-text">
                            <kbd>ctrl/cmd + k</kbd>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="d-flex align-items-center me-3">
                <a class="btn" type="button" href="{{ url('/') }}" target="_blank">
                    <svg class="icon icon-left svg-icon-ti-ti-world" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                        <path d="M3.6 9h16.8" />
                        <path d="M3.6 15h16.8" />
                        <path d="M11.5 3a17 17 0 0 0 0 18" />
                        <path d="M12.5 3a17 17 0 0 1 0 18" />
                    </svg>
                    View website
                </a>
            </div>


            <div class="dropdown nav-item">
                <a href="#" class="p-0 nav-link d-flex lh-1 text-reset" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="crop-image-original avatar avatar-sm"
                        style="
                    background-image: url(data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAD6APoDASIAAhEBAxEB/8QAGQABAQEBAQEAAAAAAAAAAAAAAAYEBwMF/8QANBABAAAEAQoFAQgDAAAAAAAAAAECAwQFBgcRFTI2VXKx0RJxk5TCIRMXNVFUdJKyFDGR/8QAGgEBAAIDAQAAAAAAAAAAAAAAAAMFAQQGAv/EACIRAQABAwQDAQEBAAAAAAAAAAACAQMzBBJRcRFB8DEUIf/aAAwDAQACEQMRAD8A9wFG5oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAb8GwufGcSks6dSWnNNCMfFNDTD6Q0sCjyH3oo8k/R7t0pKdKVSWo0lcpGvL6X3dXf6+h/CJ93V3+vofwi6GLH+a3wtv4rPDkOP5O1sAjbwq15Kv23i0eGEYaNGju+Ku84+1hvlV+KEaF6NIzrGir1EKQu1jH8AESEAAAAAAAAAAAAAAAAAAAAAAAAUeQ+9FHkn6JxR5D70UeSfoks5KdpbGWPbqoC4dAgs4+1hvlV+KEXecfaw3yq/FCKrU5aqPWZpfegBA1gAAAAAAAAAAAAAAAAAAAAAAABR5D70UeSfonFHkPvRR5J+iSzkp2lsZY9uqgLh0CCzj7WG+VX4oRd5x9rDfKr8UIqtTlqo9Zml96AEDWAAAAAAAAAAAAAAAAAAAAAAAAFHkPvRR5J+icUeQ+9FHkn6JLOSnaWxlj26qAuHQILOPtYb5VfihF3nH2sN8qvxQiq1OWqj1maX3oAQNYAAAAAAAAAAAAAAAAAAAAAAAAUeQ+9FHkn6JxR5D70UeSfoks5KdpbGWPbqoC4dAgs4+1hvlV+KEXecfaw3yq/FCKrU5aqPWZpfegBA1gAAAAAAAAAAAAAAAAAAAAAAABR5D70UeSfonFHkPvRR5J+iSzkp2lsZY9uqgLh0CCzj7WG+VX4oR0LL+yu7ybD/APFta1fwwqeL7KnGbRp8P+9CL1LivDL30Juyr1Ea1uV/xS6uMq3peKfeGEbtS4rwy99CbsalxXhl76E3ZDtlw1tkuGEbtS4rwy99CbsalxXhl76E3Y2y4NkuGEe1xa3FpPCS5t6tGaMNMJakkZYxh+f1eLDzWngAYAAAAAAAAAAAAAAAAAABR5D70UeSfonFHkPvRR5J+iSzkp2lsZY9uqgLh0AAAAAADm+cP8atv28P7TI9YZw/xq2/bw/tMj1TfyVUOqzSAEKAAAAAAAAAAAAAAAAAAAelC4r2tWFW3rVKNSH0hPTmjLH/ALB5jJ+N+vMW4pe+4n7mvMW4pe+4n7sAzuly9b5ct+vMW4pe+4n7mvMW4pe+4n7sAbpcm+XLfrzFuKXvuJ+5rzFuKXvuJ+7AG6XJvly368xbil77ifua8xbil77ifuwBulyb5cva4u7m8nhPdXFWvPCGiE1WeM0YQ/L6vEGHmtfP6AMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/9k=);
                  "></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->name }}</div>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route("admin.profile.index",Auth::user()->id) }}">
                        <svg class="icon dropdown-item-icon svg-icon-ti-ti-user" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        Profile
                    </a>
                    <form action="{{ route("admin.dashboard.logout") }}" method="post">
                        @csrf
                        <button class="dropdown-item" wire:click.prevent="logout">
                            <svg class="icon dropdown-item-icon svg-icon-ti-ti-logout"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu"></div>
    </div>
</header>
