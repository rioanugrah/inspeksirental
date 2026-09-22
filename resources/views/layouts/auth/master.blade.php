<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @php
        $asset = asset('backend/assets/');
    @endphp
    <link rel="shortcut icon" href="{{ $asset }}/images/favicon.ico">

    <!-- App css -->
    <link href="{{ $asset }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ $asset }}/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ $asset }}/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
    <link href="{{ $asset }}/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

    <!-- icons -->
    <link href="{{ $asset }}/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="authentication-bg">
    <div class="account-pages my-5">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <!-- Vendor js -->
    <script src="{{ $asset }}/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="{{ $asset }}/js/app.min.js"></script>
</body>
</html>
