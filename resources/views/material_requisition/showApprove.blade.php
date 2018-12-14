@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Material Requisition » '.$modelMR->project->name,
        'items' => [
            'Dashboard' => route('index'),
            'View Material Requisition' => route('rap.show',$modelMR->id),
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
                            <span class="info-box-number">{{ $modelMR->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Project Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelMR->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Project Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelMR->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Customer Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelMR->project->customer->name }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Ship Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelMR->project->ship->type }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ship Type
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelMR->project->ship->type }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Created By
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelMR->user->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Created At
                        </div>
                        <div class="col-md-8">
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
                                <td>{{ $MRD->work->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12 p-b-10 p-r-0">
                    <button class="btn btn-primary pull-right m-l-10" >APPROVE</button>
                    <button class="btn btn-danger pull-right p-r-10" >NOT APPROVE</button>
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
