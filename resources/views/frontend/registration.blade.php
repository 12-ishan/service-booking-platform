@extends('layout.register')
@section('content')

<div class="col-md-5">
    <div class="login-sec">
       <h1 class="heading">Lorem ipsum dolor sit amet</h1>
       <p id="err" style="color:red;"></p>

       <form id="registrationForm" method="post" action="{{route('doRegistration')}}" class="login-form">

        {{ csrf_field() }}

        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif

          <div class="form-group">
             <label for="firstName" class="text-uppercase">First Name</label>
             <input id="firstName" name="firstName" type="text" class="form-control fname" placeholder="Enter your first name" value="">
             <span class="f-icon"><img src="{{asset('assets/frontend/images/user-icon.png')}}" alt="user-icon"></span>
          </div>
          <div class="form-group">
             <label for="lastName" class="text-uppercase">Last Name</label>
             <input id="lastName" name="lastName" type="text" class="form-control lname" placeholder="Enter your last name" value="" >
             <span class="f-icon"><img src="{{asset('assets/frontend/images/user-icon.png')}}" alt="user-icon"></span>
          </div>
          <div class="form-group">
             <label for="email" class="text-uppercase">Email</label>
             <input id="email" name="email" type="text" class="form-control email" placeholder="Enter email" value="" >
             <span class="e-icon"><img src="{{asset('assets/frontend/images/mail-icon.png')}}" alt="mail-icon'"></span>
          </div>
          <div class="form-group">
             <label for="password" class="text-uppercase">Password</label>
             <input id="password" name="password" type="password" class="form-control pass" placeholder="Enter password" value="" >
             <span class="visible"><img src="{{asset('assets/frontend/images/visible-icon.png')}}" alt="visible-icon"></span>
          </div>
          <div class="form-check">
             <label class="form-check-label">
             <input id="termsAndConditions"  type="checkbox" class="form-check-input" >
             <small>I agree to receive updates regarding my application & admission process. View <a href="#">Terms and Conditions</a>. </small>
             </label>
             <button type="submit" class="btn btn-login">Register</button>
          </div>
       </form>
       <div class="register text-center">Already Register? <a href="#">Login</a></div>
    </div>
 </div>
 <script type="text/javascript">

    $(document).ready(function(){
    
        $("#registrationForm").submit(function(){
           
            if($("#firstName").val()=="")
            {
                $("#err").text("Please enter first name");
                $("#firstName").focus();
                return false;
            }
            if($("#lastName").val()=="")
            {
                $("#err").text("Please enter last name");
                $("#lastName").focus();
                return false;
            }
            if($("#email").val()=="")
            {
                $("#err").text("Please enter your email");
                $("#email").focus();
                return false;
            }
            if(!$("#email").val().match("^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$"))
            {
                $("#err").text("Please enter valid email");
                $("#email").focus();
                return false;
            }
            if($("#password").val()=="")
            {
                $("#err").text("Please enter password");
                $("#password").focus();
                return false;
            }
        });
    });
     
    </script>    

@endsection