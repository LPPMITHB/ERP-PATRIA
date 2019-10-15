@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Material Write Off » '.$modelMWO->number,
        'items' => [
            'Dashboard' => route('index'),
            'View All Material Write Off' => route('material_write_off.index'),
            'Edit Material Write Off' => ""
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/material_write_off")
                    <form id="create-mwo" class="form-horizontal" method="POST" action="{{ route('material_write_off.update',['id'=>$modelMWO->id]) }}">
                @else
                    <form id="create-mwo" class="form-horizontal" method="POST" action="{{ route('material_write_off_repair.update',['id'=>$modelMWO->id]) }}">
                @endif
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                @verbatim
                    <div id="mwo">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <label for="">Description</label>
                                    <textarea class="form-control" rows="3" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="box-body p-t-0">
                            <table id="cost-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 13%">Warehouse</th>
                                        <th style="width: 12%">S.Loc</th>
                                        <th style="width: 15%">Material Number</th>
                                        <th style="width: 15%">Material Description</th>
                                        <th style="width: 7%">Unit</th>
                                        <th style="width: 9%">Available</th>
                                        <th style="width: 12%">Amount / Unit</th>
                                        <th style="width: 7%">Write-Off Quantity</th>
                                        <th style="width: 12%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(material,index) in dataMaterial">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ material.warehouse_name }}</td>
                                        <td class="tdEllipsis">{{ material.sloc_name }}</td>
                                        <td class="tdEllipsis">{{ material.material_code }}</td>
                                        <td class="tdEllipsis">{{ material.material_name }}</td>
                                        <td class="tdEllipsis">{{ material.unit }}</td>
                                        <td class="tdEllipsis">{{ material.available }}</td>
                                        <td class="tdEllipsis">Rp.{{ material.amount }}</td>
                                        <td class="tdEllipsis">{{ material.quantity }}</td>

                                        <td class="p-l-0 p-r-0 p-b-0 textCenter">
                                            <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                                <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                                    <a class="btn btn-primary btn-xs col-xs-12" href="#edit_remark" @click="remarkModal(material,index)"
                                                        data-toggle="modal">
                                                        REMARK
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 p-l-5 p-r-5 p-b-0">
                                                <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                                    <a class="btn btn-primary btn-xs col-xs-12" @click="openEditModal(material,index)" data-toggle="modal"
                                                        href="#edit_item">
                                                        EDIT
                                                    </a>
                                                </div>
                                                <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                                    <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                        DELETE
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <div class="modal fade" id="edit_remark">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title">Input Remark</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label for="remark" class="control-label">Remark</label>
                                                        <textarea name="remark" id="remark" rows="3" v-model="editRemark.remark"
                                                            class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal"
                                                    @click.prevent="updateRemark">SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <tfoot>
                                    <td>{{ newIndex }}</td>
                                    <td class="p-l-0 textLeft no-padding">
                                        <selectize v-model="dataInput.warehouse_id" :settings="warehouseSettings">
                                            <option v-for="(warehouse,index) in warehouses" :value="warehouse.id">{{ warehouse.name }}</option>
                                        </selectize>
                                    </td>
                                    <td class="p-l-0 textLeft no-padding">
                                        <selectize id="sloc" v-model="dataInput.sloc_id" :settings="slocSettings">
                                            <option v-for="(sloc,index) in slocs" v-if="sloc.selected != true" :value="sloc.id">{{ sloc.name }}</option>
                                        </selectize>
                                    </td>
                                    <td colspan="2" class="p-l-0 textLeft no-padding">
                                        <selectize id="material" v-model="dataInput.material_id" :settings="materialSettings">
                                            <option v-for="(slocDetail,index) in slocDetails" v-if="slocDetail.selected != true" :value="slocDetail.material.id">{{ slocDetail.material.code }} - {{ slocDetail.material.description }}</option>
                                        </selectize>
                                    </td>
                                    <td class="no-padding">
                                        <input type="text" class="form-control" v-model="dataInput.unit" disabled>
                                    </td>
                                    <td class="tdEllipsis">
                                        {{ dataInput.available }}
                                    </td>
                                    <td class="tdEllipsis">
                                        Rp.{{ dataInput.amount }}
                                    </td>
                                    <td class="no-padding">
                                        <input type="text" class="form-control" v-model="dataInput.quantity">
                                    </td>
                                    <td class="p-l-0 textCenter">
                                        <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                    </td>
                                </tfoot>
                            </table><br>
                            <div class="col-md-12 no-padding">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">SAVE</button>
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
                                                <label for="type" class="control-label">Warehouse</label>
                                                <selectize v-model="editInput.warehouse_id" :settings="warehouseSettings" disabled>
                                                    <option v-for="(warehouse,index) in warehouses" :value="warehouse.id">{{ warehouse.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Storage Location</label>
                                                <selectize v-model="editInput.sloc_id" :settings="slocSettings" disabled>
                                                    <option v-for="(sloc,index) in slocs" :value="sloc.id">{{ sloc.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="materialedit" v-model="editInput.material_id" :settings="materialSettings" disabled>
                                                    <option v-for="(slocDetail,index) in slocDetails" :value="slocDetail.material.id">{{ slocDetail.material.code }} - {{ slocDetail.material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="available" class="control-label">Amount / Unit(Rp.)</label>
                                                <input type="text" v-model="editInput.amount" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="available" class="control-label">Available</label>
                                                <input type="text" v-model="editInput.available" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Write-Off Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endverbatim
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-mwo');

    $(document).ready(function() {
        $('div.overlay').hide();
    });

    var data = {
        description: @json($modelMWO -> description),
        slocDetails: [],
        newIndex: "",
        slocs: [],
        warehouses: @json($warehouseLocations),
        editRemark : {
            remark : "",
        },
        dataInput: {
            sloc_id: "",
            sloc_name: "",
            warehouse_name: "",
            warehouse_id: "",
            material_id: "",
            material_code: "",
            material_name: "",
            quantity: "",
            available: "",
            unit: "",
            is_decimal: "",
            amount: "",
        },
        editInput: {
            old_sloc_id: "",
            old_warehouse_id: "",
            sloc_id: "",
            sloc_name: "",
            warehouse_name: "",
            warehouse_id: "",
            material_id: "",
            material_code: "",
            material_name: "",
            quantity: "",
            available: "",
            old_material_id: "",
            unit: "",
            is_decimal: "",
            amount: "",
        },
        warehouseSettings: {
            placeholder: 'Please Select Warehouse'
        },
        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        dataMaterial: @json($materials),
        submittedForm: {},
        mwod_deleted: [],
    };

    var vm = new Vue({
        el: '#mwo',
        data: data,
        computed: {
            allOk: function() {
                let isOk = false;

                if (this.dataMaterial.length < 1) {
                    isOk = true;
                }

                return isOk;
            },
            createOk: function() {
                let isOk = false;

                if (this.dataInput.material_id == "" || this.dataInput.quantity == "") {
                    isOk = true;
                }

                return isOk;
            },
            updateOk: function() {
                let isOk = false;

                if (this.editInput.material_id == "" || this.editInput.quantity == "") {
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            add() {
                var material_id = this.dataInput.material_id;
                var sloc_id = this.dataInput.sloc_id;
                var warehouse_id = this.dataInput.warehouse_id;
                $('div.overlay').show();
                window.axios.get('/api/getMaterialsMWO/' + material_id).then(({ data }) => {
                    this.dataInput.material_name = data.description;
                    this.dataInput.material_code = data.code;

                    window.axios.get('/api/getSloc/' + sloc_id).then(({ data }) => {
                        this.dataInput.sloc_name = data.name;
                        this.dataInput.warehouse_name = data.warehouse.name;
                        var temp_data = JSON.stringify(this.dataInput);
                        temp_data = JSON.parse(temp_data);

                        this.dataMaterial.push(temp_data);

                        this.dataInput.material_id = "";
                        this.dataInput.material_name = "",
                        this.dataInput.material_code = "",
                        this.dataInput.quantity = "";
                        this.dataInput.amount = "";
                        this.dataInput.sloc_id = "";
                        this.dataInput.sloc_name = "";
                        this.dataInput.warehouse_id = "";
                        this.dataInput.warehouse_name = "";
                        this.dataInput.available = "";
                        this.dataInput.unit = "";
                        this.dataInput.is_decimal = "";
                        this.newIndex = Object.keys(this.dataMaterial).length + 1;

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
            update() {
                var material = this.dataMaterial[this.editInput.index];
                material.warehouse_id = this.editInput.warehouse_id;
                material.sloc_id = this.editInput.sloc_id;
                material.quantityInt = this.editInput.quantityInt;
                material.quantity = this.editInput.quantity;
                material.material_id = this.editInput.material_id;
                material.available = this.editInput.available;

                window.axios.get('/api/getMaterialsMWO/' + this.editInput.material_id).then(({ data }) => {
                    material.material_name = data.description;
                    material.material_code = data.code;
                    material.unit = data.uom.unit;
                    material.is_decimal = data.uom.is_decimal;

                    window.axios.get('/api/getSloc/' + this.editInput.sloc_id).then(({
                            data
                        }) => {
                            material.sloc_name = data.name;
                            material.warehouse_name = data.warehouse.name;
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
            submitForm() {
                this.dataMaterial.forEach(data => {
                    data.quantity = parseFloat(data.quantity.replace(/,/g , ''));
                    data.amount = parseFloat(data.amount.replace(/,/g , ''));
                });
                this.submittedForm.description = this.description;
                this.submittedForm.materials = this.dataMaterial;
                this.submittedForm.mwod_deleted = this.mwod_deleted;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },

            remarkModal(MWOD,index){
                this.editRemark.remark = MWOD.remark;
                this.editRemark.index = index;
            },

            updateRemark(){
                var mwod = this.dataMaterial[this.editRemark.index];
                mwod.remark = this.editRemark.remark;
            },

            openEditModal(mwod,index){
                // mengambil sloc pada warehouse tersebut
                window.axios.get('/api/getStorloc/'+mwod.warehouse_id).then(({ data }) => {
                    this.slocs = data;

                    window.axios.get('/api/getMaterialMWO/' + mwod.sloc_id).then(({ data }) => {
                        this.slocDetails = data;

                        this.editInput.material_id = mwod.material_id;
                        this.editInput.old_material_id = mwod.material_id;
                        this.editInput.material_code = mwod.material_code;
                        this.editInput.material_name = mwod.material_name;
                        this.editInput.quantity = mwod.quantity;
                        this.editInput.available = mwod.available;
                        this.editInput.sloc_id = mwod.sloc_id;
                        this.editInput.old_sloc_id = mwod.sloc_id;
                        this.editInput.sloc_name = mwod.sloc_name;
                        this.editInput.remark = mwod.remark;                        
                        this.editInput.old_warehouse_id = mwod.warehouse_id;
                        this.editInput.warehouse_id = mwod.warehouse_id;
                        this.editInput.warehouse_name = mwod.warehouse_name;
                        this.editInput.is_decimal = mwod.is_decimal;
                        this.editInput.unit = mwod.unit;
                        this.editInput.amount = mwod.amount;
                        this.editInput.index = index;

                        $('#edit_item').modal('show');
                        $('div.overlay').hide();
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
                    $('div.overlay').hide();
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
            removeRow(index) {
                this.mwod_deleted.push(this.dataMaterial[index].mwod_id);
                this.dataMaterial.splice(index, 1);

                this.newIndex = this.dataMaterial.length + 1;
            },
        },

        watch: {
            'dataInput.warehouse_id': function(newValue) {
                if (newValue != "") {
                    $('div.overlay').show();
                    this.dataInput.quantity = "";
                    this.dataInput.available = "";
                    this.dataInput.unit = "";
                    window.axios.get('/api/getStorloc/' + newValue).then(({ data }) => {
                        this.slocs = data;

                        this.slocDetails = "";
                        var $material = $(document.getElementById('material')).selectize();
                        var $slocs = $(document.getElementById('sloc')).selectize();
                        $slocs[0].selectize.focus();
                        $material[0].selectize.clear();
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
                    // mengosongkan inputan lain jika inputan warehouse dihapus
                    this.dataInput.quantity = "";
                    this.dataInput.available = "";
                    this.dataInput.unit = "";
                    this.dataInput.material_id = "";
                    this.dataInput.amount = "";
                    this.dataInput.sloc_id = "";
                    this.slocs = [];
                    this.slocDetails = [];
                }
            },
            'dataInput.sloc_id': function(newValue) {
                if (newValue != "") {
                    this.dataInput.quantity = "";
                    this.dataInput.available = "";
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialMWO/' + newValue).then(({ data }) => {
                        this.slocDetails = data;

                        this.dataMaterial.forEach(existing => {
                            if (existing.sloc_id == newValue) {
                                this.slocDetails.forEach(allMaterial => {
                                    if (existing.material_id == allMaterial.material_id) {
                                        allMaterial.selected = true;
                                    }
                                });
                            }
                        });

                        var $material = $(document.getElementById('material')).selectize();
                        $material[0].selectize.focus();
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
                    // mengosongkan inputan lain jika inputan storage location dihapus
                    this.dataInput.quantity = "";
                    this.dataInput.available = "";
                    this.dataInput.unit = "";
                    this.dataInput.material_id = "";
                    this.dataInput.amount = "";
                    this.slocDetails = [];
                }
            },
            'dataInput.material_id' : function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getMaterialsMWO/'+newValue).then(({ data }) => {
                        var is_decimal = data.uom.is_decimal;
                        this.dataInput.unit = data.uom.unit;
                        this.dataInput.is_decimal = data.uom.is_decimal;

                        this.dataInput.amount = 0;
                        var count = 0;
                        this.dataInput.available = 0;
                        this.slocDetails.forEach(element => {
                            if(element.storage_location_id == this.dataInput.sloc_id && this.dataInput.material_id == element.material_id){
                                this.dataInput.available += element.quantity;
                                this.dataInput.amount += element.value * element.quantity;
                                count += element.quantity;
                            }
                        });
                        if(is_decimal == 1){
                            var decimalReceived = (this.dataInput.available+"").replace(/,/g, '').split('.');
                            if(decimalReceived[1] != undefined){
                                var maxDecimal = 2;
                                if((decimalReceived[1]+"").length > maxDecimal){
                                    this.dataInput.quantity = (decimalReceived[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalReceived[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    this.dataInput.quantity = (decimalReceived[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimalReceived[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                this.dataInput.available = (this.dataInput.available+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        }else{
                            this.dataInput.available = (this.dataInput.available+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                        this.dataInput.amount = ((this.dataInput.amount / count).toFixed(0)+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        this.dataInput.quantity = "";
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
                    // mengosongkan inputan lain jika inputan material dihapus
                    this.dataInput.quantity = "";
                    this.dataInput.available = "";
                    this.dataInput.unit = "";
                    this.dataInput.material_id = "";
                    this.dataInput.amount = "";
                }
            },
            'dataInput.quantity': function(newValue) {
                if (newValue != "") {
                    var is_decimal = this.dataInput.is_decimal;
                    if (is_decimal == 0) {
                        this.dataInput.quantity = (this.dataInput.quantity + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    } else {
                        var decimal = newValue.replace(/,/g, '').split('.');
                        if (decimal[1] != undefined) {
                            var maxDecimal = 2;
                            if ((decimal[1] + "").length > maxDecimal) {
                                this.dataInput.quantity = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                            } else {
                                this.dataInput.quantity = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                            }
                        } else {
                            this.dataInput.quantity = (newValue + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }

                    if (parseFloat(this.dataInput.quantity.replace(/,/g, '')) > parseFloat(this.dataInput.available.replace(/,/g, ''))) {
                        iziToast.warning({
                            title: 'Cannot insert more than available quantity !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });

                        this.dataInput.quantity = this.dataInput.available;
                    }
                }
            },
            'editInput.quantity': function(newValue) {
                if (newValue != "") {
                    var is_decimal = this.editInput.is_decimal;
                    if (is_decimal == 0) {
                        this.editInput.quantity = (this.editInput.quantity + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    } else {
                        var decimal = newValue.replace(/,/g, '').split('.');
                        if (decimal[1] != undefined) {
                            var maxDecimal = 2;
                            if ((decimal[1] + "").length > maxDecimal) {
                                this.editInput.quantity = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                            } else {
                                this.editInput.quantity = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                            }
                        } else {
                            this.editInput.quantity = (newValue + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }

                    if (parseFloat(this.editInput.quantity.replace(/,/g, '')) > parseFloat(this.editInput.available.replace(/,/g, ''))) {
                        iziToast.warning({
                            title: 'Cannot insert more than available quantity !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });

                        this.editInput.quantity = this.editInput.available;
                    }
                }
            },
            // 'editInput.sloc_id': function(newValue) {
            //     if (newValue != "") {
            //         $('div.overlay').show();
            //         window.axios.get('/api/getMaterialMWO/' + newValue).then(({
            //                 data
            //             }) => {
            //                 this.slocDetails = data;

            //                 var $material = $(document.getElementById('materialedit')).selectize();
            //                 if (this.editInput.old_sloc_id != newValue) {
            //                     this.editInput.quantity = "";
            //                     this.editInput.available = "";
            //                     this.editInput.material_id = "";
            //                 }

            //                 $('#edit_item').modal();
            //                 $('div.overlay').hide();
            //             })
            //             .catch((error) => {
            //                 iziToast.warning({
            //                     title: 'Please Try Again..',
            //                     position: 'topRight',
            //                     displayMode: 'replace'
            //                 });
            //                 $('div.overlay').hide();
            //             })
            //     }
            // },
            // 'editInput.material_id': function(newValue) {
            //     if (newValue != "") {
            //         this.slocDetails.forEach(element => {
            //             if (element.storage_location_id == this.editInput.sloc_id && this.editInput.material_id == element.material_id) {
            //                 this.editInput.available = element.quantity;
            //                 this.editInput.unit = element.material.uom.unit;
            //                 this.editInput.is_decimal = element.material.uom.is_decimal;
            //                 this.editInput.available = (this.editInput.available + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            //             }
            //         });
            //         if (this.editInput.old_material_id != newValue) {
            //             this.editInput.quantity = "";
            //         }
            //     }
            // },
        },
        created: function() {
            this.newIndex = Object.keys(this.dataMaterial).length + 1;
            this.dataMaterial.forEach(data=>{
                data.amount = (data.amount + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                data.available = (data.available + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                data.quantity = (data.quantity + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            })
        },
    });
</script>
@endpush
