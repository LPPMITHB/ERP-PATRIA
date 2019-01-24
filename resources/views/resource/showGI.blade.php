@extends('layouts.main')

@section('content-header')
@if($route == "/resource")
    @breadcrumb(
        [
            'title' => 'View Goods Issue » '.$modelGI->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Issue' => route('resource.indexIssued'),
                'View Goods Issue' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/resource_repair")
    @breadcrumb(
        [
            'title' => 'View Goods Issue » '.$modelGI->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Issue' => route('resource_repair.indexIssued'),
                'View Goods Issue' => '',
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
                            <span class="info-box-text">GI Number</span>
                            <span class="info-box-number">{{ $modelGI->number }}</span>
                        </div>
                    </div>
                </div>
            <div class="box-header p-t-0 p-b-0">
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Ship Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ isset($modelGI->materialRequisition) ? $modelGI->materialRequisition->project->name : '-'}} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            MR Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ isset($modelGI->materialRequisition) ? $modelGI->materialRequisition->number : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Type
                        </div>
                        <div class="col-md-8">
                            @if($modelGI->type == 0)
                            : <b> Automatic </b>
                            @elseif($modelGI->type == 1)
                            : <b>  Manual </b>
                            @elseif($modelGI->type == 2)
                            : <b>  Resource </b>
                            @elseif($modelGI->type == 4)
                            : <b>  Goods Return </b>
                            @else
                            : <b> Material Write Off </b>
                            @endif
                        </div>
                    </div>
                    
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                                Description
                            </div>
                        <div class="col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelGI->description}}">
                                : <b> {{ $modelGI->description }} </b>
                            </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="box-body">
                <table class="table table-bordered showTable" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Resource Name</th>
                            <th width="25%">Quantity</th>
                            <th width="30%">Storage Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelGID as $GID)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ "[".$GID->resourceDetail->code."] ".$GID->resourceDetail->brand }}</td>
                            <td>{{ number_format($GID->quantity) }}</td>
                            <td>{{ $GID->storageLocation != null ? $GID->storageLocation->name : "-" }} </td>
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
        $('#gi-table').DataTable({
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
