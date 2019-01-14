@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Material Requisition » '.$modelMR->project->name,
        'items' => [
            'Dashboard' => route('index'),
            'View Purchase Requisition' => route('purchase_requisition.show',$modelMR->id),
        ]
    ]
)
@endbreadcrumb
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
                            <span class="info-box-text">MR Number</span>
                            <span class="info-box-number">{{ $modelMR->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Project Number
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelMR->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Ship Name
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelMR->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Ship Type
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelMR->project->ship->type }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Customer Name
                        </div>
                        <div class="col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelMR->project->customer->name}}">
                            : <b> {{ $modelMR->project->customer->name }} </b>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            Status
                        </div>
                        @if($modelMR->status == 1)
                            <div class="col-xs-7 col-md-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelMR->status == 2)
                            <div class="col-xs-7 col-md-7">
                                : <b>APPROVE</b>
                            </div>
                        @elseif($modelMR->status == 3)
                            <div class="col-xs-7 col-md-7">
                                : <b>NEEDS REVISION</b>
                            </div>
                        @elseif($modelMR->status == 4)
                            <div class="col-xs-7 col-md-7">
                                : <b>REVISED</b>
                            </div>
                        @elseif($modelMR->status == 5)
                            <div class="col-xs-7 col-md-7">
                                : <b>REJECTED</b>
                            </div>
                        @elseif($modelMR->status == 0)
                            <div class="col-xs-7 col-md-7">
                                : <b>ISSUED</b>
                            </div>
                        @endif
                        <div class="col-xs-5 col-md-5">
                            Created By
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelMR->user->name }} </b>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            Created At
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelMR->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered showTable tableFixed tableNonPagingVue">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Material Name</th>
                            <th width="25%">Quantity</th>
                            <th width="30%">Work Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelMR->MaterialRequisitionDetails as $MRD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $MRD->material->name }}</td>
                                <td>{{ number_format($MRD->quantity) }}</td>
                                <td>{{ $MRD->wbs != null ? $MRD->wbs->name : "-" }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($modelMR->status == 1 || $modelMR->status == 4)
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                        @if($menu == "building")
                            <a class="btn btn-primary pull-right m-l-10" href="{{ route('material_requisition.approval', ['id'=>$modelMR->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="btn btn-danger pull-right m-l-10 p-r-10" href="{{ route('material_requisition.approval', ['id'=>$modelMR->id,'status'=>'need-revision']) }}">REVISE</a>
                            <a class="btn btn-danger pull-right p-r-10" href="{{ route('material_requisition.approval', ['id'=>$modelMR->id,'status'=>'reject']) }}">REJECT</a>
                        @else
                            <a class="btn btn-primary pull-right m-l-10" href="{{ route('material_requisition_repair.approval', ['id'=>$modelMR->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="btn btn-danger pull-right m-l-10 p-r-10" href="{{ route('material_requisition_repair.approval', ['id'=>$modelMR->id,'status'=>'need-revision']) }}">REVISE</a>
                            <a class="btn btn-danger pull-right p-r-10" href="{{ route('material_requisition_repair.approval', ['id'=>$modelMR->id,'status'=>'reject']) }}">REJECT</a>
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
