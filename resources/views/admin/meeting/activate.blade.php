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

                        <form id="Activatefrm" method="post"
                            action="{{url('meeting/activate/update')}}/{{ $meeting->id}}" enctype='multipart/form-data'>

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
                                        <label for="meetingUrl">Meeting Url</label>
                                        <input type="text" class="form-control" id="meetingUrl" name="meetingUrl" placeholder="Enter Url" value="{{old('meetingUrl',  isset($meeting->meetingUrl) ? $meeting->meetingUrl : NULL)}}">
                                    </div>
                                </div>
                               
                                <div class="col-4 mt-5">
                                    <div class="form-group">
                                        <label for="meetingStatus">Meeting Status</label>
                                       <select class="form-control selectpicker" id="meetingStatus" name="meetingStatus" data-live-search="true">
                                            <option value="">Select Status</option>
                                           
                                            <option value="1" @if (old('meetingStatus', isset($meeting->meetingStatus) ? $meeting->meetingStatus : NULL) == 1) selected="selected" @endif>Active</option>
                                            <option value="0" @if (old('meetingStatus', isset($meeting->meetingStatus) ? $meeting->meetingStatus : NULL) == 0) selected="selected" @endif>Deactivate</option>
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4 mt-5">
                                    <div class="form-group">
                                        <label for="meetingStatus">Available Teachers</label>
                                       <select class="form-control selectpicker" id="tutorId" name="tutorId"
                                            data-live-search="true">
                                            <option value="">Select Teacher</option>
                                            @if(isset($teacher))
                                            @foreach($teacher as $value)
                                            <option value="{{$value->teacherId}}" @if (old('tutorId', isset($meeting->tutorId) ? $meeting->tutorId : NULL) == $value->teacherId)
                                                selected="selected" @endif>{{$value->teacher->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>
                        @if(isset($meeting->id))
                        <input type="hidden" name="id" value="{{ $meeting->id }}">
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


<script type="text/javascript">

$(document).ready(function(){

    $("#Activatefrm").submit(function(){

        if($("#meetingUrl").val()=="")
        {
            $("#err").text("Please enter meeting url");
            $("#meetingUrl").focus();
            return false;
        }
        if($("#meetingStatus").val()=="")
        {
            $("#err").text("Please select meeting status");
            $("#meetingStatus").focus();
            return false;
        }
        });
    });
</script>
@section('js')
<script src="{{ asset('assets/admin/js/console/meeting.js') }}"></script>
@append

@endsection