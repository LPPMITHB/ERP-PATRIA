@extends('layouts.main')

@section('content-header')
@if($route == "/sales_order")
    @breadcrumb(
        [
            'title' => 'View Sales Order',
            'items' => [
                'Dashboard' => route('index'),
                'View All Sales Orders' => route('sales_order.index'),
                'View Sales Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/sales_order_repair")
    @breadcrumb(
        [
            'title' => 'View Sales Order',
            'items' => [
                'Dashboard' => route('index'),
                'View All Sales Orders' => route('sales_order_repair.index'),
                'View Sales Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">SO Number</span>
                            <span class="info-box-number">{{ $modelSO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 m-t-10 m-l-25 no-padding">
                    <div class="row">
                        <div class="col-md-5 col-xs-5" >
                            Quotation Number
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelSO->quotation->number }}">
                        @if($route == "/sales_order")
                            : <b><a href="{{ route('quotation.show',['id'=>$modelSO->quotation->id]) }}" target="_blank"> {{ $modelSO->quotation->number }} </b></a>
                        @elseif($route == "/sales_order_repair")
                            : <b><a href="{{ route('quotation_repair.show',['id'=>$modelSO->quotation->id]) }}" target="_blank"> {{ $modelSO->quotation->number }} </b></a>
                        @endif
                        </div>
                        <div class="col-md-5 col-xs-5" >
                            Customer Name
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelSO->customer->code }} - {{ $modelSO->customer->name }}">
                            : <b> {{ $modelSO->customer->code }} - {{ $modelSO->customer->name }} </b>
                        </div>
                        <div class="col-md-5 col-xs-5">
                            Status
                        </div>
                        <div class="col-md-7 col-xs-7">
                            : <b>{{$statusSO}}</b>
                        </div>
                        <div class="col-md-5 col-xs-5" >
                            Description
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelSO->description }}">
                            : <b> {{ ($modelSO->description != "") ? $modelSO->description : '-' }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 m-t-10 m-l-25 no-padding">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Created By
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelSO->user->name }} </b>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            Created At
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelSO->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        <div class="col-md-12 p-t-5">
                            <a href="#top" class="btn btn-sm btn-primary " data-toggle="modal">View Terms Of Payment</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered tableFixed" id="qt-table">
                    <thead>
                        <tr>
                            <th width="20%">Cost Standard</th>
                            <th width="25%">Description</th>
                            <th width="20%">Value</th>
                            <th width="10%">Unit</th>
                            <th width="25%">Sub Total</th>
                        </tr>
                    </thead>
                    @foreach($wbs as $data)
                        <tbody>
                            <td colspan="5" class="p-t-13 p-b-13 bg-primary"><b>{{ $data->code }} - {{ $data->name }}</b></td>
                            @foreach($modelSO->salesOrderDetails as $sod)
                                @if($sod->estimatorCostStandard->estimator_wbs_id == $data->id)
                                    <tr>
                                        <td class="tdEllipsis p-t-13 p-b-13">{{ $sod->estimatorCostStandard->code }} - {{ $sod->estimatorCostStandard->name }}</td>
                                        <td class="tdEllipsis p-t-13 p-b-13">{{ $sod->estimatorCostStandard->description ? $sod->estimatorCostStandard->description : '-' }}</td>
                                        <td class="tdEllipsis p-t-13 p-b-13">{{ number_format($sod->value,2) }}</td>
                                        <td class="tdEllipsis p-t-13 p-b-13">{{ $sod->estimatorCostStandard->uom->unit }}</td>
                                        <td class="tdEllipsis p-t-13 p-b-13">Rp.{{ number_format($sod->value * $sod->price) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td class="p-b-13 p-t-13 text-right p-r-5" colspan="4"><b>Margin :</b></td>
                            <td class="p-r-5">{{number_format($modelSO->margin,2)}} %</td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13 text-right p-r-5" colspan="4"><b>Total Price :</b></td>
                            <td class="p-r-5">Rp.{{number_format($modelSO->total_price)}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
    <div class="modal fade" id="top">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">View Terms of Payment</h4>
                </div>
                <div class="modal-body">
                    <div class="row p-l-10 p-r-10">
                        <table class="table table-bordered tableFixed m-b-0 showTable">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="35%">Project Progress (%)</th>
                                    <th width="40%">Payment Percentage (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tops as $top)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $top->project_progress }} %</td>
                                        <td>{{ $top->payment_percentage }} %</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">CANCEL</button>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
        $("textarea").keydown(false);
    });
</script>
@endpush
