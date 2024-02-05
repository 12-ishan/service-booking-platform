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

                        <form id="profileForm" method="post" action="@if(isset($editStatus)){{ route('profile.update', $profile->id) }} @else {{ route('profile.store')}}@endif" enctype='multipart/form-data'>


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
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter profile" value="{{old('name',  isset($profile->name) ? $profile->name : NULL)}}">
                                    </div>
                                </div> 

                            </div>

                            <div class="row">

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth:</label>
                                        <input type="text" id="dob" name="dob" placeholder="yy-mm-dd" class="datepicker"  value="{{old('dob',  isset($profile->dob) ? $profile->dob : NULL)}}">
                                    </div>
                                </div> 

                            </div>
                        
                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($profile->description) ? $profile->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($profile->id))
                            <input type="hidden" name="id" value="{{ $profile->id }}">
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
<script src="{{ asset('assets/admin/js/console/profile.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });
    
      $("#profileForm").submit(function(){

        if($("#name").val()=="")
        {
            $("#err").text("Please enter profile");
            $("#name").focus();
            return false;
        }

        });
});
 
</script>


@endsection