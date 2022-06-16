<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SPK PT Madu Baru</title>

    <!-- Custom fonts for this template-->
    @stack('prepend-style')
    @include('includes.admin.styles')
    @stack('addon-style')
</head>

<body id="page-top">

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @yield('content')
    </div>
@stack('prepend-script')
@include('includes.admin.script')
@stack('addon-script')

</body>

</html>
