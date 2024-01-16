@extends('layout.admin')
@section('content')

<div class="row">

<div class="col-lg-12 col-ml-12">
        <div class="row">
            <!-- basic form start -->

            <div class="col-12 mt-5 start-form-sec">

                <div class="card">
                    <div class="card-body">

                        <!-- <h4 class="header-title">Basic form</h4> -->
                         <p id="err" style="color:red;"></p>

                        <form id="studentManagerForm" method="post" action="@if(isset($editStatus)){{ route('studentManager.update', $student->id) }} @else {{ route('studentManager.store')}}@endif" enctype='multipart/form-data'>


                            {{ csrf_field() }}

                            @if(isset($editStatus))
                            @method('PUT')
                            @endif


                            @if(session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session()->get('message') }}
                            </div>
                            @endif


                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach

                            <div class="row">

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="firstName"> First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" value="{{old('firstName',  isset($student->first_name) ? $student->first_name : NULL)}}">
                                    </div>
                                </div> 

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" value="{{old('lastName',  isset($student->last_name) ? $student->last_name : NULL)}}">
                                    </div>
                                </div> 

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="{{old('email',  isset($student->email) ? $student->email : NULL)}}">
                                    </div>
                                </div> 

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control" id="password" name="password" placeholder="Enter password" value="">
                                    </div>
                                </div> 

                            </div>

                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($student->description) ? $student->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($student->id))
                            <input type="hidden" name="id" value="{{ $student->id }}">
                            @endif
                           
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- basic form end -->
        </div>
    </div>
</div>

@section('js')
<script src="{{ asset('assets/admin/js/console/studentManager.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#studentManagerForm").submit(function(){

        if($("#firstName").val()=="")
        {
            $("#err").text("Please enter first name");
            $("#name").focus();
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
                $("#err").text("Please enter email");
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