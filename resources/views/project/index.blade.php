@extends('layouts.main')

@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'View All Projects',
            'items' => [
                'Dashboard' => route('index'),
                'View All Projects' => route('project.index'),
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'View All Projects',
            'items' => [
                'Dashboard' => route('index'),
                'View All Projects' => route('project_repair.index'),
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
            <div class="box-header m-b-10">
                <div class="box-tools pull-right p-t-5">
                    @if($menu == "building")
                        <a href="{{ route('project.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    @else
                        <a href="{{ route('project_repair.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    @endif
                </div>
            </div> <!-- /.box-header -->
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
                                <td>{{ $project->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}">{{ $project->ship->type }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}">{{ $project->customer->name }}</td>
                                <td>{{ $project->planned_start_date}}</td>
                                <td>{{ $project->progress}} %</td>
                                @if($menu == "building")
                                    <td class="p-l-0 p-r-0" align="center"><a href="{{ route('project.show', ['id'=>$project->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('project.edit',['id'=>$project->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                @else
                                    <td class="p-l-0 p-r-0" align="center"><a href="{{ route('project_repair.show', ['id'=>$project->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('project_repair.edit',['id'=>$project->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
