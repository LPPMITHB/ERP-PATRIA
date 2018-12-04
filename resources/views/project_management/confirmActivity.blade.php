@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Confirm Activities',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.indexConfirm'),
            'Select WBS' => route('project.selectWBS',['id'=>$project->id]),
            'Confirm Activities' => ""
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
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Code</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->code}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->ship->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Name</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$work->name}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Description</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$work->description}}"><b>: {{$work->description}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Deliverables</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$work->deliverables}}"><b>: {{$work->deliverables}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Deadline</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $work->planned_deadline);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-xs-4 no-padding">Progress</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$work->progress}} %</b></div>
                    </div>
                </div>
            </div>
            @verbatim
            <div id="confirm_activity">
                <div class="box-body">
                    <h4 class="box-title">List of Activities</h4>
                    <table id="activity-table" class="table table-bordered" >
                        <thead>
                            <tr>
                                <th style="width: 4%">No</th>
                                <th style="width: 35%">Name</th>
                                <th style="width: 40%">Description</th>
                                <th style="width: 8%">Status</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities" class="popoverData"  data-content="" v-on:mouseover="dataForTooltip(data)" data-trigger="hover" rel="popover" data-placement="auto top" data-original-title="Details">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="textCenter">
                                    <template v-if="data.status == 0">
                                        <i class='fa fa-check'></i>
                                    </template>
                                    <template v-else>
                                        <i class='fa fa-times'></i>
                                    </template>
                                </td>
                                <td class="textCenter">
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#confirm_activity_modal"  @click="openConfirmModal(data)">CONFIRM</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

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
                                                <input :disabled="alreadyStart" v-model="confirmActivity.actual_end_date" type="text" class="form-control datepicker" id="actual_end_date" placeholder="End Date">                                                                                            
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="duration" class=" control-label">Actual Duration</label>
                                            <input :disabled="alreadyStart" @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="confirmActivity.actual_duration"  type="number" class="form-control" id="actual_duration" placeholder="Duration" >                                        
                                        </div> 
                                        <div class="form-group col-sm-6">
                                            <label for="duration" class=" control-label">Current Progress (%)</label>
                                            <input :disabled="alreadyStart" v-model="confirmActivity.current_progress"  type="number" class="form-control" id="current_progress" placeholder="Current Progress" >                                        
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
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div id="myPopoverContent" style="display : none;">
                
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
$(document).ready(function(){
    $('div.overlay').hide();
});

var data = {
    work_id: @json($work->id),
    predecessorActivities : [],
    activities : [],
    confirmActivity : {
        activity_id : "",
        actual_start_date : "",
        actual_end_date : "",
        actual_duration : "",
        current_progress : "",
    },
    havePredecessor : false,
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'             
    })
})

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
                    this.confirmActivity.current_progress = 100;
                    this.confirmActivity.actual_duration = datediff(parseDate(this.confirmActivity.actual_start_date), parseDate(this.confirmActivity.actual_end_date));
                }else{
                    this.confirmActivity.actual_duration ="";
                    this.confirmActivity.current_progress = 0;
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
        predecessorStatusCheck: function(){
            
        },
    }, 
    methods:{
        tooltipText: function(text) {
            return text
        },
        openConfirmModal(data){
            this.predecessorTableView = [];
            if(data.predecessor != null){
                this.havePredecessor = true;
                window.axios.get('/project/getPredecessor/'+data.id).then(({ data }) => {
                    this.predecessorActivities = data;
                });
            }else{
                this.havePredecessor = false;
            }
            document.getElementById("confirm_activity_code").innerHTML= data.code;
            document.getElementById("planned_start_date").innerHTML= data.planned_start_date;
            document.getElementById("planned_end_date").innerHTML= data.planned_end_date;
            document.getElementById("planned_duration").innerHTML= data.planned_duration+" Days";


            this.confirmActivity.activity_id = data.id;
            $('#actual_start_date').datepicker('setDate', (data.actual_start_date != null ? new Date(data.actual_start_date):new Date(data.planned_start_date)));
            $('#actual_end_date').datepicker('setDate', (data.actual_end_date != null ? new Date(data.actual_end_date):null));

        },
        setEndDateEdit(){
            if(this.confirmActivity.actual_duration != "" && this.confirmActivity.actual_start_date != ""){
                var actual_duration = parseInt(this.confirmActivity.actual_duration);
                var actual_start_date = this.confirmActivity.actual_start_date;
                var actual_end_date = new Date(actual_start_date);
                
                actual_end_date.setDate(actual_end_date.getDate() + actual_duration-1);
                $('#actual_end_date').datepicker('setDate', actual_end_date);
                this.confirmActivity.current_progress = 100;

            }else{
                this.confirmActivity.actual_end_date = "";
                this.confirmActivity.current_progress = 0;
            }
        },
        dataForTooltip(data){
            var status = "";
            if(data.status == 1){
                status = "Open";
            }else if(data.status == 0){
                status = "Closed";
            }

            var actual_duration = "-";
            if(data.actual_duration != null){
                actual_duration = data.actual_duration+" Days";
            }

            var actual_start_date = "-";
            if(data.actual_start_date != null){
                actual_start_date = data.actual_start_date;
            }

            var actual_end_date = "-";
            if(data.actual_end_date != null){
                actual_end_date = data.actual_end_date;
            }

            var text = '<table style="table-layout:fixed; width:100%"><thead><th style="width:35%">Attribute</th><th style="width:5%"></th><th>Value</th></thead><tbody><tr><td>Code</td><td>:</td><td>'+data.code+
            '</td></tr><tr><td class="valignTop">Name</td><td class="valignTop" style="overflow-wrap: break-word;">:</td><td>'+data.name+
            '</td></tr><tr><td class="valignTop">Description</td><td class="valignTop">:</td><td class="valignTop" style="overflow-wrap: break-word;">'+data.description+
            '</td></tr><tr><td>Status</td><td>:</td><td>'+status+
            '</td></tr><tr><td>Actual Duration</td><td>:</td><td>'+actual_duration+
            '</td></tr><tr><td>Actual Start Date</td><td>:</td><td>'+actual_start_date+
            '</td></tr><tr><td>Actual End Date</td><td>:</td><td>'+actual_end_date+
            '</td></tr><tr><td>Progress</td><td>:</td><td>'+data.progress+
            '%</td></tr></tbody></table>'
            
            function handlerMouseOver(ev) {
                $('.popoverData').popover({
                    html: true,
                });
                var target = $(ev.target);
                var target = target.parent();
                if(target.attr('class')=="popoverData odd"||target.attr('class')=="popoverData even"){
                    $(target).attr('data-content',text);
                    $(target).popover('show');
                }else{
                    $('.popoverData').popover('hide');
                }
            }
            $(".popoverData").mouseover(handlerMouseOver);

            function handlerMouseOut(ev) {
                var target = $(ev.target);
                var target = target.parent(); 
                if(target.attr('class')=="popoverData odd" || target.attr('class')=="popoverData even"){
                    $(target).attr('data-content',"");
                }
            }
            $(".popoverData").mouseout(handlerMouseOut);
        },
        getActivities(){
            window.axios.get('/project/getActivities/'+this.work_id).then(({ data }) => {
                this.activities = data;
                var dT = $('#activity-table').DataTable();
                dT.destroy();
                this.$nextTick(function() {
                    $('#activity-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                        'initComplete': function(){
                            $('div.overlay').remove();
                        },
                        columnDefs : [
                            { targets: 0, sortable: false},
                        ]
                    });
                })
            });

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
                
                this.getActivities();   
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
    created: function() {
        this.getActivities();
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
</script>
@endpush