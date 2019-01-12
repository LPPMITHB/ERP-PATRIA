@extends('layouts.main')
@section('content-header')
@if($modelPR->type == 1)
    @php($type = "Material")
@else
    @php($type = "Resource")
@endif
@if($route == "/purchase_requisition")
    @breadcrumb(
        [
            'title' => 'Edit Purchase Requisition » '.$modelPR->number.' - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Requisitions' => route('purchase_requisition.index'),
                'Edit Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_requisition_repair")
    @breadcrumb(
        [
            'title' => 'Edit Purchase Requisition » '.$modelPR->number.' - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Requisitions' => route('purchase_requisition_repair.index'),
                'Edit Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/purchase_requisition")
                    <form id="edit-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition.update',['id'=>$modelPR->id]) }}">
                @elseif($route == "/purchase_requisition_repair")
                    <form id="edit-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition_repair.update',['id'=>$modelPR->id]) }}">
                @endif
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                    @verbatim
                    <div id="pr">
                        <div class="box-header no-padding">
                            <div class="col-xs-12 col-md-4" v-if="selectedProject != null">
                                <div class="col-sm-12 no-padding"><b>Project Information</b></div>
        
                                <div class="col-xs-5 no-padding">Project Number</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject.number}}</b></div>
                                
                                <div class="col-xs-5 no-padding">Ship Type</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject.ship.type}}</b></div>
        
                                <div class="col-xs-5 no-padding">Customer</div>
                                <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="tooltip(selectedProject.customer.name)"><b>: {{selectedProject.customer.name}}</b></div>

                                <div class="col-xs-5 no-padding">Start Date</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject.planned_start_date}}</b></div>

                                <div class="col-xs-5 no-padding">End Date</div>
                                <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject.planned_end_date}}</b></div>
                            </div>
                            <div class="col-xs-12 col-md-4 p-r-0">
                                <div class="col-sm-12 p-l-0">
                                    <label for="">PR Description</label>
                                </div>
                                <div class="col-sm-12 p-l-0">
                                    <textarea class="form-control" rows="3" v-model="modelPR.description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table class="table table-bordered tableFixed">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th v-if="modelPR.type == 1" style="width: 30%">Material Name</th>
                                            <th v-else style="width: 30%">Resource Name</th>
                                            <th style="width: 15%">Quantity</th>
                                            <th style="width: 25%">WBS Name</th>
                                            <th style="width: 15%">Alocation</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td v-if="modelPR.type == 1" class="tdEllipsis">{{ material.material_code }} - {{ material.material_name }}</td>
                                            <td v-else class="tdEllipsis">{{ material.resource_code }} - {{ material.resource_name }}</td>
                                            <td class="tdEllipsis">{{ material.quantity }}</td>
                                            <td class="tdEllipsis" v-if="material.wbs_name != null">{{ material.wbs_name }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td v-if="modelPR.type == 1" class="tdEllipsis">{{ material.alocation }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td class="p-l-0 textCenter">
                                                <a v-if="modelPR.type == 1" class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(material,index)">
                                                    EDIT
                                                </a>
                                                <a v-else class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_resource" @click="openEditModal(material,index)">
                                                    EDIT
                                                </a>
                                                <a v-show="material.prd_id == null" href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-l-10">{{newIndex}}</td>
                                            <td v-show="modelPR.type == 1" class="no-padding textLeft">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                                </selectize>
                                            </td>
                                            <td v-show="modelPR.type == 2" class="no-padding textLeft">
                                                <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="no-padding ">
                                                <input class="form-control width100" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="no-padding  textLeft" v-show="selectedProject != null">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="no-padding textLeft" v-show="selectedProject == null">
                                                <selectize v-model="dataInput.wbs_id" :settings="nullSettings" disabled>
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="no-padding textLeft">
                                                <selectize v-model="dataInput.alocation" :settings="alocationSettings" :disabled="resourceOk">
                                                    <option value="Consumption">Consumption</option>
                                                    <option value="Stock">Stock</option>
                                                </selectize>
                                            </td>
                                            <td class="no-padding textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 p-r-0 p-t-10">
                            <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">SAVE</button>
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
                                                <label for="material" class="control-label">Material</label>
                                                <input type="text" id="material" class="form-control" disabled >
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12" v-show="selectedProject != null"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="selectedProject == null"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="nullSettings" disabled>
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Alocation</label>
                                                <selectize id="edit_modal" v-model="editInput.alocation" :settings="alocationSettings">
                                                    <option value="Consumption">Consumption</option>
                                                    <option value="Stock">Stock</option>
                                                </selectize>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="edit_resource">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Resource</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="resource" class="control-label">Resource</label>
                                                <input type="text" id="resource" class="form-control" disabled >
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12" v-show="selectedProject != null"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="selectedProject == null"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="nullSettings" disabled>
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.name }}</option>
                                                </selectize>
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
    const form = document.querySelector('form#edit-pr');

    $(document).ready(function(){
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == 'Quantity' || title == ""){
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
        newIndex : "",
        resource : "",
        modelPR : @json($modelPR),
        selectedProject : @json($project),
        dataMaterial : @json($modelPRD),
        materials : @json($materials),
        resources : @json($resources),
        wbss : @json($wbss),
        wbsSettings: {
            placeholder: 'Please Select WBS'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        nullSettings:{
            placeholder: '-'
        },
        alocationSettings: {
            placeholder: 'Please Select Alocation'
        },
        dataInput : {
            prd_id :null,
            material_id :"",
            resource_id : "",
            material_code : "",
            material_name : "",
            resource_code : "",
            resource_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_name : "",
            alocation : "Stock"
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_name : "",
            alocation : ""
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        submittedForm : {}
    }

    var vm = new Vue({
        el : '#pr',
        data : data,
        computed : {
            resourceOk: function(){
                let isOk = false;
                
                if(this.resource == "ok"){
                    isOk = true;
                    this.dataInput.alocation = "";
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

                if(this.modelPR.type == 1){
                    var string_newValue = this.dataInput.quantityInt+"";
                    this.dataInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                    if(this.dataInput.material_id == "" || this.dataInput.quantityInt < 1 || this.dataInput.quantityInt == "" || isNaN(this.dataInput.quantityInt)){
                        isOk = true;
                    }
                }else{
                    if(this.dataInput.resource_id == ""){
                        isOk = true;
                    }
                }

                return isOk;
            },
            updateOk: function(){
                let isOk = false;
                if(this.modelPR.type == 1){
                    var string_newValue = this.editInput.quantityInt+"";
                    this.editInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                    if(this.editInput.material_id == "" || this.editInput.quantityInt < 1 || this.editInput.quantityInt == "" || isNaN(this.editInput.quantityInt)){
                        isOk = true;
                    }
                }else{
                    if(this.editInput.resource_id == ""){
                        isOk = true;
                    }
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
                this.submittedForm.description = this.modelPR.description;
                this.submittedForm.project_id = this.project_id;    
                
                var data = this.dataMaterial;
                data.forEach(prd => {
                    prd.quantity = parseInt((prd.quantity+"").replace(/,/g , ''));
                });

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
                if(this.editInput.wbs_id != null){
                    material.wbs_name = this.editInput.wbs_name;
                    material.quantityInt = this.editInput.quantityInt;
                    material.quantity = this.editInput.quantity;
                    material.wbs_id = this.editInput.wbs_id;
                    material.alocation = this.editInput.alocation;
                }else{
                    material.quantityInt = this.editInput.quantityInt;
                    material.quantity = this.editInput.quantity;
                    material.alocation = this.editInput.alocation;
                }
                $('div.overlay').hide();
            },
            openEditModal(data,index){
                if(data.material_id != null && data.material_id != ''){
                    this.editInput.material_id = data.material_id;
                    this.editInput.old_material_id = data.material_id;
                    this.editInput.material_code = data.material_code;
                    this.editInput.material_name = data.material_name;
                    this.editInput.quantity = data.quantity;
                    this.editInput.quantityInt = data.quantityInt;
                    this.editInput.wbs_id = data.wbs_id;
                    this.editInput.wbs_name = data.wbs_name;
                    this.editInput.alocation = data.alocation;
                    this.editInput.index = index;

                    document.getElementById('material').value = data.material_code+" - "+data.material_name;
                    var material_id = JSON.stringify(this.material_id);
                    material_id = JSON.parse(material_id);
                    
                    this.material_id_modal.forEach(id => {
                        if(id == data.material_id){
                            var index = this.material_id_modal.indexOf(id);
                        }
                    });
                }else{
                    this.editInput.resource_id = data.resource_id;
                    this.editInput.resource_code = data.resource_code;
                    this.editInput.resource_name = data.resource_name;
                    this.editInput.quantity = data.quantity;
                    this.editInput.quantityInt = data.quantityInt;
                    this.editInput.wbs_id = data.wbs_id;
                    this.editInput.wbs_name = data.wbs_name;
                    this.editInput.index = index;
                    console.log(data.resource_code)
                    document.getElementById('resource').value = data.resource_code+" - "+data.resource_name;
                }
                
            },
            add(){
                $('div.overlay').show();
                if(this.modelPR.type == 1){
                    var material_id = this.dataInput.material_id;
                    window.axios.get('/api/getMaterialPR/'+material_id).then(({ data }) => {
                        this.dataInput.material_name = data.name;
                        this.dataInput.material_code = data.code;

                        var temp_data = JSON.stringify(this.dataInput);
                        temp_data = JSON.parse(temp_data);

                        this.dataMaterial.push(temp_data);

                        this.dataInput.material_name = "";
                        this.dataInput.material_code = "";
                        this.dataInput.quantity = "";
                        this.dataInput.material_id = "";
                        this.dataInput.wbs_id = "";
                        this.dataInput.wbs_name = "";
                        this.dataInput.alocation = "Stock";

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
                }else{
                    var resource_id = this.dataInput.resource_id;
                    window.axios.get('/api/getResourcePR/'+resource_id).then(({ data }) => {
                        this.dataInput.resource_name = data.name;
                        this.dataInput.resource_code = data.code;

                        var temp_data = JSON.stringify(this.dataInput);
                        temp_data = JSON.parse(temp_data);

                        this.dataMaterial.push(temp_data);

                        this.dataInput.resource_name = "";
                        this.dataInput.resource_code = "";
                        this.dataInput.resource_id = "";
                        this.dataInput.wbs_id = "";
                        this.dataInput.wbs_name = "";
                        this.dataInput.quantity = "";

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
                }
            },
            removeRow(index){
                this.dataMaterial.splice(index, 1);
                
                this.newIndex = this.dataMaterial.length + 1;
            }
        },
        watch : {
            'dataInput.quantity': function(newValue){
                this.dataInput.quantityInt = newValue;
                var string_newValue = newValue+"";
                quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                this.dataInput.quantity = quantity_string;
            },
            'editInput.quantity': function(newValue){
                this.editInput.quantityInt = newValue;
                var string_newValue = newValue+"";
                quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                Vue.nextTick(() => this.editInput.quantity = quantity_string);
            },
            'dataInput.wbs_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsPR/'+newValue).then(({ data }) => {
                        this.dataInput.wbs_name = data.name;
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
            'editInput.wbs_id': function(newValue){
                if(newValue != '' && newValue != null){
                    window.axios.get('/api/getWbsPR/'+newValue).then(({ data }) => {
                        this.editInput.wbs_name = data.name;
                        this.editInput.wbs_id = data.id;
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    })
                }
            }
        },
        created: function() {
            this.newIndex = Object.keys(this.dataMaterial).length+1;

            var data = this.dataMaterial;
            data.forEach(prd => {
                prd.quantity = (prd.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                if(prd.material_id != null){
                    prd.material_name = prd.material.name;
                    prd.material_code = prd.material.code;
                }else{
                    prd.resource_name = prd.resource.name;
                    prd.resource_code = prd.resource.code;
                }
                prd.prd_id = prd.id;
                if(this.selectedProject){
                    if(prd.wbs == null){

                    }else{
                        prd.wbs_name = prd.wbs.name;
                    }
                }else{

                }
            });

            if(this.modelPR.type == 1){
                this.resource = "";
            }else if(this.modelPR.type == 2){
                this.resource = "ok";
            }
        },
    });
</script>
@endpush
