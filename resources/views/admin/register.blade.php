@extends('layout.adminlogin')
@section('content')
 
   <!-- login area start -->
   <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">

            

            <form id="registrationForm" method="POST" action="/register">
            {{ csrf_field() }}
                    <div class="login-form-head">

                  
                        <h4>Sign up</h4>
                        <p>Always deliver more than expected</p>

                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach

                    </div>

                    @if(session()->has('message'))
                    <div class="alert alert-success" >
                    {{ session()->get('message') }}
                    </div>
                    @endif

                    <div id="err" class="alert alert-danger" style="display:none;">
                    </div>

                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputName1">Full Name</label>
                            <input type="text" id="name" name="name">
                            <i class="ti-user"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="email" name="email">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="password" name="password">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                            <!-- <div class="login-other row mt-4">
                                <div class="col-6">
                                    <a class="fb-login" href="#">Sign up with <i class="fa fa-facebook"></i></a>
                                </div>
                                <div class="col-6">
                                    <a class="google-login" href="#">Sign up with <i class="fa fa-google"></i></a>
                                </div>
                            </div> -->
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="{{ url('/admin/login') }}">Sign in</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

        @section('js')
        <script src="{{ asset('assets/admin/js/registration.js') }}"></script>
        @append
        
@endsection