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
            'Edit Bill Of Material' => route('bom.edit', ['id' => $modelBOM->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <form class="form-horizontal" method="POST" action="{{ route('bom.update',['id'=>$modelBOM->id]) }}">
            <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="box-header p-b-0">
                    <div class="col-xs-12 col-md-4">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>

                        <div class="col-xs-4 no-padding">Project Code</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->number}}</b></div>
                        
                        <div class="col-xs-4 no-padding">Project Name</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->name}}</b></div>

                        <div class="col-xs-4 no-padding">Ship Name</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->ship->name}}</b></div>

                        <div class="col-xs-4 no-padding">Ship Type</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->ship->type}}</b></div>

                        <div class="col-xs-4 no-padding">Customer</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->project->customer->name}}</b></div>
                    </div>

                    <div class="col-xs-12 col-md-4">
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                    
                        <div class="col-xs-4 no-padding">Code</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->wbs->code}}</b></div>
                        
                        <div class="col-xs-4 no-padding">Name</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->wbs->name}}</b></div>

                        <div class="col-xs-4 no-padding">Description</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->wbs->description}}</b></div>

                        <div class="col-xs-4 no-padding">Deliverable</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->wbs->deliverables}}</b></div>

                        <div class="col-xs-4 no-padding">Progress</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOM->wbs->progress}}%</b></div>
                    </div>

                    <div class="col-xs-12 col-md-3 p-b-10">
                        <div class="col-sm-12 no-padding"><b>BOM Information</b></div>
                
                        <div class="col-md-5 col-xs-4 no-padding">Code</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$modelBOM->code}}</b></div>
                        
                        <div class="col-md-5 col-xs-4 no-padding">RAP Number</div>
                        <div class="col-md-7 col-xs-8 no-padding"><a href="{{ route('rap.show',$modelRAP->id) }}" class="text-primary"><b>: {{$rap_number}}</b></a></div>

                        @if(isset($modelPR))
                            <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                            <div class="col-md-7 col-xs-8 no-padding"><a href="{{ route('purchase_requisition.show',$modelPR->id) }}" class="text-primary"><b>: {{$pr_number}}</b></a></div>
                        @else
                            <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                            <div class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>
                        @endif
                    </div>
                </div> <!-- /.box-header -->
                <div class="box-body p-t-5">
                    @verbatim
                    <div id="bom">
                        <div class="col-xs-12 col-md-6">
                            <div class="col-md-3 col-xs-4 no-padding">BOM Description  <b>:</b></div>
                            <div class="col-md-9 col-xs-8 no-padding">
                                <textarea class="form-control" v-model="bom.description" style="width:100%"></textarea>  
                            </div>
                        </div>
                        <div class="col-md-12 p-t-10">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%">Material</th>
                                        <th width="38%">Description</th>
                                        <th width="7%">Quantity</th>
                                        <th width="10%" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bomDetail, index) in materialTable">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ bomDetail.material.code }} - {{ bomDetail.material.name }}</td>
                                        <td v-if="bomDetail.material.description != null">{{ bomDetail.material.description }}</td>
                                        <td v-else>{{ '-' }}</td>
                                        <td>{{ bomDetail.quantity }}</td>
                                        <td class="p-l-0" align="center">
                                            <a data-toggle="modal" data-target="#edit" class="btn btn-primary btn-xs" @click="getMaterial(index)">
                                                <div class="btn-group">
                                                    EDIT
                                                </div>
                                            </a>
                                            <a class="btn btn-danger btn-xs" @click="">
                                                <div class="btn-group">
                                                    DELETE
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td  class="no-padding">
                                            <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control width100" type="text" :value="input.description" disabled></td>
                                        <td class="no-padding"><input class="form-control width100" type="text" v-model="input.quantity"></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tbody>
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
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                    @endverbatim
                </div>
            </form>
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
        bom : @json($modelBOM),
        project : @json($project),
        materials : @json($materials),
        wbs : @json($modelBOM->wbs),
        newIndex : 0, 
        submittedForm :{
            project_id : "",
            bom_code : "",
            description : ""
        },
        input : {
            material_id : "",
            material_name : "",
            description : "",
            quantity : "",
            quantityInt : 0,
            bom_id : ""
        },
        materialTable : @json($modelBOMDetail),
        materialSettings: {
            placeholder: 'Please Select Material'
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
    }

    var vm = new Vue({
        el : '#bom',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                if(this.input.material_id == "" || this.input.material_name == "" || this.input.description == "" || this.input.quantity == ""){
                    isOk = true;
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
            updateDesc(newValue){
                var bom_id = this.bom.id;
                var data ={
                    desc : newValue,
                    bom_id : bom_id
                }
                data = JSON.stringify(data);
                var url = "{{ route('bom.updateDesc') }}";
                window.axios.patch(url,data).then((response) => {
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

                var url = "{{ route('bom.update') }}";
                console.log(url);

                window.axios.patch(url,data).then((response) => {
                    console.log(response);
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

                if(this.input.material_id != "" && this.input.material_name != "" && this.input.description != "" && this.input.quantity != "" && this.input.quantityInt > 0){
                    $('div.overlay').show();
                    var newMaterial = this.input;
                    var bom_id = this.input.bom_id;
                    newMaterial = JSON.stringify(newMaterial);
                    var url = "{{ route('bom.storeBom') }}";

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
                        console.log(data);
                        this.modalData.material_name = data.name;
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
                this.material_id.push(bomDetail.material_id);         
            });
            var jsonMaterialId = JSON.stringify(this.material_id);
            this.getNewMaterials(jsonMaterialId);
        }
    });
       
</script>
@endpush
