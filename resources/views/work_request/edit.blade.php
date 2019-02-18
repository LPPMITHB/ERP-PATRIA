@extends('layouts.main')
@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'Edit Work Request',
            'subtitle' => '',
            'items' => [
                'Dashboard' => route('index'),
                'View All Work Request' => route('work_request.index'),
                'Edit Work Request' => route('work_request.edit',$modelWR->id),
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'Edit Work Request',
            'subtitle' => '',
            'items' => [
                'Dashboard' => route('index'),
                'View All Work Request' => route('work_request_repair.index'),
                'Edit Work Request' => route('work_request_repair.edit',$modelWR->id),
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
                @if($menu == "building")
                    <form id="edit-wr" class="form-horizontal" method="POST" action="{{ route('work_request.update',['id'=>$modelWR->id]) }}">
                @else
                    <form id="edit-wr" class="form-horizontal" method="POST" action="{{ route('work_request_repair.update',['id'=>$modelWR->id]) }}">
                @endif
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                    @verbatim
                    <div id="wr">
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
                                <div class="col-sm-12 col-lg-3 p-l-0 p-r-0 p-t-3">
                                    <label for="">Required Date</label>
                                </div>
                                <div class="col-sm-12 col-lg-8 p-l-0">
                                    <input v-model="required_date" autocomplete="off" type="text" class="form-control datepicker width100" name="required_date" id="required_date" placeholder="Set Default Required Date">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 p-r-0">
                                <div class="col-sm-12 p-l-0">
                                    <label for="">WR Description</label>
                                </div>
                                <div class="col-sm-12 p-l-0">
                                    <textarea class="form-control" rows="4" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <h4>Raw Material</h4>
                                <table class="table table-bordered tableFixed" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">WBS Name</th>
                                            <th style="width: 20%">Material Name</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 10%">Available</th>
                                            <th style="width: 20%">Description</th>
                                            <th style="width: 10%">Required Date</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis" v-if="material.wbs_number != ''">{{ material.wbs_number }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td class="tdEllipsis">{{ material.material_code }} - {{ material.material_name }}</td>
                                            <td v-if="material.quantity != null" class="tdEllipsis">{{ material.quantity }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td class="tdEllipsis">{{ material.available }}</td>
                                            <td class="tdEllipsis">{{ material.description}}</td>
                                            <td class="tdEllipsis">{{ material.required_date }}</td>
                                            <td class="p-l-0 textCenter">
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(material,index)">
                                                    EDIT
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-l-10">{{newIndex}}</td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }}</option>
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
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input :disabled="materialOk" class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.available" disabled>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.description">
                                            </td>
                                            <td class="no-padding p-l-0 textLeft">
                                                <input v-model="dataInput.required_date" autocomplete="off" type="text" class="form-control datepicker width100" name="input_required_date" id="input_required_date" placeholder="Required Date">  
                                            </td>
                                            <td class="p-l-0  textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <h4>Finished Goods</h4>
                                <table class="table table-bordered tableFixed" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 15%">WBS Name</th>
                                            <th style="width: 20%">Material Name</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 20%">Description</th>
                                            <th style="width: 10%">Required Date</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterialFG">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis" v-if="material.wbs_number != ''">{{ material.wbs_number }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td class="tdEllipsis">{{ material.material_code }} - {{ material.material_name }}</td>
                                            <td v-if="material.quantity != null" class="tdEllipsis">{{ material.quantity }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td class="tdEllipsis">{{ material.description}}</td>
                                            <td class="tdEllipsis">{{ material.required_date }}</td>
                                            <td class="p-l-0 textCenter">
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#editFG_item" @click="openEditModalFG(material,index)">
                                                    EDIT
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-l-10">{{newIndexFG}}</td>
                                            <td class="p-l-0 textLeft" v-show="wbss.length > 0">
                                                <selectize v-model="dataInputFG.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in wbss" :value="wbs.id">{{ wbs.number }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInputFG.wbs_id == ''">
                                                <selectize disabled v-model="dataInputFG.id" :settings="nullSettings" disabled>
                                                </selectize>  
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInputFG.wbs_id != '' && allmaterial.length > 0">
                                                <selectize v-model="dataInputFG.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in allmaterial" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input :disabled="materialFGOk" class="form-control" v-model="dataInputFG.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInputFG.description" placeholder="Please Fill in this Field">
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <input v-model="dataInputFG.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="inputFG_required_date" id="inputFG_required_date" placeholder="Required Date">  
                                            </td>
                                            <td class="p-l-0  textCenter">
                                                <button @click.prevent="addFG" :disabled="createFGOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
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
                                                <label for="wbs" class="control-label">WBS Name</label>
                                                <input type="text" id="wbs" class="form-control" disabled> 
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="material" class="control-label">Material</label>
                                                <input type="text" id="materiall" class="form-control" disabled> 
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="available" class="control-label">Available</label>
                                                <input type="text" id="available" v-model="editInput.available" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <input type="text" id="description" v-model="editInput.description" class="form-control" placeholder="Please Input description">
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Required Date</label>
                                                <input v-model="editInput.required_date" autocomplete="off" type="text" class="form-control datepicker width100" name="edit_required_date" id="edit_required_date" placeholder="Required Date">  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editFG_item">
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
                                                <label for="wbs" class="control-label">WBS Name</label>
                                                <input type="text" id="wbsFG" class="form-control" disabled> 
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="material" class="control-label">Material</label>
                                                <input type="text" id="materiallFG" class="form-control" disabled> 
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInputFG.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <input type="text" id="description" v-model="editInputFG.description" class="form-control" placeholder="Please Input description">
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Required Date</label>
                                                <input v-model="editInputFG.required_date" autocomplete="off" type="text" class="form-control datepicker width100" name="editFG_required_date" id="editFG_required_date" placeholder="Required Date">  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateFGOk" data-dismiss="modal" @click.prevent="updateFG(editInputFG.old_material_id, editInputFG.material_id)">SAVE</button>
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
    const form = document.querySelector('form#edit-wr');

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
        tempAvailable: 0,
        description : @json($modelWR->description),
        wr_id : @json($modelWR->id),
        availableQuantity : [],
        newIndex : "",
        modelWR : @json($modelWR),
        selectedProject : @json($project),
        dataMaterial : @json($modelWRD),
        dataMaterialFG : @json($modelWRDFG),
        materials : [],
        allmaterial : @json($allmaterial),
        wbss : @json($wbss),
        project_id : "",
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        wbsSettings: {
            placeholder: 'Please Select WBS'
        },
        nullSettings:{
            placeholder: '-'
        },
        materialNullSettings:{
            placeholder: "WBS doesn't have BOM ! / Material already inputted"
        },
        dataInput : {
            material_id :"",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            available : "",
            description : "",
            required_date : "",
            wrd_id : null,
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            available : "",
            description : "",
            required_date : "",
        },
        dataInputFG : {
            material_id :"",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            description : "",
            required_date : "",
            wrd_id : null,
        },
        editInputFG : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            wbs_number : "",
            description : "",
            required_date : "",
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        submittedForm : {},
        required_date : "",

    }

    var vm = new Vue({
        el : '#wr',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
                format: 'dd-mm-yyyy',
            });
            $("#required_date").datepicker().on(
                "changeDate", () => {
                    this.required_date = $('#required_date').val();
                }
            );
            $("#input_required_date").datepicker().on(
                "changeDate", () => {
                    this.dataInput.required_date = $('#input_required_date').val();
                }
            );
            $("#edit_required_date").datepicker().on(
                "changeDate", () => {
                    this.editInput.required_date = $('#edit_required_date').val();
                }
            );

            $("#inputFG_required_date").datepicker().on(
                "changeDate", () => {
                    this.dataInputFG.required_date = $('#inputFG_required_date').val();
                }
            );
            $("#editFG_required_date").datepicker().on(
                "changeDate", () => {
                    this.editInputFG.required_date = $('#editFG_required_date').val();
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
            materialFGOk: function(){
                let isOk = false;

                if(this.dataInputFG.material_id == ""){
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
                
                if(this.dataMaterial.length < 1 || this.submit == "" || this.dataMaterialFG.length < 1){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;

                var string_newValue = this.dataInput.quantity+"";
                this.dataInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.dataInput.material_id == "" || this.dataInput.quantityInt < 1 || this.dataInput.quantityInt == "" || isNaN(this.dataInput.quantityInt) || this.dataInput.wbs_id == ""){
                    isOk = true;
                }
                
                return isOk;
            },
            createFGOk: function(){
                let isOk = false;

                var string_newValue = this.dataInputFG.quantity+"";
                this.dataInputFG.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.dataInputFG.material_id == "" || this.dataInputFG.quantityInt < 1 || this.dataInputFG.quantityInt == "" || isNaN(this.dataInputFG.quantityInt) || this.dataInputFG.wbs_id == ""){
                    isOk = true;
                }
                
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityInt+"";
                this.editInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.editInput.material_id == "" || this.editInput.quantityInt < 1 || this.editInput.quantityInt == "" || isNaN(this.editInput.quantityInt) || this.editInput.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            updateFGOk: function(){
                let isOk = false;

                var string_newValue = this.editInputFG.quantityInt+"";
                this.editInputFG.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.editInputFG.material_id == "" || this.editInputFG.quantityInt < 1 || this.editInputFG.quantityInt == "" || isNaN(this.editInputFG.quantityInt) || this.editInputFG.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            }
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
                this.submit = "";
                this.submittedForm.description = this.description;
                this.submittedForm.project_id = this.project_id;    

                var data = this.dataMaterial;
                data.forEach(wrd => {
                    wrd.quantity = parseInt((wrd.quantity+"").replace(/,/g , ''));
                });

                var data = this.dataMaterialFG;
                data.forEach(wrd => {
                    wrd.quantity = parseInt((wrd.quantity+"").replace(/,/g , ''));
                });

                this.submittedForm.materials = this.dataMaterial;
                this.submittedForm.materialsFG = this.dataMaterialFG;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            update(old_material_id, new_material_id){
                var material = this.dataMaterial[this.editInput.index];

                window.axios.get('/api/getMaterialWr/'+new_material_id).then(({ data }) => {
                    material.material_name = data.name;
                    material.material_code = data.code;
                    material.required_date = this.editInput.required_date;

                    if(this.editInput.wbs_id != ''){
                        window.axios.get('/api/getWbsWr/'+this.editInput.wbs_id).then(({ data }) => {
                            material.wbs_number = data.name;
                            material.quantityInt = this.editInput.quantity;
                            material.quantity = this.editInput.quantity;
                            material.material_id = new_material_id;
                            material.wbs_id = this.editInput.wbs_id;
                            material.description = this.editInput.description;
                            material.available = this.editInput.available;

                            $('div.overlay').hide();
                        })
                        .catch((error) => {
                            iziToast.warning({
                                title: 'Please Try Again..'+error,
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            $('div.overlay').hide();
                        })
                    }else{
                        material.quantityInt = this.editInput.quantityInt;
                        material.quantity = this.editInput.quantity;
                    }
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..'+error,
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
            updateFG(old_material_id, new_material_id){
                var material = this.dataMaterialFG[this.editInputFG.index];

                window.axios.get('/api/getMaterialWr/'+new_material_id).then(({ data }) => {
                    material.material_name = data.name;
                    material.material_code = data.code;
                    material.required_date = this.editInputFG.required_date;

                    if(this.editInputFG.wbs_id != ''){
                        window.axios.get('/api/getWbsWr/'+this.editInputFG.wbs_id).then(({ data }) => {
                            material.wbs_number = data.name;
                            material.quantityInt = this.editInputFG.quantity;
                            material.quantity = this.editInputFG.quantity;
                            material.material_id = new_material_id;
                            material.wbs_id = this.editInputFG.wbs_id;
                            material.description = this.editInputFG.description;
                            material.available = this.editInputFG.available;

                            $('div.overlay').hide();
                        })
                        .catch((error) => {
                            iziToast.warning({
                                title: 'Please Try Again..'+error,
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            $('div.overlay').hide();
                        })
                    }else{
                        material.quantityInt = this.editInputFG.quantityInt;
                        material.quantity = this.editInputFG.quantity;
                    }
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..'+error,
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
            openEditModal(data,index){
                console.log();
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.quantity = data.quantity;
                this.editInput.quantityInt = data.quantityInt;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_number = data.wbs_number;
                this.editInput.available = data.available;
                this.editInput.description = data.description;
                this.editInput.required_date = data.required_date;
                this.editInput.index = index;

                document.getElementById('materiall').value = data.material_code+" - "+data.material_name;
                document.getElementById('wbs').value = data.wbs_number;

                var material_id = JSON.stringify(this.material_id);
                material_id = JSON.parse(material_id);
                
                this.material_id_modal.forEach(id => {
                    if(id == data.material_id){
                        var index = this.material_id_modal.indexOf(id);
                    }
                });
            },
            openEditModalFG(data,index){
                console.log();
                this.editInputFG.material_id = data.material_id;
                this.editInputFG.old_material_id = data.material_id;
                this.editInputFG.material_code = data.material_code;
                this.editInputFG.material_name = data.material_name;
                this.editInputFG.quantity = data.quantity;
                this.editInputFG.quantityInt = data.quantityInt;
                this.editInputFG.wbs_id = data.wbs_id;
                this.editInputFG.wbs_number = data.wbs_number;
                this.editInputFG.description = data.description;
                this.editInputFG.required_date = data.required_date;
                this.editInputFG.index = index;

                document.getElementById('materiallFG').value = data.material_code+" - "+data.material_name;
                document.getElementById('wbsFG').value = data.wbs_number;

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
                window.axios.get('/api/getMaterialWr/'+material_id).then(({ data }) => {
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
                    this.dataInput.wbs_number = "";
                    this.dataInput.description = "";
                    this.dataInput.available = "";
                    this.dataInput.required_date = "";
                    
                    this.newIndex = Object.keys(this.dataMaterial).length+1;
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..'+error,
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
            addFG(){
                var material_id = this.dataInputFG.material_id;
                $('div.overlay').show();
                window.axios.get('/api/getMaterialWr/'+material_id).then(({ data }) => {
                    this.dataInputFG.material_name = data.name;
                    this.dataInputFG.material_code = data.code;

                    var temp_data = JSON.stringify(this.dataInputFG);
                    temp_data = JSON.parse(temp_data);

                    this.dataMaterialFG.push(temp_data);
                    
                    this.dataInputFG.material_name = "";
                    this.dataInputFG.material_code = "";
                    this.dataInputFG.quantity = "";
                    this.dataInputFG.material_id = "";
                    this.dataInputFG.wbs_id = "";
                    this.dataInputFG.wbs_number = "";
                    this.dataInputFG.description = "";
                    this.dataInputFG.required_date = "";
                    
                    this.newIndex = Object.keys(this.dataMaterialFG).length+1;
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..'+error,
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
        },
        watch : {
            'dataInput.material_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getQuantityReserved/'+newValue).then(({ data }) => {
                        this.availableQuantity = data;

                            this.dataInput.available = data.quantity - data.reserved;
                            this.dataInput.available = (this.dataInput.available+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");


                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..'+error,
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })

                    this.dataInput.quantity = "";
                
                }else{

                }
            },

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
            'dataInputFG.quantity': function(newValue){
                this.dataInputFG.quantityInt = newValue;
                var string_newValue = newValue+"";
                quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                this.dataInputFG.quantity = quantity_string;
            },
            'editInputFG.quantity': function(newValue){
                this.editInputFG.quantityInt = newValue;
                var string_newValue = newValue+"";
                quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                Vue.nextTick(() => this.editInputFG.quantity = quantity_string);
            },
            'dataInput.wbs_id': function(newValue){
                this.dataInput.material_id = "";
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsWREdit/'+newValue+'/'+this.wr_id).then(({ data }) => {
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
            'dataInputFG.wbs_id': function(newValue){
                this.dataInputFG.material_id = "";
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsWREdit/'+newValue+'/'+this.wr_id).then(({ data }) => {
                        this.dataInputFG.wbs_number = data.wbs.number;
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
                    this.dataInputFG.wbs_id = "";
                }
            },
            'required_date': function(newValue){
                this.dataMaterial.forEach(data =>{
                    if(newValue != ''){
                        data.required_date = newValue;
                    }
                });

                this.dataMaterialFG.forEach(data =>{
                    if(newValue != ''){
                        data.required_date = newValue;
                    }
                });
            }
        },

        created: function() {
            this.newIndex = Object.keys(this.dataMaterial).length+1;
            this.newIndexFG = Object.keys(this.dataMaterialFG).length+1;
            this.dataMaterial.forEach( function (wrd, i) {
                wrd.quantity = (wrd.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                wrd.available = (wrd.available+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                
                wrd.material_name = wrd.material.name;
                wrd.material_code = wrd.material.code;
                wrd.quantityInt = wrd.quantity;
                wrd.wrd_id = wrd.id;
                wrd.wbs_number = wrd.wbs.number;

            });

            this.dataMaterialFG.forEach( function (wrd, i) {
                wrd.quantity = (wrd.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                
                wrd.material_name = wrd.material.name;
                wrd.material_code = wrd.material.code;
                wrd.quantityInt = wrd.quantity;
                wrd.wrd_id = wrd.id;
                wrd.wbs_number = wrd.wbs.number;

            });

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
