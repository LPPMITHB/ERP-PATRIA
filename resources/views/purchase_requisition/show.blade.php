@extends('layouts.main')

@section('content-header')
@if($modelPR->type == 1)
    @php($type = 'Material')
@else  
    @php($type = 'Resource')
@endif
@if($route == "/purchase_requisition")
    @breadcrumb(
        [
            'title' => 'View Purchase Requisition - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Requisition' => route('purchase_requisition.index'),
                'View Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_requisition_repair")
    @breadcrumb(
        [
            'title' => 'View Purchase Requisition - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Requisition' => route('purchase_requisition_repair.index'),
                'View Purchase Requisition' => '',
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
                <div class="col-sm-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">PR Number</span>
                            <span class="info-box-number">{{ $modelPR->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            Status
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b>{{ $status }}</b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Created By
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelPR->user->name }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Created At
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelPR->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="col-xs-4 col-md-4">
                        Description
                    </div>
                    <div class="col-xs-8 col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelPR->description}}">
                        : <b> {{ ($modelPR->description != "") ? $modelPR->description : '-' }} </b>
                    </div>
                    @if($modelPR->status != 6 && $modelPR->status != 1)
                        @if($modelPR->status == 2 || $modelPR->status == 0 || $modelPR->status == 7)
                            <div class="col-xs-4 col-md-4">
                                Approved By
                            </div>
                        @elseif($modelPR->status == 3 || $modelPR->status == 4)
                            <div class="col-xs-4 col-md-4">
                                Checked By
                            </div>
                        @elseif($modelPR->status == 5)
                            <div class="col-xs-4 col-md-4">
                                Rejected By
                            </div>
                        @endif
                        <div class="col-xs-8 col-md-8 tdEllipsis">
                            : <b> {{ $modelPR->approvedBy->name }} </b>
                        </div>
                    @endif
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                @if($modelPR->type != 3)
                    <table class="table table-bordered showTable tableFixed tableNonPagingVue">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                @if($modelPR->type == 1)
                                    <th width="20%">Material Number</th>
                                    <th width="25%">Material Description</th>
                                @else
                                    <th width="20%">Resource Number</th>
                                    <th width="25%">Resource Description</th>
                                @endif
                                <th width="8%">Qty</th>
                                <th width="7%">Unit</th>
                                <th width="14%">Project Number</th>
                                <th width="13%">Required Date</th>
                                <th width="10%">Allocation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelPR->PurchaseRequisitionDetails as $PRD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if($modelPR->type == 1)
                                        <td class="tdEllipsis">{{ $PRD->material->code }}</td>
                                        <td class="tdEllipsis">{{ $PRD->material->description }}</td>
                                    @else
                                        <td class="tdEllipsis">{{ $PRD->resource->code }}</td>
                                        <td class="tdEllipsis">{{ $PRD->resource->name }}</td>
                                    @endif
                                    <td>{{ number_format($PRD->quantity,2) }}</td>
                                    @if($modelPR->type == 1)
                                        <td>{{ $PRD->material->uom->unit}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td class="tdEllipsis">{{ isset($PRD->project) ? $PRD->project->number : '-' }}</td>
                                    <td>{{ isset($PRD->required_date) ? date('d-m-Y', strtotime($PRD->required_date)) : '-' }}</td>
                                    <td>{{ isset($PRD->alocation) ? $PRD->alocation : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif($modelPR->type == 3)
                    <table class="table table-bordered showTable tableFixed tableNonPagingVue">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Project Number</th>
                                <th width="25%">WBS</th>
                                <th width="40%">Job Order</th>
                                <th width="15%">Vendor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelPR->PurchaseRequisitionDetails as $PRD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $PRD->project->number}}</td>
                                    <td>{{ $PRD->wbs->number}} - {{ $PRD->wbs->description}}</td>
                                    <td>{{ $PRD->activityDetail->serviceDetail->service->name}} - {{ $PRD->activityDetail->serviceDetail->name}}</td>
                                    <td class="tdEllipsis">{{ isset($PRD->vendor) ? $PRD->vendor->name : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($route == "/purchase_requisition")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('purchase_requisition.print', ['id'=>$modelPR->id]) }}">DOWNLOAD</a>
                    @elseif($route == "/purchase_requisition_repair")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('purchase_requisition_repair.print', ['id'=>$modelPR->id]) }}">DOWNLOAD</a>
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
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == "Cost per pcs" || title == "Sub Total Cost" || title == "Qty" || title == "Unit"){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            });
        });

        var table = $('.tableNonPagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : false,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
        });
        
        $('div.overlay').hide();
    });
</script>
@endpush
