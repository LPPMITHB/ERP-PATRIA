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
                    <div class="col-md-6 col-xs-8 no-padding"><b>: {{$wbs->number}}</b></div>
                    
                    <div class="col-md-4 col-xs-4 no-padding">Description</div>
                    <div class="col-md-6 col-xs-8 no-padding"><b>: {{$wbs->description}}</b></div>

                    <div class="col-md-4 col-xs-4 no-padding">Deliverables</div>
                    <div class="col-md-6 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$wbs->deliverables}}"><b>: {{$wbs->deliverables}}</b></div>
                    
                    <div class="col-md-4 col-xs-4 no-padding">Deadline</div>
                    <div class="col-md-6 col-xs-8 no-padding"><b>: @php
                            $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_end_date);
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
            @if($modelBOM != null)
                <div class="box-body p-t-0 p-b-5">
                    <h4>Top WBS Material</h4>
                    <table class="table table-bordered showTable tableFixed" id="material-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Material Number</th>
                                <th width="30%">Material Description</th>
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
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $BOMD->material->code }}">
                                    {{ $BOMD->material->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip"
                                    title="{{ $BOMD->material->description }}">{{ $BOMD->material->description }}</td>
                                <td>{{ number_format($BOMD->quantity,2) }}</td>
                                <td>{{ $BOMD->material->uom->unit }}</td>
                                <td>{{ $BOMD->source }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /.box-body -->
            @else
                <div class="box-body p-t-0 p-b-5">
                    <h4>Top WBS Material</h4>
                    <table class="table table-bordered showTable tableFixed" id="material-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Material Number</th>
                                <th width="30%">Material Description</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Unit</th>
                                <th width="10%">Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <b>NO BOM DATA</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- /.box-body -->
            @endif

            <div class="box-body p-t-0 p-b-5">
                <h4>Resource</h4>
                <table class="table table-bordered showTable tableFixed" id="resource-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Category</th>
                            <th width="30%">Resource</th>
                            <th width="30%">Resource Detail</th>
                            <th width="20%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelRD as $RD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if($RD->category_id == 1)
                                <td>Subcon</td>
                                @elseif($RD->category_id == 2)
                                <td>Others</td>
                                @elseif($RD->category_id == 3)
                                <td>External</td>
                                @elseif($RD->category_id == 4)
                                <td>Internal</td>
                                @endif
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $RD->resource->code }} - {{ $RD->resource->name }}">{{ $RD->resource->code }} - {{ $RD->resource->description }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ ($RD->resourceDetail) ? $RD->resourceDetail->code : "" }}">{{ ($RD->resourceDetail) ? $RD->resourceDetail->code : '-'  }}</td>
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
                                <h4 class="modal-title">Edit Additional Material</h4>
                            </div>
                            <div class="modal-body p-t-0">
                                <div class="row" v-if="editInput.type == 'Material'">
                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Material Number</label>
                                        <selectize v-model="editInput.id" disabled>
                                            <option v-for="(material, index) in materials" :value="material.id" disabled>{{ material.code }}</option>
                                        </selectize>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Material Name</label>
                                        <input class="form-control" v-model="editInput.description" disabled>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="type" class="control-label p-b-10">Quantity</label>
                                        <input class="form-control" v-model="editInput.quantity">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="type" class="control-label p-b-10">Unit</label>
                                        <input class="form-control" v-model="editInput.unit" disabled>
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
            type :"Material",
            code : "",
            name : "",
            description : "",
            quantity : "",
            unit : "",
            is_decimal : "",
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
        resources : [],
        services : [],
        bom : @json($modelBOM != null ? $modelBOM->bomDetails : []),
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
            quantity : "",
            unit : "",
            is_decimal : ""
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
                this.editInput.type = "Material";
                this.editInput.id = "";
                this.editInput.code = "";
                this.editInput.name = "";
                this.editInput.description = "";
                this.editInput.quantity = "";
                this.editInput.unit = "";
                this.editInput.is_decimal = "";
            },
            openEditModal(data,index){
                this.clearEditInput();
                this.editInput.index = index;
                this.editInput.id = data.id;
                this.editInput.description = data.description;
                this.editInput.type = data.type;
                this.editInput.quantity = data.quantity;
                this.editInput.unit = data.unit;
                this.editInput.is_decimal = data.is_decimal;
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
                this.dataInput.type = "Material";
                this.dataInput.code = "";
                this.dataInput.name = "";
                this.dataInput.description = "";
                this.dataInput.quantity = "";
                this.dataInput.unit = "";
                this.dataInput.is_decimal = "";
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
                            this.dataInput.unit = data.uom.unit;
                            this.dataInput.is_decimal = data.uom.is_decimal;
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
                var is_decimal = this.dataInput.is_decimal;
                if(is_decimal == 0){
                    this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = this.dataInput.quantity.replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.dataInput.quantity = (this.dataInput.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }  
            },
            'editInput.quantity' : function(newValue){
                var is_decimal = this.editInput.is_decimal;
                if(is_decimal == 0){
                    this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = this.editInput.quantity.replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.editInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.editInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.editInput.quantity = (this.editInput.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }    
            }
        },
        created: function() {
            this.newIndex = Object.keys(this.datas).length+1;
        },
    });
</script>
@endpush
