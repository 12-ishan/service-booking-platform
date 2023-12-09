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

                        <form id="questionCategoryForm" method="post" action="@if(isset($editStatus)){{ route('question-category.update', $questionCategory->id) }} @else {{ route('question-category.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="program">Program</label>
                                        <div class="loading"></div>
                                        <select class="form-control selectpicker" id="programId" name="programId"
                                            data-live-search="true">
                                            <option value="">Select Program</option>
                                            @if(isset($program))
                                            @foreach($program as $value)
                                            <option value="{{$value->id}}" @if (old('programId', isset($questionCategory->
                                                programId) ? $questionCategory->programId : NULL) == $value->id)
                                                selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">

                                        <label for="subjectId">Subject</label>
                                       
                                        <select class="form-control selectpicker" id="subjectId" name="subjectId" data-live-search="true" @if(!isset($editStatus)) disabled @endif>

                                            <option value="">Select Subject</option>
                                            @if(isset($subject))
                                            @foreach($subject as $value)

                                            <option value="{{$value->id}}" @if (old('subjectId', isset($questionCategory->subjectId) ? $questionCategory->subjectId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif

                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name',  isset($questionCategory->name) ? $questionCategory->name : NULL)}}">
                                    </div>
                                </div>

                                  <div class="col-6 mt-5">
                                    <div class="form-group">

                                        <label for="stateId">State</label>
                                       
                                        <select class="form-control selectpicker" id="stateId" name="stateId" data-live-search="true" @if(!isset($editStatus)) @endif>

                                            <option value="">Select State</option>
                                            @if(isset($state))
                                            @foreach($state as $value)

                                            <option value="{{$value->id}}" @if (old('stateId', isset($questionCategory->stateId) ? $questionCategory->stateId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif

                                        </select>

                                    </div>
                                </div>

                            </div>

                        

                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($questionCategory->description) ? $questionCategory->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($questionCategory->id))
                            <input type="hidden" name="id" value="{{ $questionCategory->id }}">
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
<script src="{{ asset('assets/admin/js/console/questionCategory.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#questionCategoryForm").submit(function(){

        if($("#programId").val()=="")
        {
            $("#err").text("Please select program name");
            $("#programId").focus();
            return false;
        }
        if($("#subjectId").val()=="")
        {
            $("#err").text("Please select subject name");
            $("#subjectId").focus();
            return false;
        }
        if($("#name").val()=="")
        {
            $("#err").text("Please enter question category");
            $("#name").focus();
            return false;
        }
        if($("#stateId").val()=="")
        {
            $("#err").text("Please select state name");
            $("#stateId").focus();
            return false;
        }
        });
    });
 
</script>

@endsection