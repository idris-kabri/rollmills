<div class="d-block d-lg-flex">
    <aside class="navbar navbar-vertical navbar-expand-lg flex-auto" data-bs-theme="dark" id="sidebar-menu-main">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <h2 class="d-block d-lg-none navbar-brand navbar-brand-autodark">
                <a href="/admin">
                    <img src="{{ asset('assets/images/white-logo.png') }}" style="max-height: 32px; height: auto"
                        alt="Botble Technologies" class="navbar-brand-image" />
                </a>
            </h2>

            <div class="navbar-nav flex-row d-lg-none">
                <div class="dropdown nav-item">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                        aria-label="Open user menu">
                        <span class="crop-image-original avatar avatar-sm"
                            style="
                      background-image: url(data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAD6APoDASIAAhEBAxEB/8QAGQABAQEBAQEAAAAAAAAAAAAAAAYEBwMF/8QANBABAAAEAQoFAQgDAAAAAAAAAAECAwQFBgcRFTI2VXKx0RJxk5TCIRMXNVFUdJKyFDGR/8QAGgEBAAIDAQAAAAAAAAAAAAAAAAMFAQQGAv/EACIRAQABAwQDAQEBAAAAAAAAAAACAQMzBBJRcRFB8DEUIf/aAAwDAQACEQMRAD8A9wFG5oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAb8GwufGcSks6dSWnNNCMfFNDTD6Q0sCjyH3oo8k/R7t0pKdKVSWo0lcpGvL6X3dXf6+h/CJ93V3+vofwi6GLH+a3wtv4rPDkOP5O1sAjbwq15Kv23i0eGEYaNGju+Ku84+1hvlV+KEaF6NIzrGir1EKQu1jH8AESEAAAAAAAAAAAAAAAAAAAAAAAAUeQ+9FHkn6JxR5D70UeSfoks5KdpbGWPbqoC4dAgs4+1hvlV+KEXecfaw3yq/FCKrU5aqPWZpfegBA1gAAAAAAAAAAAAAAAAAAAAAAABR5D70UeSfonFHkPvRR5J+iSzkp2lsZY9uqgLh0CCzj7WG+VX4oRd5x9rDfKr8UIqtTlqo9Zml96AEDWAAAAAAAAAAAAAAAAAAAAAAAAFHkPvRR5J+icUeQ+9FHkn6JLOSnaWxlj26qAuHQILOPtYb5VfihF3nH2sN8qvxQiq1OWqj1maX3oAQNYAAAAAAAAAAAAAAAAAAAAAAAAUeQ+9FHkn6JxR5D70UeSfoks5KdpbGWPbqoC4dAgs4+1hvlV+KEXecfaw3yq/FCKrU5aqPWZpfegBA1gAAAAAAAAAAAAAAAAAAAAAAABR5D70UeSfonFHkPvRR5J+iSzkp2lsZY9uqgLh0CCzj7WG+VX4oR0LL+yu7ybD/APFta1fwwqeL7KnGbRp8P+9CL1LivDL30Juyr1Ea1uV/xS6uMq3peKfeGEbtS4rwy99CbsalxXhl76E3ZDtlw1tkuGEbtS4rwy99CbsalxXhl76E3Y2y4NkuGEe1xa3FpPCS5t6tGaMNMJakkZYxh+f1eLDzWngAYAAAAAAAAAAAAAAAAAABR5D70UeSfonFHkPvRR5J+iSzkp2lsZY9uqgLh0AAAAAADm+cP8atv28P7TI9YZw/xq2/bw/tMj1TfyVUOqzSAEKAAAAAAAAAAAAAAAAAAAelC4r2tWFW3rVKNSH0hPTmjLH/ALB5jJ+N+vMW4pe+4n7mvMW4pe+4n7sAzuly9b5ct+vMW4pe+4n7mvMW4pe+4n7sAbpcm+XLfrzFuKXvuJ+5rzFuKXvuJ+7AG6XJvly368xbil77ifua8xbil77ifuwBulyb5cva4u7m8nhPdXFWvPCGiE1WeM0YQ/L6vEGHmtfP6AMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/9k=);
                    "></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>Lori Ruecker</div>
                            <div class="mt-1 small text-muted">
                                <span class="__cf_email__"
                                    data-cfemail="d9abb6aab8b5b0b8e1ea99b3b8aaadf7bab6b4">[email&#160;protected]</span>
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-user"></i>
                            Profile
                        </a>

                        <a class="dropdown-item" href="#">
                            <i class="fa fa-sign-out"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>

            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                        <a class="nav-link nav-priority--9999 show {{ Request::is('admin') ? 'active' : '' }}"
                            href="{{ url('/admin') }}" id="cms-core-dashboard" title="Dashboard">
                            <span class="nav-link-icon d-md-none d-lg-inline-block" title="Dashboard">
                                <svg class="icon svg-icon-ti-ti-home" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>

                            <span class="nav-link-title text-truncate">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li
                        class="nav-item dropdown {{ Request::is('admin/contact-us*') || Request::is('admin/banner*') || Request::is('admin/settings*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle nav-priority-120" href="#cms-plugins-contact"
                            id="cms-plugins-contact" data-bs-toggle="dropdown" data-bs-auto-close="false"
                            role="button" aria-expanded="false" title="Masters">
                            <span class="nav-link-icon d-md-none d-lg-inline-block" title="Contact">
                                <svg class="icon svg-icon-ti-ti-mail" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg>
                            </span>

                            <span class="nav-link-title text-truncate">
                                Masters
                                <span
                                    class="badge badge-sm bg-primary text-primary-fg badge-pill menu-item-count unread-contacts"
                                    data-url="#" style="display: none"></span>
                            </span>
                        </a>

                        <div class="dropdown-menu animate slideIn dropdown-menu-start">
                            <a class="dropdown-item nav-priority-120 {{ Request::is('admin/contact-us*') ? 'active' : '' }}"
                                href="{{ route('admin.contact.us.index') }}" id="cms-plugins-contact-list"
                                title="Contacts">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Contacts">
                                    <svg class="icon svg-icon-ti-ti-cube" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M21 16.008v-8.018a1.98 1.98 0 0 0 -1 -1.717l-7 -4.008a2.016 2.016 0 0 0 -2 0l-7 4.008c-.619 .355 -1 1.01 -1 1.718v8.018c0 .709 .381 1.363 1 1.717l7 4.008a2.016 2.016 0 0 0 2 0l7 -4.008c.619 -.355 1 -1.01 1 -1.718z" />
                                        <path d="M12 22v-10" />
                                        <path d="M12 12l8.73 -5.04" />
                                        <path d="M3.27 6.96l8.73 5.04" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Contacts
                                </span>
                            </a>

                            <a class="dropdown-item nav-priority-120 {{ Request::is('admin/banner*') ? 'active' : '' }}"
                                href="{{ route('admin.banner.index') }}" id="cms-plugins-contact-list"
                                title="Banners">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Banners">
                                    <i class="fa fa-image" style="font-size: 18px"></i>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Banners
                                </span>
                            </a>

                            <a class="dropdown-item nav-priority-120 {{ Request::is('admin/settings*') ? 'active' : '' }}"
                                href="{{ url('admin/settings') }}" id="cms-core-settings" title="Settings">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Settings">
                                    <svg class="icon svg-icon-ti-ti-settings" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate"> Settings </span>
                            </a>
                        </div>
                    </li>
                    <li
                        class="nav-item dropdown {{ Request::is('admin/offer*') || Request::is('admin/coupon*') || Request::is('admin/product*') || Request::is('admin/products-categories*') || Request::is('admin/product-attributes*') || Request::is('admin/brand*') || Request::is('admin/gift-cards*') || Request::is('admin/customer*') || Request::is('admin/transaction*') || Request::is('admin/orders*') || Request::is('admin/order-return*') || Request::is('admin/reviews*') || Request::is('admin/gift-card-items*')    ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle nav-priority-0" href="#cms-plugins-ecommerce"
                            id="cms-plugins-ecommerce" data-bs-toggle="dropdown" data-bs-auto-close="false"
                            role="button" aria-expanded="false" title="Ecommerce">
                            <span class="nav-link-icon d-md-none d-lg-inline-block" title="Ecommerce">
                                <svg class="icon svg-icon-ti-ti-shopping-bag" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z" />
                                    <path d="M9 11v-5a3 3 0 0 1 6 0v5" />
                                </svg>
                            </span>

                            <span class="nav-link-title text-truncate">
                                Ecommerce
                                <span
                                    class="badge badge-sm bg-primary text-primary-fg badge-pill menu-item-count ecommerce-count"
                                    data-url="#" style="display: none"></span>
                            </span>
                        </a>

                        <div class="dropdown-menu animate slideIn dropdown-menu-start">
                            {{--<a class="dropdown-item nav-priority-0" href="#" id="cms-plugins-ecommerce-report"
                                title="Report">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Report">
                                    <svg class="icon svg-icon-ti-ti-report-analytics" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                        <path
                                            d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path d="M9 17v-5" />
                                        <path d="M12 17v-1" />
                                        <path d="M15 17v-3" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate"> Report </span>
                            </a>--}}

                            <!-- product categories  -->
                            <a class="dropdown-item nav-priority-90 {{ Request::is('admin/products-categories*') ? 'active' : '' }}"
                                href="{{ url('admin/products-categories') }}" id="cms-plugins-product-categories"
                                title="Product Categories">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Product categories">
                                    <svg class="icon svg-icon-ti-ti-archive" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                        <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" />
                                        <path d="M10 12l4 0" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Product categories
                                </span>
                            </a>

                            <!-- product attributes  -->
                            <a class="dropdown-item nav-priority-110 {{ Request::is('admin/product-attributes*') ? 'active' : '' }}"
                                href="{{ url('/admin/product-attributes') }}" id="cms-plugins-product-attribute"
                                title="Product Attributes">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Product attributes">
                                    <svg class="icon svg-icon-ti-ti-album" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                        <path d="M12 4v7l2 -2l2 2v-7" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Product attributes
                                </span>
                            </a>

                            <!-- brands  -->
                            <a class="dropdown-item nav-priority-150 {{ Request::is('admin/brand*') ? 'active' : '' }}"
                                href="{{ url('admin/brand') }}" id="cms-plugins-brands" title="Brands">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Brands">
                                    <svg class="icon svg-icon-ti-ti-registered" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M10 15v-6h2a2 2 0 1 1 0 4h-2" />
                                        <path d="M14 15l-2 -2" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate"> Brands </span>
                            </a>

                            <!-- products  -->
                            <a class="dropdown-item nav-priority-60 {{ Request::is('admin/product/*') || request()->uri()->path() == 'admin/product' ? 'active' : '' }}"
                                href="{{ route('admin.product.index') }}" id="cms-plugins-ecommerce-product"
                                title="Products">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Products">
                                    <svg class="icon svg-icon-ti-ti-package" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                        <path d="M12 12l8 -4.5" />
                                        <path d="M12 12l0 9" />
                                        <path d="M12 12l-8 -4.5" />
                                        <path d="M16 5.25l-8 4.5" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Products
                                </span>
                            </a>

                            <!-- coupons  -->
                            <a class="dropdown-item nav-priority-120 {{ Request::is('admin/coupon*') ? 'active' : '' }}"
                                href="{{ route('admin.coupon.index') }}" id="cms-plugins-contact-list"
                                title="Coupon">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Coupon">
                                    <svg fill="#8a97ab" xmlns="http://www.w3.org/2000/svg" width="20px"
                                        height="20px" viewBox="0 0 48 48">
                                        <g id="Layer_2" data-name="Layer 2">
                                            <g id="invisible_box" data-name="invisible box">
                                                <rect width="48" height="48" fill="none" />
                                            </g>
                                            <g id="Layer_7" data-name="Layer 7">
                                                <g>
                                                    <path
                                                        d="M28.5,6.7a2,2,0,0,0-2.8-.2l-7,5.9-3-2.6A5.2,5.2,0,0,0,16,8a6,6,0,1,0-6,6,6.4,6.4,0,0,0,3.3-1l2.3,2-2.3,2A6.4,6.4,0,0,0,10,16a6,6,0,1,0,6,6,5.2,5.2,0,0,0-.3-1.8l3-2.6,7,5.9A2.1,2.1,0,0,0,27,24a1.8,1.8,0,0,0,1.5-.7,2,2,0,0,0-.2-2.8L21.8,15l6.5-5.5A2,2,0,0,0,28.5,6.7ZM10,10a2,2,0,1,1,2-2A2,2,0,0,1,10,10Zm0,14a2,2,0,1,1,2-2A2,2,0,0,1,10,24Z" />
                                                    <path
                                                        d="M44,38a2,2,0,0,0-2,2,2,2,0,0,0,0,4h4V40A2,2,0,0,0,44,38Z" />
                                                    <path d="M26,40H22a2,2,0,0,0,0,4h4a2,2,0,0,0,0-4Z" />
                                                    <path d="M16,40H12a2,2,0,0,0,0,4h4a2,2,0,0,0,0-4Z" />
                                                    <path d="M36,40H32a2,2,0,0,0,0,4h4a2,2,0,0,0,0-4Z" />
                                                    <path d="M6,40a2,2,0,0,0-4,0v4H6a2,2,0,0,0,0-4Z" />
                                                    <path
                                                        d="M4,36.7a2,2,0,0,0,2-2V31.2a1.9,1.9,0,0,0-2-2,1.9,1.9,0,0,0-2,2v3.5A2,2,0,0,0,4,36.7Z" />
                                                    <path d="M36,13H32a2,2,0,0,0,0,4h4a2,2,0,0,0,0-4Z" />
                                                    <path d="M42,13a2,2,0,0,0,0,4,2,2,0,0,0,4,0V13Z" />
                                                    <path
                                                        d="M44,20.3a2,2,0,0,0-2,2v3.5a2,2,0,0,0,4,0V22.3A2,2,0,0,0,44,20.3Z" />
                                                    <path
                                                        d="M44,29.2a1.9,1.9,0,0,0-2,2v3.5a2,2,0,0,0,4,0V31.2A1.9,1.9,0,0,0,44,29.2Z" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Coupon
                                </span>
                            </a>

                            <!-- offers  -->
                            <a class="dropdown-item nav-priority-120 {{ Request::is('admin/offer*') ? 'active' : '' }}"
                                href="{{ route('admin.offer.index') }}" id="cms-plugins-contact-list"
                                title="Offer">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Offer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        fill="currentColor" class="bi bi-tag" viewBox="0 0 16 16">
                                        <path
                                            d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0" />
                                        <path
                                            d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Offer
                                </span>
                            </a>

                            <!-- gift cards  -->
                            <a class="dropdown-item nav-priority-160 {{ Request::is('admin/gift-cards*') ? 'active' : '' }}"
                                href="{{ url('/admin/gift-cards') }}" id="cms-ecommerce-giftcard" title="Gift Cards">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Gift Cards">
                                    <svg class="icon svg-icon-ti-ti-star" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Gift Cards
                                </span>
                            </a>

                            <!-- orders  -->
                            <a class="dropdown-item nav-priority-10" href="{{url('admin/orders/')}}" id="cms-plugins-ecommerce-order"
                                title="Orders">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Orders">
                                    <svg class="icon svg-icon-ti-ti-truck-delivery" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                        <path d="M3 9l4 0" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Orders
                                    <span
                                        class="badge badge-sm bg-primary text-primary-fg badge-pill menu-item-count pending-orders"
                                        data-url="#" style="display: none"></span>
                                </span>
                            </a>

                            <!-- order returns  -->
                            <a class="dropdown-item nav-priority-30" href="{{url('admin/order-return')}}"
                                id="cms-plugins-ecommerce-order-return" title="Order Returns">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Order returns">
                                    <svg class="icon svg-icon-ti-ti-basket-down" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M17 10l-2 -6" />
                                        <path d="M7 10l2 -6" />
                                        <path
                                            d="M12 20h-4.756a3 3 0 0 1 -2.965 -2.544l-1.255 -7.152a2 2 0 0 1 1.977 -2.304h13.999a2 2 0 0 1 1.977 2.304l-.349 1.989" />
                                        <path d="M10 14a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M19 16v6" />
                                        <path d="M22 19l-3 3l-3 -3" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Order returns
                                    <span
                                        class="badge badge-sm bg-primary text-primary-fg badge-pill menu-item-count pending-order-returns"
                                        data-url="#" style="display: none"></span>
                                </span>
                            </a>

                            {{--<a class="dropdown-item nav-priority-40" href="#"
                                id="cms-plugins-ecommerce-shipping-shipments" title="Shipments">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Shipments">
                                    <svg class="icon svg-icon-ti-ti-truck-loading" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M2 3h1a2 2 0 0 1 2 2v10a2 2 0 0 0 2 2h15" />
                                        <path
                                            d="M9 6m0 3a3 3 0 0 1 3 -3h4a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3z" />
                                        <path d="M9 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M18 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Shipments
                                </span>
                            </a>--}}

                            <!-- reviews  -->
                            <a class="dropdown-item nav-priority-160 {{ Request::is('admin/reviews*') ? 'active' : '' }}"
                                href="{{ url('admin/reviews') }}" id="cms-ecommerce-review" title="Reviews">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Reviews">
                                    <svg class="icon svg-icon-ti-ti-star" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Reviews
                                </span>
                            </a>

                            {{--<a class="dropdown-item nav-priority-180" href="#"
                                id="cms-plugins-ecommerce-discount" title="Discounts">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Discounts">
                                    <svg class="icon svg-icon-ti-ti-discount" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 15l6 -6" />
                                        <circle cx="9.5" cy="9.5" r=".5" fill="currentColor" />
                                        <circle cx="14.5" cy="14.5" r=".5" fill="currentColor" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Discounts
                                </span>
                            </a>--}}

                            <!-- customers  -->
                            <a class="dropdown-item nav-priority-190 {{ Request::is('admin/customer*') ? 'active' : '' }}"
                                href="{{ route('admin.customer.index') }}" id="cms-plugins-ecommerce-customer"
                                title="Customers">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Customers">
                                    <svg class="icon svg-icon-ti-ti-users" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Customers
                                </span>
                            </a>

                            <!-- trnsactions  -->
                            <a class="dropdown-item nav-priority-0 {{ Request::is('admin/transaction*') ? 'active' : '' }}"
                                href="{{ route('admin.transaction.index') }}" id="cms-plugins-payments-all"
                                title="Transactions">
                                <span class="nav-link-icon d-md-none d-lg-inline-block" title="Transactions">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
                                        <path
                                            d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z" />
                                    </svg>
                                </span>

                                <span class="nav-link-title text-truncate">
                                    Transactions
                                    <span
                                        class="badge badge-sm bg-primary text-primary-fg badge-pill menu-item-count pending-payments"
                                        data-url="#" style="display: none"></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="nav-item {{ Request::is('admin/user-quotation*') ? 'active' : '' }}">
                        <a class="nav-link nav-priority--9999 show {{ Request::is('admin/user-quotation*') ? 'active' : '' }}"
                            href="{{ route('admin.user-quotation.index') }}" id="cms-core-dashboard" title="User Quotation">
                            <span class="nav-link-icon d-md-none d-lg-inline-block" title="Dashboard">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 11.5a8.38 8.38 0 0 1-1.9 5.4 8.5 8.5 0 0 1-6.6 3.1 8.38 8.38 0 0 1-5.4-1.9L3 21l2.9-4.1a8.38 8.38 0 0 1-1.9-5.4 8.5 8.5 0 0 1 3.1-6.6A8.38 8.38 0 0 1 11.5 3h1a8.5 8.5 0 0 1 8.5 8.5z" />
                                    <path d="M9 10h.01" />
                                    <path d="M15 10h.01" />
                                    <path d="M8 14c1 1 3 1 4 0" />
                                </svg>

                            </span>

                            <span class="nav-link-title text-truncate">
                                User Quotation
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>