<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
   @include('backend.partials.head')
   <body>
      <section class="material-half-bg">
         <div class="cover"></div>
      </section>
      @yield('content')
      <script src="{{{ asset('js/admin.js') }}}"></script>
      @section('page_scripts')@show
   </body>
</html>