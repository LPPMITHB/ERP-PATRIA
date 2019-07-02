@extends('layouts.main')

@section('content-header')
@if($route == "/production_order")
    @breadcrumb(
        [
            'title' => 'View All Production Order',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProjectIndex'),
                'View All Production Order' => route('production_order.indexPrO',$id),
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/production_order_repair")
    @breadcrumb(
        [
            'title' => 'View All Production Order',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProjectIndex'),
                'View All Production Order' => route('production_order_repair.indexPrO',$id),
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered tableFixed datatable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="25%">Project Name</th>
                            <th width="25%">Work Name</th>
                            <th width="20%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPrOs as $modelPrO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelPrO->number }}</td>
                                <td>{{ $modelPrO->project->name }}</td>
                                <td class="tdEllipsis">{{ $modelPrO->wbs->number }}</td>
                                @if($modelPrO->status == 1)
                                    <td class="tdEllipsis">{{ 'UNRELEASED' }}</td>
                                @elseif($modelPrO->status == 2)
                                    <td class="tdEllipsis">{{ 'RELEASED' }}</td>
                                @elseif($modelPrO->status == 0)
                                    <td class="tdEllipsis">{{ 'COMPLETED' }}</td>
                                @endif
                                <td class="textCenter">
                                    @if($route == "/production_order" && $modelPrO->status == 1 || $route == "/production_order" && $modelPrO->status == 2)
                                        <a href="{{route('production_order.show',$modelPrO->id)}}" class="btn btn-primary btn-xs">VIEW</a>
                                        <a href="{{route('production_order.editPrO',$modelPrO->id)}}" class="btn btn-primary btn-xs">EDIT</a>
                                    @elseif($route == "/production_order" && $modelPrO->status != 1)
                                        <a href="{{route('production_order.show',$modelPrO->id)}}" class="btn btn-primary btn-xs">VIEW</a>
                                    @elseif($route == "/production_order_repair" && $modelPrO->status == 1)
                                        <a href="{{route('production_order_repair.show',$modelPrO->id)}}" class="btn btn-primary btn-xs">VIEW</a>
                                        <a href="{{route('production_order_repair.editPrO',$modelPrO->id)}}" class="btn btn-primary btn-xs">EDIT</a>
                                    @elseif($route == "/production_order_repair" && $modelPrO->status != 1)
                                        <a href="{{route('production_order_repair.show',$modelPrO->id)}}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                </td>
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
        var pr_table = $('.datatable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });

    });
</script>
@endpush
