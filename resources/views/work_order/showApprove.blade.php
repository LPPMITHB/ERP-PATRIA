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
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Project Number
                        </div>
                        <div class="col-md-8">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->number : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ship Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->name : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ship Type
                        </div>
                        <div class="col-md-8">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->ship->type : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ref Number
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelWO->workRequest->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Total Price
                        </div>
                        <div class="col-md-8">
                            : <b> {{ number_format($modelWO->total_price) }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-5">
                            Customer Name
                        </div>
                        <div class="col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelWO->project) ? $modelWO->project->customer->name : '-'}}">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->customer->name : '-' }} </b>
                        </div>
                        <div class="col-md-5">
                            Vendor Name
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelWO->vendor->code }} - {{ $modelWO->vendor->name }} </b>
                        </div>
                        <div class="col-md-5">
                            Status
                        </div>
                        @if($modelWO->status == 1)
                            <div class="col-md-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelWO->status == 2)
                            <div class="col-md-7">
                                : <b>APPROVED</b>
                            </div>
                        @elseif($modelWO->status == 3)
                            <div class="col-md-7">
                                : <b>NEED REVISION</b>
                            </div>
                        @elseif($modelWO->status == 4)
                            <div class="col-md-7">
                                : <b>REVISED</b>
                            </div>
                        @elseif($modelWO->status == 5)
                            <div class="col-md-7">
                                : <b>REJECTED</b>
                            </div>
                        @elseif($modelWO->status == 0)
                            <div class="col-md-7">
                                : <b>RECEIVED</b>
                            </div>
                        @endif
                        <div class="col-md-5">
                            Created By
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelWO->user->name }} </b>
                        </div>
                        <div class="col-md-5">
                            Created At
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelWO->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered showTable" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Material Name</th>
                            <th width="20%">Quantity</th>
                            <th width="20%">Price / pcs</th>
                            <th width="20%">Sub Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWO->workOrderDetails as $WOD)
                            @if($WOD->quantity > 0)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $WOD->material->code }} - {{ $WOD->material->name }}</td>
                                    <td>{{ number_format($WOD->quantity) }}</td>
                                    <td>{{ number_format($WOD->total_price / $WOD->quantity) }}</td>
                                    <td>{{ number_format($WOD->total_price) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                @if($modelWO->status == 1 || $modelWO->status == 4)
                    <div class="col-md-12 m-b-10 p-r-0">
                        @if($menu == "building")
                            <a class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" href="{{ route('work_order.approval', ['id'=>$modelWO->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="col-xs-12 col-md-2 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" href="{{ route('work_order.approval', ['id'=>$modelWO->id,'status'=>'need-revision']) }}">NEEDS REVISION</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" href="{{ route('work_order.approval', ['id'=>$modelWO->id,'status'=>'reject']) }}">REJECT</a>
                        @else
                            <a class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" href="{{ route('work_order_repair.approval', ['id'=>$modelWO->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="col-xs-12 col-md-2 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" href="{{ route('work_order_repair.approval', ['id'=>$modelWO->id,'status'=>'need-revision']) }}">NEEDS REVISION</a>
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
