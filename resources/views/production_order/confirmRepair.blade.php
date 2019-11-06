@extends('layouts.main')

@section('content-header')

@if($route == "/production_order")
    @breadcrumb(
        [
            'title' => 'Confirm Production Order » '.$modelPrO->number,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProject'),
                'Select WBS' => route('production_order.selectWBS', ['id' => $project->id]),
                'Add Additional Material & Resource' => ''
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/production_order_repair")
    @breadcrumb(
        [
            'title' => 'Confirm Production Order » '.$modelPrO->number,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order_repair.selectProject'),
                'Select WBS' => route('production_order_repair.selectWBS', ['id' => $project->id]),
                'Add Additional Material & Resource' => ''
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-4 p-l-0">
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

                <div class="col-sm-4 p-l-0">
                    <table>
                        <thead>
                            <th colspan="2">WBS Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->number}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->description}}</b></td>
                            </tr>
                            <tr>
                                <td>Deliverable</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->progress}}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if($route == "/production_order")
                <form id="confirm-wo" class="form-horizontal" method="POST" action="{{ route('production_order.storeConfirm') }}">
            @elseif($route == "/production_order_repair")
                <form id="confirm-wo" class="form-horizontal" method="POST" action="{{ route('production_order_repair.storeConfirm') }}">
            @endif
            <input type="hidden" name="_method" value="PATCH">
            @csrf
            @verbatim
            <div id="production_order">
                <div class="box-body p-t-0 p-b-5">
                    <h4>Activity</h4>
                    <table id="activity-table" class="table table-bordered tableFixed" >
                        <thead>
                            <tr>
                                <th style="width: 4%">No</th>
                                <th style="width: 25%">Activity Name</th>
                                <th style="width: 30%">Description</th>
                                <th style="width: 10%">Progress</th>
                                <th style="width: 10%">Weight</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities" >
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td>{{ data.progress }} %</td>
                                <td>{{ data.weight }} %</td>
                                <template v-if="data.status == 0">
                                    <template v-if="data.planned_end_date > data.actual_end_date">
                                        <td style="background-color: green; color: white;">
                                            Ahead {{data.date_diff}} Day(s)
                                        </td>
                                    </template>                                       
                                    <template v-if="data.planned_end_date == data.actual_end_date">
                                        <td style="background-color: green; color: white;">
                                            On Time
                                        </td>
                                    </template>                                       
                                    <template v-if="data.planned_end_date < data.actual_end_date">
                                        <td style="background-color: red; color: white;">
                                            Behind {{data.date_diff}} Day(s)
                                        </td>
                                    </template>                                       
                                </template>
                                <template v-else>
                                    <template v-if="data.planned_end_date > today">
                                        <td style="background-color: green; color: white;">
                                            Ahead {{data.date_diff}} Day(s)
                                        </td>
                                    </template>                                       
                                    <template v-if="data.planned_end_date == today">
                                        <td style="background-color: green; color: white;">
                                            On Time
                                        </td>
                                    </template>                                       
                                    <template v-if="data.planned_end_date < today">
                                        <td style="background-color: red; color: white;">
                                            Behind {{data.date_diff}} Day(s)
                                        </td>
                                    </template>
                                </template>
                                </td>
                                <td class="textCenter">
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#confirm_activity_modal"  @click.prevent="openConfirmModal(data)">CONFIRM</button>
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
                                                <td>&nbsp;<b id="planned_start_date"></b></td>
                                            </tr>
                                            <tr>
                                                <td>Planned End Date</td>
                                                <td>:</td>
                                                <td>&nbsp;<b id="planned_end_date"></b></td>
                                            </tr>
                                            <tr>
                                                <td>Planned Duration</td>
                                                <td>:</td>
                                                <td>&nbsp;<b id="planned_duration"></b></td>
                                            </tr>
                                            <tr>
                                                <td>Predecessor</td>
                                                <td>:</td>
                                                <td>&nbsp;<template v-if="havePredecessor == false">-</template></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <template v-if="havePredecessor == false"><br></template>
                                    <template v-if="havePredecessor == true">
                                        <table class="table table-bordered tableFixed">
                                            <thead>
                                                <tr>
                                                    <th class="p-l-5" style="width: 5%">No</th>
                                                    <th style="width: 15%">Code</th>
                                                    <th style="width: 29%">Name</th>
                                                    <th style="width: 29%">Description</th>
                                                    <th style="width: 15%">WBS Number</th>
                                                    <th style="width: 12%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(data,index) in predecessorActivities">
                                                    <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.number)">{{ data.wbs.number }}</td>
                                                    <td class="textCenter">
                                                        <template v-if="data.status == 0">
                                                            <i class="fa fa-check text-success"></i>
                                                        </template>
                                                        <template v-else>
                                                            <i class='fa fa-times text-danger'></i>
                                                        </template>    
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </template>
                                    <div class="row">
                                        <div class=" col-sm-6">
                                            <label for="actual_start_date" class=" control-label">Actual Start Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input v-model="confirmActivity.actual_start_date" type="text" class="form-control datepicker" id="actual_start_date" placeholder="Start Date">                                             
                                            </div>
                                        </div>
                                                
                                        <div class=" col-sm-6">
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
                                        <div class=" col-sm-6">
                                            <label for="duration" class=" control-label">Actual Duration (Days)</label>
                                            <input @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="confirmActivity.actual_duration"  type="number" class="form-control" id="actual_duration" placeholder="Duration" >                                        
                                        </div> 
                                        <div class=" col-sm-6">
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

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="box-title m-t-0">Material</h4>
                            <table id="material-table" class="table table-bordered tableFixed">
                                <thead>
                                    <tr>
                                        <th width="4%">No</th>
                                        <th width="10%">Material Code</th>
                                        <th width="12%">Description</th>
                                        <th width="5%">Quantity</th>
                                        <th width="5%">Actual</th>
                                        <th width="6%">Remaining</th>
                                        <th width="18%">Dimensions</th>                                        
                                        <th width="4%">UOM</th>
                                        <th width="5%">Weight</th>
                                        <th width="6%">Used</th>
                                        <th width="7%">Confirmed</th>
                                        <th width="11%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in materials">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis" v-tooltip:top="tooltipText(data.material.code)">{{ data.material.code }}</td>
                                        <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.material.description)">{{ data.material.description }}</td>
                                        <td class="tdEllipsis">{{ data.used }}</td>
                                        <td class="tdEllipsis">{{ data.actual }}</td>
                                        <td class="tdEllipsis">{{ data.sugQuantity }}</td>
                                        <template v-if="data.dimension_type_id == 1">
                                            <template v-if="data.editable">
                                                <td class="row no-padding">
                                                    <template v-if="input.selected_material.dimension_type_id == 1">
                                                        <div v-for="dimension in part.dimensions_value_obj" class="col-sm-4 no-padding">
                                                            <input v-model="dimension.value_input" type="text" class="form-control width100"
                                                                :placeholder="dimension.name">
                                                        </div>
                                                    </template>
                                                </td>
                                                <td class="no-padding">
                                                    <input v-model="part.quantity" type="text" class="form-control width100" placeholder="Quantity">
                                                </td>
                                            </template>
                                            <td v-if="data.editable" class="tdEllipsis no-padding">
                                                <input class="form-control width100" v-model="data.lengths" placeholder="Length">
                                            </td>
                                            <td v-else>
                                                {{data.lengths}}
                                            </td>
                                            <td v-if="data.editable" class="tdEllipsis no-padding">
                                                <input class="form-control width100" v-model="data.width" placeholder="Width">
                                            </td>
                                            <td v-else>
                                                {{data.width}}
                                            </td>
                                            <td v-if="data.editable" class="tdEllipsis no-padding">
                                                <input class="form-control width100" v-model="data.height" placeholder="Width">
                                            </td>
                                            <td v-else>
                                                {{data.height}}
                                            </td>
                                            <td>{{data.dimension_uom.unit}}</td>
                                            <td v-if="data.weight == '' || data.weight == 0 " class="tdEllipsis">
                                                -
                                            </td>
                                            <td v-else class="tdEllipsis" id="weight" data-container="body" v-tooltip:top="tooltipTextResponsive('getActiveWeight', data.id)">
                                                {{ data.weight }} kg                                     
                                            </td>
                                            <td v-if="data.quantity == '' || data.quantity == 0" class="tdEllipsis">
                                                -
                                            </td>
                                            <td v-else class="tdEllipsis" id="qty" data-container="body" v-tooltip:top="tooltipTextResponsive('getActiveQty', data.id)">
                                                {{ data.quantity }}                                        
                                            </td>
                                        </template>
                                        <template v-else>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td v-if="data.editable" class="tdEllipsis no-padding">
                                                <input class="form-control width100" v-model="data.quantity" placeholder="Qty">                                     
                                            </td>
                                            <td v-else class="tdEllipsis" id="qty" data-container="body" v-tooltip:top="tooltipTextResponsive('getActiveQty', data.id)">
                                                {{ data.quantity }}                                        
                                            </td>
                                        </template>
                                        <td v-if="data.production_order_details.length > 0" class="p-l-0 p-r-0 p-b-0 text-center">
                                            <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                                <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                                    <button type="button" class="btn btn-primary btn-xs col-xs-12" @click.prevent="openConfirmed(data)">CONFIRMED</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td v-else>-</td>
                                        <td class="p-l-0 p-r-0 p-b-0 text-center">
                                            <template v-if="data.editable">
                                                <template v-if="data.dimension_uom != null">
                                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                                        <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                                            <button :disabled="data.weight == 0 || data.weight == ''" type="button" class="btn btn-primary btn-xs" @click.prevent="saveProd(data)">SAVE</button>                                                
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                                        <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                                            <button :disabled="data.quantity == 0 || data.quantity == ''" type="button" class="btn btn-primary btn-xs" @click.prevent="saveProd(data)">SAVE</button>                                                
                                                        </div>
                                                    </div>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                                    <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                                        <button type="button" class="btn btn-primary btn-xs col-xs-12" @click.prevent="makeEditable(data)">EDIT</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                                    <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                                        <button type="button" class="btn btn-primary btn-xs col-xs-12" @click.prevent="openModalLeftover(data)">RETURNED MATERIAL</button>                                                
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="m-t-0">Resource</h4>
                            <table id="resource-table" class="table table-bordered tableFixed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%">Resource Name</th>
                                        <th width="40%">Operational Resource</th>
                                        <th width="15%">Status</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in resources">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.resource.code }} - {{ data.resource.name }}</td>
                                        <td class="tdEllipsis" v-if="data.resource_detail.category_id != 1">{{ data.resource_detail.code }} - {{ data.resource_detail.brand }}</td>
                                        <td class="tdEllipsis" v-else>{{ data.resource_detail.code }} - {{ data.resource_detail.others_name }}</td>
                                        <td>{{ data.status }}</td>
                                        <td v-if="data.status == 'UNACTUALIZED'" class="p-l-5" align="center"><a @click.prevent="openEditModal(data,index)" class="btn btn-primary btn-xs" href="#actual_resource" data-toggle="modal">
                                            <div class="btn-group">
                                                INPUT ACTUAL
                                            </div></a>
                                        </td>
                                        <td v-else class="p-l-5" align="center"><a @click.prevent="openEditModal(data,index)" class="btn btn-primary btn-xs" href="#actual_resource" data-toggle="modal">
                                            <div class="btn-group">
                                                EDIT ACTUAL
                                            </div></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade" id="actual_resource">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Input Actual Resource's Performance</h4>
                                </div>
                                <div class="modal-body p-t-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6 p-l-0">
                                                <label for="type" class="control-label p-b-10">Performance</label>
                                                <input class="form-control" v-model="editInput.performance" placeholder="Please Input Performance">
                                            </div>
                                            <div class="col-sm-6 no-padding">
                                                <label for="type" class="control-label p-b-10">Unit</label>
                                                <template v-if="editInput.statusUom == ''">
                                                    <selectize id="edit_modal" v-model="editInput.performance_uom_id" :settings="uomSettings">
                                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                    </selectize>
                                                </template>
                                                <template v-else-if="editInput.statusUom == 'exist'">
                                                    <selectize id="edit_modal" v-model="editInput.performance_uom_id" :settings="uomSettings" disabled>
                                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                                    </selectize>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-6 p-l-0">
                                                <label for="type" class="control-label p-b-10">Usage</label>
                                                <input class="form-control width100" v-model="editInput.usage" placeholder="Please Input Usage">
                                            </div>
                                            <div class="col-sm-6 p-t-45 p-l-0">
                                                Hour(s)
                                            </div>
                                        </div>
                                        <template v-if="editInput.category_id == 0">
                                            <div class="col-sm-12">
                                                <div class="col-sm-6 p-l-0">
                                                    <label for="type" class="control-label p-b-10">Total Accident</label>
                                                    <input class="form-control width100" v-model="editInput.total_accident" placeholder="Please Input Total Accident">
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <label for="type" class="control-label p-b-10">Morale Notes</label>
                                                <table id="morale-table" class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="25%">Subject</th>
                                                            <th width="35%">Notes</th>
                                                            <th width="20%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(data,index) in resources[editInput.index].morale">
                                                            <td>{{ index + 1 }}</td>
                                                            <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.subject)">{{ data.subject }}</td>
                                                            <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.notes)">{{ data.notes }}</td>
                                                            <td class="p-l-5" align="center"><a @click.prevent="editMoraleNotes(data,index)" class="btn btn-primary btn-xs" href="#morale_notes" data-toggle="modal">
                                                                <button type="button" data-dismiss="modal" class="btn btn-primary btn-xs" @click.prevent="">
                                                                    EDIT
                                                                </button></a>
                                                                <a href="#" @click="removeMoraleNotes(index)" class="btn btn-danger btn-xs">
                                                                    <div class="btn-group">DELETE</div>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="#morale_notes" data-toggle="modal">
                                        <button type="button" data-dismiss="modal" class="btn btn-primary" @click.prevent="">
                                            ADD NOTES
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-primary" :disabled="selectOk" data-dismiss="modal" @click.prevent="submitToTable">SAVE</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="morale_notes" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Input Morale Notes</h4>
                                </div>
                                <div class="modal-body p-t-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12 p-l-0">
                                                <label for="type" class="control-label p-b-10">Subject</label>
                                                <input class="form-control" v-model="moraleNotes.subject" placeholder="Please Input Subject">
                                            </div>
                                            <div class="col-sm-12 p-l-0">
                                                <label for="type" class="control-label p-b-10">Notes</label>
                                                <textarea rows="4" class="form-control" v-model="moraleNotes.notes" placeholder="Please Input Notes">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="#actual_resource" data-toggle="modal">
                                        <button v-if="moraleNotes.index !== ''" type="button" class="btn btn-primary" :disabled="addMoraleOk" data-dismiss="modal" @click.prevent="updateMoraleNotes">SAVE</button>
                                        <button v-else type="button" class="btn btn-primary" :disabled="addMoraleOk" data-dismiss="modal" @click.prevent="submitMoraleNotes">SAVE</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="material_return">
                        <div class="modal-dialog modalPredecessor">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Return Material (Material Offcut)</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 border-right-modal">
                                            <div class="form-group">
                                                <label for="length" class="col-sm-12">Material</label>
                
                                                <div class="col-sm-12">
                                                    <selectize id="material" name="material_id" v-model="return_material.material_id" :settings="material_settings">
                                                        <option v-if="material.selected==false" v-for="(material, index) in all_materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                    </selectize>    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="length" class="col-sm-12">Storage Location</label>
                
                                                <div class="col-sm-12">
                                                    <selectize id="sloc" name="sloc_id" v-model="return_material.sloc_id" :settings="sloc_settings">
                                                        <option v-for="(sloc, index) in modelSloc" :value="sloc.id">{{ sloc.code }} - {{ sloc.description }}</option>
                                                    </selectize>    
                                                </div>
                                            </div>
    
                                            <div class="form-group">
                                                <label for="quantity" class="col-sm-12">Quantity</label>
                                
                                                <div class="col-sm-12">
                                                    <input autocomplete="off" class="form-control width100" v-model="return_material.quantity" placeholder="Quantity">
                                                </div>
                                            </div>  
                                            
                                            <div class="form-group">
                                                <label for="quantity" class="col-sm-12">Quantity</label>
                                
                                                <div class="col-sm-12">
                                                    <input v-model="return_material.received_date" autocomplete="off" type="text" class="form-control datepicker" name="received_date" id="received_date" placeholder="Received Date">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="m-t-10 col-sm-2">
                                                    <button :disabled="addMaterialOk" type="button" class="btn btn-primary" @click="addMaterial">ADD</button>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="m-t-10 col-sm-12">
                                                    <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
                                                        <thead>
                                                            <tr>
                                                                <th class="p-l-5" style="width: 3%">No</th>
                                                                <th style="width: 20%">Material</th>
                                                                <th style="width: 20%">Storage Location</th>
                                                                <th style="width: 10%">Quantity</th>
                                                                <th style="width: 10%">Received Date</th>
                                                                <th style="width: 10%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(data,index) in data_return_material">
                                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.material_name)">{{ data.material_name }}</td>
                                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.sloc_name)">{{ data.sloc_name }}</td>
                                                                <td class="p-b-15 p-t-15">{{ data.quantity }}</td>
                                                                <td class="p-b-15 p-t-15">{{ data.received_date }}</td>
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
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button :disabled="createOk" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="save">NEXT</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="modal fade" id="show_material_return">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Return Material (Material Offcut)</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 border-right-modal">
                                            <div class="form-group">
                                                <div class="m-t-10 col-sm-12">
                                                    <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
                                                        <thead>
                                                            <tr>
                                                                <th class="p-l-5" style="width: 3%">No</th>
                                                                <th style="width: 25%">Material</th>
                                                                <th style="width: 25%">Storage Location</th>
                                                                <th style="width: 10%">Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody v-if="data_return_material_show.length > 0">
                                                            <tr v-for="(data,index) in data_return_material_show">
                                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.material_name)">{{ data.material_name }}</td>
                                                                <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.sloc_name)">{{ data.sloc_name }}</td>
                                                                <td class="p-b-15 p-t-15">{{ data.quantity }}</td>
                                                            </tr>
                                                        </tbody>
                                                        <tbody v-else>
                                                            <tr>
                                                                <td colspan="4" class="p-b-15 p-t-15 text-center"><b>EMPTY</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
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

                    <div class="modal fade" id="confirmed_prod">
                        <div class="modal-dialog modalPredecessor">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Confirmed Material <b>{{active_material}}</b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 border-right-modal">
                                            <div class="form-group">
                                                <div class="m-t-10 col-sm-12">
                                                    <table class="table table-bordered" style="border-collapse:collapse; table-layout:fixed;">
                                                        <thead>
                                                            <tr>
                                                                <th class="p-l-5" style="width: 3%">No</th>
                                                                <th style="width: 7%">Length</th>
                                                                <th style="width: 7%">Width</th>
                                                                <th style="width: 7%">Height</th>
                                                                <th style="width: 6%">UOM</th>
                                                                <th style="width: 7%">Weight</th>
                                                                <th style="width: 8%">Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(data,index) in data_confirmed_material_show">
                                                                <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                                <template v-if="data.dimension_uom != null">
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText((data.lengths+'').replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','))">{{ (data.lengths+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText((data.width+'').replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','))">{{ (data.width+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText((data.height+'').replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','))">{{ (data.height+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.dimension_uom.unit)">{{ data.dimension_uom.unit }}</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText((data.weight+'').replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',')+' kg')">{{ (data.weight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} kg</td>
                                                                    <td class="p-b-15 p-t-15">{{ (data.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                                </template>
                                                                <template v-else>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body">-</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body">-</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body">-</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body">-</td>
                                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body">-</td>
                                                                    <td class="p-b-15 p-t-15">{{ (data.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                                </template>
                                                            </tr>
                                                        </tbody>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
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

                    <div class="col-md-12 p-t-10 p-r-0">
                        <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CONFIRM</button>
                    </div>
                </div>
            </div>
            @endverbatim
            </form>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#confirm-wo');

    $(document).ready(function(){
        $('.datepicker').datepicker({
            autoclose : true,
        });
        $('div.overlay').hide();
    });

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var data = {
        today : "",
        modelSloc : @json($modelSloc),
        route : @json($route),
        menu : @json($route),
        uoms : @json($uoms),
        modelPrO : @json($modelPrO),
        modelPrOD : @json($modelPrOD),
        activities : @json($modelPrO->wbs->activities),
        materials : [],
        resources : [],
        services : [],
        wbs_id: @json($modelPrO->wbs->id),
        predecessorActivities : [],
        confirmActivity : {
            activity_id : "",
            actual_start_date : "",
            actual_end_date : "",
            actual_duration : "",
            current_progress : 0,
        },
        havePredecessor : false,
        submittedForm : {
        },
        editInput: {
            performance : "",
            performance_uom_id : "",
            usage : "",
            total_accident : "",
            statusUom : "",
            index : "",
            total_accident : "",
        },
        moraleNotes : {
            subject : "",
            notes : "",
            index : "",
        },
        uomSettings: {
            placeholder: 'Please Select Unit'
        },
        material_settings : {
            placeholder: 'Material'
        },
        sloc_settings : {
            placeholder: 'Storage Location'
        },
        all_materials : @json($materials),
        return_material : {
            id : null,
            material_id : "",
            material_name : "",
            sloc_id : "",
            sloc_name : "",
            quantity : "",
            received_date : "",
        },
        data_return_material : [],
        data_return_material_show : [],
        deleted_returned_material : [],
        data_confirmed_material_show : [],
        active_prod_id : "",
        active_material : "",
        data_changed : false,
    };

    var vm = new Vue({
        el: '#production_order',
        data: data,
        mounted() {
            $('.datepicker').datepicker({
                autoclose : true,
                format: 'dd-mm-yyyy',
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
            $("#received_date").datepicker().on(
                "changeDate", () => {
                    this.return_material.received_date = $('#received_date').val();
                }
            );
        },
        computed : {
            addMoraleOk: function(){
                let isOk = false;
                if(this.moraleNotes.subject == ""){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                return isOk;
            },
            selectOk: function(){
                let isOk = false;
                
                return isOk;
            },
            addMaterialOk: function(){
            let isOk = false;

            if(this.return_material.material_id == "" || 
            this.return_material.quantity == "" ||
            this.return_material.quantity == 0 ||
            this.return_material.received_date == "" 
            ){
                isOk = true;
            }
            
            return isOk;
        },
        },
        methods: {
            openConfirmed(data){
                this.active_material = data.material.description;
                this.data_confirmed_material_show = [];
                this.data_confirmed_material_show = data.production_order_details;
                $('#confirmed_prod').modal();
            },
            removeMaterial(data){
                for (let x = 0; x < this.data_return_material.length; x++) {
                    if(this.data_return_material[x].material_id == data.material_id){
                        if(this.data_return_material[x].id != null){
                            this.deleted_returned_material.push(this.data_return_material[x].id);
                        }
                        this.data_return_material.splice(x,1);
                    }
                }
                this.all_materials.forEach(material => {
                    if(material.id == data.material_id){
                        material.selected = false;
                    }
                });

                this.data_changed = true;
            },
            addMaterial(){
                var temp = this.return_material;
                temp = JSON.stringify(temp);
                temp = JSON.parse(temp);
                this.all_materials.forEach(material => {
                    if(material.id == temp.material_id){
                        material.selected = true;
                    }
                });
                this.data_return_material.push(temp);

                this.return_material.material_id = "";
                this.return_material.sloc_id = "";
                this.return_material.quantity = "";
                this.return_material.received_date = "";

                this.data_changed = true;
            },
            save(){
                var temp_returned = this.data_return_material;
                temp_returned = JSON.stringify(temp_returned);
                temp_returned = JSON.parse(temp_returned);

                var temp_deleted = this.deleted_returned_material;
                temp_deleted = JSON.stringify(temp_deleted);
                temp_deleted = JSON.parse(temp_deleted);

                this.materials.forEach(prod => {
                    if(prod.id == this.active_prod_id){
                        prod.returned_materials = temp_returned;
                        prod.deleted_returned_material = temp_deleted;
                        prod.editable = false;
                    }
                });
                this.all_materials.forEach(material => {
                    temp_returned.forEach(material_return => {
                        if(material.id == material_return.material_id){
                            material.selected = false;
                        }
                    });
                });

                this.data_return_material = [];
                this.deleted_returned_material = [];
                iziToast.success({
                    displayMode: 'replace',
                    title: 'Material information saved!',
                    position: 'topRight',
                });

                this.data_changed = true;
            },
            saveProd(data){
                this.all_materials.forEach(material => {
                    data.returned_materials.forEach(material_return => {
                        if(material.id == material_return.material_id){
                            material.selected = true;
                        }
                    });
                });
                this.data_return_material = data.returned_materials;
                this.active_prod_id = data.id;
                $('#material_return').modal();
            },
            makeEditable(data){
                data.editable = true;
            },
            openModalLeftover(data){
                this.data_return_material_show = data.returned_materials;
                $('#show_material_return').modal();
            },
            clearEditInput(){
                this.editInput.performance = "";
                this.editInput.performance_uom_id = "";
                this.editInput.usage = "";
                this.editInput.statusUom = "";
                this.editInput.total_accident = "";
            },
            editMoraleNotes(data,index){
                this.moraleNotes.index = index;
                this.moraleNotes.subject = data.subject;
                this.moraleNotes.notes = data.notes;
            },
            openEditModal(data,index){
                this.clearEditInput();
                this.editInput.index = index;
                this.editInput.performance = data.performance;
                this.editInput.category_id = data.resource_detail.category_id;
                this.editInput.usage = data.usage;
                this.editInput.performance_uom_id = data.performance_uom_id;
                this.editInput.total_accident = data.actual;

                if(data.resource_detail.performance_uom_id != "" && data.resource_detail.performance_uom_id != null && this.editInput.performance_uom_id != ""){
                    this.editInput.performance_uom_id = data.resource_detail.performance_uom_id;
                    this.editInput.statusUom = "exist";
                }else{
                    this.editInput.statusUom = "";
                }
            },
            submitToTable(){
                let resource = this.resources[this.editInput.index];
                resource.performance = this.editInput.performance;
                resource.performance_uom_id = this.editInput.performance_uom_id;
                resource.usage = this.editInput.usage;
                resource.actual = this.editInput.total_accident;
                if(resource.performance != "" && resource.usage != "" && resource.total_accident != ""){
                    resource.status = "ACTUALIZED";
                    iziToast.success({
                        displayMode: 'replace',
                        title: 'Actual Performance Submitted!',
                        position: 'topRight',
                    });
                }else{
                    resource.status = "UNACTUALIZED";
                }
            },
            submitMoraleNotes(){
                let resource = this.resources[this.editInput.index];
                let moraleNotes = {};
                moraleNotes.subject = this.moraleNotes.subject;
                moraleNotes.notes = this.moraleNotes.notes;
                resource.morale.push(moraleNotes);
                iziToast.success({
                    displayMode: 'replace',
                    title: 'Morale Notes Submitted!',
                    position: 'topRight',
                });
                this.moraleNotes.subject = "";
                this.moraleNotes.notes = "";
                
            },
            updateMoraleNotes(){
                let resource = this.resources[this.editInput.index].morale[this.moraleNotes.index];
                resource.subject = this.moraleNotes.subject;
                resource.notes = this.moraleNotes.notes;
                iziToast.success({
                    displayMode: 'replace',
                    title: 'Morale Notes Updated!',
                    position: 'topRight',
                });
                this.moraleNotes.subject = "";
                this.moraleNotes.notes = "";
                this.moraleNotes.index = "";
                
            },
            removeMoraleNotes: function(index) {
                this.resources[this.editInput.index].morale.splice(index, 1);
                iziToast.success({
                    displayMode: 'replace',
                    title: 'Morale Notes Deleted!',
                    position: 'topRight',
                });
            },
            tooltipText: function(text) {
                return text
            },
            tooltipTextResponsive: function(text, id) {
                var temp_text = "";
                this.materials.forEach(prod => {
                    if(prod.id == id){
                        Vue.directive('tooltip', function(el, binding){
                            if(el.id == "qty"){
                                $(el).tooltip('destroy');
                                $(el).tooltip({
                                    title: prod.quantity,
                                    placement: binding.arg,
                                    trigger: 'hover'             
                                })
                            }else if(el.id == "weight"){
                                $(el).tooltip('destroy');
                                $(el).tooltip({
                                    title: prod.weight+" kg",
                                    placement: binding.arg,
                                    trigger: 'hover'             
                                })
                            }
                        })
                    }
                });
                
            },
            submitForm() {
                let status = 0;
                this.activities.forEach(activity => {
                    if(activity.progress != 100){
                        status = 1;
                    }
                });
                this.materials.forEach(material => {
                    if(material.quantity != null && material.quantity != ''){
                        material.quantity = parseFloat((material.quantity+"").replace(/,/g , ''));
                        material.lengths = parseFloat((material.lengths+"").replace(/,/g , ''));
                        material.width = parseFloat((material.width+"").replace(/,/g , ''));
                        material.height = parseFloat((material.height+"").replace(/,/g , ''));
                        material.weight = parseFloat((material.weight+"").replace(/,/g , ''));
                        material.returned_materials.forEach(returned_material => {
                            returned_material.quantity = parseFloat((returned_material.quantity+"").replace(/,/g , ''));                            
                        });
                    }
                });
                if(status == 0){
                    let statusResource = 0;
                    this.resources.forEach(resource => {
                        if(resource.status == "UNACTUALIZED"){
                            statusResource = 1;
                        }
                    });
                    if(statusResource == 0){
                        this.modelPrOD.forEach(PROD => {
                            if(PROD.performance != null && PROD.performance != ''){
                                PROD.performance = parseInt((PROD.performance+"").replace(/,/g , ''));
                            }
                            if(PROD.usage != null && PROD.usage != ''){
                                PROD.usage = parseInt((PROD.usage+"").replace(/,/g , ''));
                            }
                        });
                        this.submittedForm.modelPrO = this.modelPrO;
                        this.submittedForm.modelPrOD = this.modelPrOD;
                        this.submittedForm.materials = this.materials;
                        this.submittedForm.services = this.services;
                        this.submittedForm.resources = this.resources;
                        this.submittedForm.data_changed = this.data_changed;

                        let struturesElem = document.createElement('input');
                        struturesElem.setAttribute('type', 'hidden');
                        struturesElem.setAttribute('name', 'datas');
                        struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                        form.appendChild(struturesElem);
                        form.submit();
                    }else{
                        iziToast.warning({
                            displayMode: 'replace',
                            title: 'Please Input Actual Resource\'s Performance !',
                            position: 'topRight',
                        });
                    }
                }else{
                    this.modelPrOD.forEach(PROD => {
                        if(PROD.performance != null && PROD.performance != ''){
                            PROD.performance = parseInt((PROD.performance+"").replace(/,/g , ''));
                        }
                        if(PROD.usage != null && PROD.usage != ''){
                            PROD.usage = parseInt((PROD.usage+"").replace(/,/g , ''));
                        }
                    });
                    this.submittedForm.modelPrO = this.modelPrO;
                    this.submittedForm.modelPrOD = this.modelPrOD;
                    this.submittedForm.materials = this.materials;
                    this.submittedForm.services = this.services;
                    this.submittedForm.resources = this.resources;
                    this.submittedForm.data_changed = this.data_changed;

                    let struturesElem = document.createElement('input');
                    struturesElem.setAttribute('type', 'hidden');
                    struturesElem.setAttribute('name', 'datas');
                    struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                    form.appendChild(struturesElem);
                    form.submit();
                }
            },
            openConfirmModal(data){
                this.predecessorTableView = [];
                if(data.predecessor != null){
                    this.havePredecessor = true;
                    window.axios.get('/api/getPredecessor/'+data.id).then(({ data }) => {
                        this.predecessorActivities = data;
                        if(this.predecessorActivities.length>0){
                            this.predecessorActivities.forEach(activity => {
                                if(activity.status == 1){
                                    $('#actual_start_date').datepicker('setDate', null);
                                    document.getElementById("actual_start_date").disabled = true;
                                    document.getElementById("actual_start_date").value = null;
                                    document.getElementById("actual_end_date").disabled = true;
                                    document.getElementById("actual_duration").disabled = true;
                                    document.getElementById("btnSave").disabled = true;
                                    document.getElementById("current_progress").disabled = true;
                                }else{
                                    document.getElementById("actual_start_date").disabled = false;
                                }
                            });
                        }else{
                            document.getElementById("actual_start_date").disabled = false;
                        }
                    });
                }else{
                    document.getElementById("actual_start_date").disabled = false;
                    this.havePredecessor = false;
                    this.predecessorActivities = [];
                }
                
                this.confirmActivity.current_progress = data.progress;
                if(this.confirmActivity.current_progress != 100){
                    document.getElementById("actual_end_date").disabled = true;
                    document.getElementById("actual_duration").disabled = true;
                    this.confirmActivity.actual_end_date = "";
                    this.confirmActivity.actual_duration = "";
                }else{
                    document.getElementById("actual_end_date").disabled = false;
                    document.getElementById("actual_duration").disabled = false;
                }
                document.getElementById("confirm_activity_code").innerHTML= data.code;
                document.getElementById("planned_start_date").innerHTML= data.planned_start_date.split("-").reverse().join("-");
                document.getElementById("planned_end_date").innerHTML= data.planned_end_date.split("-").reverse().join("-");
                document.getElementById("planned_duration").innerHTML= data.planned_duration+" Day(s)";


                this.confirmActivity.activity_id = data.id;
                $('#actual_start_date').datepicker('setDate', (data.actual_start_date != null ? new Date(data.actual_start_date):new Date(data.planned_start_date)));
                $('#actual_end_date').datepicker('setDate', (data.actual_end_date != null ? new Date(data.actual_end_date):null));

            },
            setEndDateEdit(){
                if(this.confirmActivity.actual_duration != "" && this.confirmActivity.actual_start_date != ""){
                    var actual_duration = parseInt(this.confirmActivity.actual_duration);
                    var actual_start_date = this.confirmActivity.actual_start_date;
                    var actual_end_date = new Date(actual_start_date.split("-").reverse().join("-"));
                    
                    actual_end_date.setDate(actual_end_date.getDate() + actual_duration-1);
                    $('#actual_end_date').datepicker('setDate', actual_end_date);

                }else{
                    this.confirmActivity.actual_end_date = "";
                }
            },
            getActivities(){
                window.axios.get('/api/getActivities/'+this.wbs_id).then(({ data }) => {
                    this.activities = data;
                    
                    this.activities.forEach(activity => {
                        if(activity.status == 0){
                            activity.date_diff = Math.abs(datediff(parseDate(activity.planned_end_date.split("-").reverse().join("-")), parseDate(activity.actual_end_date.split("-").reverse().join("-"))) - 1);
                        }else{
                            activity.date_diff = Math.abs(datediff(parseDate(activity.planned_end_date.split("-").reverse().join("-")), parseDate(this.today.split("-").reverse().join("-"))) - 1);
                        }
                    });
                });

            },
            confirm(){            
                var confirmActivity = this.confirmActivity;
                var url = "";
                if(this.menu =="/production_order"){
                    var url = "/activity/updateActualActivity/"+confirmActivity.activity_id;
                }else{
                    var url = "/activity_repair/updateActualActivity/"+confirmActivity.activity_id;
                }
                confirmActivity = JSON.stringify(confirmActivity);
                window.axios.put(url,confirmActivity)
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
                    iziToast.warning({
                        displayMode: 'replace',
                        title: "Please try again.. ",
                        position: 'topRight',
                    });
                    console.log(error);
                })

            }
        },
        watch : {
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
            materials:{
                handler: function(newValue) {
                    this.materials.forEach(material => {
                        if(material.dimension_uom_id != null){
                            var temp_length = (material.lengths+"").replace(/,/g , '');  
                            var temp_width = (material.width+"").replace(/,/g , '');  
                            var temp_height = (material.height+"").replace(/,/g , '');  
                            var temp_weight = ((temp_length * temp_width * temp_height)/ 1000000) * material.material.density.value;
                            var temp_qty = Math.ceil(temp_weight / material.material.weight);
    
                            var decimal_length = temp_length.replace(/,/g, '').split('.');
                            if(decimal_length[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal_length[1]+"").length > maxDecimal){
                                    material.lengths = (decimal_length[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_length[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    material.lengths = (decimal_length[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_length[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                material.lengths = (temp_length+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } 
    
                            var decimal_width = temp_width.replace(/,/g, '').split('.');
                            if(decimal_width[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal_width[1]+"").length > maxDecimal){
                                    material.width = (decimal_width[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_width[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    material.width = (decimal_width[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_width[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                material.width = (temp_width+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } 
    
                            var decimal_height = temp_height.replace(/,/g, '').split('.');
                            if(decimal_height[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal_height[1]+"").length > maxDecimal){
                                    material.height = (decimal_height[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_height[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    material.height = (decimal_height[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_height[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                material.height = (temp_height+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } 
    
                            var decimal_weight = (temp_weight+"").replace(/,/g, '').split('.');
                            if(decimal_weight[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal_weight[1]+"").length > maxDecimal){
                                    material.weight = (decimal_weight[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_weight[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    material.weight = (decimal_weight[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_weight[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                material.weight = (temp_weight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } 

                        }else{
                            var temp_qty = material.quantity;
                        }

                        material.quantity = (temp_qty+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        
                    });
                },
                deep: true
            }, 
            'confirmActivity.actual_start_date' :function(newValue){
                if(newValue == ""){
                    $('#actual_end_date').datepicker('setDate', null);
                    this.confirmActivity.actual_duration = "";
                }
            },
            'confirmActivity.actual_duration' : function(newValue){
                if(newValue != ""){
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
                }
            },
            'editInput.performance' : function(newValue){
                this.editInput.performance = (this.editInput.performance+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'editInput.usage' : function(newValue){
                this.editInput.usage = (this.editInput.usage+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'return_material.material_id': function(newValue) {
                if(newValue != ""){
                    this.all_materials.forEach(material => {
                        if(material.id == newValue){
                            this.return_material.material_name = material.code+" - "+material.description;
                        }
                    });
                }else{
                    this.return_material.material_name = "";
                }

            },
            'return_material.sloc_id': function(newValue) {
                if(newValue != ""){
                    this.modelSloc.forEach(sloc => {
                        if(sloc.id == newValue){
                            this.return_material.sloc_name = sloc.code+" - "+sloc.description;
                        }
                    });
                }else{
                    this.return_material.sloc_name = "";
                }
            },
            'return_material.quantity': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.return_material.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.return_material.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.return_material.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
        },
        created: function() {
            this.getActivities();
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            this.today = today;

            this.modelPrOD.forEach(POD => {
                if(POD.material_id != null && POD.production_order_detail_id == null){
                    if(POD.actual == null){
                        POD.actual = 0;
                    }
                    POD.sugQuantity = POD.quantity-POD.actual;
                    let used = POD.quantity-POD.actual;
                    POD.used = POD.quantity;
                    POD.quantity = used;
                    if(POD.sugQuantity < 0){
                        POD.sugQuantity = 0;
                    }
                    if(POD.used < 0){
                        POD.quantity = 0;
                    }
                    POD.quantity = "";  
                    POD.actual = (POD.actual+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                    POD.sugQuantity = (POD.sugQuantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                    POD.used = (POD.used+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                    this.materials.push(POD);
                }else if(POD.resource_id != null && POD.resource_detail_id != null){
                    if(POD.morale != null){
                        POD.morale = JSON.parse(POD.morale);
                    }else{
                        POD.morale = [];
                    }
                    this.resources.push(POD);
                }
            });
        },
    });
    function parseDate(str) {
        var mdy = str.split('-');
        var date = new Date(mdy[2], mdy[1]-1, mdy[0]);
        return date;
    }

    function datediff(first, second) {
        return Math.round(((second-first)/(1000*60*60*24))+1);
    }
</script>
@endpush
