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

                                    <!-- <button type="button" class="btn btn-flat btn-secondary mb-3" onclick="checkAll(1)">Check All</button>
                                    <button type="button" class="btn btn-flat btn-secondary mb-3" onclick="checkAll(0)">Uncheck</button>

                                    <button type="button" class="btn btn-flat btn-danger mb-3" onclick="deleteAll('deleteAllApplicationNumber','Delete these Application Number\'s details?','Are you sure you want to delete these Application Number\'s details?');">
                                        Delete</button> -->

                                    <div class="loading"></div>


                                </div>

                                <div class="col-6 right-control">

                                    <a href="javascript:void(0);" onclick="window.history.back();">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                    </a>

                                    <a href="{{ url('/console/application-number') }}">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Refresh</button>
                                    </a>

                                    <!--

                                    <a href="{{ url('/console/application-number/create') }}">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Add Application Number</button>
                                    </a>

                                    -->

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <form method="post" id="deleteAllApplicationNumber">

                    <div class="data-tables">
                        <table id="applicationNumberTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Seq.</th>
                                    <th style="width:2px;max-width:2px;"></th>
                                    <th>Id</th>
                                    <th>Prefix</th>
                                    <th>Start Number</th>
                                    <th>Suffix</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applicationNumber as $value)

                                <tr id="item{{$value->id}}">
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        <input type="checkbox" class="checkBoxClass" name="deleterecords[]" value="{{$value->id}}">
                                    </td>

                                    <td>{{$value->id}} </td>
                                    <td>{{$value->prefix}}</td>
                                    <td>{{$value->startNumber}}</td>
                                    <td>{{$value->suffix}}</td>       
                                    <td>{{$value->type}}</td>
                                    <td>

                                        <label class="label-switch switch-success">
                                            <input type="checkbox" class="switch switch-bootstrap status" name="status" data-id="{{$value->id}}" @if($value->status == 1) checked="checked" @endif />
                                            <span class="lable"></span>
                                        </label>

                                    </td>
                                    <td>{{$value->created_at}}</td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{route('application-number.edit',$value->id)}}">Edit</a>
                                            <!-- <a class="dropdown-item" onclick="deleteRecord('{{$value->id}}','Delete this Application Number details?','Are you sure you want to delete this Application Number details?');">Delete</a> -->
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
<script src="{{ asset('assets/admin/js/console/applicationNumber.js') }}"></script>
@append

@endsection