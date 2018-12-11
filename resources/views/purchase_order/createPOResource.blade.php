@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Purchase Order - Resource',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Create Purchase Order - Resource' => '',
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
                <form id="create-po" class="form-horizontal" method="POST" action="{{ route('purchase_order.storeResource') }}">
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
                                <selectize v-model="project_id" :settings="projectSettings" :disabled="dataOk">
                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.name }}</option>
                                </selectize> 
                                <template v-if="selectedProject.length > 0">
                                    <label for="" >Vendor Name</label>
                                    <selectize v-model="vendor_id" :settings="vendorSettings">
                                        <option v-for="(vendor, index) in vendors" :value="vendor.id">{{ vendor.name }}</option>
                                    </selectize>   
                                </template>
                            </div>
                            <template v-if="selectedProject.length > 0">
                                <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <label for="">PO Description</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="5" v-model="description"></textarea>
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
                                                <th style="width: 20%">Resource Name</th>
                                                <th style="width: 10%">Quantity</th>
                                                <th style="width: 10%">UOM</th>
                                                <th style="width: 20%">Cost</th>
                                                <th style="width: 25%">Work Name</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(resource,index) in dataResource">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ resource.resource_code }} - {{ resource.resource_name }}</td>
                                                <td class="tdEllipsis">{{ resource.quantity }}</td>
                                                <td class="tdEllipsis">{{ resource.uom_name }}</td>
                                                <td class="tdEllipsis">{{ resource.cost }}</td>
                                                <td class="tdEllipsis">{{ resource.work_name }}</td>
                                                <td class="p-l-0 textCenter">
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(resource,index)">
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
                                                    <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                    </selectize>
                                                </td>
                                                <td class="p-l-0">
                                                    <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td>{{ dataInput.uom_name }}</td>
                                                <td class="p-l-0 textLeft">
                                                    <input class="form-control" v-model="dataInput.cost" placeholder="Please Input Cost">
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
    const form = document.querySelector('form#create-po');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        description : "",
        newIndex : "",
        resources : @json($modelResource),
        projects : @json($modelProject),
        vendors : @json($modelVendor),
        works : [],
        project_id : "",
        vendor_id : "",
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        workSettings: {
            placeholder: 'Please Select Work'
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        selectedProject : [],
        dataResource : [],
        dataInput : {
            resource_id :"",
            resource_code : "",
            resource_name : "",
            quantity : "",
            cost : "",
            uom_id : "",
            uom_name : "",
            wbs_id : "",
            work_name : ""
        },
        // editInput : {
        //     old_material_id : "",
        //     material_id : "",
        //     material_code : "",
        //     material_name : "",
        //     quantity : "",
        //     quantityInt : 0,
        //     wbs_id : "",
        //     work_name : ""
        // },
        submittedForm : {}
    }

    var vm = new Vue({
        el : '#pr',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataResource.length > 0){
                    isOk = true;
                }

                return isOk;
            },
            allOk: function(){
                let isOk = false;
                
                if(this.dataResource.length < 1 || this.vendor_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;

                var string_newValue = this.dataInput.quantityInt+"";
                this.dataInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.dataInput.resource_id == "" || parseInt(this.dataInput.quantity.replace(/,/g , '')) < 1 || parseInt(this.dataInput.cost.replace(/,/g , '')) < 1 || this.dataInput.wbs_id == ""){
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
                var datas = this.dataResource;
                datas = JSON.stringify(datas);
                datas = JSON.parse(datas);

                datas.forEach(data => {
                    data.quantity = data.quantity.replace(/,/g , '');      
                    data.cost = data.cost.replace(/,/g , '');      
                });

                this.submittedForm.description = this.description;
                this.submittedForm.project_id = this.project_id;     
                this.submittedForm.vendor_id = this.vendor_id;     
                this.submittedForm.resources = datas;    

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            update(old_material_id, new_material_id){
                var material = this.dataMaterial[this.editInput.index];
                material.quantityInt = this.editInput.quantityInt;
                material.quantity = this.editInput.quantity;
                material.material_id = new_material_id;
                material.wbs_id = this.editInput.wbs_id;

                window.axios.get('/api/getMaterialPR/'+new_material_id).then(({ data }) => {
                    console.log(data);
                    material.material_name = data.name;
                    material.material_code = data.code;

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
            },
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
                
                this.material_id_modal.forEach(id => {
                    if(id == data.material_id){
                        var index = this.material_id_modal.indexOf(id);
                        // this.material_id_modal.splice(index, 1);
                    }
                });
            },
            add(){
                var temp_data = JSON.stringify(this.dataInput);
                temp_data = JSON.parse(temp_data);

                this.dataResource.push(temp_data);

                this.dataInput.resource_id = "";
                this.dataInput.resource_code = "";
                this.dataInput.resource_name = "";
                this.dataInput.quantity = "";
                this.dataInput.cost = "";
                this.dataInput.uom_id = "";
                this.dataInput.uom_name = "";
                this.dataInput.wbs_id = "";
                this.dataInput.work_name = "";

                this.newIndex = Object.keys(this.dataResource).length+1;
            },
            removeRow(index){
                this.dataResource.splice(index, 1);
                
                this.newIndex = this.dataResource.length + 1;
            }
        },
        watch : {
            'project_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getProject/'+newValue).then(({ data }) => {
                        this.selectedProject = [];
                        this.selectedProject.push(data);

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
                this.dataInput.quantity = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            'dataInput.cost': function(newValue){
                this.dataInput.cost = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
            'dataInput.resource_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getResourcePO/'+newValue).then(({ data }) => {
                        this.dataInput.resource_code = data.code;
                        this.dataInput.resource_name = data.name;
                        this.dataInput.uom_id = data.uom_id;
                        this.dataInput.uom_name = data.uom.name;
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
            this.newIndex = Object.keys(this.dataResource).length+1;
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
