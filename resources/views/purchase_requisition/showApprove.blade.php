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
            'title' => isset($modelPR->project) ? 'View Purchase Requisition - '.$type.' » '.$modelPR->project->number : 'View Purchase Requisition - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Requisition' => route('purchase_requisition.indexApprove'),
                'View Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_requisition_repair")
    @breadcrumb(
        [
            'title' => isset($modelPR->project) ? 'View Purchase Requisition - '.$type.' » '.$modelPR->project->number : 'View Purchase Requisition - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Requisition' => route('purchase_requisition_repair.indexApprove'),
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
                <div class="col-sm-3 col-md-3">
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
                <div class="col-sm-6 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Project Number
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ isset($modelPR->project) ? $modelPR->project->number : '-'}} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Ship Name
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ isset($modelPR->project) ? $modelPR->project->name : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Ship Type
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ isset($modelPR->project) ? $modelPR->project->ship->type : '-' }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Customer Name
                        </div>
                        <div class="col-xs-7 col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelPR->project) ?$modelPR->project->customer->name : ''}}">
                            : <b> {{ isset($modelPR->project) ? $modelPR->project->customer->name : '-'}} </b>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            Status
                        </div>
                        @if($modelPR->status == 1)
                            <div class="col-xs-7 col-md-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelPR->status == 2)
                            <div class="col-xs-7 col-md-7">
                                : <b>APPROVED</b>
                            </div>
                        @elseif($modelPR->status == 3)
                            <div class="col-xs-7 col-md-7">
                                : <b>NEEDS REVISION</b>
                            </div>
                        @elseif($modelPR->status == 4)
                            <div class="col-xs-7 col-md-7">
                                : <b>REVISED</b>
                            </div>
                        @elseif($modelPR->status == 5)
                            <div class="col-xs-7 col-md-7">
                                : <b>REJECTED</b>
                            </div>
                        @elseif($modelPR->status == 0 || $modelPR->status == 7)
                            <div class="col-xs-7 col-md-7">
                                : <b>ORDERED</b>
                            </div>
                        @elseif($modelPR->status == 6)
                            <div class="col-xs-7 col-md-7">
                                : <b>CONSOLIDATED</b>
                            </div>
                        @endif
                        <div class="col-xs-5 col-md-5">
                            Created By
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelPR->user->name }} </b>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            Created At
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelPR->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered showTable tableFixed tableNonPagingVue">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Material Name</th>
                            <th width="15%">Quantity</th>
                            <th width="30%">Work Name</th>
                            <th width="15%">Alocation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPR->PurchaseRequisitionDetails as $PRD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if($modelPR->type == 1)
                                    <td>{{ $PRD->material->code }} - {{ $PRD->material->name }}</td>
                                @else
                                    <td>{{ $PRD->resource->code }} - {{ $PRD->resource->name }}</td>
                                @endif
                                <td>{{ number_format($PRD->quantity) }}</td>
                                <td>{{ isset($PRD->wbs) ? $PRD->wbs->name : '-' }}</td>
                                <td>{{ isset($PRD->alocation) ? $PRD->alocation : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($modelPR->status == 1 || $modelPR->status == 4)
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                        @if($route == "/purchase_requisition")
                            <a class="btn btn-primary pull-right m-l-10" href="{{ route('purchase_requisition.approval', ['id'=>$modelPR->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="btn btn-danger pull-right m-l-10 p-r-10" href="{{ route('purchase_requisition.approval', ['id'=>$modelPR->id,'status'=>'need-revision']) }}">NEEDS REVISION</a>
                            <a class="btn btn-danger pull-right p-r-10" href="{{ route('purchase_requisition.approval', ['id'=>$modelPR->id,'status'=>'reject']) }}">REJECT</a>
                        @elseif($route == "/purchase_requisition_repair")
                            <a class="btn btn-primary pull-right m-l-10" href="{{ route('purchase_requisition_repair.approval', ['id'=>$modelPR->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="btn btn-danger pull-right m-l-10 p-r-10" href="{{ route('purchase_requisition_repair.approval', ['id'=>$modelPR->id,'status'=>'need-revision']) }}">NEEDS REVISION</a>
                            <a class="btn btn-danger pull-right p-r-10" href="{{ route('purchase_requisition_repair.approval', ['id'=>$modelPR->id,'status'=>'reject']) }}">REJECT</a>
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
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == "Cost per pcs" || title == "Sub Total Cost" || title == "Quantity"){
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
