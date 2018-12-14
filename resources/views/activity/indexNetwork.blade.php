@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage Network',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show', ['id' => $project->id]),
            'Select WBS' =>  route('activity.listWBS',['id'=>$project->id,'menu'=>'mngNet']),
            'Manage Netwbs' => ''
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
                    <table class="tableFixed width100">
                        <thead>
                            <th style="width: 25%">WBS Information</th>
                            <th style="width: 3%"></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="">Name</td>
                                <td>:</td>
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
            <div id="activitiesVue">
                <div class="box-body">
                    <h4 class="box-title">List of Activities</h4>
                    <table id="activity-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 7ch">No</th>
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
                            <tr v-for="(data,index) in activities">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td>{{ data.planned_start_date }}</td>
                                <td>{{ data.planned_end_date }}</td>
                                <td>{{ data.planned_duration }}</td>
                                <td class="tdEllipsis"  data-container="body" v-tooltip:top="tooltipText(data.predecessorText)">{{ data.predecessorText }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_predecessor" @click="populateSelectize(data,index)">EDIT</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="edit_predecessor">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">predecessor Activities for <b id="edit_activity_code"></b></h4>
                            </div>
                            <div class="modal-body">
                                <div class="p-l-0 m-b-20 form-group col-sm-10">
                                    <selectize v-model="selectizeValue" :settings="activitiesSettings" style="white-space : normal">
                                        <option v-for="(activity, index) in allActivitiesEdit" :value="activity.id">{{ activity.name }}</option>
                                    </selectize>
                                </div>
                                <div class="p-l-5 form-group col-sm-2">
                                    <button  type="button" class="btn btn-primary" @click="refresh(activeIndex)">RESET</button>
                                </div>
                                <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <th class="p-l-5" style="width: 5%">No</th>
                                            <th style="width: 16%">Code</th>
                                            <th style="width: 20%">Name</th>
                                            <th style="width: 27%">Description</th>
                                            <th style="width: 35%">Work Breakdown Structure</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in predecessorTable">
                                            <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                            <td class="p-b-15 p-t-15">{{ data.code }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                            <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.name)">{{ data.wbs.name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="updatePredecessor">SAVE</button>
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
        project_id: @json($project->id),
        wbs_id : @json($wbs->id),
        activities :"",
        allActivities : [],
        allActivitiesEdit: [],
        activitiesSettings: {
            placeholder: 'Predecessor Activities',
            maxItems : null,
            dropdownDirection : "auto",
            plugins: ['remove_button'],
        },
        selectizeValue: [],
        predecessorTable:[],
        activeIndex : "",
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
        methods:{
            populateSelectize(data, index){
                window.axios.get('/api/getAllActivitiesEdit/'+this.project_id+'/'+data.id).then(({ data }) => {
                    this.allActivitiesEdit = data;
                });
                document.getElementById("edit_activity_code").innerHTML= data.code;
                var predecessorObj = JSON.parse(data.predecessor);
                this.selectizeValue = predecessorObj;
                this.activeIndex = index;
            },
            refresh(index) {
                this.selectizeValue = [];
                this.activities[index].predecessor = [];
                this.predecessorTable = [];
            },
            tooltipText: function(text) {
                return text
            },
            getAllActivities(){
                window.axios.get('/api/getAllActivities/'+this.project_id).then(({ data }) => {
                    this.allActivities = data;
                });
            },
            getActivities(){
                window.axios.get('/api/getActivitiesNetwork/'+this.wbs_id).then(({ data }) => {
                    this.activities = data;

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
                activityUpdate = JSON.stringify(activityUpdate);
                var url = "/activity/updatePredecessor/"+idUpd;
                $('div.overlay').show();
                window.axios.patch(url,activityUpdate)
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
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    console.log(error);
                    $('div.overlay').hide();
                })
            }
        },
        watch:{
            selectizeValue:function(newValue){
                if(newValue != null){
                    this.predecessorTable = [];
                    newValue.forEach(predecessor => {
                        for(var i = 0; i < this.allActivities.length; i++){
                            if(predecessor==this.allActivities[i].id){
                                this.predecessorTable.push(this.allActivities[i]);
                            }
                        }
                    });
                    var predecessor = "["+newValue.join(",")+"]";
                    this.activities[this.activeIndex].predecessor = predecessor;
                }else{
                    this.activities[this.activeIndex].predecessor = null;
                    this.predecessorTable = [];
                }
            },
        },
        created: function(){
            this.getAllActivities();
            this.getActivities();
        }
    });
</script>
@endpush
