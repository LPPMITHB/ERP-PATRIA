@extends('layouts.main')
@section('content-header')
@if ($wbs->wbs != null)
    @breadcrumb(
        [
            'title' => 'Manage Material',
            'subtitle' => '',
            'items' => [
                'Dashboard' => route('index'),
                $wbs->number => route('project_standard.createSubWbsStandard', $wbs->wbs->id),
                'Manage Material' => '',
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'Manage Material',
            'subtitle' => '',
            'items' => [
                'Dashboard' => route('index'),
                $wbs->number => route('project_standard.createWbsStandard', $wbs->project_standard_id),
                'Manage Material' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 p-b-50">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                @if ($edit)
                    <form id="create-wbs-material" class="form-horizontal" method="POST" action="{{ route('project_standard.updateMaterialStandard') }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form id="create-wbs-material" class="form-horizontal" method="POST" action="{{ route('project_standard.storeMaterialStandard') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="wbs_material">
                        <div class="box-header p-b-0">
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>Project Standard Information</b></div>
        
                                <div class="col-xs-4 no-padding">Name</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.name)"><b>: {{project.name}}</b></div>

                                <div class="col-xs-4 no-padding">Description</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.number)"><b>: {{project.description}}</b></div>
        
                                <div class="col-xs-4 no-padding">Ship Type</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.ship.type)"><b>: {{project.ship.type}}</b></div>
                            </div>
                            
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                                
                                <div class="col-xs-4 no-padding">Number</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.number)"><b>: {{wbs.number}}</b></div>
        
                                <div class="col-xs-4 no-padding">Description</div>
                                <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: {{wbs.description}}</b></div>
                                <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: -</b></div>
        
                                <div class="col-xs-4 no-padding">Deliverable</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
                            </div>
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-5">
                            <table id="material-standard-table" class="table table-bordered tableFixed m-b-0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Material Number</th>
                                        <th width="28%">Material Description</th>
                                        <th width="10%">Quantity</th>
                                        <th width="10%">Unit</th>
                                        <th width="15%">Parts Details</th>
                                        <th width="12%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(material, index) in materialTable">
                                        <td>{{ index + 1 }}</td>
                                        <td :id="material.material_code" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipCode(material.material_code)">{{ material.material_code}}</td>
                                        <td :id="material.material_name" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipDesc(material.material_name)">{{ material.material_name }}</td>
                                        <td>{{ material.quantity }}</td>
                                        <td>{{ material.unit }}</td>
                                        <td class="p-l-5" align="center" v-if="material.part_details.length > 0">
                                            <a class="btn btn-primary btn-xs" href="#view_part_details" data-toggle="modal" @click="openViewParts(material)">
                                                VIEW PARTS DETAILS
                                            </a>
                                        </td>
                                        <td v-else>-</td>
                                        <td class="p-l-5" align="center">
                                            <a class="btn btn-primary btn-xs" @click="openEditModal(material,index)">
                                                EDIT
                                            </a>
                                            <a href="#" @click="removeRow(material)" class="btn btn-danger btn-xs">
                                                <div class="btn-group">DELETE</div>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td colspan="2" class="no-padding">
                                            <selectize class="selectizeFull" id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control width100" type="text" v-model="input.quantity" :disabled="materialOk"></td>
                                        <td class="no-padding"><input class="form-control width100" type="text" v-model="input.unit" disabled></td>
                                        <td class="p-l-5" align="center">
                                            <template v-if="input.selected_material != null">
                                                <template v-if="input.selected_material.dimension_type_id == 1 || input.selected_material.dimension_type_id == 2">
                                                    <button type="button" class="btn btn-primary btn-xs" href="#add_part_details" data-toggle="modal">
                                                        ADD PARTS DETAILS
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button type="button" class="btn btn-primary btn-xs" disabled>
                                                        ADD PARTS DETAILS
                                                    </button>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <button type="button" class="btn btn-primary btn-xs" disabled>
                                                    ADD PARTS DETAILS
                                                </button>
                                            </template>
                                        </td>
                                        <td class="p-l-0" align="center">
                                            <a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12 p-t-5">
                            <button v-if="submittedForm.edit" id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">SAVE</button>
                            <button v-else id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                        </div>
                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog modalFull">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Material</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials_modal" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity" :disabled="editMaterialOk">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Unit</label>
                                                <input type="text" id="quantity" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <template v-if="editInput.selected_material != null">
                                            <div class="row">
                                                <template v-if="editInput.selected_material.weight_uom != null">
                                                    <div class="col-sm-6">
                                                        <label for="type" class="control-label">Material Dimensions</label>
                                                        <div class="row" v-for="dimension in input_part_edit.dimensions_value">
                                                            <div class="col-xs-2">{{dimension.name}}</div>
                                                            <div class="col-xs-8"><b>: {{dimension.value}} {{dimension.uom.unit}}</b></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-2">Weight</div>
                                                            <div class="col-xs-8"><b>: {{editInput.selected_material.weight}}
                                                                    {{editInput.selected_material.weight_uom.unit}}</b></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="type" class="control-label">Parts Information</label>
                                                        <div class="row">
                                                            <div class="col-xs-3">Total Weight</div>
                                                            <div class="col-xs-8"><b>: {{editInput.parts_weight}} {{editInput.selected_material.weight_uom.unit}}</b></div>
                                                        </div>
                                            
                                                        <div class="row">
                                                            <div class="col-xs-3">Estimated Quantity</div>
                                                            <div class="col-xs-8"><b>: {{editInput.quantity_by_weight}}</b></div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="row" v-if="editInput.selected_material.weight_uom != null">
                                                <div class="col-sm-12">
                                                    <label for="type" class="control-label">Parts</label>
                                                    <table id="part-table-edit" class="table table-bordered tableFixed tablePagingVue">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th width="35%">Parts Description</th>
                                                                <th width="18%">Dimensions</th>
                                                                <th width="10%">Quantity</th>
                                                                <th width="10%">Weight</th>
                                                                <th width="7%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(part, index_part) in editInput.part_details">
                                                                <td>{{ index_part + 1 }}</td>
                                                                <template v-if="part.edit">
                                                                    <td class="no-padding">
                                                                        <input v-model="part.description" type="text" class="form-control width100"
                                                                            placeholder="Part Description">
                                                                    </td>
                                                                    <td class="row no-padding">
                                                                        <template v-if="editInput.selected_material.dimension_type_id == 1">
                                                                            <div v-for="dimension in part.dimensions_value_obj" class="col-sm-4 no-padding">
                                                                                <input v-model="dimension.value_input" type="text" class="form-control width100"
                                                                                    :placeholder="dimension.name">
                                                                            </div>
                                                                        </template>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <input v-model="part.quantity" type="text" class="form-control width100"
                                                                            placeholder="Quantity">
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <input disabled v-model="part.weight" type="text" class="form-control width100"
                                                                            placeholder="Weight">
                                                                    </td>
                                                                    <td class="p-l-5" align="center">
                                                                        <a class="btn btn-primary btn-xs" :disabled="savePartEditOk" @click="updateRowPartEdit(index_part)">
                                                                            SAVE
                                                                        </a>
                                                                    </td>
                                                                </template>
                                                                <template v-else>
                                                                    <td>{{ part.description }}</td>
                                                                    <td>{{ part.dimension_string }}</td>
                                                                    <td>{{ part.quantity }}</td>
                                                                    <td>{{ part.weight }}</td>
                                                                    <td class="p-l-5" align="center">
                                                                        <a class="btn btn-primary btn-xs" @click="editRowPartEdit(index_part)">
                                                                            EDIT
                                                                        </a>
                                                                        <a href="#" @click="removeRowPartEdit(part,index_part)" class="btn btn-danger btn-xs">
                                                                            <div class="btn-group">DELETE</div>
                                                                        </a>
                                                                    </td>
                                                                </template>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td>{{newIndexPartEdit}}</td>
                                                                <td class="no-padding">
                                                                    <input v-model="input_part_edit.description" type="text" class="form-control width100"
                                                                        placeholder="Part Description">
                                                                </td>
                                                                <td class="row no-padding">
                                                                    <template v-if="editInput.selected_material != null">
                                                                        <template v-if="editInput.selected_material.dimension_type_id == 1">
                                                                            <div v-for="dimension in input_part_edit.dimensions_value" class="col-sm-4 no-padding">
                                                                                <input v-model="dimension.value_input" type="text" class="form-control width100"
                                                                                    :placeholder="dimension.name">
                                                                            </div>
                                                                        </template>
                                                                    </template>
                                                                    <template v-else>
                                                                        <div class="p-l-10">Please select material first</div>
                                                                    </template>
                                                                </td>
                                                                <td class="no-padding">
                                                                    <input v-model="input_part_edit.quantity" type="text" class="form-control width100"
                                                                        placeholder="Quantity">
                                                                </td>
                                                                <td class="no-padding">
                                                                    <input disabled v-model="input_part_edit.weight" type="text" class="form-control width100"
                                                                        placeholder="Weight">
                                                                </td>
                                                                <td class="p-l-5" align="center">
                                                                    <a @click.prevent="submitToTablePartsEdit()" :disabled="inputPartEditOk" class="btn btn-primary btn-xs"
                                                                        href="#">
                                                                        <div class="btn-group">
                                                                            ADD
                                                                        </div>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="add_part_details">
                            <div class="modal-dialog modalFull">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Add Parts Details - {{input.material_code}} {{input.material_name}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" v-if="input.selected_material != null">
                                            <template v-if="input.selected_material.weight_uom != null">
                                                <div class="col-sm-6">
                                                    <label for="type" class="control-label">Material Dimensions</label>
                                                    <div class="row" v-for="dimension in input_part.dimensions_value">
                                                        <div class="col-xs-2">{{dimension.name}}</div>
                                                        <div class="col-xs-8"><b>: {{dimension.value}} {{dimension.uom.unit}}</b></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-2">Weight</div>
                                                        <div class="col-xs-8"><b>: {{input.selected_material.weight}} {{input.selected_material.weight_uom.unit}}</b></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="type" class="control-label">Parts Information</label>
                                                    <div class="row">
                                                        <div class="col-xs-3">Total Weight</div>
                                                        <div class="col-xs-8"><b>: {{input.parts_weight}} {{input.selected_material.weight_uom.unit}}</b></div>
                                                    </div>
    
                                                    <div class="row">
                                                        <div class="col-xs-3">Estimated Quantity</div>
                                                        <div class="col-xs-8"><b>: {{input.quantity_by_weight}}</b></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Parts</label>
                                                <table id="part-table" class="table table-bordered tableFixed tablePagingVue">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="35%">Parts Description</th>
                                                            <th width="18%">Dimensions</th>
                                                            <th width="10%">Quantity</th>
                                                            <th width="10%">Weight</th>
                                                            <th width="7%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(part, index_part) in input.part_details">
                                                            <td>{{ index_part + 1 }}</td>
                                                            <template v-if="part.edit">
                                                                <td class="no-padding">
                                                                    <input v-model="part.description" type="text" class="form-control width100" placeholder="Part Description">    
                                                                </td>
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
                                                                <td class="no-padding">
                                                                    <input disabled v-model="part.weight" type="text" class="form-control width100" placeholder="Weight">
                                                                </td>
                                                                <td class="p-l-5" align="center">
                                                                    <a class="btn btn-primary btn-xs" :disabled="savePartOk" @click="updateRowPart(index_part)">
                                                                        SAVE
                                                                    </a>
                                                                </td>
                                                            </template>
                                                            <template v-else>
                                                                <td>{{ part.description }}</td>
                                                                <td>{{ part.dimension_string }}</td>
                                                                <td>{{ part.quantity }}</td>
                                                                <td>{{ part.weight }}</td>
                                                                <td class="p-l-5" align="center">
                                                                    <a class="btn btn-primary btn-xs" @click="editRowPart(index_part)">
                                                                        EDIT
                                                                    </a>
                                                                    <a href="#" @click="removeRowPart(part,index_part)" class="btn btn-danger btn-xs">
                                                                        <div class="btn-group">DELETE</div>
                                                                    </a>
                                                                </td>
                                                            </template>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td>{{newIndexPart}}</td>
                                                            <td class="no-padding">
                                                                <input v-model="input_part.description" type="text" class="form-control width100" placeholder="Part Description">
                                                            </td>
                                                            <td class="row no-padding">
                                                                <template v-if="input.selected_material != null">
                                                                    <template v-if="input.selected_material.dimension_type_id == 1">
                                                                        <div v-for="dimension in input_part.dimensions_value" class="col-sm-4 no-padding">
                                                                            <input v-model="dimension.value_input" type="text" class="form-control width100" :placeholder="dimension.name">
                                                                        </div>
                                                                    </template>
                                                                </template>
                                                                <template v-else>
                                                                    <div class="p-l-10">Please select material first</div>
                                                                </template>
                                                            </td>
                                                            <td class="no-padding">
                                                                <input v-model="input_part.quantity" type="text" class="form-control width100" placeholder="Quantity">
                                                            </td>
                                                            <td class="no-padding">
                                                                <input disabled v-model="input_part.weight" type="text" class="form-control width100" placeholder="Weight">
                                                            </td>
                                                            <td class="p-l-5" align="center">
                                                                <a @click.prevent="submitToTableParts()" :disabled="inputPartOk" class="btn btn-primary btn-xs" href="#">
                                                                    <div class="btn-group">
                                                                        ADD
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="view_part_details">
                            <div class="modal-dialog modalFull">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">View Parts Details - {{view.material_code}} {{view.material_name}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" v-if="view.selected_material != null">
                                            <template v-if="view.selected_material.weight_uom != null">
                                                <div class="col-sm-6">
                                                    <label for="type" class="control-label">Material Dimensions</label>
                                                    <div class="row" v-for="dimension in JSON.parse(view.selected_material.dimensions_value)">
                                                        <div class="col-xs-2">{{dimension.name}}</div>
                                                        <div class="col-xs-8"><b>: {{dimension.value}} {{dimension.uom.unit}}</b></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-2">Weight</div>
                                                        <div class="col-xs-8"><b>: {{view.selected_material.weight}} {{view.selected_material.weight_uom.unit}}</b></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="type" class="control-label">Parts Information</label>
                                                    <div class="row">
                                                        <div class="col-xs-3">Total Weight</div>
                                                        <div class="col-xs-8"><b>: {{view.parts_weight}} {{view.selected_material.weight_uom.unit}}</b></div>
                                                    </div>
    
                                                    <div class="row">
                                                        <div class="col-xs-3">Estimated Quantity</div>
                                                        <div class="col-xs-8"><b>: {{view.quantity_by_weight}}</b></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Parts</label>
                                                <table id="part-table-view" class="table table-bordered tableFixed showTable">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="35%">Parts Description</th>
                                                            <th width="18%">Dimensions</th>
                                                            <th width="10%">Quantity</th>
                                                            <th width="10%">Weight</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(part, index_part) in view.part_details">
                                                            <td>{{ index_part + 1 }}</td>
                                                            <td>{{ part.description }}</td>
                                                            <td>{{ part.dimension_string }}</td>
                                                            <td>{{ part.quantity }}</td>
                                                            <td>{{ part.weight }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endverbatim
                </form>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-wbs-material');

    $(document).ready(function(){
        $('div.overlay').hide();

        var part_table = $('#part-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
                document.getElementById("part-table_wrapper").setAttribute("style", "margin-top: -30px");
            }
        });

        var material_standard_table = $('#material-standard-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
                // document.getElementById("material-standard-table_wrapper").setAttribute("style", "margin-top: -30px");
            }
        });
    });

    var data = {
        project : @json($project),
        materials : @json($materials),
        wbs : @json($wbs),
        newIndex : 0, 
        newIndexPart : 0,
        newIndexPartEdit : 0,
        submittedForm :{
            project_id : @json($project->id),
            wbs_id : @json($wbs->id),
            edit : @json($edit),
            deleted_id : [],
            deleted_part_id : [],
        },
        input : {
            selected_material : null,
            material_id : "",
            material_name : "",
            material_code : "",
            quantity : "",
            unit : "",
            is_decimal : "",
            material_ok : "",
            quantity_by_weight : "",
            parts_weight : "",

            part_details : [],
        },
        input_part :{
            description: "",
            dimensions_value : "",
            quantity : "",
            volume : "",
            weight : "",

            dimension_string : null,
            edit : false,
        },

        input_part_edit :{
            description: "",
            dimensions_value : "",
            quantity : "",
            volume : "",
            weight : "",

            dimension_string : null,
            edit : false,
        },

        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            unit : "",
            is_decimal : "",
            material_ok : "",

            selected_material : null,
            quantity_by_weight : "",
            parts_weight : "",
            
            part_details : [],
        },

        view: {
            material_code : "",
            material_name : "",
            selected_material : null,
            part_details : [],
            parts_weight : "",
            quantity_by_weight : "",
        },
        materialTable : @json($existing_data),
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        material_id:@json($material_ids),
        material_id_modal:[],
        materials_modal :[],
        active_edit_part_index : "",
        active_edit_part_edit_index : "",

        temp_part_details_edit : [],
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el : '#wbs_material',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                if(this.input.material_id == "" || this.input.quantity == ""){
                    isOk = true;
                }
                return isOk;
            },
            inputPartOk: function(){
                let isOk = false;
                
                if(this.input_part.description == "" || this.input_part.quantity == ""){
                    isOk = true;
                }

                return isOk;
            },
            inputPartEditOk: function(){
                let isOk = false;
                
                if(this.input_part_edit.description == "" || this.input_part_edit.quantity == ""){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.materialTable.length < 1){
                    isOk = true;
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.editInput.material_id == "" || this.editInput.quantity == ""){
                    isOk = true;
                }

                return isOk;
            },
            materialOk : function(){
                let isOk = false;

                if(this.input.material_ok == ""){
                    isOk = true;
                }

                return isOk;
            },
            editMaterialOk : function(){
                let isOk = false;

                if(this.editInput.material_ok == ""){
                    isOk = true;
                }

                return isOk;
            },
            savePartOk : function(){
                let isOk = false;

                var part = this.input.part_details[this.active_edit_part_index];                
                if(part.description == "" || part.quantity == ""){
                    isOk = true;
                }

                return isOk;
            },
            savePartEditOk : function(){
                let isOk = false;

                var part = this.editInput.part_details[this.active_edit_part_edit_index];                
                if(part.description == "" || part.quantity == ""){
                    isOk = true;
                }

                return isOk;
            },
        },
        methods: {
            refreshTooltip: function(code,description){
                Vue.directive('tooltip', function(el, binding){
                    if(el.id == code){
                        $(el).tooltip('destroy');
                        $(el).tooltip({
                            title: el.id,
                            placement: binding.arg,
                            trigger: 'hover'             
                        })
                    }else if(el.id == description){
                        $(el).tooltip('destroy');
                        $(el).tooltip({
                            title: el.id,
                            placement: binding.arg,
                            trigger: 'hover'             
                        })
                    }
                })
            },
            tooltipCode: function(code) {
                return code;
            },
            tooltipDesc: function(desc) {
                return desc;
            },
            getNewMaterials(jsonMaterialId){
                window.axios.get('/api/getMaterialsBOM/'+jsonMaterialId).then(({ data }) => {
                    this.materials = data;
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
            getNewModalMaterials(jsonMaterialId){
                window.axios.get('/api/getMaterialsBOM/'+jsonMaterialId).then(({ data }) => {
                    this.materials_modal = data;
                    $('#edit_item').modal();
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
            openViewParts(material_standard){
                this.view = material_standard;
                $('#part-table-view').DataTable().destroy();
                this.$nextTick(function() {
                    $('#part-table-view').DataTable({
                        'paging' : true,
                        'lengthChange': false,
                        'ordering' : true,
                        'info' : true,
                        'autoWidth' : false,
                        'bFilter' : true,
                        'initComplete': function(){
                        $('div.overlay').hide();
                            document.getElementById("part-table-view_wrapper").setAttribute("style", "margin-top: -30px");
                        }
                    });
                })
            },
            openEditModal(data,index){
                $('div.overlay').show();
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.quantity = data.quantity;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_number = data.wbs_number;
                this.editInput.index = index;
                this.editInput.unit = data.unit;
                this.editInput.is_decimal = data.is_decimal;

                var material_id = JSON.stringify(this.material_id);
                material_id = JSON.parse(material_id);
                
                this.material_id_modal = material_id;
                this.material_id_modal.forEach(id => {
                    if(id == data.material_id){
                        var index = this.material_id_modal.indexOf(id);
                        this.material_id_modal.splice(index, 1);
                    }
                });
                var jsonMaterialId = JSON.stringify(this.material_id_modal);
                this.getNewModalMaterials(jsonMaterialId);

                this.temp_part_details_edit = data.part_details;
            },
            submitForm(){
                $('div.overlay').show();
                this.materialTable.forEach(data=>{
                    data.quantity = (data.quantity+"").replace(/,/g , '');
                    data.part_details.forEach(part => {
                        part.quantity = (part.quantity+"").replace(/,/g , '');
                    });
                })
                this.submittedForm.materials = this.materialTable;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            submitToTable(){
                if(this.input.material_id != "" && this.input.material_name != "" && this.input.quantity != ""){
                    $('div.overlay').show();

                    var data = JSON.stringify(this.input);
                    data = JSON.parse(data);
                    this.materialTable.push(data);

                    this.material_id.push(data.material_id); //ini buat nambahin material_id terpilih

                    var jsonMaterialId = JSON.stringify(this.material_id);
                    this.getNewMaterials(jsonMaterialId);             

                    this.newIndex = this.materialTable.length + 1;  

                    // refresh tooltip
                    let datas = [];
                    datas.push(this.input.material_code,this.input.material_name);
                    datas = JSON.stringify(datas);
                    datas = JSON.parse(datas);
                    this.refreshTooltip(datas[0],datas[1]);

                    this.input.material_id = "";
                    this.input.material_code = "";
                    this.input.material_name = "";
                    this.input.quantity = "";
                    this.input.unit = "";
                    this.input.quantityInt = 0;
                    this.input.quantity_by_weight = "";
                    this.input.parts_weight = "";
                    
                    this.input.part_details = [];
                    this.newIndexPart = this.input.part_details.length + 1;

                    $('#material-standard-table').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#material-standard-table').DataTable({
                            'paging' : true,
                            'lengthChange': false,
                            'ordering' : true,
                            'info' : true,
                            'autoWidth' : false,
                            'bFilter' : true,
                            'initComplete': function(){
                            $('div.overlay').hide();
                            // document.getElementById("material-standard-table_wrapper").setAttribute("style", "margin-top: -30px");
                            }
                        });
                    })

                    $('#part-table').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#part-table').DataTable({
                            'paging' : true,
                            'lengthChange': false,
                            'ordering' : true,
                            'info' : true,
                            'autoWidth' : false,
                            'bFilter' : true,
                            'initComplete': function(){
                            $('div.overlay').hide();
                            document.getElementById("part-table_wrapper").setAttribute("style", "margin-top: -30px");
                            }
                        });
                    })
                }
            },
            removeRow: function(material) {
                $('div.overlay').show();
                var index_materialId = "";
                var index_materialTable = "";
                if(typeof material.id !== 'undefined'){
                    this.submittedForm.deleted_id.push(material.id);
                }
                
                this.material_id.forEach(id => {
                    if(id == material.material_id){
                        index_materialId = this.material_id.indexOf(id);
                    }
                });
                for (var i in this.materialTable) { 
                    if(this.materialTable[i].material_id == material.material_id){
                        index_materialTable = i;
                    }
                }

                this.materialTable.splice(index_materialTable, 1);
                this.material_id.splice(index_materialId, 1);
                this.newIndex = this.materialTable.length + 1;

                var jsonMaterialId = JSON.stringify(this.material_id);
                this.getNewMaterials(jsonMaterialId);

                $('#material-standard-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#material-standard-table').DataTable({
                        'paging' : true,
                        'lengthChange': false,
                        'ordering' : true,
                        'info' : true,
                        'autoWidth' : false,
                        'bFilter' : true,
                        'initComplete': function(){
                        $('div.overlay').hide();
                        // document.getElementById("material-standard-table_wrapper").setAttribute("style", "margin-top: -30px");
                        }
                    });
                })
            },
            update(old_material_id, new_material_id){
                this.materialTable.forEach(material => {
                    if(material.material_id == old_material_id){
                        var material = this.materialTable[this.editInput.index];
                        material.quantityInt = this.editInput.quantityInt;
                        material.quantity = this.editInput.quantity;
                        material.unit = this.editInput.unit;
                        material.material_id = new_material_id;
                        material.wbs_id = this.editInput.wbs_id;

                        var elemCode = document.getElementById(material.material_code);
                        var elemDesc = document.getElementById(material.material_name);

                        window.axios.get('/api/getMaterialProjectStandard/'+new_material_id).then(({ data }) => {
                            material.material_name = data.description;
                            material.material_code = data.code;

                            this.material_id.forEach(id => {
                                if(id == old_material_id){
                                    var index = this.material_id.indexOf(id);
                                    this.material_id.splice(index, 1);
                                }
                            });
                            this.material_id.push(new_material_id);

                            var jsonMaterialId = JSON.stringify(this.material_id);
                            this.getNewMaterials(jsonMaterialId);

                            // refresh tooltip
                            elemCode.id = data.code;
                            elemDesc.id = data.description;
                            this.refreshTooltip(elemCode.id,elemDesc.id);
                            
                            $('#material-standard-table').DataTable().destroy();
                            this.$nextTick(function() {
                                $('#material-standard-table').DataTable({
                                    'paging' : true,
                                    'lengthChange': false,
                                    'ordering' : true,
                                    'info' : true,
                                    'autoWidth' : false,
                                    'bFilter' : true,
                                    'initComplete': function(){
                                    $('div.overlay').hide();
                                    // document.getElementById("material-standard-table_wrapper").setAttribute("style", "margin-top: -30px");
                                    }
                                });
                            })
                            $('div.overlay').hide();
                        })
                        .catch((error) => {
                            iziToast.warning({
                                title: 'Please Try Again..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            $('div.overlay').hide();
                        })
                    }
                });
            },
            submitToTableParts(){
                $('div.overlay').show();         
                var data = JSON.stringify(this.input_part);
                data = JSON.parse(data); 

                var still_empty = false;
                data.dimensions_value.forEach(dimension => {
                    if(dimension.value_input == undefined || dimension.value_input == ""){
                        still_empty = true;
                    }
                });

                if(!still_empty){
                    if(data.dimensions_value != null){
                        data.dimensions_value = JSON.stringify(data.dimensions_value);
                        data.dimensions_value_obj = JSON.parse(data.dimensions_value);
                    }
                    
                    this.input.part_details.push(data);
                    this.newIndexPart = this.input.part_details.length + 1;

                    this.input_part.description = "";
                    this.input_part.dimensions_value = JSON.parse(this.input.selected_material.dimensions_value);
                    this.input_part.dimension_string = "";
                    this.input_part.quantity = "";
                    this.input_part.weight = "";
                    this.input_part.volume = "";

                    $('#part-table').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#part-table').DataTable({
                            'paging' : true,
                            'lengthChange': false,
                            'ordering' : true,
                            'info' : true,
                            'autoWidth' : false,
                            'bFilter' : true,
                            'initComplete': function(){
                            $('div.overlay').hide();
                            document.getElementById("part-table_wrapper").setAttribute("style", "margin-top: -30px");
                            }
                        });
                    })
                }else{
                    iziToast.warning({
                        title: 'Please manage the part\'s dimension',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                }   
            },
            editRowPart(index){
                this.input.part_details[index].edit = true;
                this.active_edit_part_index = index;
                // var temp_selected_data = JSON.stringify(this.input.part_details[index]);
                // temp_selected_data = JSON.parse(temp_selected_data); 
                
                // this.edit_part.description = temp_selected_data.description;
                // this.edit_part.dimensions_value = JSON.parse(temp_selected_data.dimensions_value);
                // this.edit_part.quantity = temp_selected_data.quantity;
                // this.edit_part.weight = temp_selected_data.weight;
            },
            removeRowPart(part, index){
                this.input.part_details.splice(index, 1);
                this.newIndexPart = this.input.part_details.length + 1;
                
                $('#part-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#part-table').DataTable({
                        'paging' : true,
                        'lengthChange': false,
                        'ordering' : true,
                        'info' : true,
                        'autoWidth' : false,
                        'bFilter' : true,
                        'initComplete': function(){
                        $('div.overlay').hide();
                        document.getElementById("part-table_wrapper").setAttribute("style", "margin-top: -30px");
                        }
                    });
                })
            },
            updateRowPart(index){
                var data = JSON.stringify(this.input.part_details[this.active_edit_part_index]);
                data = JSON.parse(data); 

                var still_empty = false;
                data.dimensions_value_obj.forEach(dimension => {
                    if(dimension.value_input == undefined || dimension.value_input == ""){
                        still_empty = true;
                    }
                });

                if(!still_empty){
                    this.input.part_details[index].edit = false;

                    $('#part-table').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#part-table').DataTable({
                            'paging' : true,
                            'lengthChange': false,
                            'ordering' : true,
                            'info' : true,
                            'autoWidth' : false,
                            'bFilter' : true,
                            'initComplete': function(){
                            $('div.overlay').hide();
                            document.getElementById("part-table_wrapper").setAttribute("style", "margin-top: -30px");
                            }
                        });
                    })
                }else{
                    iziToast.warning({
                        title: 'Please manage the part\'s dimension',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                }  
            },

            submitToTablePartsEdit(){
                $('div.overlay').show();         
                var data = JSON.stringify(this.input_part_edit);
                data = JSON.parse(data); 

                var still_empty = false;
                data.dimensions_value.forEach(dimension => {
                    if(dimension.value_input == undefined || dimension.value_input == ""){
                        still_empty = true;
                    }
                });

                if(!still_empty){
                    if(data.dimensions_value != null){
                        data.dimensions_value = JSON.stringify(data.dimensions_value);
                        data.dimensions_value_obj = JSON.parse(data.dimensions_value);
                    }
                    
                    this.editInput.part_details.push(data);
                    this.newIndexPartEdit = this.editInput.part_details.length + 1;

                    this.input_part_edit.description = "";
                    this.input_part_edit.dimensions_value = JSON.parse(this.editInput.selected_material.dimensions_value);
                    this.input_part_edit.dimension_string = "";
                    this.input_part_edit.quantity = "";
                    this.input_part_edit.weight = "";
                    this.input_part_edit.volume = "";

                    $('#part-table-edit').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#part-table-edit').DataTable({
                            'paging' : true,
                            'lengthChange': false,
                            'ordering' : true,
                            'info' : true,
                            'autoWidth' : false,
                            'bFilter' : true,
                            'initComplete': function(){
                            $('div.overlay').hide();
                            document.getElementById("part-table-edit_wrapper").setAttribute("style", "margin-top: -30px");
                            }
                        });
                    })
                }else{
                    iziToast.warning({
                        title: 'Please manage the part\'s dimension',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                }   
            },
            editRowPartEdit(index){
                this.editInput.part_details[index].edit = true;
                this.active_edit_part_edit_index = index;
            },
            removeRowPartEdit(part, index){
                if(part.id != undefined){
                    this.submittedForm.deleted_part_id.push(part.id);
                }
                this.editInput.part_details.splice(index, 1);
                this.newIndexPartEdit = this.editInput.part_details.length + 1;
                
                $('#part-table-edit').DataTable().destroy();
                this.$nextTick(function() {
                    $('#part-table-edit').DataTable({
                        'paging' : true,
                        'lengthChange': false,
                        'ordering' : true,
                        'info' : true,
                        'autoWidth' : false,
                        'bFilter' : true,
                        'initComplete': function(){
                        $('div.overlay').hide();
                        document.getElementById("part-table-edit_wrapper").setAttribute("style", "margin-top: -30px");
                        }
                    });
                })
            },
            updateRowPartEdit(index){
                var data = JSON.stringify(this.editInput.part_details[this.active_edit_part_edit_index]);
                data = JSON.parse(data); 

                var still_empty = false;
                data.dimensions_value_obj.forEach(dimension => {
                    if(dimension.value_input == undefined || dimension.value_input == ""){
                        still_empty = true;
                    }
                });

                if(!still_empty){
                    this.editInput.part_details[index].edit = false;

                    $('#part-table').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#part-table').DataTable({
                            'paging' : true,
                            'lengthChange': false,
                            'ordering' : true,
                            'info' : true,
                            'autoWidth' : false,
                            'bFilter' : true,
                            'initComplete': function(){
                            $('div.overlay').hide();
                            document.getElementById("part-table_wrapper").setAttribute("style", "margin-top: -30px");
                            }
                        });
                    })
                }else{
                    iziToast.warning({
                        title: 'Please manage the part\'s dimension',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                }  
            },
        },
        watch: {
            'input.material_id': function(newValue){
                this.input.quantity = "";
                this.input_part.dimensions_value = null;
                if(newValue != ""){
                    this.input.material_ok = "ok";
                    window.axios.get('/api/getMaterialProjectStandard/'+newValue).then(({ data }) => {
                        this.input.selected_material = data;
                        this.input_part.dimensions_value = JSON.parse(data.dimensions_value);
                        this.input.material_name = data.description;
                        this.input.material_code = data.code;
                        this.input.unit = data.uom.unit;
                        this.input.is_decimal = data.uom.is_decimal;
                    });
                }else{
                    this.input.material_name = "";
                    this.input.material_code = "";
                    this.input.unit = "";
                    this.input.is_decimal = "";
                    this.input.material_ok = "";
                }
            },
            'editInput.material_id': function(newValue){
                if(newValue != this.editInput.old_material_id){
                    this.editInput.quantity = "";
                }
                if(newValue != ""){
                    this.editInput.material_ok = "ok";
                    window.axios.get('/api/getMaterialProjectStandard/'+newValue).then(({ data }) => {
                        this.editInput.selected_material = data;
                        this.input_part_edit.dimensions_value = JSON.parse(data.dimensions_value);
                        this.editInput.material_name = data.description;
                        this.editInput.material_code = data.code;
                        this.editInput.unit = data.uom.unit;
                        this.editInput.is_decimal = data.uom.is_decimal;
                        this.editInput.part_details = this.temp_part_details_edit;
                        this.newIndexPartEdit = this.editInput.part_details.length + 1;
                    });
                }else{
                    this.editInput.material_name = "";
                    this.editInput.material_code = "";
                    this.editInput.unit = "";
                    this.editInput.is_decimal = "";
                    this.editInput.material_ok = "";
                }
            },
            'input.parts_weight': function(newValue){
                if(newValue != "" && !isNaN(newValue)){
                    this.input.quantity_by_weight = Math.ceil(newValue / this.input.selected_material.weight);
                }else{
                    this.input.quantity_by_weight = "";
                    this.input.parts_weight = "";
                }
            },
            'input.part_details':{ 
                handler: function(newValue) {
                    if(newValue.length > 0){
                        var temp_total_weight = 0;
                        newValue.forEach(part_detail => {
                            temp_total_weight += part_detail.weight;
                            part_detail.dimensions_value = JSON.stringify(part_detail.dimensions_value_obj);
                            if(part_detail.dimensions_value != null){
                                var dimension_string = "";
                                JSON.parse(part_detail.dimensions_value).forEach(dimension => {
                                    var unit = dimension.uom.unit;
                                    if(dimension_string == ""){
                                        dimension_string += dimension.value_input+" "+unit;
                                    }else{
                                        dimension_string += " x "+dimension.value_input+" "+unit;
                                    }
                                });
                                part_detail.dimension_string = dimension_string;

                                var still_empty = false;
                                var temp_volume = 1;
                                part_detail.dimensions_value_obj.forEach(dimension => {
                                    if(dimension.value_input != undefined || dimension.value_input == ""){
                                        var temp_dimension_value = (dimension.value_input+"").replace(/,/g , '');
                                        temp_volume *= temp_dimension_value;

                                        if(dimension.uom.is_decimal == 1){
                                            var decimal_dimension_value = temp_dimension_value.replace(/,/g, '').split('.');
                                            if(decimal_dimension_value[1] != undefined){
                                                var maxDecimal = 2;
                                                if((decimal_dimension_value[1]+"").length > maxDecimal){
                                                    dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                                }else{
                                                    dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").replace(/\D/g, "");
                                                }
                                            }else{
                                                dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                            } 
                                        }else{
                                            dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                        }
                                    }else{
                                        still_empty = true;
                                    }
                                });

                                if(!still_empty){
                                    part_detail.volume = temp_volume;
                                }

                                if(part_detail.volume != "" && part_detail.quantity != ""){
                                    var temp_part_quantity = (part_detail.quantity+"").replace(/,/g , '');                            
                                    var temp_weight = ((part_detail.volume)/ 1000000) * this.input.selected_material.density.value * temp_part_quantity;
                                    part_detail.weight = parseFloat(temp_weight.toFixed(2));
                                    if(isNaN(part_detail.weight)){
                                        part_detail.weight = "";
                                    }
                                }
                            }

                            part_detail.quantity = (part_detail.quantity+"").replace(/[^0-9]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        });
                        this.input.parts_weight = (parseFloat(temp_total_weight).toFixed(2));
                    }else{
                        this.input.parts_weight = "";
                    }
                },
                deep: true
            },
            'editInput.parts_weight': function(newValue){
                if(newValue != "" && !isNaN(newValue) && this.editInput.selected_material != null){
                    this.editInput.quantity_by_weight = Math.ceil(newValue / this.editInput.selected_material.weight);
                }else{
                    this.editInput.quantity_by_weight = "";
                    this.editInput.parts_weight = "";
                }
            },
            'editInput.part_details':{ 
                handler: function(newValue) {
                    if(newValue.length > 0){
                        var temp_total_weight = 0;
                        newValue.forEach(part_detail => {
                            temp_total_weight += part_detail.weight;
                            part_detail.dimensions_value = JSON.stringify(part_detail.dimensions_value_obj);
                            if(part_detail.dimensions_value != null){
                                var dimension_string = "";
                                JSON.parse(part_detail.dimensions_value).forEach(dimension => {
                                    var unit = dimension.uom.unit;
                                    if(dimension_string == ""){
                                        dimension_string += dimension.value_input+" "+unit;
                                    }else{
                                        dimension_string += " x "+dimension.value_input+" "+unit;
                                    }
                                });
                                part_detail.dimension_string = dimension_string;

                                var still_empty = false;
                                var temp_volume = 1;
                                part_detail.dimensions_value_obj.forEach(dimension => {
                                    if(dimension.value_input != undefined || dimension.value_input == ""){
                                        var temp_dimension_value = (dimension.value_input+"").replace(/,/g , '');
                                        temp_volume *= temp_dimension_value;

                                        if(dimension.uom.is_decimal == 1){
                                            var decimal_dimension_value = temp_dimension_value.replace(/,/g, '').split('.');
                                            if(decimal_dimension_value[1] != undefined){
                                                var maxDecimal = 2;
                                                if((decimal_dimension_value[1]+"").length > maxDecimal){
                                                    dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                                }else{
                                                    dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").replace(/\D/g, "");
                                                }
                                            }else{
                                                dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                            } 
                                        }else{
                                            dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                        }
                                    }else{
                                        still_empty = true;
                                    }
                                });

                                if(!still_empty){
                                    part_detail.volume = temp_volume;
                                }

                                if(part_detail.volume != "" && part_detail.quantity != "" && this.editInput.selected_material != null){
                                    var temp_part_quantity = (part_detail.quantity+"").replace(/,/g , ''); 
                                    var temp_weight = ((part_detail.volume)/ 1000000) * this.editInput.selected_material.density.value * temp_part_quantity;
                                    part_detail.weight = parseFloat(temp_weight.toFixed(2));
                                    if(isNaN(part_detail.weight)){
                                        part_detail.weight = "";
                                    }
                                }
                            }

                            part_detail.quantity = (part_detail.quantity+"").replace(/[^0-9]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        });
                        this.editInput.parts_weight = (parseFloat(temp_total_weight).toFixed(2));
                    }else{
                        this.editInput.parts_weight = "";
                    }
                },
                deep: true
            },
            'view.part_details':{ 
                handler: function(newValue) {
                    if(newValue.length > 0){
                        var temp_total_weight = 0;
                        newValue.forEach(part_detail => {
                            temp_total_weight += part_detail.weight;
                            part_detail.dimensions_value = JSON.stringify(part_detail.dimensions_value_obj);
                            if(part_detail.dimensions_value != null){
                                var dimension_string = "";
                                part_detail.dimensions_value_obj.forEach(dimension => {
                                    var unit = dimension.uom.unit;
                                    if(dimension_string == ""){
                                        dimension_string += dimension.value_input+" "+unit;
                                    }else{
                                        dimension_string += " x "+dimension.value_input+" "+unit;
                                    }
                                });
                                part_detail.dimension_string = dimension_string;

                                var still_empty = false;
                                var temp_volume = 1;
                                part_detail.dimensions_value_obj.forEach(dimension => {
                                    if(dimension.value_input != undefined || dimension.value_input == ""){
                                        var temp_dimension_value = (dimension.value_input+"").replace(/,/g , '');
                                        temp_volume *= temp_dimension_value;

                                        if(dimension.uom.is_decimal == 1){
                                            var decimal_dimension_value = temp_dimension_value.replace(/,/g, '').split('.');
                                            if(decimal_dimension_value[1] != undefined){
                                                var maxDecimal = 2;
                                                if((decimal_dimension_value[1]+"").length > maxDecimal){
                                                    dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                                }else{
                                                    dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").replace(/\D/g, "");
                                                }
                                            }else{
                                                dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                            } 
                                        }else{
                                            dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                        }
                                    }else{
                                        still_empty = true;
                                    }
                                });

                                if(!still_empty){
                                    part_detail.volume = temp_volume;
                                }

                                if(part_detail.volume != "" && part_detail.quantity != ""){
                                    var temp_part_quantity = (part_detail.quantity+"").replace(/,/g , '');                            
                                    var temp_weight = ((part_detail.volume)/ 1000000) * this.view.selected_material.density.value * temp_part_quantity;
                                    part_detail.weight = parseFloat(temp_weight.toFixed(2));
                                    if(isNaN(part_detail.weight)){
                                        part_detail.weight = "";
                                    }
                                }
                            }

                            part_detail.quantity = (part_detail.quantity+"").replace(/[^0-9]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        });
                        this.view.parts_weight = (parseFloat(temp_total_weight).toFixed(2));
                         if(this.view.parts_weight != "" && !isNaN(this.view.parts_weight)){
                            this.view.quantity_by_weight = Math.ceil(this.view.parts_weight / this.view.selected_material.weight);
                        }else{
                            this.view.quantity_by_weight = "";
                            this.view.parts_weight = "";
                        }
                    }else{
                        this.view.parts_weight = "";
                    }
                },
                deep: true
            },
            'input_part.dimensions_value':{
                handler: function(newValue) {
                    if(newValue != null){
                        var still_empty = false;
                        var temp_volume = 1;
                        newValue.forEach(dimension => {
                            if(dimension.value_input != undefined || dimension.value_input == ""){
                                var temp_dimension_value = (dimension.value_input+"").replace(/,/g , '');
                                temp_volume *= temp_dimension_value;

                                if(dimension.uom.is_decimal == 1){
                                    var decimal_dimension_value = temp_dimension_value.replace(/,/g, '').split('.');
                                    if(decimal_dimension_value[1] != undefined){
                                        var maxDecimal = 2;
                                        if((decimal_dimension_value[1]+"").length > maxDecimal){
                                            dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                        }else{
                                            dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").replace(/\D/g, "");
                                        }
                                    }else{
                                        dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    } 
                                }else{
                                    dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }else{
                                still_empty = true;
                            }
                        });

                        if(!still_empty){
                            this.input_part.volume = temp_volume;
                        }

                        if(this.input_part.volume != "" && this.input_part.quantity != ""){
                            var temp_part_quantity = (this.input_part.quantity+"").replace(/,/g , '');                            
                            var temp_weight = ((this.input_part.volume)/ 1000000) * this.input.selected_material.density.value * temp_part_quantity;
                            this.input_part.weight = parseFloat(temp_weight.toFixed(2));
                        }
                    }   
                },
                deep: true
            }, 
            'input_part.quantity': function(newValue){
                if(newValue != null){
                    var still_empty = false;
                    var temp_volume = 1;
                    this.input_part.dimensions_value.forEach(dimension => {
                        if(dimension.value_input != undefined || dimension.value_input == ""){
                            var temp_dimension_value = (dimension.value_input+"").replace(/,/g , '');
                            temp_volume *= temp_dimension_value;
                        }else{
                            still_empty = true;
                        }
                    });

                    if(!still_empty){
                        this.input_part.volume = temp_volume;
                    }

                    if(this.input_part.volume != ""){
                        var temp_part_quantity = (newValue+"").replace(/,/g , '');                            
                        var temp_weight = ((this.input_part.volume)/ 1000000) * this.input.selected_material.density.value * temp_part_quantity;
                        this.input_part.weight = parseFloat(temp_weight.toFixed(2));
                    }
                    this.input_part.quantity = (newValue+"").replace(/[^0-9]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'input_part_edit.dimensions_value':{
                handler: function(newValue) {
                    if(newValue != null){
                        var still_empty = false;
                        var temp_volume = 1;
                        newValue.forEach(dimension => {
                            if(dimension.value_input != undefined || dimension.value_input == ""){
                                var temp_dimension_value = (dimension.value_input+"").replace(/,/g , '');
                                temp_volume *= temp_dimension_value;

                                if(dimension.uom.is_decimal == 1){
                                    var decimal_dimension_value = temp_dimension_value.replace(/,/g, '').split('.');
                                    if(decimal_dimension_value[1] != undefined){
                                        var maxDecimal = 2;
                                        if((decimal_dimension_value[1]+"").length > maxDecimal){
                                            dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                        }else{
                                            dimension.value_input = (decimal_dimension_value[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal_dimension_value[1]+"").replace(/\D/g, "");
                                        }
                                    }else{
                                        dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    } 
                                }else{
                                    dimension.value_input = (temp_dimension_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }else{
                                still_empty = true;
                            }
                        });

                        if(!still_empty){
                            this.input_part_edit.volume = temp_volume;
                        }

                        if(this.input_part_edit.volume != "" && this.input_part_edit.quantity != ""){
                            var temp_part_quantity = (this.input_part_edit.quantity+"").replace(/,/g , '');                            
                            var temp_weight = ((this.input_part_edit.volume)/ 1000000) * this.editInput.selected_material.density.value * temp_part_quantity;
                            this.input_part_edit.weight = parseFloat(temp_weight.toFixed(2));
                        }
                    }   
                },
                deep: true
            }, 
            'input_part_edit.quantity': function(newValue){
                if(newValue != null){
                    var still_empty = false;
                    var temp_volume = 1;
                    this.input_part_edit.dimensions_value.forEach(dimension => {
                        if(dimension.value_input != undefined || dimension.value_input == ""){
                            var temp_dimension_value = (dimension.value_input+"").replace(/,/g , '');
                            temp_volume *= temp_dimension_value;
                        }else{
                            still_empty = true;
                        }
                    });

                    if(!still_empty){
                        this.input_part_edit.volume = temp_volume;
                    }

                    if(this.input_part_edit.volume != ""){
                        var temp_part_quantity = (newValue+"").replace(/,/g , '');                            
                        var temp_weight = ((this.input_part_edit.volume)/ 1000000) * this.editInput.selected_material.density.value * temp_part_quantity;
                        this.input_part_edit.weight = parseFloat(temp_weight.toFixed(2));
                    }
                    this.input_part_edit.quantity = (newValue+"").replace(/[^0-9]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'input.quantity_by_weight': function(newValue){
                if(newValue != null){
                    this.input.quantity = newValue;
                }
            },
            'editInput.quantity_by_weight': function(newValue){
                if(newValue != null){
                    this.editInput.quantity = newValue;
                }
            },
            'input.quantity': function(newValue){
                var is_decimal = this.input.is_decimal;
                if(is_decimal == 0){
                    this.input.quantity = (this.input.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = (newValue+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.input.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.input.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.input.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            },
            'editInput.quantity': function(newValue){
                var is_decimal = this.editInput.is_decimal;
                if(is_decimal == 0){
                    this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = (newValue+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.editInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.editInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.editInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }  
            },
        },
        created: function() {
            this.newIndex = this.materialTable.length + 1;
            this.newIndexPart = this.input.part_details.length + 1;
            var jsonMaterialId = JSON.stringify(this.material_id);
            this.getNewMaterials(jsonMaterialId);        
        }
    });
       
</script>
@endpush
