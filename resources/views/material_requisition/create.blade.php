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
                            <template v-if="selectedProject.length > 0">
                                <div class="col-xs-12 col-md-4">
                                    <div class="col-sm-12 no-padding"><b>Project Information</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].number}}</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].ship.type}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="tooltip(selectedProject[0].customer.name)"><b>: {{selectedProject[0].customer.name}}</b></div>

                                    <div class="col-xs-5 no-padding">Start Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].planned_start_date}}</b></div>

                                    <div class="col-xs-5 no-padding">End Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].planned_end_date}}</b></div>
                                </div>
                            </template>
                            <div class="col-xs-12 col-md-4">
                                <label for="" >Project Name</label>
                                <selectize v-model="project_id" :settings="projectSettings" :disabled="dataOk">
                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.name }}</option>
                                </selectize>  
                            </div>
                            <template v-if="selectedProject.length > 0">
                                <div class="col-xs-12 col-md-4 p-r-0">
                                        <div class="col-sm-12 p-l-0">
                                            <label for="">MR Description</label>
                                        </div>
                                        <div class="col-sm-12 p-l-0">
                                            <textarea class="form-control" rows="3" v-model="description"></textarea>
                                        </div>
                                </div>
                            </template>
                        </div>
                        <div class="row" v-show="selectedProject.length > 0">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 23%">WBS Name</th>
                                            <th style="width: 35%">Material Name</th>
                                            <th style="width: 17%">Planned Quantity (BOM)</th>
                                            <th style="width: 16%">Available Quantity</th>
                                            <th style="width: 16%">Requested Quantity</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis">{{ material.wbs_number }} - {{ material.wbs_description }}</td>
                                            <td class="tdEllipsis">{{ material.material_code }} - {{ material.material_description }}</td>
                                            <td class="tdEllipsis">{{ material.planned_quantity }}</td>
                                            <td class="tdEllipsis">{{ material.availableStr }}</td>
                                            <td class="tdEllipsis">{{ material.quantity }}</td>
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
                                            <td class="p-l-0 textLeft" v-show="wbss.length > 0">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="wbss.length == 0">
                                                <selectize disabled v-model="dataInput.wbs_id" :settings="wbsNullSettings">
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.wbs_id == ''">
                                                <selectize disabled v-model="dataInput.id" :settings="nullSettings" disabled>
                                                </selectize>  
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.wbs_id != '' && materials.length == 0">
                                                <selectize disabled v-model="dataInput.material_id" :settings="materialNullSettings">
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.wbs_id != '' && materials.length > 0">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input disabled class="form-control" v-model="dataInput.planned_quantity" placeholder="">
                                            </td>
                                            <td class="p-l-0">
                                                <input disabled class="form-control" v-model="dataInput.availableStr" placeholder="">
                                            </td>
                                            <td class="p-l-0">
                                                <input :disabled="materialOk" class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="p-l-0 textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <template v-if="selectedProject.length > 0">
                            <div class="col-md-12 p-r-0 p-t-10">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">CREATE</button>
                            </div>
                        </template>
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
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.wbs_id != '' && materialsEdit.length > 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materialsEdit" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.wbs_id != '' && materialsEdit.length == 0">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize disabled :settings="materialNullSettings" >
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.wbs_id == ''">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize disabled :settings="nullSettings" disabled >
                                                </selectize>  
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="planned_quantity" class="control-label">Planned Quantity</label>
                                                <input disabled type="text" id="planned_quantity" v-model="editInput.planned_quantity" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="available" class="control-label">Available Quantity</label>
                                                <input disabled type="text" id="available" v-model="editInput.availableStr" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input :disabled="materialEditOk" type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
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
        newIndex : "",
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
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            wbs_description : "",
            planned_quantity: "",
            available: "",
            availableStr: "",
            is_decimal: "",
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_description : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            old_wbs_id : "",
            wbs_number : "",
            wbs_description : "",
            planned_quantity: "",
            available: "",
            availableStr: "",
            index: "",
            is_decimal: "",
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        submittedForm : {}
    }

    var vm = new Vue({
        el : '#mr',
        data : data,
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

                var string_newValue = this.dataInput.quantityInt+"";
                this.dataInput.quantityInt = parseFloat(string_newValue.replace(/,/g , ''));

                if(this.dataInput.material_id == "" || this.dataInput.quantityInt < 1 || this.dataInput.quantityInt == "" || isNaN(this.dataInput.quantityInt)){
                    isOk = true;
                }

                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityInt+"";
                this.editInput.quantityInt = parseFloat(string_newValue.replace(/,/g , ''));

                if(this.editInput.material_id == "" || this.editInput.quantityInt < 1 || this.editInput.quantityInt == "" || isNaN(this.editInput.quantityInt)){
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
                this.submittedForm.description = this.description;
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
                var material = this.dataMaterial[this.editInput.index];
                material.quantityInt = this.editInput.quantityInt;
                material.quantity = this.editInput.quantity;
                material.material_id = new_material_id;
                material.wbs_id = this.editInput.wbs_id;

                console.log(this.editInput.available - this.editInput.quantityInt);

                var quantity = this.editInput.quantityInt;

                window.axios.get('/api/getStockMR/'+material.material_id).then(({ data }) => {
                    var temp = data.quantity - data.reserved;

                    if(temp < 0){
                        var available = 0;
                    }else if(temp > 0){
                        var available = data.quantity - data.reserved;
                    }

                    if(quantity > available){
                        iziToast.warning({
                            title: 'This material only have '+ available + ' in stocks',
                            position: 'topRight',
                            displayMode: 'replace'
                        });

                    }

                    $('div.overlay').hide();

                }).catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })

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
                var quantity = this.dataInput.quantityInt;

                $('div.overlay').show();

                window.axios.get('/api/getStockMR/'+material_id).then(({ data }) => {
                    var temp = data.quantity - data.reserved;

                    if(temp < 0){
                        var available = 0;
                    }else if(temp > 0){
                        var available = data.quantity - data.reserved;
                    }

                    if(quantity > available){
                        iziToast.warning({
                            title: 'This material only have '+ available + ' in stocks',
                            position: 'topRight',
                            displayMode: 'replace'
                        });

                    }

                    $('div.overlay').hide();

                }).catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
                
                window.axios.get('/api/getMaterialPR/'+material_id).then(({ data }) => {
                    this.dataInput.material_description = data.description;
                    this.dataInput.material_code = data.code;

                    var temp_data = JSON.stringify(this.dataInput);
                    temp_data = JSON.parse(temp_data);

                    this.dataMaterial.push(temp_data);

                    this.stocks.forEach(stock => {
                        if(stock.material_id == this.dataInput.material_id){
                            stock.reserved += this.dataInput.quantityInt;
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
                    var temp = parseFloat((newValue+"").replace(/\D/g, ""));
                    var qty = "";
                    if(temp > this.dataInput.available){
                        iziToast.warning({
                            title: 'There is no available stock for this material',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        qty = this.dataInput.available;
                    }else{
                        qty = newValue;
                    }

                    this.dataInput.quantityInt = qty;
                    var string_newValue = qty+"";
                    quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.dataInput.quantity = quantity_string;
                }
            },
            'dataInput.available':function(newValue){
                this.dataInput.availableStr = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            'editInput.available':function(newValue){
                this.editInput.availableStr = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            'editInput.quantity': function(newValue){
                var temp = parseFloat((newValue+"").replace(/\D/g, ""));
                var qty = "";
                if(temp > this.editInput.available){
                    iziToast.warning({
                        title: 'There is no available stock for this material',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    qty = this.editInput.available;
                }else{
                    qty = newValue;
                }

                this.editInput.quantityInt = qty;
                var string_newValue = qty+"";
                quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                Vue.nextTick(() => this.editInput.quantity = quantity_string);
            },
            'dataInput.wbs_id': function(newValue){
                this.dataInput.material_id = "";
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
                    this.editInput.quantity = "";
                    this.editInput.quantityInt = 0;
                    this.editInput.old_wbs_id = null;
                }

                if(this.editInput.old_wbs_id == null){
                    this.editInput.material_id = "";
                    this.editInput.quantity = "";
                    this.editInput.quantityInt = 0;
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
                    this.dataInput.quantity = "";
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialInfoAPI/'+newValue+"/"+this.dataInput.wbs_id).then(({ data }) => {
                        // this.dataInput.available = data['available'];
                        this.dataInput.planned_quantity = data['planned_quantity'];

                        this.stocks.forEach(stock => {
                            if(stock.material_id == newValue){
                                this.dataInput.available = stock.quantity - stock.reserved;
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
            },
            'editInput.material_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getMaterialInfoAPI/'+newValue+'/'+this.editInput.wbs_id).then(({ data }) => {
                        // this.editInput.available = data['available'];
                        this.editInput.planned_quantity = data['planned_quantity'];

                        this.editInput.available = this.dataMaterial[this.editInput.index].available;
                        this.editInput.quantity = this.dataMaterial[this.editInput.index].quantity;

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
        },
        created: function() {
            this.newIndex = Object.keys(this.dataMaterial).length+1;
        },
    });
</script>
@endpush
