@extends('layouts.main')

@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'View All Projects',
            'items' => [
                'Dashboard' => route('index'),
                'View All Projects' => route('wbs.selectProject'),
            ]
        ]
    )
    @endbreadcrumb
@else
    {{-- @breadcrumb(
        [
            'title' => 'View All Projects',
            'items' => [
                'Dashboard' => route('index'),
                'View All Projects' => route('project_repair.index'),
            ]
        ]
    )
    @endbreadcrumb --}}
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
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{date("d-m-Y", strtotime($project->planned_start_date))}}">{{date("d-m-Y", strtotime($project->planned_start_date))}}</td>
                                <td>{{ $project->progress}} %</td>
                                @if($menu == "building")
                                <td class="p-l-5 p-r-5" align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('wbs.manageWbsImages', ['id'=>$project->id]) }}">SELECT</a>
                                </td>
                                @else
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
