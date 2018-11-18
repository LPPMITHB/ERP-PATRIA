@extends('layouts.main')

@section('content-header')
    @if($menu == "view_rab")
        @breadcrumb(
            [
                'title' => 'View RAP » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('rab.indexSelectProject'),
                ]
            ]
        )
        @endbreadcrumb
    @elseif($menu == "create_cost")
        @breadcrumb(
            [
                'title' => 'Create Cost » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('rab.selectProjectCost'),
                ]
            ]
        )
        @endbreadcrumb
    @elseif($menu == "assign_cost")
        @breadcrumb(
            [
                'title' => 'Assign Cost » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('rab.selectProjectAssignCost'),
                ]
            ]
        )
        @endbreadcrumb
    @elseif($menu == "view_planned_cost")
        @breadcrumb(
            [
                'title' => 'View Planned Cost » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('rab.selectProjectViewCost'),
                ]
            ]
        )
        @endbreadcrumb
    @elseif($menu == "view_rm")
        @breadcrumb(
            [
                'title' => 'View Remaining Material » Select Project',
                'items' => [
                    'Dashboard' => route('index'),
                    'Select Project' => route('rab.selectProjectViewRM'),
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
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->customer->name }}</td>
                                <td>{{ $project->ship->name }}</td>
                                @if($menu == "create_rab")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('rab.create', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                @elseif($menu == "view_rab")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('rab.index', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                @elseif($menu == "create_cost")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('rab.createCost', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                @elseif($menu == "assign_cost")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('rab.assignCost', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                @elseif($menu == "view_planned_cost")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('rab.viewPlannedCost', ['id'=>$project->id]) }}">SELECT</a>
                                    </td>
                                @elseif($menu == "view_rm")
                                    <td class="p-l-5 p-r-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="{{ route('rab.selectWBS', ['id'=>$project->id]) }}">SELECT</a>
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
