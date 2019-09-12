@extends('layouts.main')

@section('content-header')
@breadcrumb([
    'title' => 'View All Quality Control Task',
    'subtitle' => '',
    'items' => [
        'Dashboard' => route('index'),
        'View All Quality Control Task' => '',
    ]
])
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12 col-lg-4 col-md-12">
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
            
                        <div class="col-md-3 col-xs-4 no-padding">Code</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
            
                        <div class="col-md-3 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>
            
                        <div class="col-md-3 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip"
                            title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>
            
                        <div class="col-md-3 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>:
                                @if($project->planned_start_date != null)
                                @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                                @endphp
                                @else
                                -
                                @endif
                            </b>
                        </div>
            
                        <div class="col-md-3 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>:
                                @if($project->planned_end_date != null)
                                @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                                @endphp
                                @else
                                -
                                @endif
                            </b>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <table id="qctask-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="45%">Description</th>
                            <th width="30%">WBS</th>
                            <th width="10%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelQcTasks as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->description }}</td>
                                <td>{{ $data->wbs->number }} - {{ $data->wbs->description }}</td>
                                @if ($data->status == 1)
                                    <td>NOT DONE</td>
                                @else
                                    <td>DONE</td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('qc_task.show',$data->id) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('qc_task.edit',$data->id) }}" class="btn btn-primary btn-xs">EDIT</a>
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
    $('div.overlay').hide();

    $(document).ready(function() {
        $('#qctask-table').DataTable({
            'paging': true,
            'lengthChange': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'bFilter': true,
            'initComplete': function() {
                $('div.overlay').hide();
            }
        });
    });

    function loading() {
        $('div.overlay').show();
    }
</script>
@endpush