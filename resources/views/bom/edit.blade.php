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
        <div class="box box-solid">
            <div class="box-body">
                <form class="form-horizontal" method="POST" action="{{ route('bom.update',['id'=>$modelBOM->id]) }}">
                <input type="hidden" name="_method" value="PATCH">
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
                                            <td><b>{{project.code}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Project Name</td>
                                            <td>:</td>
                                            <td><b>{{project.name}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Ship Name</td>
                                            <td>:</td>
                                            <td><b>{{project.ship.name}}</b></td>
    
                                            
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
                                            <td>&ensp;<b>{{work.code}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{work.name}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{work.description}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Deliverable</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{work.deliverables}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Progress</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{work.progress}}%</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <td rowspan="2">BOM Description</td>
                                <td rowspan="2">:</td>
                                <td rowspan="2">
                                    <textarea class="form-control" rows="3" v-model="bom.description" style="width:326px"></textarea>  
                                </td>
                            </div>
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-20">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="28%">Material</th>
                                        <th width="38%">Description</th>
                                        <th width="14%">Quantity</th>
                                        <th width="15%" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bomDetail, index) in materialTable">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ bomDetail.material.name }}</td>
                                        <td v-if="bomDetail.material.description != null">{{ bomDetail.material.description }}</td>
                                        <td v-else>{{ '-' }}</td>
                                        <td>{{ bomDetail.quantity }}</td>
                                        <td class="p-l-0" align="center">
                                            <a data-toggle="modal" data-target="#edit" class="btn btn-primary btn-xs" @click="getMaterial(index)">
                                                <div class="btn-group">
                                                    EDIT
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td  class="no-padding">
                                            <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.name }}</option>
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
                                        <label for="material">Material</label>
                                        <selectize id="material" v-model="modalData.material_id" :settings="materialSettings">
                                            <option v-for="(material, index) in materials" :value="material.id">{{ material.name }}</option>
                                        </selectize>    

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
        $('.alert').addClass('animated bounce');
        
    });

    var data = {
        bom : @json($modelBOM),
        project : @json($project),
        materials : @json($materials),
        work : @json($modelBOM->work),
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
        }
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

                window.axios.patch(url,data).then((response) => {
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
                    window.axios.get('/api/getMaterial/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.modalData.description = '-';
                        }else{
                            this.modalData.description = data.description;
                        }
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
            });
        }
    });
       
</script>
@endpush
