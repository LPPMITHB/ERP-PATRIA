@extends('layouts.main')

@section('content-header')
@if($route == "/purchase_order")
    @breadcrumb(
        [
            'title' => 'View Purchase Order',
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
            'title' => 'View Purchase Order',
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
                            PR Number
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelPO->purchaseRequisition->number }} </b>
                        </div>
                        <div class="col-md-4 col-xs-4" >
                            Vendor Name
                        </div>
                        <div class="col-md-8 col-xs-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelPO->vendor->code }} - {{ $modelPO->vendor->name }}">
                            : <b> {{ $modelPO->vendor->code }} - {{ $modelPO->vendor->name }} </b>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            Status
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b>{{$statusPO}}</b>
                        </div>
                        <div class="col-md-4 col-xs-4" >
                            Description
                        </div>
                        <div class="col-md-8 col-xs-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelPO->description }}">
                            : <b> {{ ($modelPO->description != "") ? $modelPO->description : '-' }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 m-t-10 m-l-25 no-padding">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Created By
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelPO->user->name }} </b>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            Created At
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelPO->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        @if($modelPO->status != 1)
                            @if($modelPO->status == 2 || $modelPO->status == 0 || $modelPO->status == 7)
                                <div class="col-xs-4 col-md-4">
                                    Approved By
                                </div>
                            @elseif($modelPO->status == 3 || $modelPO->status == 4)
                                <div class="col-xs-4 col-md-4">
                                    Checked By
                                </div>
                            @elseif($modelPO->status == 5)
                                <div class="col-xs-4 col-md-4">
                                    Rejected By
                                </div>
                            @endif
                            <div class="col-xs-8 col-md-8 tdEllipsis">
                                : <b> {{ $modelPO->approvedBy->name }} </b>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered tableFixed" id="boms-table">
                    <thead>
                        <tr>
                            <th width="4%">No</th>
                            @if($modelPO->purchaseRequisition->type == 1)
                                <th width="14%">Material Number</th>
                                <th width="20%">Material Description</th>
                            @elseif($modelPO->purchaseRequisition->type == 2)
                                <th width="14%">Resource Number</th>
                                <th width="20%">Resource Description</th>
                            @endif
                            <th width="6%">Qty</th>
                            <th width="5%">Unit</th>
                            <th width="5%">Disc.</th>
                            <th width="13%">Price / pcs ({{$unit}})</th>
                            <th width="15%">Sub Total Price ({{$unit}})</th>
                            <th width="10%">Delivery Date</th>
                            <th width="8%">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $POD)
                            @if($POD['quantity'] > 0)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if($modelPO->purchaseRequisition->type == 1)
                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $POD['material_code'] }}">{{ $POD['material_code'] }}</td>
                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $POD['material_name'] }}">{{ $POD['material_name'] }}</td>
                                    @elseif($modelPO->purchaseRequisition->type == 2)
                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $POD['resource_code'] }}">{{ $POD['resource_code'] }}</td>
                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $POD['resource_name'] }}">{{ $POD['resource_name'] }}</td>
                                    @endif
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ number_format($POD['quantity'],2) }}">{{ number_format($POD['quantity'],2) }}</td>
                                    <td>{{ $POD['unit'] }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ number_format($POD['discount'],2) }}%">{{ number_format($POD['discount'],2) }}%</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ number_format($POD['price'] / $modelPO['value'],2) }}">{{ number_format($POD['price'] / $modelPO['value'],2) }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ number_format($POD['sub_total'] / $modelPO['value'],2) }}">{{ number_format($POD['sub_total'] / $modelPO['value'],2) }}</td>
                                    <td>{{ isset($POD['delivery_date']) ? date('d-m-Y', strtotime($POD['delivery_date'])) : '-' }}</td>
                                    <td class="textCenter">
                                        <a class="btn btn-primary btn-xs" data-toggle="modal" href="#show_remark" onClick="test({{$POD['id']}})">
                                            REMARK
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="7" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Subtotal :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format($datas->sum('sub_total') / $modelPO['value'],2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="7" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Discount :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format($total_discount  / $modelPO['value'],2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="7" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Tax ({{$modelPO->tax}}%) :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format($tax / $modelPO['value'],2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="7" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Estimated Freight :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format($modelPO->estimated_freight / $modelPO->value),2}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="7" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Total Order :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format( (($datas->sum('sub_total') - $total_discount) + $tax + $modelPO->estimated_freight)/ $modelPO['value'],2)}} {{$unit}}</b></td>
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

                <div class="modal fade" id="show_remark">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">View Remark</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="remark" class="control-label">Remark</label>
                                        <textarea name="remark" id="remark" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
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

    var data = {
        modelPOD : @json($datas)
    }
    function test(id){
        var modelPOD = this.data.modelPOD;
        var remark = ""
        modelPOD.forEach(POD =>{
            if(POD.id == id){
                remark = POD.remark;
            }
        })
        document.getElementById("remark").value = remark;
    }
</script>
@endpush
