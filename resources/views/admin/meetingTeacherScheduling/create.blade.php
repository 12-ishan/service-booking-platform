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

                        <form id="meetingTeacherSchedulingForm" method="post" action="@if(isset($editStatus)){{ route('meeting-teacher-scheduling.update', $meetingTeacherScheduling->id) }} @else {{ route('meeting-teacher-scheduling.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="meeting">Meeting</label>
                                         <select class="form-control selectpicker" id="meeting" name="meetingId" data-live-search="true">
                                            <option value="">Select Meeting</option>
                                            @if(isset($meetingList))
                                            @foreach($meetingList as $value)
                                            <option value="{{$value->id}}" @if (old('id', isset($meetingTeacherScheduling->meetingId) ? $meetingTeacherScheduling->meetingId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="metaKeyword">Teacher</label>
                                           <select class="form-control selectpicker" id="teacherId" name="teacherId" data-live-search="true">
                                            <option value="">Select Teacher</option>
                                            @if(isset($role))
                                            @foreach($role as $value)
                                            <option value="{{$value->id}}" @if (old('teacherId', isset($meetingTeacherScheduling->teacherId) ? $meetingTeacherScheduling->teacherId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="meetingDate">Meeting Date</label>
                                        <input type="date" class="form-control" id="meetingDate" name="meetingDate" placeholder="Enter Meta Description" value="{{old('meetingDate',  isset($meetingTeacherScheduling->meetingDate) ? $meetingTeacherScheduling->meetingDate : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="metaDescription">Meeting Time</label>
                                        <input type="time" id="appt" class="form-control" name="meetingTime" value="{{old('meetingTime',  isset($meetingTeacherScheduling->meetingTime) ? $meetingTeacherScheduling->meetingTime : NULL)}}">
                                    </div>
                                </div>

                            </div>
                            @if(isset($meetingTeacherScheduling->id))
                            <input type="hidden" name="id" value="{{ $meetingTeacherScheduling->id }}">
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
<script src="{{ asset('assets/admin/js/console/meetingTeacherScheduling.js') }}"></script>
@append

@endsection