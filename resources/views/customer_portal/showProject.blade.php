@extends('layouts.main')

@section('content-header')
    @if ($menu == "building")
        @breadcrumb(
            [
                'title' => 'Show Project » '.$project->businessUnit->name.' » '.$project->name." (".$project->person_in_charge.")",
                'items' => [
                    'View All Projects' => route('customer_portal.selectProject'),
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
                    'View All Projects' => route('customer_portal.selectProject'),
                    'Project' => route('project_repair.show', ['id' => $project->id]),
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection

@section('content')
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
            </div>
        </div>
    </div>
</div>
@verbatim
<div id="customer_portal_show">
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

    var progressCanvas = $('#progress').get(0).getContext('2d');

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
            havePredecessor : false,
            str_expected_date : @json($str_expected_date),
            expectedStatus : @json($expectedStatus),
        };
        var vm = new Vue({
            el: '#customer_portal_show',
            data: data,
            mounted() {
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
            },
            watch: {
                
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

    });

</script>
@endpush
