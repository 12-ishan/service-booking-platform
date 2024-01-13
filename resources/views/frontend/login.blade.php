@extends('layout.register')
@section('content')
    <div class="col-md-5">
        <div class="login-sec">
            <h1 class="heading">Lorem ipsum dolor sit amet</h1>
            <p id="err" style="color:red;"></p>

            <form id="loginForm" method="post" action="{{ route('doStudentLogin') }}" class="login-form">
                {{ csrf_field() }}

                @if (session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session()->get('message') }}
                    </div>
                @endif


                <div class="form-group">
                    <label for="email" class="text-uppercase">Email</label>
                    <input id="email" name="email" type="text" class="form-control email" placeholder="Enter email"
                        value="">
                    <span class="e-icon"><img src="{{ asset('assets/frontend/images/mail-icon.png') }}"
                            alt="mail-icon'"></span>
                </div>
                <div class="form-group">
                    <label for="password" class="text-uppercase">Password</label>
                    <input id="password" name="password" type="password" class="form-control pass"
                        placeholder="Enter password" value="">
                    <span class="visible"><img src="{{ asset('assets/frontend/images/visible-icon.png') }}"
                            alt="visible-icon"></span>
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {

                $("#loginForm").submit(function() {

                    if ($("#email").val() == "") {
                        $("#err").text("Please enter your email");
                        $("#email").focus();
                        return false;
                    }
                    if (!$("#email").val().match(
                            "^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$")) {
                        $("#err").text("Please enter valid email");
                        $("#email").focus();
                        return false;
                    }
                    if ($("#password").val() == "") {
                        $("#err").text("Please enter password");
                        $("#password").focus();
                        return false;
                    }

                });
            });
        </script>
    @endsection
