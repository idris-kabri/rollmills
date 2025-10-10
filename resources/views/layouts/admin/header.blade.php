<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard | Fakhri Electric Store</title>
    <meta name="csrf-token" content="jGUWK2Xr2e2QuaKVLNhSjvgsvhP59I2QoCW4xz59" />

    {{-- <link href="{{asset('assets/images/white-logo.png')}}" rel="icon shortcut" />
    <meta property="og:image" content="{{asset('assets/images/white-logo.png')}}" /> --}}

    <meta name="description" content="Copyright 2025 © Botble Technologies. Version 1.41.2" />
    <meta property="og:description" content="Copyright 2025 © Botble Technologies. Version 1.41.2" />

    <style>
        [v-cloak],
        [x-cloak] {
            display: none;
        }

        /* Hide arrows in Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide arrows in Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <link href="{{ asset('assets/backend/css/main.css') }}" rel="stylesheet" type="text/css" />

    <style>
        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2jl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
                U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma0zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+1F00-1FFF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0370-0377, U+037A-037F, U+0384-038A, U+038C,
                U+038E-03A1, U+03A3-03FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169,
                U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309,
                U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma25l7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
                U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F,
                U+A720-A7FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1zl7w0q5nw.woff2) format("woff2");
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
                U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
                U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2jl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
                U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma0zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+1F00-1FFF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0370-0377, U+037A-037F, U+0384-038A, U+038C,
                U+038E-03A1, U+03A3-03FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169,
                U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309,
                U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma25l7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
                U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F,
                U+A720-A7FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1zl7w0q5nw.woff2) format("woff2");
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
                U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
                U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2jl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
                U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma0zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+1F00-1FFF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0370-0377, U+037A-037F, U+0384-038A, U+038C,
                U+038E-03A1, U+03A3-03FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169,
                U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309,
                U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma25l7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
                U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F,
                U+A720-A7FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1zl7w0q5nw.woff2) format("woff2");
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
                U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
                U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2jl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
                U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma0zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+1F00-1FFF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0370-0377, U+037A-037F, U+0384-038A, U+038C,
                U+038E-03A1, U+03A3-03FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169,
                U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309,
                U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma25l7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
                U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F,
                U+A720-A7FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1zl7w0q5nw.woff2) format("woff2");
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
                U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
                U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2jl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
                U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma0zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2zl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+1F00-1FFF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0370-0377, U+037A-037F, U+0384-038A, U+038C,
                U+038E-03A1, U+03A3-03FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma2pl7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169,
                U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309,
                U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma25l7w0q5n-wu.woff2) format("woff2");
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
                U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F,
                U+A720-A7FF;
        }

        @font-face {
            font-family: "Inter";
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://shopwise.botble.com/storage/fonts/2832c0ff63/sinterv13ucc73fwrk3iltehus-fvqtmwcp50knma1zl7w0q5nw.woff2) format("woff2");
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
                U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
                U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>

    <style>
        :root {
            --primary-font: "Inter";
            --primary-color: #206bc4;
            --primary-color-rgb: 32, 107, 196;
            --secondary-color: #6c7a91;
            --secondary-color-rgb: 108, 122, 145;
            --heading-color: inherit;
            --text-color: #182433;
            --text-color-rgb: 24, 36, 51;
            --link-color: #206bc4;
            --link-color-rgb: 32, 107, 196;
            --link-hover-color: #206bc4;
            --link-hover-color-rgb: 32, 107, 196;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/font-awesome/css/fontawesome.min.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/select2/css/select2.min.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/css/libraries/select2.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/toastr/toastr.min.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/mcustom-scrollbar/jquery.mCustomScrollbar.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/flatpickr/flatpickr.min.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/spectrum/spectrum.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/fancybox/jquery.fancybox.min.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/morris/morris.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/css/core.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('themes/shopwise/css/flaticon.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('themes/shopwise/css/ionicons.min.css?v=1.41.') }}2" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('themes/shopwise/css/linearicons.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/plugins/language/css/language.css?v=1.41.2') }}" />
    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/plugins/analytics/libraries/jvectormap/jquery-jvectormap-1.2.2.css?v=1.41.2') }}" />

    <script src="{{ asset('vendor/core/core/base/libraries/jquery.min.js?v=1.41.2') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/core/core/base/js/app.js?v=1.41.2') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/core/core/base/libraries/vue.global.min.js?v=1.41.2') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/core/core/base/js/vue-app.js?v=1.41.2') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/core/core/base/libraries/ckeditor/ckeditor.js?v=1.41.2') }}"></script>
    <script src="{{ asset('vendor/core/core/base/js/editor.js?v=1.41.2') }}"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css">

    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/libraries/jquery-nestable/jquery.nestable.min.css') }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('vendor/core/core/base/css/core.css') }}">


    <link media="all" type="text/css" rel="stylesheet"
        href="{{ asset('vendor/core/core/base/css/tree-category.css') }}"> --}}
    @livewireStyles


    <!-- toastr style  -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
        
    <!-- loder style  -->
    <style>
        .preloader {
            background-color: #fff;
            bottom: 0;
            height: 100%;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            width: 100%;
            z-index: 9999;
        }

        .lds-ellipsis {
            margin: 0 auto;
            position: relative;
            top: 50%;
            -moz-transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            width: 64px;
            text-align: center;
            z-index: 9999;
        }

        .lds-ellipsis span {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #FF324D;
            -webkit-animation: ball-pulse-sync .6s 0s infinite ease-in-out;
            animation: ball-pulse-sync .6s 0s infinite ease-in-out;
        }

        .lds-ellipsis span:nth-child(1) {
            -webkit-animation: ball-pulse-sync .6s -.14s infinite ease-in-out;
            animation: ball-pulse-sync .6s -.14s infinite ease-in-out
        }

        .lds-ellipsis span:nth-child(2) {
            -webkit-animation: ball-pulse-sync .6s -70ms infinite ease-in-out;
            animation: ball-pulse-sync .6s -70ms infinite ease-in-out
        }

        @-webkit-keyframes ball-pulse-sync {
            33% {
                -webkit-transform: translateY(10px);
                transform: translateY(10px)
            }

            66% {
                -webkit-transform: translateY(-10px);
                transform: translateY(-10px)
            }

            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0)
            }
        }

        @keyframes ball-pulse-sync {
            33% {
                -webkit-transform: translateY(10px);
                transform: translateY(10px)
            }

            66% {
                -webkit-transform: translateY(-10px);
                transform: translateY(-10px)
            }

            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0)
            }
        }
    </style>

    {{-- <link rel="stylesheet" href="{{asset('assets/css/adminLoader.css')}}">  --}}

    <!-- DataTables CSS (in <head>) -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}

</head>

<body class="page-sidebar-closed-hide-logo page-content-white page-container-bg-solid" style="">
    <div id="app">
        {{--<div wire:loading.remove.delay class="preloader">
            <div class="lds-ellipsis">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>--}}