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

                        <form id="applicationForm" method="post" action="@if(isset($editStatus)){{ route('application.update', $application->id) }} @else {{ route('application.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="studentId">Student</label>
                                        <select class="form-control selectpicker" id="studentName" name="studentName" data-live-search="true">
                                            <option value="">Select student</option>
                                            @if(isset($student))
                                            @foreach($student as $value)
                                            <option value="{{$value->id}}" @if (old('studentId', isset($application->student_id ) ? $application->student_id : NULL) == $value->id) selected="selected" @endif>{{$value->first_name . " " . $value->last_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="applicationNumber">Application Number</label>
                                        <input type="text" class="form-control" id="applicationNumber" name="applicationNumber" placeholder="Enter application number" value="{{old('applicationNumber',  isset($application->application_number) ? $application->application_number : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="startTime">Start Time</label>
                                        <input type="text" class="form-control" id="startTime" name="startTime" placeholder="Enter start time" value="{{old('startTime',  isset($application->start_time) ? $application->start_time : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="endTime">End Time</label>
                                        <input type="text" class="form-control" id="endTime" name="endTime" placeholder="Enter end time" value="{{old('endTime',  isset($application->end_time) ? $application->end_time : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="lastDate">Last Date</label>
                                        <input type="text" class="form-control" id="lastDate" name="lastDate" placeholder="Enter last date" value="{{old('lastDate',  isset($application->last_date) ? $application->last_date : NULL)}}">
                                    </div>
                                </div>
                            </div>   

                            <div class="row">
                                <div class="col-12 mt-10">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($application->description) ? $application->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>
                            @if(isset($application->id))
                            <input type="hidden" name="id" value="{{ $application->id }}">
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
<script src="{{ asset('assets/admin/js/console/application.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#applicationForm").submit(function(){

        if($("#studentId").val()=="")
        {
            $("#err").text("Please select student Id");
            $("#studentId").focus();
            return false;
        }
        if($("#startDate").val()=="")
        {
            $("#err").text("Please enter start date");
            $("#startTime").focus();
            return false;
        }
        if($("#endDate").val()=="")
        {
            $("#err").text("Please enter end date");
            $("#endTime").focus();
            return false;
        }
        if($("#lastDate").val()=="")
        {
            $("#err").text("Please enter last date");
            $("#lastDate").focus();
            return false;
        }
        });
    });
 
</script>

@endsection