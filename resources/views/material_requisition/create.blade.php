@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Material Requisition',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Create Material Requisition' => route('material_requisition.create'),
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
                @if($menu == 'building')
                    <form id="create-mr" class="form-horizontal" method="POST" action="{{ route('material_requisition.store') }}">
                @else
                    <form id="create-mr" class="form-horizontal" method="POST" action="{{ route('material_requisition_repair.store') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="mr">
                        <div class="box-header no-padding">
                            <div class="col-xs-12 col-md-4" v-show="project_id != ''">
                                <div class="col-sm-12 no-padding"><b>Project Information</b></div>

                                <div class="col-xs-5 no-padding">Project Number</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject.length > 0 ? selectedProject[0].number : "-"}}</b></div>

                                <div class="col-xs-5 no-padding">Ship Type</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject.length > 0 ? selectedProject[0].ship.type : "-"}}</b></div>

                                <div class="col-xs-5 no-padding">Customer</div>
                                <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="tooltip(selectedProject.length > 0 ? selectedProject[0].customer.name: '-')"><b>: {{selectedProject.length > 0 ? selectedProject[0].customer.name: '-'}}</b></div>

                                <div class="col-xs-5 no-padding">Start Date</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject.length > 0 ? selectedProject[0].planned_start_date : "-"}}</b></div>

                                <div class="col-xs-5 no-padding">End Date</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject.length > 0 ? selectedProject[0].planned_end_date : "-"}}</b></div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <label for="" >Project Name</label>
                                <selectize v-model="project_id" :settings="projectSettings" :disabled="dataOk">
                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.name }}</option>
                                </selectize>
                            </div>
                            <div class="col-xs-12 col-md-4" v-show="project_id != ''">
                                <label for="" >Delivery Date</label>
                                <div class="form-group">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" v-model="delivery_date" type="text" class="form-control datepicker" name="delivery_date" id="delivery_date" placeholder="Delivery Date">
                                        </div>
                                    </div>
                            </div>
                            <div class="col-xs-12 col-md-4 p-r-0" v-show="project_id != ''">
                                <div class="col-sm-12 p-l-0">
                                    <label for="">MR Description</label>
                                </div>
                                <div class="col-sm-12 p-l-0">
                                    <textarea class="form-control" rows="3" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-show="project_id != ''">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 23%" v-show="selectedProject.length > 0">WBS Name</th>
                                            <th style="width: 38%">Material Name</th>
                                            <th style="width: 15%" v-show="selectedProject.length > 0">Planned Quantity (BOM)</th>
                                            <th style="width: 12%">Available Quantity</th>
                                            <th style="width: 12%">Request Quantity</th>
                                            <th style="width: 6%">Unit</th>
                                            <th style="width: 13%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis" v-show="selectedProject.length > 0">{{ material.wbs_number }} - {{ material.wbs_description }}</td>
                                            <td class="tdEllipsis">{{ material.material_code }} - {{ material.material_description }}</td>
                                            <td class="tdEllipsis" v-show="selectedProject.length > 0">{{ material.planned_quantity }}</td>
                                            <td class="tdEllipsis">{{ material.availableStr }}</td>
                                            <td class="tdEllipsis">{{ material.quantity }}</td>
                                            <td class="tdEllipsis">{{ material.unit }}</td>
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

                                            <td class="p-l-0 textLeft" v-show="wbss.length > 0 && selectedProject.length > 0 ">
                                                <selectize class="selectizeFull" v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="wbss.length == 0 && selectedProject.length > 0">
                                                <selectize disabled v-model="dataInput.wbs_id" :settings="wbsNullSettings">
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.wbs_id == '' && selectedProject.length > 0">
                                                <selectize disabled v-model="dataInput.id" :settings="nullSettings" disabled>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.wbs_id != '' && materials.length == 0 && selectedProject.length > 0">
                                                <selectize disabled v-model="dataInput.material_id" :settings="materialNullSettings">
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.wbs_id != '' && materials.length > 0 && selectedProject.length > 0">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="selectedProject.length == 0">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in all_materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0" v-show="selectedProject.length > 0">
                                                <input disabled class="form-control" v-model="dataInput.planned_quantity" placeholder="">
                                            </td>
                                            <td class="p-l-0">
                                                <input disabled class="form-control" v-model="dataInput.availableStr" placeholder="">
                                            </td>
                                            <td class="p-l-0">
                                                <input :disabled="materialOk" class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="p-l-0">
                                                <input disabled class="form-control" v-model="dataInput.unit" placeholder="">
                                            </td>

                                            <td class="p-l-0 textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 p-r-0 p-t-10">
                            <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">CREATE</button>
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
                                            <div class="col-sm-12" v-show="selectedProject.length > 0">
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.wbs_id != '' && materialsEdit.length > 0 && selectedProject.length > 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materialsEdit" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.wbs_id != '' && materialsEdit.length == 0 && selectedProject.length > 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize disabled :settings="materialNullSettings" >
                                                </selectize>
                                            </div>
                                            <div class="col-sm-9" v-show="editInput.wbs_id == '' && selectedProject.length > 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize disabled :settings="nullSettings" disabled >
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="selectedProject.length == 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in all_materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-9" v-show="selectedProject.length > 0">
                                                <label for="planned_quantity" class="control-label">Planned Quantity (BOM)</label>
                                                <input disabled type="text" id="planned_quantity" v-model="editInput.planned_quantity" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-sm-3 m-t-25" v-show="selectedProject.length > 0">
                                                <input disabled type="text" id="unit" v-model="editInput.unit" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-sm-9">
                                                <label for="available" class="control-label">Available Quantity</label>
                                                <input disabled type="text" id="available" v-model="editInput.availableStr" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-sm-3 m-t-25">
                                                <input disabled type="text" id="unit" v-model="editInput.unit" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-sm-9">
                                                <label for="quantity" class="control-label">Request Quantity</label>
                                                <input :disabled="materialEditOk" type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-3 m-t-25">
                                                <input disabled type="text" id="unit" v-model="editInput.unit" class="form-control" placeholder="">
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
    const form = document.querySelector('form#create-mr');

    $(document).ready(function(){
        $('div.overlay').hide();
    });



    var data = {
        stocks : @json($stocks),
        description : "",
        delivery_date: "",
        newIndex : "",
        all_materials : @json($all_materials),
        materials : [],
        materialsEdit : [],
        projects : @json($modelProject),
        wbss : [],
        project_id : "",
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        wbsSettings: {
            placeholder: 'Please Select WBS'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        nullSettings:{
            placeholder: 'Please Select WBS First !'
        },
        wbsNullSettings:{
            placeholder: "Project doesn't have WBS !"
        },
        materialNullSettings:{
            placeholder: "WBS doesn't have BOM !"
        },
        selectedProject : [],
        dataMaterial : [],
        dataInput : {
            material_id :"",
            material_code : "",
            material_description : "",
            quantity : "",
            quantityFloat : 0,
            wbs_id : "",
            wbs_number : "",
            wbs_description : "",
            planned_quantity: "",
            available: "",
            availableStr: "",
            is_decimal: "",
            unit : "",
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_description : "",
            quantity : "",
            quantityFloat : 0,
            wbs_id : "",
            old_wbs_id : "",
            wbs_number : "",
            wbs_description : "",
            planned_quantity: "",
            available: "",
            availableStr: "",
            index: "",
            is_decimal: "",
            unit : "",
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        submittedForm : {}
    }
    var vm = new Vue({
        el : '#mr',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
                format : "dd-mm-yyyy"
            });
            $("#delivery_date").datepicker().on(
                "changeDate", () => {
                    this.delivery_date = $('#delivery_date').val();
                }
            );
        },
        computed : {
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
            dataOk: function(){
                let isOk = false;

                if(this.dataMaterial.length > 0){
                    isOk = true;
                }

                return isOk;
            },
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
                this.dataInput.quantityFloat = parseFloat(string_newValue.replace(/,/g , ''));

                if(this.dataInput.material_id == "" || this.dataInput.quantityFloat < 0 || this.dataInput.quantityFloat == 0 || this.dataInput.quantityFloat == "" || isNaN(this.dataInput.quantityFloat)){
                    isOk = true;
                }

                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityFloat+"";
                this.editInput.quantityFloat = parseFloat(string_newValue.replace(/,/g , ''));

                if(this.editInput.material_id == "" || this.editInput.quantityFloat < 0 || this.editInput.quantityFloat == 0 || this.editInput.quantityFloat == "" || isNaN(this.editInput.quantityFloat)){
                    isOk = true;
                }

                return isOk;
            },
        },
        methods : {
            tooltip(text){
                Vue.directive('tooltip', function(el, binding){
                    $(el).tooltip('destroy');
                    $(el).tooltip({
                        title: text,
                        placement: binding.arg,
                        trigger: 'hover'
                    })
                })
                return text
            },
            submitForm(){
                $('div.overlay').show();
                this.submittedForm.description = this.description;
                this.submittedForm.delivery_date = this.delivery_date;
                this.submittedForm.project_id = this.project_id;
                this.submittedForm.materials = this.dataMaterial;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            update(old_material_id, new_material_id){
                $('div.overlay').show();
                this.dataInput.material_description = "";
                this.dataInput.material_code = "";
                this.dataInput.quantity = "";
                this.dataInput.planned_quantity = "";
                this.dataInput.available = "";
                this.dataInput.material_id = "";
                this.dataInput.wbs_id = "";
                this.dataInput.wbs_number = "";

                var material = this.dataMaterial[this.editInput.index];
                material.quantityFloat = this.editInput.quantityFloat;
                material.quantity = this.editInput.quantity;
                material.planned_quantity = this.editInput.planned_quantity;
                material.material_id = new_material_id;
                material.wbs_id = this.editInput.wbs_id;
                material.available = this.editInput.available;
                material.availableStr = this.editInput.availableStr;
                material.unit = this.editInput.unit;

                if(old_material_id != new_material_id){
                    this.stocks.forEach(stock => {
                        if(old_material_id == stock.material_id){
                            stock.available = stock.quantity - stock.reserved;
                        }

                        if(new_material_id == stock.material_id){
                            stock.available -= this.editInput.quantityFloat;
                        }
                    });
                }else{
                    var diff = this.editInput.available - this.editInput.quantityFloat;
                    this.stocks.forEach(stock => {
                        if(new_material_id == stock.material_id){
                            stock.available = diff;
                        }
                    });
                }

                window.axios.get('/api/getMaterialMR/'+new_material_id).then(({ data }) => {
                    material.material_description = data.description;
                    material.material_code = data.code;

                    window.axios.get('/api/getWbsMR/'+this.editInput.wbs_id).then(({ data }) => {
                        material.wbs_number = data.wbs.number;
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
                });
            },
            openEditModal(data,index){
                this.editInput.index = index;
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_description = data.material_description;
                this.editInput.old_wbs_id = data.wbs_id;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_number = data.wbs_number;
                this.editInput.is_decimal = data.is_decimal;
                this.editInput.unit = data.unit;
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
                var quantity = this.dataInput.quantityFloat;

                $('div.overlay').show();


                window.axios.get('/api/getMaterialPR/'+material_id).then(({ data }) => {
                    this.dataInput.material_description = data.description;
                    this.dataInput.material_code = data.code;

                    var temp_data = JSON.stringify(this.dataInput);
                    temp_data = JSON.parse(temp_data);

                    this.dataMaterial.push(temp_data);

                    this.stocks.forEach(stock => {
                        if(stock.material_id == this.dataInput.material_id){
                            stock.available -= this.dataInput.quantityFloat;
                        }
                    });

                    this.dataInput.material_description = "";
                    this.dataInput.material_code = "";
                    this.dataInput.quantity = "";
                    this.dataInput.planned_quantity = "";
                    this.dataInput.available = "";
                    this.dataInput.material_id = "";
                    this.dataInput.wbs_id = "";
                    this.dataInput.wbs_number = "";
                    this.dataInput.unit = "";
                    this.dataInput.is_decimal = "";

                    this.newIndex = Object.keys(this.dataMaterial).length+1;
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
                var material_id = this.dataMaterial[index].material_id;
                this.stocks.forEach(stock => {
                    if(stock.material_id == material_id){
                        stock.available = stock.quantity - stock.reserved;
                    }
                });

                this.dataMaterial.splice(index, 1);
                this.newIndex = this.dataMaterial.length + 1;
            }
        },
        watch : {
            'project_id' : function(newValue){
                this.dataInput.wbs_id = "";
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getProjectMR/'+newValue).then(({ data }) => {
                        this.selectedProject = [];
                        this.selectedProject.push(data);
                        this.selectedProject.forEach(data => {
                            var date_planned = data.planned_start_date;
                            var date_ended = data.planned_end_date;

                            data.planned_start_date = date_planned.split("-").reverse().join("-");
                            data.planned_end_date = date_ended.split("-").reverse().join("-");
                        });
                        this.wbss = data.wbss;
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
                    this.selectedProject = [];
                }
            },
            'dataInput.quantity': function(newValue){
                if(newValue != ""){
                    var temp = parseFloat((newValue+"").replace(",", ""));
                    this.dataInput.quantityFloat = temp;

                    if(this.dataInput.is_decimal){
                        var decimal = (newValue+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            this.dataInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }else{
                        this.dataInput.quantity = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                }
            },
            'dataInput.quantityFloat' : function(newValue){
                var qty = "";
                var temp = newValue;
                console.log(newValue);
                console.log(this.dataInput.available);
                if(temp > this.dataInput.available){
                    iziToast.warning({
                        title: 'There is no available stock for this material',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    qty = this.dataInput.available;
                }else{
                    qty = temp;
                }
                this.dataInput.quantity = qty+"";
            },
            'editInput.quantity': function(newValue){
                if(newValue != ""){
                    var temp = parseFloat((newValue+"").replace(",", ""));
                    this.editInput.quantityFloat = temp;

                    if(this.editInput.is_decimal){
                        var decimal = (newValue+"").replace(/,/g, '').split('.');
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
                    }else{
                        this.editInput.quantity = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                }
            },
            'editInput.quantityFloat' : function(newValue){
                var qty = "";
                var temp = newValue;
                if(temp > this.editInput.available){
                    iziToast.warning({
                        title: 'There is no available stock for this material',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    qty = this.editInput.available;
                }else{
                    qty = temp;
                }
                this.editInput.quantity = qty+"";
            },
            'dataInput.available':function(newValue){
                if(this.dataInput.is_decimal){
                    var decimal = (newValue+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.dataInput.availableStr = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.dataInput.availableStr = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.dataInput.availableStr = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }else{
                    this.dataInput.availableStr = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }

            },
            'editInput.available':function(newValue){
                if(this.editInput.is_decimal){
                    var decimal = (newValue+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.editInput.availableStr = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.editInput.availableStr = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.editInput.availableStr = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }else{
                    this.editInput.availableStr = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            },
            'dataInput.wbs_id': function(newValue){
                this.dataInput.material_id = "";
                this.dataInput.planned_quantity = "";
                this.dataInput.available = "";
                this.dataInput.availableStr = "";
                this.dataInput.quantity = "";
                this.dataInput.quantityFloat = "";
                this.dataInput.unit = "";
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsMR/'+newValue).then(({ data }) => {
                        this.dataInput.wbs_description = data.wbs.description;
                        this.dataInput.wbs_number = data.wbs.number;
                        this.materials = data.materials;
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
                    this.dataInput.wbs_id = "";
                }
            },
            'editInput.wbs_id': function(newValue){
                if(this.editInput.old_wbs_id != newValue){
                    this.editInput.material_id = "";
                    this.editInput.planned_quantity = "";
                    this.editInput.quantity = "";
                    this.editInput.quantityFloat = "";
                    this.editInput.available = "";
                    this.editInput.availableStr = "";
                    this.editInput.unit = "";
                    this.editInput.old_wbs_id = null;
                }

                if(this.editInput.old_wbs_id == null){
                    this.editInput.material_id = "";
                    this.editInput.planned_quantity = "";
                    this.editInput.quantity = "";
                    this.editInput.quantityFloat = "";
                    this.editInput.available = "";
                    this.editInput.availableStr = "";
                    this.editInput.quantityFloat = "";
                    this.editInput.unit = "";
                }

                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsMR/'+newValue).then(({ data }) => {
                        this.materialsEdit = data.materials;
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
                    this.dataInput.wbs_id = "";
                }
            },
            'dataInput.material_id' : function(newValue){
                if(newValue != ""){
                    if(this.selectedProject.length > 0){
                        this.dataInput.quantity = "";
                        $('div.overlay').show();
                        window.axios.get('/api/getMaterialInfoAPI/'+newValue+"/"+this.dataInput.wbs_id).then(({ data }) => {
                            // this.dataInput.available = data['available'];
                            this.dataInput.is_decimal = data['is_decimal'];
                            this.dataInput.unit = data['unit'];
                            if(this.dataInput.is_decimal){
                                var decimal = (data['planned_quantity']+"").replace(/,/g, '').split('.');
                                if(decimal[1] != undefined){
                                    var maxDecimal = 2;
                                    if((decimal[1]+"").length > maxDecimal){
                                        this.dataInput.planned_quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                    }else{
                                        this.dataInput.planned_quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                    }
                                }else{
                                    this.dataInput.planned_quantity = (data['planned_quantity']+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }else{
                                this.dataInput.planned_quantity = ((data['planned_quantity']+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            }

                            this.stocks.forEach(stock => {
                                if(stock.material_id == newValue){
                                    if(stock.available < 0){
                                        this.dataInput.material_id = "";
                                        iziToast.warning({
                                            title: 'There are no available stock for this material..',
                                            position: 'topRight',
                                            displayMode: 'replace'
                                        });
                                    }else{
                                        this.dataInput.available = stock.available+data['planned_quantity'];
                                    }
                                }
                            });
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
                        this.dataInput.quantity = "";
                        $('div.overlay').show();
                        window.axios.get('/api/getMaterialInfoWithoutProjectAPI/'+newValue).then(({ data }) => {
                            this.dataInput.is_decimal = data['is_decimal'];
                            this.dataInput.unit = data['unit'];

                            this.stocks.forEach(stock => {
                                if(stock.material_id == newValue){
                                    this.dataInput.available = stock.available;
                                }
                            });
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
                }
            },
            'editInput.material_id' : function(newValue){
                if(newValue != ""){
                    if(this.selectedProject.length > 0){
                        $('div.overlay').show();
                        window.axios.get('/api/getMaterialInfoAPI/'+newValue+'/'+this.editInput.wbs_id).then(({ data }) => {
                            // this.editInput.available = data['available'];
                            this.editInput.is_decimal = data['is_decimal'];
                            this.editInput.unit = data['unit'];
                            if(this.editInput.is_decimal){
                                var decimal = (data['planned_quantity']+"").replace(/,/g, '').split('.');
                                if(decimal[1] != undefined){
                                    var maxDecimal = 2;
                                    if((decimal[1]+"").length > maxDecimal){
                                        this.editInput.planned_quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                    }else{
                                        this.editInput.planned_quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                    }
                                }else{
                                    this.editInput.planned_quantity = (data['planned_quantity']+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }else{
                                this.editInput.planned_quantity = ((data['planned_quantity']+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            }

                            if(newValue != this.editInput.old_material_id){
                                this.stocks.forEach(stock => {
                                    if(stock.material_id == newValue){
                                        if(stock.available < 0){
                                            this.editInput.material_id = "";
                                            iziToast.warning({
                                                title: 'There are no available stock for this material..',
                                                position: 'topRight',
                                                displayMode: 'replace'
                                            });
                                        }else{
                                            this.editInput.available = stock.available+data['planned_quantity'];
                                        }
                                    }
                                });
                                this.editInput.quantity = "";
                            }else{
                                this.editInput.available = this.dataMaterial[this.editInput.index].available + data['planned_quantity'];
                                this.editInput.quantity = this.dataMaterial[this.editInput.index].quantity;
                            }

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
                        $('div.overlay').show();
                        window.axios.get('/api/getMaterialInfoWithoutProjectAPI/'+newValue).then(({ data }) => {
                            this.editInput.is_decimal = data['is_decimal'];
                            this.editInput.unit = data['unit'];

                            if(newValue != this.editInput.old_material_id){
                                this.stocks.forEach(stock => {
                                    if(stock.material_id == newValue){
                                        this.editInput.available = stock.available;
                                    }
                                });
                                this.editInput.quantity = "";
                            }else{
                                this.editInput.available = this.dataMaterial[this.editInput.index].available;
                                this.editInput.quantity = this.dataMaterial[this.editInput.index].quantity;
                            }

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
                }
            },
        },
        created: function() {
            this.newIndex = Object.keys(this.dataMaterial).length+1;
        },
    });
</script>
@endpush
