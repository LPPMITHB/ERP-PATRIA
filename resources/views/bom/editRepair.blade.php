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
                        <div class="box-header p-b-0 p-l-0 p-r-0">
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>Project Information</b></div>
            
                                <div class="col-xs-4 no-padding">Project Code</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(project.number)"><b>: {{project.number}}</b></div>
                                
                                <div class="col-xs-4 no-padding">Ship Name</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(project.name)"><b>: {{project.name}}</b></div>
        
                                <div class="col-xs-4 no-padding">Ship Type</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(project.ship.type)"><b>: {{project.ship.type}}</b></div>
        
                                <div class="col-xs-4 no-padding">Customer</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(project.customer.name)"><b>: {{project.customer.name}}</b></div>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                                
                                <div class="col-xs-4 no-padding">Code</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.code)"><b>: {{wbs.code}}</b></div>
                                
                                <div class="col-xs-4 no-padding">Name</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.name)"><b>: {{wbs.name}}</b></div>
        
                                <div class="col-xs-4 no-padding">Description</div>
                                <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.description)"><b>: {{wbs.description}}</b></div>
                                <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.description)"><b>: -</b></div>
        
                                <div class="col-xs-4 no-padding">Deliverable</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
        
                                <div class="col-xs-4 no-padding">Progress</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.progress)"><b>: {{wbs.progress}}%</b></div>
                            </div>

                            <div class="col-xs-12 col-md-4 p-b-10">
                                <div class="col-sm-12 no-padding"><b>BOM Information</b></div>
                        
                                <div class="col-md-5 col-xs-4 no-padding">Code</div>
                                <div class="col-md-7 col-xs-8 no-padding"><b>: {{bom.code}}</b></div>
                                
                                <div class="col-md-5 col-xs-4 no-padding">RAP Number</div>
                                <div class="col-md-7 col-xs-8 no-padding"><a :href="showRapRoute(rap.id)" class="text-primary"><b>: {{rap.number}}</b></a></div>

                                <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                                <div v-if="pr != null" class="col-md-7 col-xs-8 no-padding"><a :href="showPrRoute(pr.id)" class="text-primary"><b>: {{pr.number}}</b></a></div>
                                <div v-else class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>

                                <div class="col-md-5 col-xs-4 no-padding">Description</div>
                                <div class="col-md-7 col-xs-8 no-padding">
                                    <textarea class="form-control" v-model="bom.description"></textarea>  
                                </div>
                            </div>
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-10">
                            <table class="table table-bordered tableFixed tableNonPagingVue">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Type</th>
                                        <th width="30%">Material/Service</th>
                                        <th width="38%">Description</th>
                                        <th width="10%">Quantity</th>
                                        <th width="7%" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bomDetail, index) in materialTable">
                                        <td class="p-b-13 p-t-13">{{ index + 1 }}</td>
                                        <td v-if="bomDetail.service_id == null">Material</td>
                                        <td v-else>Service</td>
                                        <template v-if="bomDetail.material_id != null">
                                            <td class="tdEllipsis">{{ bomDetail.material.code }} - {{ bomDetail.material.name }}</td>
                                            <td class="tdEllipsis" v-if="bomDetail.material.description != null">{{ bomDetail.material.description }}</td>
                                            <td v-else>-</td>
                                        </template>
                                        <template v-else-if="bomDetail.service_id != null">
                                            <td class="tdEllipsis">{{ bomDetail.service.code }} - {{ bomDetail.service.name }}</td>
                                            <td class="tdEllipsis" v-if="bomDetail.service.description != null">{{ bomDetail.service.description }}</td>
                                            <td v-else>-</td>
                                        </template>
                                        <td>{{ bomDetail.quantity }}</td>
                                        <td class="p-l-0" align="center">
                                            
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td width="5%">{{newIndex}}</td>
                                        <td width="10%" class="no-padding">
                                            <selectize id="type" v-model="input.type" :settings="typeSettings">
                                                <option v-for="(type, index) in types" :value="type">{{ type }}</option>
                                            </selectize>    
                                        </td>
                                        <td width="30%" class="no-padding" v-if="input.type == ''">
                                            <input class="form-control width100" type="text" disabled placeholder="Please select type first">  
                                        </td>
                                        <td width="30%"class="no-padding" v-else-if="input.type == 'Material'">
                                            <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td width="30%" class="no-padding" v-else-if="input.type == 'Service'">
                                            <selectize id="service" v-model="input.service_id" :settings="serviceSettings">
                                                <option v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td width="38%" class="no-padding"><input class="form-control width100" type="text" :value="input.description" disabled></td>
                                        <td width="10%" class="no-padding"><input class="form-control width100" type="text" v-model="input.quantity"></td>
                                        <td width="7%" class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="modal fade" id="edit">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Material</h4>
                                    </div>
                                    <div class="modal-body">
                                        <label for="material">Material Name</label>
                                        <input id="description" class="form-control" type="text" disabled v-model="modalData.material_name">

                                        <label class="p-t-10" for="description">Description</label>
                                        <input id="description" class="form-control" type="text" disabled v-model="modalData.description">

                                        <label class="p-t-15" for="quantity">Quantity</label>
                                        <input id="quantity" class="form-control" type="text" v-model="modalData.quantity">
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
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'Status' || title == 'No' || title == "" ){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tableNonPagingVue.column(i).search() !== this.value ) {
                    tableNonPagingVue
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        var tableNonPagingVue = $('.tableNonPagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : false,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
        });

        $('div.overlay').hide();
    });

    var data = {
        submit: "ok",
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
            material_name : "",
            material_code : "",
            description : "",
            quantity : "",
            quantityInt : 0,
            type : "",
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
        modalData : {
            bom_detail_id : "",
            material_id : "",
            description : "",
            quantity : "",
            quantityInt : 0,
            material_name : "",
        },
        material_id:[],
        service_id:[],
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
                        console.log()
                        if(this.input.service_id == "" || this.input.quantity == ""){
                            isOk = true;
                        }
                    }
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.submittedForm.project_id == "" || this.submittedForm.bom_code == "" || this.submittedForm.description == "" || this.materialTable.length < 1){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
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
                this.modalData.quantityInt = (this.modalData.quantityInt+"").replace(/,/g , '');
                this.modalData.quantityInt = parseInt(this.modalData.quantityInt);
                $('div.overlay').show();
                var data = this.modalData;
                data = JSON.stringify(data);
                var bom_id = this.bom.id;

                var url = "{{ route('bom_repair.update') }}";

                window.axios.put(url,data).then((response) => {
                    iziToast.success({
                        title: 'Edit Success',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.modalData.description = "";
                    this.modalData.bom_detail_id = "";
                    this.modalData.material_id = "";
                    this.modalData.quantity = "";
                    this.modalData.quantityInt = 0;
                    this.modalData.material_name = "";
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
                window.axios.get('/api/getBom/'+bom_id).then(({ data }) => {
                    this.materialTable = data;
                    $('div.overlay').hide();
                    this.newIndex = this.materialTable.length + 1;
                });
            },
            submitToTable(){
                this.input.quantityInt = (this.input.quantityInt+"").replace(/,/g , '');
                this.input.quantityInt = parseInt(this.input.quantityInt);
                if(this.input.type == "Material"){
                    if(this.input.material_id != "" && this.input.material_name != "" && this.input.description != "" && this.input.quantity != "" && this.input.quantityInt > 0){
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

                            this.input.description = "";
                            this.input.material_id = "";
                            this.input.material_name = "";
                            this.input.type = "";
                            this.input.quantity = "";
                            this.input.quantityInt = 0;
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
                    if(this.input.service_id != "" && this.input.service_name != "" && this.input.description != "" && this.input.quantity != "" && this.input.quantityInt > 0){
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

                            this.input.description = "";
                            this.input.service_id = "";
                            this.input.service_name = "";
                            this.input.type = "";
                            this.input.quantity = "";
                            this.input.quantityInt = 0;
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
                if(newValue != ""){
                    window.axios.get('/api/getMaterial/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;

                        }
                        this.input.material_name = data.name;
                    });
                }else{
                    this.input.description = "";
                }
            },
            'input.quantity': function(newValue){
                this.input.quantityInt = newValue;
                this.input.quantity = (this.input.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            },
            'modalData.quantity': function(newValue){
                this.modalData.quantityInt = newValue;
                this.modalData.quantity = (this.modalData.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            },
            'bom.description' : function(newValue){
                this.updateDesc(newValue);
            },
            'modalData.material_id' : function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.modalData.description = '-';
                        }else{
                            this.modalData.description = data.description;
                        }
                        this.modalData.material_name = data.name;
                    });
                }
            },
            'input.type' : function(newValue){
                this.input.material_id = "";
                this.input.service_id = "";
                this.input.material_name = "";
                this.input.description = "";

                if(newValue == 'Material'){
                    var jsonMaterialId = JSON.stringify(this.material_id);
                    this.getNewMaterials(jsonMaterialId);
                }else if(newValue == 'Service'){
                    var jsonServiceId = JSON.stringify(this.service_id);
                    this.getNewServices(jsonServiceId);        
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
                        this.input.service_name = data.name;
                        this.input.service_code = data.code;
                    });
                }
            },
            materialTable: function(newValue) {
                newValue.forEach(bomDetail => {
                    bomDetail.quantity = (bomDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
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
                bomDetail.quantity = (bomDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                if(bomDetail.material_id != null){
                    this.material_id.push(bomDetail.material_id);         
                }else if(bomDetail.service_id != null){
                    this.service_id.push(bomDetail.service_id);         
                }
            });
            var jsonMaterialId = JSON.stringify(this.material_id);
            var jsonServiceId = JSON.stringify(this.service_id);
            this.getNewMaterials(jsonMaterialId);
            this.getNewServices(jsonServiceId);
        }
    });
       
</script>
@endpush
