@extends('layout.admin')
@section('content')

<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body list-grid">

                <div class="row">
                    <div class="col-12">
                        <div class="grid-col control-bar">

                            <div class="row control">
                                <div class="col-6 left-control">

                                    <button type="button" class="btn btn-flat btn-secondary mb-3" onclick="checkAll(1)">Check All</button>
                                    <button type="button" class="btn btn-flat btn-secondary mb-3" onclick="checkAll(0)">Uncheck</button>

                                    <button type="button" class="btn btn-flat btn-danger mb-3" onclick="deleteAll('deleteAllMeeting','Delete these Meeting\'s details?','Are you sure you want to delete these Meeting\'s details?');">
                                        Delete</button>

                                    <div class="loading"></div>


                                </div>

                                <div class="col-6 right-control">

                                    <a href="javascript:void(0);" onclick="window.history.back();">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                    </a>


                                    <a href="{{route('meeting.index')}}">

                                    <!-- <a href="{{ url('/console/meeting') }}"> -->
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Refresh</button>
                                    </a>

                                    <a href="{{route('meeting.create')}}">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Add Session</button>
                                    </a>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <form method="post" id="deleteAllMeeting">

                    <div class="data-tables">
                        <table id="meetingTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Seq.</th>
                                    <th style="width:2px;max-width:2px;"></th>
                                    <th>Attend By</th>
                                    <th>Program</th>
                                    <th>Subject</th>
                                    <th>Topic</th>
                                    <th>Teacher</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meeting as $value)

                                <tr id="item{{$value->id}}">
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        <input type="checkbox" class="checkBoxClass" name="deleterecords[]" value="{{$value->id}}">
                                    </td>
                                    <td>@isset($value->username->name)
                                    {{$value->username->name}}
                                    @else
                                    NA
                                    @endif</td>
                                    <td>@isset($value->program->name)
                                    {{$value->program->name}}
                                    @else
                                    NA
                                    @endif</td>
                                    <td>@isset($value->subject->name)
                                    {{$value->subject->name}}
                                    @else
                                    NA
                                    @endif</td>
                                    <td>@isset($value->topic->title)
                                    {{$value->topic->title}}
                                    @else
                                    NA
                                    @endif</td>
                                    <td>@isset($value->teacher->name)
                                    {{$value->teacher->name}}
                                    @else
                                    NA
                                    @endif</td>
                                   <td>@isset($value->date)
                                    {{$value->date}}
                                    @else
                                    NA
                                    @endif</td>
                                    <td>@isset($value->timeSlot->id)
                                {{date('h:i',strtotime($value->timeSlot->fromTime))}}- {{date('h:i',strtotime($value->timeSlot->toTime))}}

                                    @else
                                    NA
                                    @endif</td>
                             
                                    <td>
                
                                        <label class="label-switch switch-success">
                                            <input type="checkbox" class="switch switch-bootstrap status" name="status" data-id="{{$value->id}}" @if($value->status == 1) checked="checked" @endif /> 
                                            <span class="lable"></span>
                                        </label>

                                    </td>
                                    <!-- <td>{{$value->created_at}}</td> -->
                                    <td>
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">

                                        <a class="dropdown-item" href="{{route('meeting.edit', $value->id)}}">Edit</a>
                                        @if($value->scheduleStatus == 1)
                                         <a class="dropdown-item" href="{{ url('/admin/meeting/activate', $value->id) }}">Activate</a>
                                        @endif 

                                            <a class="dropdown-item" onclick="deleteRecord('{{$value->id}}','Delete this Meeting details?','Are you sure you want to delete this Meeting details?');">Delete</a>
                                        </div>
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>

@section('js')
<script src="{{ asset('assets/admin/js/console/meeting.js') }}"></script>
@append

@endsection