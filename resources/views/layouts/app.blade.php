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
    <nav class="navbar navbar-light bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ url('backend/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
                PT Madu Baru Yogyakarta
            </a>

            @guest
                <a href="{{ route('dashboard') }}" class="btn btn-sm my-2 my-sm-0 text-dark font-weight-bold">Hitung Spk</a>
            @endguest

            @auth
                <form class="form-inline my-2 my-lg-0 d-none d-md-block text-dark font-weight-bold" action="{{  url('logout') }}" method="POST">
                    <a href="{{ route('dashboard') }}" class="btn btn-sm my-2 my-sm-0 text-dark font-weight-bold">Hitung Spk</a>
                    @csrf
                    <button class="btn btn-sm my-2 my-sm-0 text-dark font-weight-bold" type="submit">
                        Keluar
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @yield('content')
        </div>
@stack('prepend-script')
@include('includes.admin.script')
@stack('addon-script')

</body>

</html>
