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
            @verbatim
                <div id="summary_report">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#last_status" data-toggle="tab" aria-expanded="true">By WBS</a></li>
                                <li class=""><a href="#qc_type" data-toggle="tab" aria-expanded="false">By QC Type</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="last_status">
                                    <div id="treeview">
                                    
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="qc_type">
                                    <div class="box-body">
                                        
                                        <h4>Summary Rejection Rate : <b>{{rejection_ratio}}</b></h4>
                                        <h5>Approved : <b>{{approved}}</b></h5>
                                        <h5>Rejected : <b>{{rejected}}</b></h5>
                                        <div id="table-scroll" class="table-scroll ">
                                            <div class="table-wrap">
                                                <table class="main-table tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 200px" rowspan="2" class="fixed-side" scope="col">&nbsp;</th>
                                                            <th v-for="(data,index) in model_qc_tasks" :colspan="data.quality_control_type.quality_control_type_details.length"
                                                                class="textCenter tdEllipsis" scope="col" width="300px" data-container="body" v-tooltip:top="tooltipText(data.quality_control_type.name+' - '+data.quality_control_type.description)">{{data.quality_control_type.name}} -
                                                                {{data.quality_control_type.description}}</th>
                                                        </tr>
                                                        <tr>
                                                            <template v-for="(data,index) in model_qc_tasks">
                                                                <th v-for="(data_detail,index) in data.quality_control_type.quality_control_type_details" class="textCenter tdEllipsis" scope="col"
                                                                data-container="body" v-tooltip:top="tooltipText(data_detail.name+' - '+data_detail.task_description)"
                                                                >
                                                                    {{data_detail.name}} - {{data_detail.task_description}}</th>
                                                            </template>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(data_wbs,index) in wbss">
                                                            <td style="width: 200px" class="fixed-side tdEllipsis" width="200px" 
                                                            data-container="body" v-tooltip:top="tooltipText(data_wbs.number+' - '+data_wbs.description)">{{data_wbs.number}} - {{data_wbs.description}}</td>
                                                            <template v-for="(data_qc_task,index) in model_qc_tasks">
                                                                <td v-if="data_wbs.id == data_qc_task.wbs_id" v-for="(data_detail,index) in data_qc_task.quality_control_task_details"
                                                                    class="textCenter tdEllipsis" scope="col" >
                                                                    <b v-if="data_detail.status_first == 'OK'" class="text-success">OK</b>
                                                                    <b v-else-if="data_detail.status_first == 'NOT OK'" class="text-danger">NOT OK</b>
                                                                </td>
                                                                <td v-else class="textCenter">-</td>
                                                            </template>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                                            <a class="col-xs-12 col-md-2 btn btn-primary pull-right" target="_blank"
                                                :href="routeToExport(project.id)">EXPORT TO EXCEL</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
        
                        <div class="modal fade" id="detail_modal">
                            <div class="modal-dialog modalFull">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Quality Control Task</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Description</label>
                                                <p>{{detail_data.description}}</p>
                                            </div>
                        
                                            <div class="col-sm-12" >
                                                <label for="quantity" class="control-label">Quality Control Task Details</label>
                                                <table id="qc_task_detail_table" class="table table-bordered showTable" style="border-collapse:collapse; table-layout:fixed;">
                                                    <thead>
                                                        <tr>
                                                            <th class="p-l-5" style="width: 5%">No</th>
                                                            <th style="width: 25%">Name</th>
                                                            <th style="width: 30%">Description</th>
                                                            <th style="width: 10%">First Status</th>
                                                            <th style="width: 10%">Second Status</th>
                                                            <th style="width: 30%">Notes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(data,index) in detail_data.qc_task_detail">
                                                            <td>{{ index + 1 }}</td>
                                                            <td class="tdEllipsis">{{ data.name }}</td>
                                                            <td class="tdEllipsis">{{ data.description }}</td>
                                                            <td class="tdEllipsis" v-if="data.status_first == null">NOT DONE</td>
                                                            <td class="tdEllipsis" v-else>
                                                                <b v-if="data.status_first == 'OK'" class="text-success">
                                                                    {{data.status_first}}
                                                                </b>
                                                                <b v-else-if="data.status_first == 'NOT OK'" class="text-danger">
                                                                    {{data.status_first}}
                                                                </b>
                                                            </td>
                                                            <td class="tdEllipsis" v-if="data.status_second == null">-</td>
                                                            <td class="tdEllipsis" v-else>
                                                                <b v-if="data.status_second == 'OK'" class="text-success">
                                                                    {{data.status_second}}
                                                                </b>
                                                                <b v-else-if="data.status_second == 'NOT OK'" class="text-danger">
                                                                    {{data.status_second}}
                                                                </b>
                                                            </td>
                                                            <td class="tdEllipsis">{{data.notes}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>  
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            @endverbatim
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
        // requires jquery library
        jQuery(document).ready(function() {
            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
        });
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

        $('#qc_task_detail_table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            },
            "columnDefs": [
                { "searchable": false, "targets": [3,4,0] },
                { "orderable": false, "targets": [3,4] }
            ]
        });
    });

    function loading() {
        $('div.overlay').show();
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var data = {
        model_qc_tasks : @json($modelQcTasks),      
        detail_data : {
            name : "",
            description : "",
            status : "",
            notes : "",
            qc_task_detail : [],
        },
        wbss : @json($wbss),
        rejection_ratio : @json($rejection_ratio),
        approved : @json($approved),
        rejected : @json($rejected),
        route : @json($route),
        project : @json($project),
    }

    var vm = new Vue({
        el : '#summary_report',
        data : data,
        mounted: function(){
            var data = @json($data);

            $('#treeview').jstree({
                "core": {
                    "data": data,
                    "check_callback": true,
                    "animation": 200,
                    "dblclick_toggle": false,
                    "keep_selected_style": false
                },
                "plugins": ["dnd", "contextmenu"],
                "contextmenu": {
                    "select_node": false, 
                    "show_at_node": false,
                }
            }).bind("changed.jstree", function (e, data) {
                if(data.node) {
                    document.location = data.node.a_attr.href;
                }
            }).bind("loaded.jstree", function (event, data) {
                $(this).jstree("open_all");
            });
            $('div.overlay').hide();

            $('#treeview').on("select_node.jstree", function (e, data) {
                vm.model_qc_tasks.forEach(qc_task => {
                    if(data.node.original.qc_task_id == qc_task.id){
                        vm.openDetailModal(qc_task);
                    }
                });
            });
        },
        computed : {

        },
        methods : {
            routeToExport(project_id){
                var route = "";
                if(this.route == "/qc_task"){
                    route = "/qc_task/exportToExcel/"+project_id;
                }

                return route;
            },
            tooltipText(text){
                return text;
            },
            openDetailModal(data){
                this.detail_data.name = data.name;
                this.detail_data.description = data.description;
                this.detail_data.status = data.status;
                this.detail_data.notes = data.notes;
                this.detail_data.qc_task_detail = data.quality_control_task_details;

                $('#detail_modal').modal();
            },
        },
        watch : {
        },
        created : function(){ 
        },
    })
</script>
@endpush