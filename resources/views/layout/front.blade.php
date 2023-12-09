
<!DOCTYPE html>

<html lang="en">

<head>

    @include('frontened/partials.head') 

  
</head>

<body>


<!-- HEADER -->

@include('frontened/partials.header') 


@yield('content')

<!-- FOOTER -->

@include('frontened/partials.footer') 



</body>

</html>