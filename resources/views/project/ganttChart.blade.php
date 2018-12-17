@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Gantt Chart | '.$project->name,
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show',$project->id),
            'Gantt Chart' => route('project.showGanttChart', ['id' => $project->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body gantt_chart_mobile">
                <label>View by :</label>
                <label><input type="radio" name="scale" value="day" checked/>Day scale</label>
                <label><input type="radio" name="scale" value="month"/>Month scale</label>
                <label><input type="radio" name="scale" value="year"/>Year scale</label>
                <div class="col-sm-12 p-l-0">
                    <div id="ganttChart" class="width100" style="height: 496px"></div>
                </div>
            </div>
            <div class="box">
                <div class="box-body gantt_chart_mobile_notification">
                    <div class="col-xs-12 textCenter"><b>Please view Gantt Chart in Landscape Mode</b></div>
                </div>
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
                        <table class="table table-bordered">
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
                                    <td class="p-b-15 p-t-15">{{ data.wbs.code }}</td>
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
@endsection

@push('script')
<script>
    $(document).ready(function(){
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
            }, 
            methods:{
                tooltipText: function(text) {
                    return text
                },
                openConfirmModal: function(data){
                    axios.get('/api/getActivity/'+data).then(({ data }) => {
                        this.activity = data[0];
                        if(this.activity.predecessor != null){
                            this.havePredecessor = true;
                            axios.get('/api/getPredecessor/'+this.activity.id).then(({ data }) => {
                                this.predecessorActivities = data;
                            });
                        }else{
                            this.havePredecessor = false;
                            this.predecessorActivities = [];
                        }

                        this.confirmActivity.current_progress = this.activity.progress;
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
                    var url = "/activity/updateActualActivity/"+confirmActivity.activity_id;
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
                vm.openConfirmModal(id);
                $("#confirm_activity_modal").modal('show');
                return true;
            }else{
                return true;
            }
        });
    });
</script>
@endpush