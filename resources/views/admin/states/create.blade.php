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

                        <form id="statesForm" method="post" action="@if(isset($editStatus)){{ route('state.update', $states->id) }} @else {{ route('state.store')}}@endif" enctype='multipart/form-data'>

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

                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <label for="name">State Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter State Name" value="{{old('name',  isset($states->name) ? $states->name : NULL)}}">
                                    </div>
                                </div>
                            </div>

                            @if(isset($states->id))
                            <input type="hidden" name="id" value="{{ $states->id }}">
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
<script src="{{ asset('assets/admin/js/console/states.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#statesForm").submit(function(){

        if($("#name").val()=="")
        {
            $("#err").text("Please enter state name");
            $("#name").focus();
            return false;
        }
        });
    });
 
</script>
@endsection