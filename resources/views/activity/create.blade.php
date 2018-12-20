@extends('layouts.main')
@section('content-header')
    @if ($menu == "building")
        @breadcrumb(
            [
                'title' => "Add Activities",
                'items' => [
                    'Dashboard' => route('index'),
                    'View all Projects' => route('project.index'),
                    'Project|'.$project->number => route('project.show', ['id' => $project->id]),
                    'Select WBS' => route('project.listWBS',['id'=>$project->id,'menu'=>'addAct']),
                    'Add Activities' => ""
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [
                'title' => "Add Activities",
                'items' => [
                    'Dashboard' => route('index'),
                    'View all Projects' => route('project_repair.index'),
                    'Project|'.$project->number => route('project_repair.show', ['id' => $project->id]),
                    'Select WBS' => route('project_repair.listWBS',['id'=>$project->id,'menu'=>'addAct']),
                    'Add Activities' => ""
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <div class="col-sm-6">
                    <table>
                        <thead>
                            <th colspan="2">Project Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->number}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->ship->type}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->customer->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
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
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-sm-6">
                    <table>
                        <thead>
                            <th>WBS Information</th>
                            <th></th>
                            <th></th>
                        </thead>
                    </table>
                    <table class="tableFixed width100">
                        <tbody>
                            <tr>
                                <td style="width: 25%">Name</td>
                                <td style="width: 3%">:</td>
                                <td><b>{{$wbs->name}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Description</td>
                                <td class="valignTop">:</td>
                                <td class="valignTop" style="overflow-wrap: break-word;"><b >{{$wbs->description}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Deliverables</td>
                                <td class="valignTop">:</td>
                                <td class="valignTop" style="overflow-wrap: break-word;"><b >{{$wbs->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Deadline</td>
                                <td>:</td>
                                <td><b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_deadline);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td><b>{{$wbs->progress}} %</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @verbatim
            <div id="add_activity">
                <div class="box-body">
                    <h4 class="box-title">List of Activities (Weight : <b>{{totalWeight}}%</b> / <b>{{wbsWeight}}%</b>)</h4>
                    <table id="activity-table" class="table table-bordered" style="border-collapse:collapse; table-layout: fixed;">
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
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td>{{ data.planned_start_date }}</td>
                                <td>{{ data.planned_end_date }}</td>
                                <td>{{ data.planned_duration }} Day(s)</td>
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
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_activity"  @click="openModalEditActivity(data)">EDIT</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0">
                                    <textarea v-model="newActivity.name" class="form-control width100" rows="3" id="name" name="name" placeholder="Name"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newActivity.description" class="form-control width100" rows="3" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" v-model="newActivity.planned_start_date" type="text" class="form-control datepicker width100" id="planned_start_date" name="planned_start_date" placeholder="Start Date">
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" v-model="newActivity.planned_end_date" type="text" class="form-control datepicker width100" id="planned_end_date" name="planned_end_date" placeholder="End Date">
                                </td>
                                <td class="p-l-0">
                                    <input @keyup="setEndDateNew" @change="setEndDateNew" v-model="newActivity.planned_duration"  type="number" class="form-control width100" id="duration" name="duration" placeholder="Duration" >                                        
                                </td>
                                <td class="p-l-0">
                                    <input v-model="newActivity.weight"  type="text" class="form-control width100" id="weight" name="weight" placeholder="Weight" >                                        
                                </td>
                                <td class="p-l-0 textCenter">
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add_dependent_activity">MANAGE DEPENDENT ACTIVITIES</button>
                                </td>
                                <td>
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary" id="btnSubmit">SUBMIT</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal fade" id="add_dependent_activity">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Dependent Activity</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="p-l-0 form-group col-sm-10">
                                        <selectize v-model="newActivity.predecessor" :settings="activitiesSettings">
                                            <option v-for="(activity, index) in allActivities" :value="activity.id">{{ activity.name }}</option>
                                        </selectize>
                                    </div>
                                    <div class="p-l-2 form-group col-sm-2">
                                        <button  type="button" class="btn btn-primary" @click="refresh">RESET</button>
                                    </div>
                                    <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
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
                                            <tr v-for="(data,index) in predecessorTable">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="#add_dependent_activity" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.name)">{{ data.wbs.name}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">SAVE</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

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
                                    <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
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
                                            <tr v-for="(data,index) in predecessorTableView">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.name)">{{ data.wbs.name}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                    <div class="p-l-0 form-group col-sm-12">
                                        <label for="name" class="control-label">Name</label>
                                        <textarea id="name" v-model="editActivity.name" class="form-control" rows="2" placeholder="Insert Name Here..."></textarea>                                                
                                    </div>

                                    <div class="p-l-0 form-group col-sm-12">
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

                                            
                                    <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
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
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="#add_dependent_activity" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.name)">{{ data.wbs.name}}</td>
                                            </tr>
                                        </tbody>
                                    </table>                                
                                </div>
                                <div class="modal-footer">
                                    <button :disabled="updateOk" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="update">SAVE</button>
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
    menu : @json($menu),
    wbsWeight : @json($wbs->weight),
    project_id: @json($project->id),
    activities :[],
    newIndex : "",
    allActivities : [],
    allActivitiesEdit : [],
    maxWeight : 0,
    newActivity : {
        name : "",
        description : "",
        planned_start_date : "",
        planned_end_date : "",
        planned_duration : "",
        wbs_id : @json($wbs->id), 
        predecessor : [],
        weight : "",
        latest_predecessor : "",
    },
    editActivity : {
        activity_id : "",
        name : "",
        description : "",
        planned_start_date : "",
        planned_end_date : "",
        planned_duration : "",
        predecessor : [],
        weight : "",
        latest_predecessor : "",
    },
    activitiesSettings: {
        placeholder: 'Predecessor Activities',
        maxItems : null,
        plugins: ['remove_button'],
    },
    indexActivitiesSettings: {
        placeholder: 'Insert Predecessor Here...',
        maxItems : null,
        plugins: ['remove_button'],
    },
    maxWeight : 0,
    totalWeight : 0,
    predecessorTable: [],
    predecessorTableView :[],
    predecessorTableEdit:[],
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
        $("#planned_start_date").datepicker().on(
            "changeDate", () => {
                this.newActivity.planned_start_date = $('#planned_start_date').val();
                if(this.newActivity.planned_end_date != ""){
                    this.newActivity.planned_duration = datediff(parseDate(this.newActivity.planned_start_date), parseDate(this.newActivity.planned_end_date));
                }
                this.setEndDateNew();
            }
        );
        $("#planned_end_date").datepicker().on(
            "changeDate", () => {
                this.newActivity.planned_end_date = $('#planned_end_date').val();
                if(this.newActivity.planned_start_date != ""){
                    this.newActivity.planned_duration = datediff(parseDate(this.newActivity.planned_start_date), parseDate(this.newActivity.planned_end_date));
                }
            }
        );

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
        createOk: function(){
            let isOk = false;
                if(this.newActivity.name == ""
                || this.newActivity.weight == ""
                || this.newActivity.planned_duration == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editActivity.name == ""
                || this.editActivity.weight == ""
                || this.editActivity.planned_duration == "")
                {
                    isOk = true;
                }
            return isOk;
        },
    }, 
    methods:{
        refresh() {
            this.newActivity.predecessor = [];
        },
        refreshEdit() {
            this.editActivity.predecessor = [];
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
        setEndDateNew(){
            if(this.newActivity.planned_duration != "" && this.newActivity.planned_start_date != ""){
                var planned_duration = parseInt(this.newActivity.planned_duration);
                var planned_start_date = this.newActivity.planned_start_date;
                var planned_end_date = new Date(planned_start_date);
                
                planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
                $('#planned_end_date').datepicker('setDate', planned_end_date);
            }else{
                this.newActivity.planned_end_date = "";
            }
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
            });
        },
        getActivities(){
            window.axios.get('/api/getWeightWbs/'+this.newActivity.wbs_id).then(({ data }) => {
                this.totalWeight = data;
            })
            window.axios.get('/api/getActivities/'+this.newActivity.wbs_id).then(({ data }) => {
                this.activities = data;
                this.newIndex = Object.keys(this.activities).length+1;

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
        add(){            
            var newActivity = this.newActivity;
            newActivity = JSON.stringify(newActivity);
            var url = "";
            if(this.menu == "building"){
                url = "{{ route('activity.store') }}";
            }else{
                url = "{{ route('activity_repair.store') }}";              
            }
            $('div.overlay').show();            
            window.axios.post(url,newActivity)
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
                    this.getActivities();
                    this.getAllActivities();   
                    this.newActivity.name = "";
                    this.newActivity.description = "";
                    this.newActivity.planned_start_date = "";
                    this.newActivity.planned_end_date = "";
                    this.newActivity.planned_duration = "";
                    this.newActivity.weight = "";
                    this.newActivity.predecessor = [];                     
                }
            })
            .catch((error) => {
                iziToast.warning({
                    displayMode: 'replace',
                    title: "Please try again.. ",
                    position: 'topRight',
                });
                console.log(error);
                $('div.overlay').hide();            
            })

        },
        update(){            
            var editActivity = this.editActivity;
            var url = "";
            if(this.menu == "building"){
                var url = "/activity/update/"+editActivity.activity_id;
            }else{
                var url = "/activity_repair/update/"+editActivity.activity_id;
            }
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
                this.getAllActivities(); 
            })
            .catch((error) => {
                iziToast.warning({
                    displayMode: 'replace',
                    title: "Please try again.. ",
                    position: 'topRight',
                });
                console.log(error);
                $('div.overlay').hide();            
            })

        }
    },
    watch: {
        newActivity:{
            handler: function(newValue) {
                this.newActivity.planned_duration = newValue.planned_duration+"".replace(/\D/g, "");
                if(parseInt(newValue.planned_duration) < 1 ){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'End Date cannot be ahead Start Date',
                        position: 'topRight',
                    });
                    this.newActivity.planned_duration = "";
                    this.newActivity.planned_end_date = "";
                    this.newActivity.planned_start_date = "";
                }
            },
            deep: true
        },
        'newActivity.predecessor': function(newValue){
            this.predecessorTable = [];
            if(newValue != "" && newValue != null){
                newValue.forEach(elementpredecessor => {
                    this.allActivities.forEach(elementAllActivities => {
                        if(elementpredecessor == elementAllActivities.id){
                            this.predecessorTable.push(elementAllActivities);
                        }
                    });
                });
                window.axios.get('/api/getLatestPredecessor/'+JSON.stringify(newValue)).then(({ data }) => {
                    this.newActivity.latest_predecessor = data;
                    // Create new Date instance
                    var dateRef = new Date(data.planned_end_date);

                    var startDate = new Date(data.planned_end_date);
                    var endDate = new Date(data.planned_end_date);
                    var tempDuration = parseInt(this.newActivity.planned_duration)-1;
                    // Add a day
                    startDate.setDate(startDate.getDate());
                    $('#planned_start_date').datepicker('setDate', startDate);

                    if(this.newActivity.planned_duration != ""){
                        endDate.setDate(startDate.getDate() + tempDuration);
                        $('#planned_end_date').datepicker('setDate', endDate);
                    }
                })
            }
        },
        'editActivity.weight': function(newValue){
            this.editActivity.weight = (this.editActivity.weight+"").replace(/[^0-9.]/g, "");  
            window.axios.get('/api/getWeightWbs/'+this.newActivity.wbs_id).then(({ data }) => {
                this.totalWeight = data;
                var totalEdit = roundNumber(data - this.constWeightAct,2);
                maxWeightEdit = roundNumber(this.wbsWeight - totalEdit,2); 
                if(this.editActivity.weight>maxWeightEdit){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'Total weight cannot exceed '+this.wbsWeight+'%',
                        position: 'topRight',
                    });
                }
            });
        },
        'newActivity.weight': function(newValue){
            this.newActivity.weight = (this.newActivity.weight+"").replace(/[^0-9.]/g, "");  
            if(roundNumber(newValue,2)>this.maxWeight){
                iziToast.warning({
                    displayMode: 'replace',
                    title: 'Total weight cannot exceed '+this.wbsWeight+'%',
                    position: 'topRight',
                });
            }
        },
        'editActivity.predecessor': function(newValue){
            this.predecessorTableEdit = [];
            if(newValue != "" && newValue != null){
                newValue.forEach(elementpredecessor => {
                    this.allActivities.forEach(elementAllActivities => {
                        if(elementpredecessor == elementAllActivities.id){
                            this.predecessorTableEdit.push(elementAllActivities);
                        }
                    });
                });
                window.axios.get('/api/getLatestPredecessor/'+JSON.stringify(newValue)).then(({ data }) => {
                    this.editActivity.latest_predecessor = data;
                    // Create new Date instance
                    var dateRef = new Date(data.planned_end_date);

                    var startDate = new Date(data.planned_end_date);
                    var endDate = new Date(data.planned_end_date);
                    var tempDuration = parseInt(this.editActivity.planned_duration)-1;
                    // Add a day
                    startDate.setDate(startDate.getDate());
                    $('#edit_planned_start_date').datepicker('setDate', startDate);

                    if(this.editActivity.planned_duration != ""){
                        endDate.setDate(startDate.getDate() + tempDuration);
                        $('#edit_planned_end_date').datepicker('setDate', endDate);
                    }
                })
            }
        },
    },
    created: function() {
        this.getActivities();
        this.getAllActivities();
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