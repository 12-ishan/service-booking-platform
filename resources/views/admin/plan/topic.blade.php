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

                        <form id="planForm" method="post"
                            action="@if(isset($editStatus)){{ route('plan.update', $topic->id) }} @else {{ route('plan.store')}}@endif"
                            enctype='multipart/form-data'>

                            {{ csrf_field() }}

                            @if(isset($editStatus))
                            @method('PUT')
                            @endif


                            @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                            @endif


                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach

                            <div class="row">

                                <div class="col-4 mt-5">
                                    <div class="form-group">
                                        <label for="topic">Topic</label>
                                        <div class="loading"></div>
                                        <select class="form-control selectpicker" id="topicId" name="topicId"
                                            data-live-search="true">
                                            <option value="">Select Topic</option>
                                            @if(isset($topic))
                                            @foreach($topic as $value)
                                            <option value="{{$value->id}}" @if (old('topicId', isset($topic->
                                                topicId) ? $topic->topicId : NULL) == $value->id)
                                                selected="selected" @endif>{{$value->title}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-4 mt-5">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <div class="loading"></div>
                                        <select class="form-control selectpicker" id="quantity" name="quantity">
                                            <option value="">Select Quantity</option>

                                            <option value="1" @if (old('quantity', isset($topic->
                                                quantity) ? $topic->quantity : NULL) == 1)
                                                selected="selected" @endif>1</option>

                                            <option value="2" @if (old('quantity', isset($topic->
                                                quantity) ? $topic->quantity : NULL) == 2)
                                                selected="selected" @endif>2</option>

                                            <option value="3" @if (old('quantity', isset($topic->
                                                quantity) ? $topic->quantity : NULL) == 3)
                                                selected="selected" @endif>3</option>

                                            <option value="4" @if (old('quantity', isset($topic->
                                                quantity) ? $topic->quantity : NULL) == 4)
                                                selected="selected" @endif>4</option>

                                            <option value="5" @if (old('quantity', isset($topic->
                                                quantity) ? $topic->quantity : NULL) == 5)
                                                selected="selected" @endif>5</option>


                                        </select>
                                    </div>
                                </div>


                                <div class="col-4 mt-5">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount"
                                            placeholder="Enter amount"
                                            value="{{old('amount',  isset($topic->amount) ? $topic->amout : NULL)}}">
                                    </div>
                                </div>




                            </div>

                            @if(isset($topic->id))
                            <input type="hidden" name="id" value="{{ $topic->id }}">
                            @endif
                            <input type="hidden" name="programId" value="{{ $programId }}">
                            <input type="hidden" name="subjectId" value="{{ $subjectId}}">

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
                        </form>
                    </div>






                </div>
            </div>
            <!-- basic form end -->
        </div>



        <div class="row">


            <div class="col-12 mt-5 start-form-sec">

                <div class="card">
                    <div class="card-body">

                        <!-- <h4 class="header-title">Basic form</h4> -->
                        <p id="err" style="color:red;"></p>

                        <div class="data-tables">
                            <table id="planTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="5%">Seq.</th>
                                        <!-- <th style="width:2px;max-width:2px;"></th> -->
                                        <th>Topic</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
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

                                        <td>@isset($value->title){{$value->title}}@else NA @endif</td>
                                        <td>@isset($value->quantity){{$value->quantity}}@else NA @endif</td>
                                        <td>@isset($value->amount){{$value->amount}}@else NA @endif</td>
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


                                            <form id="planDeleteForm" method="post"
                                                action="{{route('plan.delete', $value->id) }}">

                                                {{ csrf_field() }}

                                                <input type="hidden" name="programId" value="{{ $programId }}">
                            <input type="hidden" name="subjectId" value="{{ $subjectId}}">


                                                <button class="btn btn-secondary btn-sm " type="submit">
                                                    Delete
                                                </button>


                                            </form>

                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>






                </div>
            </div>
            <!-- basic form end -->
        </div>
    </div>
</div>

@section('js')
<script src="{{ asset('assets/admin/js/console/plan.js') }}"></script>
@append

<script type="text/javascript">
$(document).ready(function() {

            $("#planForm").submit(function(){

                if($("#topicId").val()=="")
                {
                    $("#err").text("Please select topic");
                    $("#topicId").focus();
                    return false;
                }
                if($("#quantity").val()=="")
                {
                    $("#err").text("Please select quantity");
                    $("#quantity").focus();
                    return false;
                }
                if($("#amount").val()=="")
                {
                    $("#err").text("Please enter amount");
                    $("#amount").focus();
                    return false;
                }
                if($("#bannerSloganText").val()=="")
                {
                    $("#err").text("Please enter your bannerSloganText");
                    $("#bannerSloganText").focus();
                    return false;
                }
                });
            });
</script>

@endsection