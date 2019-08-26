@extends('layouts.main')
@section('content-header')
@if(isset($index))
    @breadcrumb(
        [
            'title' => "View Activities",
            'items' => [
                'Dashboard' => route('index'),
                'View all Projects' => route('project_repair.index'),
                'Project|'.$project->number => route('project_repair.show', ['id' => $project->id]),
                'Select WBS' => route('project_repair.listWBS',['id'=>$project->id,'menu'=>'viewAct']),
                'Manage Activities' => ""
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => "Manage Activities",
            'items' => [
                'Dashboard' => route('index'),
                'View all Projects' => route('project_repair.index'),
                'Project|'.$project->number => route('project_repair.show', ['id' => $project->id]),
                'Select WBS' => route('project_repair.listWBS',['id'=>$project->id,'menu'=>'addAct']),
                'Manage Activities' => ""
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
                                            $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td><b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_end_date);
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
            <div id="add_activity">
                <div class="box-body">
                    <h4 class="box-title">List of Activities (Weight : <b>{{totalWeight}}%</b> / <b>{{wbsWeight}}%</b>)</h4>
                    <table id="activity-table" class="table table-bordered" style="border-collapse:collapse; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width: 4%">No</th>
                                <th style="width: 14%">Name</th>
                                <th style="width: 15%">Description</th>
                                <th style="width: 10%">Start Date</th>
                                <th style="width: 10%">End Date</th>
                                <th style="width: 7%" >Duration</th>
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
                        <tfoot v-if="index == false">
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0">
                                    <selectize class="selectizeFull" v-model="newActivity.activity_configuration_id" :settings="activityConfigSettings">
                                        <option v-for="(activity_config, index) in activity_configs" :value="activity_config.id">{{ activity_config.name }} - {{ activity_config.description }}</option>
                                    </selectize> 
                                </td>
                                <td class="p-l-0">
                                    <textarea rows="2" autocomplete="off" v-model="newActivity.description"  type="text" class="form-control width100" id="description" name="description" placeholder="Description" >          
                                    </textarea>                              
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" v-model="newActivity.planned_start_date" type="text" class="form-control datepicker width100" id="planned_start_date" name="planned_start_date" placeholder="Start Date">
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" v-model="newActivity.planned_end_date" type="text" class="form-control datepicker width100" id="planned_end_date" name="planned_end_date" placeholder="End Date">
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" @keyup="setEndDateNew" @change="setEndDateNew" v-model="newActivity.planned_duration"  type="number" class="form-control width100" id="duration" name="duration" placeholder="Duration" >                                        
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" v-model="newActivity.weight"  type="text" class="form-control width100" id="weight" name="weight" placeholder="Weight" >                                        
                                </td>
                                <td class="p-l-0 textCenter p-r-5 p-l-5">
                                    <button class="btn btn-primary btn-xs col-xs-12 " data-toggle="modal" data-target="#add_dependent_activity">MANAGE DEPENDENT ACTIVITIES</button>
                                </td>
                                <td class="textCenter">
                                    <button @click.prevent="assignActivity" :disabled="nextStepOk" class="btn btn-primary" id="btnSubmit">CREATE</button>
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
                                    <h4 class="modal-title">Predecessor Activities <b id="activity_code" style="display: none"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
                                        <thead>
                                            <tr>
                                                <th class="p-l-5" style="width: 5%">No</th>
                                                <th style="width: 26%">Name</th>
                                                <th style="width: 30%">Description</th>
                                                <th style="width: 23%">WBS Number</th>
                                                <th style="width: 23%">Pred. Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in predecessorTableView">
                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
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
                        <div class="modal-dialog modalFull">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Activity <b id="edit_activity_code" style="display: none"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-6 border-right-modal">
                                            <div class="p-l-0 form-group col-sm-12">
                                                <label for="name" class="control-label">Activity Configuration</label>
                                                <selectize v-model="editActivity.activity_configuration_id" :settings="activityConfigSettings">
                                                    <option v-for="(activity_config, index) in activity_configs" :value="activity_config.id">{{ activity_config.name }} - {{ activity_config.description }}</option>
                                                </selectize>
                                            </div>

                                            <div class="p-l-0 form-group col-sm-12">
                                                <label for="weight" class=" control-label">Description</label>
                                                <textarea rows="3" autocomplete="off" v-model="editActivity.description"  type="text" class="form-control" id="edit_description" placeholder="Description" >                                        
                                                </textarea>                              
                                            </div>
        
                                            <div class="p-l-0 form-group col-sm-3">
                                                <label for="edit_planned_start_date" class=" control-label">Start Date</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input autocomplete="off" v-model="editActivity.planned_start_date" type="text" class="form-control datepicker" id="edit_planned_start_date" placeholder="Insert Start Date here...">                                             
                                                </div>
                                            </div>
                                                    
                                            <div class="p-l-0 form-group col-sm-3">
                                                <label for="edit_planned_end_date" class=" control-label">End Date</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input autocomplete="off" v-model="editActivity.planned_end_date" type="text" class="form-control datepicker" id="edit_planned_end_date" placeholder="Insert End Date here...">                                                                                            
                                                </div>
                                            </div>
                                            
                                            <div class="p-l-0 form-group col-sm-3">
                                                <label for="duration" class=" control-label">Duration</label>
                                                <input autocomplete="off" @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="editActivity.planned_duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >                                        
                                            </div>
                                                
                                            <div class="p-l-0 form-group col-sm-3">
                                                <label for="weight" class=" control-label">Weight</label>
                                                <input autocomplete="off" v-model="editActivity.weight"  type="text" class="form-control" id="edit_weight" placeholder="Weight" >                                        
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
                                        <div style="margin-left: -0.2em" class="col-sm-6 border-left-modal">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="length" class="col-sm-12 control-label">Material</label>
                    
                                                    <div class="col-sm-12">
                                                        <selectize id="material" name="material_id" v-model="editMaterial.material_id" :settings="material_settings">
                                                            <option v-if="material.selected==false" v-for="(material, index) in editMaterials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                        </selectize>    
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="length" class="col-sm-12 control-label">Length</label>
                                    
                                                    <div class="col-sm-8">
                                                        <input autocomplete="off" type="text" name="length" :disabled="lengthEditOk" class="form-control" id="lengths" v-model="editMaterial.lengths" >
                                                    </div>
                    
                                                    <div class="col-sm-4 p-l-2">
                                                        <selectize id="uom" name="dimension_uom_id" v-model="editMaterial.dimension_uom_id" :settings="length_uom_settings">
                                                            <option disabled v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                        </selectize>    
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="width" class="col-sm-12 control-label">Width</label>
                                    
                                                    <div class="col-sm-8">
                                                        <input autocomplete="off" type="text" name="width" :disabled="widthEditOk" class="form-control" id="width" v-model="editMaterial.width"  >
                                                    </div>
                    
                                                    <div class="col-sm-4 p-l-2">
                                                        <selectize id="uom" name="dimension_uom_id" v-model="editMaterial.dimension_uom_id" :settings="width_uom_settings">
                                                            <option disabled v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                        </selectize>    
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="height" class="col-sm-12 control-label">Height</label>
                                    
                                                    <div class="col-sm-8">
                                                        <input autocomplete="off" type="text" name="height" :disabled="heightEditOk" class="form-control" id="height" v-model="editMaterial.height" >
                                                    </div>
                    
                                                    <div class="col-sm-4 p-l-2">
                                                        <selectize id="uom" name="dimension_uom_id" v-model="editMaterial.dimension_uom_id" :settings="height_uom_settings">
                                                            <option disabled v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                        </selectize>    
                                                    </div>
                                                </div>   
        
                                                <div class="form-group">
                                                    <label for="quantity" class="col-sm-6 control-label">Quantity</label>
                                                    <label for="quantity" class="p-l-2 col-sm-6 control-label">Source</label>
                                
                                                    <div class="col-sm-6">
                                                        <input autocomplete="off" type="text" name="quantity" class="form-control" id="quantity" v-model="editMaterial.quantity" >
                                                    </div>
                                                    <div class="p-l-2 col-sm-6">
                                                        <selectize id="source" name="source" v-model="editMaterial.source" :settings="source_settings">
                                                            <option value="Stock">Stock</option>
                                                            <option value="WIP">WIP</option>
                                                        </selectize>  
                                                    </div>
                                                </div>  
                                                
                                                <div class="form-group">
                                                    <div class="m-t-10 col-sm-2">
                                                        <button :disabled="addMaterialEditOk" type="button" class="btn btn-primary" @click="addMaterialEdit">ADD</button>
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <div class="m-t-10 col-sm-12">
                                                        <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="p-l-5" style="width: 3%">No</th>
                                                                    <th style="width: 14%">Material</th>
                                                                    <th style="width: 6%">Length</th>
                                                                    <th style="width: 6%">Width</th>
                                                                    <th style="width: 6%">Height</th>
                                                                    <th style="width: 5%">UOM</th>
                                                                    <th style="width: 7%">Quantity</th>
                                                                    <th style="width: 6%">Source</th>
                                                                    <th style="width: 6%"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(data,index) in editActivity.dataMaterial">
                                                                    <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.material_name)">{{ data.material_name }}</td>
                                                                    <td v-if="data.lengths != ''" class="p-b-15 p-t-15">{{ data.lengths }}</td>
                                                                    <td v-else class="p-b-15 p-t-15">-</td>
                                                                    <td v-if="data.width != ''" class="p-b-15 p-t-15">{{ data.width }}</td>
                                                                    <td v-else class="p-b-15 p-t-15">-</td>
                                                                    <td v-if="data.height != ''" class="p-b-15 p-t-15">{{ data.height }}</td>
                                                                    <td v-else class="p-b-15 p-t-15">-</td>
                                                                    <td v-if="data.dimension_uom_id != null && data.dimension_uom_id != ''" class="p-b-15 p-t-15">{{ data.unit }}</td>
                                                                    <td v-else class="p-b-15 p-t-15">-</td>
                                                                    <td class="p-b-15 p-t-15">{{ data.quantity }}</td>
                                                                    <td class="p-b-15 p-t-15">{{ data.source }}</td>
                                                                    <td>
                                                                        <div class="col-sm-12 col-xs-12 no-padding p-r-2">
                                                                            <a class="btn btn-danger btn-xs col-xs-12" @click="removeMaterialEdit(data)" data-toggle="modal">
                                                                                DELETE
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table> 
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="m-t-10 border-top-modal">
                                                <div class="row m-t-10">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <label for="length" class="col-sm-12 control-label">Service</label>
                            
                                                            <div class="col-sm-12">
                                                                <selectize id="service" name="service_id" v-model="editActivity.service_id" :settings="service_settings">
                                                                    <option v-if="service.ship_id == null" v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }} [General]</option>
                                                                    <option v-if="service.ship_id != null" v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }} [{{service.ship.type}}]</option>
                                                                </selectize>    
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <label for="length" class="col-sm-12 control-label">Service Detail</label>
                            
                                                            <div v-show="editActivity.service_id == ''" class="col-sm-12">
                                                                <selectize disabled :settings="empty_service_settings">
                                                                </selectize>  
                                                            </div>
                                                            <div v-show="editActivity.selected_service.length == 0 && editActivity.service_id != ''" class="col-sm-12">
                                                                <selectize  disabled :settings="empty_service_detail_settings">
                                                                </selectize>  
                                                            </div>            
                                                            <div class="col-sm-12"  v-show="editActivity.selected_service.length > 0">
                                                                <selectize id="service_detail" name="service_detail_id" v-model="editActivity.service_detail_id" :settings="service_detail_settings">
                                                                    <option v-for="(service_detail, index) in editActivity.selected_service" :value="service_detail.id">{{ service_detail.name }} - {{ service_detail.description }}</option>
                                                                </selectize>    
                                                            </div>                                            
                                                        </div>
                                                    </div>
                                                            
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <label for="area" class="col-sm-12 control-label">Quantity/Area</label>
                                            
                                                            <div class="col-sm-8">
                                                                <input autocomplete="off" type="text" name="area" class="form-control" id="area" v-model="editActivity.area" >
                                                            </div>
                            
                                                            <div class="col-sm-4 p-l-2">
                                                                <selectize id="uom" name="area_uom_id" v-model="editActivity.area_uom_id" :settings="area_uom_settings">
                                                                    <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                                </selectize>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <label for="length" class="col-sm-12 control-label">Vendor</label>
                            
                                                            <div class="col-sm-12">
                                                                <selectize id="vendor" name="vendor_id" v-model="editActivity.vendor_id" :settings="vendor_settings">
                                                                    <option v-for="(vendor, index) in vendors" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                                                </selectize>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button :disabled="updateOk" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="modal fade" id="assign_activity_detail">
                        <div class="modal-dialog modalFull">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <div class="row">
                                        <h4 class="modal-title col-sm-8">Assign Material</h4>
                                        <h4 class="modal-title col-sm-2">Assign Service</h4>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-8 border-right-modal">
                                            <div class="form-group">
                                                <label for="length" class="p-l-0 col-sm-12 control-label">Material</label>
                
                                                <div class="p-l-0 col-sm-12">
                                                    <selectize id="material" name="material_id" v-model="newMaterial.material_id" :settings="material_settings">
                                                        <option v-if="material.selected==false" v-for="(material, index) in newMaterials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                    </selectize>    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="length" class="p-l-0 col-sm-12 control-label">Length</label>
                                
                                                <div class="p-l-0 col-sm-8">
                                                    <input autocomplete="off" type="text" name="length" :disabled="lengthOk" class="form-control" id="lengths" v-model="newMaterial.lengths" >
                                                </div>
                
                                                <div class="col-sm-4 p-l-2">
                                                    <selectize disabled id="uom" name="dimension_uom_id" v-model="newMaterial.dimension_uom_id" :settings="length_uom_settings">
                                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                    </selectize>    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="width" class="p-l-0 col-sm-12 control-label">Width</label>
                                
                                                <div class="p-l-0 col-sm-8">
                                                    <input autocomplete="off" type="text" name="width" :disabled="widthOk" class="form-control" id="width" v-model="newMaterial.width"  >
                                                </div>
                
                                                <div class="col-sm-4 p-l-2">
                                                    <selectize disabled id="uom" name="dimension_uom_id" v-model="newMaterial.dimension_uom_id" :settings="width_uom_settings">
                                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                    </selectize>    
                                                </div>
                                            </div>
                                        
                                            <div class="form-group">
                                                <label for="height" class="p-l-0 col-sm-12 control-label">Height</label>
                                
                                                <div class="p-l-0 col-sm-8">
                                                    <input autocomplete="off" type="text" name="height" :disabled="heightOk" class="form-control" id="height" v-model="newMaterial.height" >
                                                </div>
                
                                                <div class="col-sm-4 p-l-2">
                                                    <selectize disabled id="uom" name="dimension_uom_id" v-model="newMaterial.dimension_uom_id" :settings="height_uom_settings">
                                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                    </selectize>    
                                                </div>
                                            </div>   
    
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="quantity" class="col-sm-6 control-label">Quantity</label>
                                                    <label for="quantity" class="col-sm-6 control-label">Source</label>
                                                </div>
                                
                                                    <div class="p-l-0 col-sm-6">
                                                        <input autocomplete="off" type="text" name="quantity" class="form-control" id="quantity" v-model="newMaterial.quantity" >
                                                    </div>
                                                    <div class="p-l-2 col-sm-6">
                                                        <selectize id="source" name="source" v-model="newMaterial.source" :settings="source_settings">
                                                            <option value="Stock">Stock</option>
                                                            <option value="WIP">WIP</option>
                                                        </selectize>  
                                                    </div>
                                            </div>   

                                            <div class="form-group">
                                                <div class="p-l-0 m-t-10 col-sm-2">
                                                    <button :disabled="addMaterialOk" type="button" class="btn btn-primary" @click="addMaterial">ADD</button>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="p-l-0 m-t-10 col-sm-12">
                                                    <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
                                                        <thead>
                                                            <tr>
                                                                <th class="p-l-5" style="width: 3%">No</th>
                                                                <th style="width: 25%">Material</th>
                                                                <th style="width: 7%">Length</th>
                                                                <th style="width: 7%">Width</th>
                                                                <th style="width: 7%">Height</th>
                                                                <th style="width: 5%">UOM</th>
                                                                <th style="width: 7%">Quantity</th>
                                                                <th style="width: 6%">Source</th>
                                                                <th style="width: 6%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(data,index) in newActivity.dataMaterial">
                                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.material_name)">{{ data.material_name }}</td>
                                                                <td v-if="data.lengths != ''" class="p-b-15 p-t-15">{{ data.lengths }}</td>
                                                                <td v-else class="p-b-15 p-t-15">-</td>
                                                                <td v-if="data.width != ''" class="p-b-15 p-t-15">{{ data.width }}</td>
                                                                <td v-else class="p-b-15 p-t-15">-</td>
                                                                <td v-if="data.height != ''" class="p-b-15 p-t-15">{{ data.height }}</td>
                                                                <td v-else class="p-b-15 p-t-15">-</td>
                                                                <td v-if="data.unit != ''" class="p-b-15 p-t-15">{{ data.unit }}</td>
                                                                <td v-else class="p-b-15 p-t-15">-</td>
                                                                <td class="p-b-15 p-t-15">{{ data.quantity }}</td>
                                                                <td class="p-b-15 p-t-15">{{ data.source }}</td>
                                                                <td>
                                                                    <div class="col-sm-12 col-xs-12 no-padding p-r-2">
                                                                        <a class="btn btn-danger btn-xs col-xs-12" @click="removeMaterial(data)" data-toggle="modal">
                                                                            DELETE
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table> 
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div style="margin-left: -0.2em" class="col-sm-4 border-left-modal">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <label for="length" class="col-sm-12 control-label">Service</label>
                        
                                                        <div class="col-sm-12">
                                                            <selectize id="service" name="service_id" v-model="newActivity.service_id" :settings="service_settings">
                                                                <option v-if="service.ship_id == null" v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }} [General]</option>
                                                                <option v-if="service.ship_id != null" v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }} [{{service.ship.type}}]</option>
                                                            </selectize>    
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <label for="length" class="col-sm-12 control-label">Service Detail</label>
                        
                                                        <div v-show="newActivity.service_id == ''" class="col-sm-12">
                                                            <selectize disabled :settings="empty_service_settings">
                                                            </selectize>  
                                                        </div>
                                                        <div v-show="newActivity.selected_service.length == 0 && newActivity.service_id != ''" class="col-sm-12">
                                                            <selectize  disabled :settings="empty_service_detail_settings">
                                                            </selectize>  
                                                        </div>            
                                                        <div class="col-sm-12"  v-show="newActivity.selected_service.length > 0">
                                                            <selectize id="service_detail" name="service_detail_id" v-model="newActivity.service_detail_id" :settings="service_detail_settings">
                                                                <option v-for="(service_detail, index) in newActivity.selected_service" :value="service_detail.id">{{ service_detail.name }} - {{ service_detail.description }}</option>
                                                            </selectize>    
                                                        </div>                                            
                                                    </div>
                                                </div>
                                                      
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <label for="area" class="col-sm-12 control-label">Quantity/Area</label>
                                        
                                                        <div class="col-sm-8">
                                                            <input autocomplete="off" type="text" name="area" class="form-control" id="area" v-model="newActivity.area" >
                                                        </div>
                        
                                                        <div class="col-sm-4 p-l-2">
                                                            <selectize id="uom" name="area_uom_id" v-model="newActivity.area_uom_id" :settings="area_uom_settings">
                                                                <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                            </selectize>    
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <label for="length" class="col-sm-12 control-label">Vendor</label>
                        
                                                        <div class="col-sm-12">
                                                            <selectize id="vendor" name="vendor_id" v-model="newActivity.vendor_id" :settings="vendor_settings">
                                                                <option v-for="(vendor, index) in vendors" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                                            </selectize>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button :disabled="createOk" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="add">NEXT</button>
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
    index : @json(isset($index) ? $index : false),
    menu : @json($menu),
    newMaterials : @json($materials),
    editMaterials : @json($materials),
    services : @json($services),
    uoms : @json($uoms),
    vendors : @json($vendors),
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

    newMaterial : {
        material_id : "",
        material_name : "",
        quantity : 1,
        lengths :"",
        width : "",
        height :"",
        dimension_uom_id : "",
        unit : "",
        source : "Stock",
    },

    editMaterial : {
        id : null,
        material_id : "",
        material_name : "",
        quantity : 1,
        lengths :"",
        width : "",
        height :"",
        dimension_uom_id : "",
        unit : "",
        source : "Stock",
    },

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
        latest_predecessor : "",
        allPredecessor : [],
        activity_configuration_id : "",

        service_id: "",
        service_detail_id: "",
        selected_service : "",
        vendor_id : "",
        area :"",
        area_uom_id : "",

        dataMaterial : [],
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
        latest_predecessor : "",
        allPredecessor : [],
        activity_configuration_id : "",

        act_detail_service_id : "",
        service_id: "",
        service_detail_id: "",
        selected_service : "",
        vendor_id : "",
        area :"",
        area_uom_id : "",

        dataMaterial : [],
        deletedActDetail : [],
    },
    maxWeight : 0,
    totalWeight : 0,
    predecessorTable: [],
    predecessorTableView :[],
    predecessorTableEdit:[],
    constWeightAct : 0,
    oldValueWeight : "",
    activity_configs : @json($activity_config),
    first_open_modal_service : true,
    first_open_modal_area_uom : true,
    activitiesSettings: {
        placeholder: 'Predecessor Activities',
    },
    indexActivitiesSettings: {
        placeholder: 'Insert Predecessor Here...',
    },
    typeSettings:{
        placeholder: 'Predecessor Type',
    },
    activityConfigSettings:{
        placeholder: 'Activity Configuration',
    },
    weight_uom_settings: {
        placeholder: 'weight UOM!'
    },
    height_uom_settings: {
        placeholder: 'height UOM!'
    },
    length_uom_settings: {
        placeholder: 'length UOM!'
    },
    width_uom_settings: {
        placeholder: 'width UOM!'
    },
    area_uom_settings: {
        placeholder: 'Select area UOM!'
    },
    material_settings : {
        placeholder: 'Material'
    },
    service_settings : {
        placeholder: 'Service'
    },
    vendor_settings : {
        placeholder: 'Vendor'
    },
    empty_service_settings:{
        placeholder: 'Please select service first!'
    },
    empty_service_detail_settings:{
        placeholder: 'Service doesn\'t have service detail!'
    },
    service_detail_settings:{
        placeholder: 'Service Detail'
    },
    source_settings:{
        placeholder: 'Source'
    },
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
        addMaterialOk: function(){
            let isOk = false;
            if(this.newMaterial.dimension_uom_id != "" && this.newMaterial.dimension_uom_id != null){
                if(this.newMaterial.material_id == "" || 
                this.newMaterial.quantity == "" ||
                this.newMaterial.dimension_uom_id == "" ||
                this.newMaterial.height == "" || 
                this.newMaterial.height == 0 || 
                this.newMaterial.lengths == "" ||
                this.newMaterial.lengths == 0 ||
                this.newMaterial.width == "" ||
                this.newMaterial.width == 0 ||
                this.newMaterial.source == ""){
                    isOk = true;
                }
            }
            
            return isOk;
        },
        addMaterialEditOk: function(){
            let isOk = false;
            
            if(this.editMaterial.dimension_uom_id != "" && this.editMaterial.dimension_uom_id != null){
                if(this.editMaterial.material_id == "" || 
                this.editMaterial.quantity == "" ||
                this.editMaterial.dimension_uom_id == "" ||
                this.editMaterial.height == "" || 
                this.editMaterial.height == 0 || 
                this.editMaterial.lengths == "" ||
                this.editMaterial.lengths == 0 ||
                this.editMaterial.width == "" ||
                this.editMaterial.width == 0 ||
                this.editMaterial.source == ""){
                    isOk = true;
                }
            }
            
            return isOk;
        },
        createOk: function(){
            let isOk = false;
                if(this.newActivity.activity_configuration_id == ""
                || this.newActivity.weight == ""
                || this.newActivity.planned_duration == "")
                {
                    isOk = true;
                }

                if(this.newActivity.service_id != ""){
                    if(this.newActivity.area == "" || 
                    this.newActivity.area_uom_id == "" ||
                    this.newActivity.service_detail_id == "" ||
                    this.newActivity.vendor_id == "")
                    {
                        isOk = true;
                    }
                }

            return isOk;
        },
        nextStepOk: function(){
            let isOk = false;
                if(this.newActivity.activity_configuration_id == ""
                || this.newActivity.weight == ""
                || this.newActivity.planned_duration == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editActivity.activity_configuration_id == ""
                || this.editActivity.weight == ""
                || this.editActivity.planned_duration == "")
                {
                    isOk = true;
                }

                if(this.editActivity.service_id != ""){
                    if(this.editActivity.area == "" || 
                    this.editActivity.area_uom_id == "" ||
                    this.editActivity.service_detail_id == "" ||
                    this.editActivity.vendor_id == "")
                    {
                        isOk = true;
                    }
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
        heightOk :function(){
            let isOk = false;

            if(this.newMaterial.dimension_uom_id == ""){
                isOk = true;
            }
            return isOk;
        },
        lengthOk :function(){
            let isOk = false;

            if(this.newMaterial.dimension_uom_id == ""){
                isOk = true;
            }
            return isOk;
        },
        widthOk :function(){
            let isOk = false;

            if(this.newMaterial.dimension_uom_id == ""){
                isOk = true;
            }
            return isOk;
        },
        heightEditOk :function(){
            let isOk = false;

            if(this.editMaterial.dimension_uom_id == "" || 
            this.editMaterial.dimension_uom_id == null){
                isOk = true;
            }
            return isOk;
        },
        lengthEditOk :function(){
            let isOk = false;

            if(this.editMaterial.dimension_uom_id == "" ||
            this.editMaterial.dimension_uom_id == null){
                isOk = true;
            }
            return isOk;
        },
        widthEditOk :function(){
            let isOk = false;

            if(this.editMaterial.dimension_uom_id == "" ||
            this.editMaterial.dimension_uom_id == null){
                isOk = true;
            }
            return isOk;
        },
    }, 
    methods:{
        assignActivity(){
            $('#assign_activity_detail').modal();
        },
        addMaterial(){
            var temp = this.newMaterial;
            temp = JSON.stringify(temp);
            temp = JSON.parse(temp);
            this.newMaterials.forEach(material => {
                if(material.id == temp.material_id){
                    material.selected = true;
                }
            });
            this.newActivity.dataMaterial.push(temp);

            this.newMaterial.material_id = "";
            this.newMaterial.material_name = "";
            this.newMaterial.quantity = 1;
            this.newMaterial.lengths = "";
            this.newMaterial.width = "";
            this.newMaterial.height = "";
            this.newMaterial.dimension_uom_id = "";
            this.newMaterial.unit = "";
            this.newMaterial.source = "Stock";
        },
        addMaterialEdit(){
            var temp = this.editMaterial;
            temp = JSON.stringify(temp);
            temp = JSON.parse(temp);
            this.editMaterials.forEach(material => {
                if(material.id == temp.material_id){
                    material.selected = true;
                }
            });
            this.editActivity.dataMaterial.push(temp);

            this.editMaterial.material_id = "";
            this.editMaterial.material_name = "";
            this.editMaterial.quantity = 1;
            this.editMaterial.lengths = "";
            this.editMaterial.width = "";
            this.editMaterial.height = "";
            this.editMaterial.dimension_uom_id = "";
            this.editMaterial.unit = "";
            this.editMaterial.source = "Stock";
        },
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
        removeMaterial(data){
            for (let x = 0; x < this.newActivity.dataMaterial.length; x++) {
                if(this.newActivity.dataMaterial[x].material_id == data.material_id){
                    this.newActivity.dataMaterial.splice(x,1);
                }
            }
            this.newMaterials.forEach(material => {
                if(material.id == data.material_id){
                    material.selected = false;
                }
            });
        },
        removeMaterialEdit(data){
            for (let x = 0; x < this.editActivity.dataMaterial.length; x++) {
                if(this.editActivity.dataMaterial[x].material_id == data.material_id){
                    if(this.editActivity.dataMaterial[x].id != null){
                        this.editActivity.deletedActDetail.push(this.editActivity.dataMaterial[x].id);
                    }
                    this.editActivity.dataMaterial.splice(x,1);
                }
            }
            this.editMaterials.forEach(material => {
                if(material.id == data.material_id){
                    material.selected = false;
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
            $('div.overlay').show();     
            this.editMaterial.material_id = "";
            this.editMaterial.material_name = "";
            this.editMaterial.quantity = 1;
            this.editMaterial.lengths = "";
            this.editMaterial.width = "";
            this.editMaterial.height = "";
            this.editMaterial.dimension_uom_id = "";
            this.editMaterial.unit = ""; 
            this.predecessorTableEdit = [];
            document.getElementById("edit_activity_code").innerHTML= data.code;
            this.editActivity.activity_id = data.id;
            this.editActivity.name = data.name;
            this.editActivity.description = data.description;
            this.editActivity.activity_configuration_id = data.activity_configuration_id;
            this.editActivity.weight = data.weight;
            this.first_open_modal_service = true;
            this.first_open_modal_area_uom = true;
            
            var material = [];
            data.activity_details.forEach(act_detail => {
                if(act_detail.material_id != null){
                    act_detail['lengths'] = (act_detail['length']+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    act_detail['width'] = (act_detail['width']+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    act_detail['height'] = (act_detail['height']+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    act_detail['quantity'] = (act_detail['quantity_material']+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    act_detail['material_name'] = act_detail.material.code+" - "+act_detail.material.description;
                    if(act_detail.dimension_uom_id != null && act_detail.dimension_uom_id != ''){
                        act_detail['unit'] = act_detail.dimension_uom.unit;
                    }
                    this.editMaterials.forEach(material => {
                        if(material.id == act_detail['material_id']){
                            material.selected = true;
                        }
                    });

                    material.push(act_detail);
                }else if(act_detail.service_detail_id != null){
                    this.editActivity.act_detail_service_id = act_detail.id;
                    this.editActivity.service_id = act_detail.service_detail.service_id;
                    this.editActivity.service_detail_id = act_detail.service_detail_id;
                    this.editActivity.area = (act_detail.area+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");;
                    this.editActivity.area_uom_id = act_detail.area_uom_id;
                    this.editActivity.vendor_id = act_detail.vendor_id;
                }
            });
            this.editActivity.dataMaterial = material;
            
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
                $('div.overlay').hide();
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
                    })
                });
            })

        },
        add(){            
            var newActivity = this.newActivity;
            newActivity.dataMaterial.forEach(material => {
                material.lengths = (material.lengths+"").replace(/,/g , '');
                material.width = (material.width+"").replace(/,/g , '');
                material.height = (material.height+"").replace(/,/g , '');
                material.quantity = (material.quantity+"").replace(/,/g , '');
            });
            newActivity.area = (newActivity.area+"").replace(/,/g , '');        
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
                    this.newActivity.activity_configuration_id = "";
                    this.newActivity.planned_start_date = "";
                    this.newActivity.planned_end_date = "";
                    this.newActivity.planned_duration = "";
                    this.newActivity.weight = "";
                    this.newActivity.dataMaterial = [];
                    this.newActivity.service_id = "";
                    this.newActivity.service_detail_id = "";
                    this.newActivity.area = "";
                    this.newActivity.area_uom_id = "";
                    this.newActivity.vendor_id = "";

                    this.newMaterial.lengths="";
                    this.newMaterial.width = "";
                    this.newMaterial.height = "";
                    this.newMaterial.quantity = 1;
                    this.newMaterial.dimension_uom_id = "";
                    this.newMaterial.material_id = "";

                    this.newMaterials.forEach(material => {
                        if(material.selected){
                            material.selected = false;
                        }
                    });

                    this.newActivity.allPredecessor = []; 
                    this.predecessorTable =[];
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
            editActivity.dataMaterial.forEach(material => {
                material.lengths = (material.lengths+"").replace(/,/g , '');
                material.width = (material.width+"").replace(/,/g , '');
                material.height = (material.height+"").replace(/,/g , '');
                material.quantity = (material.quantity+"").replace(/,/g , '');
            });
            editActivity.area = (editActivity.area+"").replace(/,/g , '');        
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
                    $('div.overlay').hide();
                }
                this.newMaterials.forEach(material => {
                    if(material.selected){
                        material.selected = false;
                    }
                });
                this.editActivity.deletedActDetail = [];
                this.editActivity.dataMaterial = [];
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
                                $('div.overlay').hide();
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
        'newActivity.weight': function(newValue){
            this.newActivity.weight = (this.newActivity.weight+"").replace(/[^0-9.]/g, "");  
            if(roundNumber(newValue,2)>this.maxWeight){
                iziToast.warning({
                    displayMode: 'replace',
                    title: 'Total weight cannot exceed '+this.wbsWeight+'%',
                    position: 'topRight',
                });
                this.newActivity.weight = this.maxWeight;
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
        'newActivity.activity_configuration_id' : function(newValue){
            if(newValue != ""){
                this.activity_configs.forEach(activity_config => {
                    if(newValue == activity_config.id){
                        this.newActivity.number = activity_config.number;
                        this.newActivity.name = activity_config.name;
                        this.newActivity.description = activity_config.description;
                    }
                });
            }else{
                this.newActivity.number = "";
                this.newActivity.name = "";
                this.newActivity.description = "";
            }

        },
        'editActivity.activity_configuration_id' : function(newValue){
            if(newValue != ""){
                if(this.openModalFirstTime){
                    this.openModalFirstTime = false;
                }else{
                    this.activity_configs.forEach(activity_config => {
                        if(newValue == activity_config.id){
                            this.editActivity.number = activity_config.number;
                            this.editActivity.name = activity_config.name;
                            this.editActivity.description = activity_config.description;
                        }
                    });
                }
            }else{
                this.editActivity.number = "";
                this.editActivity.name = "";
                this.editActivity.description = "";
            }
        },
        'newMaterial.height': function(newValue) {
            var decimal = newValue.replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.newMaterial.height = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.newMaterial.height = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.newMaterial.height = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        'newMaterial.lengths': function(newValue) {
            var decimal = newValue.replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.newMaterial.lengths = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.newMaterial.lengths = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.newMaterial.lengths = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        'newMaterial.width': function(newValue) {
            var decimal = newValue.replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.newMaterial.width = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.newMaterial.width = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.newMaterial.width = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        'newActivity.area': function(newValue) {
            var decimal = newValue.replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.newActivity.area = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.newActivity.area = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.newActivity.area = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        'editActivity.area': function(newValue) {
            var decimal = newValue.replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.editActivity.area = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.editActivity.area = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.editActivity.area = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        'newMaterial.quantity': function(newValue) {
            this.newMaterial.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        'editMaterial.quantity': function(newValue) {
            this.editMaterial.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        'newActivity.service_id': function(newValue) {
            if(newValue != ""){
                this.newActivity.service_detail_id = "";
                this.services.forEach(service => {
                    if(service.id == newValue){
                        this.newActivity.selected_service = service.service_details;
                    }
                });
            }else{
                this.newActivity.selected_service = "";
                this.newActivity.service_detail_id = "";
            }
        },
        'newActivity.service_detail_id' : function(newValue){
            if(newValue != ""){
                this.newActivity.selected_service.forEach(service_detail => {
                    if(service_detail.id == newValue){
                        this.newActivity.area_uom_id = service_detail.uom_id;
                    }
                });
            }else{
                this.newActivity.area_uom_id = "";
            }
        },
        'editActivity.service_id': function(newValue) {
            if(newValue != ""){
                if(this.first_open_modal_service){
                    this.first_open_modal_service = false;
                }else{
                    this.editActivity.service_detail_id = "";
                }
                this.services.forEach(service => {
                    if(service.id == newValue){
                        this.editActivity.selected_service = service.service_details;
                    }
                });
            }else{
                this.editActivity.selected_service = "";
                this.editActivity.service_detail_id = "";
            }
        },
        'editActivity.service_detail_id' : function(newValue){
            if(newValue != ""){
                this.editActivity.selected_service.forEach(service_detail => {
                    if(service_detail.id == newValue){
                        this.editActivity.area_uom_id = service_detail.uom_id;
                    }
                });
            }else{
                this.editActivity.area_uom_id = "";
            }
        },
        'editActivity.area_uom_id' : function(newValue){
            if(newValue != ""){
                if(this.first_open_modal_area_uom){
                    this.first_open_modal_area_uom = false;
                }else{
                    this.editActivity.area = "";
                }
            }else{
                this.editActivity.area = "";
            }
        },
        'newActivity.area_uom_id' : function(newValue){
            this.newActivity.area = "";
        },
        'newMaterial.material_id': function(newValue) {
            if(newValue != ""){
                this.newMaterial.dimension_uom_id = "";
                this.newMaterials.forEach(material => {
                    if(material.id == newValue){
                        this.newMaterial.dimension_uom_id = material.dimension_uom_id;
                        if(material.dimension_uom_id != null){
                            this.newMaterial.lengths = material.length+"";
                            this.newMaterial.width = material.width+"";
                            this.newMaterial.height = material.height+"";
                        }else{
                            this.newMaterial.lengths = "";
                            this.newMaterial.width =  "";
                            this.newMaterial.height =  "";
                        }
                        this.newMaterial.material_name = material.code+" - "+material.description;
                    }
                });
            }
        },
        'newMaterial.dimension_uom_id': function(newValue) {
            if(newValue != ""){
                this.uoms.forEach(uom => {
                    if(uom.id == newValue){
                        this.newMaterial.unit = uom.unit;
                    }
                });
            }
        },
        'editMaterial.material_id': function(newValue) {
            if(newValue != ""){
                this.editMaterial.dimension_uom_id = "";
                this.editMaterials.forEach(material => {
                    if(material.id == newValue){
                        this.editMaterial.dimension_uom_id = material.dimension_uom_id;
                        if(material.dimension_uom_id != null){
                            this.editMaterial.lengths = material.length+"";
                            this.editMaterial.width = material.width+"";
                            this.editMaterial.height = material.height+"";
                        }else{
                            this.editMaterial.lengths = "";
                            this.editMaterial.width =  "";
                            this.editMaterial.height =  "";
                        }
                        this.editMaterial.material_name = material.code+" - "+material.description;
                    }
                });
            }
        },
        'editMaterial.dimension_uom_id': function(newValue) {
            if(newValue != ""){
                this.uoms.forEach(uom => {
                    if(uom.id == newValue){
                        this.editMaterial.unit = uom.unit;
                    }
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