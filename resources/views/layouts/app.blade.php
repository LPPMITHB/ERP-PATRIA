<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <title>ERP - PATRIA</title>
    <link rel="icon" href="{!! asset('images/icon.png') !!}"/>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}" type="text/css">
    <style>
        body {
            background-image: url("{{ asset('/images/login-background.jpeg') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment :fixed;
            background-position :center;
        }
    </style>
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
