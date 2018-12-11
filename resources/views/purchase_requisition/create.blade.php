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
                <form id="create-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition.store') }}">
                @csrf
                    @verbatim
                    <div id="pr">
                        <div class="row">
                            <template v-if="selectedProject.length > 0">
                                <div class="col-sm-4">
                                    <div class="col-sm-4">
                                        Project Code
                                    </div>
                                    <div class="col-sm-8">
                                        : <b>{{ selectedProject[0].code }}</b>
                                    </div>
                                    <div class="col-sm-4">
                                        Ship
                                    </div>
                                    <div class="col-sm-8">
                                        : <b>{{ selectedProject[0].ship.name }}</b>
                                    </div>
                                    <div class="col-sm-4">
                                        Customer
                                    </div>
                                    <div class="col-sm-8 tdEllipsis"  data-container="body" v-tooltip:top="tooltipText(selectedProject[0].customer.name)">
                                        : <b>{{ selectedProject[0].customer.name }}</b>
                                    </div>
                                    <div class="col-sm-4">
                                        Start Date
                                    </div>
                                    <div class="col-sm-8">
                                        : <b>{{ selectedProject[0].planned_start_date }}</b>
                                    </div>
                                    <div class="col-sm-4">
                                        End Date
                                    </div>
                                    <div class="col-sm-8">
                                        : <b>{{ selectedProject[0].planned_end_date }}</b>
                                    </div>
                                </div>
                            </template>
                            <div class="col-sm-4 p-l-20">
                                <label for="" >Project Name</label>
                                <selectize id="material" v-model="project_id" :settings="projectSettings" :disabled="dataOk">
                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.name }}</option>
                                </selectize>  
                            </div>
                            <template v-if="selectedProject.length > 0">
                                <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <label for="">PR Description</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="3" v-model="description"></textarea>
                                        </div>
                                </div>
                            </template>
                        </div>
                        <div class="row">
                            <template v-if="selectedProject.length > 0">
                                <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                    <table class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 35%">Material Name</th>
                                                <th style="width: 20%">Quantity</th>
                                                <th style="width: 30%">Work Name</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(material,index) in dataMaterial">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ material.material_code }} - {{ material.material_name }}</td>
                                                <td class="tdEllipsis">{{ material.quantity }}</td>
                                                <td class="tdEllipsis">{{ material.work_name }}</td>
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
                                                <td class="p-l-0 textLeft">
                                                    <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                        <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                                    </selectize>
                                                </td>
                                                <td class="p-l-0">
                                                    <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="p-l-0 textLeft">
                                                    <selectize v-model="dataInput.wbs_id" :settings="workSettings">
                                                        <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                    </selectize>
                                                </td>
                                                <td class="p-l-0 textCenter">
                                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </template>
                        </div>
                        <template v-if="selectedProject.length > 0">
                            <div class="col-md-12">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">CREATE</button>
                            </div>
                        </template>
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
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Work Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="workSettings">
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
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
        description : "",
        newIndex : "",
        materials : @json($modelMaterial),
        projects : @json($modelProject),
        works : [],
        project_id : "",
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        workSettings: {
            placeholder: 'Please Select Work'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        
        selectedProject : [],
        dataMaterial : [],
        dataInput : {
            material_id :"",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            work_name : ""
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            work_name : ""
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

                var string_newValue = this.dataInput.quantityInt+"";
                this.dataInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.dataInput.material_id == "" || this.dataInput.quantityInt < 1 || this.dataInput.quantityInt == "" || isNaN(this.dataInput.quantityInt)){
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
        methods : {
            tooltipText: function(text) {
                return text
            },
            submitForm(){
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
                        var material = this.dataMaterial[this.editInput.index];
                        material.quantityInt = this.editInput.quantityInt;
                        material.quantity = this.editInput.quantity;
                        material.material_id = new_material_id;
                        material.wbs_id = this.editInput.wbs_id;

                        window.axios.get('/api/getMaterialPR/'+new_material_id).then(({ data }) => {
                            console.log(data);
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

                             window.axios.get('/api/getWork/'+this.editInput.wbs_id).then(({ data }) => {
                                material.work_name = data.name;
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
                    // }
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
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.quantity = data.quantity;
                this.editInput.quantityInt = data.quantityInt;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.work_name = data.work_name;
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
                    window.axios.get('/api/getProject/'+newValue).then(({ data }) => {
                        this.selectedProject = [];
                        this.selectedProject.push(data);
                        console.log(this.selectedProject)

                        this.works = data.works;
                        
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
                window.axios.get('/api/getWork/'+newValue).then(({ data }) => {
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
