@extends('layouts.main')

@section('content-header')
    @if ($menu == "building")
        @breadcrumb(
            [
                'title' => 'Manage Network',
                'items' => [
                    'Dashboard' => route('index'),
                    'View all Projects' => route('project.index'),
                    'Project|'.$project->number => route('project.show', ['id' => $project->id]),
                    'Manage Networks' => ''
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [
                'title' => 'Manage Network',
                'items' => [
                    'Dashboard' => route('index'),
                    'View all Projects' => route('project_repair.index'),
                    'Project|'.$project->number => route('project_repair.show', ['id' => $project->id]),
                    'Manage Networks' => ''
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

            </div>
            @verbatim
            <div id="activitiesVue">
                <div class="box-body">
                    <h4 class="box-title">List of Activities</h4>
                    <table id="activity-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 7px">No</th>
                                <th style="width: 14%">Name</th>
                                <th style="width: 18%">Description</th>
                                <th style="width: 10%">Start Date</th>
                                <th style="width: 10%">End Date</th>
                                <th style="width: 10%">Duration (Days)</th>
                                <th style="width: 19%">Predecessor</th> 
                                <th style="width: 6%"></th>
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
                                <template v-if="data.predecessor != null">
                                    <td class="p-l-0 p-r-0 p-b-0 textCenter">
                                        <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                            <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                                <button class="btn btn-primary btn-xs col-xs-12" data-toggle="modal" data-target="#predecessor_activity"  @click="openModalPredecessor(data)">VIEW PREDECESSOR ACTIVITIES</button>
                                            </div>
                                        </div>
                                    </td>
                                </template>
                                <template v-else>
                                    <td>-</td>
                                </template>
                                <td class="textCenter">
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_predecessor" @click="openModalEditPredecessor(data,index)">EDIT</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="predecessor_activity">
                    <div class="modal-dialog modalPredecessor">
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
                                            <th style="width: 23%">WBS Number</th>
                                            <th style="width: 23%">Pred. Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in predecessorTableView">
                                            <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.number)">{{ data.wbs.number}}</td>
                                            <td v-if="data.type == 'fs'" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('Finish to Start')">Finish to Start</td>
                                            <td v-else-if="data.type == 'ss'" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('Start to Start')">Start to Start</td>
                                            <td v-else-if="data.type == 'ff'" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('Finish to Finish')">Finish to Finish</td>
                                            <td v-else-if="data.type == 'sf'" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('Start to Finish')">Start to Finish</td>
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

                <div class="modal fade" id="edit_predecessor">
                    <div class="modal-dialog modalPredecessor">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Edit Predecessor <b id="edit_activity_code"></b></h4>
                            </div>
                            <div class="modal-body">
                                <div class="p-l-0 form-group col-sm-12">
                                    <selectize v-model="predecessor" :settings="activitiesSettings">
                                        <option v-for="(activity, index) in allActivitiesEdit" v-if="activity.selected != true" :value="activity.id">{{ activity.name }}</option>
                                    </selectize>
                                </div>
                                <div class="p-l-0 form-group col-sm-12">
                                    <selectize v-model="predecessorType" :settings="typeSettings">
                                        <option value="fs">Finish to Start</option>
                                        <option value="ss">Start to Start</option>
                                        <option value="ff">Finish to Finish</option>
                                        <option value="sf">Start to Finish</option>
                                    </selectize>
                                </div>
                                <div class="p-l-0 form-group col-sm-2">
                                    <button  :disabled="predecessoreEditOk" type="button" class="btn btn-primary" @click="addPredecessorEdit">ADD PREDECESSOR</button>
                                </div>
                                        
                                <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <th class="p-l-5" style="width: 5%">No</th>
                                            <th style="width: 16%">Code</th>
                                            <th style="width: 26%">Name</th>
                                            <th style="width: 30%">Description</th>
                                            <th style="width: 23%">WBS Number</th>
                                            <th style="width: 23%">Pred. Type</th>
                                            <th style="width: 15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in predecessorTableEdit">
                                            <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="#add_dependent_activity" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.number)">{{ data.wbs.number}}</td>
                                            <td v-if="data.type == 'fs'" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('Finish to Start')">Finish to Start</td>
                                            <td v-else-if="data.type == 'ss'" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('Start to Start')">Start to Start</td>
                                            <td v-else-if="data.type == 'ff'" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('Finish to Finish')">Finish to Finish</td>
                                            <td v-else-if="data.type == 'sf'" class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText('Start to Finish')">Start to Finish</td>
                                            <td>
                                                <div class="col-sm-12 col-xs-12 no-padding p-r-2">
                                                    <a class="btn btn-danger btn-xs col-xs-12" @click="removePredecessorEdit(data)" data-toggle="modal">
                                                        DELETE
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="updatePredecessor">SAVE</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
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
        project_id: @json($project->id),
        activities :"",
        allActivities : [],
        allActivitiesEdit: [],
        activitiesSettings: {
            placeholder: 'Predecessor Activities',
        },
        typeSettings:{
            placeholder: 'Predecessor Type',
        },
        predecessorTable:[],
        predecessorTableView :[],
        predecessorTableEdit:[],
        activeIndex : "",
        predecessor : "",
        predecessorType : "",
        allPredecessor : [],
        predecessor : "",
    };

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el: '#activitiesVue',
        data: data,
        computed:{
            predecessoreEditOk: function(){
                let isOk = false;
                    if(this.predecessor == ""
                    || this.predecessorType == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
        },
        methods:{
            openModalPredecessor(data){
                this.predecessorTableView = [];
                document.getElementById("activity_code").innerHTML= data.code;
                var predecessorObj = JSON.parse(data.predecessor);
                if(predecessorObj.length > 0){
                    predecessorObj.forEach(predecessor => {
                        this.allActivities.forEach(activityRef => {
                            if(predecessor[0]==activityRef.id){
                                activityRef["type"] = predecessor[1];
                                this.predecessorTableView.push(activityRef);
                            } 
                        });
                    });
                }
            },
            openModalEditPredecessor(data, index){
                this.activeIndex = index;
                this.predecessorTableEdit = [];
                document.getElementById("edit_activity_code").innerHTML= data.code;
                if(JSON.parse(data.predecessor) != null){
                    this.allPredecessor = JSON.parse(data.predecessor);
                }else{
                    this.allPredecessor = [];
                }

                window.axios.get('/api/getAllActivitiesEdit/'+this.project_id+'/'+data.id).then(({ data }) => {
                    this.allActivitiesEdit = data;

                    this.allActivitiesEdit.forEach(activity => {
                        activity['selected'] = false;
                    });

                    if(this.allPredecessor.length > 0){
                        this.allPredecessor.forEach(elementpredecessor => {
                            this.allActivitiesEdit.forEach(elementAllActivities => {
                                if(elementpredecessor[0] == elementAllActivities.id){
                                    elementAllActivities['type'] = elementpredecessor[1];
                                    elementAllActivities.selected = true;
                                    this.predecessorTableEdit.push(elementAllActivities);
                                }
                            });
                        });
                    }
                });
            },
            addPredecessorEdit() {
                this.allActivitiesEdit.forEach(elementAllActivities => {
                    if(this.predecessor == elementAllActivities.id){
                        elementAllActivities.selected = true;
                        elementAllActivities['type'] = this.predecessorType;
                        this.predecessorTableEdit.push(elementAllActivities);
                        var obj = [];
                        obj[0] = elementAllActivities.id;
                        obj[1] = this.predecessorType;
                        this.allPredecessor.push(obj);
                    }
                });

                if(this.allPredecessor.length != 0){
                    window.axios.get('/api/getLatestPredecessor/'+JSON.stringify(this.allPredecessor)).then(({ data }) => {
                        this.latest_predecessor = data;
                        // Create new Date instance
                        var dateRef = new Date(data.planned_end_date);

                        var startDate = new Date(data.planned_end_date);
                        var endDate = new Date(data.planned_end_date);
                        var tempDuration = parseInt(this.planned_duration)-1;
                        // Add a day
                        startDate.setDate(startDate.getDate());
                        $('#edit_planned_start_date').datepicker('setDate', startDate);

                        if(this.planned_duration != ""){
                            endDate.setDate(startDate.getDate() + tempDuration);
                            $('#edit_planned_end_date').datepicker('setDate', endDate);
                        }
                    })
                }
                this.predecessor = "";
                this.predecessorType = "";
            },
            removePredecessorEdit(data){
                for (let x = 0; x < this.predecessorTableEdit.length; x++) {
                    if(this.predecessorTableEdit[x].id == data.id){
                        this.predecessorTableEdit.splice(x,1);
                        this.allPredecessor.splice(x,1);
                    }
                }
                this.allActivitiesEdit.forEach(activities => {
                    if(activities.id == data.id){
                        activities.selected = false;
                    }
                });
            },
            tooltipText: function(text) {
                return text
            },
            getAllActivities(){
                window.axios.get('/api/getAllActivities/'+this.project_id).then(({ data }) => {
                    this.allActivities = data;

                    this.allActivities.forEach(activity => {
                        activity['selected'] = false;
                    });
                });
            },
            getActivities(){
                window.axios.get('/api/getActivitiesNetwork/'+this.project_id).then(({ data }) => {
                    this.activities = data;
                    this.activities.forEach(data => {
                        if(data.planned_start_date != null){
                            data.planned_start_date = data.planned_start_date.split("-").reverse().join("-");   
                        }

                        if(data.planned_end_date != null){
                            data.planned_end_date = data.planned_end_date.split("-").reverse().join("-");   
                        }
                    });
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
            updatePredecessor(){
                var activityUpdate = this.activities[this.activeIndex];
                var idUpd = activityUpdate.id;
                activityUpdate.allPredecessor = this.allPredecessor;
                activityUpdate = JSON.stringify(activityUpdate);
                var url = "";
                if(this.menu == "building"){
                    url = "/activity/updatePredecessor/"+idUpd;
                }else{
                    url = "/activity_repair/updatePredecessor/"+idUpd;
                }
                $('div.overlay').show();
                window.axios.put(url,activityUpdate)
                .then((response) => {
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });

                    if(response.data.error != undefined){
                        iziToast.danger({
                            displayMode: 'replace',
                            title: response.data.response,
                            position: 'topRight',
                        });
                    }
                
                    this.getActivities();
                    this.allPredecessor = []
                    $('div.overlay').hide();
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
        watch:{
            // selectizeValue:function(newValue){
            //     if(newValue != null){
            //         this.predecessorTable = [];
            //         newValue.forEach(predecessor => {
            //             for(var i = 0; i < this.allActivities.length; i++){
            //                 if(predecessor==this.allActivities[i].id){
            //                     this.predecessorTable.push(this.allActivities[i]);
            //                 }
            //             }
            //         });
            //         var predecessor = "["+newValue.join(",")+"]";
            //         this.activities[this.activeIndex].predecessor = predecessor;
            //     }else{
            //         this.activities[this.activeIndex].predecessor = null;
            //         this.predecessorTable = [];
            //     }
            // },
        },
        created: function(){
            this.getAllActivities();
            this.getActivities();
        }
    });
</script>
@endpush
