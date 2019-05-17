@extends('layouts.main')

@section('content-header')
@if($route == "/production_order")
    @breadcrumb(
        [
            'title' => 'Release Production Order » '.$modelPrO->number,
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
                'title' => 'Release Production Order » '.$modelPrO->number,
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
            @if($route == "/production_order")
                <form id="release-pro" class="form-horizontal" method="POST" action="{{ route('production_order.storeRelease') }}">
            @elseif($route == "/production_order_repair")
                <form id="release-pro" class="form-horizontal" method="POST" action="{{ route('production_order_repair.storeRelease') }}">
            @endif
            <input type="hidden" name="_method" value="PATCH">
            @csrf
            @verbatim
            <div id="production_order">
                <div class="box-body p-t-0 p-b-5">
                    <h4>Activity</h4>
                    <table id="activity-table" class="table table-bordered tableFixed">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Activity Name</th>
                                <th width="28%">Description</th>
                                <th width="18%">Planned Start Date</th>
                                <th width="19%">Planned End Date</th>
                                <th width="8%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="tdEllipsis">{{ data.planned_start_date }}</td>
                                <td class="tdEllipsis">{{ data.planned_end_date }}</td>
                                <td class="tdEllipsis">
                                    <button class="btn btn-primary btn-xs col-xs-12" @click.prevent="openActDetails(data)">DETAILS</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="box-body p-t-0 p-b-5">
                    <h4>Material</h4>
                    <table id="material-table" class="table table-bordered tableFixed">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Material Code</th>
                                <th width="28%">Description</th>
                                <th width="8%">Quantity</th>
                                <th width="8%">Allocated</th>
                                <th width="8%">Available</th>
                                <th width="7%">Unit</th>
                                <th width="7%">Source</th>
                                <th width="5%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in materials">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.material.code }}</td>
                                <td class="tdEllipsis">{{ data.material.description }}</td>
                                <td class="tdEllipsis">{{ data.sugQuantity }}</td>
                                <td class="no-padding">
                                    <input class="form-control" v-model="data.allocated" placeholder="Allocated">
                                </td>
                                <td class="tdEllipsis">{{ data.quantity }}</td>
                                <td class="tdEllipsis">{{ data.material.unit }}</td>
                                <td class="tdEllipsis">{{ data.material.source }}</td>
                                <td class="tdEllipsis text-center" v-if="data.status == 'ok'">
                                    <i class="fa fa-check text-success"></i>
                                </td>
                                <td class="tdEllipsis text-center" v-else>
                                    <i class="fa fa-times text-danger"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="box-body p-t-0 p-b-5">
                    <h4>Resource</h4>
                    <table id="resource-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Resource Name</th>
                                <th width="28%">Description</th>
                                <th width="18%">Operational Resource</th>
                                <th width="12%">Status</th>
                                <th width="7%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in resources">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.resource.code }} - {{ data.resource.name }}</td>
                                <td class="tdEllipsis">{{ (data.resource.description) ? data.resource.description : '-' }}</td>
                                <td class="tdEllipsis">{{ (data.trx_resource_code) ? data.trx_resource_code : '-' }}</td>
                                <td class="tdEllipsis" v-show="data.status == null"> {{ 'NOT SELECTED' }}</td>
                                <td class="tdEllipsis" v-show="data.status == ''"> {{ 'NOT SELECTED' }}</td>
                                <td class="tdEllipsis" v-show="data.status == 1"> {{ 'IDLE' }}</td>
                                <td class="tdEllipsis" v-show="data.status == 2"> {{ 'USED' }}</td>
                                <td class="p-l-0" align="center"><a @click.prevent="addResource(data,index)" class="btn btn-primary btn-xs" href="#select_resource" data-toggle="modal">
                                    <div class="btn-group">
                                        SELECT
                                    </div></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="select_resource">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Select Operational Resource</h4>
                            </div>
                            <div class="modal-body p-t-0">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="type" class="control-label p-b-10">Operational Resource</label>
                                        <selectize id="edit_modal" v-model="editInput.resource_id" :settings="resourceSettings">
                                            <option v-for="(resource, index) in resourceDetails" :value="resource.id">{{ resource.code }}</option>
                                        </selectize>
                                    </div>
                                </div>
                                <table class="table table-bordered tableFixed showTable" v-show="editInput.resource_id != ''">
                                    <thead>
                                        <tr>
                                            <th width="7%">No</th>
                                            <th width="28%">Type</th>
                                            <th width="15%">Status</th>
                                            <th width="50%">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="tdEllipsis">{{ editInput.type }}</td>
                                            <td class="tdEllipsis" v-if="editInput.status == 1">{{ 'IDLE' }}</td>
                                            <td class="tdEllipsis" v-else-if="editInput.status == 2">{{ 'USED' }}</td>
                                            <td class="tdEllipsis">{{ editInput.notes }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" :disabled="selectOk" data-dismiss="modal" @click.prevent="submitToTable">SELECT</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="activity_detail">
                    <div class="modal-dialog modalPredecessor">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Activity Details</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <label for="activity-material-table" class="col-sm-12">Material</label>
                                    <div class="col-sm-12">
                                        <table class="table table-bordered showTable tableFixed" id="activity-material-table">
                                            <thead>
                                                <tr>
                                                    <th class="p-l-5" style="width: 3%">No</th>
                                                    <th style="width: 25%">Material</th>
                                                    <th style="width: 7%">Length</th>
                                                    <th style="width: 7%">Width</th>
                                                    <th style="width: 7%">Height</th>
                                                    <th style="width: 5%">UOM</th>
                                                    <th style="width: 7%">Quantity</th>
                                                    <th style="width: 6%">Source</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(data,index) in activityDetailMaterials">
                                                    <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.material.code +' - '+  data.material.description)">{{ data.material.code }} - {{ data.material.description }}</td>
                                                    <template v-if="data.weight > 0">
                                                        <td v-if="data.length != ''" class="p-b-15 p-t-15">{{ (data.length+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                        <td v-else class="p-b-15 p-t-15">-</td>
                                                        <td v-if="data.width != ''" class="p-b-15 p-t-15">{{ (data.width+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                        <td v-else class="p-b-15 p-t-15">-</td>
                                                        <td v-if="data.height != ''" class="p-b-15 p-t-15">{{ (data.height+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                        <td v-else class="p-b-15 p-t-15">-</td>
                                                        <td v-if="data.unit != ''" class="p-b-15 p-t-15">{{ data.dimension_uom.unit }}</td>
                                                        <td v-else class="p-b-15 p-t-15">-</td>
                                                        <td class="p-b-15 p-t-15">{{ (Math.ceil(data.weight / data.material.weight)+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                    </template>
                                                    <template v-else>
                                                        <td class="p-b-15 p-t-15">-</td>
                                                        <td class="p-b-15 p-t-15">-</td>
                                                        <td class="p-b-15 p-t-15">-</td>
                                                        <td class="p-b-15 p-t-15">-</td>
                                                        <td class="p-b-15 p-t-15">{{ data.quantity_material }}</td>
                                                    </template>
                                                    <td class="p-b-15 p-t-15">{{ data.source }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <label for="activity-material-table" class="col-sm-12">Service</label>

                                    <template v-if="activityDetailService != ''">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div for="length" class="col-sm-3">Service Name</div>
                
                                                <div class="col-sm-9">
                                                    : <b>{{activityDetailService.service_detail.service.name}} - {{activityDetailService.service_detail.name}}</b>
                                                </div>
                                            </div>
                                        </div>
                                                
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div for="length" class="col-sm-3">Area</div>
            
                                                <div class="col-sm-9">
                                                    : <b>{{(activityDetailService.area+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} {{activityDetailService.area_uom.unit}}</b>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div for="length" class="col-sm-3">Vendor</div>
            
                                                <div class="col-sm-9">
                                                    : <b>{{activityDetailService.vendor.name}}</b>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">CLOSE</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="box-body p-t-0 p-b-10">
                    <div class="col-md-12 p-t-10 p-r-0">
                        <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">RELEASE</button>
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
    const form = document.querySelector('form#release-pro');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var data = {
        route : @json($route),
        modelPrOD : @json($modelPrOD),
        materials : @json($materials),
        services : @json($services),
        resources : @json($resources),
        activities : @json($activities),
        activityDetailMaterials : [],
        activityDetailService : "",
        submittedForm : {},
        resourceDetails : [],
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        editInput : {
            resource_id: "",
            type: "",
            status: "",
            notes : "",
            index : "",
            trx_resource_code : ""
        },
        selectedResource :[], 
    };

    var vm = new Vue({
        el: '#production_order',
        data: data,
        computed : {
            createOk: function(){
                let isOk = false;

                this.resources.forEach(resource => {
                    if(resource.trx_resource_id == ""){
                        isOk = true;
                    }
                });

                return isOk;
            },
            selectOk: function(){
                let isOk = false;

                return isOk;
            }
        },
        methods: {
            tooltipText: function(text) {
                return text
            },
            openActDetails(data){
                this.activityDetailMaterials = [];
                var temp_material = [];
                var temp_service = "";
                data.activity_details.forEach(act_detail => {
                    if(act_detail.material_id != null){
                        temp_material.push(act_detail);
                    }else if(act_detail.service_detail_id != null){
                        temp_service = act_detail;
                    }
                });
                this.activityDetailMaterials = temp_material;
                this.activityDetailService = temp_service;
                $('#activity_detail').modal();
            },
            clearEditInput(){
                this.editInput.resource_id = "";
                this.editInput.type = "";
                this.editInput.status = "";
                this.editInput.notes = "";
                this.editInput.index = "";
                this.editInput.trx_resource_code = "";
            },
            addResource(data,index) {
                this.clearEditInput();
                this.editInput.index = index;
                this.editInput.resource_id = data.trx_resource_id;
                this.selectedResource.forEach(resource_id => {
                    if(resource_id == this.editInput.resource_id){
                        let indexArr = this.selectedResource.indexOf(resource_id);
                        this.selectedResource.splice(indexArr,1)
                    }
                });

                let selectedResource = JSON.stringify(this.selectedResource);
                window.axios.get('/api/getTrxResourcePro/'+data.resource_id+'/'+selectedResource).then(({ data }) => {
                    this.resourceDetails = data;
                    this.resourceDetails.forEach(resourceDetail => {
                        if(resourceDetail.id == this.editInput.resource_id){
                            this.editInput.status = resourceDetail.status;
                            this.editInput.trx_resource_code = resourceDetail.code;

                            if(resourceDetail.category_id == 0){
                                this.editInput.type = "Subcon"
                            }else if(resourceDetail.category_id == 1){
                                this.editInput.type = "Others"
                            }else if(resourceDetail.category_id == 2){
                                this.editInput.type = "External Equipment"
                            }else if(resourceDetail.category_id == 3){
                                this.editInput.type = "Internal Equipment"
                            }

                            if(resourceDetail.status == 1){
                                this.editInput.notes = "-"
                            }else if(resourceDetail.status == 2){
                                this.editInput.notes = ""
                            }
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
            },
            submitForm() {
                this.materials.forEach(material => {
                    material.allocated = (material.allocated+"").replace(/,/g , '');
                });
                this.submittedForm.materials = this.materials;
                this.submittedForm.modelPrOD = this.modelPrOD;
                this.submittedForm.resources = this.resources;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            checkStock(){
                this.materials.forEach(material => {
                    if(material.material.source == "Stock"){
                        window.axios.get('/api/getStockPrO/'+material.material_id).then(({ data }) => {
                            if(data.length == 0){
                                material.sugQuantity = material.quantity;
                                material.quantity = 0;
                            }else{
                                if(data.reserved > data.quantity){
                                    material.sugQuantity = material.quantity;
                                    material.quantity = 0;
                                }else{
                                    material.sugQuantity = material.quantity;
                                    material.quantity = data.quantity;
                                }
                            }
                            if(material.sugQuantity <= material.quantity){
                                material.status = "ok";
                            }else{
                                material.status = "not ok";
                            }
                            material.quantity = (material.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                            material.sugQuantity = (material.sugQuantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                            $('div.overlay').hide();
                        });
                    }else if(material.material.source == "WIP"){
                        window.axios.get('/api/getProjectInvPrO/'+material.material_id).then(({ data }) => {
                            if(data.length == 0){
                                material.sugQuantity = material.quantity;
                                material.quantity = 0;
                            }else{
                                material.sugQuantity = material.quantity;
                                material.quantity = data.quantity;
                            }
                            if(material.sugQuantity <= material.quantity){
                                material.status = "ok";
                            }else{
                                material.status = "not ok";
                            }
                            material.quantity = (material.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                            material.sugQuantity = (material.sugQuantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                        });
                    }
                });
            },
            submitToTable(){
                let resource = this.resources[this.editInput.index];
                if(this.editInput.resource_id == ''){
                    resource.trx_resource_code = '';
                    resource.trx_resource_id = '';
                    resource.status = '';
                }else{
                    resource.trx_resource_code = this.editInput.trx_resource_code;
                    resource.trx_resource_id = this.editInput.resource_id ;
                    resource.status = this.editInput.status;
                }

                this.selectedResource.push(this.editInput.resource_id);
                this.clearEditInput();
            }
        },
        watch: {
            'editInput.resource_id': function(newValue){
                if(newValue != ""){
                    this.resourceDetails.forEach(data => {
                        if(data.id == newValue){
                            this.editInput.trx_resource_code = data.code;
                            this.editInput.status = data.status;
                            if(data.category_id == 0){
                                this.editInput.type = "Subcon"
                            }else if(data.category_id == 1){
                                this.editInput.type = "Others"
                            }else if(data.category_id == 2){
                                this.editInput.type = "External Equipment"
                            }else if(data.category_id == 3){
                                this.editInput.type = "Internal Equipment"
                            }

                            if(data.status == 1){
                                this.editInput.notes = "-"
                            }else if(data.status == 2){
                                this.editInput.notes = ""
                            }
                        }
                    });
                }else{

                }
            },
            materials:{
                handler: function(newValue) {
                    newValue.forEach(material => {
                        material.allocated = (material.allocated+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                        
                    });
                },
                deep: true
            },
        },
        created: function() {
            this.checkStock();
        }
    });
</script>
@endpush
