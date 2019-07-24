@extends('layouts.main')

@section('content-header')
@if($route == "/goods_receipt")
    @breadcrumb(
        [
            'title' => 'View Goods Receipt » '.$modelGR->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipts' => route('goods_receipt.index'),
                'View Goods Receipt' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_receipt_repair")
    @breadcrumb(
        [
            'title' => 'View Goods Receipt » '.$modelGR->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipts' => route('goods_receipt_repair.index'),
                'View Goods Receipt' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box box-blue">
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">GR Number</span>
                                <span class="info-box-number">{{ $modelGR->number }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                            <div class="box-header no-padding">
                                <div class="box-body">
                                    <div class="col-md-4 col-xs-4 no-padding">PO Number</div>
                                    <div class="col-md-6 no-padding">: <b> {{ isset($modelGR->purchaseOrder) ? $modelGR->purchaseOrder->number : '-' }} </b></div>

                                    <div class="col-md-4 col-xs-4 no-padding">Project Number</div>
                                    <div class="col-md-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelGR->purchaseOrder->project) ? $modelGR->purchaseOrder->project->number : '-'}}">: <b> {{ isset($modelGR->purchaseOrder->project) ? $modelGR->purchaseOrder->project->number : '-'}} </b></div>

                                    <div class="col-md-4 col-xs-4 no-padding">Vendor Name</div>
                                    <div class="col-md-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelGR->purchaseOrder) ? $modelGR->purchaseOrder->vendor->name : '-'}}">: <b> {{ isset($modelGR->purchaseOrder) ? $modelGR->purchaseOrder->vendor->name : '-'}} </b></div>

                                    <div class="col-md-4 col-xs-4 no-padding">Ship Date</div>
                                    <div class="col-md-6 no-padding">: <b> {{ isset($modelGR->ship_date) ? date('d-m-Y', strtotime($modelGR->ship_date)) : '-'}} </b></div>
                                    
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="box-header no-padding">
                            <div class="box-body">
                                @if ($modelGR->status == 2)
                                    <div class="col-md-4 col-xs-4 no-padding">Status</div>
                                    <div class="col-md-6 no-padding">: <b> REVERSED </b></div>
                                @endif
                                
                                <div class="col-md-4 col-xs-4 no-padding">Description</div>
                                <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelGR->description}}">: <b> {{ $modelGR->description }} </b></div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="box-body p-t-0">
                <div class="col-sm-12">
                    <div class="row">
                        <table class="table table-bordered showTable tablePaging tableFixed">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Material Number</th>
                                    <th width="20%">Material Description</th>
                                    <th width="5%">Unit</th>
                                    <th width="10%">Quantity</th>
                                    <th width="25%">Storage Location</th>
                                    <th width="15%">Received Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modelGRD as $GRD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $GRD->material->code }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$GRD->material->description}}">{{ $GRD->material->description }}</td>
                                    <td>{{ $GRD->material->uom->unit }}</td>
                                    <td>{{ number_format($GRD->quantity,2) }}</td>
                                    <td>{{ isset($GRD->storageLocation) ? $GRD->storageLocation->name : '-' }} </td>
                                    <td>{{ isset($GRD->received_date) ? date('d-m-Y', strtotime($GRD->received_date)) : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                            @if($route == "/goods_receipt")
                                <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_receipt.print', ['id'=>$modelGR->id]) }}">DOWNLOAD</a>
                            @elseif($route == "/goods_receipt_repair")
                                <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_receipt_repair.print', ['id'=>$modelGR->id]) }}">DOWNLOAD</a>
                            @endif
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
    </script>
@endpush
