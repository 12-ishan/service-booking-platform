@extends('layout.admin')
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body list-grid">

                <div class="row">
                    <div class="col-12">
                        <div class="grid-col control-bar">

                            <div class="row control">
                                <div class="col-6 left-control">


                                </div>

                                <div class="col-6 right-control">

                                    <a href="javascript:void(0);" onclick="window.history.back();">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                    </a>


                                    <a href="{{route('index')}}">

                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Refresh</button>
                                    </a>

                                   
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <form method="post" id="deleteAllPaymentHistory">

                    <div class="data-tables">
                        <table id="paymentHistoryTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Seq.</th>
                                    <th>Organisation Id</th>
                                    <th>Student Id</th>
                                    <th>Program Id</th>
                                    <th>Txn Number</th>
                                    <th>Payment Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentHistory as $value)

                                <tr id="item{{$value->id}}">
                                     <td> {{$loop->iteration}} </td>
                                  
                                    <td>@isset($value->organisation_id){{$value->organisation_id}}@else NA @endif</td>

                                    <td>@isset($value->student_id){{$value->student_id}}@else NA @endif</td>
                                    
                                    <td>@isset($value->program_id){{$value->program_id}}@else NA @endif</td>
                                    
                                    <td>@isset($value->transaction_number){{$value->transaction_number}}@else NA @endif</td>

                                    <td>@isset($value->payment_status){{$value->payment_status}}@else NA @endif</td>

                                

                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>

@section('js')
<script src="{{ asset('assets/admin/js/console/paymentHistory.js') }}"></script>
@append

@endsection