@extends('layout.register')
@section('content')
    <div class="col-md-5">
        <div class="login-sec">
            <h1 class="heading">Lorem ipsum dolor sit amet</h1>
            <p id="err" style="color:red;"></p>

            this is a dashbaord

            <a href="{{ url('/student/logout') }}">Logout</a>
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
