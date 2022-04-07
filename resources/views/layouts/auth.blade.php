<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keyword" content="">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- Vendors styles-->
        <link rel="stylesheet" href="{{ asset('vendors/simplebar/css/simplebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
        <!-- Main styles for this application-->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    </head>

    <body>
        @yield('content')
        <!-- CoreUI and necessary plugins-->
        <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
        <script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
    </body>

</html>
