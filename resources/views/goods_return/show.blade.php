@extends('layouts.main')

@section('content-header')
@if($route == "/goods_return")
    @breadcrumb(
        [
            'title' => 'View Goods Return » '.$modelGR->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Returns' => route('goods_return.index'),
                'View Goods Return' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_return_repair")
    @breadcrumb(
        [
            'title' => 'View Goods Return » '.$modelGR->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Returns' => route('goods_return_repair.index'),
                'View Goods Return' => '',
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

                            <div class="col-md-4 col-xs-4 no-padding">PR Number</div>
                            <div class="col-md-6 no-padding">: <b> {{ isset($modelGR->purchaseOrder->PurchaseRequisition->number) ? $modelGR->purchaseOrder->PurchaseRequisition->number : '-' }} </b></div>

                            <div class="col-md-4 col-xs-4 no-padding">PO Number</div>
                            <div class="col-md-6 no-padding">: <b> {{ isset($modelGR->purchaseOrder->project) ? $modelGR->purchaseOrder->number : '-' }} </b></div>

                            <div class="col-md-4 col-xs-4 no-padding">Vendor Name</div>
                            <div class="col-md-6 no-padding">: <b> {{ isset($modelGR->purchaseOrder->project) ? $modelGR->purchaseOrder->vendor->name : '-'}} </b></div>

                            <div class="col-md-4 col-xs-4 no-padding">Ship Date</div>
                            <div class="col-md-6 no-padding">: <b> {{ isset($modelGR->ship_date) ? date('d-m-Y', strtotime($modelGR->ship_date)) : '-'}} </b></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="box-header no-padding">
                        <div class="box-body">
                            <div class="col-md-4 col-xs-4 no-padding">Description</div>
                            <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelGR->description}}">: <b> {{ $modelGR->description }} </b></div>
                            @if($modelGR->status != 6 && $modelGR->status != 1)
                                @if($modelGR->status == 2 || $modelGR->status == 0 || $modelGR->status == 7)
                                    <div class="col-md-4 col-xs-4 no-padding">
                                        Approved By
                                    </div>
                                @elseif($modelGR->status == 3 || $modelGR->status == 5)
                                    <div class="col-md-4 col-xs-4 no-padding">
                                        Checked By
                                    </div>
                                @elseif($modelGR->status == 5)
                                    <div class="col-md-4 col-xs-4 no-padding">
                                        Rejected By
                                    </div>
                                @endif
                                <div class="col-md-8 col-xs-8 no-padding tdEllipsis">
                                    : <b> {{ $modelGR->approvedBy->name }} </b>
                                </div>
                            @endif
                            @php
                                $approval_date = "";
                                if($modelGR->approval_date != NULL){
                                    $approval_date = DateTime::createFromFormat('Y-m-d', $modelGR->approval_date);
                                    $approval_date = $approval_date->format('d-m-Y');
                                }
                            @endphp
                            @if($modelGR->status == 2 || $modelGR->status == 0 || $modelGR->status == 7)
                                <div class="col-md-4 col-xs-4 no-padding">
                                    Approved Date
                                </div>
                                <div class="col-md-8 col-xs-8 no-padding tdEllipsis">
                                    : <b>{{ $approval_date }}</b>
                                </div>
                            @elseif($modelGR->status == 5)
                                <div class="col-md-4 col-xs-4 no-padding">
                                    Rejected Date
                                </div>
                                <div class="col-md-8 col-xs-8 no-padding tdEllipsis">
                                    : <b>{{ $approval_date }}</b>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0">
                <div class="col-sm-12">
                    <div class="row">
                        <table class="table table-bordered tableFixed showTable" id="gr-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Material Number</th>
                                    <th width="30%">Material Description</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Unit</th>
                                    <th width="20%">Storage Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modelGRD as $GRD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $GRD->material->code }}</td>
                                    <td class="tdEllipsis">{{ $GRD->material->description }}</td>
                                    <td>{{ number_format($GRD->quantity,2) }}</td>
                                    <td>{{ $GRD->material->uom->unit }}</td>
                                    <td>{{ isset($GRD->storageLocation->name) ? $GRD->storageLocation->name : '-' }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                            @if($route == "/goods_return" && $modelGR->status == 2)
                                <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_return.print', ['id'=>$modelGR->id]) }}">DOWNLOAD</a>
                            @elseif($route == "/goods_return_repair" && $modelGR->status == 2)
                                <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_return_repair.print', ['id'=>$modelGR->id]) }}">DOWNLOAD</a>
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
            $('#gr-table').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                'initComplete': function(){
                    $('div.overlay').hide();
                }
            });
        });
    </script>
@endpush
