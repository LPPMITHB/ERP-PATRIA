@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Goods Receipt Without Reference',
        'items' => [
            'Dashboard' => route('index'),
            'Create GR Without Reference' => '',
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
                @if($route == "/goods_receipt")
                    <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_receipt.storeWOR') }}">
                @elseif($route == "/goods_receipt_repair")
                    <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_receipt_repair.storeWOR') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="pod">
                            <div class="row p-l-0">
                                <div class="col-sm-4">
                                    <div class="col-sm-12 p-l-0">
                                        GR Description
                                    </div>
                                    <div class="col-sm-12 p-l-0">
                                        <textarea class="form-control" rows="3" v-model="description" style="width:326px"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-3 col-md-12">
                                        <div class="col-md-8 col-xs-12 p-l-0">Ship Date:</div>
                                        <div class="col-sm-12 col-lg-8  p-l-0">
                                            <input v-model="ship_date" autocomplete="off" type="text" class="form-control datepicker" name="ship_date" id="ship_date" placeholder="Ship Date" style="width: 180px">
                                        </div>
                                    </div>
                            </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <table class="table table-bordered table-hover" id="gr-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 17%">Material Number</th>
                                            <th style="width: 20%">Material Description</th>
                                            <th style="width: 5%">Unit</th>
                                            <th style="width: 10%">Quantity Received</th>
                                            <th style="width: 28%">Storage Location</th>
                                            <th style="width: 12%">Received Date</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis">{{ material.material_code }}</td>
                                            <td class="tdEllipsis">{{ material.material_name }}</td>
                                            <td class="tdEllipsis">{{ material.unit }}</td>
                                            <td class="tdEllipsis">{{ material.quantity }}</td>
                                            <td class="tdEllipsis">{{ material.sloc_name }}</td>
                                            <td class="tdEllipsis">{{ material.received_date }}</td>
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
                                            <td class="p-l-0 textLeft" colspan="2">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control width100" v-model="dataInput.unit" disabled>
                                            </td>
                                            <td class="p-l-0">
                                                <input :disabled="materialOk" class="form-control width100" v-model="dataInput.quantity" placeholder="Please Input Received Quantity">
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.sloc_id" :settings="slocSettings">
                                                    <option v-for="(sloc, index) in modelSloc" :value="sloc.id">{{ sloc.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <input v-model="dataInput.received_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="input_received_date" id="input_received_date" placeholder="Received Date">
                                            </td>
                                            <td class="p-l-0 textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 p-t-10">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">CREATE</button>
                            </div>
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
                                                        <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="unit" class="control-label">Unit</label>
                                                    <input type="text" id="unit" v-model="editInput.unit" class="form-control" disabled>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="quantity" class="control-label">Quantity</label>
                                                    <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="type" class="control-label">Storage Location</label>
                                                    <selectize id="edit_modal" v-model="editInput.sloc_id" :settings="slocSettings">
                                                        <option v-for="(sloc, index) in modelSloc" :value="sloc.id">{{sloc.code}} - {{sloc.name}}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="type" class="control-label">Received Date</label>
                                                    <input v-model="editInput.received_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="edit_received_date" id="edit_received_date" placeholder="Received Date">
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
        $('#gr-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });

    var data = {
        description : "",
        newIndex : "",
        materials : @json($modelMaterial),
        modelSloc : @json($modelSloc),
        project_id : "",
        materialSettings: {
            placeholder: 'Please Select Material'
        },

        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        description:"",
        dataMaterial : [],
        dataInput : {
            material_id :"",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityFloat : 0,
            sloc_id : "",
            sloc_name : "",
            received_date: "",
            unit:"",
            is_decimal : "",

        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityFloat : 0,
            sloc_id : "",
            sloc_name : "",
            received_date: "",
            unit:"",
            is_decimal : "",
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        submittedForm : {},
        ship_date: "",
    }

    var vm = new Vue({
        el : '#pod',
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
                    this.dataInput.received_date = $('#input_received_date').val();
                }
            );
            $("#edit_received_date").datepicker().on(
                "changeDate", () => {
                    this.editInput.received_date = $('#edit_received_date').val();
                }
            );
        },
        computed : {

            allOk: function(){
                let isOk = false;

                if(this.dataMaterial.length < 1){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;

                var string_newValue = this.dataInput.quantityFloat+"";
                this.dataInput.quantityFloat = parseFloat(string_newValue.replace(",", ''));

                if(this.dataInput.material_id == "" || this.dataInput.quantityFloat < 0 || this.dataInput.quantityFloat == 0 || this.dataInput.quantityFloat == "" || isNaN(this.dataInput.quantityFloat) || this.dataInput.sloc_id =="" || this.dataInput.received_date == ""){
                    isOk = true;
                }

                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityFloat+"";
                this.editInput.quantityFloat = parseFloat(string_newValue.replace(",", ''));

                if(this.editInput.material_id == "" ||  this.editInput.quantityFloat < 0|| this.editInput.quantityFloat == 0 || this.editInput.quantityFloat == "" || isNaN(this.editInput.quantityFloat)){
                    isOk = true;
                }

                return isOk;
            },
            materialOk: function(){
                let isOk = false;

                if(this.dataInput.material_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            materialEditOk: function(){
                let isOk = false;

                if(this.editInput.material_id == ""){
                    isOk = true;
                }

                return isOk;
            },
        },
        watch : {
            'dataInput.quantity': function(newValue){
                if(this.dataInput.is_decimal == 1){
                    var decimalReceived = (newValue+"").replace(/,/g, '').split('.');
                    if(decimalReceived[1] != undefined){
                        var maxDecimal = 2;
                        if((decimalReceived[1]+"").length > maxDecimal){
                            this.dataInput.quantity = (decimalReceived[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalReceived[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            this.dataInput.quantityFloat = this.dataInput.quantity.replace(',', '');
                        }else{
                            this.dataInput.quantity = (decimalReceived[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalReceived[1]+"").replace(/\D/g, "");
                            this.dataInput.quantityFloat = this.dataInput.quantity.replace(',', '');
                        }
                    }else{
                        this.dataInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        this.dataInput.quantityFloat = this.dataInput.quantity.replace(',', '');
                    }
                }else{
                    this.dataInput.quantity = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.dataInput.quantityFloat = this.dataInput.quantity.replace(',', '');
                }
            },
            'editInput.quantity': function(newValue){
                if(this.editInput.is_decimal == 1){
                    var decimalReceived = (newValue+"").replace(/,/g, '').split('.');
                    if(decimalReceived[1] != undefined){
                        var maxDecimal = 2;
                        if((decimalReceived[1]+"").length > maxDecimal){
                            this.editInput.quantity = (decimalReceived[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalReceived[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            this.editInput.quantityFloat = this.editInput.quantity.replace(',', '');
                        }else{
                            this.editInput.quantity = (decimalReceived[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalReceived[1]+"").replace(/\D/g, "");
                            this.editInput.quantityFloat = this.editInput.quantity.replace(',', '');
                        }
                    }else{
                        this.editInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        this.editInput.quantityFloat = this.editInput.quantity.replace(',', '');
                    }
                }else{
                    this.editInput.quantity = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.editInput.quantityFloat = this.editInput.quantity.replace(',', '');
                }
            },
            'dataInput.sloc_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getSlocGR/'+newValue).then(({ data }) => {
                        this.dataInput.sloc_name = data.name;
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
                    this.dataInput.sloc_id = "";
                }
            },
            'dataInput.material_id': function(newValue){
                if(newValue != ""){
                    this.dataInput.quantity = "";
                    this.materials.forEach(material => {
                        if(newValue == material.id){
                            this.dataInput.unit = material.uom.unit;
                            this.dataInput.is_decimal = material.uom.is_decimal;
                        }
                    });
                }
            },
            'editInput.material_id': function(newValue){
                if(newValue != ""){
                    if(newValue != this.editInput.old_material_id){
                        this.editInput.quantity = "";
                    }
                    this.materials.forEach(material => {
                        if(newValue == material.id){
                            this.editInput.unit = material.uom.unit;
                            this.editInput.is_decimal = material.uom.is_decimal;
                        }
                    });
                }
            },
        },
        methods : {

            submitForm(){
                this.dataMaterial.forEach(material => {
                    material.quantity = parseFloat((material.quantity+"").replace("," , ''));
                });
                this.submittedForm.materials = this.dataMaterial;
                this.submittedForm.description = this.description;
                this.submittedForm.ship_date = this.ship_date;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            update(old_material_id, new_material_id){
                var material = this.dataMaterial[this.editInput.index];
                material.quantityFloat = this.editInput.quantityFloat;
                material.quantity = this.editInput.quantity;
                material.material_id = new_material_id;
                material.sloc_id = this.editInput.sloc_id;
                material.unit = this.editInput.unit;

                window.axios.get('/api/getMaterialPR/'+new_material_id).then(({ data }) => {
                    material.material_name = data.description;
                    material.material_code = data.code;
                    material.received_date = this.editInput.received_date;

                        window.axios.get('/api/getSlocGR/'+this.editInput.sloc_id).then(({ data }) => {
                        material.sloc_name = data.name;
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
                this.editInput.is_decimal = data.is_decimal;
                this.editInput.quantity = data.quantity;
                this.editInput.sloc_id = data.sloc_id;
                this.editInput.sloc_name = data.sloc_name;
                this.editInput.received_date = data.received_date;
                this.editInput.index = index;

                var material_id = JSON.stringify(this.material_id);
                material_id = JSON.parse(material_id);


                this.material_id_modal.forEach(id => {
                    if(id == data.material_id){
                        var index = this.material_id_modal.indexOf(id);

                    }
                });
            },

            add(){
                var material_id = this.dataInput.material_id;
                $('div.overlay').show();
                window.axios.get('/api/getMaterialGR/'+material_id).then(({ data }) => {
                    // this.dataInput.unit = data.uom.unit;
                    this.dataInput.material_name = data.description;
                    this.dataInput.material_code = data.code;


                    var temp_data = JSON.stringify(this.dataInput);
                    temp_data = JSON.parse(temp_data);

                    this.dataMaterial.push(temp_data);

                    // this.material_id.push(temp_data.material_id);

                    this.dataInput.material_name = "";
                    this.dataInput.material_code = "";
                    this.dataInput.quantity = "";
                    this.dataInput.material_id = "";
                    this.dataInput.sloc_id = "";
                    this.dataInput.unit = "";
                    this.dataInput.sloc_name = "";
                    this.dataInput.received_date = "";

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
