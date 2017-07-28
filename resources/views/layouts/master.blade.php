<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{URL::to('src/css/main.css')}}" type="text/css" />
    @yield('styles')
</head>
<body>
    @include('includes.header')
    @yield('content')
</body>
</html>