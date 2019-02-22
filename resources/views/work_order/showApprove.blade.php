@extends('layouts.main')

@section('content-header')
@if(!$modelWO->project)
    @breadcrumb(
        [
            'title' => 'Approve Work Order',
            'items' => [
                'Dashboard' => route('index'),
                'Approve Work Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'Approve Work Order » '.$modelWO->project->name,
            'items' => [
                'Dashboard' => route('index'),
                'Approve Work Order' => '',
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
                            <span class="info-box-text">WO Number</span>
                            <span class="info-box-number">{{ $modelWO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12 m-t-10 m-l-25">
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Project Number
                        </div>
                        <div class="col-md-8 col-xs-6">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->number : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Ship Name
                        </div>
                        <div class="col-md-8 col-xs-6 tdEllipsis" data-container="body" data-toggle="tooltip" title=" {{ isset($modelWO->project) ? $modelWO->project->name : '-' }}">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->name : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Ship Type
                        </div>
                        <div class="col-md-8 col-xs-6">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->ship->type : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Ref Number
                        </div>
                        <div class="col-md-8 col-xs-6">
                            : <b> {{ $modelWO->workRequest->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Total Price
                        </div>
                        <div class="col-md-8 col-xs-6">
                            : <b> {{ number_format($modelWO->total_price) }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12 m-t-10 m-l-25">
                    <div class="row">
                        <div class="col-md-5 col-xs-4 no-padding">
                            Customer Name
                        </div>
                        <div class="col-md-7 col-xs-6 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelWO->project) ? $modelWO->project->customer->name : '-'}}">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->customer->name : '-' }} </b>
                        </div>
                        <div class="col-md-5 col-xs-4 no-padding">
                            Vendor Name
                        </div>
                        <div class="col-md-7 col-xs-6 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelWO->vendor->code }} - {{ $modelWO->vendor->name }}">
                            : <b> {{ $modelWO->vendor->code }} - {{ $modelWO->vendor->name }} </b>
                        </div>
                        <div class="col-md-5 col-xs-4 no-padding">
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
                        <div class="col-md-5 col-xs-4 no-padding">
                            Created By
                        </div>
                        <div class="col-md-7 col-xs-6">
                            : <b> {{ $modelWO->user->name }} </b>
                        </div>
                        <div class="col-md-5 col-xs-4 no-padding">
                            Created At
                        </div>
                        <div class="col-md-7 col-xs-6">
                            : <b> {{ $modelWO->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered tableFixed showTable" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Material Number</th>
                            <th width="20%">Material Description</th>
                            <th width="4%">Unit</th>
                            <th width="10%">Quantity</th>
                            <th width="20%">Price / pcs</th>
                            <th width="10%">Discount (%)</th>
                            <th width="16%">Sub Total Price</th>
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
                                    <td>{{ number_format($WOD->quantity) }}</td>
                                    <td>{{ number_format($WOD->total_price / $WOD->quantity) }}</td>
                                    <td>{{ number_format($WOD->discount,2) }}</td>
                                    <td>{{ number_format($WOD->total_price - ($WOD->total_price * ($WOD->discount/100)),2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                @if($modelWO->status == 1 || $modelWO->status == 4)
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                        @if($route == "/work_order")
                            <a class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" href="{{ route('work_order.approval', ['id'=>$modelWO->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" href="{{ route('work_order.approval', ['id'=>$modelWO->id,'status'=>'need-revision']) }}">REVISE</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" href="{{ route('work_order.approval', ['id'=>$modelWO->id,'status'=>'reject']) }}">REJECT</a>
                        @else
                            <a class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" href="{{ route('work_order_repair.approval', ['id'=>$modelWO->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" href="{{ route('work_order_repair.approval', ['id'=>$modelWO->id,'status'=>'need-revision']) }}">REVISE</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" href="{{ route('work_order_repair.approval', ['id'=>$modelWO->id,'status'=>'reject']) }}">REJECT</a>
                        @endif
                    </div>
                @endif
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
