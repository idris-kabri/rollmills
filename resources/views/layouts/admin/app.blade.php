@include('layouts.admin.header')
@include('layouts.admin.navbar')
@include('layouts.admin.sidebar')
{{ $slot }}
@include('layouts.admin.footer')