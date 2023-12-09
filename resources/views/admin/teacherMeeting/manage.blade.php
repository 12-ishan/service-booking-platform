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
                                <div class="loading"></div>
                                </div>
                                <div class="col-6 right-control">
                                    <a href="javascript:void(0);" onclick="window.history.back();">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                    </a>
                                    <a href="{{route('teacher-meeting.index')}}">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Refresh</button>
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
                                    <th>Attend By</th>
                                    <th>Program</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meeting as $value)
                                <tr id="item{{$value->id}}">
                                    <td> {{$loop->iteration}} </td>
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
                                    <td>@isset($value->teacher->name)
                                    {{$value->teacher->name}}
                                    @else
                                    NA
                                    @endif</td>
                                    <td>{{$value->date}}</td>
                                    <td>@isset($value->timeSlot->name)
                                    {{$value->timeSlot->name}}
                                    @else
                                    NA
                                    @endif</td>
                               <td>
                               <a class="btn btn-success btn-sm" href="{{ url('/admin/teacher-meeting/activate', $value->id) }}">Update</a>
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
<script src="{{ asset('assets/admin/js/console/teacherMeeting.js') }}"></script>
@append

@endsection