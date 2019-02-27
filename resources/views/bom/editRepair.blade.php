@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit BOM / BOS',
        'items' => [
            'Dashboard' => route('index'),
            'Manage BOM / BOS' => route('bom_repair.indexProject'),
            'Select BOM / BOS' => route('bom_repair.indexBom', ['id' => $modelBOM->project_id]),
            'View BOM / BOS' => route('bom_repair.show', ['id' => $modelBOM->id]),
            'Edit BOM / BOS' => '',
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
                <form class="form-horizontal" method="POST" action="{{ route('bom.update',['id'=>$modelBOM->id]) }}">
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                    @verbatim
                    <div id="bom">
                        <div class="box-header p-b-0">
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>Project Information</b></div>
            
                                <div class="col-xs-4 no-padding">Project Code</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.number)"><b>: {{project.number}}</b></div>
                                
                                <div class="col-xs-4 no-padding">Ship Name</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.name)"><b>: {{project.name}}</b></div>
        
                                <div class="col-xs-4 no-padding">Ship Type</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.ship.type)"><b>: {{project.ship.type}}</b></div>
        
                                <div class="col-xs-4 no-padding">Customer</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.customer.name)"><b>: {{project.customer.name}}</b></div>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>WBS Information </b></div>
                                
                                <div class="col-xs-4 no-padding">Number</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.number)"><b>: {{wbs.number}}</b></div>
        
                                <div class="col-xs-4 no-padding">Description</div>
                                <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: {{wbs.description}}</b></div>
                                <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: -</b></div>
        
                                <div class="col-xs-4 no-padding">Deliverable</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
        
                                <div class="col-xs-4 no-padding">Progress</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.progress)"><b>: {{wbs.progress}}%</b></div>
                            </div>

                            <div class="col-xs-12 col-md-4 p-b-10">
                                <div class="col-sm-12 no-padding"><b>BOM Information - {{status}}</b></div>
                        
                                <div class="col-md-5 col-xs-4 no-padding">Code</div>
                                <div class="col-md-7 col-xs-8 no-padding"><b>: {{bom.code}}</b></div>
                                
                                <div class="col-md-5 col-xs-4 no-padding">RAP Number</div>
                                <div v-if="rap != null" class="col-md-7 col-xs-8 no-padding"><a :href="showRapRoute(rap.id)" class="text-primary"><b>: {{rap.number}}</b></a></div>
                                <div v-else class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>

                                <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                                <div v-if="pr == null" class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>
                                <div v-else-if="pr != null" class="col-md-7 col-xs-8 no-padding"><a :href="showPrRoute(pr.id)" class="text-primary"><b>: {{pr.number}}</b></a></div>

                                <div class="col-md-5 col-xs-4 no-padding">Description</div>
                                <div class="col-md-7 col-xs-8 no-padding">
                                    <textarea class="form-control" v-model="bom.description"></textarea>  
                                </div>
                            </div>
                        </div> <!-- /.box-header -->
                        <div class="col-md-12">
                            <table class="table table-bordered tableFixed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Type</th>
                                        <th width="25%">Material / Service Number</th>
                                        <th width="28%">Material / Service Description</th>
                                        <th width="10%">Quantity</th>
                                        <th width="10%">Unit</th>
                                        <th width="12%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bomDetail, index) in materialTable">
                                        <td class="p-b-13 p-t-13">{{ index + 1 }}</td>
                                        <td v-if="bomDetail.material_id != null && bomDetail.material_id != ''">Material</td>
                                        <td v-else>Service</td>
                                        <template v-if="bomDetail.material_id != null">
                                            <td class="tdEllipsis">{{ bomDetail.material.code }}</td>
                                            <td class="tdEllipsis">{{ bomDetail.material.description }}</td>
                                            <td>{{ bomDetail.quantity }}</td>
                                            <td>{{ bomDetail.material.uom.unit }}</td>
                                        </template>
                                        <template v-else-if="bomDetail.service_id != null">
                                            <td class="tdEllipsis">{{ bomDetail.service.code }}</td>
                                            <td class="tdEllipsis">{{ bomDetail.service.description }}</td>
                                            <td>{{ bomDetail.quantity }}</td>
                                            <td>-</td>
                                        </template>
                                        <td class="p-l-0" align="center">
                                            <template v-if="bom.status == 1">
                                                <a class="btn btn-primary btn-xs" href="#edit_item" @click="openEditModal(bomDetail,index)">
                                                    EDIT
                                                </a>
                                                <a href="#" @click="removeRow(bomDetail.id)" class="btn btn-danger btn-xs">
                                                    <div class="btn-group">DELETE</div>
                                                </a>
                                            </template>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td class="no-padding">
                                            <selectize id="type" v-model="input.type" :settings="typeSettings">
                                                <option v-for="(type, index) in types" :value="type">{{ type }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding" v-show="input.type == ''" colspan = 2>
                                            <input class="form-control width100" type="text" disabled placeholder="Please select type first">  
                                        </td>
                                        <td class="no-padding" v-show="input.type == 'Material'" colspan = 2>
                                            <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding" v-show="input.type == 'Service'" colspan = 2>
                                            <selectize id="service" v-model="input.service_id" :settings="serviceSettings">
                                                <option v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.description }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control width100" type="text" v-model="input.quantity"></td>
                                        <td class="no-padding"><input class="form-control width100" type="text" :value="input.unit" disabled></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tfoot>
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
                                                    <option v-for="(material, index) in materials_modal" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.type == 'Service'">
                                                <label for="type" class="control-label">Service</label>
                                                <selectize id="edit_modal" v-model="editInput.service_id" :settings="serviceSettings">
                                                    <option v-for="(service, index) in services_modal" :value="service.id">{{ service.code }} - {{ service.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" id="unit" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" v-show="editInput.type == 'Material'">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
                                    </div>
                                    <div class="modal-footer" v-show="editInput.type == 'Service'">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_service_id, editInput.service_id)">SAVE</button>
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

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        menu : @json($menu),
        status : @json(($modelBOM->status == 0) ? 'CONFIRMED' : 'OPEN'),
        types : ['Material','Service'],
        bom : @json($modelBOM),
        project : @json($project),
        materials : @json($materials),
        services : @json($services),
        wbs : @json($modelBOM->wbs),
        rap : @json($modelRAP),
        pr : @json($modelPR),
        newIndex : 0, 
        submittedForm :{
            project_id : "",
            bom_code : "",
            description : ""
        },
        input : {
            material_id : "",
            service_id : "",
            description : "",
            quantity : "",
            type : "",
            unit : "",
            is_decimal : "",
            material_ok : ""
        },
        materialTable : @json($modelBOMDetail),
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        serviceSettings: {
            placeholder: 'Please Select Service'
        },
        typeSettings: {
            placeholder: 'Please Select Type'
        },
        editInput : {
            bom_detail_id : "",
            material_id : "",
            service_id : "",
            quantity : "",
            unit : "",
            source : "Stock",
            is_decimal : "",
            material_ok : "",
            type : ""
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
            inputOk: function(){
                let isOk = false;

                if(this.input.type == ""){
                    isOk = true;
                }else{
                    if(this.input.type == "Material"){
                        if(this.input.material_id == "" || this.input.quantity == ""){
                            isOk = true;
                        }
                    }else if(this.input.type == "Service"){
                        if(this.input.service_id == "" || this.input.quantity == ""){
                            isOk = true;
                        }
                    }
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.editInput.type == 'Material'){
                    if(this.editInput.material_id == "" || this.editInput.quantity == ""){
                        isOk = true;
                    }
                }else if(this.editInput.type == 'Service'){
                    if(this.editInput.service_id == "" || this.editInput.quantity == ""){
                        isOk = true;
                    }
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
            getNewMaterialService(){
                var data = this.materialTable;
                this.material_id = [];
                this.service_id = [];
                data.forEach(bomDetail => {
                    if(bomDetail.material_id != null){
                        var decimal = (bomDetail.quantity+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                bomDetail.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                bomDetail.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            bomDetail.quantity = (bomDetail.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                        this.material_id.push(bomDetail.material_id);         
                    }else if(bomDetail.service_id != null){
                        bomDetail.quantity = (bomDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        this.service_id.push(bomDetail.service_id); 
                    }
                });
                var jsonMaterialId = JSON.stringify(this.material_id);
                var jsonServiceId = JSON.stringify(this.service_id);
                this.getNewMaterials(jsonMaterialId);
                this.getNewServices(jsonServiceId);
            },
            showRapRoute(id){
                url = "/rap_repair/"+id;

                return url;
            },
            showPrRoute(id){
                url = "/purchase_requisition/"+id;

                return url;
            },
            tooltipText: function(text) {
                return text
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
            getNewModalServices(jsonServiceId){
                window.axios.get('/api/getServicesBOM/'+jsonServiceId).then(({ data }) => {
                    this.services_modal = data;
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
            openEditModal(data,index){
                $('div.overlay').show();
                this.editInput.bom_detail_id = data.id;
                this.editInput.quantity = data.quantity;

                if(data.material != null){
                    this.editInput.type = 'Material';
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
                    this.editInput.old_material_id = data.material_id;
                    this.editInput.unit = data.material.uom.unit;
                    this.editInput.is_decimal = data.is_decimal;

                }else if(data.service != null){
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
                    this.editInput.old_service_id = data.service_id;
                    this.editInput.unit = '-';
                    this.editInput.type = 'Service';
                    this.editInput.is_decimal = 0;

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
                    message: 'Are you sure you want to delete this materials?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            var url = "";
                            if(vm.menu == "building"){
                                url = "/bom/deleteMaterial/"+id;
                            }else if(vm.menu == "repair"){
                                url = "/bom_repair/deleteMaterial/"+id;
                            }
                            $('div.overlay').show();            
                            window.axios.delete(url).then((response) => {
                                if(response.data.error != undefined){
                                    console.log(response.data.error);
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
                                    vm.getBom(vm.bom.id);
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
            updateDesc(newValue){
                var bom_id = this.bom.id;
                var data ={
                    desc : newValue,
                    bom_id : bom_id
                }
                data = JSON.stringify(data);
                var url = "{{ route('bom_repair.updateDesc') }}";
                window.axios.put(url,data).then((response) => {
                    
                })
                .catch((error) => {
                    $('div.overlay').hide();
                })
            },
            update(){
                $('div.overlay').show();
                this.editInput.quantity = (this.editInput.quantity+"").replace(/,/g , '');
                $('div.overlay').show();
                var data = this.editInput;
                data = JSON.stringify(data);
                var url = "{{ route('bom_repair.update') }}";

                window.axios.put(url,data).then((response) => {
                    if(response.data.service_id != ''){
                        iziToast.success({
                            title: 'Success Edit Service !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    } else if(response.data.material_id != ''){
                        iziToast.success({
                            title: 'Success Edit Material !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    }

                    this.getBom(this.bom.id);

                    this.editInput.description = "";
                    this.editInput.bom_detail_id = "";
                    this.editInput.material_id = "";
                    this.editInput.quantity = "";
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
            getBom(bom_id){
                window.axios.get('/api/getBom/'+bom_id).then(({ data }) => {
                    this.materialTable = data;
                    this.getNewMaterialService();
                    $('div.overlay').hide();
                    this.newIndex = this.materialTable.length + 1;
                });
            },
            submitToTable(){
                this.input.quantity = (this.input.quantity+"").replace(/,/g , '');
                if(this.input.type == "Material"){
                    if(this.input.material_id != "" && this.input.quantity != ""){
                        $('div.overlay').show();
                        var newMaterial = this.input;
                        var bom_id = this.input.bom_id;

                        newMaterial = JSON.stringify(newMaterial);
                        var url = "{{ route('bom_repair.storeBom') }}";

                        window.axios.post(url,newMaterial).then((response) => {
                            iziToast.success({
                                title: 'Success Add Material',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            this.material_id.push(this.input.material_id);         
                            var jsonMaterialId = JSON.stringify(this.material_id);
                            this.getNewMaterials(jsonMaterialId);

                            this.input.material_id = "";
                            this.input.type = "";
                            this.input.unit = "";
                            this.input.quantity = "";
                            this.materialTable = [];
                            this.getBom(bom_id);
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
                }else if(this.input.type == "Service"){
                    if(this.input.service_id != "" && this.input.quantity != ""){
                        $('div.overlay').show();
                        var newMaterial = this.input;
                        var bom_id = this.input.bom_id;

                        newMaterial = JSON.stringify(newMaterial);
                        var url = "{{ route('bom_repair.storeBom') }}";

                        window.axios.post(url,newMaterial).then((response) => {
                            iziToast.success({
                                title: 'Success Add Service',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            this.service_id.push(this.input.service_id);         
                            var jsonServiceId = JSON.stringify(this.service_id);
                            this.getNewServices(jsonServiceId);

                            this.input.service_id = "";
                            this.input.unit = "";
                            this.input.type = "";
                            this.input.quantity = "";
                            this.materialTable = [];
                            this.getBom(bom_id);
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
                }
            },
            getMaterial: function(index) {
                var datas = this.materialTable[index];
                this.modalData.bom_detail_id = datas.id;

                window.axios.get('/api/getBomDetail/'+this.modalData.bom_detail_id).then(({ data }) => {
                    this.modalData.material_id = data.material_id;
                    this.modalData.quantity = data.quantity;
                });
            }
        },
        watch: {
            'input.material_id': function(newValue){
                this.input.quantity = "";
                if(newValue != ""){
                    this.input.material_ok = "ok";
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        this.input.unit = data.uom.unit;
                        this.input.is_decimal = data.uom.is_decimal;
                    });
                }else{
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
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        this.editInput.unit = data.uom.unit;
                        this.editInput.is_decimal = data.uom.is_decimal;
                    });
                }else{
                    this.editInput.unit = "";
                    this.editInput.is_decimal = "";
                    this.editInput.material_ok = "";
                }
            },
            'input.quantity': function(newValue){
                var is_decimal = this.input.is_decimal;
                if(is_decimal == 0){
                    this.input.quantity = (this.input.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = newValue.replace(/,/g, '').split('.');
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
            'bom.description' : function(newValue){
                this.updateDesc(newValue);
            },
            'input.type' : function(newValue){
                this.input.material_id = "";
                this.input.service_id = "";

                if(newValue == 'Material'){
                    var jsonMaterialId = JSON.stringify(this.material_id);
                    this.getNewMaterials(jsonMaterialId);
                }else if(newValue == 'Service'){
                    var jsonServiceId = JSON.stringify(this.service_id);
                    this.getNewServices(jsonServiceId);        
                }
            },
            'input.service_id': function(newValue){
                this.input.quantity = "";
                if(newValue != ""){
                    this.input.material_ok = "ok";
                    window.axios.get('/api/getServiceBOM/'+newValue).then(({ data }) => {
                        this.input.unit = '-';
                        this.input.is_decimal = 0;
                    });
                }else{
                    this.input.unit = "";
                    this.input.is_decimal = "";
                    this.input.material_ok = "";
                }
            },
            'editInput.service_id': function(newValue){
                if(newValue != this.editInput.old_service_id){
                    this.editInput.quantity = "";
                }
                if(newValue != ""){
                    this.editInput.material_ok = "ok";
                    window.axios.get('/api/getServiceBOM/'+newValue).then(({ data }) => {
                        this.editInput.unit = '-';
                        this.editInput.is_decimal = 0;
                    });
                }else{
                    this.editInput.unit = "";
                    this.editInput.is_decimal = "";
                    this.editInput.material_ok = "";
                }
            },
            materialTable: function(newValue) {
                newValue.forEach(bomDetail => {
                    var decimal = (bomDetail.quantity+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            bomDetail.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            bomDetail.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        bomDetail.quantity = (bomDetail.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                });
            },
        },
        created: function() {
            this.submittedForm.project_id = this.bom.project_id;
            this.submittedForm.bom_code = this.bom_code;
            this.newIndex = this.materialTable.length + 1;
            this.input.bom_id = this.bom.id;

            this.getNewMaterialService();
        }
    });
       
</script>
@endpush
