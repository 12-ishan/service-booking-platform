@extends('layout.admin')
@section('content')
             <div class="card mt-5">
                    <div class="card-body">
                        <!-- <h4 class="header-title">Todays Order List</h4> -->
                        <div class="icons-wrapper">
                            <div class="row">
                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)
                                <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/program') }}" title="Program"><img src="{{ asset('assets/admin/images/icon/state.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                            @endif
                            @endif

                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)
                                    <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/subject') }}" title="Subject"><img src="{{ asset('assets/admin/images/icon/books-stack.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                            @endif
                            @endif

                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)
                                    <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/topic') }}" title="Topic"><img src="{{ asset('assets/admin/images/icon/category.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                            @endif
                            @endif

                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)
                                    <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/time-slot') }}" title="Time Slot"><img src="{{ asset('assets/admin/images/icon/clock.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                            @endif
                            @endif

                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)
                                <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/teacher-class') }}" title="Class Teacher"><img src="{{ asset('assets/admin/images/icon/program.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                            @endif
                            @endif
                           

                               <!--  <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href=""><img src="{{ asset('assets/admin/images/icon/topic.svg') }}" alt="image"></a>
                                    </div>
                                </div> -->

                               <!--  <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href=""><img src="{{ asset('assets/admin/images/icon/teacher.svg') }}" alt="image"></a>
                                    </div>
                                </div> -->

                               <!--  <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href=""><img src="{{ asset('assets/admin/images/icon/question.svg') }}" alt="image"></a>
                                    </div>
                                </div> -->

                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)


                                <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/question') }}" title="Question"><img src="{{ asset('assets/admin/images/icon/plan.svg') }}" alt="image"></a>
                                    </div>
                                </div>

                            @endif
                            @endif    


                                
                                @if(isset(Auth::user()->roleId))
                                @if(Auth::user()->roleId == 2)
                                <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/teacher-meeting') }}" title="Session"><img src="{{ asset('assets/admin/images/icon/meeting.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                                @endif
                                @endif

                            @if(isset(Auth::user()->roleId))
                                @if(Auth::user()->roleId == 1)
                                <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/meeting') }}" title="Session"><img src="{{ asset('assets/admin/images/icon/meeting.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                                @endif
                                @endif
                            

                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)
                                <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/plan') }}" title="Plan management"><img src="{{ asset('assets/admin/images/icon/order.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                            @endif
                            @endif

                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)
                                    <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/contact') }}" title="Contact"><img src="{{ asset('assets/admin/images/icon/management.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                            @endif
                            @endif

                            @if(isset(Auth::user()->roleId))
                            @if(Auth::user()->roleId == 1)
                                <div class="col-lg-3 col-md-6 my-3">
                                    <div class="icon-list rounded">
                                        <a href="{{ url('/admin/user') }}" title="User"><img src="{{ asset('assets/admin/images/icon/user.svg') }}" alt="image"></a>
                                    </div>
                                </div>
                            @endif
                            @endif
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- order list area end -->
@endsection