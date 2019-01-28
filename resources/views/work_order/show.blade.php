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
                <div class="col-xs-12 col-lg-4 col-md-12 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Project Number
                        </div>
                        <div class="col-md-6 col-xs-8">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->number : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Ship Name
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->name : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Ship Type
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ isset($modelWO->project) ? $modelWO->project->ship->type : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Ref Number
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelWO->workRequest->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Total Price
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ number_format($modelWO->total_price,2) }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 no-padding">
                            Required Date
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelWO->required_date }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4 col-md-12 m-t-10 m-l-10">
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
                        <div class="col-md-7 col-xs-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelWO->vendor->code }} - {{ $modelWO->vendor->name }}">
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
                        <div class="col-md-7 col-xs-8">
                            : <b> {{ $modelWO->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered tableFixed showTable" id="boms-table">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="25%">Material Name</th>
                            <th width="30%">Description</th>
                            <th width="5%">Qty</th>
                            <th width="13%">Price / pcs</th>
                            <th width="6%">Disc (%)</th>
                            <th width="15%">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWO->workOrderDetails as $WOD)
                            @if($WOD->quantity > 0)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $WOD->material->code }} - {{ $WOD->material->name }}">{{ $WOD->material->code }} - {{ $WOD->material->name }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$WOD->workRequestDetail->description}}">{{ $WOD->workRequestDetail->description }}</td>
                                    <td>{{ number_format($WOD->quantity) }}</td>
                                    <td>{{ number_format($WOD->total_price / $WOD->quantity,2) }}</td>
                                    <td>{{ number_format($WOD->discount,2) }}</td>
                                    <td>{{ number_format($WOD->total_price - ($WOD->total_price * ($WOD->discount/100)),2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($menu == "building")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('work_order.print', ['id'=>$modelWO->id]) }}">DOWNLOAD</a>
                    @else
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
        $('div.overlay').remove();
    });
</script>
@endpush
