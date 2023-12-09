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

                        <form id="subscriptionMemberForm" method="post" action="@if(isset($editStatus)){{ route('subscription-member.update', $subscriptionMember->id) }} @else {{ route('subscription-member.store')}}@endif" enctype='multipart/form-data'>

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
                                    <div class="form-group">
                                        <label for="userId">User</label>
                                        <select class="form-control selectpicker" id="userId" name="userId" data-live-search="true">
                                            <option value="">Select User</option>
                                            @if(isset($role))
                                            @foreach($role as $value)
                                            <option value="{{$value->id}}" @if (old('roleId', isset($user->userId) ? $user->userId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                    <div class="form-group">
                                        <label for="subscriptionId">Subscription</label>
                                        <select class="form-control selectpicker" id="subscriptionId" name="subscriptionId" data-live-search="true">
                                            <option value="">Select subscription</option>
                                            @if(isset($subscriptionId))
                                            @foreach($subscriptionId as $value)
                                            <option value="{{$value->id}}" @if (old('id', isset($subscription->subscriptionId) ? $subscription->subscriptionId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                </div>


                            </div>
                            @if(isset($subscriptionMember->id))
                            <input type="hidden" name="id" value="{{ $subscriptionMember->id }}">
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
<script src="{{ asset('assets/admin/js/console/subscriptionMember.js') }}"></script>
@append

@endsection