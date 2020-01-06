@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Quality Control Task Confirmation » Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('qc_task.selectProject'),
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Projects</h3>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered" id="projects-table">
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
                                <td class="p-l-5 p-r-5" align="center">
                                    @if($route == "/qc_task")
                                        <a class="btn btn-primary btn-xs" href="{{ route('qc_task.selectQcTask', ['id'=>$project->id]) }}">SELECT</a>
                                    @elseif($route == "/qc_task_repair")
                                        <a class="btn btn-primary btn-xs" href="{{ route('qc_task_repair.selectQcTask', ['id'=>$project->id]) }}">SELECT</a>
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
        $('#projects-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
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