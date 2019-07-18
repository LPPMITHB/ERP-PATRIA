@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Goods Issue » '.$modelGI->number,
        'items' => [
            'Dashboard' => route('index'),
            'View Goods Issue' => route('purchase_order.show',$modelGI->id),
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
                            : <b> {{ isset($modelGI->materialRequisition->project) ? $modelGI->materialRequisition->project->name : '-'}} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            MR Number
                        </div>
                        <div class="col-md-8">
                            @if(isset($modelGI->materialRequisition))
                                @if($route == "/goods_issue")
                                    : <a href="{{ route('material_requisition.show', ['id'=>$modelGI->materialRequisition->id]) }}" class="text-primary"><b>{{$modelGI->materialRequisition->number}}</b></a>
                                @else
                                    : <a href="{{ route('material_requisition_repair.show', ['id'=>$modelGI->materialRequisition->id]) }}" class="text-primary"><b>{{$modelGI->materialRequisition->number}}</b></a>
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Type
                        </div>
                        <div class="col-md-8">
                            @if($modelGI->type == 1)
                            : <b> MR Transaction </b>
                            @elseif($modelGI->type == 2)
                            : <b>  Resource Transaction </b>
                            @elseif($modelGI->type == 3)
                            : <b>  PI Transaction </b>
                            @elseif($modelGI->type == 4)
                            : <b>  Goods Return </b>
                            @else
                            : <b> Material Write Off </b>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">Issue Date</div>
                        <div class="col-md-6">: <b> {{ isset($modelGI->issue_date) ? date('d-m-Y', strtotime($modelGI->issue_date)) : '-'}} </b></div>
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
                            <th width="15%">Material Number</th>
                            <th width="20%">Material Description</th>
                            <th width="25%">Picked Quantity</th>
                            <th width="5%">Unit</th>
                            <th width="30%">Storage Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelGID as $GID)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $GID->material->code }}</td>
                            <td>{{ $GID->material->description }}</td>
                            <td>{{ number_format($GID->quantity,2) }}</td>
                            <td>{{ $GID->material->uom->unit }}</td>
                            <td>{{ $GID->storageLocation != null ? $GID->storageLocation->name : "-" }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($approve)
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                        <a class="btn btn-primary pull-right m-l-10" href="{{ route('goods_issue.approval', ['id'=>$modelGI->id,'status'=>'approve']) }}">APPROVE</a>
                        {{-- <a class="btn btn-danger pull-right m-l-10 p-r-10" href="{{ route('goods_issue.approval', ['id'=>$modelGI->id,'status'=>'need-revision']) }}">REVISE</a> --}}
                        <a class="btn btn-danger pull-right p-r-10" href="{{ route('goods_issue.approval', ['id'=>$modelGI->id,'status'=>'reject']) }}">REJECT</a>
                    </div>
                @else
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                        @if($route == "/goods_issue")
                            <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_issue.print', ['id'=>$modelGI->id]) }}">DOWNLOAD</a>
                        @elseif($route == "/goods_issue_repair")
                            <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_issue_repair.print', ['id'=>$modelGI->id]) }}">DOWNLOAD</a>
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
        $('#gi-table').DataTable({
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
