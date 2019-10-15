@extends('layouts.main')

@section('content-header')
    @if ($menu == "building")
        @breadcrumb(
            [
                'title' => 'Show Project » '.$project->businessUnit->name.' » '.$project->name." (".$project->person_in_charge.")",
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Projects' => route('project.index'),
                    'Project' => route('project.show', ['id' => $project->id]),
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [
                'title' => 'Show Project » '.$project->businessUnit->name.' » '.$project->name." (".$project->person_in_charge.")",
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Projects' => route('project_repair.index'),
                    'Project' => route('project_repair.show', ['id' => $project->id]),
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection

@section('content')
<div class="row">
    @if ($menu == "building")
        <div class="box-tools pull-left m-l-15">
            <a href="{{ route('project.showGanttChart',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 ">VIEW GANTT CHART</a>
            <a href="{{ route('wbs.createWBS',['id'=>$project->id]) }}" class="btn btn-primary btn-sm mobile_button_view m-t-5 ">MANAGE WBS</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'viewWbs']) }}" class="btn btn-primary btn-sm m-t-5 mobile_button_view">VIEW WBS</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'addAct']) }}" class="btn btn-primary btn-sm mobile_button_view m-t-5 ">MANAGE ACTIVITIES</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'viewAct']) }}" class="btn btn-primary btn-sm m-t-5 ">VIEW ACTIVITIES</a>
            <a href="{{ route('activity.manageNetwork',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 mobile_button_view">MANAGE NETWORK</a>
            <a href="{{ route('project.projectCE',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 mobile_device_potrait">
                @if($is_pami)
                    PROJECT COST MONITORING
                @else
                    PROJECT COST EVALUATION
                @endif
                </a>
        </div>
    @else
        <div class="box-tools pull-left m-l-15">
            <a href="{{ route('project_repair.showGanttChart',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 ">VIEW GANTT CHART</a>
            <a href="{{ route('wbs_repair.createWBS',['id'=>$project->id]) }}" class="btn btn-primary btn-sm mobile_button_view m-t-5 ">MANAGE WBS</a>
            <a href="{{ route('project_repair.listWBS',['id'=>$project->id,'menu'=>'viewWbs']) }}" class="btn btn-primary btn-sm m-t-5 mobile_button_view">VIEW WBS</a>
            <a href="{{ route('project_repair.listWBS',['id'=>$project->id,'menu'=>'addAct']) }}" class="btn btn-primary btn-sm mobile_button_view m-t-5 ">EDIT ACTIVITIES</a>
            <a href="{{ route('project_repair.listWBS',['id'=>$project->id,'menu'=>'viewAct']) }}" class="btn btn-primary btn-sm m-t-5 ">VIEW ACTIVITIES</a>
            <a href="{{ route('activity_repair.manageNetwork',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 mobile_button_view">MANAGE NETWORK</a>
            <a href="{{ route('project_repair.projectCE',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 mobile_device_potrait">
                @if($is_pami)
                    PROJECT COST MONITORING
                @else
                    PROJECT COST EVALUATION
                @endif
            </a>
        </div>
    @endif
</div>
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="col-xs-12 col-lg-4 col-md-12">
                    <div class="box-body">
                        <div class="col-md-4 col-xs-6 no-padding">Project Code</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->number}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Ship Name</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->name}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Ship Type</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->ship->type}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Hull Number</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->hull_number}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Customer Name</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Description</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->description}}"><b>: {{isset($project->description) ? $project->description : '-'}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Status</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->status == 1 ? "OPEN" : "CLOSED" }}</b></div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3 col-md-12">
                    <div class="box-body">
                        <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Planned Start Date</div>
                        <div class="col-md-8 col-lg-5 col-xs-6 no-padding"><b>:
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

                        <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Planned End Date</div>
                        <div class="col-md-8 col-lg-5 col-xs-6 no-padding"><b>:
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

                        <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Planned Duration</div>
                        <div class="col-md-8 col-lg-5 col-xs-6 no-padding"><b>: {{$project->planned_duration}}</b></div>

                        <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Actual Start Date</div>
                        <div class="col-md-8 col-lg-5 col-xs-6 no-padding" id="project-actual_start_date"><b>: @php
                                if($project->actual_start_date){
                                    $date = DateTime::createFromFormat('Y-m-d', $project->actual_start_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                } else{
                                    echo "-";
                                }
                                @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Actual End Date</div>
                        <div class="col-md-8 col-lg-5 col-xs-6 no-padding"><b>: @php
                                if($project->actual_end_date){
                                    $date = DateTime::createFromFormat('Y-m-d', $project->actual_end_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                } else{
                                    echo "-";
                                }
                                @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Actual Duration</div>
                        <div class="col-md-8 col-lg-5 col-xs-6 no-padding"><b>: {{$project->actual_duration != null ? $project->actual_duration : '-' }}</b></div>

                        @if($menu == "repair")
                            <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Arrival Date</div>
                            <div class="col-md-8 col-lg-5 col-xs-6 no-padding"><b>: @php
                                if($project->arrival_date){
                                    $date = DateTime::createFromFormat('Y-m-d', $project->arrival_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                } else{
                                    echo "-";
                                }
                                @endphp</b></div>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4 col-md-12">
                    <div class="box-body">
                        <div class="col-md-4 col-xs-6 no-padding">Sales Order</div>
                        @if($menu == "building")
                            <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{($project->salesOrder) ? $project->salesOrder->number : null}}"><a href="{{ route('sales_order.show',['id'=>$project->sales_order_id]) }}" target="_blank"><b>: {{($project->salesOrder) ? $project->salesOrder->number : null}}</b></a></div>
                        @elseif($menu == "repair")
                            <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{($project->salesOrder) ? $project->salesOrder->number : null}}"><a href="{{ route('sales_order_repair.show',['id'=>$project->sales_order_id]) }}" target="_blank"><b>: {{($project->salesOrder) ? $project->salesOrder->number : null}}</b></a></div>
                        @endif

                        <div class="col-md-4 col-xs-6 no-padding">Owner CP</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->contact_name}} | {{$project->customer->phone_number_1}}"><b>: {{$project->customer->contact_name}} | {{$project->customer->phone_number_1}}</b></div>

                        @if($menu == "building")
                            <div class="col-md-4 col-xs-6 no-padding">Flag</div>
                            <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->flag}}</b></div>

                            <div class="col-md-4 col-xs-6 no-padding">Class Name</div>
                            <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->class_name}}</b></div>

                            <div class="col-md-4 col-xs-6 no-padding">Class CP Name</div>
                            <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->class_contact_person_name}}</b></div>

                            <div class="col-md-4 col-xs-6 no-padding">Class CP Phone</div>
                            <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->class_contact_person_phone}}</b></div>

                            <div class="col-md-4 col-xs-6 no-padding">Class CP Email</div>
                            <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->class_contact_person_email}}"><b>: {{$project->class_contact_person_email}}</b></div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-1 col-md-12 col-xs-12">
                    @can('edit-project')
                        @if($menu == "building")
                            <a href="{{ route('project.edit',['id'=>$project->id]) }}" class="btn btn-primary btn-sm col-xs-12">EDIT</a>
                        @endif
                    @endcan
                    @can('edit-project-repair')
                        @if($menu == "repair")
                            <a href="{{ route('project_repair.edit',['id'=>$project->id]) }}" class="btn btn-primary btn-sm col-xs-12">EDIT</a>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@verbatim
<div id="confirm_activity">
    <div class="row">
        <div class="col-sm-12" style="margin-top: -5px;">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="col-sm-12">
                        <table class="marginAuto">
                            <tbody>
                                <tr>
                                    <td class="textCenter"><h3 style="margin-top: -1%;">PROGRESS ({{project.progress}} %)</h3></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="progress" style="height:20px">
                            <div :class="progressBarColor" role="progressbar" :style="styleProgressBar(project.progress)" :aria-valuenow="project.progress" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="margin-top: -5px;">
            <div class="box box-solid">
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle" class="textCenter" rowspan="2">Comp. %</th>
                                <th class="textCenter" colspan="3">In-Week Performance</th>
                                <th class="textCenter">Cum. Performance</th>
                            </tr>
                            <tr>
                                <th class="textCenter">Last Week</th>
                                <th class="textCenter">This Week</th>
                                <th class="textCenter">In-Week Gain</th>
                                <th style="width: 10%" class="textCenter">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Expected Comp. %</th>
                                <td class="textCenter">{{progressStatus.last_week_planned}} %</td>
                                <td class="textCenter">{{progressStatus.this_week_planned}} %</td>
                                <td class="textCenter">{{progressStatus.expected_in_week_gain}} %</td>
                                <td v-if="progressStatus.this_week_actual - progressStatus.this_week_planned < 0" rowspan="2" class="textCenter" style="background-color: red; color: white; font-size:1.2em">
                                    <i>{{getStatus(progressStatus.this_week_actual - progressStatus.this_week_planned)}}</i> {{Math.abs(progressStatus.this_week_actual - progressStatus.this_week_planned)}} %
                                </td>
                                <td v-else-if="progressStatus.this_week_actual - progressStatus.this_week_planned > 0" rowspan="2" class="textCenter" style="background-color: #3db9d3; color: white; font-size:1.2em">
                                    <i>{{getStatus(progressStatus.this_week_actual - progressStatus.this_week_planned)}}</i> {{Math.abs(progressStatus.this_week_actual - progressStatus.this_week_planned)}} %
                                </td>
                                <td v-else-if="progressStatus.this_week_actual - progressStatus.this_week_planned == 0" rowspan="2" class="textCenter" style="background-color: #3db9d3; color: white; font-size:1.2em">
                                    <i>{{getStatus(progressStatus.this_week_actual - progressStatus.this_week_planned)}}</i>
                                </td>
                            </tr>
                            <tr>
                                <th>Actual Comp. %</th>
                                <td class="textCenter">{{progressStatus.last_week_actual}} %</td>
                                <td class="textCenter">{{progressStatus.this_week_actual}} %</td>
                                <td class="textCenter">{{progressStatus.this_week_actual - progressStatus.last_week_actual}} %</td>
                            </tr>
                            <tr>
                                <th v-if="expectedStatus != null">Expected End Date</th>
                                <td colspan="4" v-if="expectedStatus == 0" style="background-color: #3db9d3; color: white;">{{str_expected_date}}</td>
                                <td colspan="4" v-else-if="expectedStatus == 1" style="background-color: #3db9d3; color: white;">{{str_expected_date}}</td>
                                <td colspan="4" v-else-if="expectedStatus == 2" style="background-color: red; color: white;">{{str_expected_date}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- unused -->
    <div class="modal fade" id="confirm_activity_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Confirm Activity <b id="confirm_activity_code"></b></h4>
                </div>
                <div class="modal-body">
                    <table>
                        <thead>
                            <th colspan="2">Activity Details</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b id="planned_start_date"></b></td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td>&ensp;<b id="planned_end_date"></b></td>
                            </tr>
                            <tr>
                                <td>Planned Duration</td>
                                <td>:</td>
                                <td>&ensp;<b id="planned_duration"></b></td>
                            </tr>
                            <tr>
                                <td>Predecessor</td>
                                <td>:</td>
                                <td>&ensp;<template v-if="havePredecessor == false">-</template></td>
                            </tr>
                        </tbody>
                    </table>
                    <template v-if="havePredecessor == false"><br></template>
                    <template v-if="havePredecessor == true">
                        <table class="table table-bordered tableFixed">
                            <thead>
                                <tr>
                                    <th class="p-l-5" style="width: 5%">No</th>
                                    <th style="width: 15%">Code</th>
                                    <th style="width: 29%">Name</th>
                                    <th style="width: 29%">Description</th>
                                    <th style="width: 15%">WBS Number</th>
                                    <th style="width: 12%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data,index) in predecessorActivities">
                                    <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.number)">{{ data.wbs.number }}</td>
                                    <td class="textCenter">
                                        <template v-if="data.status == 0">
                                            <i class='fa fa-check'></i>
                                        </template>
                                        <template v-else>
                                            <i class='fa fa-times'></i>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="actual_start_date" class=" control-label">Actual Start Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input v-model="confirmActivity.actual_start_date" type="text" class="form-control datepicker" id="actual_start_date" placeholder="Start Date">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="actual_end_date" class=" control-label">Actual End Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input v-model="confirmActivity.actual_end_date" type="text" class="form-control datepicker" id="actual_end_date" placeholder="End Date">
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="duration" class=" control-label">Actual Duration (Days)</label>
                            <input @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="confirmActivity.actual_duration"  type="number" class="form-control" id="actual_duration" placeholder="Duration" >
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="duration" class=" control-label">Current Progress (%)</label>
                            <input v-model="confirmActivity.current_progress"  type="number" class="form-control" id="current_progress" placeholder="Current Progress" >
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="btnSave" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="confirm">SAVE</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="mm_prod_info">
        <div class="modal-dialog modalPredecessor">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Material Management and Production Execution Information</h4>
                </div>
                <div class="modal-body">
                    <div class="box-group accordion" id="accordion_pr">
                        <div class="panel box box-primary">
                            <div class="no-padding box-header with-border">
                                <h5 class="pull-left">
                                    <a data-toggle="collapse" data-parent="#accordion_pr" href="#pr">
                                        Purchase Requisitions <template v-if="active_pr.length == 0">(NO TRANSACTION RECORDED)</template>
                                    </a>
                                </h5>
                            </div>
                            <div id="pr" class="panel-collapse collapse in" v-if="active_pr.length > 0">
                                <div class="p-l-0 p-r-0 box-body">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th class="p-l-5" style="width: 5%">No</th>
                                                <th style="width: 15%">Number</th>
                                                <th style="width: 29%">Description</th>
                                                <th style="width: 12%">Status</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in active_pr">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.number }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td v-if="data.status == 0" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('ORDERED')">ORDERED</td>
                                                <td v-else-if="data.status == 1" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('OPEN')">OPEN</td>
                                                <td v-else-if="data.status == 2" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('APPROVED')">APPROVED</td>
                                                <td v-else-if="data.status == 3" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('NEEDS REVISION')">NEEDS REVISION</td>
                                                <td v-else-if="data.status == 4" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('REVISED')">REVISED</td>
                                                <td v-else-if="data.status == 5" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('REJECTED')">REJECTED</td>
                                                <td v-else-if="data.status == 6" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('CONSOLIDATED')">CONSOLIDATED</td>
                                                <td>
                                                    <a class="btn btn-primary btn-xs col-xs-12" :href="openPr(data.id)" target="_blank">
                                                        DETAILS
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-group accordion" id="accordion_po">
                        <div class="panel box box-primary">
                            <div class="no-padding box-header with-border">
                                <h5 class="pull-left">
                                    <a data-toggle="collapse" data-parent="#accordion_po" href="#po">
                                        Purchase Orders <template v-if="active_po.length == 0">(NO TRANSACTION RECORDED)</template>
                                    </a>
                                </h5>
                            </div>
                            <div id="po" class="panel-collapse collapse in" v-if="active_po.length > 0">
                                <div class="p-l-0 p-r-0 box-body">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th class="p-l-5" style="width: 5%">No</th>
                                                <th style="width: 15%">Number</th>
                                                <th style="width: 29%">Description</th>
                                                <th style="width: 12%">Vendor</th>
                                                <th style="width: 12%">Status</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in active_po">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.number }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.vendor.code+' - '+data.vendor.name)">
                                                        {{data.vendor.code}} - {{data.vendor.name}}
                                                    </td>
                                                <td v-if="data.status == 0" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('RECEIVED')">RECEIVED</td>
                                                <td v-else-if="data.status == 1" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('OPEN')">OPEN</td>
                                                <td v-else-if="data.status == 2" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('APPROVED')">APPROVED</td>
                                                <td v-else-if="data.status == 3" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('NEEDS REVISION')">NEEDS REVISION</td>
                                                <td v-else-if="data.status == 4" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('REVISED')">REVISED</td>
                                                <td v-else-if="data.status == 5" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('REJECTED')">REJECTED</td>
                                                <td v-else-if="data.status == 6" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('CONSOLIDATED')">CONSOLIDATED</td>
                                                <td>
                                                    <a class="btn btn-primary btn-xs col-xs-12" :href="openPo(data.id)" target="_blank">
                                                        DETAILS
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-group accordion" id="accordion_gr">
                        <div class="panel box box-primary">
                            <div class="no-padding box-header with-border">
                                <h5 class="pull-left">
                                    <a data-toggle="collapse" data-parent="#accordion_gr" href="#gr">
                                        Goods Receipts <template v-if="active_gr.length == 0">(NO TRANSACTION RECORDED)</template>
                                    </a>
                                </h5>
                            </div>
                            <div id="gr" class="panel-collapse collapse in" v-if="active_gr.length > 0">
                                <div class="p-l-0 p-r-0 box-body">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th class="p-l-5" style="width: 5%">No</th>
                                                <th style="width: 15%">Number</th>
                                                <th style="width: 29%">Description</th>
                                                <th style="width: 12%">PO Number</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in active_gr">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.number }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.purchase_order.number)">
                                                    <a :href="openPo(data.purchase_order.id)" target="_blank">
                                                        {{data.purchase_order.number}}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-xs col-xs-12" :href="openGr(data.id)" target="_blank">
                                                        DETAILS
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-group accordion" id="accordion_mr">
                        <div class="panel box box-primary">
                            <div class="no-padding box-header with-border">
                                <h5 class="pull-left">
                                    <a data-toggle="collapse" data-parent="#accordion_mr" href="#mr">
                                        Material Requisitions <template v-if="active_mr.length == 0">(NO TRANSACTION RECORDED)</template>
                                    </a>
                                </h5>
                            </div>
                            <div id="mr" class="panel-collapse collapse in" v-if="active_mr.length > 0">
                                <div class="p-l-0 p-r-0 box-body">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th class="p-l-5" style="width: 5%">No</th>
                                                <th style="width: 15%">Number</th>
                                                <th style="width: 29%">Description</th>
                                                <th style="width: 12%">Status</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in active_mr">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.number }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td v-if="data.status == 0" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('ORDERED')">ORDERED</td>
                                                <td v-else-if="data.status == 1" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('OPEN')">OPEN</td>
                                                <td v-else-if="data.status == 2" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('APPROVED')">APPROVED</td>
                                                <td v-else-if="data.status == 3" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('NEEDS REVISION')">NEEDS REVISION</td>
                                                <td v-else-if="data.status == 4" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('REVISED')">REVISED</td>
                                                <td v-else-if="data.status == 5" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('REJECTED')">REJECTED</td>
                                                <td v-else-if="data.status == 6" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('CONSOLIDATED')">CONSOLIDATED</td>
                                                <td>
                                                    <a class="btn btn-primary btn-xs col-xs-12" :href="openMr(data.id)" target="_blank">
                                                        DETAILS
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-group accordion" id="accordion_gi">
                        <div class="panel box box-primary">
                            <div class="no-padding box-header with-border">
                                <h5 class="pull-left">
                                    <a data-toggle="collapse" data-parent="#accordion_gi" href="#gi">
                                        Goods Issues <template v-if="active_gi.length == 0">(NO TRANSACTION RECORDED)</template>
                                    </a>
                                </h5>
                            </div>
                            <div id="gi" class="panel-collapse collapse in" v-if="active_gi.length > 0">
                                <div class="p-l-0 p-r-0 box-body">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th class="p-l-5" style="width: 5%">No</th>
                                                <th style="width: 15%">Number</th>
                                                <th style="width: 29%">Description</th>
                                                <th style="width: 15%">MR Number</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in active_gi">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.number }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.material_requisition.number)">
                                                    <a :href="openMr(data.material_requisition_id)" target="_blank">
                                                        {{data.material_requisition.number}}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-xs col-xs-12" :href="openGi(data.id)" target="_blank">
                                                        DETAILS
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-group accordion" id="accordion_prod">
                        <div class="panel box box-primary">
                            <div class="no-padding box-header with-border">
                                <h5 class="pull-left">
                                    <a data-toggle="collapse" data-parent="#accordion_prod" href="#prod">
                                        Production Orders <template v-if="active_prod.length == 0">(NO TRANSACTION RECORDED)</template>
                                    </a>
                                </h5>
                            </div>
                            <div id="prod" class="panel-collapse collapse in" v-if="active_prod.length > 0">
                                <div class="p-l-0 p-r-0 box-body">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th class="p-l-5" style="width: 5%">No</th>
                                                <th style="width: 15%">Number</th>
                                                <th style="width: 12%">Status</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in active_prod">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.number }}</td>
                                                <td v-if="data.status == 0" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('CLOSED')">CLOSED</td>
                                                <td v-else-if="data.status == 1" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('UNRELEASED')">UNRELEASED</td>
                                                <td v-else-if="data.status == 2" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('RELEASED')">RELEASED</td>
                                                <td>
                                                    <a class="btn btn-primary btn-xs col-xs-12" :href="openProd(data.id)" target="_blank">
                                                        DETAILS
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnSave" type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@endverbatim

<div class="row">
    <div class="col-sm-12" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border"><h4><b>Gantt Chart</b></h4></div>
            <div class="box-body gantt_chart_mobile">
                <label>View by :</label>
                <label><input type="radio" name="scale" value="day" />Day scale</label>
                <label><input type="radio" name="scale" value="month" checked/>Month scale</label>
                <label><input type="radio" name="scale" value="year"/>Year scale</label>
                <div class="col-sm-12 col-xs-12 no-padding-left">
                    <div id="ganttChart" style='width:100%; height:490px;'></div>
                </div>
            </div>
            <div class="box-body gantt_chart_mobile_notification">
                <div class="col-xs-12 textCenter"><b>Please view Gantt Chart in Landscape Mode</b></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border"><h4><b>Planned Cost Vs. Actual Cost</b></h4></div>
            <div class="box-body" style="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart">
                            <canvas id="cost" width="703" height="350"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border"><h4><b>Planned Progress Vs. Actual Progress</b></h4></div>
            <div class="box-body" style="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart">
                            <canvas id="progress" width="703" height="350"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-sm-6" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border"><h4><b>Outstanding Item Report</b></h4></div>
            <div class="box-body">
                <div id="treeview" class="tdEllipsis">

                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border p-b-0"><h4><b>Completed Production Order Report</b></h4></div>
            <div class="box-body p-t-0">
                <table class="table table-bordered showTable" id="wo-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Number</th>
                            <th width="25%">Created At</th>
                            <th width="30%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelPrO as $PrO)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $PrO->number }}</td>
                            <td>{{ $PrO->created_at }}</td>
                            @if($PrO->status == 1)
                                <td>{{ 'UNRELEASED' }} </td>
                            @else()
                                <td>{{ 'COMPLETED' }} </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}

<form id="form" class="form-horizontal" method="POST">
    <input type="hidden" name="_method" value="PATCH">
    @csrf
</form>



@endsection
@push('script')
<script>
    $('#wo-table').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
    });
    jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');

    var costCanvas = document.getElementById("cost").getContext("2d");
    var progressCanvas = $('#progress').get(0).getContext('2d');
    var horizonalLinePlugin = {
        afterDraw: function(chartInstance) {
            var yScale = chartInstance.scales["y-axis-0"];
            var canvas = chartInstance.chart;
            var ctx = canvas.ctx;
            var index;
            var line;
            var style;

            if (chartInstance.options.horizontalLine) {
            for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
                line = chartInstance.options.horizontalLine[index];

                if (!line.style) {
                    style = "rgba(169,169,169, .6)";
                } else {
                    style = line.style;
                }

                if (line.y) {
                    yValue = yScale.getPixelForValue(line.y);
                } else {
                    yValue = 0;
                }

                ctx.lineWidth = 3;

                if (yValue) {
                    ctx.beginPath();
                    ctx.moveTo(0, yValue);
                    ctx.lineTo(canvas.width, yValue);
                    ctx.strokeStyle = style;
                    ctx.stroke();
                }

                if (line.text) {
                    ctx.fillStyle = style;
                    ctx.fillText(line.text, 0, yValue + ctx.lineWidth + 10);
                }
            }
            return;
            };
        }
    };
    Chart.pluginService.register(horizonalLinePlugin);
    var configCost = {
        type: 'line',
        data: {
            datasets: [
                {
                    label: "EVM Cost",
                    backgroundColor: "rgba(0, 0, 0, 0)",
                    borderColor : "rgba(122, 122, 211, 122)",
                    data: @json($dataEvm),
                },
                {
                    label: "Planned Cost",
                    borderColor: "rgba(0, 0, 255, 0.7)",
                    data: @json($dataPlannedCost),
                },
                {
                    label: "Actual Cost",
                    borderColor: "green",
                    data: @json($dataActualCost),
                },
            ]
        },
        options: {
            "horizontalLine": [{
                "y": @json($project->budget_value/1000000),
                "style": "rgba(255, 0, 0, .4)",
                "text": "Budget Value"
            }],
            elements: {
                point: {
                    radius: 4,
                    hitRadius: 4,
                    hoverRadius: 6
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var value = tooltipItem.yLabel;
                        if(parseInt(value) >= 1000){
                            return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } else {
                            return 'Rp' + value;
                        }
                    }
                } // end callbacks:
            }, //end tooltips
            responsive: true,
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        tooltipFormat: 'll',
                        unit: 'week',
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display:false
                    },
                    ticks: {
                        beginAtZero:true,
                        callback: function(value, index, values) {
                            if(parseInt(value) >= 1000){
                               return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } else {
                               return 'Rp' + value;
                            }
                       },
                       suggestedMax : @json($project->budget_value/1000000),
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'in million'
                    }
                }]
            },
        }
    };

    var costChart = new Chart(costCanvas, configCost);

    var configProgress = {
        type: 'line',
        data: {
            datasets: [
                {
                    label: "Planned Progress",
                    borderColor: "rgba(0, 0, 255, 0.7)",
                    data: @json($dataPlannedProgress),
                },
                {
                    label: "Actual Progress",
                    borderColor: "green",
                    data: @json($dataActualProgress),
                }
            ]
        },
        options: {
            elements: {
                point: {
                    radius: 4,
                    hitRadius: 4,
                    hoverRadius: 6
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var value = tooltipItem.yLabel;
                            return value + "%";
                    }
                } // end callbacks:
            }, //end tooltips
            responsive: true,
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        tooltipFormat: 'll',
                        unit: 'week',
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display:false
                    },
                    ticks: {
                        beginAtZero:true,
                        callback: function(value, index, values) {
                            return value + "%";
                       }
                    }
                }]
            }
        }
    };

    var progress = new Chart(progressCanvas, configProgress);

    $(document).ready(function(){
        var outstanding_item = @json($outstanding_item);
        $('#treeview').jstree({
            'core' : {
                'data' : outstanding_item
            }
        }).bind("loaded.jstree", function (event, data) {
            // you get two params - event & data - check the core docs for a detailed description
            $(this).jstree("open_all");
        });
        var project = @json($ganttData);
        var links = @json($links);


        gantt.config.columns = [
            {name:"text", label:"Task name", width:"*", tree:true,
                template:function(obj){
                    var text = "";
                    function myFunction(x) {
                        if (x.matches) { // If media query matches
                            text = '<b>'+obj.text+'</b>';
                        }else{
                            text = '<div class="tdEllipsis" data-placement="left" data-container="body" data-toggle="tooltip" title="'+obj.text+'"><b>'+obj.text+'</b></div>';
                        }
                    }

                    var x = window.matchMedia("(max-width: 500px)")
                    myFunction(x) // Call listener function at run time
                    x.addListener(myFunction) // Attach listener function on state changes

                    var x = window.matchMedia("(max-width: 1024px)")
                    myFunction(x) // Call listener function at run time
                    x.addListener(myFunction) // Attach listener function on state changes
                    return text ;
                }
            },

            {name:"progress", label:"Progress", align: "center",
                template:function(obj){
                    if(obj.status != undefined){
                        if(obj.status == 0){
                            return "<i class='fa fa-check text-success'></i>"
                        }else{
                            return "<i class='fa fa-times text-danger'></i>"
                        }
                    }else{
                        return obj.progress * 100+" %"
                    }
                },
                width:"70px"
            },
        ];

        gantt.config.grid_width = 290;

        gantt.templates.rightside_text = function(start, end, task){
            if(task.status != undefined){
                if(task.status == 0){
                    var text = task.text.replace('[Actual]','');
                    return "<b>"+text+" Completed</b>"
                }else{
                    return "<b>"+task.text+"</b>"
                }
            }else{
                if(task.$level != 0){
                    return "<b>"+task.text+"</b> | Progress: <b>" + task.progress*100+ "%</b>"
                }else{
                    return "Progress: <b>" + task.progress*100+ "%</b>";
                }
            }
        };

        gantt.templates.task_text=function(start,end,task){
            if(task.$level == 0){
                return "<b>"+task.text+"</b>";
            }else{
                if(task.is_cpm){
                    return "(!)";
                }else{
                    return "";
                }
            }
        };


        var tasks = {
            data:project,
            links:links
        };

        var markerId = gantt.addMarker({
            start_date: new Date(),
            css: "today",
            text: "Now",
            title: new Date().toString(),
        });
        gantt.getMarker(markerId); //->{css:"today", text:"Now", id:...}
        gantt.config.readonly = true;
        gantt.config.open_tree_initially = true;
        gantt.templates.grid_folder = function(item) {
            return "<div class='gantt_tree_icon textCenter'><i class='fa fa-suitcase'></i></div>";
        };
        gantt.templates.grid_file = function(item) {
            if(item.id.indexOf("WBS") != -1){
                return "<div class='gantt_tree_icon textCenter'><i class='fa fa-suitcase'></i></div>";
            }else{
                return "<div class='gantt_tree_icon textCenter'><i class='fa fa-clock-o'></i></div>";
            }
        };

        /* global gantt */
        function setScaleConfig(level) {
            switch (level) {
                case "day":
                    gantt.config.scale_unit = "day";
                    gantt.config.step = 1;
                    gantt.config.date_scale = "%d %M";
                    gantt.templates.date_scale = null;

                    gantt.config.scale_height = 27;

                    gantt.config.subscales = [];
                    break;
                case "month":
                    gantt.config.scale_unit = "month";
                    gantt.config.date_scale = "%F, %Y";
                    gantt.templates.date_scale = null;

                    gantt.config.scale_height = 50;

                    gantt.config.subscales = [
                        {unit: "week", step: 1, date: "%j"}
                    ];

                    break;
                case "year":
                    gantt.config.scale_unit = "year";
                    gantt.config.step = 1;
                    gantt.config.date_scale = "%Y";
                    gantt.templates.date_scale = null;

                    gantt.config.min_column_width = 50;
                    gantt.config.scale_height = 90;

                    gantt.config.subscales = [
                        {unit: "month", step: 1, date: "%M"}
                    ];
                    break;
            }
        }

        setScaleConfig("month");
        gantt.init("ganttChart");
        gantt.parse(tasks);
        gantt.showDate(new Date());
        gantt.sort("start_date", false);

        var els = document.querySelectorAll("input[name='scale']");
        for (var i = 0; i < els.length; i++) {
            els[i].onclick = function(e){
                e = e || window.event;
                var el = e.target || e.srcElement;
                var value = el.value;
                setScaleConfig(value);
                gantt.render();
                $('[data-toggle="tooltip"]').tooltip();
            };
        }
        $('[data-toggle="tooltip"]').tooltip();

        Vue.directive('tooltip', function(el, binding){
            $(el).tooltip({
                title: binding.value,
                placement: binding.arg,
                trigger: 'hover'
            })
        })


        var data = {
            menu : @json($menu),
            project_id : @json($project->id),
            project : @json($project),
            today : @json($today),
            activities : @json($activities),
            wbss : @json($wbss),
            progressStatus : @json($progressStatus),
            predecessorActivities : [],
            activity:"",
            confirmActivity : {
                activity_id : "",
                actual_start_date : "",
                actual_end_date : "",
                actual_duration : "",
                current_progress : 0,
            },
            havePredecessor : false,
            active_pr : [],
            active_po : [],
            active_gr : [],
            active_mr : [],
            active_gi : [],
            active_prod : [],
            str_expected_date : @json($str_expected_date),
            expectedStatus : @json($expectedStatus),
        };
        var vm = new Vue({
            el: '#confirm_activity',
            data: data,
            mounted() {
                $('.datepicker').datepicker({
                    autoclose : true,
                });

                $("#actual_start_date").datepicker().on(
                    "changeDate", () => {
                        this.confirmActivity.actual_start_date = $('#actual_start_date').val();
                        if(this.confirmActivity.actual_end_date != "" && this.confirmActivity.actual_start_date != ""){
                            this.confirmActivity.actual_duration = datediff(parseDate(this.confirmActivity.actual_start_date), parseDate(this.confirmActivity.actual_end_date));
                        }else{
                            this.confirmActivity.actual_duration ="";
                        }
                        this.setEndDateEdit();
                    }
                );
                $("#actual_end_date").datepicker().on(
                    "changeDate", () => {
                        this.confirmActivity.actual_end_date = $('#actual_end_date').val();
                        if(this.confirmActivity.actual_start_date != "" && this.confirmActivity.actual_end_date != ""){
                            this.confirmActivity.actual_duration = datediff(parseDate(this.confirmActivity.actual_start_date), parseDate(this.confirmActivity.actual_end_date));
                        }else{
                            this.confirmActivity.actual_duration ="";
                        }
                    }
                );
            },
            computed:{
                progressBarColor: function(){
                    let classStyle = "";
                    if(this.project.planned_end_date < this.today){
                        classStyle = "progress-bar progress-bar-danger";
                    }else if(this.project.planned_end_date == this.today){
                        classStyle = "progress-bar progress-bar-warning";
                    }else{
                        classStyle = "progress-bar progress-bar-success";
                    }
                    return classStyle;
                }

            },
            methods:{
                openPr(id){
                    if(this.menu == "building"){
                        url = "/purchase_requisition/"+id;
                    }else{
                        url = "/purchase_requisition_repair/"+id;
                    }

                    return url
                },
                openPo(id){
                    if(this.menu == "building"){
                        url = "/purchase_order/"+id;
                    }else{
                        url = "/purchase_order_repair/"+id;
                    }

                    return url
                },
                openGr(id){
                    if(this.menu == "building"){
                        url = "/goods_receipt/"+id;
                    }else{
                        url = "/goods_receipt_repair/"+id;
                    }

                    return url
                },
                openMr(id){
                    if(this.menu == "building"){
                        url = "/material_requisition/"+id;
                    }else{
                        url = "/material_requisition_repair/"+id;
                    }

                    return url
                },
                openGi(id){
                    if(this.menu == "building"){
                        url = "/goods_issue/"+id;
                    }else{
                        url = "/goods_issue_repair/"+id;
                    }

                    return url
                },
                openProd(id){
                    if(this.menu == "building"){
                        url = "/production_order/"+id;
                    }else{
                        url = "/production_order_repair/"+id;
                    }

                    return url
                },
                getStatus:function(data){
                    text = "";
                    if(data < 0){
                        text = "Behind";
                    }else if(data == 0){
                        text = "On Time";
                    }else if(data > 0){
                        text = "Ahead";
                    }

                    return text;
                },
                styleProgressBar: function(data){
                    return "width: "+data+"%";
                },
                tooltipText: function(text) {
                    return text
                },
                openConfirmModal(data){
                    window.axios.get('/api/getActivity/'+data).then(({ data }) => {
                        this.activity = data[0];
                        var isOkPredecessor = true;
                        if(this.activity.predecessor != null){
                            this.havePredecessor = true;
                            window.axios.get('/api/getPredecessor/'+this.activity.id).then(({ data }) => {
                                this.predecessorActivities = data;
                                this.predecessorActivities.forEach(activity => {
                                    if(activity.status == 1){
                                        isOkPredecessor = false;
                                        this.confirmActivity.actual_start_date = "";
                                        this.confirmActivity.actual_end_date = "";
                                        this.confirmActivity.actual_duration = "";
                                        document.getElementById("actual_start_date").disabled = true;
                                        document.getElementById("current_progress").disabled = true;
                                    }

                                    if(isOkPredecessor){
                                        $('#actual_start_date').datepicker('setDate', (this.activity.actual_start_date != null ? new Date(this.activity.actual_start_date):new Date(this.activity.planned_start_date)));
                                        $('#actual_end_date').datepicker('setDate', (this.activity.actual_end_date != null ? new Date(this.activity.actual_end_date):null));
                                        document.getElementById("actual_start_date").disabled = false;
                                        document.getElementById("current_progress").disabled = false;
                                        if(this.confirmActivity.current_progress != 100){
                                            document.getElementById("actual_end_date").disabled = true;
                                            document.getElementById("actual_duration").disabled = true;
                                            this.confirmActivity.actual_end_date = "";
                                            this.confirmActivity.actual_duration = "";
                                        }else{
                                            document.getElementById("actual_end_date").disabled = false;
                                            document.getElementById("actual_duration").disabled = false;
                                            if(this.confirmActivity.actual_end_date == ""){
                                                document.getElementById("btnSave").disabled = true;
                                            }else{
                                                document.getElementById("btnSave").disabled = false;
                                            }
                                        }
                                    }else{
                                        this.confirmActivity.actual_start_date = "";
                                        this.confirmActivity.actual_end_date = "";
                                        this.confirmActivity.actual_duration = "";
                                    }
                                });
                            });
                        }else{
                            isOkPredecessor = true;
                            this.havePredecessor = false;
                            this.predecessorActivities = [];
                        }
                        this.confirmActivity.current_progress = this.activity.progress;

                        if(isOkPredecessor){
                            $('#actual_start_date').datepicker('setDate', (this.activity.actual_start_date != null ? new Date(this.activity.actual_start_date):new Date(this.activity.planned_start_date)));
                            $('#actual_end_date').datepicker('setDate', (this.activity.actual_end_date != null ? new Date(this.activity.actual_end_date):null));
                            document.getElementById("actual_start_date").disabled = false;
                            document.getElementById("current_progress").disabled = false;
                            if(this.confirmActivity.current_progress != 100){
                                document.getElementById("actual_end_date").disabled = true;
                                document.getElementById("actual_duration").disabled = true;
                                this.confirmActivity.actual_end_date = "";
                                this.confirmActivity.actual_duration = "";
                            }else{
                                document.getElementById("actual_end_date").disabled = false;
                                document.getElementById("actual_duration").disabled = false;
                                if(this.confirmActivity.actual_end_date == ""){
                                    document.getElementById("btnSave").disabled = true;
                                }else{
                                    document.getElementById("btnSave").disabled = false;
                                }
                            }
                        }else{
                            this.confirmActivity.actual_start_date = "";
                            this.confirmActivity.actual_end_date = "";
                            this.confirmActivity.actual_duration = "";
                        }

                        document.getElementById("confirm_activity_code").innerHTML= this.activity.code;
                        document.getElementById("planned_start_date").innerHTML= this.activity.planned_start_date;
                        document.getElementById("planned_end_date").innerHTML= this.activity.planned_end_date;
                        document.getElementById("planned_duration").innerHTML= this.activity.planned_duration+" Days";

                        this.confirmActivity.activity_id = this.activity.id;

                    });
                },
                setEndDateEdit(){
                    if(this.confirmActivity.actual_duration != "" && this.confirmActivity.actual_start_date != ""){
                        var actual_duration = parseInt(this.confirmActivity.actual_duration);
                        var actual_start_date = this.confirmActivity.actual_start_date;
                        var actual_end_date = new Date(actual_start_date);

                        actual_end_date.setDate(actual_end_date.getDate() + actual_duration-1);
                        $('#actual_end_date').datepicker('setDate', actual_end_date);
                    }else{
                        this.confirmActivity.actual_end_date = "";
                    }
                },
                confirm(){
                    var confirmActivity = this.confirmActivity;
                    var url = "";
                    if(this.menu == "building"){
                        url = "/activity/updateActualActivity/"+confirmActivity.activity_id;
                    }else{
                        url = "/activity_repair/updateActualActivity/"+confirmActivity.activity_id;
                    }
                    confirmActivity = JSON.stringify(confirmActivity);
                    window.axios.put(url,confirmActivity)
                    .then((response) => {
                        if(response.data.error != undefined){
                            iziToast.warning({
                                displayMode: 'replace',
                                title: response.data.error,
                                position: 'topRight',
                            });
                        }else{
                            iziToast.success({
                                displayMode: 'replace',
                                title: response.data.response,
                                position: 'topRight',
                            });
                        }

                        window.axios.get('/api/getDataGantt/'+this.project_id).then(({ data }) => {
                            var tasks = {
                                data:data.data,
                                links:data.links
                            };
                            gantt.render();
                            gantt.parse(tasks);
                            gantt.eachTask(function(task){
                                if(task.id.indexOf("WBS") !== -1){
                                    gantt.open(task.id);
                                }
                            })
                        });

                        window.axios.get('/api/getProjectActivity/'+this.project_id).then(({ data }) => {
                            this.project = data;
                        });

                        window.axios.get('/api/getActualStartDate/'+this.project_id).then(({ data }) => {
                            document.getElementById('project-actual_start_date').innerHTML = "<b>: "+data+"</b>";
                        });

                        window.axios.get('/api/getDataChart/'+this.project_id).then(({ data }) => {
                            var updateChart =[
                                {
                                    label: "Planned Progress",
                                    backgroundColor: "rgba(242, 38, 2, 0.7)",
                                    data: data.dataPlannedProgress,
                                },
                                {
                                    label: "Actual Progress",
                                    backgroundColor: "rgba(0, 0, 255, 0.7)",
                                    data:data.dataActualProgress,
                                }

                            ];
                            progress.config.data.datasets = updateChart;
                            window.progress.update();
                        });

                        window.axios.get('/api/getDataJstree/'+this.project_id).then(({ data }) => {
                            $('#treeview').jstree(true).settings.core.data = data;
                            $('#treeview').jstree(true).refresh();
                        });


                        this.confirmActivity.activity_id = "";
                        this.confirmActivity.actual_start_date = "";
                        this.confirmActivity.actual_end_date = "";
                        this.confirmActivity.actual_duration = "";
                        this.havePredecessor = false;
                        this.predecessorActivities = [];
                    })
                    .catch((error) => {
                        console.log(error);
                    })

                }
            },
            watch: {
                confirmActivity:{
                    handler: function(newValue) {
                        if(this.confirmActivity.actual_start_date == ""){
                            document.getElementById("actual_end_date").disabled = true;
                            document.getElementById("actual_duration").disabled = true;
                            document.getElementById("btnSave").disabled = true;
                            document.getElementById("current_progress").disabled = true;
                        }else{
                            document.getElementById("actual_end_date").disabled = false;
                            document.getElementById("actual_duration").disabled = false;
                            document.getElementById("btnSave").disabled = false;
                            document.getElementById("current_progress").disabled = false;
                        }

                        this.predecessorActivities.forEach(activity => {
                            if(activity.status == 1){
                                document.getElementById("actual_start_date").disabled = true;
                                document.getElementById("actual_end_date").disabled = true;
                                document.getElementById("actual_duration").disabled = true;
                                document.getElementById("btnSave").disabled = true;
                                document.getElementById("current_progress").disabled = true;
                            }
                        });

                        if(this.confirmActivity.current_progress != 100){
                            document.getElementById("actual_end_date").disabled = true;
                            document.getElementById("actual_duration").disabled = true;
                            this.confirmActivity.actual_end_date = "";
                            this.confirmActivity.actual_duration = "";
                        }else{
                            document.getElementById("actual_end_date").disabled = false;
                            document.getElementById("actual_duration").disabled = false;
                            if(this.confirmActivity.actual_end_date == ""){
                                document.getElementById("btnSave").disabled = true;
                            }else{
                                document.getElementById("btnSave").disabled = false;
                            }
                        }
                    },
                    deep: true
                },
                'confirmActivity.actual_start_date' :function(newValue){
                    if(newValue == ""){
                        $('#actual_end_date').datepicker('setDate', null);
                        this.confirmActivity.actual_duration = "";
                    }
                },
                'confirmActivity.actual_duration' : function(newValue){
                    this.confirmActivity.actual_duration = newValue+"".replace(/\D/g, "");
                        if(parseInt(newValue) < 1 ){
                            iziToast.warning({
                                displayMode: 'replace',
                                title: 'End Date cannot be ahead Start Date',
                                position: 'topRight',
                            });
                            this.confirmActivity.actual_duration = "";
                            this.confirmActivity.actual_end_date = "";
                        }
                },
            },
            created: function(){
                this.progressStatus.last_week_actual = parseFloat(this.progressStatus.last_week_actual).toFixed(2);
                this.progressStatus.last_week_planned = parseFloat(this.progressStatus.last_week_planned).toFixed(2);
                this.progressStatus.this_week_actual = parseFloat(this.progressStatus.this_week_actual).toFixed(2);
                this.progressStatus.this_week_planned = parseFloat(this.progressStatus.this_week_planned).toFixed(2);
                this.progressStatus.expected_in_week_gain = parseFloat(this.progressStatus.this_week_planned - this.progressStatus.last_week_planned).toFixed(2);
                $('div.overlay').hide();
            }
        });

        function parseDate(str) {
            var mdy = str.split('/');
            return new Date(mdy[2], mdy[0]-1, mdy[1]);
        }

        function datediff(first, second) {
            // Take the difference between the dates and divide by milliseconds per day.
            // Round to nearest whole number to deal with DST.
            return Math.round(((second-first)/(1000*60*60*24))+1);
        }

        gantt.attachEvent("onTaskClick", function(id,e){
            if(e.target.classList[0] != "gantt_tree_icon"){
                if(vm.menu == "building"){
                    if(id.indexOf("WBS") !== -1){
                        var temp_pr = [];
                        var temp_po = [];
                        var temp_gr = [];
                        var temp_mr = [];
                        var temp_gi = [];
                        var temp_prod = [];

                        vm.wbss.forEach(wbs => {
                            if(wbs.code == id){
                                if(wbs.bom != null){
                                    if(wbs.bom.purchase_requisition != null){
                                        temp_pr.push(wbs.bom.purchase_requisition);
                                        wbs.bom.purchase_requisition.purchase_orders.forEach(purchase_order => {
                                            temp_po.push(purchase_order);
                                            purchase_order.goods_receipts.forEach(gr => {
                                                temp_gr.push(gr);
                                            });
                                        });
                                    }
                                }
                                if(wbs.production_order != null){
                                    temp_prod.push(wbs.production_order);
                                }

                                var temp_mr_id = []
                                if(wbs.material_requisition_details.length > 0){
                                    wbs.material_requisition_details.forEach(mrd => {
                                        if(temp_mr_id.includes(mrd.material_requisition_id) == false){
                                            temp_mr_id.push(mrd.material_requisition_id);
                                            temp_mr.push(mrd.material_requisition);
                                        }
                                    });
                                }

                                temp_mr.forEach(mr => {
                                    mr.goods_issues.forEach(gi => {
                                        temp_gi.push(gi);
                                    });
                                });
                            }

                        });

                        vm.active_pr = [];
                        vm.active_po = [];
                        vm.active_gr = [];
                        vm.active_mr = [];
                        vm.active_gi = [];
                        vm.active_prod = [];

                        vm.active_pr = temp_pr;
                        vm.active_po = temp_po;
                        vm.active_gr = temp_gr;
                        vm.active_mr = temp_mr;
                        vm.active_gi = temp_gi;
                        vm.active_prod = temp_prod;
                        $('#mm_prod_info').modal();
                    }
                }else{
                    if(id.indexOf("ACT") !== -1){
                        var temp_pr = [];
                        var temp_po = [];
                        var temp_gr = [];
                        var temp_mr = [];
                        var temp_gi = [];
                        var temp_prod = [];

                        vm.activities.forEach(activity => {
                            if(activity.code == id){
                                activity.activity_details.forEach(act_detail => {
                                    if(act_detail.material_id != null){
                                        act_detail.bom_prep.bom_details.forEach(bom_detail => {
                                            if(bom_detail.bom.purchase_requisition != null){
                                                temp_pr.push(bom_detail.bom.purchase_requisition);
                                                bom_detail.bom.purchase_requisition.purchase_orders.forEach(purchase_order => {
                                                    temp_po.push(purchase_order);
                                                    purchase_order.goods_receipts.forEach(gr => {
                                                        temp_gr.push(gr);
                                                    });
                                                });
                                            }
                                        });
                                    }
                                });
                                if(activity.wbs.production_order != null){
                                    temp_prod.push(activity.wbs.production_order);
                                }

                                var temp_mr_id = []
                                if(activity.wbs.material_requisition_details.length > 0){
                                    activity.wbs.material_requisition_details.forEach(mrd => {
                                        if(temp_mr_id.includes(mrd.material_requisition_id) == false){
                                            temp_mr_id.push(mrd.material_requisition_id);
                                            temp_mr.push(mrd.material_requisition);
                                        }
                                    });
                                }

                                temp_mr.forEach(mr => {
                                    mr.goods_issues.forEach(gi => {
                                    temp_gi.push(gi);
                                    });
                                });
                            }
                        });
                        vm.active_pr = [];
                        vm.active_po = [];
                        vm.active_gr = [];
                        vm.active_mr = [];
                        vm.active_gi = [];
                        vm.active_prod = [];

                        vm.active_pr = temp_pr;
                        vm.active_po = temp_po;
                        vm.active_gr = temp_gr;
                        vm.active_mr = temp_mr;
                        vm.active_gi = temp_gi;
                        vm.active_prod = temp_prod;
                        $('#mm_prod_info').modal();
                    }
                }
            }
            return true;
        });
    });

</script>
@endpush
