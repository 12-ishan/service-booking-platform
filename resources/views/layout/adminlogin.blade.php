<!doctype html>
<html class="no-js" lang="en">
<head>
  @include('admin/partials.head')  
</head>
<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    @yield('content') 
  
  @include('admin/partials.offset')
  @include('admin/partials.footer')
  @yield('js')
</body>
</html>
