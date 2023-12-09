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
                        <form id="meetingForm" method="post"
                            action="@if(isset($editStatus)){{ route('teacher-meeting.update', $teacherMeeting->id) }} @else {{ route('teacher-meeting.store')}}@endif"
                            enctype='multipart/form-data'>

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
                                        <label for="practiceSetQuestionId">Practice Question Set</label>
                                        <select class="form-control selectpicker" id="practiceSetQuestionId"
                                            name="practiceSetQuestionId" data-live-search="true">
                                            <option value="">Select Question Set</option>
                                            @if(isset($questionCategory))
                                            @foreach($questionCategory as $value)
                                            <option value="{{$value->id}}" @if (old('id', isset($teacherMeeting->
                                                practiceSetQuestionId) ? $teacherMeeting->practiceSetQuestionId : NULL) ==
                                                $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Thumbnail</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                 <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="pdf">PDF</label>
                                        <input type="file" name="pdf" class="form-control">
                                    </div>
                                </div>

                                @if(isset($teacherMeeting->image->name))
                                <div class="col-6 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60"
                                            src=" {{ URL::to('/') }}/uploads/meeting/{{ $teacherMeeting->image->name }}"
                                            alt="image">
                                    </div>
                                </div>
                                @endif

                            </div>
                            <div class="row">
                                <div class="col-12 mt-6">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description"
                                            placeholder="Enter Description">{{old('description', isset($teacherMeeting->description) ? $teacherMeeting->description : NULL)}}</textarea>
                                    </div>

                                </div>

                            </div>



                            <div class="card-body">

                                <div class="row">

                                    <div class="col-3 mt-5">

                                        <h3>Session Content</h3>

                                    </div>

                                    <div class="col-5 mt-5">

                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="add_button" title="Add field">
                                                <img src="{{ asset('steve/img/add-icon.png')}}" /></a>
                                        </div>

                                    </div>
                                </div>

                                <div class="section-content-fields">

                                    @if(isset($sessionContent))
                                    @foreach($sessionContent as $data)

                                    <div class="row">

                                        <div class="col-10 mt-5">
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" class="form-control" placeholder="Title"
                                                    name="title[]"
                                                    value="{{old('title',  isset($data->title) ? $data->title : NULL)}}" required/>
                                            </div>
                                        </div>

                                        <div class="col-2 mt-5" align="right">
                                            <div class="form-group">
                                                <a href="javascript:void(0);" class="remove_button"><img
                                                        src='{{ asset("steve/img/remove-icon.png")}}' /></a>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <div class="form-group">
                                                <label for="name">Description</label>
                                                <textarea class="form-control" name="descriptions[]"
                                                    placeholder="Enter Description" required>{{old('description',  isset($data->description) ? $data->description : NULL)}}</textarea>
                                                <input type="hidden" name="sessionContentId[]"
                                                    value="{{old('sessionContentId',  isset($data->id) ? $data->id : NULL)}}" />
                                            </div>
                                        </div>

                                    </div>

                                    @endforeach
                                    @endif


                                    <!-- <div class="row">

                                        <div class="col-10 mt-5">
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" class="form-control" placeholder="Title"
                                                    name="title[]" required/>
                                            </div>
                                        </div>

                                        <div class="col-2 mt-5" align="right">
                                            <div class="form-group">
                                                <a href="javascript:void(0);" class="remove_button"><img
                                                        src='{{ asset("steve/img/remove-icon.png")}}' /></a>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <div class="form-group">
                                                <label for="name">Description</label>
                                                <textarea class="form-control" name="descriptions[]"
                                                    placeholder="Enter Description" required></textarea>
                                            </div>
                                        </div>

                                    </div> -->

                                </div>


                                <?php                    
                                if(isset($editStatus)){
                                    $counter = count($sessionContent);
                                }else{
                                    $counter = 0;
                                }                           
                                ?>

                                <input type="hidden" id="counter" value="<?php echo $counter; ?>">
                                    @if(isset($teacherMeeting->id))
                                    <input type="hidden" name="id" value="{{ $teacherMeeting->id }}">
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


<script type="text/javascript">
$(document).ready(function() {
    var maxField = 5; //Input fields increment limitation

    var fieldHTML =
        '<div class="row"><div class="col-10 mt-5"> <div class="form-group">  <label for="name">Title</label> <input type="text" class="form-control" placeholder="Title" name="title[]" required/>  </div>  </div>  <div class="col-2 mt-5" align="right"><div class="form-group">  <a href="javascript:void(0);" class="remove_button"><img src="{{ asset("steve/img/remove-icon.png")}}" /></a>   </div>  </div>  <div class="col-12 mt-5"><div class="form-group">  <label for="name">Description</label>  <textarea class="form-control" name="descriptions[]" placeholder="Enter Description" required></textarea> </div>  </div></div>';

   

    //Once add button is clicked
    $('.add_button').click(function() {

        var counter = $('#counter').val();

        //Check maximum number of input fields
        if (counter < maxField) {
            //Increment field counter
            $('#counter').val(function(i, oldval) {
                return parseInt(oldval, 10) + 1;
            });
            $(".section-content-fields").append(fieldHTML); //Add field html
            console.log($('#counter').val());
        }
    });

    //Once remove button is clicked
    $('.section-content-fields').on('click', '.remove_button', function(e) {

        e.preventDefault();
        $(this).closest('.row').remove();

        //Decrement field counter
        $('#counter').val(function(i, oldval) {
            return parseInt(oldval, 10) - 1;
        });
        console.log($('#counter').val());
    });
});

$(document).ready(function(){

    $("#meetingForm").submit(function(){

        if($("#programId").val()=="")
        {
            $("#err").text("Please enter your program name");
            $("#programId").focus();
            return false;
        }
        if($("#subjectId").val()=="")
        {
            $("#err").text("Please enter your subject");
            $("#subjectId").focus();
            return false;
        }
        if($("#topicId").val()=="")
        {
            $("#err").text("Please enter your topic");
            $("#topicId").focus();
            return false;
        }
        if($("#tutorId").val()=="")
        {
            $("#err").text("Please enter your tutor");
            $("#tutorId").focus();
            return false;
        }
        if($("#sessionRecieverId").val()=="")
        {
            $("#err").text("Please enter your session reciever");
            $("#sessionRecieverId").focus();
            return false;
        }
        if($("#state").val()=="")
        {
            $("#err").text("Please enter your state");
            $("#state").focus();
            return false;
        }
        if($("#date").val()=="")
        {
            $("#err").text("Please enter date");
            $("#date").focus();
            return false;
        }
        if($("#timeSlotId").val()=="")
        {
            $("#err").text("Please enter time slot");
            $("#timeSlotId").focus();
            return false;
        }
        if($("#name").val()=="")
        {
            $("#err").text("Please enter name");
            $("#name").focus();
            return false;
        }
        if($("#practiceSetQuestionId").val()=="")
        {
            $("#err").text("Please enter practice set question");
            $("#practiceSetQuestionId").focus();
            return false;
        }
        });
    });
</script>
@section('js')
<script src="{{ asset('assets/admin/js/console/meeting.js') }}"></script>
@append

@endsection