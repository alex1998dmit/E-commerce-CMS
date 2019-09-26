<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Admin Panel
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ route('categories') }}">Categories</a>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ route('category.trashed') }}">Trashed Categories</a>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ route('products') }}">Products</a>
                    </ul>
                        {{-- <ul class="navbar-nav mr-auto">
                            <a class="nav-link" href="{{ route('carts') }}">From user's cart</a>
                        </ul> --}}
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ route('orders') }}">Orders</a>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ route('orders.trashed') }}">Trashed Orders</a>
                    </ul>

                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ route('requisites') }}">Requisites</a>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ route('users') }}">Users</a>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
<script>
</script>
</body>
</html>
