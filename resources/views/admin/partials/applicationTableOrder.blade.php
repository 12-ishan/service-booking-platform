
@if(isset($includeOffset) && $includeOffset)


<!-- offset area start -->
<div class="offset-area2">
        <div class="offset-close2"><i class="ti-close"></i></div>

        <div class="offset-settings">
                    <h4>Manage Order</h4>
                    <div class="settings-list">

                     @foreach ($finalColumnSettings as $columnSetting)
                                    

                                         <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>{{ $columnSetting['title'] }}</h5>
                            </div>
                        </div>


                                          
                                        @endforeach


                       
                    </div>
                </div>
       
       
    </div>
    <!-- offset area end -->

    @endif
