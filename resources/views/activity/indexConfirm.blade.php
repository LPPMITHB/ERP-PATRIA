@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Confirm Activities » Select Project',
        'items' => [
            'Dashboard' => route('index'),
            'Projects' => route('activity.indexConfirm'),
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
                <table class="table table-bordered table-hover" id="project-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Code</th>
                            <th>Ship</th>
                            <th>Customer</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $project->number }}</td>
                                <td>{{ $project->ship->name }}</td>
                                <td>{{ $project->customer->name }}</td>
                                <td>{{ $project->planned_start_date}}</td>
                                <td>{{ $project->planned_end_date}}</td>
                                <td><a href="{{ route('activity.listWBS',['id'=>$project->id,'menu'=>'confirmAct']) }}" class="btn btn-primary btn-xs">SELECT</a></td>
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
