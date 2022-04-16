<!DOCTYPE html>
<html lang="fr">
<head>
        @include('partials.meta')
        @yield('title')
        <title>Gestion de stock</title>
        @yield('style')
        @include('partials.style')
        {{--@notifyCss--}}
        <style>
            .inset-0 {
            z-index: 999999999 !important;
            }
        </style>
    <body class="nav-fixed">
        {{--<x:notify-messages />--}}
        @include('partials.header')
        <div id="layoutSidenav_content">

        @yield('content')

        @include('partials.footer')
        </div>
        </div>
        @include('partials.script')
        @yield('script')
        {{--@notifyJs--}}
</body>

</html>
