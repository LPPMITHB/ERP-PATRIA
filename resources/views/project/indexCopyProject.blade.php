@extends('layouts.main')

@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'View All Projects' => route('project.index'),
                'Select Project' => route('project.indexCopyProject'),
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'View All Projects' => route('project_repair.index'),
                'Select Project' => route('project_repair.indexCopyProject'),
            ]
        ]
    )
    @endbreadcrumb
@endif
<style>

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-hover tableFixed" id="project-table">
                    <thead>
                        <tr>
                            <th style="width: 15px">No</th>
                            <th>Code</th>
                            <th style="width: 15%">Ship Name</th>
                            <th style="width: 33%">Customer</th>
                            <th>Start Date</th>
                            <th>Progress</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->number}}">{{ $project->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->name}}">{{ $project->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}">{{ $project->customer->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->planned_start_date}}">{{ $project->planned_start_date}}</td>
                                <td>{{ $project->progress}} %</td>
                                <td class="p-l-0 p-r-0" align="center">
                                @if($menu == "building")
                                    <a href="{{ route('project.copyProject', ['id'=>$project->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                @else
                                    <a href="{{ route('project_repair.copyProject', ['id'=>$project->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
        $('#project-table').DataTable({
            "iDisplayLength": 16,
			"bPaginate"     : false,
            'paging'        : true,
            'lengthChange'  : false,
            'searching'     : false,
            'ordering'      : true,
            'info'          : true,
            'autoWidth'     : false,
            'initComplete'  : function(){
                $('div.overlay').remove();
            }
        });
        
    });
</script>
@endpush
