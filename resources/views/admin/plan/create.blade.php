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

                        <form id="bannerForm" method="post" action="@if(isset($editStatus)){{ route('banner.update', $banner->id) }} @else {{ route('banner.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="type">Type</label>
                                        <input type="number" min="1" oninput="this.value = Math.abs(this.value)" class="form-control" id="type" name="type" placeholder="Enter type" value="{{old('type',  isset($banner->type) ? $banner->type : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="bannerHeading">Banner Heading</label>
                                        <input type="text" class="form-control" id="bannerHeading" name="bannerHeading" placeholder="Enter Banner Heading" value="{{old('bannerHeading',  isset($banner->bannerHeading) ? $banner->bannerHeading : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <label for="bannerText">Banner Text</label>
                                        <input type="text" class="form-control" id="bannerText" name="bannerText" placeholder="Enter Banner text" value="{{old('bannerText',  isset($banner->bannerText) ? $banner->bannerText : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <label for="bannerSloganText">Banner Slogan Text</label>
                                        <input type="text" class="form-control" id="bannerSloganText" name="bannerSloganText" placeholder="Enter Banner Slogan Text" value="{{old('bannerSloganText',  isset($banner->bannerSloganText) ? $banner->bannerSloganText : NULL)}}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">


                                <div class="col-12 mt-6">
                                    <div class="form-group">
                                        <label for="name">Thumbnail</label>
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>
                                </div>


                                @if(isset($banner->image->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60" src=" {{ URL::to('/') }}/uploads/banner/{{ $banner->image->name }}" alt="image">
                                    </div>
                                </div>
                                @endif

                            </div>

                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($banner->description) ? $banner->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($banner->id))
                            <input type="hidden" name="id" value="{{ $banner->id }}">
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
<script src="{{ asset('assets/admin/js/console/banner.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#bannerForm").submit(function(){

        if($("#type").val()=="")
        {
            $("#err").text("Please enter your type");
            $("#type").focus();
            return false;
        }
        if($("#bannerHeading").val()=="")
        {
            $("#err").text("Please enter your bannerHeading");
            $("#bannerHeading").focus();
            return false;
        }
        if($("#bannerText").val()=="")
        {
            $("#err").text("Please enter your bannerText");
            $("#bannerText").focus();
            return false;
        }
        if($("#bannerSloganText").val()=="")
        {
            $("#err").text("Please enter your bannerSloganText");
            $("#bannerSloganText").focus();
            return false;
        }
        });
    });
 
</script>

@endsection