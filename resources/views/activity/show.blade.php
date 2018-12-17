@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Activity » '.$activity->code,
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$activity->wbs->project->number => route('project.show', ['id' => $activity->wbs->project->id]),
            'Select WBS' => route('activity.listWBS',['id'=>$activity->wbs->project->id,'menu'=>'viewAct']),
            'List of Activities' => route('activity.index', ['id' => $activity->wbs->id]),
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
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Activity Information</b></div>
                        
                        <div class="col-md-4 col-xs-6 no-padding">Code</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$activity->code}}</b></div>
                        
                        <div class="col-md-4 col-xs-6 no-padding">Name</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$activity->name}}"><b>: {{$activity->name}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Description</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$activity->description}}"><b>: {{$activity->description}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Progress</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$activity->progress}} %</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">WBS</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$activity->wbs->code}} - {{$activity->wbs->name}}"><b>: {{$activity->wbs->code}} - {{$activity->wbs->name}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Status</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$activity->status == 1 ? 'Open' : 'Done'}} </b></div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-lg-4 col-md-12 activityContinue">    
                    <div class="box-body">                        
                        <div class="col-md-5 col-xs-6 no-padding">Planned Start Date</div>
                        <div class="col-md-7 col-xs-6 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $activity->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>
    
                        <div class="col-md-5 col-xs-6 no-padding">Planned End Date</div>
                        <div class="col-md-7 col-xs-6 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $activity->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>
                        
                        <div class="col-md-5 col-xs-6 no-padding">Planned Duration</div>
                        <div class="col-md-7 col-xs-6 no-padding"><b>: {{$activity->planned_duration}}</b></div>

                        <div class="col-md-5 col-xs-6 no-padding">Actual Start Date</div>
                        <div class="col-md-7 col-xs-6 no-padding"><b>: @if($activity->actual_start_date != null)@php
                                $date = DateTime::createFromFormat('Y-m-d', $activity->actual_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            @else
                            -
                            @endif
                            </b>
                        </div>

                        <div class="col-md-5 col-xs-6 no-padding">Actual End Date</div>
                        <div class="col-md-7 col-xs-6 no-padding"><b>: @if($activity->actual_end_date != null)@php
                                $date = DateTime::createFromFormat('Y-m-d', $activity->actual_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            @else
                            -
                            @endif
                            </b>
                        </div>
                        
                        <div class="col-md-5 col-xs-6 no-padding">Actual Duration</div>
                        <div class="col-md-7 col-xs-6 no-padding"><b>: {{$activity->actual_duration}}</b></div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <h4 class="box-title">List of Predecessor Activities</h4>
                <table class="table table-bordered showTable tableFixed" id="activity-table">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th width="12%">Activity Code</th>
                            <th width="30%">Activity Name</th>
                            <th width="30%">WBS</th>
                            <th>Progress</th>
                            <th width="20px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activityPredecessor as $activity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $activity->code }}</td>
                                <td>{{ $activity->name }}</td>
                                <td>{{$activity->wbs->code}} - {{$activity->wbs->name}}</td>
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
        jQuery('#activity-table').wrap('<div class="dataTables_scroll" />');


    });
</script>
@endpush
