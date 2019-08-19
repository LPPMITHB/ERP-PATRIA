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
                                            $date = isset($date) ? $date->format('d-m-Y') : '-';
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
                                            $date = isset($date) ? $date->format('d-m-Y') : '-';
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
                                <td><b>{{$wbs->number}}</b></td>
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
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td><b>@php
                                        if(isset($wbs->planned_end_date)){
                                        $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_start_date);
                                        $date = $date->format('d-m-Y');
                                        echo $date;
                                    }else{
                                        echo '-';
                                    }
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td><b>@php
                                    if(isset($wbs->planned_end_date)){
                                        $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_end_date);
                                        $date = $date->format('d-m-Y');
                                        echo $date;
                                    }else{
                                        echo '-';
                                    }
                                        @endphp
                                    </b>
                                </td>
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
                                <th style="width: 5%">No</th>
                                <th style="width: 14%">Name</th>
                                <th style="width: 16%">Description</th>
                                <th style="width: 10%">Start Date</th>
                                <th style="width: 10%">End Date</th>
                                <th style="width: 8%" >Duration</th>
                                <th style="width: 7%">Total Weight</th>
                                <th style="width: 7%">Weight</th>
                                <th style="width: 19%">Predecessor</th>
                                <th style="width: 13%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td>{{ data.planned_start_date }}</td>
                                <td>{{ data.planned_end_date }}</td>
                                <td>{{ data.planned_duration }} Day(s)</td>
                                <td>{{ Number.isNaN(((data.weight/wbsWeight)*100)) ? "-" : ((data.weight/wbsWeight)*100).toFixed(2) }} %</td>
                                <td>{{ data.weight }} %</td>
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
                                <td class="p-l-0 p-r-0 p-b-0 textCenter">
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <button class="btn btn-primary btn-xs col-xs-12" data-toggle="modal" data-target="#edit_activity"  @click="openModalEditActivity(data)">EDIT</button>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-danger btn-xs col-xs-12" @click="deleteActivity(data)" data-toggle="modal">
                                                DELETE
                                            </a>
                                        </div>
                                    </div>
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
                                    <input autocomplete="off" v-model="newActivity.planned_start_date" type="text" class="form-control datepicker width100 create_date" id="planned_start_date" name="planned_start_date" placeholder="Start Date">
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" v-model="newActivity.planned_end_date" type="text" class="form-control datepicker width100 create_date" id="planned_end_date" name="planned_end_date" placeholder="End Date">
                                </td>
                                <td class="p-l-0">
                                    <input @keyup="setEndDateNew" @change="setEndDateNew" v-model="newActivity.planned_duration"  type="number" class="form-control width100" id="duration" name="duration" placeholder="Duration" >
                                </td>
                                <td class="p-l-0">
                                    <input v-model="newActivity.totalWeight"  type="text" class="form-control width100" id="totalWeight" name="totalWeight" placeholder="Weight" >
                                </td>
                                <td class="p-l-0">
                                    <input disabled v-model="newActivity.weight"  type="text" class="form-control width100" id="weight" name="weight" placeholder="Weight" >
                                </td>
                                <td class="p-l-0 textCenter p-r-5 p-l-5">
                                    <button class="btn btn-primary btn-xs col-xs-12 " data-toggle="modal" data-target="#add_dependent_activity">MANAGE DEPENDENT ACTIVITIES</button>
                                </td>
                                <td class="textCenter">
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary" id="btnSubmit">CREATE</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal fade" id="add_dependent_activity">
                        <div class="modal-dialog modalPredecessor">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Dependent Activity</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="p-l-0 form-group col-sm-12">
                                        <selectize v-model="newActivity.predecessor" :settings="activitiesSettings">
                                            <option v-for="(activity, index) in allActivities" v-if="activity.selected != true" :value="activity.id">{{ activity.name }}</option>
                                        </selectize>
                                    </div>
                                    <div class="p-l-0 form-group col-sm-12">
                                        <selectize v-model="newActivity.predecessorType" :settings="typeSettings">
                                            <option value="fs">Finish to Start</option>
                                            <option value="ss">Start to Start</option>
                                            <option value="ff">Finish to Finish</option>
                                            <option value="sf">Start to Finish</option>
                                        </selectize>
                                    </div>
                                    <div class="p-l-0 form-group col-sm-2">
                                        <button  :disabled="predecessorOk" type="button" class="btn btn-primary" @click="addPredecessor">ADD PREDECESSOR</button>
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
                                            <tr v-for="(data,index) in predecessorTable">
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
                                                        <a class="btn btn-danger btn-xs col-xs-12" @click="removePredecessor(data)" data-toggle="modal">
                                                            DELETE
                                                        </a>
                                                    </div>
                                                </td>
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

                    <div class="modal fade" id="edit_activity">
                        <div class="modal-dialog modalPredecessor">
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

                                    <div class="p-l-0 form-group col-sm-6">
                                        <label for="totalWeight" class=" control-label">Total Weight (Max = 100%)</label>
                                        <input v-model="editActivity.totalWeight"  type="text" class="form-control" id="edit_totalWeight" placeholder="Weight" >
                                    </div>

                                    <div class="p-l-0 form-group col-sm-6">
                                        <label for="weight" class=" control-label">Weight</label>
                                        <input disabled v-model="editActivity.weight"  type="text" class="form-control" id="edit_weight" placeholder="Weight" >
                                    </div>

                                    <div class="p-l-0 form-group col-sm-12">
                                        <selectize v-model="editActivity.predecessor" :settings="activitiesSettings">
                                            <option v-for="(activity, index) in allActivitiesEdit" v-if="activity.selected != true" :value="activity.id">{{ activity.name }}</option>
                                        </selectize>
                                    </div>
                                    <div class="p-l-0 form-group col-sm-12">
                                        <selectize v-model="editActivity.predecessorType" :settings="typeSettings">
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
});

var data = {
    menu : @json($menu),
    project_start_date : @json($project->planned_start_date),
    project_end_date : @json($project->planned_end_date),
    wbs_start_date : @json($wbs->planned_start_date),
    wbs_end_date : @json($wbs->planned_end_date),
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
        predecessor : "",
        predecessorType : "",
        weight : "",
        totalWeight : "",
        latest_predecessor : "",
        allPredecessor : [],
    },
    editActivity : {
        activity_id : "",
        name : "",
        description : "",
        planned_start_date : "",
        planned_end_date : "",
        planned_duration : "",
        predecessor : "",
        predecessorType : "",
        weight : "",
        totalWeight :"",
        latest_predecessor : "",
        allPredecessor : [],
    },
    activitiesSettings: {
        placeholder: 'Predecessor Activities',
    },
    indexActivitiesSettings: {
        placeholder: 'Insert Predecessor Here...',
    },
    typeSettings:{
        placeholder: 'Predecessor Type',
    },
    maxWeight : 0,
    totalWeight : 0,
    predecessorTable: [],
    predecessorTableView :[],
    predecessorTableEdit:[],
    constWeightAct : 0,
    oldValueWeight : "",
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
            format : "dd-mm-yyyy"
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
        predecessorOk: function(){
            let isOk = false;
                if(this.newActivity.predecessor == ""
                || this.newActivity.predecessorType == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        predecessoreEditOk: function(){
            let isOk = false;
                if(this.editActivity.predecessor == ""
                || this.editActivity.predecessorType == "")
                {
                    isOk = true;
                }
            return isOk;
        },
    },
    methods:{
        addPredecessor() {
            this.allActivities.forEach(elementAllActivities => {
                if(this.newActivity.predecessor == elementAllActivities.id){
                    elementAllActivities.selected = true;
                    elementAllActivities['type'] = this.newActivity.predecessorType;
                    this.predecessorTable.push(elementAllActivities);
                    var obj = [];
                    obj[0] = elementAllActivities.id;
                    obj[1] = this.newActivity.predecessorType;
                    this.newActivity.allPredecessor.push(obj);
                }
            });

            if(this.newActivity.allPredecessor.length != 0){
                window.axios.get('/api/getLatestPredecessor/'+JSON.stringify(this.newActivity.allPredecessor)).then(({ data }) => {
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
            this.newActivity.predecessor = "";
            this.newActivity.predecessorType = "";
        },
        addPredecessorEdit() {
            this.allActivitiesEdit.forEach(elementAllActivities => {
                if(this.editActivity.predecessor == elementAllActivities.id){
                    elementAllActivities.selected = true;
                    elementAllActivities['type'] = this.editActivity.predecessorType;
                    this.predecessorTableEdit.push(elementAllActivities);
                    var obj = [];
                    obj[0] = elementAllActivities.id;
                    obj[1] = this.editActivity.predecessorType;
                    this.editActivity.allPredecessor.push(obj);
                }
            });

            if(this.editActivity.allPredecessor.length != 0){
                window.axios.get('/api/getLatestPredecessor/'+JSON.stringify(this.editActivity.allPredecessor)).then(({ data }) => {
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
            this.editActivity.predecessor = "";
            this.editActivity.predecessorType = "";
        },
        removePredecessor(data){
            for (let x = 0; x < this.predecessorTable.length; x++) {
                if(this.predecessorTable[x].id == data.id){
                    this.predecessorTable.splice(x,1);
                    this.newActivity.allPredecessor.splice(x,1);
                }
            }
            this.allActivities.forEach(activities => {
                if(activities.id == data.id){
                    activities.selected = false;
                }
            });
        },
        removePredecessorEdit(data){
            for (let x = 0; x < this.predecessorTableEdit.length; x++) {
                if(this.predecessorTableEdit[x].id == data.id){
                    this.predecessorTableEdit.splice(x,1);
                    this.editActivity.allPredecessor.splice(x,1);
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
        openModalEditActivity(data){
            this.predecessorTableEdit = [];
            document.getElementById("edit_activity_code").innerHTML= data.code;
            this.editActivity.activity_id = data.id;
            this.editActivity.name = data.name;
            this.editActivity.description = data.description;
            this.editActivity.weight = data.weight;
            this.editActivity.planned_duration = data.planned_duration;
            this.editActivity.totalWeight = Number.isNaN(((data.weight/this.wbsWeight)*100)) ? "" : ((data.weight/this.wbsWeight)*100).toFixed(2);
            if(JSON.parse(data.predecessor) != null){
                this.editActivity.allPredecessor = JSON.parse(data.predecessor);
            }else{
                this.editActivity.allPredecessor = [];
            }
            this.constWeightAct = data.weight;
            $('#edit_planned_start_date').datepicker('setDate', new Date(data.planned_start_date.split("-").reverse().join("-")));
            $('#edit_planned_end_date').datepicker('setDate', new Date(data.planned_end_date.split("-").reverse().join("-")));

            window.axios.get('/api/getAllActivitiesEdit/'+this.project_id+'/'+data.id).then(({ data }) => {
                this.allActivitiesEdit = data;

                this.allActivitiesEdit.forEach(activity => {
                    activity['selected'] = false;
                });

                if(this.editActivity.allPredecessor.length > 0){
                    this.editActivity.allPredecessor.forEach(elementpredecessor => {
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
        setEndDateNew(){
            if(this.newActivity.planned_duration != "" && this.newActivity.planned_start_date != ""){
                var planned_duration = parseInt(this.newActivity.planned_duration);
                var planned_start_date = this.newActivity.planned_start_date;
                var planned_end_date = new Date(planned_start_date.split("-").reverse().join("-"));

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
                var planned_end_date = new Date(planned_start_date.split("-").reverse().join("-"));

                planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
                $('#edit_planned_end_date').datepicker('setDate', planned_end_date);
            }else{
                this.editActivity.planned_end_date = "";
            }
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
            window.axios.get('/api/getWeightWbs/'+this.newActivity.wbs_id).then(({ data }) => {
                this.totalWeight = data;
                window.axios.get('/api/getActivities/'+this.newActivity.wbs_id).then(({ data }) => {
                    this.activities = data;
                    this.newIndex = Object.keys(this.activities).length+1;
                    this.activities.forEach(data => {
                        if(data.planned_start_date != null){
                            data.planned_start_date = data.planned_start_date.split("-").reverse().join("-");
                        }

                        if(data.planned_end_date != null){
                            data.planned_end_date = data.planned_end_date.split("-").reverse().join("-");
                        }
                    });
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
                        $('div.overlay').hide();
                    })
                });
            })

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
                    this.getActivities();
                    this.getAllActivities();
                    this.newActivity.name = "";
                    this.newActivity.description = "";
                    this.newActivity.planned_start_date = "";
                    this.newActivity.planned_end_date = "";
                    this.newActivity.planned_duration = "";
                    this.newActivity.weight = "";
                    this.newActivity.allPredecessor = [];
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
            window.axios.put(url,editActivity)
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
        },
        deleteActivity(data){
            var menuTemp = this.menu;
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Confirm',
                message: 'Are you sure you want to delete this Activity?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        var url = "";
                        if(menuTemp == "building"){
                            url = "/activity/deleteActivity/"+data.id;
                        }else{
                            url = "/activity_repair/deleteActivity/"+data.id;
                        }
                        $('div.overlay').show();
                        window.axios.delete(url)
                        .then((response) => {
                            if(response.data.error != undefined){
                                response.data.error.forEach(error => {
                                    iziToast.warning({
                                        displayMode: 'replace',
                                        title: error,
                                        position: 'topRight',
                                    });
                                });
                                $('div.overlay').hide();
                            }else{
                                iziToast.success({
                                    displayMode: 'replace',
                                    title: response.data.response,
                                    position: 'topRight',
                                });
                                vm.getActivities();
                                vm.getAllActivities();
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

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
            });
        },
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
        editActivity:{
            handler: function(newValue) {
                this.editActivity.planned_duration = newValue.planned_duration+"".replace(/\D/g, "");
                if(parseInt(newValue.planned_duration) < 1 ){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'End Date cannot be ahead Start Date',
                        position: 'topRight',
                    });
                    this.editActivity.planned_duration = "";
                    this.editActivity.planned_end_date = "";
                    this.editActivity.planned_start_date = "";
                }
            },
            deep: true
        },
        // 'newActivity.predecessor': function(newValue){
        //     this.predecessorTable = [];
        //     if(newValue != "" && newValue != null){
        //         newValue.forEach(elementpredecessor => {
        //             this.allActivities.forEach(elementAllActivities => {
        //                 if(elementpredecessor == elementAllActivities.id){
        //                     this.predecessorTable.push(elementAllActivities);
        //                 }
        //             });
        //         });
        //         window.axios.get('/api/getLatestPredecessor/'+JSON.stringify(newValue)).then(({ data }) => {
        //             this.newActivity.latest_predecessor = data;
        //             // Create new Date instance
        //             var dateRef = new Date(data.planned_end_date);

        //             var startDate = new Date(data.planned_end_date);
        //             var endDate = new Date(data.planned_end_date);
        //             var tempDuration = parseInt(this.newActivity.planned_duration)-1;
        //             // Add a day
        //             startDate.setDate(startDate.getDate());
        //             $('#planned_start_date').datepicker('setDate', startDate);

        //             if(this.newActivity.planned_duration != ""){
        //                 endDate.setDate(startDate.getDate() + tempDuration);
        //                 $('#planned_end_date').datepicker('setDate', endDate);
        //             }
        //         })
        //     }
        // },
        'editActivity.totalWeight': function(newValue){
            this.editActivity.totalWeight = (this.editActivity.totalWeight+"").replace(/[^0-9.]/g, "");
            if(roundNumber(newValue,2) > 100){
                iziToast.warning({
                    displayMode: 'replace',
                    title: 'Total Total Weight cannot exceed 100%',
                    position: 'topRight',
                });
                this.editActivity.totalWeight = 100;
            }else{
                this.editActivity.weight = ((this.editActivity.totalWeight/100)*this.wbsWeight).toFixed(2);
            }
        },
        'editActivity.weight': function(newValue){
            this.editActivity.weight = (this.editActivity.weight+"").replace(/[^0-9.]/g, "");
            if(newValue != ""){
                if(this.oldValueWeight == ""){
                    this.oldValueWeight = this.editActivity.weight;
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
                            this.editActivity.weight = maxWeightEdit;
                        }
                    });
                }else if(this.oldValueWeight != this.editActivity.weight){
                    this.oldValueWeight = this.editActivity.weight;
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
                            this.editActivity.weight = maxWeightEdit;
                        }
                    });
                }
            }
        },
        'newActivity.totalWeight': function(newValue){
            this.newActivity.totalWeight = (this.newActivity.totalWeight+"").replace(/[^0-9.]/g, "");
            if(roundNumber(newValue,2) > 100){
                iziToast.warning({
                    displayMode: 'replace',
                    title: 'Total Total Weight cannot exceed 100%',
                    position: 'topRight',
                });
                this.newActivity.totalWeight = 100;
            }else{
                this.newActivity.weight = ((this.newActivity.totalWeight/100)*this.wbsWeight).toFixed(2);
            }
        },
        'newActivity.weight': function(newValue){
            this.newActivity.weight = (this.newActivity.weight+"").replace(/[^0-9.]/g, "");
            if(roundNumber(newValue,2)>this.maxWeight){
                iziToast.warning({
                    displayMode: 'replace',
                    title: 'Total weight cannot exceed '+this.wbsWeight+'%',
                    position: 'topRight',
                });
                this.newActivity.weight = this.maxWeight;
                this.newActivity.totalWeight = (this.maxWeight/this.wbsWeight)*100;
            }
        },
        // 'editActivity.predecessor': function(newValue){
        //     this.predecessorTableEdit = [];
        //     if(newValue != "" && newValue != null){
        //         newValue.forEach(elementpredecessor => {
        //             this.allActivities.forEach(elementAllActivities => {
        //                 if(elementpredecessor == elementAllActivities.id){
        //                     this.predecessorTableEdit.push(elementAllActivities);
        //                 }
        //             });
        //         });
        //         window.axios.get('/api/getLatestPredecessor/'+JSON.stringify(newValue)).then(({ data }) => {
        //             this.editActivity.latest_predecessor = data;
        //             // Create new Date instance
        //             var dateRef = new Date(data.planned_end_date);

        //             var startDate = new Date(data.planned_end_date);
        //             var endDate = new Date(data.planned_end_date);
        //             var tempDuration = parseInt(this.editActivity.planned_duration)-1;
        //             // Add a day
        //             startDate.setDate(startDate.getDate());
        //             $('#edit_planned_start_date').datepicker('setDate', startDate);

        //             if(this.editActivity.planned_duration != ""){
        //                 endDate.setDate(startDate.getDate() + tempDuration);
        //                 $('#edit_planned_end_date').datepicker('setDate', endDate);
        //             }
        //         })
        //     }
        // },
        'newActivity.planned_start_date' : function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var wbs_end_date = new Date(this.wbs_end_date).toDateString();
            var wbs_start_date = new Date(this.wbs_start_date).toDateString();

            var activity_start_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var wbs_end_date = new Date(wbs_end_date);
            var wbs_start_date = new Date(wbs_start_date);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);

            if(activity_start_date > wbs_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This activity start date is after parent WBS end date",
                    position: 'topRight',
                });
                $('#planned_start_date').datepicker('setDate', wbs_end_date);
            }else if(activity_start_date < wbs_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This activity start date is before parent WBS start date",
                    position: 'topRight',
                });
                $('#planned_start_date').datepicker('setDate', wbs_start_date);
            }else if(activity_start_date < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this activity start date is behind project start date",
                    position: 'topRight',
                });
                $('#planned_start_date').datepicker('setDate', pro_planned_start_date);
            }else if(activity_start_date > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this activity start date is after project end date",
                    position: 'topRight',
                });
                $('#planned_start_date').datepicker('setDate', pro_planned_end_date);
            }
        },
        'newActivity.planned_end_date' : function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var wbs_end_date = new Date(this.wbs_end_date).toDateString();
            var wbs_start_date = new Date(this.wbs_start_date).toDateString();

            var activity_end_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var wbs_end_date = new Date(wbs_end_date);
            var wbs_start_date = new Date(wbs_start_date);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);

            if(activity_end_date > wbs_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This activity end date is after parent WBS end date",
                    position: 'topRight',
                });
                $('#planned_end_date').datepicker('setDate', wbs_end_date);
            }else if(activity_end_date < wbs_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This activity end date is before parent WBS start date",
                    position: 'topRight',
                });
                $('#planned_end_date').datepicker('setDate', wbs_start_date);
            }else if(activity_end_date < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this activity end date is behind project start date",
                    position: 'topRight',
                });
                $('#planned_end_date').datepicker('setDate', pro_planned_start_date);
            }else if(activity_end_date > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this activity end date is after project end date",
                    position: 'topRight',
                });
                $('#planned_end_date').datepicker('setDate', pro_planned_end_date);
            }
        },
        'editActivity.planned_start_date' : function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var wbs_end_date = new Date(this.wbs_end_date).toDateString();
            var wbs_start_date = new Date(this.wbs_start_date).toDateString();

            var activity_start_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var wbs_end_date = new Date(wbs_end_date);
            var wbs_start_date = new Date(wbs_start_date);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);

            if(activity_start_date > wbs_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This activity start date is after parent WBS end date",
                    position: 'topRight',
                });
                $('#edit_planned_start_date').datepicker('setDate', wbs_end_date);
            }else if(activity_start_date < wbs_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This activity start date is before parent WBS start date",
                    position: 'topRight',
                });
                $('#edit_planned_start_date').datepicker('setDate', wbs_start_date);
            }else if(activity_start_date < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this activity start date is behind project start date",
                    position: 'topRight',
                });
                $('#edit_planned_start_date').datepicker('setDate', pro_planned_start_date);
            }else if(activity_start_date > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this activity start date is after project end date",
                    position: 'topRight',
                });
                $('#edit_planned_start_date').datepicker('setDate', pro_planned_end_date);
            }
        },
        'editActivity.planned_end_date' : function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var wbs_end_date = new Date(this.wbs_end_date).toDateString();
            var wbs_start_date = new Date(this.wbs_start_date).toDateString();

            var activity_end_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var wbs_end_date = new Date(wbs_end_date);
            var wbs_start_date = new Date(wbs_start_date);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);

            if(activity_end_date > wbs_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This activity end date is after parent WBS end date",
                    position: 'topRight',
                });
                $('#edit_planned_end_date').datepicker('setDate', wbs_end_date);
            }else if(activity_end_date < wbs_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This activity end date is before parent WBS start date",
                    position: 'topRight',
                });
                $('#edit_planned_end_date').datepicker('setDate', wbs_start_date);
            }else if(activity_end_date < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this activity end date is behind project start date",
                    position: 'topRight',
                });
                $('#edit_planned_end_date').datepicker('setDate', pro_planned_start_date);
            }else if(activity_end_date > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this activity end date is after project end date",
                    position: 'topRight',
                });
                $('#edit_planned_end_date').datepicker('setDate', pro_planned_end_date);
            }
        },
    },
    created: function() {
        if(this.project_start_date == null || this.project_end_date == null){
            for (let i = 0; i < $(".create_date").length; i++) {
                $(".create_date")[i].disabled = true;
            }
        }
        this.getActivities();
        this.getAllActivities();
    }
});

function parseDate(str) {
    var mdy = str.split('-');
    var date = new Date(mdy[2], mdy[1]-1, mdy[0]);
    return date;
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
