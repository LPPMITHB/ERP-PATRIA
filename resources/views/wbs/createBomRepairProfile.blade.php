@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage BOM / BOS Profile',
        'items' => [
            'Dashboard' => route('index'),
            'Create WBS Profile' => route('wbs.createWbsProfile'),
            'Manage BOM / BOS Profile' => '',
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
                @verbatim
                <div id="bom">
                    <div class="box-header p-b-0">                          
                        <div class="col-xs-12 col-md-4">
                            <div class="col-sm-12 no-padding"><b>WBS Profile Information</b></div>
                        
                            <div class="col-xs-4 no-padding">Name</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.name)"><b>: {{wbs.name}}</b></div>
    
                            <div class="col-xs-4 no-padding">Description</div>
                            <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.description)"><b>: {{wbs.description}}</b></div>
                            <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.description)"><b>: -</b></div>
    
                            <div class="col-xs-4 no-padding">Deliverable</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
    
                        </div>
                    </div> <!-- /.box-header -->
                    <div class="col-md-12 p-t-20">
                        <table class="table table-bordered tableFixed m-b-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Type</th>
                                    <th width="30%">Material / Service</th>
                                    <th width="33%">Description</th>
                                    <th width="10%">Quantity</th>
                                    <th width="12%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in materialTable">
                                    <td>{{ index + 1 }}</td>
                                    <td v-if="data.material_id != null">Material</td>
                                    <td v-else-if="data.service_id != null">Service</td>
                                    <td v-if="data.material_id != null" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.material.name)">{{ data.material.code }} - {{ data.material.name }}</td>
                                    <td v-else-if="data.service_id != null" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.service.name)">{{ data.service.code }} - {{ data.service.name }}</td>
                                    <td v-if="data.material_id != null">{{ data.material.description }}</td>
                                    <td v-else-if="data.service_id != null">{{ data.service.description }}</td>
                                    <td>{{ data.quantity }}</td>
                                    <td class="p-l-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="#edit_item" @click="openEditModal(data,index)">
                                            EDIT
                                        </a>
                                        <a href="#" @click="removeRow(data.id)" class="btn btn-danger btn-xs">
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
                                    <td class="no-padding" v-show="input.type == ''">
                                        <selectize id="material" v-model="input.material_id" :settings="nullSettings" disabled>
                                            <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                        </selectize>
                                    </td>
                                    <td class="no-padding" v-show="input.type == 'Material'">
                                        <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                            <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                        </selectize>    
                                    </td>
                                    <td class="no-padding" v-show="input.type == 'Service'">
                                        <selectize id="service" v-model="input.service_id" :settings="serviceSettings">
                                            <option v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }}</option>
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

                    <div class="modal fade" id="edit_item">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" v-show="editInput.type == 'Material'">Edit Material</h4>
                                    <h4 class="modal-title" v-show="editInput.type == 'Service'">Edit Service</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12" v-show="editInput.type == 'Material'">
                                            <label for="type" class="control-label">Material</label>
                                            <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials_modal" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                            </selectize>
                                        </div>
                                        <div class="col-sm-12" v-show="editInput.type == 'Service'">
                                            <label for="type" class="control-label">Service</label>
                                            <selectize id="edit_modal" v-model="editInput.service_id" :settings="serviceSettings">
                                                <option v-for="(service, index) in services_modal" :value="service.id">{{ service.code }} - {{ service.name }}</option>
                                            </selectize>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <input type="text" id="description" v-model="editInput.description" class="form-control" disabled>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="quantity" class="control-label">Quantity</label>
                                            <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update()">SAVE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endverbatim
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
        types : ['Material','Service'],
        route : @json($route),
        materials : @json($materials),
        services : @json($services),
        wbs : @json($wbs),
        materialTable : @json($bom),
        newIndex : 0, 
        input : {
            wbs_id : @json($wbs->id),
            material_id : "",
            service_id : "",
            description : "",
            quantity : "",
            quantityInt : 0,
            type : "",
        },
        editInput : {
            wbs_id : @json($wbs->id),
            type : "",
            material_id : "",
            service_id : "",
            quantity : "",
            quantityInt : 0,
            description : "",
            id : ""
        },
        nullSettings: {
            placeholder: 'Please select type first'
        },
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
        service_id:[],
        service_id_modal:[],
        services_modal :[],
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el : '#bom',
        data : data,
        computed:{
            selectize: function(){
                let isOk = true;

                return isOk;
            },
            inputOk: function(){
                let isOk = false;

                var string_newValue = this.input.quantityInt+"";
                this.input.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.input.type == ""){
                    isOk = true;
                }else{
                    if(this.input.type == "Material"){
                        if(this.input.material_id == "" || this.input.quantity == "" || this.input.quantityInt < 1){
                            isOk = true;
                        }
                    }else if(this.input.type == "Service"){
                        if(this.input.service_id == "" || this.input.quantity == "" || this.input.quantityInt < 1){
                            isOk = true;
                        }
                    }
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityInt+"";
                this.editInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.editInput.material_id == "" && this.editInput.service_id == "" || this.editInput.quantityInt < 1 || this.editInput.quantityInt == "" || this.editInput.source == "" || isNaN(this.editInput.quantityInt)){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            getBomProfile(wbs_id){
                window.axios.get('/api/getBomProfile/'+wbs_id).then(({data}) =>{
                    this.material_id = [];
                    this.service_id = [];
                    this.materialTable = data;

                    this.materialTable.forEach(data =>{
                        if(data.material_id != null){
                            this.material_id.push(data.material_id);
                        }else if(data.service_id != null){
                            this.service_id.push(data.service_id);
                        }
                        data.quantity = (data.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                    });

                    var jsonMaterialId = JSON.stringify(this.material_id);
                    var jsonServiceId = JSON.stringify(this.service_id);
                    this.getNewMaterials(jsonMaterialId); 
                    this.getNewServices(jsonServiceId); 
                    this.newIndex = this.materialTable.length + 1;
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
            tooltipText: function(text) {
                return text
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
            getNewServices(jsonServiceId){
                window.axios.get('/api/getServicesBOM/'+jsonServiceId).then(({ data }) => {
                    this.services = data;
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
                    $('#edit_item').modal();
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
            getNewModalServices(jsonServiceId){
                window.axios.get('/api/getServicesBOM/'+jsonServiceId).then(({ data }) => {
                    this.services_modal = data;
                    $('div.overlay').hide();
                    $('#edit_item').modal();
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
                $('div.overlay').show();
                if(data.material_id != null){
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
                    this.editInput.material_id = data.material_id;
                    this.editInput.type = 'Material';
                }else if(data.service_id != null){
                    var service_id = JSON.stringify(this.service_id);
                    service_id = JSON.parse(service_id);
                    
                    this.service_id_modal = service_id;
                    this.service_id_modal.forEach(id => {
                        if(id == data.service_id){
                            var index = this.service_id_modal.indexOf(id);
                            this.service_id_modal.splice(index, 1);
                        }
                    });
                    var jsonServiceId = JSON.stringify(this.service_id_modal);
                    this.getNewModalServices(jsonServiceId);
                    this.editInput.service_id = data.service_id;
                    this.editInput.type = 'Service';
                }

                this.editInput.quantity = data.quantity;
                this.editInput.quantityInt = parseInt((data.quantity+"").replace(/,/g , ''));
                this.editInput.id = data.id;
            },
            submitToTable(){
                if(this.input.material_id != "" && this.input.quantity != "" && this.input.quantityInt > 0 || this.input.service_id != "" && this.input.quantity != "" && this.input.quantityInt > 0){
                    var data = JSON.stringify(this.input);
                    if(this.route == "/wbs"){
                        var url = "{{ route('wbs.storeBomProfile') }}";
                    }else if(this.route == "/wbs_repair"){
                        var url = "{{ route('wbs_repair.storeBomProfile') }}";
                    }
                    // store to database
                    window.axios.post(url,data).then((response)=>{
                        iziToast.success({
                            title: 'Success add material !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        this.input.material_id = "";
                        this.input.service_id = "";
                        this.input.type = "";
                        this.input.description = "";
                        this.input.quantity = "";
                        this.input.quantityInt = 0;

                        this.getBomProfile(this.wbs.id)
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        console.log(error);
                        $('div.overlay').hide();
                    })
                }
            },
            removeRow: function(id) {
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to delete this material?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            var url = "";
                            if(vm.route == "/wbs"){
                                url = "/wbs/deleteBomProfile/"+id;
                            }else if(vm.route == "/wbs_repair"){
                                url = "/wbs_repair/deleteBomProfile/"+id;
                            }
                            $('div.overlay').show();            
                            window.axios.delete(url).then((response) => {
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
                                    vm.getBomProfile(vm.wbs.id);
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
            update(){
                var data = JSON.stringify(this.editInput);

                if(this.route == "/wbs"){
                    var url = "{{ route('wbs.updateBomProfile') }}"
                }else if(this.route == "/wbs_repair"){
                    var url = "{{ route('wbs_repair.updateBomProfile') }}"
                }

                // update to database
                window.axios.put(url,data).then((response)=>{
                    this.getBomProfile(this.editInput.wbs_id);
                    if(this.editInput.material_id != ''){
                        iziToast.success({
                            title: 'Success update material !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    }else if(this.editInput.service_id != ''){
                        iziToast.success({
                            title: 'Success update service !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    }
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            },
        },
        watch: {
            'input.material_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;
                        }
                    });
                }else{
                    this.input.description = "";
                }
            },
            'input.service_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getServiceBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;
                        }
                    });
                }else{
                    this.input.description = "";
                }
            },
            'input.quantity': function(newValue){
                this.input.quantityInt = newValue;
                this.input.quantity = (this.input.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'editInput.quantity': function(newValue){
                this.editInput.quantityInt = newValue;
                this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'editInput.material_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.editInput.description = '-';
                        }else{
                            this.editInput.description = data.description;

                        }
                    });
                }else{
                    this.editInput.description = "";
                }
            },
            'editInput.service_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getServiceBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.editInput.description = '-';
                        }else{
                            this.editInput.description = data.description;

                        }
                    });
                }else{
                    this.editInput.description = "";
                }
            },
            'input.type' : function(newValue){
                this.input.material_id = "";
                this.input.material_name = "";
                this.input.description = "";
                this.input.quantity = "";
                this.input.quantityInt = 0;
            }
        },
        created: function() {
            this.getBomProfile(this.wbs.id);

        }
    });
       
</script>
@endpush
