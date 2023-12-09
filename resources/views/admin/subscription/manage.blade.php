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

                                    <button type="button" class="btn btn-flat btn-danger mb-3" onclick="deleteAll('deleteAllSubscription','Delete these Subscription\'s details?','Are you sure you want to delete these Subscription\'s details?');">
                                        Delete</button>

                                    <div class="loading"></div>


                                </div>

                                <div class="col-6 right-control">

                                    <a href="javascript:void(0);" onclick="window.history.back();">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                    </a>


                                    <a href="{{route('subscription.index')}}">

                                    <!-- <a href="{{ url('/console/subscription') }}"> -->
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Refresh</button>
                                    </a>

                                    <a href="{{route('subscription.create')}}">
                                    <!-- <a href="{{ url('/console/bannner/create') }}"> -->
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Add Subscription</button>
                                    </a>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <form method="post" id="deleteAllSubscription">

                    <div class="data-tables">
                        <table id="subscriptionTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                      <tr>
                                    <th width="5%">Seq.</th>
                                    <th style="width:2px;max-width:2px;"></th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Days</th>
                                    <th>No Of Subjects</th>
                                    <th>No Of Classes</th>
                                    <th>Amount</th>
                                     <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscription as $value)

                                <tr id="item{{$value->id}}">
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        <input type="checkbox" class="checkBoxClass" name="deleterecords[]" value="{{$value->id}}">
                                    </td>

                                    <td>{{$value->id}} </td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->days}}</td>
                                    <td>{{$value->noOfSubjects}}</td>
                                    <td>{{$value->noOfClasses}}</td>
                                     <td>{{$value->amount}}</td>
                             
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
                                            <a class="dropdown-item" href="{{route('subscription.edit', $value->id)}}">Edit</a>
                                            <a class="dropdown-item" onclick="deleteRecord('{{$value->id}}','Delete this Subscription details?','Are you sure you want to delete this Subscription details?');">Delete</a>
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
<script src="{{ asset('assets/admin/js/console/subscription.js') }}"></script>
@append

@endsection