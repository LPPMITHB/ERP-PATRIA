@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Activity » '.$activity->code,
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$activity->work->project->code => route('project.show', ['id' => $activity->work->project->id]),
            'List of Activities' => route('project.indexActivities', ['id' => $activity->work->id]),
            'View Activity|'.$activity->code => ""
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <div class="col-sm-6">
                    <table>
                        <thead>
                            <th colspan="2">Activity Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$activity->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$activity->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$activity->description}}</b></td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$activity->progress}} %</b></td>
                            </tr>
                            <tr>
                                <td>WBS</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$activity->work->code}} - {{$activity->work->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$activity->progress}} %</b></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>

                <div class="col-sm-6">
                    <table class="m-t-20">
                        <tbody>
                            <tr>
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $activity->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $activity->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned Duration</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$activity->planned_duration}} Days</b></td>
                            </tr>
                            <tr>
                                <td>Actual Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $activity->actual_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Actual End Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $activity->actual_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Actual Duration</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$activity->actual_duration}} Days</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <h4 class="box-title">List of Predecessor Activities</h4>
                <table class="table table-bordered showTable tableFixed" id="activity-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">Activity Code</th>
                            <th width="30%">Activity Name</th>
                            <th width="30%">WBS</th>
                            <th width="10%">Progress</th>
                            <th width="5%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activityPredecessor as $activity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $activity->code }}</td>
                                <td>{{ $activity->name }}</td>
                                <td>{{$activity->work->code}} - {{$activity->work->name}}</td>
                                <td>{{$activity->progress}} %</td>
                                <td class="textCenter">
                                    @if($activity->status == 0)
                                        <i class='fa fa-check'></i>
                                    @else
                                       <i class='fa fa-times'></i>
                                    @endif   
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
        </div>
    </div>    
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#activity-table').DataTable({
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
