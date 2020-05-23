<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.partials.head')
<body>       
    @include('frontend.partials.notifications')
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
