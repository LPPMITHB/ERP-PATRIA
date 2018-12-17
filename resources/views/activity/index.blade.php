@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Activities',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show', ['id' => $project->id]),
            'Select WBS' => route('activity.listWBS',['id'=>$project->id,'menu'=>'viewAct']),
            'View Activities' => ""
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
                <div class="col-xs-12 col-lg-6 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Code</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>

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

                <div class="col-xs-12 col-lg-6 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Name</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$wbs->name}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Description</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$wbs->description}}"><b>: {{$wbs->description}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Deliverables</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$wbs->deliverables}}"><b>: {{$wbs->deliverables}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Deadline</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_deadline);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-xs-4 no-padding">Progress</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$wbs->progress}} %</b></div>
                    </div>
                </div>

            </div>
            @verbatim
            <div id="add_activity">
                <div class="box-body">
                    <h4 class="box-title">List of Activities (Weight : <b>{{totalWeight}}%</b> / <b>{{wbsWeight}}%</b>)</h4>
                    <table id="activity-table" class="table table-bordered tableFixed">
                        <thead>
                            <tr>
                                    <th style="width: 4%">No</th>
                                    <th style="width: 14%">Name</th>
                                    <th style="width: 16%">Description</th>
                                    <th style="width: 10%">Start Date</th>
                                    <th style="width: 10%">End Date</th>
                                    <th >Duration</th>
                                    <th >Weight</th>
                                    <th style="width: 19%">Predecessor</th> 
                                    <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td>{{ data.planned_start_date }}</td>
                                <td>{{ data.planned_end_date }}</td>
                                <td>{{ data.planned_duration }}</td>
                                <td>{{ data.weight }} %</td>
                                <template v-if="data.predecessor != null">
                                    <td class="p-l-5">
                                        <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#predecessor_activity"  @click="openModalPredecessor(data)">VIEW PREDECESSOR ACTIVITIES</button>
                                    </td>
                                </template>
                                <template v-else>
                                    <td>-</td>
                                </template>
                                <td class="textCenter">
                                    <a class="btn btn-primary btn-xs" :href="createRouteView(data.id)" >VIEW</a>
                                    <button class="btn btn-primary btn-xs mobile_button_view" data-toggle="modal" data-target="#edit_activity"  @click="openModalEditActivity(data)">EDIT</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="modal fade" id="predecessor_activity">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Predecessor Activities for <b id="activity_code"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="box-body">
                                        <table class="table table-bordered tableFixed">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30px">No</th>
                                                    <th>Code</th>
                                                    <th style="width: 25%">Name</th>
                                                    <th style="width: 30%">Description</th>
                                                    <th>WBS Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(data,index) in predecessorTableView">
                                                    <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                    <td class="p-b-15 p-t-15">{{ data.code }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.name)">{{ data.wbs.name}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="modal fade" id="edit_activity">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Activity <b id="edit_activity_code"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="p-l-0 form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <textarea id="name" v-model="editActivity.name" class="form-control" rows="2" placeholder="Insert Name Here..."></textarea>                                                
                                    </div>

                                    <div class="p-l-0 form-group">
                                        <label for="description" class=" control-label">Description</label>
                                        <textarea id="description" v-model="editActivity.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>                                                
                                    </div>

                                    <div class="p-l-0 form-group col-sm-3">
                                            <label for="edit_planned_start_date" class=" control-label">Start Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input v-model="editActivity.planned_start_date" type="text" class="form-control datepicker" id="edit_planned_start_date" placeholder="Insert Start Date here...">                                             
                                            </div>
                                        </div>
                                                
                                        <div class="p-l-0 form-group col-sm-3">
                                            <label for="edit_planned_end_date" class=" control-label">End Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input v-model="editActivity.planned_end_date" type="text" class="form-control datepicker" id="edit_planned_end_date" placeholder="Insert End Date here...">                                                                                            
                                            </div>
                                        </div>
                                        
                                        <div class="p-l-0 form-group col-sm-3">
                                            <label for="duration" class=" control-label">Duration</label>
                                            <input @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="editActivity.planned_duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >                                        
                                        </div>
                                            
                                        <div class="p-l-0 form-group col-sm-3">
                                            <label for="weight" class=" control-label">Weight</label>
                                            <input v-model="editActivity.weight"  type="text" class="form-control" id="edit_weight" placeholder="Weight" >                                        
                                        </div>
                                        
                                    <div class="p-l-0 form-group col-sm-10">
                                        <label for="predecessor" class="control-label">Predecessor</label>
                                        <selectize id="predecessor" v-model="editActivity.predecessor" :settings="indexActivitiesSettings">
                                            <option v-for="(activity, index) in allActivitiesEdit" :value="activity.id">{{ activity.name }}</option>
                                        </selectize>
                                    </div>  
                                    <div class="p-l-0 form-group col-sm-2 m-t-25">
                                        <button type="button" class="btn btn-primary" @click="refreshEdit">RESET</button>
                                    </div> 

                                            
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="p-l-5" style="width: 5%">No</th>
                                                <th style="width: 16%">Code</th>
                                                <th style="width: 26%">Name</th>
                                                <th style="width: 30%">Description</th>
                                                <th style="width: 23%">WBS Code</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in predecessorTableEdit">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="p-b-15 p-t-15">{{ data.code }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="#add_dependent_activity" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.name)">{{ data.wbs.name}}</td>
                                            </tr>
                                        </tbody>
                                    </table>                                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="update">SAVE</button>
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
    wbsWeight : @json($wbs->weight),
    project_id: @json($project->id),
    activities : [],
    allActivities : [],
    allActivitiesEdit: [],
    wbs_id : @json($wbs->id),
    editActivity : {
        activity_id : "",
        name : "",
        description : "",
        planned_start_date : "",
        planned_end_date : "",
        planned_duration : "",
        predecessor : null,
        weight : "",
    },
    indexActivitiesSettings: {
        placeholder: 'Insert Predecessor Here...',
        maxItems : null,
        dropdownDirection : "auto",
        plugins: ['remove_button'],
    },
    predecessorTable: [],
    predecessorTableView :[],
    predecessorTableEdit:[],
    maxWeight : 0,
    totalWeight : 0,
    constWeightAct : 0,
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'             
    })
})

var vm = new Vue({
    el: '#add_activity',
    data: data,
    mounted() {
        $('.datepicker').datepicker({
            autoclose : true,
        });

        $("#edit_planned_start_date").datepicker().on(
            "changeDate", () => {
                this.editActivity.planned_start_date = $('#edit_planned_start_date').val();
                if(this.editActivity.planned_end_date != ""){
                    this.editActivity.planned_duration = datediff(parseDate(this.editActivity.planned_start_date), parseDate(this.editActivity.planned_end_date));
                }
                this.setEndDateEdit();
            }
        );
        $("#edit_planned_end_date").datepicker().on(
            "changeDate", () => {
                this.editActivity.planned_end_date = $('#edit_planned_end_date').val();
                if(this.editActivity.planned_start_date != ""){
                    this.editActivity.planned_duration = datediff(parseDate(this.editActivity.planned_start_date), parseDate(this.editActivity.planned_end_date));
                }
            }
        );
    },
    computed:{
        // updateOk: function(){
        //     let isOk = false;
        //         if(this.dataUpd.uom_id == ""
        //         || this.dataUpd.standard_price.replace(/,/g , '') < 1)
        //         {
        //             isOk = true;
        //         }
        //     return isOk;
        // },

    }, 
    methods:{
        createRouteView(data){
            return "/activity/show/"+data;
        },
        refreshEdit() {
            this.editActivity.predecessor = null;
        },
        tooltipText: function(text) {
            return text
        },
        openModalPredecessor(data){
            this.predecessorTableView = [];
            document.getElementById("activity_code").innerHTML= data.code;
            var predecessorObj = JSON.parse(data.predecessor);
            if(predecessorObj.length > 0){
                predecessorObj.forEach(predecessor => {
                    this.allActivities.forEach(activityRef => {
                        if(predecessor==activityRef.id){
                            this.predecessorTableView.push(activityRef);
                        } 
                    });
                });
            }
        },
        openModalEditActivity(data){
            window.axios.get('/api/getAllActivitiesEdit/'+this.project_id+'/'+data.id).then(({ data }) => {
                this.allActivitiesEdit = data;
            });
            document.getElementById("edit_activity_code").innerHTML= data.code;
            this.editActivity.activity_id = data.id;
            this.editActivity.name = data.name;
            this.editActivity.description = data.description;
            this.editActivity.weight = data.weight;
            this.constWeightAct = data.weight;
            $('#edit_planned_start_date').datepicker('setDate', new Date(data.planned_start_date));
            $('#edit_planned_end_date').datepicker('setDate', new Date(data.planned_end_date));
            var predecessorObj = JSON.parse(data.predecessor);
            this.editActivity.predecessor  = predecessorObj;
        },
        setEndDateEdit(){
            if(this.editActivity.planned_duration != "" && this.editActivity.planned_start_date != ""){
                var planned_duration = parseInt(this.editActivity.planned_duration);
                var planned_start_date = this.editActivity.planned_start_date;
                var planned_end_date = new Date(planned_start_date);
                
                planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
                $('#edit_planned_end_date').datepicker('setDate', planned_end_date);
            }else{
                this.editActivity.planned_end_date = "";
            }
        },
        getAllActivities(){
            window.axios.get('/api/getAllActivities/'+this.project_id).then(({ data }) => {
                this.allActivities = data;
                this.allActivitiesEdit = data;
            });
        },
        getActivities(){
            window.axios.get('/api/getWeightWbs/'+this.wbs_id).then(({ data }) => {
                this.totalWeight = data;
            })
            window.axios.get('/api/getActivities/'+this.wbs_id).then(({ data }) => {
                this.activities = data;
                this.getAllActivities();

                this.maxWeight = roundNumber((this.wbsWeight-this.totalWeight),2);
                $('#activity-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#activity-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                        columnDefs : [
                            { targets: 0, sortable: false},
                        ]
                    });
                })
            });

        },
        update(){            
            var editActivity = this.editActivity;
            var url = "/activity/update/"+editActivity.activity_id;
            editActivity = JSON.stringify(editActivity);
            $('div.overlay').show();            
            window.axios.patch(url,editActivity)
            .then((response) => {
                if(response.data.error != undefined){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: response.data.error,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();            
                }else{
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();            
                }
                
                this.getActivities();   
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })

        }
    },
    watch: {
        editActivity:{
            handler: function(newValue) {
                this.editActivity.planned_duration = newValue.planned_duration+"".replace(/\D/g, "");
                if(parseInt(newValue.planned_duration) < 1 ){
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
                    this.editActivity.planned_duration = "";
                    this.editActivity.planned_end_date = "";
                    this.editActivity.planned_start_date = "";
                }
            },
            deep: true
        },
        'editActivity.predecessor': function(newValue){
            this.predecessorTableEdit = [];
            if(newValue != null){
                newValue.forEach(elementpredecessor => {
                    this.allActivities.forEach(elementactivities => {
                        if(elementpredecessor == elementactivities.id){
                            this.predecessorTableEdit.push(elementactivities);
                        }
                    });
                });
            }
        },
        'editActivity.weight': function(newValue){
            this.editActivity.weight = (this.editActivity.weight+"").replace(/[^0-9.]/g, "");  
            window.axios.get('/api/getWeightWbs/'+this.wbs_id).then(({ data }) => {
                this.totalWeight = data;
                var totalEdit = roundNumber(data - this.constWeightAct,2);
                maxWeightEdit = roundNumber(this.wbsWeight - totalEdit,2); 
                if(this.editActivity.weight>maxWeightEdit){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'Total weight cannot be more than '+this.wbsWeight+'%',
                        position: 'topRight',
                    });
                }
            });
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

function roundNumber(num, scale) {
  if(!("" + num).includes("e")) {
    return +(Math.round(num + "e+" + scale)  + "e-" + scale);
  } else {
    var arr = ("" + num).split("e");
    var sig = ""
    if(+arr[1] + scale > 0) {
      sig = "+";
    }
    return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
  }
}
</script>
@endpush