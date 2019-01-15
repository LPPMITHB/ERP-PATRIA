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
            <div class="row">
                <div class="col-sm-3 col-md-3">
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
                            : <b> {{ number_format($modelWO->total_price,2) }} </b>
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
                            <th width="10%">Quantity</th>
                            <th width="20%">Price / pcs</th>
                            <th width="10%">Discount (%)</th>
                            <th width="20%">Sub Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWO->workOrderDetails as $POD)
                            @if($POD->quantity > 0)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $POD->material->code }} - {{ $POD->material->name }}</td>
                                    <td>{{ number_format($POD->quantity) }}</td>
                                    <td>{{ number_format($POD->total_price / $POD->quantity,2) }}</td>
                                    <td>{{ number_format($POD->discount,2) }}</td>
                                    <td>{{ number_format($POD->total_price - ($POD->total_price * ($POD->discount/100)),2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
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
