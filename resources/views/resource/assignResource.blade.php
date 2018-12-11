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
                        <div class="row">
                            <template v-if="selectedResource.length > 0">
                                <div class="col-sm-12">
                                    <div class="col-sm-2">
                                        Resource Code
                                    </div>
                                    <div class="col-sm-10">
                                        : <b>{{ selectedResource[0].code }}</b>
                                    </div>
                                    <div class="col-sm-2">
                                        Name
                                    </div>
                                    <div class="col-sm-10">
                                        : <b>{{ selectedResource[0].name }}</b>
                                    </div>
                                    <div class="col-sm-2">
                                        Description
                                    </div>
                                    <div class="col-sm-10">
                                        : <b>{{ selectedResource[0].description }}</b>
                                    </div>
                                    <div class="col-sm-2">
                                        Unit Of Measurement
                                    </div>
                                    <div class="col-sm-10">
                                        : <b>{{ selectedResource[0].uom.name }}</b>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="row">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table id="assign-rsc" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 25%">Resource</th>
                                            <th style="width: 25%">Project Name</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 18%">Work Name</th>
                                            <th style="width: 12%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(datas,index) in modelAssignResource">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ datas.resource.name }}</td>
                                            <td>{{ datas.project.name }}</td>
                                            <template v-if="datas.wbs_id == null">

                                                <td>{{ "Not Assigned" }}</td>
                                            
                                            </template>
                                            <template v-else>
                                            
                                                <td>{{ "Assigned" }}</td>
                                            
                                            </template>     
                                            <td>
                                                {{ datas.work.name }}
                                            </td>
                                            <td class="p-l-3 textCenter">
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(datas,index)">
                                                    EDIT
                                                </a>
                                                <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                    <tfoot>
                                        <td class="p-l-10"></td>
                                        <td class="p-l-0 textLeft">
                                            <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                <option v-for="(resource,index) in modelResources" :value="resource.id">{{ resource.name }}</option>
                                            </selectize>
                                        </td>
                                        <td class="p-l-0">
                                            <selectize v-model="dataInput.project_id" :settings="projectSettings">
                                                <option v-for="(project,index) in modelProjects" :value="project.id">{{ project.name }}</option>
                                            </selectize>
                                        </td>
                                        <td>
                                            {{ "Not Assign" }}
                                        </td>
                                        <td class="p-l-0 textLeft">
                                            <selectize v-model="dataInput.wbs_id" :settings="workSettings">
                                                <option v-for="(work, index) in workDetail" :value="work.id">{{ work.name }}</option>
                                            </selectize>
                                        </td>
                                        <td class="p-l-0 textCenter">
                                            <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
                                                <label for="type" class="control-label">Resource</label>
                                                <selectize v-model="editInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource,index) in modelResources" :value="resource.id">{{ resource.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Project Name</label>
                                                <selectize v-model="editInput.project_id" :settings="projectSettings">
                                                    <option v-for="(project,index) in modelProjects" :value="project.id">{{ project.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="work_name" class="control-label">Work Name</label>
                                                <selectize v-model="editInput.wbs_id" :settings="workSettings">
                                                    <option v-for="(work, index) in workDetail" :value="work.id">{{ work.name }}</option>
                                                </selectize>
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

        modelResources : @json($resources),
        modelProjects : @json($projects),
        modelAssignResource : "",
        newIndex : "",
        dataWork : "",


        dataInput : {
            project_id : "",
            resource_id :"",
            wbs_id : "",
            category_id : "",
            quantity : "",
        },

        editInput : {
            resourcedetail_id : "",
            project_id : "",
            resource_id :"",
            wbs_id : "",
            category_id : "",
            quantity : "",
        },

        resourceSettings: {
            placeholder: 'Please Select Resource'
        },

        projectSettings: {
            placeholder: 'Please Select Project'
        },

        workSettings: {
            placeholder: 'Please Select Work'
        },

        selectedResource : [],
        workDetail : [],

    }

    var vm = new Vue({
        el : '#assignRsc',
        data : data,

        computed : {

            createOk: function(){
                let isOk = false;

                if(this.dataInput.resource_id == "" || this.dataInput.project_id == "" || this.dataInput.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            },

            updateOk: function(){
                let isOk = false;

                if(this.editInput.resource_id == "" || this.editInput.project_id == "" || this.editInput.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            }
        },

        methods : {
            add(){
                var dataInput = this.dataInput;
                var resource_id = this.dataInput.resource_id;
                window.axios.get('/api/getCategoryAR/'+resource_id).then(({ data }) => {
                    this.dataInput.category_id = data.category_id;
                    this.dataInput.quantity = data.quantity;
                    dataInput = JSON.stringify(dataInput);
                    var url = "{{ route('resource.storeAssignResource') }}";
                    $('div.overlay').show();            
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
                    })
                    .catch((error) => {
                        console.log(error);
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

            getResource(){
                window.axios.get('/api/getResourceDetail').then(({ data }) => {
                    this.modelAssignResource = data;
                    this.newIndex = Object.keys(this.modelAssignResource).length+1;

                    $('#assign-rsc').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#assign-rsc').DataTable({
                            'paging'      : true,
                            'lengthChange': false,
                            'searching'   : false,
                            'ordering'    : false,
                            'info'        : true,
                            'autoWidth'   : false,
                            columnDefs : [
                                { targets: 0, sortable: false},
                            ]
                        });
                    })
                });
            },

            update(){
                var editInput = this.editInput;       
                var resource_id = this.editInput.resource_id;
                window.axios.get('/api/getCategoryAR/'+resource_id).then(({ data }) => {
                    this.editInput.category_id = data.category_id;
                    this.editInput.quantity = data.quantity;

                    var url = "/resource/updateAssignResource/"+editInput.resourcedetail_id;
                    editInput = JSON.stringify(editInput);
                    $('div.overlay').show();            
                    window.axios.patch(url,editInput)
                    .then((response) => {
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
                this.editInput.resourcedetail_id = data.id;
                this.editInput.project_id = data.project_id;
                this.editInput.project_name = data.project_name;
                this.editInput.resource_id = data.resource_id;
                this.editInput.resource_name = data.resource_name;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.work_name = data.work_name;
                this.editInput.index = index;
            },

            removeRow(index){
                this.modelAssignResource.splice(index, 1);
                // this.material_id.splice(index, 1);

                // var jsonMaterialId = JSON.stringify(this.material_id);
                // this.getNewMaterials(jsonMaterialId);
                
                this.newIndex = this.modelAssignResource.length + 1;

            },

        },

        watch : {
            'dataInput.resource_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getResourceAssign/'+newValue).then(({ data }) => {
                        this.selectedResource = [];
                        this.selectedResource.push(data);
                        
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
                    this.selectedResource = [];
                }
            },

            'dataInput.project_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWorkAssignResource/'+newValue).then(({ data }) => {
                        this.workDetail = data;

                        
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
                    this.selectedResource = [];
                }
            },

            
            'editInput.project_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getWorkAssignResource/'+newValue).then(({ data }) => {
                        this.workDetail = data;

                        
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
                    this.selectedResource = [];
                }
            },


        },

        created: function() {
            this.getResource();
        },

    });

</script>
@endpush
