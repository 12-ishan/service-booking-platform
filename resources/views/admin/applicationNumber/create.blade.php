@extends('layout.admin')
@section('content')

<div class="row">


    <div class="col-lg-6 col-ml-12">
        <div class="row">
            <!-- basic form start -->

            <div class="col-12 mt-5 start-form-sec">

                <div class="card">
                    <div class="card-body">

                        <form id="applicationNumberForm" method="post" action="@if(isset($editStatus)){{ route('application-number.update', $applicationNumber->id) }} @else {{ route('application-number.store')}}@endif">

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
                                        <label for="prefix">Prefix</label>
                                        <input type="text" class="form-control" id="prefix" name="prefix" placeholder="Enter prefix" value="{{old('prefix',  isset($applicationNumber->prefix) ? $applicationNumber->prefix : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="suffix">Suffix</label>
                                        <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Enter suffix" value="{{old('suffix',  isset($applicationNumber->suffix) ? $applicationNumber->suffix : NULL)}}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">


                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="startNumber">Start Number</label>
                                        <input type="number" class="form-control" id="startNumber" name="startNumber" placeholder="Enter Start Number" value="{{old('startNumber',  isset($applicationNumber->startNumber) ? $applicationNumber->startNumber : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input type="text" class="form-control" id="type" name="type" placeholder="Enter Type" value="{{old('type',  isset($applicationNumber->type) ? $applicationNumber->type : NULL)}}" readonly>
                                    </div>
                                </div>



                            </div>

                            <div class="row">
                                <div class="col-12 mt-10">
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <textarea class="form-control ckeditor" id="comment" name="comment" placeholder="Enter Comment">{{old('comment', isset($applicationNumber->comment) ? $applicationNumber->comment : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($applicationNumber->id))
                            <input type="hidden" name="id" value="{{ $applicationNumber->id }}">
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
<script src="{{ asset('assets/admin/js/console/applicationNumber.js') }}"></script>
@append

@endsection