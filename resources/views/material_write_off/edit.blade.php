@extends('layouts.main')
@section('content-header')
@breadcrumb(
[
'title' => 'Edit Material Write Off',
'items' => [
'Dashboard' => route('index'),
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
                <form id="create-mwo" class="form-horizontal" method="POST" action="{{ route('material_write_off.update',['id'=>$modelGI->id]) }}">
                    @else
                    <form id="create-mwo" class="form-horizontal" method="POST" action="{{ route('material_write_off_repair.update',['id'=>$modelGI->id]) }}">
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
                            </div><br>
                            <div class="box-body p-t-0">
                                <table id="cost-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">Werehouse</th>
                                            <th style="width: 15%">Storage Location</th>
                                            <th style="width: 20%">Material Number</th>
                                            <th style="width: 20%">Material Description</th>
                                            <th style="width: 10%">Unit</th>
                                            <th style="width: 10%">Available</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis">{{ material.werehouse_name }}</td>
                                            <td class="tdEllipsis">{{ material.sloc_name }}</td>
                                            <td class="tdEllipsis">{{ material.material_code }}</td>
                                            <td class="tdEllipsis">{{ material.material_name }}</td>
                                            <td class="tdEllipsis">{{ material.unit }}</td>
                                            <td class="tdEllipsis">{{ material.available }}</td>
                                            <td class="tdEllipsis">{{ material.quantity }}</td>
                                            <td class="p-l-3 textCenter">
                                                <a class="btn btn-primary btn-xs" @click="openEditModal(material,index)">
                                                    EDIT
                                                </a>
                                                <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td>{{ newIndex }}</td>
                                        <td class="p-l-0 textLeft no-padding">
                                            <selectize v-model="dataInput.werehouse_id" :settings="werehouseSettings">
                                                <option v-for="(werehouse,index) in werehouses" :value="werehouse.id">{{ werehouse.name }}</option>
                                            </selectize>
                                        </td>
                                        <!-- <td class="p-l-0 textLeft no-padding">
                                        <selectize v-model="dataInput.sloc_id" :settings="slocSettings">
                                            <option v-for="(sloc,index) in slocs" :value="sloc.id">{{ sloc.name }}</option>
                                        </selectize>
                                    </td> -->
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
                                        <td>
                                            {{ dataInput.available }}
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
                                                    <selectize v-model="dataInput.werehouse_id" :settings="werehouseSettings">
                                                        <option v-for="(werehouse,index) in werehouses" :value="werehouse.id">{{ werehouse.name }}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="type" class="control-label">Storage Location</label>
                                                    <selectize v-model="editInput.sloc_id" :settings="slocSettings">
                                                        <option v-for="(sloc,index) in slocs" :value="sloc.id">{{ sloc.name }}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="type" class="control-label">Material</label>
                                                    <selectize id="materialedit" v-model="editInput.material_id" :settings="materialSettings">
                                                        <option v-for="(slocDetail,index) in slocDetails" :value="slocDetail.material.id">{{ slocDetail.material.code }} - {{ slocDetail.material.description }}</option>
                                                    </selectize>
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
                                                    <label for="quantity" class="control-label">Quantity</label>
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

            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
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
        description: @json($modelGI -> description),
        slocDetails: [],
        newIndex: "",
        // slocs : @json($storageLocations),
        slocs: [],
        werehouses: @json($warehouseLocations),
        dataInput: {
            sloc_id: "",
            sloc_name: "",
            werehouse_name: "",
            werehouse_id: "",
            material_id: "",
            material_code: "",
            material_name: "",
            quantity: "",
            available: "",
            unit: "",
            is_decimal: "",
        },

        editInput: {
            old_sloc_id: "",
            old_werehouse_id: "",
            sloc_id: "",
            sloc_name: "",
            werehouse_name: "",
            werehouse_id: "",
            material_id: "",
            material_code: "",
            material_name: "",
            quantity: "",
            available: "",
            old_material_id: "",
            unit: "",
            is_decimal: "",
        },

        werehouseSettings: {
            placeholder: 'Please Select Werehouse'
        },
        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },

        materialSettings: {
            placeholder: 'Please Select Material'
        },

        dataMaterial: @json($materials),
        submittedForm: {},
        gid_deleted: [],

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
                var werehouse_id = this.dataInput.werehouse_id;
                $('div.overlay').show();
                window.axios.get('/api/getMaterialsMWO/' + material_id).then(({
                        data
                    }) => {

                        this.dataInput.material_name = data.description;
                        this.dataInput.material_code = data.code;

                        window.axios.get('/api/getSloc/' + sloc_id).then(({
                                data
                            }) => {

                                this.dataInput.sloc_name = data.name;
                                this.dataInput.werehouse_name = data.warehouse.name;
                                var temp_data = JSON.stringify(this.dataInput);
                                temp_data = JSON.parse(temp_data);

                                this.dataMaterial.push(temp_data);

                                this.dataInput.material_id = "";
                                this.dataInput.material_name = "",
                                this.dataInput.material_code = "",
                                this.dataInput.quantity = "";
                                this.dataInput.sloc_id = "";
                                this.dataInput.sloc_name = "";
                                this.dataInput.werehouse_id = "";
                                this.dataInput.werehouse_name = "";
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
                material.werehouse_id = this.editInput.werehouse_id;
                material.sloc_id = this.editInput.sloc_id;
                material.quantityInt = this.editInput.quantityInt;
                material.quantity = this.editInput.quantity;
                material.material_id = this.editInput.material_id;
                material.available = this.editInput.available;

                window.axios.get('/api/getMaterialsMWO/' + this.editInput.material_id).then(({
                        data
                    }) => {
                        material.material_name = data.description;
                        material.material_code = data.code;
                        material.unit = data.uom.unit;
                        material.is_decimal = data.uom.is_decimal;

                        window.axios.get('/api/getSloc/' + this.editInput.sloc_id).then(({
                                data
                            }) => {
                                material.sloc_name = data.name;
                                material.werehouse_name = data.warehouse.name;
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
                this.submittedForm.description = this.description;
                this.submittedForm.materials = this.dataMaterial;
                this.submittedForm.gid_deleted = this.gid_deleted;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();

            },

            openEditModal(data, index) {
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.quantity = data.quantity;
                this.editInput.unit = data.unit;
                this.editInput.is_decimal = data.is_decimal;
                this.editInput.available = data.available;
                this.editInput.sloc_id = data.sloc_id;
                this.editInput.old_sloc_id = data.sloc_id;
                this.editInput.sloc_name = data.sloc_name;
                this.editInput.old_warehouse_id = data.werehouse_id;
                this.editInput.werehouse_name = data.werehouse_name;
                this.editInput.index = index;

            },

            removeRow(index) {
                this.gid_deleted.push(this.dataMaterial[index].gid_id);
                this.dataMaterial.splice(index, 1);

                this.newIndex = this.dataMaterial.length + 1;
            },

        },

        watch: {
            'dataInput.werehouse_id': function(newValue) {
                if (newValue != "") {
                    $('div.overlay').show();
                    this.dataInput.quantity = "";
                    this.dataInput.available = "";
                    this.dataInput.unit = "";
                    window.axios.get('/api/getStorloc/' + newValue).then(({
                            data
                        }) => {
                            this.slocs = data;

                            this.slocDetails = "";
                            this.slocs.forEach(existing => {
                                if (existing.werehouse_id == newValue) {
                                    this.sloc.forEach(allSloc => {
                                        if (existing.sloc_id == allSloc.sloc_id) {
                                            allSloc.selected = true;
                                        }
                                    });
                                }
                            });
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
                }
            },
            'dataInput.sloc_id': function(newValue) {
                if (newValue != "") {
                    this.dataInput.quantity = "";
                    this.dataInput.available = "";
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialMWO/' + newValue).then(({
                            data
                        }) => {
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
                }
            },
            'editInput.sloc_id': function(newValue) {
                if (newValue != "") {
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialMWO/' + newValue).then(({
                            data
                        }) => {
                            this.slocDetails = data;

                            var $material = $(document.getElementById('materialedit')).selectize();
                            if (this.editInput.old_sloc_id != newValue) {
                                this.editInput.quantity = "";
                                this.editInput.available = "";
                                this.editInput.material_id = "";
                            }

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
                } else {

                }
            },
            'dataInput.material_id': function(newValue) {
                if (newValue != "") {
                    this.slocDetails.forEach(element => {
                        if (element.storage_location_id == this.dataInput.sloc_id && this.dataInput.material_id == element.material_id) {
                            this.dataInput.available = element.quantity;
                            this.dataInput.unit = element.material.uom.unit;
                            this.dataInput.is_decimal = element.material.uom.is_decimal;
                            this.dataInput.available = (this.dataInput.available + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    });
                    this.dataInput.quantity = "";
                }
            },
            'editInput.material_id': function(newValue) {
                if (newValue != "") {
                    this.slocDetails.forEach(element => {
                        if (element.storage_location_id == this.editInput.sloc_id && this.editInput.material_id == element.material_id) {
                            this.editInput.available = element.quantity;
                            this.editInput.unit = element.material.uom.unit;
                            this.editInput.is_decimal = element.material.uom.is_decimal;
                            this.editInput.available = (this.editInput.available + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    });
                    if (this.editInput.old_material_id != newValue) {
                        this.editInput.quantity = "";
                    }
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
        },
        created: function() {
            this.newIndex = Object.keys(this.dataMaterial).length + 1;
        },
    });
</script>
@endpush