@extends('layouts.main')

@section('content-header')
    @if ($menu == "building")
        @breadcrumb(
            [
                'title' => 'Show Project » '.$project->businessUnit->name.' » '.$project->name,
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
                'title' => 'Show Project » '.$project->businessUnit->name.' » '.$project->name,
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
            <a href="{{ route('wbs.createWBS',['id'=>$project->id]) }}" class="btn btn-primary btn-sm mobile_button_view m-t-5 ">ADD WBS</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'viewWbs']) }}" class="btn btn-primary btn-sm m-t-5 mobile_button_view">VIEW WBS</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'addAct']) }}" class="btn btn-primary btn-sm mobile_button_view m-t-5 ">ADD ACTIVITIES</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'viewAct']) }}" class="btn btn-primary btn-sm m-t-5 ">VIEW ACTIVITIES</a>
            <a href="{{ route('activity.manageNetwork',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 mobile_button_view">MANAGE NETWORK</a>
            <a href="{{ route('project.projectCE',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 mobile_device_potrait">PROJECT COST EVALUATION</a>
        </div>
    @else
        <div class="box-tools pull-left m-l-15">
            <a href="{{ route('project_repair.showGanttChart',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 ">VIEW GANTT CHART</a>
            <a href="{{ route('wbs_repair.createWBS',['id'=>$project->id]) }}" class="btn btn-primary btn-sm mobile_button_view m-t-5 ">ADD WBS</a>
            <a href="{{ route('project_repair.listWBS',['id'=>$project->id,'menu'=>'viewWbs']) }}" class="btn btn-primary btn-sm m-t-5 mobile_button_view">VIEW WBS</a>
            <a href="{{ route('project_repair.listWBS',['id'=>$project->id,'menu'=>'addAct']) }}" class="btn btn-primary btn-sm mobile_button_view m-t-5 ">ADD ACTIVITIES</a>
            <a href="{{ route('project_repair.listWBS',['id'=>$project->id,'menu'=>'viewAct']) }}" class="btn btn-primary btn-sm m-t-5 ">VIEW ACTIVITIES</a>
            <a href="{{ route('activity_repair.manageNetwork',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 mobile_button_view">MANAGE NETWORK</a>
            <a href="{{ route('project_repair.projectCE',['id'=>$project->id]) }}" class="btn btn-primary btn-sm m-t-5 mobile_device_potrait">PROJECT COST EVALUATION</a>
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

                        <div class="col-md-4 col-xs-6 no-padding">Customer Name</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Description</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->description}}"><b>: {{$project->description}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Status</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->status = 1 ? "Open" : "Closed" }}</b></div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3 col-md-12">    
                    <div class="box-body">
                        <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Planned Start Date</div>
                        <div class="col-md-8 col-lg-5 col-xs-6 no-padding"><b>: @php
                                    $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-lg-7 col-xs-6 no-padding">Planned End Date</div>
                        <div class="col-md-8 col-lg-5 col-xs-6 no-padding"><b>: @php
                                    $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                @endphp
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
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-body">
                        <div class="col-md-4 col-xs-6 no-padding">Owner CP</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->contact_person_name}} - {{$project->customer->contact_person_phone}}"><b>: {{$project->customer->contact_person_name}} - {{$project->customer->contact_person_phone}}</b></div>
                        
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
                            <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->class_contact_person_email}}</b></div>
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
    </div>
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
                                    <th style="width: 15%">WBS Code</th>
                                    <th style="width: 12%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data,index) in predecessorActivities">
                                    <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.code)">{{ data.wbs.code }}</td>
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
    <div class="col-sm-12" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border"><h4><b>Actual Cost Vs. Planned Cost</b></h4></div>
                <div class="box-body" style="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="cost" width="703" height="350"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="progress" width="703" height="350"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- ./box-body -->
        {{-- <div class="box-footer" style="">
            <div class="row">
            <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                <h5 class="description-header">$35,210.43</h5>
                <span class="description-text">TOTAL REVENUE</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                <h5 class="description-header">$10,390.90</h5>
                <span class="description-text">TOTAL COST</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                <h5 class="description-header">$24,813.53</h5>
                <span class="description-text">TOTAL PROFIT</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
                <div class="description-block">
                <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                <h5 class="description-header">1200</h5>
                <span class="description-text">GOAL COMPLETIONS</span>
                </div>
                <!-- /.description-block -->
            </div>
            </div>
            <!-- /.row -->
        </div> --}}
        <!-- /.box-footer -->
        </div>
    </div>
</div>

<div class="row">
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
</div>






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
        'initComplete': function(){
            $('div.overlay').hide();
        }
    });
    jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');

    var costCanvas = $('#cost').get(0).getContext('2d');
    var progressCanvas = $('#progress').get(0).getContext('2d');

    var configCost = {
        type: 'line',
        data: {
            datasets: [
                {
                    label: "Estimated Cost", 
                    backgroundColor: "rgba(247, 247, 32, 0.7)", // <-- supposed to be light blue
                    data: [],
                },
                {
                    label: "Planned Cost",
                    backgroundColor: "rgba(242, 38, 2, 0.7)",
                    data: @json($dataPlannedCost),
                },
                {
                    label: "Actual Cost",
                    backgroundColor: "rgba(0, 0, 255, 0.7)",
                    data: @json($dataActualCost),
                }
            ]
        },
        options: {
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
                        unit: 'month',
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
                       }    
                    }
                }]
            } 
        }
    };

    var costChart = new Chart(costCanvas, configCost);

    var configProgress = {
        type: 'line',
        data: {
            datasets: [
                {
                    label: "Planned Progress",
                    backgroundColor: "rgba(242, 38, 2, 0.7)",
                    data: @json($dataPlannedProgress),
                },
                {
                    label: "Actual Progress", 
                    backgroundColor: "rgba(0, 0, 255, 0.7)",
                    data: @json($dataActualProgress),
                }
            ]
        },
        options: {
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
                        unit: 'month',
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
                            return "<i class='fa fa-check'></i>"
                        }else{
                            return "<i class='fa fa-times'></i>"
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
                    return "<b>Completed</b>"
                }
            }else{
                return "Progress: <b>" + task.progress*100+ "%</b>";
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
                    window.axios.patch(url,confirmActivity)
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
            if(id.indexOf("ACT") !== -1){
                $("#confirm_activity_modal").modal('show');
                vm.openConfirmModal(id);
                return true;
            }else{
                return true;
            }
        });
    });
    
</script>
@endpush