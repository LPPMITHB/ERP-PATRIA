@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Bill Of Material',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Manage Bill Of Materials' => route('bom.indexProject'),
            'Select Bill Of Material' => route('bom.indexBom', ['id' => $modelBOM->project_id]),
            'View Bill Of Material' => route('bom.show', ['id' => $modelBOM->id]),
            'Edit Bill Of Material' => '',
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
                        <div class="col-md-12 p-t-10">
                            <table class="table table-bordered tableFixed m-b-0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Material Number</th>
                                        <th width="28%">Material Description</th>
                                        <th width="10%">Quantity</th>
                                        <th width="10%">Unit</th>
                                        <th width="10%">Source</th>
                                        <th width="12%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bomDetail, index) in materialTable">
                                        <td class="p-t-13 p-b-13">{{ index + 1 }}</td>
                                        <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipCode(bomDetail.material.code)">{{ bomDetail.material.code }}</td>
                                        <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipDesc(bomDetail.material.description)">{{ bomDetail.material.description }}</td>
                                        <td>{{ bomDetail.quantity }}</td>
                                        <td>{{ bomDetail.material.uom.unit }}</td>
                                        <td>{{ bomDetail.source }}</td>
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
                                        <td colspan="2" class="no-padding">
                                            <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control width100" type="text" v-model="input.quantity" :disabled="materialOk"></td>
                                        <td class="no-padding"><input class="form-control width100" type="text" v-model="input.unit" disabled></td>
                                        <td class="no-padding">
                                            <selectize v-model="input.source" :settings="sourceSettings">
                                                <option v-for="(source, index) in sources" :value="source">{{ source }}</option>
                                            </selectize>    
                                        </td>
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
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" id="unit" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Source</label>
                                                <selectize v-model="editInput.source" :settings="sourceSettings">
                                                    <option v-for="(source, index) in sources" :value="source">{{ source }}</option>
                                                </selectize>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button @click.prevent="update" type="button" class="btn btn-primary" data-dismiss="modal">SAVE</button>
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
        sources : ['Stock','WIP'],
        bom : @json($modelBOM),
        project : @json($project),
        materials : @json($materials),
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
            bom_id : @json($modelBOM->id),
            material_id : "",
            quantity : "",
            source : "Stock",
            unit : "",
            is_decimal : "",
            material_ok : ""
        },
        materialTable : @json($modelBOMDetail),
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        sourceSettings: {
            placeholder: 'Please Select Source'
        },
        editInput : {
            bom_detail_id : "",
            material_id : "",
            old_material_id : "",
            quantity : "",
            unit : "",
            source : "Stock",
            is_decimal : "",
            material_ok : ""
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
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

                if(this.input.material_id == "" || this.input.quantity == "" || this.input.source == ""){
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
            }
        },
        methods: {
            tooltipCode: function(code) {
                return code;
            },
            tooltipDesc: function(desc) {
                return desc;
            },
            showRapRoute(id){
                url = "/rap/"+id;

                return url;
            },
            showPrRoute(id){
                url = "/purchase_requisition/"+id;

                return url;
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
            updateDesc(newValue){
                var bom_id = this.bom.id;
                var data ={
                    desc : newValue,
                    bom_id : bom_id
                }
                data = JSON.stringify(data);
                var url = "{{ route('bom.updateDesc') }}";
                window.axios.put(url,data).then((response) => {
                })
                .catch((error) => {
                    iziToast.warning({
                        displayMode: 'replace',
                        title: "Please try again.. ",
                        position: 'topRight',
                    });
                    $('div.overlay').hide();
                })
            },
            update(){
                this.editInput.quantity = (this.editInput.quantity+"").replace(/,/g , '');
                $('div.overlay').show();
                var data = this.editInput;
                data = JSON.stringify(data);
                var bom_id = this.bom.id;
                var url = "{{ route('bom.update') }}";

                window.axios.put(url,data).then((response) => {
                    console.log(response.material_id)
                    iziToast.success({
                        title: 'Success Edit Material !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.editInput.bom_detail_id = "";
                    this.editInput.material_id = "";
                    this.editInput.quantity = "";
                    this.editInput.source = "";
                    this.editInput.unit = "";
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
            },
            getBom(bom_id){
                $('div.overlay').show();
                window.axios.get('/api/getBom/'+bom_id).then(({ data }) => {
                    this.material_id = [];
                    this.materialTable = data;

                    this.materialTable.forEach(material =>{
                        this.material_id.push(material.material_id);         
                    })

                    var jsonMaterialId = JSON.stringify(this.material_id);
                    this.getNewMaterials(jsonMaterialId);
                    this.newIndex = this.materialTable.length + 1;
                    $('div.overlay').hide();
                });
            },
            getPR(bom_id){
                window.axios.get('/api/getPRBom/'+bom_id).then(({ data }) => {
                    this.pr = data;
                });
            },
            submitToTable(){
                $('div.overlay').show();
                this.input.quantity = (this.input.quantity+"").replace(/,/g , '');

                if(this.input.material_id != "" && this.input.source != "" && this.input.quantity != ""){
                    var newMaterial = this.input;
                    newMaterial = JSON.stringify(newMaterial);

                    if(this.menu == "building"){
                        var url = "{{ route('bom.storeBom') }}";
                    }else{
                        var url = "{{ route('bom_repair.storeBom') }}";
                    }

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
                        this.input.quantity = "";
                        this.input.unit = "";
                        this.input.source = "Stock";
                        this.materialTable = [];
                        this.getBom(this.bom.id);
                        this.getPR(this.bom.id);
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
            getMaterial: function(index) {
                var datas = this.materialTable[index];
                this.modalData.bom_detail_id = datas.id;

                window.axios.get('/api/getBomDetail/'+this.modalData.bom_detail_id).then(({ data }) => {
                    this.modalData.material_id = data.material_id;
                    this.modalData.quantity = data.quantity;
                });
            },
            openEditModal(data,index){
                $('div.overlay').show();
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

                this.editInput.bom_detail_id = data.id;
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.quantity = data.quantity;
                this.editInput.source = data.source;
                this.editInput.unit = data.unit;
                this.editInput.is_decimal = data.is_decimal;
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
                            }else if(vm.route == "repair"){
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

            var data = this.materialTable;
            data.forEach(bomDetail => {
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
            });
            var jsonMaterialId = JSON.stringify(this.material_id);
            this.getNewMaterials(jsonMaterialId);
        }
    });
       
</script>
@endpush
