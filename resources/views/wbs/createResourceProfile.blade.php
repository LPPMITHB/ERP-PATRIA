@extends('layouts.main')
@section('content-header')
@if($route == "/wbs")
    @breadcrumb(
        [
            'title' => 'Manage Resource Profile',
            'items' => [
                'Dashboard' => route('index'),
                'Create WBS Profile' => route('wbs.createWbsProfile'),
                'Manage BOM / BOS Profile' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/wbs_repair")
    @breadcrumb(
        [
            'title' => 'Manage Resource Profile',
            'items' => [
                'Dashboard' => route('index'),
                'Create WBS Profile' => route('wbs_repair.createWbsProfile'),
                'Manage BOM / BOS Profile' => '',
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
            <div class="box-body no-padding p-b-10">
                @verbatim
                <div id="resource">
                    <div class="box-header p-b-0">                          
                        <div class="col-xs-12 col-md-4">
                            <div class="col-sm-12 no-padding"><b>WBS Profile Information</b></div>
                        
                            <div class="col-xs-4 no-padding">Name</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.number)"><b>: {{wbs.number}}</b></div>
    
                            <div class="col-xs-4 no-padding">Description</div>
                            <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.description)"><b>: {{wbs.description}}</b></div>
                            <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.description)"><b>: -</b></div>
    
                            <div class="col-xs-4 no-padding">Deliverable</div>
                            <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
    
                        </div>
                    </div> <!-- /.box-header -->
                    <div class="col-md-12 p-t-5">
                        <table id="assign-rsc" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">Category</th>
                                    <th style="width: 25%">Resource</th>
                                    <th style="width: 25%">Resource Detail</th>
                                    <th style="width: 10%">Quantity</th>
                                    <th style="width: 12%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data,index) in resourceProfile">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{getCategoryName(data.category_id)}}</td>
                                    <td>{{ data.resource.code }} - {{ data.resource.name }}</td>
                                    <td v-if="data.resource_detail != null">{{ data.resource_detail.code }}</td>
                                    <td v-else>-</td>
                                    <td>{{ data.quantity }}</td>
                                    <td class="p-l-3 textCenter">
                                        <a class="btn btn-primary btn-xs" @click="openEditModal(data,index)">
                                            EDIT
                                        </a>
                                        <a href="#" @click="removeRow(data.id)" class="btn btn-danger btn-xs">
                                            <div class="btn-group">DELETE</div>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0 textLeft">
                                    <selectize v-model="dataInput.category_id" :settings="categorySettings">
                                        <option v-for="(category,index) in resource_categories" :value="category.id">{{ category.name }}</option>
                                    </selectize>
                                </td>

                                <td class="no-padding" v-show="dataInput.category_id == ''">
                                    <selectize id="material" v-model="dataInput.null" :settings="nullSettings" disabled>
                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                    </selectize>
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.category_id != ''">
                                    <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                        <option v-for="(resource,index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                    </selectize>
                                </td>

                                <td class="no-padding" v-show="dataInput.category_id == 3 && dataInput.resource_id == '' || dataInput.category_id == '' && dataInput.resource_id == ''">
                                    <selectize id="material" v-model="dataInput.null" :settings="nullResourceSettings" disabled>
                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                    </selectize>
                                </td>
                                <td class="no-padding" v-show="dataInput.category_id != 3 && dataInput.category_id != ''">
                                    <selectize id="material" v-model="dataInput.null" :settings="otherSettings" disabled>
                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                    </selectize>
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.category_id == 3 && dataInput.resource_id != '' && selectedRD.length < 1">
                                    <selectize v-model="dataInput.null" :settings="nullRdSettings" disabled>
                                        <option v-for="(rd, index) in selectedRD" :value="rd.id">{{ rd.code }}</option>
                                    </selectize>
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.category_id == 3 && dataInput.resource_id != '' && selectedRD.length > 0">
                                    <selectize v-model="dataInput.resource_detail_id" :settings="resourceDetailSettings">
                                        <option v-for="(rd, index) in selectedRD" :value="rd.id">{{ rd.code }}</option>
                                    </selectize>
                                </td>

                                <td class="p-l-0 textLeft">
                                    <input type="text" v-model="dataInput.quantity" class="form-control" placeholder="Please Input Quantity" :disabled='resourceDetail'>
                                </td>
                                <td class="p-l-0 textCenter">
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                </td>
                            </tfoot>
                        </table>
                    </div>

                    <div class="modal fade" id="edit_item">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Resource Profile</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="control-label">Category</label>
                                            <selectize v-model="editInput.category_id" :settings="categorySettings" disabled>
                                                <option v-for="(category,index) in resource_categories" :value="category.id">{{ category.name }}</option>
                                            </selectize>
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="control-label">Resource</label>
                                            <selectize v-model="editInput.resource_id" :settings="resourceSettings">
                                                <option v-for="(resource,index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                            </selectize>
                                        </div>

                                        <div class="col-sm-12" v-show="editInput.category_id == 3 && resource_detail_modal.length > 0">
                                            <label class="control-label">Resource Detail</label>
                                            <selectize v-model="editInput.resource_detail_id" :settings="resourceDetailSettings">
                                                <option v-for="(rd, index) in selectedRDModal" :value="rd.id">{{ rd.code }}</option>
                                            </selectize>
                                        </div>
                                        <div class="col-sm-12" v-show="editInput.category_id == 3 && resource_detail_modal.length < 1">
                                            <label class="control-label">Resource Detail</label>
                                            <selectize v-model="editInput.null" :settings="nullRdSettings" disabled>
                                                <option v-for="(rd, index) in selectedRD" :value="rd.id">{{ rd.code }}</option>
                                            </selectize>
                                        </div>
                                        <div class="col-sm-12" v-show="editInput.category_id != 3">
                                            <label class="control-label">Resource Detail</label>
                                            <selectize id="material" v-model="editInput.null" :settings="otherSettings" disabled>
                                                <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                            </selectize>
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="control-label">Quantity</label>
                                            <input type="text" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
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
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const form = document.querySelector('form#assign-resource');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        wbs : @json($wbs),
        route : @json($route),
        resources : @json($resources),
        resourceDetails : @json($resourceDetails),
        resource_categories : @json($resource_categories),
        resourceProfile : [],
        selectedRD : [],
        newIndex : "",
        dataInput : {
            resource_id :"",
            wbs_id : @json($wbs->id),
            quantity : "",
            category_id : "",
            resource_detail_id : "",
            null : ""
        },
        editInput : {
            wbs_id : @json($wbs->id),
            category_id : "",
            resource_id :"",
            resource_detail_id : "",
            old_resource_detail_id : "",
            quantity : "",
            null : "",
            id : ""
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        resourceDetailSettings: {
            placeholder: 'Select Resource Detail (Optional)'
        },
        nullSettings: {
            placeholder: 'Please Select Category First'
        },
        nullResourceSettings: {
            placeholder: 'Please Select Resource First'
        },
        nullRdSettings: {
            placeholder: 'Resource Detail Not Available !'
        },
        categorySettings: {
            placeholder: 'Please Select Category'
        },
        otherSettings: {
            placeholder: '-'
        },
        resource_detail_id : [],
        resource_detail_id_modal : [],
        resource_detail_modal : [],
        selectedRDModal : [],
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el : '#resource',
        data : data,
        computed : {
            resourceDetail : function(){
                let isOk = false;

                if(this.dataInput.resource_detail_id != ""){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.dataInput.resource_id == "" || this.dataInput.quantity == "" || this.dataInput.category_id == ""){
                    isOk = true;
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.editInput.resource_id == "" || this.editInput.quantity == "" || this.editInput.category_id == ""){
                    isOk = true;
                }
                return isOk;
            }
        },

        methods : {
            getCategoryName(id){
                var category = "";
                this.resource_categories.forEach(data => {
                    if(data.id == id){
                        category = data.name;
                    }
                });
                return category;
            },
            getNewRds(jsonRdId){
                window.axios.get('/api/getRdProfiles/'+jsonRdId).then(({ data }) => {
                    this.resourceDetails = data;
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
            getNewModalRds(jsonRdId,newValue){
                window.axios.get('/api/getRdProfiles/'+jsonRdId).then(({ data }) => {
                    this.resource_detail_modal = data;

                    this.selectedRDModal = [];
                    this.resource_detail_modal.forEach(data => {
                        if(data.resource_id == newValue){
                            this.selectedRDModal.push(data);
                        }
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
            getResourceProfile(wbs_id){
                window.axios.get('/api/getResourceProfile/'+wbs_id).then(({data}) =>{
                    this.resource_detail_id = [];
                    this.resourceProfile = data;

                    this.resourceProfile.forEach(data =>{
                        if(data.resource_detail_id != null){
                            this.resource_detail_id.push(data.resource_detail_id);
                        }
                        data.quantity = (data.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                    });

                    var jsonRdId = JSON.stringify(this.resource_detail_id);
                    this.getNewRds(jsonRdId); 
                    this.newIndex = this.resourceProfile.length + 1;
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
            tooltipText: function(text) {
                return text
            },
            add(){
                $('div.overlay').show(); 
                let status = 0;

                this.resourceProfile.forEach(data=>{
                    if(data.resource_detail_id == null){
                        data.resource_detail_id = "";
                    }
                    if(data.category_id == this.dataInput.category_id && data.resource_id == this.dataInput.resource_id && data.resource_detail_id == this.dataInput.resource_detail_id){
                        status = 1;
                    }
                })

                if(status == 0){
                    this.dataInput.quantity = parseInt((this.dataInput.quantity+"").replace(/,/g , ''));           
                    var data = this.dataInput;
                    data = JSON.stringify(data);
                    if(this.route == "/wbs"){
                        var url = "{{ route('wbs.storeResourceProfile') }}";
                    }else if(this.route == "/wbs_repair"){
                        var url = "{{ route('wbs_repair.storeResourceProfile') }}";
                    }
                    window.axios.post(url,data).then((response) => {
                        iziToast.success({
                            displayMode: 'replace',
                            title: 'Success add resource !',
                            position: 'topRight',
                        });

                        this.dataInput.category_id = "";
                        this.dataInput.resource_id = "";
                        this.dataInput.resource_detail_id = "";
                        this.dataInput.quantity = "";
                        this.dataInput.quantity = "";   
                        this.getResourceProfile(this.wbs.id);
                        $('div.overlay').hide();            
                    })
                    .catch((error) => {
                        iziToast.warning({
                            displayMode: 'replace',
                            title: 'Please Try Again !',
                            position: 'topRight',
                        });
                        console.log(error);
                        $('div.overlay').hide();            
                    })
                }else{
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'Cannot Add Same Resource !',
                        position: 'topRight',
                    });
                    $('div.overlay').hide();            
                }
            },
            openEditModal(data,index){
                $('div.overlay').show();
                this.editInput.category_id = data.category_id;
                this.editInput.resource_id = data.resource_id;
                this.editInput.resource_detail_id = data.resource_detail_id;
                this.editInput.old_resource_detail_id = data.resource_detail_id;
                this.editInput.quantity = data.quantity;
                this.editInput.id = data.id;
                $('#edit_item').modal();
                $('div.overlay').hide();
            },
            update(){
                $('div.overlay').show();   
                if(this.route == "/wbs"){
                    var url = "/wbs/updateResourceProfile";
                }else if(this.route == "/wbs_repair"){
                    var url = "/wbs_repair/updateResourceProfile";
                }         
                let editInput = JSON.stringify(this.editInput);

                window.axios.put(url,editInput).then((response) => {
                    iziToast.success({
                        displayMode: 'replace',
                        title: 'Success update resource',
                        position: 'topRight',
                    });
                    $('div.overlay').hide();            
                    this.getResourceProfile(this.wbs.id);
                })
                .catch((error) => {
                    $('div.overlay').hide();            
                })
            },
            removeRow: function(id) {
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to delete this resource?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            var url = "";
                            if(vm.route == "/wbs"){
                                url = "/wbs/deleteResourceProfile/"+id;
                            }else if(vm.route == "/wbs_repair"){
                                url = "/wbs_repair/deleteResourceProfile/"+id;
                            }
                            $('div.overlay').show();            
                            window.axios.delete(url).then((response) => {
                                if(response.data.error != undefined){
                                    response.data.error.forEach(error => {
                                        iziToast.warning({
                                            displayMode: 'replace',
                                            title: error,
                                            position: 'topRight',
                                        });
                                    });
                                    $('div.overlay').hide();
                                }else{
                                    iziToast.success({
                                        displayMode: 'replace',
                                        title: response.data.response,
                                        position: 'topRight',
                                    });
                                    $('div.overlay').hide();   
                                    vm.getResourceProfile(vm.wbs.id);
                                }
                            })
                            .catch((error) => {
                                iziToast.warning({
                                    displayMode: 'replace',
                                    title: "Please try again.. ",
                                    position: 'topRight',
                                });
                                console.log(error);
                                $('div.overlay').hide();            
                            })

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ],
                });
            },
        },
        watch : {
            'dataInput.quantity': function(newValue){
                this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'editInput.quantity': function(newValue){
                this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'dataInput.resource_id' : function(newValue){
                this.selectedRD = [];
                this.dataInput.resource_detail_id = '';
                this.dataInput.quantity = '';
                this.resourceDetails.forEach(data => {
                    if(data.resource_id == newValue){
                        this.selectedRD.push(data);
                    }
                })
            },
            'dataInput.category_id' : function(newValue){
                this.selectedRD = [];
                this.dataInput.resource_id = '';
                this.dataInput.resource_detail_id = '';
                this.dataInput.quantity = '';
            },
            'dataInput.resource_detail_id': function(newValue){
                if(newValue != ''){
                    this.dataInput.quantity = 1;
                }else{
                    this.dataInput.quantity = '';
                }
            },
            'editInput.resource_id' : function(newValue){
                if(newValue == ""){
                    this.editInput.resource_detail_id = "";
                }else{
                    var resource_detail_id = JSON.stringify(this.resource_detail_id);
                    resource_detail_id = JSON.parse(resource_detail_id);

                    this.resource_detail_id_modal = resource_detail_id;
                    if(this.editInput.resource_detail_id != null || this.editInput.resource_detail_id != ''){
                        this.resource_detail_id_modal.forEach(id => {
                            if(id == this.editInput.resource_detail_id){
                                var index = this.resource_detail_id_modal.indexOf(id);
                                this.resource_detail_id_modal.splice(index, 1);
                            }
                        });
                    }
                    var jsonRdId = JSON.stringify(this.resource_detail_id_modal);
                    this.getNewModalRds(jsonRdId,newValue);
                }
            },
        },
        created: function() {
            this.getResourceProfile(this.wbs.id);
        }
    });
</script>
@endpush
