@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Purchase Requisition » '.$modelPR->project->name,
        'items' => [
            'Dashboard' => route('index'),
            'View Purchase Requisition' => route('purchase_requisition.show',$modelPR->id),
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
                            <span class="info-box-text">PR Number</span>
                            <span class="info-box-number">{{ $modelPR->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Project Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPR->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Project Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPR->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ship Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPR->project->ship->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ship Type
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPR->project->ship->type }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-5">
                            Customer Name
                        </div>
                        <div class="col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelPR->project->customer->name}}">
                            : <b> {{ $modelPR->project->customer->name }} </b>
                        </div>
                        <div class="col-md-5">
                            Status
                        </div>
                        @if($modelPR->status == 1)
                            <div class="col-md-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelPR->status == 2)
                            <div class="col-md-7">
                                : <b>CANCELED</b>
                            </div>
                        @else
                            <div class="col-md-7">
                                : <b>ORDERED</b>
                            </div>
                        @endif
                        <div class="col-md-5">
                            Created By
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelPR->user->name }} </b>
                        </div>
                        <div class="col-md-5">
                            Created At
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelPR->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered showTable" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Material Name</th>
                            <th width="25%">Quantity</th>
                            <th width="30%">Work Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPR->PurchaseRequisitionDetails as $PRD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $PRD->material->name }}</td>
                                <td>{{ number_format($PRD->quantity) }}</td>
                                <td>{{ $PRD->wbs->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        $('#boms-table').DataTable({
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
