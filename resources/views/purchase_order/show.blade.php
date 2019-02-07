@extends('layouts.main')

@section('content-header')
@if($route == "/purchase_order")
    @breadcrumb(
        [
            'title' => isset($modelPO->project) ? 'View Purchase Order » '.$modelPO->project->number : 'View Purchase Order',
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Order' => route('purchase_order.index'),
                'View Purchase Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_order_repair")
    @breadcrumb(
        [
            'title' => isset($modelPO->project) ? 'View Purchase Order » '.$modelPO->project->number : 'View Purchase Order',
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Order' => route('purchase_order_repair.index'),
                'View Purchase Order' => '',
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
                            <span class="info-box-text">PO Number</span>
                            <span class="info-box-number">{{ $modelPO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 m-t-10 m-l-25 no-padding">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Project Number
                        </div>
                        <div class="col-md-8 col-xs-7">
                            : <b> {{ isset($modelPO->project) ? $modelPO->project->number : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Ship Name
                        </div>
                        <div class="col-md-8 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelPO->project) ? $modelPO->project->name : '-' }}">
                            : <b> {{ isset($modelPO->project) ? $modelPO->project->name : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Ship Type
                        </div>
                        <div class="col-md-8 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelPO->project) ? $modelPO->project->ship->type : '-' }}">
                            : <b> {{ isset($modelPO->project) ? $modelPO->project->ship->type : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Ref Number
                        </div>
                        <div class="col-md-8 col-xs-7">
                            : <b> {{ $modelPO->purchaseRequisition->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Delivery Date
                        </div>
                        <div class="col-md-8 col-xs-7">
                            : <b>{{date("d-m-Y", strtotime($modelPO->delivery_date))}}</b>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 m-t-10 m-l-25 no-padding">
                    <div class="row">
                        <div class="col-md-5 col-xs-4">
                            Customer Name
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelPO->project) ? $modelPO->project->customer->name : '-'}}">
                            : <b> {{ isset($modelPO->project) ? $modelPO->project->customer->name : '-' }} </b>
                        </div>
                        <div class="col-md-5 col-xs-4" >
                            Vendor Name
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelPO->vendor->code }} - {{ $modelPO->vendor->name }}">
                            : <b> {{ $modelPO->vendor->code }} - {{ $modelPO->vendor->name }} </b>
                        </div>
                        <div class="col-md-5 col-xs-4">
                            Status
                        </div>
                        @if($modelPO->status == 1)
                            <div class="col-md-7 col-xs-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelPO->status == 2)
                            <div class="col-md-7 col-xs-7">
                                : <b>APPROVED</b>
                            </div>
                        @elseif($modelPO->status == 3)
                            <div class="col-md-7 col-xs-7">
                                : <b>NEED REVISION</b>
                            </div>
                        @elseif($modelPO->status == 4)
                            <div class="col-md-7 col-xs-7">
                                : <b>REVISED</b>
                            </div>
                        @elseif($modelPO->status == 5)
                            <div class="col-md-7 col-xs-8">
                                : <b>REJECTED</b>
                            </div>
                        @elseif($modelPO->status == 0)
                            <div class="col-md-7 col-xs-7">
                                : <b>RECEIVED</b>
                            </div>
                        @endif
                        <div class="col-md-5 col-xs-4">
                            Created By
                        </div>
                        <div class="col-md-7 col-xs-7">
                            : <b> {{ $modelPO->user->name }} </b>
                        </div>
                        <div class="col-md-5 col-xs-4">
                            Created At
                        </div>
                        <div class="col-md-7 col-xs-7">
                            : <b> {{ $modelPO->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered showTable tableFixed" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            @if($modelPO->purchaseRequisition->type == 1)
                                <th width="35%">Material Name</th>
                            @elseif($modelPO->purchaseRequisition->type == 2)
                                <th width="35%">Resource Name</th>
                            @endif
                            <th width="10%">Quantity</th>
                            <th width="10%">Disc. (%)</th>
                            <th width="20%">Price / pcs ({{$unit}})</th>
                            <th width="20%">Sub Total Price ({{$unit}})</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $POD)
                            @if($POD['quantity'] > 0)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if($modelPO->purchaseRequisition->type == 1)
                                        <td>{{ $POD['material_code'] }} - {{ $POD['material_name'] }}</td>
                                    @elseif($modelPO->purchaseRequisition->type == 2)
                                        <td>{{ $POD['resource_code'] }} - {{ $POD['resource_name'] }}</td>
                                    @endif
                                    <td>{{ number_format($POD['quantity']) }}</td>
                                    <td>{{ number_format($POD['discount']) }}</td>
                                    <td>{{ number_format($POD['price'] / $modelPO['value'],2) }}</td>
                                    <td>{{ number_format($POD['sub_total'] / $modelPO['value'],2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Subtotal :</b></td>
                            <td class="text-right p-r-5"><b>{{$unit}} {{number_format($datas->sum('sub_total') / $modelPO['value'],2)}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Discount :</b></td>
                            <td class="text-right p-r-5"><b>{{$unit}} {{number_format($total_discount  / $modelPO['value'],2)}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Tax ({{$modelPO->tax}}%) :</b></td>
                            <td class="text-right p-r-5"><b>{{$unit}} {{number_format($tax / $modelPO['value'],2)}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Estimated Freight :</b></td>
                            <td class="text-right p-r-5"><b>{{$unit}} {{number_format($modelPO->estimated_freight),2}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Total Order :</b></td>
                            <td class="text-right p-r-5"><b>{{$unit}} {{number_format( (($datas->sum('sub_total') - $total_discount) + $tax + $modelPO->estimated_freight)/ $modelPO['value'],2)}}</b></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($route == "/purchase_order")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('purchase_order.print', ['id'=>$modelPO->id]) }}">DOWNLOAD</a>
                    @elseif($route == "/purchase_order_repair")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('purchase_order_repair.print', ['id'=>$modelPO->id]) }}">DOWNLOAD</a>
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
        $('div.overlay').remove();
    });
</script>
@endpush
