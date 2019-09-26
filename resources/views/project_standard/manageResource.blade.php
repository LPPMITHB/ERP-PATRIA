@extends('layouts.main')
@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Resource',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('project_standard.selectProjectResource'),
                'Select WBS' => route('project_standard.selectWBS', ['id'=>$project->id,'action'=>'resource']),
                'Manage Resource' => "",
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 p-b-50">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                @if ($edit)
                    <form id="create-bom" class="form-horizontal" method="POST" action="{{ route('project_standard.updateResourceStandard') }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form id="create-bom" class="form-horizontal" method="POST" action="{{ route('project_standard.storeResourceStandard') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="bom">
                        <div class="box-header p-b-0">
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>Project Standard Information</b></div>
        
                                <div class="col-xs-4 no-padding">Name</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.name)"><b>: {{project.name}}</b></div>

                                <div class="col-xs-4 no-padding">Description</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.number)"><b>: {{project.description}}</b></div>
        
                                <div class="col-xs-4 no-padding">Ship Type</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.ship.type)"><b>: {{project.ship.type}}</b></div>
                            </div>
                            
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                                
                                <div class="col-xs-4 no-padding">Number</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.number)"><b>: {{wbs.number}}</b></div>
        
                                <div class="col-xs-4 no-padding">Description</div>
                                <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: {{wbs.description}}</b></div>
                                <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: -</b></div>
        
                                <div class="col-xs-4 no-padding">Deliverable</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
                            </div>
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-5">
                            <table class="table table-bordered tableFixed m-b-0 tablePagingVue">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Resource Number</th>
                                        <th width="28%">Resource Description</th>
                                        <th width="10%">Quantity</th>
                                        <th width="12%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(resource, index) in resourceTable">
                                        <td>{{ index + 1 }}</td>
                                        <td :id="resource.resource_code" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipCode(resource.resource_code)">{{ resource.resource_code}}</td>
                                        <td :id="resource.resource_name" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipDesc(resource.resource_name)">{{ resource.resource_name }}</td>
                                        <td>{{ resource.quantity }}</td>
                                        <td class="p-l-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="#edit_item" @click="openEditModal(resource,index)">
                                                EDIT
                                            </a>
                                            <a href="#" @click="removeRow(resource)" class="btn btn-danger btn-xs">
                                                <div class="btn-group">DELETE</div>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td colspan="2" class="no-padding">
                                            <selectize class="selectizeFull" id="resource" v-model="input.resource_id" :settings="resourceSettings">
                                                <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.description }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control" type="text" v-model="input.quantity" :disabled="resourceOk"></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12 p-t-5">
                            <button v-if="submittedForm.edit" id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">SAVE</button>
                            <button v-else id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                        </div>
                        <div class="modal fade" id="edit_item">
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
                                                <label for="type" class="control-label">Resource</label>
                                                <selectize id="edit_modal" v-model="editInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource, index) in resources_modal" :value="resource.id">{{ resource.code }} - {{ resource.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity" :disabled="editResourceOk">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Unit</label>
                                                <input type="text" id="quantity" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_resource_id, editInput.resource_id)">SAVE</button>
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
    const form = document.querySelector('form#create-bom');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        sources : ['Stock','WIP'],
        project : @json($project),
        resources : @json($resources),
        wbs : @json($wbs),
        newIndex : 0, 
        submittedForm :{
            project_id : @json($project->id),
            wbs_id : @json($wbs->id),
            edit : @json($edit),
            deleted_id : [],
        },
        input : {
            resource_id : "",
            resource_name : "",
            resource_code : "",
            quantity : "",
            resource_ok : ""
        },
        editInput : {
            old_resource_id : "",
            resource_id : "",
            resource_code : "",
            resource_name : "",
            quantity : "",
            resource_ok : ""
        },
        resourceTable : @json($existing_data),
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        sourceSettings: {
            placeholder: 'Please Select Source'
        },
        resource_id:@json($resource_ids),
        resource_id_modal:[],
        resources_modal :[],
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el : '#bom',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                if(this.input.resource_id == "" || this.input.quantity == "" || this.input.source == ""){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.resourceTable.length < 1){
                    isOk = true;
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.editInput.resource_id == "" || this.editInput.quantity == "" || this.editInput.source == ""){
                    isOk = true;
                }

                return isOk;
            },
            resourceOk : function(){
                let isOk = false;

                if(this.input.resource_ok == ""){
                    isOk = true;
                }

                return isOk;
            },
            editResourceOk : function(){
                let isOk = false;

                if(this.editInput.resource_ok == ""){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            refreshTooltip: function(code,description){
                Vue.directive('tooltip', function(el, binding){
                    if(el.id == code){
                        $(el).tooltip('destroy');
                        $(el).tooltip({
                            title: el.id,
                            placement: binding.arg,
                            trigger: 'hover'             
                        })
                    }else if(el.id == description){
                        $(el).tooltip('destroy');
                        $(el).tooltip({
                            title: el.id,
                            placement: binding.arg,
                            trigger: 'hover'             
                        })
                    }
                })
            },
            tooltipCode: function(code) {
                return code;
            },
            tooltipDesc: function(desc) {
                return desc;
            },
            getNewResource(jsonResourceId){
                window.axios.get('/api/getResourcesProjectStandard/'+jsonResourceId).then(({ data }) => {
                    this.resources = data;
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
            getNewModalResource(jsonResourceId){
                window.axios.get('/api/getResourcesProjectStandard/'+jsonResourceId).then(({ data }) => {
                    this.resources_modal = data;
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
            },
            openEditModal(data,index){
                $('div.overlay').show();
                this.editInput.resource_id = data.resource_id;
                this.editInput.old_resource_id = data.resource_id;
                this.editInput.resource_code = data.resource_code;
                this.editInput.resource_name = data.resource_name;
                this.editInput.quantity = data.quantity;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_number = data.wbs_number;
                this.editInput.index = index;
                this.editInput.source = data.source;
                this.editInput.unit = data.unit;
                this.editInput.is_decimal = data.is_decimal;

                var resource_id = JSON.stringify(this.resource_id);
                resource_id = JSON.parse(resource_id);
                
                this.resource_id_modal = resource_id;
                this.resource_id_modal.forEach(id => {
                    if(id == data.resource_id){
                        var index = this.resource_id_modal.indexOf(id);
                        this.resource_id_modal.splice(index, 1);
                    }
                });
                var jsonResourceId = JSON.stringify(this.resource_id_modal);
                this.getNewModalResource(jsonResourceId);
            },
            submitForm(){
                $('div.overlay').show();
                this.resourceTable.forEach(data=>{
                    data.quantity = (data.quantity+"").replace(/,/g , '');
                })
                this.submittedForm.resources = this.resourceTable;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            submitToTable(){
                if(this.input.resource_id != "" && this.input.resource_name != "" && this.input.quantity != "" && this.input.source != ""){
                    $('div.overlay').show();

                    var data = JSON.stringify(this.input);
                    data = JSON.parse(data);
                    this.resourceTable.push(data);

                    this.resource_id.push(data.resource_id); //ini buat nambahin resource_id terpilih

                    var jsonResourceId = JSON.stringify(this.resource_id);
                    this.getNewResource(jsonResourceId);             

                    this.newIndex = this.resourceTable.length + 1;  

                    // refresh tooltip
                    let datas = [];
                    datas.push(this.input.resource_code,this.input.resource_name);
                    datas = JSON.stringify(datas);
                    datas = JSON.parse(datas);
                    this.refreshTooltip(datas[0],datas[1]);

                    this.input.resource_id = "";
                    this.input.resource_code = "";
                    this.input.resource_name = "";
                    this.input.quantity = "";
                    this.input.quantityInt = 0;
                }
            },
            removeRow: function(resource) {
                $('div.overlay').show();
                var index_resourceId = "";
                var index_resourceTable = "";
                if(typeof resource.id !== 'undefined'){
                    this.submittedForm.deleted_id.push(resource.id);
                }
                
                this.resource_id.forEach(id => {
                    if(id == resource.resource_id){
                        index_resourceId = this.resource_id.indexOf(id);
                    }
                });
                for (var i in this.resourceTable) { 
                    if(this.resourceTable[i].resource_id == resource.resource_id){
                        index_resourceTable = i;
                    }
                }

                this.resourceTable.splice(index_resourceTable, 1);
                this.resource_id.splice(index_resourceId, 1);
                this.newIndex = this.resourceTable.length + 1;

                var jsonResourceId = JSON.stringify(this.resource_id);
                this.getNewResource(jsonResourceId);
            },
            update(old_resource_id, new_resource_id){
                this.resourceTable.forEach(resource => {
                    if(resource.resource_id == old_resource_id){
                        var resource = this.resourceTable[this.editInput.index];
                        resource.quantityInt = this.editInput.quantityInt;
                        resource.quantity = this.editInput.quantity;
                        resource.resource_id = new_resource_id;
                        resource.wbs_id = this.editInput.wbs_id;
                        resource.source = this.editInput.source;

                        var elemCode = document.getElementById(resource.resource_code);
                        var elemDesc = document.getElementById(resource.resource_name);

                        window.axios.get('/api/getResourceProjectStandard/'+new_resource_id).then(({ data }) => {
                            resource.resource_name = data.description;
                            resource.resource_code = data.code;

                            this.resource_id.forEach(id => {
                                if(id == old_resource_id){
                                    var index = this.resource_id.indexOf(id);
                                    this.resource_id.splice(index, 1);
                                }
                            });
                            this.resource_id.push(new_resource_id);

                            var jsonResourceId = JSON.stringify(this.resource_id);
                            this.getNewResource(jsonResourceId);

                            // refresh tooltip
                            elemCode.id = data.code;
                            elemDesc.id = data.description;
                            this.refreshTooltip(elemCode.id,elemDesc.id);

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
                });
            },
        },
        watch: {
            'input.resource_id': function(newValue){
                this.input.quantity = "";
                if(newValue != ""){
                    this.input.resource_ok = "ok";
                    window.axios.get('/api/getResourceProjectStandard/'+newValue).then(({ data }) => {
                        this.input.resource_name = data.description;
                        this.input.resource_code = data.code;
                    });
                }else{
                    this.input.resource_name = "";
                    this.input.resource_code = "";
                    this.input.resource_ok = "";
                }
            },
            'editInput.resource_id': function(newValue){
                if(newValue != this.editInput.old_resource_id){
                    this.editInput.quantity = "";
                }
                if(newValue != ""){
                    this.editInput.resource_ok = "ok";
                    window.axios.get('/api/getResourceProjectStandard/'+newValue).then(({ data }) => {
                        this.editInput.resource_name = data.description;
                        this.editInput.resource_code = data.code;
                    });
                }else{
                    this.editInput.resource_name = "";
                    this.editInput.resource_code = "";
                    this.editInput.resource_ok = "";
                }
            },
            'input.quantity': function(newValue){
                if(newValue != ""){
                    this.input.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'editInput.quantity': function(newValue){
                if(newValue != ""){
                    this.editInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }  
            },
        },
        created: function() {
            this.newIndex = this.resourceTable.length + 1;
            var jsonResourceId = JSON.stringify(this.resource_id);
            this.getNewResource(jsonResourceId);        
        }
    });
       
</script>
@endpush
