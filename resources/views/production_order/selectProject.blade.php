@extends('layouts.main')

@section('content-header')
    @if($menu == "create_pro")
        @php($title = "Create Production Order » Select Project")
    @elseif($menu == "release_pro")
        @php($title = "Release Production Order » Select Project")
    @elseif($menu == "confirm_pro")
        @php($title = "Confirm Production Order » Select Project")
    @elseif($menu == "report_pro")
        @php($title = "Prod. Order Actual Cost Report » Select Project")
    @elseif($menu == "index_pro")
        @php($title = "View Production Order » Select Project")
    @endif
    @breadcrumb(
        [
            'title' => $title,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => '',
            ]
        ]
    )
    @endbreadcrumb
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
                            <th width="15%">Project Number</th>
                            <th width="30%">Customer</th>
                            <th width="20%">Ship Name</th>
                            <th width="20%">Ship Type</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelProject as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->number }}</td>
                                <td>{{ $project->customer->name }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->ship->type }}</td>
                                @if($menu == "create_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        @if($route == "/production_order")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order.selectWBS', ['id'=>$project->id]) }}">SELECT</a>
                                        @elseif($route == "/production_order_repair")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order_repair.selectWBS', ['id'=>$project->id]) }}">SELECT</a>
                                        @endif
                                    </td>
                                @elseif($menu == "release_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        @if($route == "/production_order")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order.selectPrO', ['id'=>$project->id]) }}">SELECT</a>
                                        @elseif($route == "/production_order_repair")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order_repair.selectPrO', ['id'=>$project->id]) }}">SELECT</a>
                                        @endif
                                    </td>
                                @elseif($menu == "confirm_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        @if($route == "/production_order")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order.confirmPrO', ['id'=>$project->id]) }}">SELECT</a>
                                        @elseif($route == "/production_order_repair")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order_repair.confirmPrO', ['id'=>$project->id]) }}">SELECT</a>
                                        @endif
                                    </td>
                                @elseif($menu == "report_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        @if($route == "/production_order")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order.selectPrOReport', ['id'=>$project->id]) }}">SELECT</a>
                                        @elseif($route == "/production_order_repair")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order_repair.selectPrOReport', ['id'=>$project->id]) }}">SELECT</a>
                                        @endif
                                    </td>
                                @elseif($menu == "index_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        @if($route == "/production_order")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order.indexPrO', ['id'=>$project->id]) }}">SELECT</a>
                                        @elseif($route == "/production_order_repair")
                                            <a class="btn btn-primary btn-xs" href="{{ route('production_order_repair.indexPrO', ['id'=>$project->id]) }}">SELECT</a>
                                        @endif
                                    </td>
                                @endif
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
