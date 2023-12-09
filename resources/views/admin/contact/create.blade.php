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

                        <form id="contactForm" method="post" action="@if(isset($editStatus)){{ route('contact.update', $contact->id) }} @else {{ route('contact.store')}}@endif" enctype='multipart/form-data'>

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
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name',  isset($contact->name) ? $contact->name : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{old('email',  isset($contact->email) ? $contact->email : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="{{old('phone',  isset($contact->phone) ? $contact->phone : NULL)}}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12 mt-10">
                                    <div class="form-group">
                                        <label for="description">Message</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Message">{{old('message', isset($contact->message) ? $contact->message : NULL)}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @if(isset($contact->id))
                            <input type="hidden" name="id" value="{{ $contact->id }}">
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
<script src="{{ asset('assets/admin/js/console/contact.js') }}"></script>
@append

@endsection