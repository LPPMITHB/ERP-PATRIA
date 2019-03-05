@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Material Requisition » '.$modelMR->project->name,
        'items' => [
            'Dashboard' => route('index'),
            'View Material Requisition' => route('material_requisition.show',$modelMR->id),
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
                        <div class="col-xs-7 col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelMR->project->customer->name}}">
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
                                : <b>APPROVED</b>
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
                <table class="table table-bordered showTable" id="details-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Material Desc.</th>
                            <th width="25%">Quantity</th>
                            <th width="30%">WBS Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelMR->MaterialRequisitionDetails as $MRD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $MRD->material->code }} - {{ $MRD->material->description }}</td>
                                <td>{{ number_format($MRD->quantity,2) }} {{ ($MRD->material->uom->unit) }}</td>
                                <td>{{ $MRD->wbs != null ? $MRD->wbs->number : "-" }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($menu == "building")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('material_requisition.print', ['id'=>$modelMR->id]) }}">DOWNLOAD</a>
                    @else
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('material_requisition_repair.print', ['id'=>$modelMR->id]) }}">DOWNLOAD</a>
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
        $('#details-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
