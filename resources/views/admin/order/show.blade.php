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

                        <div class="invoice-area">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="iv-left col-6">
                                                <span>Order ID:</span>
                                            </div>
                                            <div class="iv-right col-6 text-md-right">
                                                <span>#{{ $order->id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="invoice-address">
                                                <h3>Customer Details</h3>
                                                <?php /* 
                                                <h5>{{ $order->customerName }}</h5>
                                                <h5>{{ $order->customerEmail }}</h5>
                                                <p>{{ $orderBilling->company }}</p>
                                                <p>{{ $orderBilling->address1 }}</p>
                                                <p>{{ $orderBilling->address2 }}, {{ $orderBilling->coutry }}, {{ $orderBilling->zip }} {{ $orderBilling->state }}</p>
                                                */ ?>                                                                                     
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <ul class="invoice-date">
                                                <li>Order Date : {{ $order->created_at }}</li>
                                                <li>Order Status :  @if($order->orderStatus == 1)
                                                Pending
                                                @elseif($order->orderStatus == 2)
                                                Completed
                                                @endif</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover text-right">
                                            <thead>
                                                <tr class="text-capitalize">
                                                    <th class="text-center" style="width: 5%;">S.No.</th>
                                                    <th class="text-left" style="width: 15%; min-width: 130px;">Program</th>
                                                    <th class="text-left">Subject</th>
                                                    <th class="text-left">Topic</th>
                                                    <th class="text-left">Number Of Session</th>
                                                    <th class="text-left">State</th>
                                                    <th style="min-width: 100px">Cost</th>
                                                    <!-- <th>total</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>

                                                 
                                            @php $i = 1 @endphp 
                                            @foreach($orderItem as $value)
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td class="text-left">{{ $value->program->name }}</td>
                                                    <td class="text-left">{{ $value->subject->name }}</td>
                                                    <td class="text-left">{{ $value->topic->title }}</td>
                                                    <td class="text-left">{{ $value->noOfSessionn }}</td>
                                                    <td class="text-left"> {{ $value->state->name }}</td>
                                                    <td>
                                                        @if(empty($value->amount))
                                                        0
                                                        @else
                                                        {{ $value->amount }}
                                                        @endif          
                                                    </td>
                                                    <!-- <td>$40</td> -->
                                                </tr>
                                                @php $i++ @endphp 
                                            @endforeach                    
                            
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6">total:</td>
                                                    <td>{{$order->totalAmount }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
            <!-- basic form end -->
        </div>
    </div>
</div>

@section('js')
<script src="{{ asset('assets/admin/js/console/customer.js') }}"></script>
@append

@endsection