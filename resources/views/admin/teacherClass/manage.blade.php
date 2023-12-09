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

                                    <button type="button" class="btn btn-flat btn-danger mb-3" onclick="deleteAll('deleteAllTeacherClass','Delete these Class Teacher\'s details?','Are you sure you want to delete these Class Teacher\'s details?');">
                                        Delete</button>

                                    <div class="loading"></div>


                                </div>

                                <div class="col-6 right-control">

                                    <a href="javascript:void(0);" onclick="window.history.back();">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                    </a>


                                    <a href="{{route('teacher-class.index')}}">

                                    <!-- <a href="{{ url('/console/teacher-class') }}"> -->
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Refresh</button>
                                    </a>

                                    <a href="{{route('teacher-class.create')}}">
                                    <!-- <a href="{{ url('/console/teacher-class/create') }}"> -->
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Assign Class Teacher</button>
                                    </a>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <form method="post" id="deleteAllTeacherClass">

                    <div class="data-tables">
                        <table id="teacherClassTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Seq.</th>
                                    <th style="width:2px;max-width:2px;"></th>
                                    <th>Program</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teacherClass as $value)

                                <tr id="item{{$value->id}}">
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        <input type="checkbox" class="checkBoxClass" name="deleterecords[]" value="{{$value->id}}">
                                    </td>

                                    <td>
                                    
                                    @if(isset($value->program->name))
                                    {{$value->program->name}} 
                                    @else
                                    NA
                                    @endif
                                    
                                    </td>
                                    <td>
                                    
                                    @if(isset($value->subject->name))
                                    {{$value->subject->name}} 
                                    @else
                                    NA
                                    @endif
                                    
                                    </td>
                                    <td>
                                    
                                    @if(isset($value->teacher->name))
                                    {{$value->teacher->name}} 
                                    @else
                                    NA
                                    @endif
                                    
                                    
                                    </td>
                             
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
                                            <a class="dropdown-item" href="{{route('teacher-class.edit', $value->id)}}">Edit</a>
                                            <a class="dropdown-item" onclick="deleteRecord('{{$value->id}}','Delete this Class Teacher details?','Are you sure you want to delete this Class Teacher details?');">Delete</a>
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
<script src="{{ asset('assets/admin/js/console/teacherClass.js') }}"></script>
@append

@endsection