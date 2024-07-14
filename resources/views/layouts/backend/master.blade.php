<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @php
        $asset = asset('backend/assets/');
    @endphp
    <link href="{{ $asset }}/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ $asset }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ $asset }}/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ $asset }}/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet"
        disabled />
    <link href="{{ $asset }}/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"
        disabled />

    <!-- icons -->
    <link href="{{ $asset }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    @yield('css')
</head>

<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>
    <!-- Begin page -->
    <div id="wrapper">
        @include('layouts.backend.topbar')
        @include('layouts.backend.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('layouts.backend.footer')
        </div>
    </div>
    <script src="{{ $asset }}/js/vendor.min.js"></script>

    <script src="{{ $asset }}/libs/moment/min/moment.min.js"></script>
    {{-- <script src="{{ $asset }}/libs/apexcharts/apexcharts.min.js"></script> --}}
    <script src="{{ $asset }}/libs/flatpickr/flatpickr.min.js"></script>

    {{-- <script src="{{ $asset }}/js/pages/dashboard.init.js"></script> --}}

    <script src="{{ $asset }}/js/app.min.js"></script>
    @yield('script')
</body>

</html>
