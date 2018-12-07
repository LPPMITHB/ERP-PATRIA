@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => "Add Activities",
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show', ['id' => $project->id]),
            'Select Work' => route('project.listWBS',['id'=>$project->id,'menu'=>'addWBS']),
            'Add Activities' => ""
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
                                <td>&ensp;<b>{{$project->ship->name}}</b></td>
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
                    <table class="tableFixed width100">
                        <thead>
                            <th style="width: 25%">Work Information</th>
                            <th style="width: 3%"></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="">Name</td>
                                <td>:</td>
                                <td><b>{{$work->name}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Description</td>
                                <td class="valignTop">:</td>
                                <td class="valignTop" style="overflow-wrap: break-word;"><b >{{$work->description}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Deliverables</td>
                                <td class="valignTop">:</td>
                                <td class="valignTop" style="overflow-wrap: break-word;"><b >{{$work->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Deadline</td>
                                <td>:</td>
                                <td><b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $work->planned_deadline);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td><b>{{$work->progress}} %</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @verbatim
            <div id="add_activity">
                <div class="box-body">
                    <h4 class="box-title">List of Activities</h4>
                    <table id="activity-table" class="table table-bordered" style="border-collapse:collapse; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width: 4%">No</th>
                                <th style="width: 14%">Name</th>
                                <th style="width: 18%">Description</th>
                                <th style="width: 10%">Start Date</th>
                                <th style="width: 10%">End Date</th>
                                <th style="width: 12%">Duration (Days)</th>
                                <th style="width: 19%">Predecessor</th> 
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities" class="popoverData"  data-content="" v-on:mouseover="dataForTooltip(data)" data-trigger="hover" rel="popover" data-placement="auto top" data-original-title="Details">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td>{{ data.planned_start_date }}</td>
                                <td>{{ data.planned_end_date }}</td>
                                <td>{{ data.planned_duration }}</td>
                                <template v-if="data.predecessor != null">
                                    <td class="p-l-5">
                                        <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#predecessor_activity"  @click="openModalPredecessor(data)">VIEW PREDECESSOR ACTIVITIES</button>
                                    </td>
                                </template>
                                <template v-else>
                                    <td>-</td>
                                </template>
                                <td class="textCenter">
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_activity"  @click="openModalEditActivity(data,index)">EDIT</button>
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
                                    <input v-model="newActivity.planned_start_date" type="text" class="form-control datepicker width100" id="planned_start_date" name="planned_start_date" placeholder="Start Date">
                                </td>
                                <td class="p-l-0">
                                    <input v-model="newActivity.planned_end_date" type="text" class="form-control datepicker width100" id="planned_end_date" name="planned_end_date" placeholder="End Date">
                                </td>
                                <td class="p-l-0">
                                    <input @keyup="setEndDateNew" @change="setEndDateNew" v-model="newActivity.planned_duration"  type="number" class="form-control width100" id="duration" name="duration" placeholder="Duration" >                                        
                                </td>
                                <td class="p-l-0 textCenter">
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add_dependant_activity">MANAGE DEPENDANT ACTIVITIES</button>
                                </td>
                                <td>
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary" id="btnSubmit">SUBMIT</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal fade" id="add_dependant_activity">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Dependant Activity</h4>
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
                                                <td class="p-b-15 p-t-15">{{ data.code }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="#add_dependant_activity" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.work.name)">{{ data.work.name}}</td>
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
                                                <td class="p-b-15 p-t-15">{{ data.code }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.work.name)">{{ data.work.name}}</td>
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
                                    <div class="p-l-0 form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <textarea id="name" v-model="editActivity.name" class="form-control" rows="2" placeholder="Insert Name Here..."></textarea>                                                
                                    </div>

                                    <div class="p-l-0 form-group">
                                        <label for="description" class=" control-label">Description</label>
                                        <textarea id="description" v-model="editActivity.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>                                                
                                    </div>

                                    <div class="p-l-0 form-group col-sm-4">
                                        <label for="edit_planned_start_date" class=" control-label">Start Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input v-model="editActivity.planned_start_date" type="text" class="form-control datepicker" id="edit_planned_start_date" placeholder="Insert Start Date here...">                                             
                                        </div>
                                    </div>
                                            
                                    <div class="p-l-0 form-group col-sm-4">
                                        <label for="edit_planned_end_date" class=" control-label">End Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input v-model="editActivity.planned_end_date" type="text" class="form-control datepicker" id="edit_planned_end_date" placeholder="Insert End Date here...">                                                                                            
                                        </div>
                                    </div>
                                    
                                    <div class="p-l-0 form-group col-sm-4">
                                        <label for="duration" class=" control-label">Duration</label>
                                        <input @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="editActivity.planned_duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >                                        
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
                                                <td class="p-b-15 p-t-15">{{ data.code }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="#add_dependant_activity" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.work.name)">{{ data.work.name}}</td>
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
    project_id: @json($project->id),
    activities :[],
    newIndex : "",
    allActivities : [],
    allActivitiesEdit : [],
    newActivity : {
        name : "",
        description : "",
        planned_start_date : "",
        planned_end_date : "",
        planned_duration : "",
        work_id : @json($work->id), 
        predecessor : [],
    },
    editActivity : {
        activity_id : "",
        name : "",
        description : "",
        planned_start_date : "",
        planned_end_date : "",
        planned_duration : "",
        predecessor : [],
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
    predecessorTable: [],
    predecessorTableView :[],
    predecessorTableEdit:[],
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
                || this.newActivity.description == ""
                || this.newActivity.planned_start_date == ""
                || this.newActivity.planned_end_date == ""
                || this.newActivity.planned_duration == "")
                {
                    isOk = true;
                }
            return isOk;
        },
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
        openModalEditActivity(data,index){
            window.axios.get('/project/getAllActivities/'+this.project_id).then(({ data }) => {
                data.splice(index, 1);
                this.allActivitiesEdit = data;
            });
            document.getElementById("edit_activity_code").innerHTML= data.code;
            this.editActivity.activity_id = data.id;
            this.editActivity.name = data.name;
            this.editActivity.description = data.description;
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
        getAllActivities(){
            window.axios.get('/project/getAllActivities/'+this.project_id).then(({ data }) => {
                this.allActivities = data;
                this.allActivitiesEdit = data;
            });
        },
        getActivities(){
            window.axios.get('/project/getActivities/'+this.newActivity.work_id).then(({ data }) => {
                this.activities = data;
                this.newIndex = Object.keys(this.activities).length+1;
                
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
            var url = "{{ route('project.storeActivity') }}";
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
                }
            
                this.getActivities();
                this.newActivity.name = "";
                this.newActivity.description = "";
                this.newActivity.planned_start_date = "";
                this.newActivity.planned_end_date = "";
                this.newActivity.planned_duration = "";
                this.newActivity.predecessor = [];
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })

        },
        update(){            
            var editActivity = this.editActivity;
            var url = "/project/updateActivity/"+editActivity.activity_id;
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
        newActivity:{
            handler: function(newValue) {
                this.newActivity.planned_duration = newValue.planned_duration+"".replace(/\D/g, "");
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
                    this.newActivity.planned_duration = "";
                    this.newActivity.planned_end_date = "";
                    this.newActivity.planned_start_date = "";
                }
            },
            deep: true
        },
        'newActivity.predecessor': function(newValue){
            this.predecessorTable = [];
            if(newValue != ""){
                newValue.forEach(elementpredecessor => {
                    this.allActivities.forEach(elementAllActivities => {
                        if(elementpredecessor == elementAllActivities.id){
                            this.predecessorTable.push(elementAllActivities);
                        }
                    });
                });
            }
        },
        'editActivity.predecessor': function(newValue){
            this.predecessorTableEdit = [];
            if(newValue != null){
                newValue.forEach(elementpredecessor => {
                    this.allActivities.forEach(elementAllActivities => {
                        if(elementpredecessor == elementAllActivities.id){
                            this.predecessorTableEdit.push(elementAllActivities);
                        }
                    });
                });
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
</script>
@endpush