@extends('layouts.main')

@section('content-header')
@if($route == "/goods_receipt")
    @breadcrumb(
        [
            'title' => 'Create Goods Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'Select PO / WO' => route('goods_receipt.selectPO'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_receipt_repair")
    @breadcrumb(
        [
            'title' => 'Create Goods Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'Select PO / WO' => route('goods_receipt_repair.selectPO'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/goods_receipt")
                    <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_receipt.storeWo') }}">
                @elseif($route == "/goods_receipt_repair")
                    <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_receipt_repair.storeWo') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="wod">
                        <div class="col-sm-12 no-padding">
                            <div class="box-header">
                                <div class="col-xs-12 col-lg-6 col-md-12 no-padding">    
                                    <div class="box-body no-padding">
                                        <div class="col-md-4 col-xs-4 no-padding">WO Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelWO.number }}</b></div>
                                        
                                        <div class="col-md-4 col-xs-4 no-padding">Vendor</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelWO.vendor.name }}</b></div>
                
                                        <div class="col-md-4 col-xs-4 no-padding">Address</div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis"><b>: {{ modelWO.vendor.address }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">Phone Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelWO.vendor.phone_number }}</b></div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-3 col-md-12 no-padding">    
                                    <div class="box-body no-padding">
                                        <div class="col-md-4 col-lg-7 col-xs-12 no-padding"> GR Description : <textarea class="form-control" rows="3" v-model="description" style="width:310px"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-3 col-md-12 no-padding">
                                    <div class="col-md-3 col-xs-3 no-padding">Ship Date:</div>

                                    <div class="col-sm-12 col-lg-8 p-l-0 p-t-0 ">
                                        <input v-model="ship_date" autocomplete="off" type="text" class="form-control datepicker width100" name="ship_date" id="ship_date" placeholder="Ship Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="15%">Material Number</th>
                                                <th width="20%">Material Description</th>
                                                <th width="5%">Unit</th>
                                                <th width="20%">Quantity</th>
                                                <th width="20%">Received</th>
                                                <th width="10%">Received Date</th>
                                                <th width="15%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(WOD,index) in modelWOD" :id="getId(WOD.id)">
                                                <td>{{ index+1 }}</td>
                                                <td>{{ WOD.material_code }}</td>
                                                <td>{{ WOD.material_name }}</td>
                                                <td>{{ WOD.unit }}</td>
                                                <td>{{ WOD.quantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="WOD.received" placeholder="Please Input Received Quantity">
                                                </td>
                                                <td class="p-l-0 textLeft">
                                                    <input v-model="WOD.received_date" required autocomplete="off" type="text" class="form-control datepicker width100 received_date" name="input_received_date" :id="makeId(WOD.id)" placeholder="Received Date">  
                                                </td>
                                                <td class="p-l-5" align="center">
                                                    <a href="#" @click="removeRow(WOD.material_id)" class="btn btn-danger btn-xs">
                                                        <div class="btn-group">DELETE</div>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{newIndex}}</td>
                                                <td colspan="2" class="no-padding">
                                                    <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                        <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                    </selectize>    
                                                </td>
                                                <td class="no-padding">
                                                    <input class="form-control width100" v-model="input.unit" disabled>
                                                </td>
                                                <td class="no-padding">
                                                    <input class="form-control width100" disabled>
                                                </td>
                                                <td class="no-padding">
                                                    <input class="form-control width100" v-model="input.received" placeholder="Please Input Received Quantity">
                                                </td>
                                                <td class="p-l-0 textLeft">
                                                    <input v-model="input.received_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="input_received_date" id="input_received_date" placeholder="Received Date">  
                                                </td>
                                                <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                                    <div class="btn-group">
                                                        ADD
                                                    </div></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 p-t-10">
                                    <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                                </div>
                            </div>

                        </div>
                    @endverbatim
                </form>
        </div><!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-gr');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        modelWODs : @json($modelWODs),
        modelWO :   @json($modelWO),
        modelSloc : @json($modelSloc),
        modelWOD : [],  
        newIndex : 0, 
        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        description:"",
        submittedForm :{},
        materials : [],
        input: {
            material_id : "",
            received : 0,
            quantity : "",
            material_name : "",
            material_code : "",
            unit : "",
            received_date : "",
        },
        material_id:[],
        ship_date : "",
    }

    var vm = new Vue({
        el : '#wod',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
                format : "dd-mm-yyyy"

            });
            $("#ship_date").datepicker().on(
                "changeDate", () => {
                    this.ship_date = $('#ship_date').val();
                }
            );
            $("#input_received_date").datepicker().on(
                "changeDate", () => {
                    this.input.received_date = $('#input_received_date').val();
                }
            );
            $(".received_date").datepicker().on(
                "changeDate", () => {

                    this.modelWOD.forEach(WOD => { 
                        WOD.received_date = $('#datepicker'+WOD.id).val();
                    });
                }
            );
        },
        computed : {
            createOk: function(){
                let isOk = false;
                
                return isOk;
            },
            inputOk: function(){
                let isOk = false;

                var string_newValue = this.input.received+"";
                this.input.received = parseInt(string_newValue.replace(/,/g , ''));

                if(this.input.material_id == "" || this.input.received < 1){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods : {
            makeId(id){
                return "datepicker"+id;
            },
            getId: function(id){
                return id;
            },
            changeText(){
                if(document.getElementsByClassName('tooltip-inner')[0]!= undefined){
                    if(document.getElementsByClassName('tooltip-inner')[0].innerHTML != modelPO.vendor.address ){
                        document.getElementsByClassName('tooltip-inner')[0].innerHTML= modelPO.vendor.address;    
                    }
                }
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
            removeRow: function(materialId) {
                var index_materialId = "";
                var index_materialTable = "";

                for (var i in this.modelWOD) { 
                    if(this.modelWOD[i].material_id == materialId){
                        index_materialTable = i;
                    }
                }
                this.material_id.forEach(id => {
                    if(id == materialId){
                        index_materialId = this.material_id.indexOf(id);
                    }
                });

                this.modelWOD.splice(index_materialTable, 1);
                this.newIndex = this.modelWOD.length + 1;
                this.material_id.splice(index_materialId, 1);

                var jsonMaterialId = JSON.stringify(this.material_id);
                this.getNewMaterials(jsonMaterialId);
            },
            submitToTable(){
                if(this.input.material_id != "" && this.input.received != ""){

                    var material_id = this.input.material_id;

                    window.axios.get('/api/getMaterialGR/'+material_id).then(({ data }) => {
                        this.input.material_name = data.description;
                        this.input.material_code = data.code;

                        var data = JSON.stringify(this.input);
                        data = JSON.parse(data);
                        this.modelWOD.push(data);
                        var WOD = JSON.stringify(this.modelWOD);
                        this.modelWOD = [];

                        this.material_id.push(data.material_id); //ini buat nambahin material_id terpilih

                        var jsonMaterialId = JSON.stringify(this.material_id);
                        this.getNewMaterials(jsonMaterialId);             

                        this.newIndex = this.modelWOD.length + 1;  

                        this.input.material_id = "";
                        this.input.unit = "";
                        this.input.received_date = "";
                        this.input.received = 0;
                        WOD = JSON.parse(WOD);
                        this.modelWOD = WOD;
                    });

                }
            },
            submitForm(){
                var data = this.modelWOD;
                data = JSON.stringify(data)
                data = JSON.parse(data)

                data.forEach(POD => {
                    POD.quantity = POD.quantity.replace(/,/g , ''); 
                    POD.received = parseInt((POD.received+"").replace(/,/g , ''));     
                });

                this.submittedForm.POD = data;
                this.submittedForm.wo_id = this.modelWO.id;
                this.submittedForm.project_id = this.modelWO.project_id;
                this.submittedForm.description = this.description;
                this.submittedForm.ship_date = this.ship_date;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch: {
            'input.material_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getMaterialGR/'+newValue).then(({ data }) => {
                        this.input.unit = data.uom.unit;

                        $('div.overlay').hide();
                    })
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;

                        }
                        this.input.material_name = data.name;
                        this.input.material_code = data.code;
                    });
                }else{
                    this.input.description = "";
                }
            },
        },
        created: function(){
            var data = this.modelWODs;
            data.forEach(POD => {
                POD.received = parseInt(POD.quantity);
                POD.quantity = POD.received;
                POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                POD.received = (POD.received+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");     
                this.material_id.push(POD.material_id); //ini buat nambahin material_id terpilih

                var x = {};
                x.id = POD.id;
                x.material_id = POD.material_id;
                x.received = POD.received;
                x.quantity = POD.quantity;
                x.material_name = POD.material.description;
                x.material_code = POD.material.code;
                x.unit = POD.material.uom.unit;

                this.modelWOD.push(x);
            });

            var jsonMaterialId = JSON.stringify(this.material_id);
            this.getNewMaterials(jsonMaterialId);
            this.newIndex = this.modelWOD.length + 1;
        }
    });
</script>
@endpush
