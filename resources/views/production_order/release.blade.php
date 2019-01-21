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
                    <table id="activity-table" class="table table-bordered tableFixed showTable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Activity Name</th>
                                <th width="28%">Description</th>
                                <th width="18%">Planned Start Date</th>
                                <th width="19%">Planned End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="tdEllipsis">{{ data.planned_start_date }}</td>
                                <td class="tdEllipsis">{{ data.planned_end_date }}</td>
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
                                <th width="30%">Material Name</th>
                                <th width="28%">Description</th>
                                <th width="8%">Quantity</th>
                                <th width="8%">Available</th>
                                <th width="7%">Unit</th>
                                <th width="7%">Source</th>
                                <th width="7%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in materials">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.material.code }} - {{ data.material.name }}</td>
                                <td class="tdEllipsis">{{ data.material.description }}</td>
                                <td class="tdEllipsis">{{ data.sugQuantity }}</td>
                                <td class="tdEllipsis">{{ data.quantity }}</td>
                                <td class="tdEllipsis">{{ data.material.unit }}</td>
                                <td class="tdEllipsis">{{ data.material.source }}</td>
                                <td class="tdEllipsis" v-if="data.status == 'ok'">
                                    <i class="fa fa-check text-success"></i>
                                </td>
                                <td class="tdEllipsis" v-else>
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
                                <td class="tdEllipsis" v-if="data.trx_resource_id == null"> {{ 'NOT SELECTED' }}</td>
                                <td class="tdEllipsis" v-else-if="data.trx_resource_id == 1"> {{ 'IDLE' }}</td>
                                <td class="tdEllipsis" v-else-if="data.trx_resource_id == 2"> {{ 'USED' }}</td>
                                <td class="p-l-0" align="center"><a @click.prevent="addResource(data,index)" class="btn btn-primary btn-xs" href="#">
                                    <div class="btn-group">
                                        SELECT
                                    </div></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="box-body p-t-0 p-b-5" v-if="route == '/production_order_repair'">
                    <h4>Service</h4>
                    <table id="service-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Service Name</th>
                                <th width="28%">Description</th>
                                <th width="18%">Quantity</th>
                                <th width="19%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in services">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.service.code }} - {{ data.service.name }}</td>
                                <td class="tdEllipsis">{{ data.service.description }}</td>
                                <td class="tdEllipsis">{{ data.quantity }}</td>
                                <td class="tdEllipsis">
                                    <i class="fa fa-check text-success"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

    var data = {
        route : @json($route),
        modelPrOD : @json($modelPrOD),
        materials : @json($materials),
        services : @json($services),
        resources : @json($resources),
        activities : @json($activities),
        submittedForm : {}
    };

    var vm = new Vue({
        el: '#production_order',
        data: data,
        computed : {
            createOk: function(){
                let isOk = false;

                return isOk;
            }
        },
        methods: {
            addResource(data,index) {

            },
            submitForm() {
                this.submittedForm.modelPrOD = this.modelPrOD;
                this.submittedForm.boms = this.boms;
                this.submittedForm.resourceDetails = this.resourceDetails;

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
            }
        },
        created: function() {
            this.checkStock();
        }
    });
</script>
@endpush
