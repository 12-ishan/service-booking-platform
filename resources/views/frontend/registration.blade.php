@extends('layout.register')
@section('content')

<div class="col-md-5">
    <div class="login-sec">
       <h1 class="heading">Lorem ipsum dolor sit amet</h1>
       <form class="login-form">
          <div class="form-group">
             <label for="exampleInputFirst" class="text-uppercase">First Name</label>
             <input type="text" class="form-control fname" placeholder="" required>
             <span class="f-icon"><img src="{{asset('assets/frontend/images/user-icon.png')}}" alt="user-icon"></span>
          </div>
          <div class="form-group">
             <label for="exampleInputlastname" class="text-uppercase">Last Name</label>
             <input type="text" class="form-control lname" placeholder="" required>
             <span class="f-icon"><img src="{{asset('assets/frontend/images/user-icon.png')}}" alt="user-icon"></span>
          </div>
          <div class="form-group">
             <label for="exampleInputEmail" class="text-uppercase">Email</label>
             <input type="password" class="form-control email" placeholder="" required>
             <span class="e-icon"><img src="{{asset('assets/frontend/images/mail-icon.png')}}" alt="mail-icon'"></span>
          </div>
          <div class="form-group">
             <label for="exampleInputPassword1" class="text-uppercase">Password</label>
             <input type="password" class="form-control pass" placeholder="" required>
             <span class="visible"><img src="{{asset('assets/frontend/images/visible-icon.png')}}" alt="visible-icon"></span>
          </div>
          <div class="form-check">
             <label class="form-check-label">
             <input type="checkbox" class="form-check-input">
             <small>I agree to receive updates regarding my application & admission process. View <a href="#">Terms and Conditions</a>. </small>
             </label>
             <button type="submit" class="btn btn-login">Register</button>
          </div>
       </form>
       <div class="register text-center">Already Register? <a href="#">Login</a></div>
    </div>
 </div>

@endsection