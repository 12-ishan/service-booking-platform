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

                        <form id="teacherClassForm" method="post"
                            action="@if(isset($editStatus)){{ route('teacher-class.update', $teacherClass->id) }} @else {{ route('teacher-class.store')}}@endif"
                            enctype='multipart/form-data'>

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

                                <div class="col-4 mt-5">
                                    <div class="form-group">
                                        <label for="program">Program</label>
                                        <div class="loading"></div>
                                        <select class="form-control selectpicker" id="programId" name="programId"
                                            data-live-search="true">
                                            <option value="">Select Program</option>
                                            @if(isset($program))
                                            @foreach($program as $value)
                                            <option value="{{$value->id}}" @if (old('programId', isset($teacherClass->
                                                programId) ? $teacherClass->programId : NULL) == $value->id)
                                                selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4 mt-5">
                                    <div class="form-group">

                                        <label for="subjectId">Subject</label>
                                       
                                        <select class="form-control selectpicker" id="subjectId" name="subjectId" data-live-search="true" @if(!isset($editStatus)) disabled @endif>

                                            <option value="">Select Subject</option>
                                            @if(isset($subject))
                                            @foreach($subject as $value)

                                            <option value="{{$value->id}}" @if (old('subjectId', isset($teacherClass->subjectId) ? $teacherClass->subjectId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif

                                        </select>

                                    </div>
                                </div>

                                

                                <div class="col-4 mt-5">
                                    <div class="form-group">
                                        <label for="metaKeyword">Teacher</label>
                                        <select class="form-control selectpicker" id="teacherId" name="teacherId"
                                            data-live-search="true">
                                            <option value="">Select Teacher</option>
                                            @if(isset($role))
                                            @foreach($role as $value)
                                            <option value="{{$value->id}}" @if (old('teacherId', isset($teacherClass->
                                                teacherId) ? $teacherClass->teacherId : NULL) == $value->id)
                                                selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>

                            @if(isset($teacherClass->id))
                            <input type="hidden" name="id" value="{{ $teacherClass->id }}">
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
<script src="{{ asset('assets/admin/js/console/teacherClass.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#teacherClassForm").submit(function(){

        if($("#programId").val()=="")
        {
            $("#err").text("Please select dropdown");
            $("#programId").focus();
            return false;
        }
        if($("#subjectId").val()=="")
        {
            $("#err").text("Please select dropdown");
            $("#subjectId").focus();
            return false;
        }
        if($("#teacherId").val()=="")
        {
            $("#err").text("Please enter your teacher name");
            $("#teacherId").focus();
            return false;
        }
        });
    });
 
</script>
@endsection