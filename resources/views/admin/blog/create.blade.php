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

                        <form id="blogForm" method="post" action="@if(isset($editStatus)){{ route('blog.update', $blog->id) }} @else {{ route('blog.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="name">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{old('title',  isset($blog->title) ? $blog->title : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="metaKeyword">Meta Keyword</label>
                                        <input type="text" class="form-control" id="metaKeyword" name="metaKeyword" placeholder="Enter Meta Keywords" value="{{old('metaKeyword',  isset($blog->metaKeyword) ? $blog->metaKeyword : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <label for="metaDescription">Meta Description</label>
                                        <input type="text" class="form-control" id="metaDescription" name="metaDescription" placeholder="Enter Meta Description" value="{{old('metaDescription',  isset($blog->metaDescription) ? $blog->metaDescription : NULL)}}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">


                                <div class="col-12 mt-6">
                                    <div class="form-group">
                                        <label for="name">Thumbnail</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>


                                @if(isset($blog->image->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60" src=" {{ URL::to('/') }}/uploads/blog/{{ $blog->image->name }}" alt="image">
                                    </div>
                                </div>
                                @endif

                            </div>

                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($blog->description) ? $blog->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($blog->id))
                            <input type="hidden" name="id" value="{{ $blog->id }}">
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
<script src="{{ asset('assets/admin/js/console/blog.js') }}"></script>
@append

@endsection