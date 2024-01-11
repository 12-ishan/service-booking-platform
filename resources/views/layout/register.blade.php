<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Bootstrap CSS -->
      <link href="{{ asset('assets/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
      <script src="{{ asset('assets/frontend/js/jquery.min.js')}}"></script>
      <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
      <link href="{{ asset('assets/frontend/css/style.css')}}" rel="stylesheet">
      <title>Registeration Form</title>
   </head>
   <body>
      <section class="login-block">
         <div class="container">
            <div class="row alignment">
               <div class="col-md-7">
                  <div class="banner-sec">
                     <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                           <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                           <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                           <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                           <div class="carousel-item active">
                              <img class="d-block img-fluid" src="{{ asset('assets/frontend/images/student.jpg')}}" alt="First slide">
                              <div class="carousel-caption d-none d-md-block">
                                 <div class="banner-text">
                                    <h2 class="heading">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
                                    <p>Lorem ipsum dolor sit amet, sed do eiusmod tempor incididunt consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                 </div>
                              </div>
                           </div>
                           <div class="carousel-item">
                              <img class="d-block img-fluid" src="{{ asset('assets/frontend/images/student.jpg')}}" alt="First slide">
                              <div class="carousel-caption d-none d-md-block">
                                 <div class="banner-text">
                                    <h2 class="heading">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                 </div>
                              </div>
                           </div>
                           <div class="carousel-item">
                              <img class="d-block img-fluid" src="{{ asset('assets/frontend/images/student.jpg')}}" alt="First slide">
                              <div class="carousel-caption d-none d-md-block">
                                 <div class="banner-text">
                                    <h2 class="heading">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               
               @yield('content')

            </div>
         </div>
      </section>
      <section class="">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h2 class="heading-2">Lorem ipsum dolor</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
               </div>
            </div>
         </div>
      </section>
      <section class="bg-sky pad-0">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <div class="align-center">
                     <div class="address">
                        <p class="heading-3">SOIL Institute of Management</p>
                        <p>Plot no 76, Sector 44<br>
                           Gurgaon (Delhi NCR)<br>
                           Haryana – 122003<br>
                           Telephone: 0124-4302222<br>
                           Email – <a href="mailto:admissions@soilindia.net">admissions@soilindia.net</a>
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="address-map">
                     <iframe allowfullscreen="" aria-hidden="false" frameborder="0" height="350" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3507.9678682539948!2d77.06776111507851!3d28.450384982489915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d18ed16e1acb3%3A0xf900a025b80f216c!2sSoil%20School%20of%20Inspired%20Leadership!5e0!3m2!1sen!2sin!4v1605960129941!5m2!1sen!2sin" style="border:0; line-height: 0;" tabindex="0" width="100%"></iframe>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="bg-clients bg-white">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="clients-heading">
                     <h2 class="heading-2 text-center">Associations</h2>
                  </div>
                  <div class="clients-logo">
                     <ul>
                     <li><img src="{{ asset('assets/frontend/images/asso_img_4-1.jpg')}}" alt="logo"></li>
                     <li><img src="{{ asset('assets/frontend/images/asso_img_2-1.jpg')}}" alt="logo"></li>
                     <li><img src="{{ asset('assets/frontend/images/asso_img_5-13.jpg')}}" alt="logo"></li>       
                     <li><img src="{{ asset('assets/frontend/images/asso_img_1-1.jpg')}}" alt="logo"></li>
                     <li><img src="{{ asset('assets/frontend/images/asso_img_3-1.jpg')}}" alt="logo"></li>
                     <li><img src="{{ asset('assets/frontend/images/asso_img_4-1.jpg')}}" alt="logo"></li>
                     <li><img src="{{ asset('assets/frontend/images/asso_img_3-1.jpg')}}" alt="logo"></li>
                     <li><img src="{{ asset('assets/frontend/images/asso_img_2-1.jpg')}}" alt="logo"></li>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="bg-sky pad-0">
         <div class="container">
            <div class="row">
               <div class="col-md-12 ">
                  <div class="footer">
                     <p class="text-center">© Copyright 2023</p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Optional JavaScript; choose one of the two! -->
      <!-- Option 1: Bootstrap Bundle with Popper -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
   </body>
</html>