@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage Bill Of Material',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('bom.indexProject'),
            'Select WBS' => route('bom.selectWBS',$project->id),
            'Manage Bill Of Material' => '',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                <form id="create-bom" class="form-horizontal" method="POST" action="{{ route('bom.store') }}">
                @csrf
                    @verbatim
                    <div id="bom">
                        <div class="box-header">
                            <div class="col-sm-4">
                                <table>
                                    <thead>
                                        <th colspan="2">Project Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-r-40">Project Code</td>
                                            <td class="p-r-5">:</td>
                                            <td><b>{{project.number}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Ship Name</td>
                                            <td>:</td>
                                            <td><b>{{project.name}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Ship Type</td>
                                            <td>:</td>
                                            <td><b>{{project.ship.type}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Customer</td>
                                            <td>:</td>
                                            <td><b>{{project.customer.name}}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <table>
                                    <thead>
                                        <th colspan="2">WBS Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Code</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.code}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.name}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.description}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Deliverable</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.deliverables}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Progress</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.progress}}%</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <td rowspan="2">BOM Description</td>
                                <td rowspan="2">:</td>
                                <td rowspan="2">
                                    <textarea class="form-control" rows="3" v-model="submittedForm.description" style="width:326px"></textarea>  
                                </td>
                            </div>
                            
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-20">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Type</th>
                                        <th width="25%">Material / Service</th>
                                        <th width="30%">Description</th>
                                        <th width="15%">Quantity</th>
                                        <th width="10%" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(material, index) in dataTable">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ material.type }}</td>
                                        <td>{{ material.material_name }}</td>
                                        <td>{{ material.description }}</td>
                                        <td>{{ material.quantity }}</td>
                                        <td class="p-l-5" align="center">
                                            <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(material,index)">
                                                EDIT
                                            </a>
                                            <a href="#" @click="removeRow(material.material_id)" class="btn btn-danger btn-xs">
                                                <div class="btn-group">DELETE</div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td class="no-padding">
                                            <selectize id="type" v-model="input.type" :settings="typeSettings">
                                                <option v-for="(type, index) in types" :value="type">{{ type }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding" v-if="input.type == ''">
                                            <input class="form-control" type="text" disabled placeholder="Please select type first">  
                                        </td>
                                        <td class="no-padding" v-else-if="input.type == 'Material'">
                                            <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding" v-else-if="input.type == 'Service'">
                                            <selectize id="service" v-model="input.material_id" :settings="serviceSettings">
                                                <option v-for="(service, index) in services" :value="service.id">{{ service.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control" type="text" :value="input.description" disabled></td>
                                        <td class="no-padding"><input class="form-control" type="text" v-model="input.quantity"></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
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
                                                    <option v-for="(material, index) in materials_modal" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
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
    const form = document.querySelector('form#create-bom');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        submit: "ok",
        types : ['Material','Service'],
        project : @json($project),
        materials : @json($materials),
        services : @json($services),
        wbs : @json($wbs),
        newIndex : 0, 
        submittedForm :{
            project_id : "",
            wbs_id : "",
            description : ""
        },
        input : {
            material_id : "",
            service_id : "",
            material_name : "",
            material_code : "",
            description : "",
            quantity : "",
            quantityInt : 0,
            type : "",
        },
        editInput : {
            old_material_id : "",
            service_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
        },
        dataTable : [],
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        serviceSettings: {
            placeholder: 'Please Select Service'
        },
        typeSettings: {
            placeholder: 'Please Select Type'
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
    }

    var vm = new Vue({
        el : '#bom',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                var string_newValue = this.input.quantityInt+"";
                this.input.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.input.material_id == "" || this.input.material_name == "" || this.input.description == "" || this.input.quantity == "" || this.input.quantityInt < 1){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.dataTable.length < 1 || this.submit == ""){
                    isOk = true;
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityInt+"";
                this.editInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.editInput.material_id == "" || this.editInput.quantityInt < 1 || this.editInput.quantityInt == "" || isNaN(this.editInput.quantityInt)){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
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
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_name = data.wbs_name;
                this.editInput.index = index;

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
            },
            submitForm(){
                this.submit = "";
                this.submittedForm.materials = this.dataTable;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            submitToTable(){
                if(this.input.material_id != "" && this.input.material_name != "" && this.input.description != "" && this.input.quantity != "" && this.input.quantityInt > 0){
                    var data = JSON.stringify(this.input);
                    data = JSON.parse(data);
                    this.dataTable.push(data);

                    this.material_id.push(data.material_id); //ini buat nambahin material_id terpilih

                    var jsonMaterialId = JSON.stringify(this.material_id);
                    this.getNewMaterials(jsonMaterialId);             

                    this.newIndex = this.dataTable.length + 1;  

                    this.input.description = "";
                    this.input.type = "";
                    this.input.material_id = "";
                    this.input.material_name = "";
                    this.input.quantity = "";
                    this.input.quantityInt = 0;
                }
            },
            removeRow: function(materialId) {
                var index_materialId = "";
                var index_dataTable = "";

                this.material_id.forEach(id => {
                    if(id == materialId){
                        index_materialId = this.material_id.indexOf(id);
                    }
                });
                this.dataTable.forEach(data => {
                    if(data.material_id == materialId){
                        index_dataTable = this.dataTable.indexOf(data.material_id);
                    }
                });

                this.dataTable.splice(index_dataTable, 1);
                this.material_id.splice(index_materialId, 1);
                this.newIndex = this.dataTable.length + 1;

                var jsonMaterialId = JSON.stringify(this.material_id);
                this.getNewMaterials(jsonMaterialId);
            },
            update(old_material_id, new_material_id){
                this.dataTable.forEach(material => {
                    if(material.material_id == old_material_id){
                        var material = this.dataTable[this.editInput.index];
                        material.quantityInt = this.editInput.quantityInt;
                        material.quantity = this.editInput.quantity;
                        material.material_id = new_material_id;
                        material.wbs_id = this.editInput.wbs_id;

                        window.axios.get('/api/getMaterialBOM/'+new_material_id).then(({ data }) => {
                            material.material_name = data.name;
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
        },
        watch: {
            'input.material_id': function(newValue){
                if(newValue != ""){
                    if(this.input.type == "Material"){
                        window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                            if(data.description == "" || data.description == null){
                                this.input.description = '-';
                            }else{
                                this.input.description = data.description;

                            }
                            this.input.material_name = data.name;
                            this.input.material_code = data.code;
                        });
                    }else if(this.input.type == "Service"){
                        window.axios.get('/api/getServiceBOM/'+newValue).then(({ data }) => {
                            if(data.description == "" || data.description == null){
                                this.input.description = '-';
                            }else{
                                this.input.description = data.description;

                            }
                            this.input.material_name = data.name;
                            this.input.material_code = data.code;
                        });
                    }
                }
            },
            'input.quantity': function(newValue){
                this.input.quantityInt = newValue;
                this.input.quantity = (this.input.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'input.type' : function(newValue){
                this.input.material_id = "";
                this.input.material_name = "";
                this.input.description = "";
            }
        },
        created: function() {
            this.submittedForm.project_id = this.project.id;
            this.submittedForm.wbs_id = this.wbs.id;          

            this.newIndex = this.dataTable.length + 1;
        }
    });
       
</script>
@endpush
