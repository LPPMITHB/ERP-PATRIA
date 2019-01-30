@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Assign Resources',
        'items' => [
            'Dashboard' => route('index'),
            'Assign Resources' => route('resource.assignResource'),
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
                @csrf
                    @verbatim
                    <div id="assignRsc">
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
                                <selectize v-model="project_id" :settings="projectSettings">
                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }} - {{ project.name }}</option>
                                </selectize>  
                            </div>
                        </div>
                        <template v-if="selectedProject.length > 0">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                    <table id="assign-rsc" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 25%">Resource</th>
                                                <th style="width: 25%">WBS Name</th>
                                                <th style="width: 20%">Quantity</th>
                                                <th style="width: 15%">Status</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in modelAssignResource">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ data.resource.code }} - {{ data.resource.name }}</td>
                                                <td>{{ data.wbs.name }}</td>
                                                <td>{{ data.quantity }}</td>
                                                <td v-if="data.wbs_id == null">{{ "Not Assigned" }}</td>
                                                <td v-else>{{ "Assigned" }}</td>
                                                <td class="p-l-3 textCenter">
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(data,index)">
                                                        EDIT
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <td class="p-l-10">{{newIndex}}</td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource,index) in modelResources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in modelWBS" :value="wbs.id">{{ wbs.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <input type="text" v-model="dataInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </td>
                                            <td>
                                                {{ "Not Assign" }}
                                            </td>
                                            <td class="p-l-0 textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Assign Resource</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="control-label">Resource</label>
                                                <selectize v-model="editInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource,index) in modelResources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="control-label">WBS Name</label>
                                                <selectize v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in modelWBS" :value="wbs.id">{{ wbs.name }}</option>
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
    const form = document.querySelector('form#assign-resource');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        route : @json($route),
        modelResources : @json($resources),
        projects : @json($modelProject),
        selectedProject : [],
        project_id : "",
        modelWBS : [],
        modelAssignResource : [],
        newIndex : "",
        dataInput : {
            resource_id :"",
            wbs_id : "",
            quantity : "",
        },
        editInput : {
            resource_id :"",
            wbs_id : "",
            quantity : "",
        },
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        wbsSettings: {
            placeholder: 'Please Select WBS'
        },
    }

    var vm = new Vue({
        el : '#assignRsc',
        data : data,

        computed : {
            createOk: function(){
                let isOk = false;

                if(this.dataInput.resource_id == "" || this.dataInput.quantity == "" || this.dataInput.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            },

            updateOk: function(){
                let isOk = false;

                if(this.editInput.resource_id == "" || this.editInput.wbs_id == "" || this.editInput.quantity == ""){
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
            getResource(){
                window.axios.get('/api/getResourceTrx/' + this.project_id).then(({ data }) => {
                    this.modelAssignResource = data;
                    this.newIndex = Object.keys(this.modelAssignResource).length+1;
                });
            },
            add(){
                $('div.overlay').show();            
                this.dataInput.project_id = this.project_id;
                var dataInput = this.dataInput;
                dataInput = JSON.stringify(dataInput);
                if(this.route == "/resource"){
                    var url = "{{ route('resource.storeAssignResource') }}";
                }else if(this.route == "/resource_repair"){
                    var url = "{{ route('resource_repair.storeAssignResource') }}";
                }
                window.axios.post(url,dataInput).then((response) => {
                    if(response.data.error != undefined){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: response.data.error,
                            position: 'topRight',
                        });
                        $('div.overlay').hide();            
                    }else{
                        iziToast.success({
                            displayMode: 'replace',
                            title: response.data.response,
                            position: 'topRight',
                        });
                        $('div.overlay').hide();            
                    }
                    
                    this.getResource();
                    this.dataInput.resource_id = "";
                    this.dataInput.project_id = "";
                    this.dataInput.wbs_id = "";             
                    this.dataInput.quantity = "";             
                })
                .catch((error) => {
                    console.log(error);
                    $('div.overlay').hide();            
                })
                
            },
            update(){
                $('div.overlay').show();   
                if(this.route == "/resource"){
                    var url = "/resource/updateAssignResource/"+this.editInput.id;
                }else if(this.route == "/resource_repair"){
                    var url = "/resource_repair/updateAssignResource/"+this.editInput.id;
                }         
                let editInput = JSON.stringify(this.editInput);

                window.axios.put(url,editInput).then((response) => {
                    if(response.data.error != undefined){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: response.data.error,
                            position: 'topRight',
                        });
                        $('div.overlay').hide();            
                    }else{
                        iziToast.success({
                            displayMode: 'replace',
                            title: response.data.response,
                            position: 'topRight',
                        });
                        $('div.overlay').hide();            
                    }
                    
                    this.getResource();   
                })
                .catch((error) => {
                    $('div.overlay').hide();            
                })
            },
            openEditModal(data,index){
                this.editInput.id = data.id
                this.editInput.resource_id = data.resource_id;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.quantity = data.quantity;
            },
        },
        watch : {
            'project_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    this.getResource();

                    window.axios.get('/api/getProjectPR/'+newValue).then(({ data }) => {
                        this.selectedProject = [];
                        this.selectedProject.push(data);
                        
                        window.axios.get('/api/getWbsAssignResource/'+newValue).then(({ data }) => {
                            this.modelWBS = data;
                        })
                        .catch((error) => {
                            iziToast.warning({
                                title: 'Please Try Again..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            $('div.overlay').hide();
                        })
                        this.dataInput.resource_id = "";
                        this.dataInput.wbs_id = "";
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
                    this.selectedProject = [];
                }

                function myFunction(x) {
                    if (x.matches) { // If media query matches
                        $('.table').wrap('<div class="dataTables_scroll" />');
                    } 
                }

                var x = window.matchMedia("(max-width: 500px)")
                myFunction(x) // Call listener function at run time
                x.addListener(myFunction) // Attach listener function on state changes

                var x = window.matchMedia("(max-width: 1024px)")
                myFunction(x) // Call listener function at run time
                x.addListener(myFunction) // Attach listener function on state changes
                
            },
            'dataInput.quantity': function(newValue){
                this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'editInput.quantity': function(newValue){
                this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
        },
    });
</script>
@endpush
