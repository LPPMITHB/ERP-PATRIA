@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Input Daily Man Hour » Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('daily_man_hour.selectProject'),
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
                <table class="table table-bordered tableFixed" id="project-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Project Name</th>
                            <th width="40%">Customer</th>
                            <th width="25%">Ship</th>
                            <th width="6%"></th>
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
                                    <a class="btn btn-primary btn-xs" href="{{ route('daily_man_hour.create', ['id'=>$project->id]) }}">SELECT</a>
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
