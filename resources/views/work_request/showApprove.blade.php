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
                            Ship Type
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ isset($modelWR->project) ? $modelWR->project->ship->type : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Customer Name
                        </div>
                        <div class="col-xs-7 col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ isset($modelWR->project) ?$modelWR->project->customer->name : ''}}">
                            : <b> {{ isset($modelWR->project) ? $modelWR->project->customer->name : '-'}} </b>
                        </div>
                    </div>
                    <div class="row">
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
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
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
                            : <b> {{ $modelWR->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        @if($modelWR->status != 6 && $modelWR->status != 1)
                            @if($modelWR->status == 2 || $modelWR->status == 0 || $modelWR->status == 7)
                                <div class="col-xs-5 col-md-5">
                                    Approved By
                                </div>
                            @elseif($modelWR->status == 3 || $modelWR->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Checked By
                                </div>
                            @elseif($modelWR->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Rejected By
                                </div>
                            @endif
                            <div class="col-xs-7 col-md-7 tdEllipsis">
                                : <b> {{ $modelWR->approvedBy->name }} </b>
                            </div>
                        @endif
                        @php
                            $approval_date = "";
                            if($modelWR->approval_date != NULL){
                                $approval_date = DateTime::createFromFormat('Y-m-d', $modelWR->approval_date);
                                $approval_date = $approval_date->format('d-m-Y');
                            }
                        @endphp
                        @if($modelWR->status == 2 || $modelWR->status == 0 || $modelWR->status == 7)
                            <div class="col-xs-5 col-md-5">
                                Approved Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date }}</b>
                            </div>
                        @elseif($modelWR->status == 5)
                            <div class="col-xs-5 col-md-5">
                                Rejected Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date }}</b>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered tableFixed showTable" id="wr-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Material Number</th>
                            <th width="15%">Material Description</th>
                            <th width="5%">Unit</th>
                            <th width="10%">Quantity</th>
                            <th width="23%">Work Name</th>
                            <th width="10%">Description</th>
                            <th width="12%">Type</th>
                            <th width="10%">Required Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWR->workRequestDetails as $WRD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$WRD->material->code}}">{{ $WRD->material->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$WRD->material->description}}">{{ $WRD->material->description }}</td>
                                <td>{{ $WRD->material->uom->unit }}</td>
                                <td>{{ number_format($WRD->quantity,2) }}</td>
                                @if(isset($WRD->wbs))
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $WRD->wbs->number }} - {{ $WRD->wbs->description }}">{{ $WRD->wbs->number }} - {{ $WRD->wbs->description }}</td>
                                @else
                                <td class="tdEllipsis">-</td>
                                @endif
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$WRD->description}}">{{$WRD->description}}</td>
                                <td>{{ ($WRD->type == 0) ? 'Raw Material' : 'Finished Goods' }}</td>
                                <td>{{ isset($WRD->required_date) ? date('d-m-Y', strtotime($WRD->required_date)) : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($modelWR->status == 1 || $modelWR->status == 4)
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                        @if($menu == "building")
                            <a class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" href="{{ route('work_request.approval', ['id'=>$modelWR->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" href="{{ route('work_request.approval', ['id'=>$modelWR->id,'status'=>'need-revision']) }}">REVISE</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" href="{{ route('work_request.approval', ['id'=>$modelWR->id,'status'=>'reject']) }}">REJECT</a>
                        @else
                            <a class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" href="{{ route('work_request_repair.approval', ['id'=>$modelWR->id,'status'=>'approve']) }}">APPROVE</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" href="{{ route('work_request_repair.approval', ['id'=>$modelWR->id,'status'=>'need-revision']) }}">REVISE</a>
                            <a class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" href="{{ route('work_request_repair.approval', ['id'=>$modelWR->id,'status'=>'reject']) }}">REJECT</a>
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
        // $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        // $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Cost per pcs" || title == "Sub Total Cost" || title == "Quantity"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( table.column(i).search() !== this.value ) {
        //             table
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var table = $('.tableNonPagingVue').DataTable( {
        //     orderCellsTop   : true,
        //     paging          : false,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : false,
        // });

        // $('div.overlay').hide();
        $('#wr-table').DataTable({
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
