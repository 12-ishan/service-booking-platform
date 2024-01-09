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

                        <form id="salutationForm" method="post" action="@if(isset($editStatus)){{ route('salutation.update', $salutation->id) }} @else {{ route('salutation.store')}}@endif" enctype='multipart/form-data'>


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
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter salutation" value="{{old('name',  isset($salutation->name) ? $salutation->name : NULL)}}">
                                    </div>
                                </div> 

                            </div>


                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($salutation->description) ? $salutation->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($salutation->id))
                            <input type="hidden" name="id" value="{{ $salutation->id }}">
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
<script src="{{ asset('assets/admin/js/console/salutation.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#salutationForm").submit(function(){

        if($("#name").val()=="")
        {
            $("#err").text("Please enter salutation");
            $("#name").focus();
            return false;
        }
        });
    });
 
</script>

@endsection