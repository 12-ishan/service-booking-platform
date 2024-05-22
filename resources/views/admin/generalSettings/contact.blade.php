@extends('layout.admin')
@section('content')

<div class="row">
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12 mt-5 start-form-sec">
                <div class="card">
                    <div class="card-body">
                        <form id="GeneralSettingsForm" method="POST" action="{{ route('updateContact') }}">
                            {{ csrf_field() }}
                            @if(isset($generalSettings))
                                @method('PUT')
                            @endif

                            @if(session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach

                            <div class="row">
                                {{-- <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input ocation="text" class="form-control" id="type" name="type" placeholder="Enter type" value="{{ old('type', $generalSettings->type ?? '') }}">
                                    </div>
                                </div> --}}
                           
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input ocation="text" class="form-control" id="phone" name="phone" placeholder="Enter phone" value="{{ old('phone', $generalSettings->phone ?? '') }}">
                                    </div>
                                </div>
                            

                           
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input ocation="text" class="form-control" id="email" name="email" placeholder="Enter eamil" value="{{ old('email', $generalSettings->email ?? '') }}">
                                    </div>
                                </div>
                           

                           
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input ocation="text" class="form-control" id="location" name="location" placeholder="Enter location" value="{{ old('location', $generalSettings->location ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            @if(isset($generalSettings->id))
                            <input type="hidden" name="id" value="{{ $generalSettings->id }}">
                            @endif
                           
                            {{-- <button ocation="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
                            @if(isset($generalSettings))
                            <button ocation="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update</button>
                        @endif --}}

                        <button ocation="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{ isset($generalSettings) ? 'Update' : 'Submit' }}</button>
                           
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
