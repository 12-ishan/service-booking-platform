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

                        <form id="ourServicesForm" method="post" action="@if(isset($editStatus)){{ route('our-services.update', $ourServices->id) }} @else {{ route('our-services.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="name">Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>


                                @if(isset($ourServices->image->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60" src=" {{ URL::to('/') }}/uploads/services/{{ $ourServices->image->name }}" alt="image">
                                    </div>
                                </div>
                                @endif

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{old('title',  isset($ourServices->title) ? $ourServices->title : NULL)}}">
                                    </div>
                                </div>
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" value="{{old('description',  isset($ourServices->description) ? $ourServices->description : NULL)}}">
                                    </div>
                                </div>
                            </div>
                            @if(isset($ourServices->id))
                            <input type="hidden" name="id" value="{{ $ourServices->id }}">
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
<script src="{{ asset('assets/admin/js/console/ourServices.js') }}"></script>
@append

@endsection