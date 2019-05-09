@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Purchase Requisition',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Create Purchase Requisition' => route('purchase_requisition.create'),
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
                @if($route == "/purchase_requisition")
                    <form id="create-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition.store') }}">
                @elseif($route == "/purchase_requisition_repair")
                    <form id="create-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition_repair.store') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="pr">
                        <div class="box-header no-padding">
                            <div class="col-xs-12 col-md-4 p-l-0">
                                <label for="" >PR Type</label>
                                <selectize v-model="pr_type" :settings="typeSettings" :disabled="dataOk">
                                    <option v-for="(type, index) in types" :value="type">{{ type }}</option>
                                </selectize>  
                            </div>
                            <div class="col-xs-12 col-md-4" v-if="pr_type != 'Subcon'">
                                <label for="">Default Required Date</label>
                                <div class="col-sm-12 p-l-0">
                                    <input v-model="required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="required_date" id="required_date" placeholder="Set Default Required Date">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 p-r-0 p-l-0">
                                <div class="col-sm-12 p-r-0">
                                    <label for="">PR Description</label>
                                </div>
                                <div class="col-sm-12 p-r-0">
                                    <textarea class="form-control" rows="2" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table class="table table-bordered tableFixed m-b-0" v-show="pr_type != 'Subcon'">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th v-if="pr_type == 'Material'" style="width: 22%">Material Number</th>
                                            <th v-else-if="pr_type == 'Resource'" style="width: 22%">Resource Number</th>
                                            <th v-if="pr_type == 'Material'" style="width: 25%">Material Description</th>
                                            <th v-else-if="pr_type == 'Resource'" style="width: 25%">Resource Description</th>
                                            <th style="width: 12%">Quantity</th>
                                            <th style="width: 8%">Unit</th>
                                            <th style="width: 15%">Project Number</th>
                                            <th style="width: 13%">Required Date</th>
                                            <th style="width: 15%">Allocation</th>
                                            <th style="width: 13%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <template v-if="data.material_code != ''">
                                                <td class="tdEllipsis">{{ data.material_code }}</td>
                                                <td class="tdEllipsis">{{ data.material_name }}</td>
                                            </template>
                                            <template v-else-if="data.resource_code != ''">
                                                <td class="tdEllipsis">{{ data.resource_code }}</td>
                                                <td class="tdEllipsis">{{ data.resource_name }}</td>
                                            </template>
                                            <td class="tdEllipsis">{{ data.quantity }}</td>
                                            <td class="tdEllipsis">{{ data.unit }}</td>
                                            <td class="tdEllipsis">{{ data.project_number }}</td>
                                            <td class="tdEllipsis">{{ data.required_date }}</td>
                                            <td class="tdEllipsis">{{ data.alocation }}</td>
                                            <td class="p-l-0 textCenter">
                                                <a v-if="pr_type == 'Material'" class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(data,index)">
                                                    EDIT
                                                </a>
                                                <a v-else-if="pr_type == 'Resource'" class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_resource" @click="openEditModal(data,index)">
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
                                            <td v-show="pr_type == 'Material'" class="p-l-0 textLeft" colspan="2">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings" class="selectizeFull">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </td>
                                            <td v-show="pr_type == 'Resource'" class="p-l-0 textLeft" colspan="2">
                                                <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity" :disabled="materialOk">
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.unit" disabled>
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.project_id" :settings="projectSettings">
                                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }}</option>
                                                </selectize>  
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <input v-model="dataInput.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="input_required_date" id="input_required_date" placeholder="Required Date">  
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.alocation" :settings="alocationSettings" :disabled="resourceOk">
                                                    <option value="Consumption">Consumption</option>
                                                    <option value="Stock">Stock</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0  textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <table class="table table-bordered tableFixed m-b-0" v-show="pr_type == 'Subcon'">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">Project Number</th>
                                            <th style="width: 20%">WBS</th>
                                            <th style="width: 35%">Job Order</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis">{{ data.project_number }}</td>
                                            <td class="tdEllipsis">{{ data.wbs_number }} - {{ data.wbs_description }}</td>
                                            <td class="tdEllipsis">{{ data.service }} - {{ data.service_detail }}</td>
                                            <td class="p-l-0 textCenter">
                                                <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-l-10">{{newIndex}}</td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="subConInput.project_id" :settings="projectSettings">
                                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }}</option>
                                                </selectize>  
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="subConInput.wbs_id" :settings="wbsSettings" >
                                                    <option v-for="(wbs, index) in modelWBS" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                                </selectize>  
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="subConInput.activity_id" :settings="jobOrderSettings" >
                                                    <input v-model="subConInput.job_order" type="text" class="form-control"/>
                                                </selectize>  
                                            </td>
                                            <td class="p-l-0  textCenter"> 
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12 p-r-0 p-t-10">
                            <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">CREATE</button>
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
                                                <label for="type" class="control-label">Material</label>
                                                <selectize v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity" :disabled="editMaterialOk">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" id="unit" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Project Number</label>
                                                <selectize v-model="editInput.project_id" :settings="projectSettings">
                                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }}</option>
                                                </selectize> 
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Required Date</label>
                                                <input v-model="editInput.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="edit_required_date" id="edit_required_date" placeholder="Required Date">  
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="alocation" class="control-label">Allocation</label>
                                                <selectize v-model="editInput.alocation" :settings="alocationSettings">
                                                    <option value="Consumption">Consumption</option>
                                                    <option value="Stock">Stock</option>
                                                </selectize>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.material_id)">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="edit_resource">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Resource</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Resource</label>
                                                <selectize id="edit_modal" v-model="editInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity" :disabled="editMaterialOk">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Project Number</label>
                                                <selectize v-model="editInput.project_id" :settings="projectSettings">
                                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }}</option>
                                                </selectize> 
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Required Date</label>
                                                <input v-model="editInput.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="edit_required_date" id="edit_required_date" placeholder="Required Date">  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.resource_id)">SAVE</button>
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
    const form = document.querySelector('form#create-pr');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        types : ['Material','Resource','Subcon'],
        pr_type : "Material",
        isResource : "",
        description : "",
        required_date : "",
        newIndex : "",
        materials : @json($modelMaterial),
        resources : @json($modelResource),
        projects : @json($modelProject),
        modelWBS : [],
        modelActivity : [],
        subConInput : {
            project_id : "",
            project_number : "",
            wbs_id : "",
            wbs_number : "",
            wbs_description : "",
            job_order : "",
        },
        dataInput : {
            material_id :"",
            material_code : "",
            material_name : "",
            resource_id :"",
            resource_code : "",
            resource_name : "",
            quantity : "",
            unit : "",
            project_id : "",
            project_number : "-",
            required_date : "",
            alocation : "Stock",
            is_decimal : "",
            material_ok : ""
        },
        editInput : {
            material_id : "",
            old_material_id : "",
            material_code : "",
            material_name : "",
            resource_id :"",
            resource_code : "",
            resource_name : "",
            quantity : "",
            unit : "",
            project_id : "",
            project_number : "",
            required_date : "",
            alocation : "",
            is_decimal : "",
            material_ok : ""
        },
        dataMaterial : [],
        submittedForm : {},
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        wbsSettings: {
            placeholder: 'Please Select WBS'
        },
        materialSettings: {
            placeholder: 'Please Select Material',
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        nullSettings:{
            placeholder: '-'
        },
        alocationSettings: {
            placeholder: 'Please Select Allocation'
        },
        typeSettings: {
            placeholder: 'Please Select Type'
        },
        jobOrderSettings: {
            placeholder: 'Please Select Job Order'
        },
        activity_ids: [],
    }

    var vm = new Vue({
        el : '#pr',
        data : data,
        mounted(){
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
        },
        computed : {
            resourceOk: function(){
                let isOk = false;
                
                if(this.isResource == "ok"){
                    isOk = true;
                }

                return isOk;
            },
            dataOk: function(){
                let isOk = false;
                
                if(this.dataMaterial.length > 0){
                    isOk = true;
                }

                return isOk;
            },
            allOk: function(){
                let isOk = false;
                
                if(this.dataMaterial.length < 1){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.pr_type == 'Material'){
                    if(this.dataInput.material_id == "" || this.dataInput.quantity == "" || this.dataInput.alocation == ""){
                        isOk = true;
                    }
                }else if(this.pr_type == 'Resource'){
                    if(this.dataInput.resource_id == "" || this.dataInput.quantity == ""){
                        isOk = true;
                    }
                }else if(this.pr_type == 'Subcon'){
                    if(this.subConInput.project_id == "" || this.subConInput.wbs_id == "" || this.subConInput.activity_id == ""){
                        isOk = true;
                    }
                }

                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.pr_type == 'Material'){
                    if(this.editInput.material_id == "" || this.editInput.quantity == "" || this.editInput.alocation == ""){
                        isOk = true;
                    }
                }else if(this.pr_type == 'Resource'){
                    if(this.editInput.resource_id == "" || this.editInput.quantity == ""){
                        isOk = true;
                    }
                }
                return isOk;
            },
            materialOk : function(){
                let isOk = false;

                if(this.dataInput.material_ok == ""){
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
            }
        },
        methods : {
            clearData(){
                this.dataInput.material_id = "";
                this.dataInput.material_code = "";
                this.dataInput.material_name = "";
                this.dataInput.resource_id = "";
                this.dataInput.resource_code = "";
                this.dataInput.resource_name = "";
                this.dataInput.quantity = "";
                this.dataInput.unit = "";
                this.dataInput.project_id = "";
                this.dataInput.project_number = "-";
                this.dataInput.required_date = "";
                if(this.dataInput.pr_type == "Material"){
                    this.dataInput.alocation = "Stock";
                }

                this.subConInput.project_id = "";
                this.subConInput.project_number = "";
                this.subConInput.wbs_id = "";
                this.subConInput.wbs_number = "";
                this.subConInput.wbs_description = "";
                this.subConInput.job_order = "";

                this.newIndex = Object.keys(this.dataMaterial).length+1;
            },
            submitForm(){
                $('div.overlay').show();
                this.dataMaterial.forEach(data => {
                    data.quantity = (data.quantity+"").replace(/,/g , '');
                })

                this.submittedForm.pr_type = this.pr_type;
                this.submittedForm.description = this.description;
                this.submittedForm.datas = this.dataMaterial;    
                
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            openEditModal(data,index){
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.resource_id = data.resource_id;
                this.editInput.resource_code = data.resource_code;
                this.editInput.resource_name = data.resource_name;
                this.editInput.quantity = data.quantity;
                this.editInput.unit = data.unit;
                this.editInput.project_id = data.project_id;
                this.editInput.project_number = data.project_number;
                this.editInput.required_date = data.required_date;
                this.editInput.alocation = data.alocation;
                this.editInput.index = index;
                this.editInput.is_decimal = data.is_decimal;
            },
            update(){
                $('div.overlay').show();
                var data = this.dataMaterial[this.editInput.index];

                data.material_id = this.editInput.material_id;
                data.material_name = this.editInput.material_name;
                data.material_code = this.editInput.material_code;
                data.resource_id = this.editInput.resource_id;
                data.resource_code = this.editInput.resource_code;
                data.resource_name = this.editInput.resource_name;
                data.quantity = this.editInput.quantity 
                data.unit = this.editInput.unit 
                data.project_id = this.editInput.project_id 
                data.project_number = this.editInput.project_number 
                data.required_date = this.editInput.required_date 
                data.alocation = this.editInput.alocation 
                
                iziToast.success({
                    title: this.pr_type+' Updated !',
                    position: 'topRight',
                    displayMode: 'replace'
                });

                $('div.overlay').hide();
            },
            add(){
                $('div.overlay').show();
                if(this.pr_type == 'Subcon'){
                    var data = JSON.stringify(this.subConInput);
                }else{
                    var data = JSON.stringify(this.dataInput);
                }
                data = JSON.parse(data);

                this.dataMaterial.push(data);
                this.clearData();
                $('div.overlay').hide();
            },
            removeRow(index){
                this.activity_ids.forEach(id =>{
                    if(this.dataMaterial[index].activity_id == id){
                        let index_id =  this.activity_ids.indexOf(id);
                        this.activity_ids.splice(index_id,1);
                    }
                })

                this.dataMaterial.splice(index, 1);
                this.clearData();
            }
        },
        watch : {
            'dataInput.quantity': function(newValue){
                if(this.pr_type == "Material"){
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
                }else{
                    this.dataInput.quantity = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'editInput.quantity': function(newValue){
                if(this.pr_type == "Material"){
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
                }else{
                    this.editInput.quantity = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'pr_type' : function(newValue){
                this.clearData();
                if(newValue == 'Material'){
                    this.isResource = "";
                }else if(newValue == 'Resource'){
                    this.isResource = "ok";
                    this.dataInput.alocation = "";
                }else if(newValue == 'Subcon'){
                    this.isResource = "";
                }else if(newValue == ''){
                    // HAHAHA THIS IS TRAP
                    location.reload();
                }
            },
            'required_date': function(newValue){
                this.dataMaterial.forEach(data =>{
                    if(newValue != ''){
                        data.required_date = newValue;
                    }
                })
            },
            'dataInput.material_id': function(newValue){
                this.dataInput.quantity = "";
                if(newValue != ""){
                    this.dataInput.material_ok = "ok";
                    window.axios.get('/api/getMaterialPR/'+newValue).then(({ data }) => {
                        this.dataInput.material_name = data.description;
                        this.dataInput.material_code = data.code;
                        this.dataInput.unit = data.uom.unit;
                        this.dataInput.is_decimal = data.uom.is_decimal;

                    });
                }else{
                    this.dataInput.material_name = "";
                    this.dataInput.material_code = "";
                    this.dataInput.unit = "";
                    this.dataInput.is_decimal = "";
                    this.dataInput.material_ok = "";
                }
            },
            'dataInput.resource_id': function(newValue){
                if(newValue != ""){
                    this.dataInput.material_ok = "ok";
                    window.axios.get('/api/getResourcePR/'+newValue).then(({ data }) => {
                        this.dataInput.resource_name = data.name;
                        this.dataInput.resource_code = data.code;
                        this.dataInput.unit = "-";
                    });
                }else{
                    this.dataInput.resource_name = "";
                    this.dataInput.resource_code = "";
                    this.dataInput.unit = "";
                    this.dataInput.material_ok = "";
                }
            },
            'dataInput.project_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getProjectPR/'+newValue).then(({ data }) => {
                        this.dataInput.project_number = data.number;
                    });
                }else{
                    this.dataInput.project_number = "-";
                }
            },
            'editInput.material_id': function(newValue){
                if(newValue != this.editInput.old_material_id){
                    this.editInput.quantity = "";
                }
                if(newValue != ""){
                    this.editInput.material_ok = "ok";
                    window.axios.get('/api/getMaterialPR/'+newValue).then(({ data }) => {
                        this.editInput.material_name = data.description;
                        this.editInput.material_code = data.code;
                        this.editInput.unit = data.uom.unit;
                        this.editInput.is_decimal = data.uom.is_decimal;
                    });
                }else{
                    this.editInput.material_name = "";
                    this.editInput.material_code = "";
                    this.editInput.unit = "";
                    this.editInput.material_ok = "";
                    this.editInput.is_decimal = "";
                }
            },
            'editInput.resource_id': function(newValue){
                if(newValue != ""){
                    this.editInput.material_ok = "ok";
                    window.axios.get('/api/getResourcePR/'+newValue).then(({ data }) => {
                        this.editInput.resource_name = data.name;
                        this.editInput.resource_code = data.code;
                        this.editInput.unit = "-";
                        this.editInput.is_decimal = 0;
                    });
                }else{
                    this.editInput.resource_name = "";
                    this.editInput.resource_code = "";
                    this.editInput.unit = "";
                    this.editInput.material_ok = "";
                    this.editInput.is_decimal = "";
                }
            },
            'editInput.project_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getProjectPR/'+newValue).then(({ data }) => {
                        this.editInput.project_number = data.number;
                        $('div.overlay').hide();
                    });
                }else{
                    this.editInput.project_number = "-";
                }
            },
            'subConInput.project_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getModelWbsPR/'+newValue).then(({ data }) => {
                        this.modelWBS = data;
                        $('div.overlay').hide();
                    });
                }else{
                    this.modelWBS = [];
                    this.subConInput.project_id = "";
                    this.subConInput.project_number = "";
                    this.subConInput.wbs_id = "";
                    this.subConInput.wbs_number = "";
                    this.subConInput.wbs_description = "";
                    this.subConInput.job_order = "";
                }
            },
            'subConInput.wbs_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    let activity_ids = JSON.stringify(this.activity_ids);

                    window.axios.get('/api/getModelActivityPR/'+newValue+"/"+activity_ids).then(({ data }) => {
                        this.modelActivity = data;

                        this.modelWBS.forEach(wbs =>{
                            if(wbs.id == newValue){
                                this.subConInput.wbs_number = wbs.number;
                                this.subConInput.wbs_description = wbs.description;
                                this.subConInput.project_number = wbs.project.number;
                            }
                        })
                        $('div.overlay').hide();
                    });
                }else{
                    this.modelActivity = [];
                    this.subConInput.wbs_id = "";
                    this.subConInput.wbs_number = "";
                    this.subConInput.wbs_description = "";
                    this.subConInput.job_order = "";
                }
            },
        },
        created: function() {
            this.clearData();
        },
    });
</script>
@endpush
