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

                        <form id="subscriptionfrm" method="post" action="@if(isset($editStatus)){{ route('subscription.update', $subscription->id) }} @else {{ route('subscription.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name',  isset($subscription->name) ? $subscription->name : NULL)}}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="days">Days</label>
                                        <input type="text" class="form-control" id="days" name="days" placeholder="Enter Days" value="{{old('days',  isset($subscription->days) ? $subscription->days : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="noOfSubjects">No of Subjects</label>
                                        <input type="number" class="form-control" id="noOfSubjects" name="noOfSubjects" placeholder="Enter no of subjects" value="{{old('noOfSubjects',  isset($subscription->noOfSubjects) ? $subscription->noOfSubjects : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="noOfClasses">No of Classes</label>
                                        <input type="number" class="form-control" id="noOfClasses" name="noOfClasses" placeholder="Enter no of classes" value="{{old('noOfClasses',  isset($subscription->noOfClasses) ? $subscription->noOfClasses : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" value="{{old('amount',  isset($subscription->amount) ? $subscription->amount : NULL)}}">
                                    </div>
                                </div>

                            </div>


                            @if(isset($subscription->id))
                            <input type="hidden" name="id" value="{{ $subscription->id }}">
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
<script src="{{ asset('assets/admin/js/console/subscription.js') }}"></script>

<script type="text/javascript">

$(document).ready(function(){

    $("#subscriptionfrm").submit(function(){

        if($("#name").val()=="")
        {
            $("#err").text("Please enter your name");
            $("#name").focus();
            return false;
        }

        if($("#days").val()=="")
        {
            $("#err").text("Please enter days");
            $("#days").focus();
            return false;
        }

        if(($("#days").val() <= 0) || ($("#days").val() > 365))
        {
            $("#err").text("Please enter days between 1 to 365");
            $("#days").focus();
            return false;
        }

        if($("#amount").val()=="")
        {
            $("#err").text("Please enter amount");
            $("#amount").focus();
            return false;
        }



        // if($("#email").val()=="")
        // {
        //     $("#err").text("Please enter your email");
        //     $("#email").focus();
        //     return false;
        // }
        // if(!$("#email").val().match("^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$"))
        // {
        //     $("#err").text("Please enter your valid email");
        //     $("#email").focus();
        //     return false;
        // }
        // if($("#contact_number").val()=="")
        // {
        //     $("#err").text("Please enter your phone no.");
        //     $("#contact_number").focus();
        //     return false;
        // }
        
        // if(!$("#contact_number").val().match("^[ ()-_+0-9]+$"))
        // {
        //     $("#err").text("Please enter your valid phone no.");
        //     $("#contact_number").focus();
        //     return false;
        // }
        
        // if($("#address").val()=="")
        // {
        //     $("#err").text("Please enter your address");
        //     $("#address").focus();
        //     return false;
        // }

        
        // if($("#position_of_interest").val()=="")
        // {
        //     $("#err").text("Please select preferred position");
        //     $("#position_of_interest").focus();
        //     return false;
        // }
        
        // if($("#here_about_us").val()=="")
        // {
        //     $("#err").text("Please select how did you hear about event");
        //     $("#here_about_us").focus();
        //     return false;
        // }

        // if($("#date").val()=="")
        // {
        //     $("#err").text("Please select preferred date/time");
        //     $("#date").focus();
        //     return false;
        // }

        // if($("#resume").val()=="")
        // {
        //     $("#err").text("Please upload your resume");
        //     $("#resume").focus();
        //     return false;
        // }

        // if($("#resume").val()!="")
        // {
        //     var ext = $('#resume').val().split('.').pop().toLowerCase();
        //     if($.inArray(ext, ['doc','pdf','rtf','docx','txt']) == -1) 
        //     {
        //     $("#err").text("Resume must be in doc, rtf, docx, pdf, txt format");
        //     $("#resume").focus();
        //     return false;
        //     }
        //     if($("#resume")[0].files[0].size > 513000)
        //     {
        //     $("#err").text("Resume size must be less then 500KB");
        //     $("#resume").focus();
        //     return false;
        //     }
            
        // }

        });
    });
 
</script>

@append

@endsection