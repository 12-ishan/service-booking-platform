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
                                <!-- <div class="col-6 left-control">

                                    <button type="button" class="btn btn-flat btn-secondary mb-3" onclick="checkAll(1)">Check All</button>
                                    <button type="button" class="btn btn-flat btn-secondary mb-3" onclick="checkAll(0)">Uncheck</button>

                                    <button type="button" class="btn btn-flat btn-danger mb-3" onclick="deleteAll('deleteAllPlan','Delete these Plan\'s details?','Are you sure you want to delete these Plan\'s details?');">
                                        Delete</button>

                                    <div class="loading"></div>


                                </div> -->

                                <!-- <div class="col-6 right-control">

                                    <a href="javascript:void(0);" onclick="window.history.back();">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                    </a>


                                    <a href="{{route('plan.index')}}">

                                    <a href="{{ url('/console/plan') }}"> -->
                                <!-- <button type="button" class="btn btn-flat btn-secondary mb-3">Refresh</button> 
                                    </a>
 <a href="{{route('plan.create')}}"> 
                                     <a href="{{ url('/console/bannner/create') }}"> 
                                         <button type="button" class="btn btn-flat btn-secondary mb-3">Add Plan</button> 
                                  </a> 

                                </div> -->

                            </div>

                        </div>
                    </div>
                </div>

                <form method="post" id="deleteAllPlan">

                    <div class="data-tables">
                    <table id="planTable" class="text-center">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th width="5%">Seq.</th>
                                <!-- <th style="width:2px;max-width:2px;"></th> -->
                                <th>Program</th>
                                <th>Subject</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plan as $value)

                            <tr id="item{{$value->id}}">
                                <td> {{$loop->iteration}} </td>
                                <!-- <td>
                                    <input type="checkbox" class="checkBoxClass" name="deleterecords[]"
                                        value="{{$value->id}}">
                                </td> -->

                                <td>@isset($value->programName){{$value->programName}}@else NA @endif </td>
                                <td>@isset($value->subjectName){{$value->subjectName}}@else NA @endif</td>
                                <!-- <td>{{$value->planText}}</td>
                                <td>{{$value->planSlogan}}</td> -->

                                <!-- <td>

                                    <label class="label-switch switch-success">
                                        <input type="checkbox" class="switch switch-bootstrap status" name="status"
                                            data-id="{{$value->id}}" @if($value->status == 1) checked="checked" @endif
                                        />
                                        <span class="lable"></span>
                                    </label>

                                </td> -->
                                <!-- <td>{{$value->created_at}}</td> -->
                                <td>

                                <a href="{{route('plan.topic',['programId' => $value->programId, 'subjectId' => $value->subjectId])}}" >

                                <button class="btn btn-secondary btn-sm " type="button" >
                                            Manage plan by topic
                                </button>

                                </a>

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
<script src="{{ asset('assets/admin/js/console/plan.js') }}"></script>
@append

@endsection