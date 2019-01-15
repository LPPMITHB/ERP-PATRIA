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
                                <label for="" >PR Type</label>
                                <selectize v-model="pr_type" :settings="typeSettings" :disabled="dataOk">
                                    <option v-for="(type, index) in types" :value="type">{{ type }}</option>
                                </selectize>  
                                <label for="" >Project Name</label>
                                <selectize v-model="project_id" :settings="projectSettings" :disabled="dataOk">
                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.name }}</option>
                                </selectize>  
                            </div>
                            <div class="col-xs-12 col-md-4 p-r-0">
                                    <div class="col-sm-12 p-l-0">
                                        <label for="">PR Description</label>
                                    </div>
                                    <div class="col-sm-12 p-l-0">
                                        <textarea class="form-control" rows="4" v-model="description"></textarea>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table class="table table-bordered tableFixed" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th v-if="pr_type == 'Material'" style="width: 30%">Material Name</th>
                                            <th v-else-if="pr_type == 'Resource'" style="width: 30%">Resource Name</th>
                                            <th style="width: 15%">Quantity</th>
                                            <th style="width: 25%">WBS Name</th>
                                            <th style="width: 15%">Alocation</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td v-if="material.material_code != ''" class="tdEllipsis">{{ material.material_code }} - {{ material.material_name }}</td>
                                            <td v-else-if="material.resource_code != ''" class="tdEllipsis">{{ material.resource_code }} - {{ material.resource_name }}</td>
                                            <td v-if="material.quantity != ''" class="tdEllipsis">{{ material.quantity }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td class="tdEllipsis" v-if="material.work_name != ''">{{ material.work_name }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td v-if="material.alocation != ''"class="tdEllipsis">{{ material.alocation }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td class="p-l-0 textCenter">
                                                <a v-if="pr_type == 'Material'" class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(material,index)">
                                                    EDIT
                                                </a>
                                                <a v-else-if="pr_type == 'Resource'" class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_resource" @click="openEditModal(material,index)">
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
                                            <td v-show="pr_type == 'Material'" class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                                </selectize>
                                            </td>
                                            <td v-show="pr_type == 'Resource'" class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="project_id != ''">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="project_id == ''">
                                                <selectize v-model="dataInput.wbs_id" :settings="nullSettings" disabled>
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
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
                                                <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12" v-show="project_id != ''"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="project_id == ''"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="nullSettings" disabled>
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="alocation" class="control-label">Alocation</label>
                                                <selectize v-model="editInput.alocation" :settings="alocationSettings">
                                                    <option value="Consumption">Consumption</option>
                                                    <option value="Stock">Stock</option>
                                                </selectize>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
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
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12" v-show="project_id != ''"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="project_id == ''"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="nullSettings" disabled>
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.resource_id)">SAVE</button>
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
        types : ['Material','Resource'],
        pr_type : "Material",
        submit: "ok",
        resource : "",
        description : "",
        newIndex : "",
        materials : @json($modelMaterial),
        resources : @json($modelResource),
        projects : @json($modelProject),
        works : [],
        project_id : "",
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        wbsSettings: {
            placeholder: 'Please Select WBS'
        },
        nullSettings:{
            placeholder: '-'
        },
        alocationSettings: {
            placeholder: 'Please Select Alocation'
        },
        typeSettings: {
            placeholder: 'Please Select Type'
        },
        selectedProject : [],
        dataMaterial : [],
        dataInput : {
            material_id :"",
            resource_id :"",
            material_code : "",
            material_name : "",
            resource_code : "",
            resource_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            work_name : "",
            alocation : "Stock"
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            resource_id :"",
            material_code : "",
            material_name : "",
            resource_code : "",
            resource_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            work_name : "",
            alocation : ""
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        submittedForm : {}
    }

    var vm = new Vue({
        el : '#pr',
        data : data,
        computed : {
            resourceOk: function(){
                let isOk = false;
                
                if(this.resource == "ok"){
                    isOk = true;
                    this.dataInput.alocation = "";
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
                
                if(this.dataMaterial.length < 1 || this.submit == ""){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;
                if(this.pr_type == 'Material'){
                    var string_newValue = this.dataInput.quantityInt+"";
                    this.dataInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                    if(this.dataInput.material_id == "" || this.dataInput.quantityInt < 1 || this.dataInput.quantityInt == "" || isNaN(this.dataInput.quantityInt)){
                        isOk = true;
                    }
                }else if(this.pr_type == 'Resource'){
                    if(this.dataInput.resource_id == ""){
                        isOk = true;
                    }
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;
                if(this.pr_type == 'Material'){
                    var string_newValue = this.editInput.quantityInt+"";
                    this.editInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                    if(this.editInput.material_id == "" || this.editInput.quantityInt < 1 || this.editInput.quantityInt == "" || isNaN(this.editInput.quantityInt)){
                        isOk = true;
                    }
                }else if(this.pr_type == 'Resource'){
                    if(this.editInput.resource_id == ""){
                        isOk = true;
                    }
                }

                return isOk;
            }
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
                this.submittedForm.resource = this.resource;
                this.submittedForm.description = this.description;
                this.submittedForm.project_id = this.project_id;     
                this.submittedForm.materials = this.dataMaterial;    

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            update(old_material_id, new_material_id){
                // this.dataMaterial.forEach(material => {
                    // if(material.material_id == old_material_id){
                        if(this.pr_type == 'Material'){
                            var material = this.dataMaterial[this.editInput.index];
                       
                            window.axios.get('/api/getMaterialPR/'+new_material_id).then(({ data }) => {
                                // console.log(data);
                                material.material_name = data.name;
                                material.material_code = data.code;

                                // this.material_id.forEach(id => {
                                //     if(id == old_material_id){
                                //         var index = this.material_id.indexOf(id);
                                //         this.material_id.splice(index, 1);
                                //     }
                                // });
                                // this.material_id.push(new_material_id);

                                // var jsonMaterialId = JSON.stringify(this.material_id);
                                // this.getNewMaterials(jsonMaterialId);
                                if(this.editInput.wbs_id != ''){
                                    window.axios.get('/api/getWbsPR/'+this.editInput.wbs_id).then(({ data }) => {
                                        material.work_name = data.name;
                                        material.quantityInt = this.editInput.quantityInt;
                                        material.quantity = this.editInput.quantity;
                                        material.material_id = new_material_id;
                                        material.wbs_id = this.editInput.wbs_id;
                                        material.alocation = this.editInput.alocation;

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
                                    material.alocation = this.editInput.alocation;
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
                        }else if(this.pr_type == 'Resource'){
                            var material = this.dataMaterial[this.editInput.index];
                            
                            window.axios.get('/api/getResourcePR/'+new_material_id).then(({ data }) => {
                                material.resource_name = data.name;
                                material.resource_code = data.code;
                                material.quantityInt = this.editInput.quantityInt;
                                material.quantity = this.editInput.quantity;

                                // this.material_id.forEach(id => {
                                //     if(id == old_material_id){
                                //         var index = this.material_id.indexOf(id);
                                //         this.material_id.splice(index, 1);
                                //     }
                                // });
                                // this.material_id.push(new_material_id);

                                // var jsonMaterialId = JSON.stringify(this.material_id);
                                // this.getNewMaterials(jsonMaterialId);
                                if(this.editInput.wbs_id != ''){
                                    window.axios.get('/api/getWbsPR/'+this.editInput.wbs_id).then(({ data }) => {
                                        material.work_name = data.name;
                                        material.resource_id = new_material_id;
                                        material.wbs_id = this.editInput.wbs_id;

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
                //     }
                // });
            },
            // getNewModalMaterials(jsonMaterialId){
            //     window.axios.get('/api/getMaterials/'+jsonMaterialId).then(({ data }) => {
            //         this.materials_modal = data;
            //         $('div.overlay').hide();
            //     })
            //     .catch((error) => {
            //         iziToast.warning({
            //             title: 'Please Try Again..',
            //             position: 'topRight',
            //             displayMode: 'replace'
            //         });
            //         $('div.overlay').hide();
            //     })
            // },
            openEditModal(data,index){
                this.editInput.material_id = data.material_id;
                this.editInput.resource_id = data.resource_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.resource_code = data.resource_code;
                this.editInput.material_name = data.material_name;
                this.editInput.resource_name = data.resource_name;
                this.editInput.quantity = data.quantity;
                this.editInput.quantityInt = data.quantityInt;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.work_name = data.work_name;
                this.editInput.alocation = data.alocation;
                this.editInput.index = index;

                var material_id = JSON.stringify(this.material_id);
                material_id = JSON.parse(material_id);
                
                // this.material_id_modal = material_id;
                this.material_id_modal.forEach(id => {
                    if(id == data.material_id){
                        var index = this.material_id_modal.indexOf(id);
                        // this.material_id_modal.splice(index, 1);
                    }
                });
                // var jsonMaterialId = JSON.stringify(this.material_id_modal);
                // this.getNewModalMaterials(jsonMaterialId);
            },
            // getNewMaterials(jsonMaterialId){
            //     window.axios.get('/api/getMaterials/'+jsonMaterialId).then(({ data }) => {
            //         this.materials = data;
            //         $('div.overlay').hide();
            //     })
            //     .catch((error) => {
            //         iziToast.warning({
            //             title: 'Please Try Again..',
            //             position: 'topRight',
            //             displayMode: 'replace'
            //         });
            //         $('div.overlay').hide();
            //     })
            // },
            add(){
                if(this.dataInput.material_id != ""){
                    var material_id = this.dataInput.material_id;
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialPR/'+material_id).then(({ data }) => {
                        this.dataInput.material_name = data.name;
                        this.dataInput.material_code = data.code;

                        var temp_data = JSON.stringify(this.dataInput);
                        temp_data = JSON.parse(temp_data);

                        this.dataMaterial.push(temp_data);
                        // this.material_id.push(temp_data.material_id);

                        this.dataInput.material_name = "";
                        this.dataInput.material_code = "";
                        this.dataInput.quantity = "";
                        this.dataInput.material_id = "";
                        this.dataInput.wbs_id = "";
                        this.dataInput.work_name = "";
                        this.dataInput.alocation = "Stock";
                        
                        this.newIndex = Object.keys(this.dataMaterial).length+1;

                        // var jsonMaterialId = JSON.stringify(this.material_id);

                        // this.getNewMaterials(jsonMaterialId);
                        
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
                }else if(this.dataInput.resource_id != ""){
                    var resource_id = this.dataInput.resource_id;
                    $('div.overlay').show();
                    window.axios.get('/api/getResourcePR/'+resource_id).then(({ data }) => {
                        this.dataInput.resource_name = data.name;
                        this.dataInput.resource_code = data.code;

                        var temp_data = JSON.stringify(this.dataInput);
                        temp_data = JSON.parse(temp_data);

                        this.dataMaterial.push(temp_data);

                        this.dataInput.resource_name = "";
                        this.dataInput.resource_code = "";
                        this.dataInput.quantity = "";
                        this.dataInput.resource_id = "";
                        this.dataInput.wbs_id = "";
                        this.dataInput.work_name = "";
                        
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
                }
            },
            removeRow(index){
                this.dataMaterial.splice(index, 1);
                // this.material_id.splice(index, 1);

                // var jsonMaterialId = JSON.stringify(this.material_id);
                // this.getNewMaterials(jsonMaterialId);
                
                this.newIndex = this.dataMaterial.length + 1;
            }
        },
        watch : {
            'project_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getProjectPR/'+newValue).then(({ data }) => {
                        this.selectedProject = [];
                        this.selectedProject.push(data);

                        this.works = data.wbss;
                        
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

                function myFunction(x) {
                    if (x.matches) { // If media query matches
                        $('.table').wrap('<div class="dataTables_scroll" />');
                    } 
                }

                var x = window.matchMedia("(max-width: 500px)")
                myFunction(x) // Call listener function at run time
                x.addListener(myFunction) // Attach listener function on state changes

                var x = window.matchMedia("(max-width: 1024px)")
                myFunction(x) // Call listener function at run time
                x.addListener(myFunction) // Attach listener function on state changes
            },
            'dataInput.quantity': function(newValue){
                this.dataInput.quantityInt = newValue;
                var string_newValue = newValue+"";
                quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                this.dataInput.quantity = quantity_string;
            },
            'editInput.quantity': function(newValue){
                this.editInput.quantityInt = newValue;
                var string_newValue = newValue+"";
                quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                Vue.nextTick(() => this.editInput.quantity = quantity_string);
            },
            'dataInput.wbs_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsPR/'+newValue).then(({ data }) => {
                        this.dataInput.work_name = data.name;
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
            pr_type : function(newValue){
                if(newValue == 'Material'){
                    this.resource = "";
                }else if(newValue == 'Resource'){
                    this.resource = "ok";
                }
            }
        },
        created: function() {
            this.newIndex = Object.keys(this.dataMaterial).length+1;
            Vue.directive('tooltip', function(el, binding){
                $(el).tooltip({
                    title: binding.value,
                    placement: binding.arg,
                    trigger: 'hover'             
                })
            })
        },
    });
</script>
@endpush
