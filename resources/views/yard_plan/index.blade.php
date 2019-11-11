@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Yard Plan',
            'items' => [
                'Dashboard' => route('index'),
                'View all Yard Plan' => route('yard_plan.index'),
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
<div id="confirm_yard_plan">
    <div class="modal fade" id="confirm_yard_plan_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Confirm Yard Plan <b id="confirm_activity_code"></b></h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-sm-4">
                            <label for="planned_end_date" class="control-label">Start Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input autocomplete="off" type="text" v-model="confirmYardPlan.actual_start_date"  class="form-control datepicker" id="actual_start_date" placeholder="Insert Actual Start Date here...">                                                                                            
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="planned_end_date" class="control-label">End Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input autocomplete="off" type="text" v-model="confirmYardPlan.actual_end_date" class="form-control datepicker" id="actual_end_date" placeholder="Insert Actual End Date here...">                                                                                            
                            </div>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="duration" class=" control-label">Duration</label>
                            <input @keyup="setEndDate" @change="setEndDate" v-model="confirmYardPlan.actual_duration"  type="number" class="form-control" id="duration" placeholder="Duration" >                                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnSave" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="confirm">CONFIRM</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@endverbatim
<form id="form" class="form-horizontal" method="POST">
    <input type="hidden" name="_method" value="PATCH">
    @csrf
</form>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
        var yard_plans = @json($data);
        
        gantt.config.columns = [ 
            {name:"text", label:"Task name", width:"*", tree:true,
                template:function(obj){
                    var text = '<div class="tdEllipsis" data-placement="left" data-container="body" data-toggle="tooltip" title="'+obj.text+'"><b>'+obj.text+'</b></div>';
                    // console.log(text);
                    return text ;
                }
            },
            
        ]; 

        gantt.config.grid_width = 270;

        // gantt.templates.rightside_text = function(start, end, task){
        //     if(task.status != undefined){
        //         if(task.status == 0){
        //             var text = task.text.replace('[Actual]','');
        //             return "<b>"+text+" Completed</b>"
        //         }else{
        //             return "<b>"+task.text+"</b>"
        //         }
        //     }else{
        //         if(task.$level != 0){
        //             return "<b>"+task.text+"</b> | Progress: <b>" + task.progress*100+ "%</b>"
        //         }else{
        //             return "Progress: <b>" + task.progress*100+ "%</b>";
        //         }
        //     }
        // };

        // gantt.templates.task_text=function(start,end,task){
        //     if(task.$level == 0){
        //         return "<b>"+task.text+"</b>";
        //     }else{
        //         if(task.is_cpm){
        //             return "(!)";
        //         }else{
        //             return "";
        //         }
        //     }
        // };
        
        var tasks = {
            data:yard_plans,
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
            if(item.id.indexOf("Y-") != -1){
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
        gantt.config.show_errors = false;
        gantt.templates.task_class = function(start,end, task){
            if(task.id.indexOf("Y-") != -1) return 'hidden';
        };
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
            yard_plans : @json($yard_plans),
            today : @json($today),
            confirmYardPlan : {
                id : "",
                actual_start_date : "",
                actual_end_date : "",
                actual_duration : "",
            },
        };

        var vm = new Vue({
            el: '#confirm_yard_plan',
            data: data,
            mounted() {
                $('.datepicker').datepicker({
                    autoclose : true,
                    format : "dd-mm-yyyy"
                });
                $("#actual_start_date").datepicker().on(
                    "changeDate", () => {
                        this.confirmYardPlan.actual_start_date = $('#actual_start_date').val();
                        if(this.confirmYardPlan.actual_end_date != ""){
                            this.confirmYardPlan.actual_duration = datediff(parseDate(this.confirmYardPlan.actual_start_date), parseDate(this.confirmYardPlan.actual_end_date));
                        }
                        this.setEndDate();
                    }
                );
                $("#actual_end_date").datepicker().on(
                    "changeDate", () => {
                        this.confirmYardPlan.actual_end_date = $('#actual_end_date').val();
                        if(this.confirmYardPlan.actual_start_date != ""){
                            this.confirmYardPlan.actual_duration = datediff(parseDate(this.confirmYardPlan.actual_start_date), parseDate(this.confirmYardPlan.actual_end_date));
                        }
                    }
                );
            },
            computed:{
                confirmOk: function(){
                let isOk = false;
                    if(this.confirmYardPlan.actual_start_date == ""
                    || this.confirmYardPlan.actual_end_date == ""
                    || this.confirmYardPlan.actual_duration == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },  
            }, 
            methods:{
                tooltipText: function(text) {
                    return text
                },
                openConfirmModal(data){
                    
                },
                setEndDate(){
                    if(this.confirmYardPlan.actual_duration != "" && this.confirmYardPlan.actual_start_date != ""){
                        var actual_duration = parseInt(this.confirmYardPlan.actual_duration);
                        var actual_start_date = this.confirmYardPlan.actual_start_date;
                        var actual_end_date = new Date(actual_start_date.split("-").reverse().join("-"));
                        
                        actual_end_date.setDate(actual_end_date.getDate() + actual_duration-1);
                        $('#actual_end_date').datepicker('setDate', actual_end_date);
                    }else{
                        this.confirmYardPlan.actual_end_date = "";
                    }
                },
                confirm(){            
                    var confirmYardPlan = this.confirmYardPlan;
                    var url = "/yard_plan/confirmYardPlan/"+confirmYardPlan.id;
                    confirmYardPlan = JSON.stringify(confirmYardPlan);
                    window.axios.put(url,confirmYardPlan)
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

                        window.axios.get('/api/getDataYardPlan/').then(({ data }) => {
                            var tasks = {
                                data:data.data,
                            };
                            gantt.render();
                            gantt.parse(tasks);
                            
                            gantt.eachTask(function(task){
                                if(task.id.indexOf("Y-") !== -1){
                                    gantt.open(task.id);
                                }
                            })
                        });                     
                        
                        this.confirmYardPlan.id = "";
                        this.confirmYardPlan.actual_start_date = "";
                        this.confirmYardPlan.actual_end_date = "";
                        this.confirmYardPlan.actual_duration = "";
                    })
                    .catch((error) => {
                        console.log(error);
                    })

                }
            },
            watch: {
                confirmYardPlan:{
                    handler: function(newValue) {
                        this.confirmYardPlan.actual_duration = newValue.actual_duration+"".replace(/\D/g, "");
                        if(parseInt(newValue.actual_duration) < 1 ){
                            iziToast.warning({
                                displayMode: 'replace',
                                title: 'End Date cannot be ahead Start Date',
                                position: 'topRight',
                            });
                            this.confirmYardPlan.actual_duration = "";
                            this.confirmYardPlan.actual_end_date = "";
                        }
                    },
                    deep: true
                },
            },
        });

        function parseDate(str) {
            var mdy = str.split('-');
            var date = new Date(mdy[2], mdy[1]-1, mdy[0]);
            return date;
        }

        //Additional Function
        function datediff(first, second) {
            // Take the difference between the dates and divide by milliseconds per day.
            // Round to nearest whole number to deal with DST.
            return Math.round(((second-first)/(1000*60*60*24))+1);
        }

        gantt.attachEvent("onTaskClick", function(id,e){
            if(e.target.classList[0] != "gantt_tree_icon"){
                if(id.indexOf('YP-') !== -1){
                    var yard_plan_id = id.split("-")[1];
                    vm.confirmYardPlan.id = yard_plan_id;
                    vm.yard_plans.forEach(yard_plan => {
                        if(yard_plan_id == yard_plan.id){
                            if(yard_plan.actual_start_date != null){
                                var actual_start_date = new Date(yard_plan.actual_start_date);
                                $('#actual_start_date').datepicker('setDate', actual_start_date);

                                var actual_end_date = new Date(yard_plan.actual_end_date);
                                $('#actual_end_date').datepicker('setDate', actual_end_date);
                            }else{
                                var planned_start_date = new Date(yard_plan.planned_start_date);
                                $('#actual_start_date').datepicker('setDate', planned_start_date);
                                var planned_end_date = new Date(yard_plan.planned_end_date);
                                $('#actual_end_date').datepicker('setDate', planned_end_date);
                            }
                        }
                    });
                    $('#confirm_yard_plan_modal').modal();

                }
            }
            return true;
        });
        
    });
</script>
@endpush