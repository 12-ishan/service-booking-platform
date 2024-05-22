@extends('layout.admin')
@section('content')

<div class="row">
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <!-- basic form start -->
            <div class="col-12 mt-5 start-form-sec">
                <div class="card">
                    <div class="card-body">
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
                                        <label for="categoryId">Category</label>
                                        <select class="form-control selectpicker" id="categoryId" name="categoryId" data-live-search="true">
                                            <option value="">Select Category</option>
                                            @if(isset($category))
                                            @foreach($category as $value)
                                            <option value="{{$value->id}}" @if (old('categoryId', isset($blog->category_id) ? $blog->category_id : NULL) == $value->id) selected="selected" @endif>{{$value->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{old('title',  isset($blog->title) ? $blog->title : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                @if(isset($blog->image->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60" src=" {{ URL::to('/') }}/uploads/blogImage/{{ $blog->image->name }}" alt="image">
                                    </div>
                                </div>
                                @endif

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="publishedBy">Published By</label>
                                        <input type="text" class="form-control" id="publishedBy" name="publishedBy" placeholder="Enter publisher name" value="{{old('publishedBy',  isset($blog->published_by) ? $blog->published_by : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <label for="publishedDate">Published On</label>
                                    <div class="input-group">
                                        <input type="text" name="publishedDate" placeholder="Enter publish date" id="publishedDate" class="form-control" value="{{old('publishedDate',  isset($blog->published_on) ? $blog->published_on : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" value="{{old('description',  isset($blog->description) ? $blog->description : NULL)}}">
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
<script src="{{ asset('assets/admin/js/console/ourServices.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function () {

    $("#publishedDate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: "c-50:c"
    });

    $("#dobIcon").on('click', function () {
        $("#publishedDate").datepicker('show');
    });
});
</script>
@append

@endsection
