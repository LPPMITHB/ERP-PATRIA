@extends('layouts.main')

@section('content-header')
@if($route == "/production_order")
    @breadcrumb(
        [
            'title' => 'Create Production Order',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProject'),
                'Select WBS' => route('production_order.selectWBS', ['id' => $project->id]),
                'Add Additional Material & Resource' => ''
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/production_order_repair")
    @breadcrumb(
        [
            'title' => 'Create Production Order',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order_repair.selectProject'),
                'Select WBS' => route('production_order_repair.selectWBS', ['id' => $project->id]),
                'Add Additional Material & Resource' => ''
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12 col-lg-4 col-md-12 no-padding">
                    <div class="box-body no-padding">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Code</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-lg-4 col-md-12 no-padding">
                    <div class="col-sm-12 no-padding"><b>WBS Information</b></div>

                    <div class="col-md-4 col-xs-4 no-padding">Name</div>
                    <div class="col-md-6 col-xs-8 no-padding"><b>: {{$wbs->name}}</b></div>
                    
                    <div class="col-md-4 col-xs-4 no-padding">Description</div>
                    <div class="col-md-6 col-xs-8 no-padding"><b>: {{$wbs->description}}</b></div>

                    <div class="col-md-4 col-xs-4 no-padding">Deliverables</div>
                    <div class="col-md-6 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$wbs->deliverables}}"><b>: {{$wbs->deliverables}}</b></div>
                    
                    <div class="col-md-4 col-xs-4 no-padding">Deadline</div>
                    <div class="col-md-6 col-xs-8 no-padding"><b>: @php
                            $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_deadline);
                            $date = $date->format('d-m-Y');
                            echo $date;
                        @endphp
                        </b>
                    </div>
                    <div class="col-md-4 col-xs-4 no-padding">Progress</div>
                    <div class="col-md-4 col-xs-8 no-padding"><b>: {{$wbs->progress}}%</b></div>
                </div>
            </div>

            <div class="box-body p-t-0 p-b-5">
                <h4>Activity</h4>
                <table class="table table-bordered showTable tableFixed" id="activity-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Activity Name</th>
                            <th width="30%">Description</th>
                            <th width="15%">Planned Start Date</th>
                            <th width="15%">Planned End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter=1)
                        @foreach($modelActivities as $activity)
                            @if($activity->id != "")
                                @php($planned_start_date = DateTime::createFromFormat('Y-m-d', $activity->planned_start_date))
                                @php($planned_start_date = $planned_start_date->format('d-m-Y'))
                                @php($planned_end_date = DateTime::createFromFormat('Y-m-d', $activity->planned_end_date))
                                @php($planned_end_date = $planned_end_date->format('d-m-Y'))
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$activity->name}}">{{ $activity->name }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$activity->description}}">{{ $activity->description }}</td>
                                    <td>{{ $planned_start_date }}</td>
                                    <td>{{ $planned_end_date }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->

            <div class="box-body p-t-0 p-b-5">
                <h4>Material</h4>
                <table class="table table-bordered showTable tableFixed" id="material-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Material Name</th>
                            <th width="30%">Description</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Unit</th>
                            <th width="10%">Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($modelBOM->bomDetails as $BOMD)
                            @if($BOMD->material_id != "")
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $BOMD->material->code }} - {{ $BOMD->material->name }}">{{ $BOMD->material->code }} - {{ $BOMD->material->name }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $BOMD->material->description }}">{{ $BOMD->material->description }}</td>
                                    <td>{{ number_format($BOMD->quantity) }}</td>
                                    <td>{{ $BOMD->material->uom->unit }}</td>
                                    <td>{{ $BOMD->source }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->

            <div class="box-body p-t-0 p-b-5">
                <h4>Resource</h4>
                <table class="table table-bordered showTable tableFixed" id="resource-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Resource Name</th>
                            <th width="30%">Description</th>
                            <th width="30%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelRD as $RD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $RD->resource->code }} - {{ $RD->resource->name }}">{{ $RD->resource->code }} - {{ $RD->resource->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $RD->resource->description }}">{{ $RD->resource->description }}</td>
                                <td>{{ $RD->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
            
            @if($route == '/production_order_repair')
            <div class="box-body p-t-0 p-b-5">
                    <h4>Service</h4>
                <table class="table table-bordered showTable" id="service-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Service Name</th>
                            <th width="30%">Description</th>
                            <th width="30%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($modelBOM->bomDetails as $BOMD)
                            @if($BOMD->service_id != "")
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $BOMD->service->code }} - {{ $BOMD->service->name }}">{{ $BOMD->service->code }} - {{ $BOMD->service->name }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $BOMD->service->description }}">{{ $BOMD->service->description }}</td>
                                    <td>{{ number_format($BOMD->quantity) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
            @endif

            @if($route == "/production_order")
                <form id="create-wo" class="form-horizontal" method="POST" action="{{ route('production_order.store') }}">
            @elseif($route == "/production_order_repair")
                <form id="create-wo" class="form-horizontal" method="POST" action="{{ route('production_order_repair.store') }}">
            @endif
                @csrf
            @verbatim
            <div id="production_order">
                <div class="box-body">
                    <h4 class="box-title m-t-0" v-if="route == '/production_order'">Add Additional Material / Resource</h4>
                    <h4 class="box-title m-t-0" v-else-if="route == '/production_order_repair'">Add Additional Material / Resource / Service</h4>
                    <table id="activity-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 10%">Type</th>
                                <th style="width: 30%">Name</th>
                                <th style="width: 35%">Description</th>
                                <th style="width: 10%">Quantity</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in datas">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.type }}</td>
                                <td class="tdEllipsis">{{ data.code }} - {{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="tdEllipsis">{{ data.quantity }}</td>
                                <td class="p-l-0 textCenter">
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(data,index)">
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
                                <td class="p-l-0 textLeft" v-if="route == '/production_order'">
                                    <selectize v-model="dataInput.type" :settings="typeSettings">
                                        <option value="Material">Material</option>
                                        <option value="Resource">Resource</option>
                                    </selectize>
                                </td>
                                <td class="p-l-0 textLeft" v-else-if="route == '/production_order_repair'">
                                    <selectize v-model="dataInput.type" :settings="typeSettings">
                                        <option value="Material">Material</option>
                                        <option value="Resource">Resource</option>
                                        <option value="Service">Service</option>
                                    </selectize>
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.type == 'Material'">
                                    <selectize v-model="dataInput.id" :settings="materialSettings" >
                                        <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                    </selectize>  
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.type == 'Resource'">
                                    <selectize v-model="dataInput.id" :settings="resourceSettings" >
                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                    </selectize>  
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.type == 'Service'">
                                    <selectize v-model="dataInput.id" :settings="serviceSettings" >
                                        <option v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }}</option>
                                    </selectize>  
                                </td>
                                <td class="p-l-0 textLeft" v-show="dataInput.type == ''">
                                    <selectize v-model="dataInput.id" :settings="nullSettings" disabled>
                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                    </selectize>  
                                </td>
                                <td class="p-l-0">
                                    <input class="form-control" v-model="dataInput.description" placeholder="-" disabled>
                                </td>
                                <td class="p-l-0" v-if="dataInput.id != ''">
                                    <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity"> 
                                </td>
                                <td class="p-l-0" v-else>
                                    <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity" disabled> 
                                </td>
                                <td class="p-l-0 textCenter">
                                    <button @click.prevent="add"  class="btn btn-primary btn-xs" :disabled ="dataOk">ADD</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="col-md-12 p-t-10 p-r-0">
                        <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                    </div>
                </div>

                <div class="modal fade" id="edit_item">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Edit Additional Material / Service / Resource</h4>
                            </div>
                            <div class="modal-body p-t-0">
                                <div class="row" v-if="editInput.type == 'Material'">
                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Material Name</label>
                                        <selectize v-model="editInput.id" disabled>
                                            <option v-for="(material, index) in materials" :value="material.id" disabled>{{ material.code }} - {{ material.name }}</option>
                                        </selectize>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Description</label>
                                        <input class="form-control" v-model="editInput.description" disabled>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Quantity</label>
                                        <input class="form-control" v-model="editInput.quantity">
                                    </div>
                                </div>

                                <div class="row" v-if="editInput.type == 'Resource'">
                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Resource Name</label>
                                        <selectize v-model="editInput.id" disabled>
                                            <option v-for="(resource, index) in resources" :value="resource.id" disabled>{{ resource.code }} - {{ resource.brand }}</option>
                                        </selectize>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Description</label>
                                        <input class="form-control" v-model="editInput.description" disabled>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Quantity</label>
                                        <input class="form-control" v-model="editInput.quantity">
                                    </div>
                                </div>

                                <div class="row" v-if="editInput.type == 'Service'">
                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Service Name</label>
                                        <selectize v-model="editInput.id" disabled>
                                            <option v-for="(service, index) in services" :value="service.id" disabled>{{ service.code }} - {{ service.name }}</option>
                                        </selectize>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Description</label>
                                        <input class="form-control" v-model="editInput.description" disabled>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Quantity</label>
                                        <input class="form-control" v-model="editInput.quantity">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" :disabled="editOk" data-dismiss="modal" @click.prevent="submitToTable">SAVE</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endverbatim
        </form>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-wo');
    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        dataInput : {
            id : "",
            type :"",
            code : "",
            name : "",
            description : "",
            quantity : "",
        },
        typeSettings: {
            placeholder: 'Please Select Type'
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        serviceSettings: {
            placeholder: 'Please Select Service'
        },
        nullSettings:{
            placeholder: 'Please Select Type First !'
        },
        datas : [],
        project_id :@json($project->id),
        wbs_id :@json($wbs->id),
        materials : @json($materials),
        resources : @json($resources),
        services : @json($services),
        bom : @json($modelBOM->bomDetails),
        assignedResource : @json($modelRD),
        newIndex : "",
        submittedForm : {},
        route : @json($route),
        editInput : {
            type : "",
            id : "",
            code : "",
            name : "",
            description : "",
            quantity : ""
        }
    };

    var vm = new Vue({
        el: '#production_order',
        data: data,
        computed : {
            dataOk: function(){
                let isOk = false;

                if(this.dataInput.type == "" || this.dataInput.id == "" || this.dataInput.quantity == "" || parseInt(this.dataInput.quantity.replace(/,/g , '')) < 1){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.materials.length < 1 && this.resources.length < 1){
                    isOk = true;
                }
                return isOk;
            },
            editOk: function(){
                let isOk = false;

                if(this.editInput.quantity == ''){
                    isOk = true;
                }
                return isOk;
            }
        },
        methods: {
            clearEditInput(){
                this.editInput.type = "";
                this.editInput.id = "";
                this.editInput.code = "";
                this.editInput.name = "";
                this.editInput.description = "";
                this.editInput.quantity = "";
            },
            openEditModal(data,index){
                this.clearEditInput();
                this.editInput.index = index;
                this.editInput.id = data.id;
                this.editInput.description = data.description;
                this.editInput.type = data.type;
                this.editInput.quantity = data.quantity;
            },
            submitToTable(){
                let data = this.datas[this.editInput.index];
                data.quantity = this.editInput.quantity;
            },
            add(){
                var data = JSON.stringify(this.dataInput);
                data = JSON.parse(data);
                this.datas.push(data);
                this.newIndex = this.datas.length + 1;

                this.dataInput.id = "";
                this.dataInput.type = "";
                this.dataInput.code = "";
                this.dataInput.name = "";
                this.dataInput.description = "";
                this.dataInput.quantity = "";
            },
            removeRow: function(index) {
                this.datas.splice(index, 1);
                this.newIndex = this.datas.length + 1;
            },
            submitForm() {
                var datas = this.datas;
                datas = JSON.stringify(datas);
                datas = JSON.parse(datas);

                datas.forEach(data => {
                    data.quantity = data.quantity.replace(/,/g , '');      
                });

                this.submittedForm.datas = datas;
                this.submittedForm.materials = this.bom;
                this.submittedForm.resources = this.assignedResource;
                this.submittedForm.project_id = this.project_id;
                this.submittedForm.wbs_id = this.wbs_id;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch: {
            'dataInput.id': function(newValue){
                if(newValue != ""){
                    if(this.dataInput.type == "Resource"){
                        window.axios.get('/api/getResourcePrO/'+newValue).then(({ data }) => {
                            if(data.description == "" || data.description == null){
                                this.dataInput.description = '-';
                            }else{
                                this.dataInput.description = data.description;
                            }
                            this.dataInput.name = data.name;
                            this.dataInput.code = data.code;
                        });
                    }else if(this.dataInput.type == "Material"){
                        window.axios.get('/api/getMaterialPrO/'+newValue).then(({ data }) => {
                            if(data.description == "" || data.description == null){
                                this.dataInput.description = '-';
                            }else{
                                this.dataInput.description = data.description;
                            }
                            this.dataInput.name = data.name;
                            this.dataInput.code = data.code;
                        });
                    }else if(this.dataInput.type == "Service"){
                        window.axios.get('/api/getServicePrO/'+newValue).then(({ data }) => {
                            if(data.description == "" || data.description == null){
                                this.dataInput.description = '-';
                            }else{
                                this.dataInput.description = data.description;
                            }
                            this.dataInput.name = data.name;
                            this.dataInput.code = data.code;
                        });
                    }
                }
            },
            'dataInput.type': function(newValue){
                this.dataInput.id = "";
                this.dataInput.description = "";
                this.dataInput.quantity = "";
            },
            'dataInput.quantity' : function(newvalue){
                this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'editInput.quantity' : function(newValue){
                this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            }
        },
        created: function() {
            this.newIndex = Object.keys(this.datas).length+1;
        },
    });
</script>
@endpush
