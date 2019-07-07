@extends('layouts.main')

@section('content-header')
@if(!$modelWO->project)
    @breadcrumb(
        [
            'title' => 'View Work Order',
            'items' => [
                'Dashboard' => route('index'),
                'View Work Order' => route('purchase_order.show',$modelWO->id),
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'View Work Order » '.$modelWO->project->name,
            'items' => [
                'Dashboard' => route('index'),
                'View Work Order' => route('purchase_order.show',$modelWO->id),
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
            <div class="box-header no-padding">
                <div class="col-sm-3 col-md-3 col-lg-3 no-padding-left">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">PO Number</span>
                            <span class="info-box-number">{{ $modelWO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12 m-t-10 m-l-25">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Project
                        </div>
                        <div class="col-md-8 col-xs-6">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->number : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Customer
                        </div>
                        <div class="col-md-8 col-xs-6 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelWO->project) ? $modelWO->project->customer->name : '-'}}">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->customer->name : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Vendor Name
                        </div>
                        <div class="col-md-8 col-xs-6 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelWO->vendor->code }} - {{ $modelWO->vendor->name }}">
                            : <b> {{ $modelWO->vendor->code }} - {{ $modelWO->vendor->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 ">
                            Ref Number
                        </div>
                        <div class="col-md-8 col-xs-6">
                            : <b> {{ $modelWO->workRequest->number }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12 m-t-10 m-l-25">
                    <div class="row">
                        <div class="col-md-5 col-xs-4 ">
                            Status
                        </div>
                        @if($modelWO->status == 1)
                            <div class="col-md-7 col-xs-6">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelWO->status == 2)
                            <div class="col-md-7 col-xs-6">
                                : <b>APPROVED</b>
                            </div>
                        @elseif($modelWO->status == 3)
                            <div class="col-md-7 col-xs-6">
                                : <b>NEED REVISION</b>
                            </div>
                        @elseif($modelWO->status == 4)
                            <div class="col-md-7 col-xs-6">
                                : <b>REVISED</b>
                            </div>
                        @elseif($modelWO->status == 5)
                            <div class="col-md-7 col-xs-6">
                                : <b>REJECTED</b>
                            </div>
                        @elseif($modelWO->status == 0)
                            <div class="col-md-7 col-xs-6">
                                : <b>RECEIVED</b>
                            </div>
                        @endif
                        <div class="col-md-5 col-xs-4 ">
                            Created By
                        </div>
                        <div class="col-md-7 col-xs-6">
                            : <b> {{ $modelWO->user->name }} </b>
                        </div>
                        <div class="col-md-5 col-xs-4 ">
                            Created At
                        </div>
                        <div class="col-md-7 col-xs-6">
                            : <b> {{ $modelWO->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        @if($modelWO->status != 6 && $modelWO->status != 1)
                            @if($modelWO->status == 2 || $modelWO->status == 0 || $modelWO->status == 7)
                                <div class="col-xs-5 col-md-5">
                                    Approved By
                                </div>
                            @elseif($modelWO->status == 3 || $modelWO->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Checked By
                                </div>
                            @elseif($modelWO->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Rejected By
                                </div>
                            @endif
                            <div class="col-xs-7 col-md-7 tdEllipsis">
                                : <b> {{ $modelWO->approvedBy->name }} </b>
                            </div>
                        @endif
                        @php
                            $approval_date = "";
                            if($modelWO->approval_date != NULL){
                                $approval_date = DateTime::createFromFormat('Y-m-d', $modelWO->approval_date);
                                $approval_date = $approval_date->format('d-m-Y');
                            }
                        @endphp
                        @if($modelWO->status == 2 || $modelWO->status == 0 || $modelWO->status == 7)
                            <div class="col-xs-5 col-md-5">
                                Approved Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date }}</b>
                            </div>
                        @elseif($modelWO->status == 5)
                            <div class="col-xs-5 col-md-5">
                                Rejected Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date }}</b>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered tableFixed showTable" id="boms-table">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="12%">Material Number</th>
                            <th width="20%">Material Description</th>
                            <th width="5%">Unit</th>
                            <th width="20%">Description</th>
                            <th width="6%">Qty</th>
                            <th width="12%">Price / pcs ({{$unit}})</th>
                            <th width="8%">Disc (%)</th>
                            <th width="14%">Amount ({{$unit}})</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWO->workOrderDetails as $WOD)
                            @if($WOD->quantity > 0)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $WOD->material->code }}">{{ $WOD->material->code }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $WOD->material->description }}">{{ $WOD->material->description }}</td>
                                    <td>{{ $WOD->material->uom->unit }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$WOD->workRequestDetail->description}}">{{ $WOD->workRequestDetail->description }}</td>
                                    <td>{{ number_format($WOD->quantity,2) }}</td>
                                    <td>{{ number_format($WOD->total_price / $WOD->quantity,2) }}</td>
                                    <td>{{ number_format($WOD->discount,2) }}</td>
                                    <td>{{ number_format($WOD->total_price - ($WOD->total_price * ($WOD->discount/100)),2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="visibility:hidden"></td>
                            <td colspan="2" class="text-right p-r-5"><b>Subtotal :</b></td>
                            <td class="text-right p-r-5"><b>{{number_format($modelWO->total_price,2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="visibility:hidden"></td>
                            <td colspan="2" class="text-right p-r-5"><b>Discount :</b></td>
                            <td class="text-right p-r-5"><b>{{number_format($total_discount ,2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="visibility:hidden"></td>
                            <td colspan="2" class="text-right p-r-5"><b>Tax ({{$modelWO->tax}}%) :</b></td>
                            <td class="text-right p-r-5"><b>{{number_format($tax,2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="visibility:hidden"></td>
                            <td colspan="2" class="text-right p-r-5"><b>Estimated Freight :</b></td>
                            <td class="text-right p-r-5"><b>{{number_format($modelWO->estimated_freight),2}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="visibility:hidden"></td>
                            <td colspan="2" class="text-right p-r-5"><b>Total Order :</b></td>
                            <td class="text-right p-r-5"><b>{{number_format( (($modelWO->total_price - $total_discount) + $tax + $modelWO->estimated_freight),2)}} {{$unit}}</b></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($route == "/work_order")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('work_order.print', ['id'=>$modelWO->id]) }}">DOWNLOAD</a>
                    @elseif($route == "/work_order_repair")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('work_order_repair.print', ['id'=>$modelWO->id]) }}">DOWNLOAD</a>
                    @endif
                </div>
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });
</script>
@endpush
