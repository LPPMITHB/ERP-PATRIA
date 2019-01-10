@extends('layouts.main')

@section('content-header')
@if($modelWR->project)
    @breadcrumb(
        [
            'title' => 'View Work Request »'.$modelWR->project->name,
            'items' => [
                'Dashboard' => route('index'),
                'View Work Request' => route('work_request.show',$modelWR->id),
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'View Work Request',
            'items' => [
                'Dashboard' => route('index'),
                'View Work Request' => route('work_request.show',$modelWR->id),
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
                            <span class="info-box-text">WR Number</span>
                            <span class="info-box-number">{{ $modelWR->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Project Number
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ isset($modelWR->project) ? $modelWR->project->number : '-'}} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Ship Name
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ isset($modelWR->project) ? $modelWR->project->name : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Ship Type
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ isset($modelWR->project) ? $modelWR->project->ship->type : '-' }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Customer Name
                        </div>
                        <div class="col-xs-7 col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelWR->project) ?$modelWR->project->customer->name : ''}}">
                            : <b> {{ isset($modelWR->project) ? $modelWR->project->customer->name : '-'}} </b>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            Status
                        </div>
                        @if($modelWR->status == 1)
                            <div class="col-xs-7 col-md-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelWR->status == 2)
                            <div class="col-xs-7 col-md-7">
                                : <b>APPROVED</b>
                            </div>
                        @elseif($modelWR->status == 3)
                            <div class="col-xs-7 col-md-7">
                                : <b>NEEDS REVISION</b>
                            </div>
                        @elseif($modelWR->status == 4)
                            <div class="col-xs-7 col-md-7">
                                : <b>REVISED</b>
                            </div>
                        @elseif($modelWR->status == 5)
                            <div class="col-xs-7 col-md-7">
                                : <b>REJECTED</b>
                            </div>
                        @elseif($modelWR->status == 0 || $modelWR->status == 7)
                            <div class="col-xs-7 col-md-7">
                                : <b>ORDERED</b>
                            </div>
                        @elseif($modelWR->status == 6)
                            <div class="col-xs-7 col-md-7">
                                : <b>CONSOLIDATED</b>
                            </div>
                        @endif
                        <div class="col-xs-5 col-md-5">
                            Created By
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelWR->user->name }} </b>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            Created At
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelWR->created_at }} </b>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWR->workRequestDetails as $WRD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $WRD->material->code }} - {{ $WRD->material->name }}</td>
                                <td>{{ number_format($WRD->quantity) }}</td>
                                <td>{{ isset($WRD->wbs) ? $WRD->wbs->name : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($modelWR->status == 1 || $modelWR->status == 4)
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                        <a class="btn btn-primary pull-right m-l-10" href="{{ route('work_request.approval', ['id'=>$modelWR->id,'status'=>'approve']) }}">APPROVE</a>
                        <a class="btn btn-danger pull-right m-l-10 p-r-10" href="{{ route('work_request.approval', ['id'=>$modelWR->id,'status'=>'need-revision']) }}">NEEDS REVISION</a>
                        <a class="btn btn-danger pull-right p-r-10" href="{{ route('work_request.approval', ['id'=>$modelWR->id,'status'=>'reject']) }}">REJECT</a>
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
