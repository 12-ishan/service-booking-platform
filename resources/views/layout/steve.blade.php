<!doctype html>
<html class="no-js" lang="eng">
    <head>
    @include('steve/partials.head')  
   </head>

   <body>
       
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{asset('steve/img/logo.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->

    <header>
     @include('steve/partials.header')
    </header>

    @yield('content')

    @include('steve/partials.footer') 

            
    </body>
</html>