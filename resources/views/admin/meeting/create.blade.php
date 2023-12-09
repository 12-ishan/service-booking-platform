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
                            action="@if(isset($editStatus)){{ route('meeting.update', $meeting->id) }} @else {{ route('meeting.store')}}@endif"
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


<?php /*?>                            <div class="row">
                                <div class="col-3 mt-5">
                                    <div class="form-group">
                                        <label for="program">Program</label>
                                        <div class="loading"></div>
                                        <select class="form-control selectpicker" id="programId" name="programId"
                                            data-live-search="true">
                                            <option value="">Select Program</option>
                                            @if(isset($program))
                                            @foreach($program as $value)
                                            <option value="{{$value->id}}" @if (old('programId', isset($meeting->
                                                programId) ? $meeting->programId : NULL) == $value->id)
                                                selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-3 mt-5">
                                    <div class="form-group">
                                        <label for="subjectId">Subject</label>
                                        <select class="form-control selectpicker" id="subjectId" name="subjectId" data-live-search="true" @if(!isset($editStatus)) disabled @endif>
                                            <option value="">Select Subject</option>
                                            @if(isset($subject))
                                            @foreach($subject as $value)

                                            <option value="{{$value->id}}" @if (old('subjectId', isset($meeting->subjectId) ? $meeting->subjectId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-3 mt-5">
                                    <div class="form-group">

                                        <label for="topicId">Topic</label>
                                        <select class="form-control selectpicker" id="topicId" name="topicId"
                                            data-live-search="true" @if(!isset($editStatus)) disabled @endif>
                                            <option value="">Select Topic</option>
                                            @if(isset($topic))
                                            @foreach($topic as $value)
                                            <option value="{{$value->id}}" @if (old('topicId', isset($meeting->topicId) ? $meeting->topicId : NULL) == $value->id) selected="selected" @endif>{{$value->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 mt-5">
                                    <div class="form-group">
                                        <label for="tutorId">Tutor Id</label>
                                        <select class="form-control selectpicker" id="tutorId" name="tutorId" data-live-search="true">
                                            <option value="">Select Tutor ID</option>
                                            @if(isset($tutorId))
                                            @foreach($tutorId as $value)
                                            <option value="{{$value->id}}" @if (old('tutorId', isset($meeting->tutorId) ? $meeting->tutorId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div> 

                            <?php */?>
  <?php /*?>
                            <div class="row">
                                <div class="col-3 mt-5">
                                    <div class="form-group">
                                        <label for="sessionRecieverId">Session Reciever ID</label>
                                        <select class="form-control selectpicker" id="sessionRecieverId" name="sessionRecieverId" data-live-search="true">
                                            <option value="">Select Session Reciever ID</option>
                                            @if(isset($sessionRecieverId))
                                            @foreach($sessionRecieverId as $value)
                                            <option value="{{$value->id}}" @if (old('sessionRecieverId', isset($meeting->sessionRecieverId) ? $meeting->sessionRecieverId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 mt-5">
                                    <div class="form-group">
                                        <label for="program">State</label>
                                        <div class="loading"></div>
                                        <select class="form-control selectpicker" id="stateId" name="stateId" data-live-search="true" @if(!isset($editStatus)) @endif>
                                            <option value="">Select State</option>
                                            @if(isset($state))
                                            @foreach($state as $value)
                                            <option value="{{$value->id}}" @if (old('stateId', isset($meeting->stateId) ? $meeting->stateId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 mt-5">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" id="date" name="date" placeholder="Enter Meta Description" value="{{old('date',  isset($meeting->date) ? $meeting->date : NULL)}}">
                                    </div>
                                </div>
                                <div class="col-3 mt-5">
                                    <div class="form-group">
                                        <label for="timeSlotId">Time</label>
                                       <select class="form-control selectpicker" id="timeSlotId" name="timeSlotId" data-live-search="true">
                                            <option value="">Select Time</option>
                                            @if(isset($timeSlot))
                                            @foreach($timeSlot as $value)
                                            <option value="{{$value->id}}" @if (old('timeSlotId', isset($meeting->timeSlotId) ? $meeting->timeSlotId : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div><?php */?>
                          


                            <div class="row">
                           

                                <?php /*?> <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Name"
                                            value="{{old('name',  isset($meeting->name) ? $meeting->name : NULL)}}">
                                    </div>
                                </div> <?php */?>

                           
<!-- 
                                          <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{old('description',  isset($meeting->description) ? $meeting->description : NULL)}}">
                                    </div>
                                </div> -->

                                <div class="col-6 mt-5">
                                    <div class="form-group">

                                        <label for="practiceSetQuestionId">Practice Question Set</label>
                                        <select class="form-control selectpicker" id="practiceSetQuestionId"
                                            name="practiceSetQuestionId" data-live-search="true">
                                            <option value="">Select Question Set</option>
                                            @if(isset($questionCategory))
                                            @foreach($questionCategory as $value)
                                            <option value="{{$value->id}}" @if (old('id', isset($meeting->
                                                practiceSetQuestionId) ? $meeting->practiceSetQuestionId : NULL) ==
                                                $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>


                                    </div>
                                </div>

                            </div>
 <?php /*?>
                            <div class="row">


                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Thumbnail</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>


                                @if(isset($meeting->image->name))
                                <div class="col-6 mt-6">
                                    <label for="name">View Image</label>
                                    <div class="upload-image">
                                        <img width="100" height="60"
                                            src=" {{ URL::to('/') }}/uploads/meeting/{{ $meeting->image->name }}"
                                            alt="image">
                                    </div>
                                </div>
                                @endif

                            </div>
<?php */?>
                        <div class="row">
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">PDF Upload</label>
                                        <input type="file" name="pdf" class="form-control">
                                    </div>
                                </div>
                                @if(isset($meeting->pdf->name))
                                <div class="col-6 mt-6">
                                     <label for="name">View PDF</label>
                                    <div class="upload-image">
                                        <embed src="{{ URL::to('/') }}/uploads/meeting/{{ $meeting->pdf->name }}" style="width:200px; height:200px;" frameborder="0" >
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-12 mt-6">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description"
                                            placeholder="Enter Description">{{old('description', isset($meeting->description) ? $meeting->description : NULL)}}</textarea>
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
                                    @if(isset($meeting->id))
                                    <input type="hidden" name="id" value="{{ $meeting->id }}">
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

// $(document).ready(function(){

//     $("#meetingForm").submit(function(){

//         if($("#programId").val()=="")
//         {
//             $("#err").text("Please select program");
//             $("#programId").focus();
//             return false;
//         }
//         if($("#subjectId").val()=="")
//         {
//             $("#err").text("Please select subject");
//             $("#subjectId").focus();
//             return false;
//         }
//         if($("#topicId").val()=="")
//         {
//             $("#err").text("Please select topic");
//             $("#topicId").focus();
//             return false;
//         }
//         if($("#sessionRecieverId").val()=="")
//         {
//             $("#err").text("Please enter your session reciever");
//             $("#sessionRecieverId").focus();
//             return false;
//         }
//         if($("#state").val()=="")
//         {
//             $("#err").text("Please enter your state");
//             $("#state").focus();
//             return false;
//         }
//         if($("#date").val()=="")
//         {
//             $("#err").text("Please enter date");
//             $("#date").focus();
//             return false;
//         }
//         if($("#timeSlotId").val()=="")
//         {
//             $("#err").text("Please enter time slot");
//             $("#timeSlotId").focus();
//             return false;
//         }
//         if($("#name").val()=="")
//         {
//             $("#err").text("Please enter name");
//             $("#name").focus();
//             return false;
//         }
//         if($("#practiceSetQuestionId").val()=="")
//         {
//             $("#err").text("Please enter practice set question");
//             $("#practiceSetQuestionId").focus();
//             return false;
//         }
//         });
//     });
</script>
@section('js')
<script src="{{ asset('assets/admin/js/console/meeting.js') }}"></script>
@append

@endsection