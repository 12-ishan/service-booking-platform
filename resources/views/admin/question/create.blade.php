@extends('layout.admin')
@section('content')

<style>
.form-check {
    padding-top: 2.5em;
}

.remove-buttons {
    padding-top: 30px;
}
</style>

<div class="row">


    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <!-- basic form start -->

            <div class="col-12 mt-5 start-form-sec">

                <div class="card">
                    <div class="card-body">

                        <p id="err" style="color:red;"></p>

                        <form id="questionForm" method="post"
                            action="@if(isset($editStatus)){{ route('question.update', $question->id) }} @else {{ route('question.store')}}@endif"
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

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <textarea class="form-control" id="question" name="question"
                                            placeholder="Enter Question">{{old('question', isset($question->question) ? $question->question : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>


                            <div class="row">

                                <div class="col-4 mt-5">

                                    <div class="form-group">

                                        <label for="roleId">Category</label>
                                        <select class="form-control selectpicker" id="questionCategoryId"
                                            name="questionCategoryId" data-live-search="true">
                                            <option value="">Select Category</option>
                                            @if(isset($questionCategory))
                                            @foreach($questionCategory as $value)
                                            <!-- <option value="{{$value->id}}">{{$value->name}}</option> -->

                                            <option value="{{$value->id}}" @if (old('questionCategoryId',
                                                isset($question->questionCategoryId) ? $question->questionCategoryId :
                                                NULL) == $value->id) selected="selected" @endif>{{$value->name}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>

                                </div>


                                <div class="col-4 mt-5">
                                    <div class="form-group">
                                        <label for="question">Marks</label>
                                        <input type="number" class="form-control" min="0" id="marks" name="marks"
                                            placeholder="Enter marks"
                                            value="{{old('marks',  isset($question->marks) ? $question->marks : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-4 mt-5">

                                    <div class="form-group">

                                        <label for="roleId">Type</label>
                                        <select class="form-control selectpicker" id="type" name="type"
                                            data-live-search="false">
                                            <!-- <option value="">Select Type</option> -->
                                            <option value="1" @if (old('type', isset($question->type) ? $question->type
                                                : NULL) == 1) selected="selected" @endif>Objective</option>

                                        </select>

                                    </div>

                                </div>


                            </div>

                            <div class="row">

                                <div class="col-12 mt-6">
                                    <div class="form-group">
                                        <label for="name">Thumbnail</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                @if(isset($question->image->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60"
                                            src=" {{ URL::to('/') }}/uploads/question/{{ $question->image->name }}"
                                            alt="image">
                                    </div>
                                </div>
                                @endif

                            </div>


                            <div class="card-body">

                            <p id="errmsg" style="color:red;"></p>



                                <div class="row">

                                    <div class="col-3 mt-5">

                                        <h3>Manage Options</h3>

                                    </div>

                                    <div class="col-5 mt-5">

                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="add_button" title="Add field">
                                                <img src="{{ asset('assets/admin/images/customicon/add-icon.png')}}" /></a>
                                        </div>

                                    </div>
                                </div>

                                <div class="section-content-fields" id="checkArray">


                                    @if(isset($questionOption))
                                    @foreach($questionOption as $value)


                                    <div class="row">

                                        <div class="col-8 mt-5">
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" class="form-control option" id="option" name="option[]"
                                                    placeholder="Enter Option" value="{{$value->option}}" />
                                            </div>
                                        </div>


                                        <div class="col-2 mt-5">
                                            <div class="form-check">

                                                <input type="checkbox" class="form-check-input"
                                                    onclick="selectOnlyThis(this.id)" name="isCorrect[]" value="1"
                                                    @if($value->isCorrect == 1 ) checked
                                                @endif
                                                />
                                                <label class="form-check-label">Mark it correct</label>

                                                <input type="hidden" name="isCorrect[]" value="0">
                                                <input type="hidden" name="questionOptionId[]"
                                                    value="{{old('questionOptionId',  isset($value->id) ? $value->id : NULL)}}" />
                                            </div>
                                        </div>

                                        <div class="col-2 mt-5 remove-buttons" align="left">
                                            <div class="form-group">
                                                <a href="javascript:void(0);" class="remove_button"><img
                                                        src='{{ asset("assets/admin/images/customicon/remove-icon.png")}}' /></a>
                                            </div>
                                        </div>

                                    </div>
                                    @endforeach
                                    @endif

                                </div>


                                <?php                    
                            if(isset($editStatus)){
                                $counter = count($questionOption);
                            }else{
                                $counter = 0;
                            }                           
                            ?>



                                <input type="hidden" id="counter" value="<?php echo $counter; ?>">
                                @if(isset($question->id))
                                <input type="hidden" name="id" value="{{ $question->id }}">
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
    var maxField = 4;
    var fieldHTML =
        '<div class="row"><div class="col-8 mt-5"><div class="form-group">  <label for="name">Title</label> <input type="text" class="form-control option" name="option[]"  placeholder="Enter Option" /></div></div><div class="col-2 mt-5"><div class="form-check">   <input type="checkbox" class="form-check-input" onclick="selectOnlyThis(this.id)" name="isCorrect[]" value="1" /> <label class="form-check-label">Mark it correct</label>   <input type="hidden" name="isCorrect[]" value="0">  <input type="hidden" name="questionOptionId[]"  /> </div></div><div class="col-2 mt-5 remove-buttons" align="left"><div class="form-group"><a href="javascript:void(0);" class="remove_button"><img src="{{ asset("assets/admin/images/customicon/remove-icon.png")}}" /></a></div></div></div>'; //New input field html 

    var x = 1; //Initial field counter is 1

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

$(document).on('click', 'input[type="checkbox"]', function() {   
$("#checkArray input[type=checkbox]:checked").not(this).prop('checked', false);  
 });




$(document).ready(function(){

    $("#questionForm").submit(function(){

        if($("#question").val()=="")
        {
            $("#err").text("Please enter question");
            $("#question").focus();
            return false;
        }

        if($("#questionCategoryId").val()=="")
        {
            $("#err").text("Please selet category");
            $("#questionCategoryId").focus();
            return false;
        }

        var checked = $("#checkArray input[type=checkbox]:checked").length;
        if (checked > 0) {
            return true;
        } else {
            $("#errmsg").text("Please select atleast one option with correct answer");
            return false;
        }
        });
    });
 
</script>
@section('js')
<script src="{{ asset('assets/admin/js/console/question.js') }}"></script>
@append

@endsection