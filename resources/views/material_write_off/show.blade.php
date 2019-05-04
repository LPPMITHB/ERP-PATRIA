@extends('layouts.main')

@section('content-header')
@if($route == "/material_write_off")
    @breadcrumb(
        [
            'title' => 'View Material Write Off » '.$modelMWO->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Material Write Off' => route('material_write_off.show',$modelMWO->id),
                'View Material Write Off' => route('purchase_order.show',$modelMWO->id),
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/material_write_off_repair")
    @breadcrumb(
        [
            'title' => 'View Material Write Off » '.$modelMWO->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Material Write Off' => route('material_write_off_repair.show',$modelMWO->id),
                'View Material Write Off' =>'',
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
                            <span class="info-box-text">MWO Number</span>
                            <span class="info-box-number">{{ $modelMWO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="box-header p-t-0 p-b-0">
                    <div class="col-sm-4 col-md-4 m-t-10">
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Type
                            </div>
                            <div class="col-md-8">
                                @if($modelMWO->type == 1)
                                : <b> MR Transaction </b>
                                @elseif($modelMWO->type == 2)
                                : <b>  Resource Transaction </b>
                                @elseif($modelMWO->type == 3)
                                : <b>  PI Transaction </b>
                                @elseif($modelMWO->type == 4)
                                : <b>  Goods Return </b>
                                @else
                                : <b> Material Write Off </b>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Status
                            </div>
                            <div class="col-md-8">
                                @if($modelMWO->status == 0)
                                : <b> ISSUED </b>
                                @elseif($modelMWO->status == 1)
                                : <b>  OPEN </b>
                                @elseif($modelMWO->status == 2)
                                : <b>  APPROVED </b>
                                @elseif($modelMWO->status == 3)
                                : <b>  NEED REVISION </b>
                                @elseif($modelMWO->status == 4)
                                : <b> REVISED </b>
                                @elseif($modelMWO->status == 5)
                                : <b> REJECTED </b>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 m-t-10">
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                    Description
                                </div>
                            <div class="col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelMWO->description}}">
                                    : <b> {{ $modelMWO->description }} </b>
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
                            <th width="20%">Material Number</th>
                            <th width="30%">Material Description</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Unit</th>
                            <th width="20%">Storage Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelMWOD as $MWO)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $MWO->material->code }}</td>
                            <td>{{ $MWO->material->description }}</td>
                            <td>{{ number_format($MWO->quantity,2) }}</td>
                            <td>{{ $MWO->material->uom->unit }}</td>
                            <td>{{ $MWO->storageLocation != null ? $MWO->storageLocation->name : "-" }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($route == "/material_write_off")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_issue.print', ['id'=>$modelMWO->id]) }}">DOWNLOAD</a>
                    @elseif($route == "/material_write_off_repair")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_issue_repair.print', ['id'=>$modelMWO->id]) }}">DOWNLOAD</a>
                    @endif
                </div> --}}
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
