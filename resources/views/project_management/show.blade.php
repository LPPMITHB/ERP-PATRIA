@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Show Project',
        'items' => [
            'Dashboard' => route('index'),
            'View All Projects' => route('project.index'),
            'Project' => route('project.show', ['id' => $project->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="box-tools pull-left m-l-15">
            <a href="{{ route('project.showGanttChart',['id'=>$project->id]) }}" class="btn btn-primary btn-sm">VIEW GANTT CHART</a>
            <a href="{{ route('project.createWBS',['id'=>$project->id]) }}" class="btn btn-primary btn-sm">ADD WBS</a>
            <a href="{{ route('project.indexWBS',['id'=>$project->id]) }}" class="btn btn-primary btn-sm">VIEW WBS</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'addAct']) }}" class="btn btn-primary btn-sm">ADD ACTIVITIES</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'viewAct']) }}" class="btn btn-primary btn-sm">VIEW ACTIVITIES</a>
            <a href="{{ route('project.listWBS',['id'=>$project->id,'menu'=>'mngNet']) }}" class="btn btn-primary btn-sm">MANAGE NETWORK</a>
            <a href="{{ route('project.projectCE',['id'=>$project->id]) }}" class="btn btn-primary btn-sm">PROJECT COST EVALUATION</a>
    </div>
    <div class="box-tools pull-right m-r-15">
        @can('edit-project')
            <a href="{{ route('project.edit',['id'=>$project->id]) }}" class="btn btn-primary btn-sm">Edit</a>
        @endcan

        <!-- @can('destroy-project')
            <button class="btn btn-danger btn-sm" onclick="event.preventDefault();document.getElementById('delete-form-{{ $project->id }}').submit();">Delete</button>
        @endcan

        <form id="delete-form-{{ $project->id }}" action="{{ route('project.destroy', ['id' => $project->id]) }}" method="POST" style="display: none;">
            <input type="hidden" name="_method" value="DELETE">
            @csrf
        </form> -->
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="col-sm-4">
                    <table class="tableFixed width100">
                        <tbody>
                            <tr>
                                <td style="width: 35%">Project Code</td>
                                <td style="width: 3%">:</td>
                                <td style="width: 62%"><b>{{$project->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Project Name</td>
                                <td>:</td>
                                <td><b>{{$project->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship Name</td>
                                <td>:</td>
                                <td><b>{{$project->ship->name}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Customer Name</td>
                                <td class="valignTop">:</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>{{$project->customer->name}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Description</td>
                                <td class="valignTop">:</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->description}}"><b>{{$project->description}}</b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td><b>{{$project->status = 1 ? "Open" : "Closed" }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-4">
                    <table class="tableFixed width100">
                        <tbody>
                            <tr>
                                <td style="width: 37%">Planned Start Date</td>
                                <td style="width: 3%">:</td>
                                <td style="width: 60%"><b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td><b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned Duration</td>
                                <td>:</td>
                                <td><b>{{$project->planned_duration}} Days</b></td>
                            </tr>
                            <tr>
                                <td>Actual Start Date</td>
                                <td>:</td>
                                <td><b>@if($project->actual_start_date != null)@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->actual_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                        @endif
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Actual End Date</td>
                                <td>:</td>
                                <td><b>@if($project->actual_end_date != null)@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->actual_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                        @endif
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Actual Duration</td>
                                <td>:</td>
                                <td><b>{{$project->actual_duration != null ? $project->actual_duration. " Days" : "" }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-4">
                    <table class="tableFixed width100">
                        <tbody>
                            <tr>
                                <td style="width: 37%">Owner CP</td>
                                <td style="width: 3%">:</td>
                                <td style="width: 60%"><b>{{$project->customer->contact_person_name}} - {{$project->customer->contact_person_phone}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Flag</td>
                                <td>:</td>
                                <td><b>{{$project->flag}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Class Name</td>
                                <td>:</td>
                                <td><b>{{$project->class_name}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Class CP Name</td>
                                <td>:</td>
                                <td><b>{{$project->class_contact_person_name}}</b></td>
                            </tr>
                            <tr>
                                <td>Class CP Phone</td>
                                <td>:</td>
                                <td><b>{{$project->class_contact_person_phone}}</b></td>
                            </tr>
                            <tr>
                                <td>Class CP Email</td>
                                <td>:</td>
                                <td><b>{{$project->class_contact_person_email}}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-body">
                <div class="col-sm-12">
                    <table class="marginAuto">
                        <tbody>
                            <tr>
                                <td class="textCenter"><h3 style="margin-top: -1%;">PROGRESS ({{$project->progress}} %)</h3></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="progress" style="height:20px">
                        @if($project->planned_end_date < $today)
                            <div class="progress-bar progress-bar-danger" role="progressbar" style="width: {{$project->progress}}%" aria-valuenow="{{$project->progress}}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        @elseif($project->planned_end_date == $today)
                            <div class="progress-bar progress-bar-warning" role="progressbar" style="width: {{$project->progress}}%" aria-valuenow="{{$project->progress}}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        @else
                            <div class="progress-bar progress-bar-success" role="progressbar" style="width: {{$project->progress}}%" aria-valuenow="{{$project->progress}}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        @endif
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
        
<div class="row">
    <div class="col-sm-12" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border"><h4><b>Gantt Chartt</b></h4></div>
            <div class="box-body">
                <label>View by :</label>
                <label><input type="radio" name="scale" value="day" />Day scale</label>
                <label><input type="radio" name="scale" value="month" checked/>Month scale</label>
                <label><input type="radio" name="scale" value="year"/>Year scale</label>
                <div class="col-sm-12 no-padding-left">
                    <div id="ganttChart" style='width:100%; height:490px;'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border"><h4><b>Actual Cost Vs. Planned Cost</b></h4></div>
        <!-- /.box-header -->
        <div class="box-body" style="">
            <div class="row">
            <div class="col-md-12">
                <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="salesChart" width="703" height="200"></canvas>
                </div>
                <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
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
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col-sm-12" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border"><h4><b>Outstanding Item Report</b></h4></div>
            <div class="box-body">
                <div id="treeview">
                
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12" style="margin-top: -5px;">
        <div class="box box-solid">
            <div class="box-header with-border p-b-0"><h4><b>Completed WO Report</b></h4></div>
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
                        @foreach ($modelWO as $WO)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $WO->number }}</td>
                            <td>{{ $WO->created_at }}</td>
                            @if($WO->status == 1)
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

@verbatim
<div id="confirm_activity">
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
                        <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
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
                                    <td class="p-b-15 p-t-15">{{ data.code }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                    <td class="p-b-15 p-t-15">{{ data.work.code }}</td>
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
                        <div class="form-group col-sm-4">
                            <label for="actual_start_date" class=" control-label">Actual Start Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input v-model="confirmActivity.actual_start_date" type="text" class="form-control datepicker" id="actual_start_date" placeholder="Start Date">                                             
                            </div>
                        </div>
                                
                        <div class="form-group col-sm-4">
                            <label for="actual_end_date" class=" control-label">Actual End Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input :disabled="alreadyStart" v-model="confirmActivity.actual_end_date" type="text" class="form-control datepicker" id="actual_end_date" placeholder="End Date">                                                                                            
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-4">
                            <label for="duration" class=" control-label">Actual Duration</label>
                            <input :disabled="alreadyStart" @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="confirmActivity.actual_duration"  type="number" class="form-control" id="actual_duration" placeholder="Duration" >                                        
                        </div> 
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button :disabled="alreadyStart" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="confirm">SAVE</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@endverbatim


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

    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    var salesChart       = new Chart(salesChartCanvas, {
        type: 'line',
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [
            {
                label: "Planned Cost", 
                fill: true, 
                backgroundColor: "rgba(247, 247, 32, 0.7)", // <-- supposed to be light blue
                data: [567, 1232, 8987, 18722, 19882, 34000]
            },
            {
                label: "Actual Cost",
                fill: true,
                backgroundColor: "rgba(242, 38, 2, 0.7)",
                data: [499, 2980, 5667, 23455, 25678, 32000]
            }]
        },
        options: {
            scales: {
                xAxes: [{
                gridLines: {
                    display:false
                    }
                }],
                yAxes: [{
                    gridLines: {
                    display:false
                    },
                    ticks: {
                    beginAtZero:true
                    }
                }]
            } 
        }
    });
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
        var project = @json($data);
        var links = @json($links);
        gantt.config.columns = [ 
            {name:"text", label:"Task name", width:"*", tree:true,
                template:function(obj){
                    var text = '<div class="tdEllipsis" data-placement="left" data-container="body" data-toggle="tooltip" title="'+obj.text+'"><b>'+obj.text+'</b></div>';
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
            } 
        ]; 

        gantt.config.grid_width = 270;

        

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
            if(item.id.indexOf("PRW") != -1){
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
            project_id : @json($project->id),
            predecessorActivities : [],
            activity:"",
            confirmActivity : {
                activity_id : "",
                actual_start_date : "",
                actual_end_date : "",
                actual_duration : "",
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
                alreadyStart: function(){
                    let isOkAlreadyStart = false;
                    if(this.confirmActivity.actual_start_date == "")
                    {
                        isOkAlreadyStart = true;
                    }
                    
                    let isOkPredecessor = false;
                    
                    document.getElementById("actual_start_date").disabled = false;
                    
                    this.predecessorActivities.forEach(activity => {
                        if(activity.status == 1){
                            isOkPredecessor = true;
                            document.getElementById("actual_start_date").disabled = true;
                        }
                    });
                    return isOkAlreadyStart || isOkPredecessor;
                },
            }, 
            methods:{
                tooltipText: function(text) {
                    return text
                },
                openConfirmModal(data){
                    window.axios.get('/project/getActivity/'+data).then(({ data }) => {
                        this.activity = data[0];
                        this.predecessorTableView = [];
                        if(this.activity.predecessor != null){
                            this.havePredecessor = true;
                            window.axios.get('/project/getPredecessor/'+this.activity.id).then(({ data }) => {
                                this.predecessorActivities = data;
                            });
                        }else{
                            this.havePredecessor = false;
                            this.predecessorActivities = [];
                        }
                        document.getElementById("confirm_activity_code").innerHTML= this.activity.code;
                        document.getElementById("planned_start_date").innerHTML= this.activity.planned_start_date;
                        document.getElementById("planned_end_date").innerHTML= this.activity.planned_end_date;
                        document.getElementById("planned_duration").innerHTML= this.activity.planned_duration+" Days";
    
    
                        this.confirmActivity.activity_id = this.activity.id;
                        $('#actual_start_date').datepicker('setDate', (this.activity.actual_start_date != null ? new Date(this.activity.actual_start_date):new Date(this.activity.planned_start_date)));
                        $('#actual_end_date').datepicker('setDate', (this.activity.actual_end_date != null ? new Date(this.activity.actual_end_date):null));
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
                    var url = "/project/updateActualActivity/"+confirmActivity.activity_id;
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

                        window.axios.get('/project/getDataGantt/'+this.project_id).then(({ data }) => {
                            var tasks = {
                                data:data.data,
                                links:data.links
                            };
                            gantt.render();
                            gantt.parse(tasks);
                            gantt.eachTask(function(task){
                                if(task.id.indexOf("PRW") !== -1){
                                    gantt.open(task.id);
                                }
                            })
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
                        this.confirmActivity.actual_duration = newValue.actual_duration+"".replace(/\D/g, "");
                        if(parseInt(newValue.actual_duration) < 1 ){
                            iziToast.show({
                                timeout: 6000,
                                color : 'red',
                                displayMode: 'replace',
                                icon: 'fa fa-warning',
                                title: 'Warning !',
                                message: 'End Date cannot be ahead Start Date',
                                position: 'topRight',
                                progressBarColor: 'rgb(0, 255, 184)',
                            });
                            this.confirmActivity.actual_duration = "";
                            this.confirmActivity.actual_end_date = "";
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
            if(id.indexOf("PRA") !== -1){
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