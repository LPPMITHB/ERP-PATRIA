@extends('layouts.main')

@section('content-header')
@if($menu == "create_pro")
    @breadcrumb(
        [
            'title' => 'Create Production Order » Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProject'),
            ]
        ]
    )
    @endbreadcrumb
@elseif($menu == "release_pro")
    @breadcrumb(
        [
            'title' => 'Release Production Order » Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProjectRelease'),
            ]
        ]
    )
    @endbreadcrumb
@elseif($menu == "confirm_pro")
    @breadcrumb(
        [
            'title' => 'Confirm Production Order » Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProjectConfirm'),
            ]
        ]
    )
    @endbreadcrumb
@elseif($menu == "report_pro")
    @breadcrumb(
        [
            'title' => 'Prod. Order Actual Cost Report » Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProjectReport'),
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
            <div class="box-header">
                <h3 class="box-title">List of Projects</h3>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Project Name</th>
                            <th width="40%">Customer</th>
                            <th width="25%">Ship</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelProject as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->customer->name }}</td>
                                <td>{{ $project->ship->type }}</td>
                                @if($menu == "create_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('production_order.selectWBS', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                @elseif($menu == "release_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('production_order.selectPrO', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                @elseif($menu == "confirm_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('production_order.confirmPrO', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                @elseif($menu == "report_pro")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('production_order.selectPrOReport', ['id'=>$project->id]) }}">SELECT</a>
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
