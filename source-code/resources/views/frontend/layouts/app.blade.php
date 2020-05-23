<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.partials.head')
<body>
    @include('frontend.partials.nav_bar')        
    @include('frontend.partials.notifications')
    @yield('content')
    @include('frontend.partials.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
