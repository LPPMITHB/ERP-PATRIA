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
                                @if(isset($modelPO->purchaseRequisition))
                                    @if($route == "/purchase_order")
                                        : <a href="{{ route('purchase_requisition.show', ['id'=>$modelPO->purchaseRequisition->id]) }}" class="text-primary"><b>{{$modelPO->purchaseRequisition->number}}</b></a>
                                    @else
                                        : <a href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPO->purchaseRequisition->id]) }}" class="text-primary"><b>{{$modelPO->purchaseRequisition->number}}</b></a>
                                    @endif
                                @else
                                    -
                                @endif
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
                        <div class="col-md-4 col-xs-4" >
                            Delivery Term
                        </div>
                        <div class="col-md-8 col-xs-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $dterm_name }}">
                            : <b> {{ ($dterm_name != null) ? $dterm_name : '-' }} </b>
                        </div>
                        <div class="col-md-4 col-xs-4" >
                            Project Number
                        </div>
                        <div class="col-md-8 col-xs-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ ($modelPO->project != null) ? $modelPO->project->number : '-' }}">
                            : <b> {{ ($modelPO->project != null) ? $modelPO->project->number : '-' }} </b>
                        </div>
                        @if($modelPO->purchaseRequisition->type == 3)
                            <div class="col-md-4 col-xs-4" >
                                Delivery Date
                            </div>
                            @php
                                if($modelPO->delivery_date != NULL){
                                    $date = DateTime::createFromFormat('Y-m-d', $modelPO->delivery_date);
                                    $date = $date->format('d-m-Y');
                                }
                            @endphp
                            <div class="col-md-8 col-xs-8 tdEllipsis">
                                : <b> {{ ($modelPO->delivery_date != "") ? $date : '-' }} </b>
                            </div>
                        @endif
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
                        @if($modelPO->status != 1 && $modelPO->status != 8)
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
                        <!-- Revision Description -->
                        @if($modelPO->status != 1 && $modelPO->status != 8)
                        @if($modelPO->status == 3 || $modelPO->status == 4)
                        <div class="col-xs-4 col-md-4">
                            Revise Description
                        </div>
                        @elseif($modelPO->status == 5)
                        <div class="col-xs-4 col-md-4">
                            Rejected Description
                        </div>
                        @endif
                        @if($modelPO->status == 3 || $modelPO->status == 4 || $modelPO->status == 5)
                        <div class="col-xs-8 col-md-8 tdEllipsis" data-toggle="tooltip" title="{{ ($modelPO->revision_description != null) ? $modelPO->revision_description : '-' }}">
                            : <b> {{ $modelPO->revision_description }} </b>
                        </div>
                        @endif
                        @endif
                        <!-- End Revision Description -->
                        @php
                            $approval_date = "";
                            if($modelPO->approval_date != NULL){
                                $approval_date = DateTime::createFromFormat('Y-m-d', $modelPO->approval_date);
                                $approval_date = $approval_date->format('d-m-Y');
                            }
                        @endphp
                        @if($modelPO->status == 2)
                            <div class="col-xs-4 col-md-4">
                                Approved Date
                            </div>
                            <div class="col-xs-8 col-md-8">
                                : <b>{{ $approval_date }}</b>
                            </div>
                        @elseif($modelPO->status == 5)
                            <div class="col-xs-4 col-md-4">
                                Rejected Date
                            </div>
                            <div class="col-xs-8 col-md-8">
                                : <b>{{ $approval_date }}</b>
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
                            @else
                                <th colspan="2" width="14%">Job Order</th>
                            @endif
                            <th width="6%">Order Quantity</th>
                            <th width="5%">Disc.</th>
                            @if($modelPO->purchaseRequisition->type != 3)
                                <th width="13%">Price / pcs ({{$unit}})</th>
                            @else
                                <th width="13%">Price / service ({{$unit}})</th>
                            @endif
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
                                    @else
                                        <td colspan ="2" class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $POD['job_order'] }}">{{ $POD['job_order'] }}</td>
                                    @endif
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ number_format($POD['quantity'],2) }}">{{ number_format($POD['quantity'],2) }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ number_format($POD['discount'],2) }}%">{{ number_format($POD['discount'],2) }}%</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ number_format($POD['price'] / $modelPO['value'],2) }}">{{ number_format($POD['price'] / $modelPO['value'],2) }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ number_format($POD['sub_total'] / $modelPO['value'],2) }}">{{ number_format($POD['sub_total'] / $modelPO['value'],2) }}</td>
                                    <td>{{ isset($POD['delivery_date']) ? date('d-m-Y', strtotime($POD['delivery_date'])) : '-' }}</td>
                                    <td class="textCenter">
                                        <a class="btn btn-primary btn-xs" data-toggle="modal" href="#show_remark" onClick="remark({{$POD['id']}})">
                                            REMARK
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="6" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Subtotal :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format($datas->sum('sub_total') / $modelPO['value'],2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="6" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Discount :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format($total_discount  / $modelPO['value'],2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="6" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Tax ({{$modelPO->tax}}%) :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format($tax / $modelPO['value'],2)}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="6" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Estimated Freight :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format($modelPO->estimated_freight / $modelPO->value),2}} {{$unit}}</b></td>
                        </tr>
                        <tr>
                            <td class="p-b-13 p-t-13" colspan="6" style="visibility:hidden"></td>
                            <td class="text-right p-r-5"><b>Total Order :</b></td>
                            <td colspan="2" class="text-right p-r-5"><b> {{number_format( (($datas->sum('sub_total') - $total_discount) + $tax + $modelPO->estimated_freight)/ $modelPO['value'],2)}} {{$unit}}</b></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($route == "/purchase_order_repair" && $modelPO->purchaseRequisition->type == 3)
                        <a class="col-xs-12 col-md-2 btn btn-primary p-l-5 pull-right m-l-20" target="_blank" href="{{ route('purchase_order_repair.printJobOrder', ['id'=>$modelPO->id]) }}">DOWNLOAD JOB ORDER</a>
                    @endif

                    @if($route == "/purchase_order")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" target="_blank" href="{{ route('purchase_order.print', ['id'=>$modelPO->id]) }}">DOWNLOAD</a>
                        @can('cancel-approval-purchase-order')
                            @if($gr)
                                <a class="col-xs-12 col-md-2 btn btn-danger pull-right m-r-5" onclick="cancelApproval('{{$route}}')">CANCEL APPROVAL</a>
                            @endif
                        @endcan
                    @elseif($route == "/purchase_order_repair")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" target="_blank" href="{{ route('purchase_order_repair.print', ['id'=>$modelPO->id]) }}">DOWNLOAD</a>
                        @can('cancel-approval-purchase-order-repair')
                            @if($gr)
                                <a class="col-xs-12 col-md-2 btn btn-danger pull-right m-r-5" onclick="cancelApproval('{{$route}}')">CANCEL APPROVAL</a>
                            @endif
                        @endcan
                    @endif

                    @if($modelPO->status == 1 || $modelPO->status == 3 || $modelPO->status == 4)
                        <a class="col-xs-12 col-md-2 btn btn-danger pull-right m-r-5" onclick="cancel('{{$route}}')">CANCEL</a>
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
        $("textarea").keydown(false);
    });

    var data = {
        modelPOD : @json($datas)
    }
    function remark(id){
        var modelPOD = this.data.modelPOD;
        var remark = ""
        modelPOD.forEach(POD =>{
            if(POD.id == id){
                remark = POD.remark;
            }
        })
        document.getElementById("remark").value = remark;
    }

    function cancel(route){
        iziToast.question({
            close: false,
            overlay: true,
            timeout : 0,
            displayMode: 'once',
            id: 'question',
            zindex: 9999,
            title: 'Confirm',
            message: 'Are you sure you want to cancel this document?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    var url = "";
                    if(route == "/purchase_order"){
                        window.location.href = "{{ route('purchase_order.cancel', ['id'=>$modelPO->id]) }}";
                    }else{
                        window.location.href = "{{ route('purchase_order_repair.cancel', ['id'=>$modelPO->id]) }}";
                    }

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }, true],
                ['<button>NO</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }],
            ],
        });
    }

    function cancelApproval(route){
        iziToast.question({
            close: false,
            overlay: true,
            timeout : 0,
            displayMode: 'once',
            id: 'question',
            zindex: 9999,
            title: 'Confirm',
            message: 'Are you sure you want to cancel this approval?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    var url = "";
                    if(route == "/purchase_order"){
                        window.location.href = "{{ route('purchase_order.cancelApproval', ['id'=>$modelPO->id]) }}";
                    }else{
                        window.location.href = "{{ route('purchase_order_repair.cancelApproval', ['id'=>$modelPO->id]) }}";
                    }

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }, true],
                ['<button>NO</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }],
            ],
        });
    }
</script>
@endpush
