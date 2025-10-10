</div>
</div>
<script src="{{asset('assets/backend/js/vendors/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/backend/js/vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/backend/js/vendors/jquery.fullscreen.min.js')}}"></script>
<!-- Main Script -->
<script src="{{asset('assets/backend/js/main.js')}}" type="text/javascript"></script>
{{-- <script src="{{ asset('vendor/core/core/base/js/core-ui.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/excanvas.min.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/ie8.fix.min.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/modernizr/modernizr.min.js') }}"></script> --}}
{{-- <script src="{{ asset('vendor/core/core/base/libraries/select2/js/select2.min.js') }}"></script> --}}
{{-- <script src="{{ asset('vendor/core/core/base/libraries/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/js/core.js') }}"></script> --}}
{{-- <script src="{{ asset('vendor/core/core/base/libraries/toastr/toastr.min.js') }}"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('vendor/core/core/base/libraries/mcustom-scrollbar/jquery.mCustomScrollbar.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/stickytableheaders/jquery.stickytableheaders.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/jquery-waypoints/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/spectrum/spectrum.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/fancybox/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/fslightbox.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/sortable/sortable.min.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/raphael-min.js') }}"></script>
<script src="{{ asset('vendor/core/core/base/libraries/morris/morris.min.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/language/js/language-global.js') }}"></script>
<script src="{{ asset('vendor/core/core/dashboard/js/dashboard.js') }}"></script>
<script src="{{ asset('vendor/core/core/dashboard/js/check-for-updates.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/analytics/libraries/jvectormap/jquery-jvectormap-1.2.2.min.js') }}">
</script>
<script src="{{ asset('vendor/core/plugins/analytics/libraries/jvectormap/jquery-jvectormap-world-mill-en.js') }}">
</script> --}}
{{-- <script src="{{ asset('vendor/core/plugins/analytics/js/analytics.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/blog/js/blog.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/audit-log/js/audit-log.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/ecommerce/js/dashboard-widgets.js') }}"></script> --}}
@livewireScripts
{{-- <script src="{{ asset('vendor/core/core/base/js/notification.js') }}"></script> --}}
<!-- loader scripts js -->
{{-- <script src="{{ asset('assets/js/scripts.js') }}"></script> --}}
<!-- jquery-ui -->
{{-- <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>  --}}

<!-- jQuery + DataTables JS (before </body>) -->
{{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-177863130-1');
</script>
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.1/"
        }
    }
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

<!-- toastr script cdn   -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script>
    function displayValidationErrors(errors) {
        // Clear any previous error messages
        document.querySelectorAll('.error-message').forEach((elem) => elem.remove());

        // Iterate through the errors object
        for (const [field, messages] of Object.entries(errors)) {
            // Find the input element associated with the field
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                // Create a new span element for the error message
                const errorMessage = document.createElement('span');
                errorMessage.className = 'error-message'; // Add a class for styling
                errorMessage.style.color = 'red'; // Optional: Add inline styling
                errorMessage.textContent = messages.join(', '); // Join multiple messages if any
                // Insert the error message after the input field
                input.parentNode.insertBefore(errorMessage, input.nextSibling);
                console.log(input.parentNode.insertBefore(errorMessage, input.nextSibling))
            }
        }
    }

    // Listen for the success event
    document.addEventListener('success', event => {
        toastr.success(event.detail.message);
    });

    document.addEventListener('error', event => {
        toastr.error(event.detail.message);
    });

    window.addEventListener('redirectAfterDelay', (event) => {
        const redirectUrl = event.detail[0].url ?? '/';
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 2000);
    });

    function displayValidationErrors(errors) {
        // Clear any previous error messages
        document.querySelectorAll('.error-message').forEach((elem) => elem.remove());

        // Iterate through the errors object
        for (const [field, messages] of Object.entries(errors)) {
            // Find the input element associated with the field
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                // Create a new span element for the error message
                const errorMessage = document.createElement('span');
                errorMessage.className = 'error-message'; // Add a class for styling
                errorMessage.style.color = 'red'; // Optional: Add inline styling
                errorMessage.textContent = messages.join(', '); // Join multiple messages if any
                // Insert the error message after the input field
                input.parentNode.insertBefore(errorMessage, input.nextSibling);
                console.log(input.parentNode.insertBefore(errorMessage, input.nextSibling))
            }
        }
    }

    window.addEventListener('validation-errors', (event) => {
        var errors = event.detail[0].errors;
        displayValidationErrors(errors);
    })
</script>


@yield('scripts')

</body>

</html>
