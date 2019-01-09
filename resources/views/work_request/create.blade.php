@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Work Request',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Create Work Request' => route('work_request.create'),
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
                <form id="create-wr" class="form-horizontal" method="POST" action="{{ route('work_request.store') }}">
                @csrf
                    @verbatim
                    <div id="wr">
                        <div class="box-header no-padding">
                            <template v-if="selectedProject.length > 0">
                                <div class="col-xs-12 col-md-4">
                                    <div class="col-sm-12 no-padding"><b>Project Information</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].number}}</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].ship.type}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="selectedProject[0].customer.name" @mouseover="changeText"><b>: {{selectedProject[0].customer.name}}</b></div>

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
                                        <label for="">WR Description</label>
                                    </div>
                                    <div class="col-sm-12 p-l-0">
                                        <textarea class="form-control" rows="4" v-model="description"></textarea>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="row" v-show="selectedProject.length > 0">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table class="table table-bordered tableFixed" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 20%">WBS Name</th>
                                            <th style="width: 25%">Material Name</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 10%">Available</th>
                                            <th style="width: 20%">Description</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(material,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis" v-if="material.work_name != ''">{{ material.work_name }}</td>
                                            <td class="tdEllipsis" v-else>-</td>
                                            <td class="tdEllipsis">{{ material.material_code }} - {{ material.material_name }}</td>
                                            <td v-if="material.quantity != null" class="tdEllipsis">{{ material.quantity }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td v-if="material.available != ''"class="tdEllipsis">{{ material.available }}</td>
                                            <td v-else class="tdEllipsis">-</td>
                                            <td class="tdEllipsis">{{ material.description}}</td>
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
                                            <td class="p-l-0 textLeft" v-show="project_id != ''">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="project_id == ''">
                                                <selectize v-model="dataInput.wbs_id" :settings="nullSettings" disabled>
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings" id="material">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.material.code }} - {{ material.material.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.available" disabled>
                                            </td>
                                            <td class="p-l-0">
                                                <input class="form-control" v-model="dataInput.description">
                                            </td>
                                            <td class="p-l-0  textCenter">
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
                                            <div class="col-sm-12" v-show="project_id != ''"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="project_id == ''"> 
                                                <label for="type" class="control-label">WBS Name</label>
                                                <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="nullSettings" disabled>
                                                    <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="materialedit" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.material.code }} - {{ material.material.name }}</option>
                                                </selectize>
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
    const form = document.querySelector('form#create-wr');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        description : "",
        availableQuantity : [],
        newIndex : "",
        boms : [],
        materials : [],
        projects : @json($modelProject),
        works : [],
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
        selectedProject : [],
        dataMaterial : [],
        dataInput : {
            material_id :"",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            work_name : "",
            available : "",
            description : ""
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            quantityInt : 0,
            wbs_id : "",
            work_name : "",
            available : "",
            description : ""
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        submittedForm : {}
    }

    var vm = new Vue({
        el : '#wr',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataMaterial.length > 0){
                    isOk = true;
                }

                return isOk;
            },
            allOk: function(){
                let isOk = false;
                
                if(this.dataMaterial.length < 1 || this.submit == ""){
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
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityInt+"";
                this.editInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.editInput.material_id == "" || this.editInput.quantityInt < 1 || this.editInput.quantityInt == "" || isNaN(this.editInput.quantityInt) || this.editInput.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods : {
            changeText(){
                if(document.getElementsByClassName('tooltip-inner')[0]!= undefined){
                    if(document.getElementsByClassName('tooltip-inner')[0].innerHTML != this.selectedProject[0].customer.name ){
                        document.getElementsByClassName('tooltip-inner')[0].innerHTML=this.selectedProject[0].customer.name;    
                    }
                }
            },  
            submitForm(){
                this.submit = "";
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
                var material = this.dataMaterial[this.editInput.index];

                window.axios.get('/api/getMaterialWr/'+new_material_id).then(({ data }) => {
                    material.material_name = data.name;
                    material.material_code = data.code;

                    if(this.editInput.wbs_id != ''){
                        window.axios.get('/api/getWbsWr/'+this.editInput.wbs_id).then(({ data }) => {
                            material.work_name = data.name;
                            material.quantityInt = this.editInput.quantityInt;
                            material.quantity = this.editInput.quantity;
                            material.material_id = new_material_id;
                            material.wbs_id = this.editInput.wbs_id;
                            material.description = this.editInput.description;
                            material.available = this.editInput.available;

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
                        material.quantityInt = this.editInput.quantityInt;
                        material.quantity = this.editInput.quantity;
                        material.alocation = this.editInput.alocation;
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
            },
            openEditModal(data,index){
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.quantity = data.quantity;
                this.editInput.quantityInt = data.quantityInt;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.work_name = data.work_name;
                this.editInput.available = data.available;
                this.editInput.description = data.description;
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
                    this.dataInput.work_name = "";
                    this.dataInput.description = "";
                    this.dataInput.available = "";
                    
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
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getProjectWR/'+newValue).then(({ data }) => {
                        this.selectedProject = [];
                        this.selectedProject.push(data);

                        this.works = data.wbss;
                        
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
                    
                    this.dataInput.material_id = "";
                }else{
                    this.selectedProject = [];
                }

                // function myFunction(x) {
                //     if (x.matches) { // If media query matches
                //         $('.table').wrap('<div class="dataTables_scroll" />');
                //     } 
                // }

                // var x = window.matchMedia("(max-width: 500px)")
                // myFunction(x) // Call listener function at run time
                // x.addListener(myFunction) // Attach listener function on state changes

                // var x = window.matchMedia("(max-width: 1024px)")
                // myFunction(x) // Call listener function at run time
                // x.addListener(myFunction) // Attach listener function on state changes
            },

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
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })

                    this.dataInput.quantity = "";
                
                }else{

                }
            },

            'editInput.material_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getQuantityReserved/'+newValue).then(({ data }) => {
                        this.availableQuantity = data;

                        this.editInput.available = data.quantity - data.reserved;
                        this.editInput.available = (this.editInput.available+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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

                    this.editInput.quantity = "";
                
                }else{

                }
            },

            'dataInput.quantity': function(newValue){
                if(newValue != ""){

                    this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    if(parseInt((this.dataInput.quantity+"").replace(/,/g , '')) > parseInt((this.dataInput.available+"").replace(/,/g , ''))){

                        iziToast.warning({
                        title: 'Cannot insert more than available quantity !',
                        position: 'topRight',
                        displayMode: 'replace'

                        });

                        this.dataInput.quantity = this.dataInput.available;
                    }
                }
            },

            'editInput.quantity': function(newValue){
                if(newValue != ""){

                    this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    if(parseInt((this.editInput.quantity+"").replace(/,/g , '')) > parseInt((this.editInput.available+"").replace(/,/g , ''))){

                        iziToast.warning({
                        title: 'Cannot insert more than available quantity !',
                        position: 'topRight',
                        displayMode: 'replace'

                        });

                        this.editInput.quantity = this.editInput.available;
                    }
                }
            },

            'dataInput.wbs_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsWr/'+newValue).then(({ data }) => {
                        this.dataInput.work_name = data.name;

                        window.axios.get('/api/getBomWr/'+this.dataInput.wbs_id).then(({ data }) => {
                            this.boms = data;

                            window.axios.get('/api/getBomDetailWr/'+this.boms.id).then(({ data }) => {
                                this.materials = data;

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

                    this.dataInput.quantity = "";
                    this.dataInput.available = "";
                }else{
                    this.dataInput.wbs_id = "";
                }
            },

            'editInput.wbs_id': function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWbsWr/'+newValue).then(({ data }) => {
                        this.editInput.work_name = data.name;

                        window.axios.get('/api/getBomWr/'+this.editInput.wbs_id).then(({ data }) => {
                            this.boms = data;

                            window.axios.get('/api/getBomDetailWr/'+this.boms.id).then(({ data }) => {
                                this.materials = data;

                                var $material = $(document.getElementById('materialedit')).selectize();
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

                    this.editInput.quantity = "";
                    this.editInput.available = "";
                }else{
                    this.editInput.wbs_id = "";
                }
            },
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
