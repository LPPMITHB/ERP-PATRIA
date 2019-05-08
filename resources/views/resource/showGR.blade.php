@extends('layouts.main')

@section('content-header')
@if($route == "/resource")
    @breadcrumb(
        [
            'title' => 'View Goods Receipt » '.$modelGR->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipts' => route('resource.indexReceived'),
                'View Goods Receipt' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/resource_repair")
    @breadcrumb(
        [
            'title' => 'View Goods Receipt » '.$modelGR->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipts' => route('resource_repair.indexReceived'),
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
                                    <div class="col-md-4 col-xs-4 no-padding"> Project Name</div>
                                    <div class="col-md-6 no-padding"> : <b> {{ isset($modelGR->purchaseOrder->project) ? $modelGR->purchaseOrder->project->name :  '-'}} </b></div>
                                
                                    <div class="col-md-4 col-xs-4 no-padding">PO Code</div>
                                    <div class="col-md-6 no-padding">: <b> {{ isset($modelGR->purchaseOrder->project) ? $modelGR->purchaseOrder->number : '-' }} </b></div>
                                
                                    <div class="col-md-4 col-xs-4 no-padding">Vendor Name</div>
                                    <div class="col-md-6 no-padding">: <b> {{ isset($modelGR->purchaseOrder->project) ? $modelGR->purchaseOrder->vendor->name : '-'}} </b></div>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                            <div class="box-header no-padding">
                                    <div class="box-body">
                                        <div class="col-md-4 col-xs-4 no-padding">Description</div>
                                        <div class="col-md-6 no-padding">: <b> {{ $modelGR->description }} </b></div>
                                    </div>
                            </div>
                    </div>
                </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <div class="row">
                        <table class="table table-bordered showTable tablePaging tableFixed">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="35%">Resource Name</th>
                                    <th width="35%">Operational Code</th>
                                    <th width="20%">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modelGRD as $GRD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $GRD->resourceDetail->resource->code }} - {{ $GRD->resourceDetail->resource->name }}</td>
                                    <td>{{ $GRD->resourceDetail->code }}</td>
                                    <td>
                                        @if($GRD->resourceDetail->category_id == 1)
                                            Sub Con
                                        @elseif($GRD->resourceDetail->category_id == 2)
                                            Others
                                        @elseif($GRD->resourceDetail->category_id == 3)
                                            External Equipment
                                        @elseif($GRD->resourceDetail->category_id == 4)
                                            Internal Equipment
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
