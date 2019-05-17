@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Work Request',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Create Work Request' => route('work_request.create'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if($menu == "building")
                    <form id="create-wr" class="form-horizontal" method="POST" action="{{ route('work_request.store') }}">
                @else
                    <form id="create-wr" class="form-horizontal" method="POST" action="{{ route('work_request_repair.store') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="wr">
                        <div class="box-header no-padding">
                            <template v-if="selectedProject.length > 0">
                                <div class="col-xs-12 col-md-4">
                                    <div class="col-sm-12 no-padding"><b>Project Information</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].number}}</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].ship.type}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="selectedProject[0].customer.name" @mouseover="changeText"><b>: {{selectedProject[0].customer.name}}</b></div>

                                    <div class="col-xs-5 no-padding">Start Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].planned_start_date}}</b></div>

                                    <div class="col-xs-5 no-padding">End Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].planned_end_date}}</b></div>
                                </div>
                            </template>
                            <div class="col-xs-12 col-md-4">
                                <label for="" >Project Name</label>
                                <selectize v-model="project_id" :settings="projectSettings" :disabled="dataOk">
                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.name }}</option>
                                </selectize>  
                                <template v-if="selectedProject.length > 0">
                                    <div class="col-sm-12 col-lg-4 p-l-0 p-t-20 ">
                                        <label for="">Required Date</label>
                                    </div>
                                    <div class="col-sm-12 col-lg-8 p-l-0 p-t-15 ">
                                        <input v-model="required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="required_date" id="required_date" placeholder="Set Default Required Date">
                                    </div>
                                </template>
                            </div>
                            <template v-if="selectedProject.length > 0">
                                <div class="col-xs-12 col-md-4 p-r-0">
                                    <div class="col-sm-12 p-l-0">
                                        <label for="">WR Description</label>
                                    </div>
                                    <div class="col-sm-12 p-l-0">
                                        <textarea class="form-control" rows="4" v-model="description" ></textarea>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="row" v-if="selectedProject.length > 0">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <h4>Raw Material</h4>
                                <table class="table table-bordered tableFixed" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">WBS Name</th>
                                            <th style="width: 10%">Material Number</th>
                                            <th style="width: 15%">Material Description</th>
                                            <th style="width: 4%">Unit</th>
                                            <th style="width: 8%">Quantity</th>
                                            <th style="width: 8%">Available</th>
                                            <th style="width: 15%">Description</th>
                                            <th style="width: 10%">Required Date</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis" v-if="material.wbs_number != ''">{{ material.wbs_number }} - {{ material.wbs_desc }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td class="tdEllipsis">{{ material.material_code }}</td>
                                            <td class="tdEllipsis">{{ material.material_name }}</td>
                                            <td class="tdEllipsis">{{ material.unit }}</td>
                                            <td v-if="material.quantity != null" class="tdEllipsis">{{ material.quantity }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td v-if="material.available != ''"class="tdEllipsis">{{ material.available }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td class="tdEllipsis">{{ material.description}}</td>
                                            <td class="tdEllipsis">{{ material.required_date}}</td>
                                            <td class="p-l-0 textCenter">
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(material,index)">
                                                    EDIT
                                                </a>
                                                <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-l-10">{{newIndex}}</td>
                                            <td class="p-l-0 textLeft" v-show="wbss.length > 0">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }} - {{ wbs.description}}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="wbss.length == 0">
                                                <selectize disabled v-model="dataInput.wbs_id" :settings="wbsNullSettings">
                                                </selectize>
                                            </td>
                                            <td colspan="2" class="p-l-0 textLeft" v-show="dataInput.wbs_id == ''">
                                                <selectize disabled v-model="dataInput.id" :settings="nullSettings" disabled>
                                                </selectize>  
                                            </td>
                                            <td colspan="2" class="p-l-0 textLeft" v-show="dataInput.wbs_id != '' && materials.length == 0">
                                                <selectize disabled v-model="dataInput.material_id" :settings="materialNullSettings">
                                                </selectize>
                                            </td>
                                            <td colspan="2" class="p-l-0 textLeft" v-show="dataInput.wbs_id != '' && materials.length > 0">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.unit" disabled>
                                            </td>
                                            <td class="p-l-0">
                                                <input :disabled="materialOk" class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.available" disabled>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.description" placeholder="Please Fill in this Field">
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <input v-model="dataInput.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="input_required_date" id="input_required_date" placeholder="Required Date">  
                                            </td>
                                            <td class="p-l-0  textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <h4>Finished Goods</h4>
                                <table class="table table-bordered tableFixed" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">WBS Name</th>
                                            <th style="width: 10%">Material Number</th>
                                            <th style="width: 15%">Material Description</th>
                                            <th style="width: 4%">Unit</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 21%">Description</th>
                                            <th style="width: 10%">Required Date</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterialFG">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis" v-if="material.wbs_number != ''">{{ material.wbs_number }} - {{ material.wbs_desc }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td class="tdEllipsis">{{ material.material_code }}</td>
                                            <td class="tdEllipsis">{{ material.material_name }}</td>
                                            <td class="tdEllipsis">{{ material.unit }}</td>
                                            <td v-if="material.quantity != null" class="tdEllipsis">{{ material.quantity }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td class="tdEllipsis">{{ material.description}}</td>
                                            <td class="tdEllipsis">{{ material.required_date}}</td>
                                            <td class="p-l-0 textCenter">
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#editFG_item" @click="openEditModalFG(material,index)">
                                                    EDIT
                                                </a>
                                                <a href="#" @click="removeRowFG(index)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-l-10">{{newIndexFG}}</td>
                                            <td class="p-l-0 textLeft" v-show="wbss.length > 0">
                                                <selectize v-model="dataInputFG.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="wbss.length == 0">
                                                <selectize disabled v-model="dataInputFG.wbs_id" :settings="wbsNullSettings">
                                                </selectize>
                                            </td>
                                            <td colspan="2" class="p-l-0 textLeft" v-show="dataInputFG.wbs_id == ''">
                                                <selectize disabled v-model="dataInputFG.id" :settings="nullSettings" disabled>
                                                </selectize>  
                                            </td>
                                            <td colspan="2" class="p-l-0 textLeft" v-show="dataInputFG.wbs_id != '' && materialWIP.length == 0">
                                                <selectize disabled v-model="dataInput.material_id" :settings="materialWIPNullSettings">
                                                </selectize>
                                            </td>
                                            <td colspan="2" class="p-l-0 textLeft" v-show="dataInputFG.wbs_id != '' && materialWIP.length > 0">
                                                <selectize v-model="dataInputFG.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materialWIP" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInputFG.unit" disabled>
                                            </td>
                                            <td class="p-l-0">
                                                <input :disabled="materialFGOk" class="form-control" v-model="dataInputFG.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInputFG.description" placeholder="Please Fill in this Field">
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <input v-model="dataInputFG.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="inputFG_required_date" id="inputFG_required_date" placeholder="Required Date">  
                                            </td>
                                            <td class="p-l-0  textCenter">
                                                <button @click.prevent="addFG" :disabled="createFGOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12 p-t-10">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">CREATE</button>
                            </div>
                        </div>
                            
                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog">
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
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.wbs_id != '' && materialsEdit.length > 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materialsEdit" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.wbs_id != '' && materialsEdit.length == 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize disabled :settings="materialNullSettings" >
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.wbs_id == ''">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize disabled :settings="nullSettings" disabled >
                                                </selectize>  
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" id="unit" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input :disabled="materialEditOk" type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="available" class="control-label">Available</label>
                                                <input type="text" id="available" v-model="editInput.available" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <input type="text" id="description" v-model="editInput.description" class="form-control" placeholder="Please Input description">
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Required Date</label>
                                                <input v-model="editInput.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="edit_required_date" id="edit_required_date" placeholder="Required Date">  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editFG_item">
                            <div class="modal-dialog">
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
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInputFG.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInputFG.wbs_id != '' && materialWIPEdit.length == 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize disabled v-model="editInputFG.material_id" :settings="materialWIPNullSettings">
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInputFG.wbs_id != '' && materialWIPEdit.length > 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="edit_modal" v-model="editInputFG.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materialWIPEdit" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInputFG.wbs_id == ''">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize disabled :settings="nullSettings" disabled >
                                                </selectize>  
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" id="unit" v-model="editInputFG.unit" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input :disabled="materialEditFGOk" type="text" id="quantity" v-model="editInputFG.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <input type="text" id="description" v-model="editInputFG.description" class="form-control" placeholder="Please Input description">
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Required Date</label>
                                                <input v-model="editInputFG.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="editFG_required_date" id="editFG_required_date" placeholder="Required Date">  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateFGOk" data-dismiss="modal" @click.prevent="updateFG(editInputFG.old_material_id, editInputFG.material_id)">SAVE</button>
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
    const form = document.querySelector('form#create-wr');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        description : "",
        availableQuantity : [],
        newIndex : "",
        newIndexFG : "",
        boms : [],
        materials : [],
        materialWIP : [],
        materialsEdit : [],
        materialWIPEdit : [],
        projects : @json($modelProject),
        wbss : [],
        project_id : "",
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        wbsSettings: {
            placeholder: 'Please Select WBS'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        nullSettings:{
            placeholder: 'Please Select WBS First !'
        },
        wbsNullSettings:{
            placeholder: "Project doesn't have WBS !"
        },
        materialNullSettings:{
            placeholder: "WBS doesn't have BOM !"
        },
        materialWIPNullSettings:{
            placeholder: "WBS doesn't have BOM with source WIP !"
        },
        selectedProject : [],
        dataMaterial : [],
        dataMaterialFG : [],
        dataInput : {
            material_id :"",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            wbs_desc :"",
            available : "",
            description : "",
            required_date : "",
            unit : "",
            is_decimal :"",
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            wbs_desc :"",
            available : "",
            description : "",
            required_date : "",
            unit : "",
            is_decimal :"",
        },
        dataInputFG : {
            material_id :"",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            wbs_desc :"",
            description : "",
            required_date : "",
            unit : "",
            is_decimal :"",

        },
        editInputFG : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            wbs_desc :"",
            description : "",
            required_date : "",
            unit : "",
            is_decimal :"",

        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        submittedForm : {},
        required_date : "",

    }

    var vm = new Vue({
        el : '#wr',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataMaterial.length > 0){
                    isOk = true;
                }

                return isOk;
            },
            allOk: function(){
                let isOk = false;
                
                if(this.dataMaterial.length < 1 || this.submit == "" || this.dataMaterialFG.length < 1){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;

                var string_newValue = this.dataInput.quantity+"";
                this.dataInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.dataInput.material_id == "" || this.dataInput.quantityInt < 1 || this.dataInput.quantityInt == "" || isNaN(this.dataInput.quantityInt) || this.dataInput.wbs_id == "" || this.dataInput.description == ""){
                    isOk = true;
                }
                
                return isOk;
            },
            createFGOk: function(){
                let isOk = false;

                var string_newValue = this.dataInputFG.quantity+"";
                this.dataInputFG.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.dataInputFG.material_id == "" || this.dataInputFG.quantityInt < 1 || this.dataInputFG.quantityInt == "" || isNaN(this.dataInputFG.quantityInt) || this.dataInputFG.wbs_id == "" || this.dataInputFG.description == ""){
                    isOk = true;
                }
                
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityInt+"";
                this.editInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.editInput.material_id == "" || this.editInput.quantityInt < 1 || this.editInput.quantityInt == "" || isNaN(this.editInput.quantityInt) || this.editInput.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            updateFGOk: function(){
                let isOk = false;

                var string_newValue = this.editInputFG.quantityInt+"";
                this.editInputFG.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.editInputFG.material_id == "" || this.editInputFG.quantityInt < 1 || this.editInputFG.quantityInt == "" || isNaN(this.editInputFG.quantityInt) || this.editInputFG.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            materialOk: function(){
                let isOk = false;

                if(this.dataInput.material_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            materialFGOk: function(){
                let isOk = false;

                if(this.dataInputFG.material_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            materialEditOk: function(){
                let isOk = false;

                if(this.editInput.material_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            materialEditFGOk: function(){
                let isOk = false;

                if(this.editInputFG.material_id == ""){
                    isOk = true;
                }

                return isOk;
            },
        },
        methods : {
            changeText(){
                if(document.getElementsByClassName('tooltip-inner')[0]!= undefined){
                    if(document.getElementsByClassName('tooltip-inner')[0].innerHTML != this.selectedProject[0].customer.name ){
                        document.getElementsByClassName('tooltip-inner')[0].innerHTML=this.selectedProject[0].customer.name;    
                    }
                }
            },  
            submitForm(){
                this.submit = "";
                this.submittedForm.description = this.description;
                this.submittedForm.project_id = this.project_id;   

                this.dataMaterial.forEach(data=>{
                    data.quantity = (data.quantity+"").replace(/,/g , '');
                })
                this.submittedForm.materials = this.dataMaterial;

                this.dataMaterialFG.forEach(data=>{
                    data.quantity = (data.quantity+"").replace(/,/g , '');
                })
                this.submittedForm.materialsFG = this.dataMaterialFG;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            update(old_material_id, new_material_id){
                var material = this.dataMaterial[this.editInput.index];

                window.axios.get('/api/getMaterialWr/'+new_material_id).then(({ data }) => {
                    material.material_name = data.description;
                    material.material_code = data.code;
                    material.required_date = this.editInput.required_date;


                    if(this.editInput.wbs_id != ''){
                        window.axios.get('/api/getWbsWr/'+this.editInput.wbs_id).then(({ data }) => {
                            material.wbs_number = data.number;
                            material.wbs_desc = data.description;
                            material.quantityInt = this.editInput.quantityInt;
                            material.quantity = this.editInput.quantity;
                            material.material_id = new_material_id;
                            material.wbs_id = this.editInput.wbs_id;
                            material.description = this.editInput.description;
                            material.available = this.editInput.available;
                            material.unit = this.editInput.unit;

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
                    }else{
                        material.quantityInt = this.editInput.quantityInt;
                        material.quantity = this.editInput.quantity;
                    }
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
            updateFG(old_material_id, new_material_id){
                var material = this.dataMaterialFG[this.editInputFG.index];

                window.axios.get('/api/getMaterialWr/'+new_material_id).then(({ data }) => {
                    material.material_name = data.description;
                    material.material_code = data.code;
                    material.required_date = this.editInputFG.required_date;


                    if(this.editInputFG.wbs_id != ''){
                        window.axios.get('/api/getWbsWr/'+this.editInputFG.wbs_id).then(({ data }) => {
                            material.wbs_number = data.number;
                            material.wbs_desc = data.description;
                            material.quantityInt = this.editInputFG.quantityInt;
                            material.quantity = this.editInputFG.quantity;
                            material.material_id = new_material_id;
                            material.wbs_id = this.editInputFG.wbs_id;
                            material.description = this.editInputFG.description;
                            material.unit = this.editInputFG.unit;

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
                    }else{
                        material.quantityInt = this.editInputFG.quantityInt;
                        material.quantity = this.editInputFG.quantity;
                    }
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
            openEditModal(data,index){
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.quantity = data.quantity;
                this.editInput.quantityInt = data.quantityInt;
                this.editInput.old_wbs_id = data.wbs_id;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_number = data.wbs_number;
                this.editInput.index = index;
                this.editInput.available = data.available;
                this.editInput.description = data.description;
                this.editInput.required_date = data.required_date;
                this.editInput.unit = data.unit;
                this.editInput.is_decimal = data.is_decimal;

                var material_id = JSON.stringify(this.material_id);
                material_id = JSON.parse(material_id);
                
                this.material_id_modal.forEach(id => {
                    if(id == data.material_id){
                        var index = this.material_id_modal.indexOf(id);
                    }
                });
            },
            openEditModalFG(data,index){
                this.editInputFG.material_id = data.material_id;
                this.editInputFG.old_material_id = data.material_id;
                this.editInputFG.material_code = data.material_code;
                this.editInputFG.material_name = data.material_name;
                this.editInputFG.quantity = data.quantity;
                this.editInputFG.quantityInt = data.quantityInt;
                this.editInputFG.old_wbs_id = data.wbs_id;
                this.editInputFG.wbs_id = data.wbs_id;
                this.editInputFG.wbs_number = data.wbs_number;
                this.editInputFG.index = index;
                this.editInputFG.description = data.description;
                this.editInputFG.required_date = data.required_date;
                this.editInputFG.unit = data.unit;
                this.editInputFG.is_decimal = data.is_decimal;

                var material_id = JSON.stringify(this.material_id);
                material_id = JSON.parse(material_id);
                
                this.material_id_modal.forEach(id => {
                    if(id == data.material_id){
                        var index = this.material_id_modal.indexOf(id);
                    }
                });
            },
            add(){
                var material_id = this.dataInput.material_id;
                $('div.overlay').show();
                window.axios.get('/api/getMaterialWr/'+material_id).then(({ data }) => {
                    this.dataInput.material_name = data.description;
                    this.dataInput.material_code = data.code;

                    var temp_data = JSON.stringify(this.dataInput);
                    temp_data = JSON.parse(temp_data);

                    this.dataMaterial.push(temp_data);

                    this.dataInput.material_name = "";
                    this.dataInput.material_code = "";
                    this.dataInput.quantity = "";
                    this.dataInput.material_id = "";
                    this.dataInput.wbs_id = "";
                    this.dataInput.wbs_number = "";
                    this.dataInput.description = "";
                    this.dataInput.available = "";
                    this.dataInput.required_date = "";
                    
                    this.newIndex = Object.keys(this.dataMaterial).length+1;
                    
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
            addFG(){
                var material_id = this.dataInputFG.material_id;
                $('div.overlay').show();
                window.axios.get('/api/getMaterialWr/'+material_id).then(({ data }) => {
                    this.dataInputFG.material_name = data.description;
                    this.dataInputFG.material_code = data.code;

                    var temp_data = JSON.stringify(this.dataInputFG);
                    temp_data = JSON.parse(temp_data);

                    this.dataMaterialFG.push(temp_data);
                    
                    this.dataInputFG.material_name = "";
                    this.dataInputFG.material_code = "";
                    this.dataInputFG.quantity = "";
                    this.dataInputFG.material_id = "";
                    this.dataInputFG.wbs_id = "";
                    this.dataInputFG.wbs_number = "";
                    this.dataInputFG.description = "";
                    this.dataInputFG.required_date = "";
                    
                    this.newIndexFG = Object.keys(this.dataMaterialFG).length+1;
                    
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
            removeRow(index){
                this.dataMaterial.splice(index, 1);
                
                this.newIndex = this.dataMaterial.length + 1;
            },
            removeRowFG(index){
                this.dataMaterialFG.splice(index, 1);
                
                this.newIndexFG = this.dataMaterialFG.length + 1;
            }
        },
        watch : {
            'dataInput.material_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialWr/'+newValue).then(({ data }) => {
                        this.dataInput.unit = data.uom.unit;
                        this.dataInput.is_decimal = data.uom.is_decimal;

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
                    window.axios.get('/api/getQuantityReserved/'+newValue).then(({ data }) => {
                        this.availableQuantity = data;

                        this.dataInput.available = data.quantity - data.reserved;
                        this.dataInput.available = (this.dataInput.available+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        this.dataInput.quantity = "";


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

                
                }else{

                }
            },

            'dataInputFG.material_id' : function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getMaterialWr/'+newValue).then(({ data }) => {
                        this.dataInputFG.unit = data.uom.unit;
                        this.dataInputFG.is_decimal = data.uom.is_decimal;
                        this.dataInputFG.quantity = "";

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
            },

            'editInput.material_id' : function(newValue){
                if(newValue != this.editInput.old_material_id){
                    this.editInput.quantity = "";
                }
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialWr/'+newValue).then(({ data }) => {
                        this.editInput.unit = data.uom.unit;
                        this.editInput.is_decimal = data.uom.is_decimal;

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
                    window.axios.get('/api/getQuantityReserved/'+newValue).then(({ data }) => {
                        this.availableQuantity = data;

                        this.editInput.available = data.quantity - data.reserved;
                        this.editInput.available = (this.editInput.available+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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
            },

            'editInputFG.material_id' : function(newValue){
                if(newValue != this.editInputFG.old_material_id){
                    this.editInputFG.quantity = "";
                }
                if(newValue != ""){
                    window.axios.get('/api/getMaterialWr/'+newValue).then(({ data }) => {
                        this.editInputFG.unit = data.uom.unit;
                        this.editInputFG.is_decimal = data.uom.is_decimal;
                        this.editInputFG.quantity = "";

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
            },

            'project_id' : function(newValue){
                
                this.dataInput.wbs_id = "";
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getProjectMR/'+newValue).then(({ data }) => {
                        this.selectedProject = [];
                        this.selectedProject.push(data);
                        this.selectedProject.forEach(data => {
                            var date_planned = data.planned_start_date;
                            var date_ended = data.planned_end_date;

                            data.planned_start_date = date_planned.split("-").reverse().join("-");
                            data.planned_end_date = date_ended.split("-").reverse().join("-");
                        });
                        this.wbss = data.wbss;
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
                }else{
                    this.selectedProject = [];
                }
            },
            'dataInput.quantity': function(newValue){
                var is_decimal = this.dataInput.is_decimal;
                if(is_decimal == 0){
                    this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = newValue.replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.dataInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            },
            'editInput.quantity': function(newValue){
                var is_decimal = this.editInput.is_decimal;
                if(is_decimal == 0){
                    this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = newValue.replace(/,/g, '').split('.');
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
            'dataInputFG.quantity': function(newValue){
                var is_decimal = this.dataInputFG.is_decimal;
                if(is_decimal == 0){
                    this.dataInputFG.quantity = (this.dataInputFG.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = newValue.replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.dataInputFG.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.dataInputFG.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.dataInputFG.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            },
            'editInputFG.quantity': function(newValue){
                var is_decimal = this.editInputFG.is_decimal;
                if(is_decimal == 0){
                    this.editInputFG.quantity = (this.editInputFG.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = newValue.replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.editInputFG.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.editInputFG.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.editInputFG.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            },
            'dataInput.wbs_id': function(newValue){
                this.dataInput.material_id = "";
                this.dataInput.unit = "";
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsMR/'+newValue).then(({ data }) => {
                        this.dataInput.wbs_number = data.wbs.number;
                        this.dataInput.wbs_desc = data.wbs.description;
                        this.materials = data.materials;
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
                }else{
                    this.dataInput.wbs_id = "";
                }
            },
            'editInput.wbs_id': function(newValue){
                if(this.editInput.old_wbs_id != newValue){
                    this.editInput.material_id = "";
                    this.editInput.quantity = "";
                    this.editInput.unit = "";
                    this.editInput.quantityInt = 0;
                }

                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsMR/'+newValue).then(({ data }) => {
                        this.materialsEdit = data.materials;
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
                }else{
                    this.editInput.wbs_id = "";
                }
            },
            'dataInputFG.wbs_id': function(newValue){
                this.dataInputFG.material_id = "";
                this.dataInputFG.unit = "";

                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialWIP/'+newValue).then(({ data }) => {
                        this.dataInputFG.wbs_number = data.wbs.number;
                        this.dataInputFG.wbs_desc = data.wbs.description;
                        this.materialWIP = data.materials;
                        
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
                }else{
                    this.dataInputFG.wbs_id = "";
                }
            },
            'editInputFG.wbs_id': function(newValue){
                if(this.editInputFG.old_wbs_id != newValue){
                    this.editInputFG.material_id = "";
                    this.editInputFG.quantity = "";
                    this.editInputFG.unit = "";
                    this.editInputFG.quantityInt = 0;
                }
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialWIP/'+newValue).then(({ data }) => {
                        this.materialWIPEdit = data.materials;
                        
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
                }else{
                    this.editInputFG.wbs_id = "";
                }
            },
            'required_date': function(newValue){
                this.dataMaterial.forEach(data =>{
                    if(newValue != ''){
                        data.required_date = newValue;
                    }
                });

                this.dataMaterialFG.forEach(data =>{
                    if(newValue != ''){
                        data.required_date = newValue;
                    }
                });
            }
        },
        created: function() {
            
            this.newIndex = Object.keys(this.dataMaterial).length+1;
            this.newIndexFG = Object.keys(this.dataMaterialFG).length+1;
            Vue.directive('tooltip', function(el, binding){
                $(el).tooltip({
                    title: binding.value,
                    placement: binding.arg,
                    trigger: 'hover'             
                })
            })
        },
        updated: function(){
            $('.datepicker').datepicker({
                autoclose : true,
                format: 'dd-mm-yyyy',
            });
            $("#required_date").datepicker().on(
                "changeDate", () => {
                    this.required_date = $('#required_date').val();
                }
            );
            $("#input_required_date").datepicker().on(
                "changeDate", () => {
                    this.dataInput.required_date = $('#input_required_date').val();
                }
            );
            $("#edit_required_date").datepicker().on(
                "changeDate", () => {
                    this.editInput.required_date = $('#edit_required_date').val();
                }
            );
            $("#inputFG_required_date").datepicker().on(
                "changeDate", () => {
                    this.dataInputFG.required_date = $('#inputFG_required_date').val();
                }
            );
            $("#editFG_required_date").datepicker().on(
                "changeDate", () => {
                    this.editInputFG.required_date = $('#editFG_required_date').val();
                }
            );
        }
    });
</script>
@endpush
