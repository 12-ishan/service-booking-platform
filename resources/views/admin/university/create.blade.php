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

                        <form id="universityForm" method="post" action="@if(isset($editStatus)){{ route('university.update', $university->id) }} @else {{ route('university.store')}}@endif" enctype='multipart/form-data'>


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
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter university name" value="{{old('name',  isset($university->name) ? $university->name : NULL)}}">
                                    </div>
                                </div> 

                            </div>


                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($university->description) ? $university->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($university->id))
                            <input type="hidden" name="id" value="{{ $university->id }}">
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
<script src="{{ asset('assets/admin/js/console/university.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#universityForm").submit(function(){

        if($("#name").val()=="")
        {
            $("#err").text("Please enter university name");
            $("#name").focus();
            return false;
        }
        });
    });
 
</script>

@endsection