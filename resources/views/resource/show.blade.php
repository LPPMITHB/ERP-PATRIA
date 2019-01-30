@extends('layouts.main')

@section('content-header')
    @if($route == "/resource")
        @breadcrumb(
            [
                'title' => 'Resource Monitoring',
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Resources' => route('resource.index'),
                    $resource->name => '',
                ]
            ]
        )
        @endbreadcrumb
    @elseif($route == "/resource_repair")
        @breadcrumb(
            [
                'title' => 'Resource Monitoring',
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Resources' => route('resource_repair.index'),
                    $resource->name => '',
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12 col-lg-8 col-md-12 no-padding">
                    <div class="box-body no-padding">
                        <div class="col-sm-12 no-padding"><b>Resource Information</b></div>
                        
                        <div class="col-md-2 col-xs-2 no-padding">Code</div>
                        <div class="col-md-10 col-xs-10 no-padding"><b>: {{$resource->code}}</b></div>
                        
                        <div class="col-md-2 col-xs-2 no-padding">Name</div>
                        <div class="col-md-10 col-xs-10 no-padding"><b>: {{$resource->name}}</b></div>

                        <div class="col-md-2 col-xs-2 no-padding">Description</div>
                        <div class="col-md-10 col-xs-10 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$resource->description}}"><b>: {{ isset($resource->description) ? $resource->description : '-' }}</b></div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4 col-md-12 no-padding ">
                    @if($route == "/resource")
                        <a href="{{ route('resource.createInternal',$resource->id) }}" class="btn btn-primary btn-sm pull-right">INPUT INTERNAL RESOURCE</a>
                    @elseif($route == "/resource_repair")
                        <a href="{{ route('resource_repair.createInternal',$resource->id) }}" class="btn btn-primary btn-sm pull-right">INPUT INTERNAL RESOURCE</a>
                    @endif
                </div>
            </div>
            @verbatim
                <div id="monitoring">
                    <div class="box-body p-t-0 p-b-0">
                        <table class="table table-bordered tableFixed tablePagingVue">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Code</th>
                                    <th width="30%">Brand</th>
                                    <th width="20%">Type</th>
                                    <th width="10%">Status</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rd, index) in modelRD">
                                    <td>{{ index + 1 }}</td>
                                    <td><a @click.prevent="showDetail(rd.id)" href="">{{ rd.code }}</a></td>
                                    <td v-if="rd.category_id != 1">{{ rd.brand }}</td>
                                    <td v-else>{{ rd.others_name }}</td>
                                    <td v-if="rd.category_id == 0">Sub Con</td>
                                    <td v-else-if="rd.category_id == 1">Others</td>
                                    <td v-else-if="rd.category_id == 2">External Equipment</td>
                                    <td v-else-if="rd.category_id == 3">Internal Equipment</td>
                                    <td v-if="rd.status == 1">IDLE</td>
                                    <td v-else-if="rd.status == 2">USED</td>
                                    <td v-else-if="rd.status == 0">NOT ACTIVE</td>
                                    <td>
                                        <a @click.prevent="showDetail(rd.id)" class="btn btn-primary btn-xs">
                                            <div class="btn-group">
                                                VIEW DETAIL
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-body p-t-0" v-show="data.selectedId != ''">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#activity" data-toggle="tab">{{data.code}}</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div class="box-body p-t-0 p-l-0 p-r-0" v-if="data.category_id == 0">
                                        <div class="col-sm-3 p-l-0">
                                            <div class="col-md-6 col-xs-6 no-padding">PO Number</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.po_number}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Receive Date</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.receive_date}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Status</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.status}}</b></div>
                                        </div>
                                        <div class="col-sm-8 p-l-0">
                                            <div class="col-md-2 col-xs-2 no-padding">Address</div>
                                            <div class="col-md-10 col-xs-10 no-padding tdEllipsis"><b>: {{(data.address) ? data.address : '-'}}</b></div>
    
                                            <div class="col-md-2 col-xs-2 no-padding">Phone</div>
                                            <div class="col-md-10 col-xs-10 no-padding tdEllipsis"><b>: {{(data.phone) ? data.phone : '-'}}</b></div>
    
                                            <div class="col-md-2 col-xs-2 no-padding">Competency</div>
                                            <div class="col-md-10 col-xs-10 no-padding tdEllipsis" ><b>: {{(data.competency) ? data.competency : '-'}}</b></div>
                                        </div>
                                        <div class="col-sm-1 p-l-0 p-r-0">
                                            <a href="#edit_info" class="btn btn-primary btn-sm pull-right" data-toggle="modal" @click="openEditModal(data.category_id)">EDIT INFORMATION</a>
                                        </div>
                                    </div>

                                    <div class="box-body p-t-0 p-l-0 p-r-0" v-if="data.category_id == 1">
                                        <div class="col-sm-3 p-l-0">
                                            <div class="col-md-6 col-xs-6 no-padding">PO Number</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.po_number}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Receive Date</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.receive_date}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Status</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.status}}</b></div>
                                        </div>
                                        <div class="col-sm-8 p-l-0">
                                            <div class="col-md-2 col-xs-2 no-padding">Name</div>
                                            <div class="col-md-10 col-xs-10 no-padding"><b>: {{data.other_name}}</b></div>
    
                                            <div class="col-md-2 col-xs-2 no-padding">Type</div>
                                            <div class="col-md-10 col-xs-10 no-padding"><b>: {{data.type}}</b></div>
    
                                            <div class="col-md-2 col-xs-2 no-padding">Description</div>
                                            <div class="col-md-10 col-xs-10 no-padding tdEllipsis"><b>: {{(data.description != '') ? data.description : '-'}}</b></div>
                                        </div>
                                        <div class="col-sm-1 p-l-0 p-r-0">
                                            <a href="#edit_info" class="btn btn-primary btn-sm pull-right" data-toggle="modal" @click="openEditModal(data.category_id)">EDIT INFORMATION</a>
                                        </div>
                                    </div>

                                    <div class="box-body p-t-0 p-l-0 p-r-0" v-if="data.category_id == 2">
                                        <div class="col-sm-3 p-l-0">
                                            <div class="col-md-6 col-xs-6 no-padding">PO Number</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.po_number}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Receive Date</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.receive_date}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Status</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.status}}</b></div>
                                        </div>
                                        <div class="col-sm-8 p-l-0">
                                            <div class="col-md-2 col-xs-2 no-padding">Brand</div>
                                            <div class="col-md-10 col-xs-10 no-padding"><b>: {{data.brand}}</b></div>
    
                                            <div class="col-md-2 col-xs-2 no-padding">Type</div>
                                            <div class="col-md-10 col-xs-10 no-padding"><b>: {{data.type}}</b></div>
    
                                            <div class="col-md-2 col-xs-2 no-padding">Description</div>
                                            <div class="col-md-10 col-xs-10 no-padding"><b>: {{(data.description != '') ? data.description : '-'}}</b></div>
                                        </div>
                                        <div class="col-sm-1 p-l-0 p-r-0">
                                            <a href="#edit_info" class="btn btn-primary btn-sm pull-right" data-toggle="modal" @click="openEditModal(data.category_id)">EDIT INFORMATION</a>
                                        </div>
                                    </div>

                                    <div class="box-body p-t-0 p-l-0 p-r-0" v-if="data.category_id == 3">
                                        <div class="col-sm-4 p-l-0">
                                            <div class="col-md-6 col-xs-6 no-padding">Brand</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.brand}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Type</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.type}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Description</div>
                                            <div class="col-md-6 col-xs-6 no-padding tdEllipsis"><b>: {{(data.description != '') ? data.description : '-'}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Status</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.status}}</b></div>

                                            <div class="col-md-6 col-xs-6 no-padding">Running Hours</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{(data.running_hour) ? data.running_hour : '-'}} Hour(s)</b></div>
                                        </div>
                                        <div class="col-sm-7 p-l-0">
                                            <div class="col-md-3 col-xs-3 no-padding">Manufactured Date</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{(data.manufactured_date) ? data.manufactured_date : '-'}}</b></div>
    
                                            <div class="col-md-3 col-xs-3 no-padding">Purchasing Date</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{(data.purchasing_date) ? data.purchasing_date : '-'}}</b></div>
    
                                            <div class="col-md-3 col-xs-3 no-padding">Purchasing Price</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{(data.purchasing_price) ? 'Rp'+data.purchasing_price : '-'}}</b></div>

                                            <div class="col-md-3 col-xs-3 no-padding">Lifetime</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{data.lifetime}}</b></div>

                                            <div class="col-md-3 col-xs-3 no-padding">Depreciation Method</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{data.depreciation_method}}</b></div>
                                            
                                            <div class="col-md-3 col-xs-3 no-padding">Cost Per Hour</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{(data.cost_per_hour) ? 'Rp'+data.cost_per_hour : '-'}}</b></div>
                                        </div>
                                        <div class="col-sm-1 p-l-0 p-r-0">
                                            <a href="#edit_info" class="btn btn-primary btn-sm pull-right" data-toggle="modal" @click="openEditModal(data.category_id)">EDIT INFORMATION</a>
                                        </div>
                                    </div>

                                    <div class="box box-solid box-default m-b-0">
                                        <div class="box-body">
                                            <div class="col-lg-3 no-padding">
                                                <div class="col-md-12 col-xs-12 no-padding"><b>Planned</b></div>
                                                <div class="col-md-12 col-xs-12 no-padding">
                                                    <div class="col-md-4 col-xs-4 no-padding">Performance</div>
                                                    <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.performance}}</b></div>
                                                </div>
                                                <div class="col-md-12 col-xs-12 no-padding">
                                                    <div class="col-md-4 col-xs-4 no-padding">Duration</div>
                                                    <div class="col-md-8 col-xs-8 no-padding" v-if="data.category_id != 3"><b>: {{data.rental_duration}}</b></div>
                                                    <div class="col-md-8 col-xs-8 no-padding" v-else-if="data.category_id == 3"><b>: {{data.lifetime}}</b></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 no-padding">
                                                <div class="col-md-12 col-xs-12 no-padding"><b>Actual</b></div>
                                                <div class="col-md-12 col-xs-12 no-padding">
                                                    <div class="col-md-4 col-xs-4 no-padding">Performance</div>
                                                    <div class="col-md-8 col-xs-8 no-padding"><b>: {{(data.total_performance) ? data.total_performance : '-' }}</b></div>
                                                </div>
                                                <div class="col-md-12 col-xs-12 no-padding">
                                                    <div class="col-md-4 col-xs-4 no-padding">Duration</div>
                                                    <div class="col-md-8 col-xs-8 no-padding"><b>: {{(data.total_usage) ? data.total_usage : '-'}}</b></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 no-padding">
                                                <div class="col-md-12 col-xs-12 no-padding"><b>Utilization</b></div>
                                                <div class="col-md-12 col-xs-12 no-padding">
                                                    <div class="col-md-8 col-xs-8 no-padding"><b>{{ (data.utilization) ? data.utilization : "0.00"}} %</b></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 no-padding">
                                                <div class="col-md-12 col-xs-12 no-padding"><b>Productivity</b></div>
                                                <div class="col-md-12 col-xs-12 no-padding">
                                                    <div class="col-md-8 col-xs-8 no-padding"><b>{{ (data.avg_productivity) ? data.avg_productivity : "0.00"}} %</b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <template v-if="data.prod_order_detail.length > 0">
                                        <div class="box-body p-l-0 p-b-0">
                                            <h4>Usage History</h4>
                                        </div>
                                        <template v-for="prod_order_detail in data.prod_order_detail">
                                            <div class="box box-solid box-default">
                                                <div class="box-body">
                                                    <div class="col-lg-4 no-padding">
                                                        <div class="col-md-12 col-xs-12 no-padding"><b>Information</b></div>
                                                        <div class="col-md-12 col-xs-12 no-padding">
                                                            <div class="col-md-4 col-xs-4 no-padding">WBS</div>
                                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{prod_order_detail.production_order.wbs.code}}</b></div>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 no-padding">
                                                            <div class="col-md-4 col-xs-4 no-padding">Prod. Order</div>
                                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{prod_order_detail.production_order.number}}</b></div>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 no-padding">
                                                            <div class="col-md-4 col-xs-4 no-padding">Status</div>
                                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{prod_order_detail.production_order.prod_order_status}}</b></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 no-padding">
                                                        <br>
                                                        <div class="col-md-12 col-xs-12 no-padding">
                                                            <div class="col-md-4 col-xs-4 no-padding">Performance</div>
                                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{ (prod_order_detail.performance != null) ? prod_order_detail.performance+' '+prod_order_detail.performance_uom.unit : '-'}}</b></div>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 no-padding">
                                                            <div class="col-md-4 col-xs-4 no-padding">Usage</div>
                                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{ (prod_order_detail.usage != null) ? prod_order_detail.usage+' Hour(s)' : '-'}}</b></div>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12 no-padding" v-if="prod_order_detail.resource_detail.category_id == 0">
                                                            <div class="col-md-4 col-xs-4 no-padding">Accident</div>
                                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{ (prod_order_detail.actual != null) ? prod_order_detail.actual+' Time(s)' : '-'}}</b></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-4 no-padding">
                                                        <div class="col-md-12 col-xs-12 no-padding"><b>Productivity</b></div>
                                                        <div class="col-md-12 no-padding" v-if="prod_order_detail.performance == null"><b>-</b></div>
                                                        <div class="col-md-12 no-padding" v-else-if="prod_order_detail.usage == null"><b>-</b></div>
                                                        <div class="col-md-12 no-padding" v-else-if="prod_order_detail.usage != null && prod_order_detail.performance != null"><b>{{ (prod_order_detail.performance/prod_order_detail.usage).toFixed(2)+' '+prod_order_detail.performance_uom.unit+' / Hour' }}</b></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="edit_info">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Resource Detail Information</h4>
                                </div>
                                <div class="modal-body p-t-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="category" class="control-label">Category</label>
                                            <input type="text" id="category" v-model="category" class="form-control" disabled>
                                        </div>
                                        
                                        <div v-show="editInput.category_id == '0'">
                                            <div class="col-sm-12">
                                                <label for="code" class="control-label">Sub Con Code*</label>
                                                <input type="text" id="code" v-model="editInput.code" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 no-padding">
                                                    <label for="lifetime" class="control-label">Rental Duration*</label>
                                                </div>
                                                <div class="col-sm-3 no-padding p-r-10">
                                                    <input type="text" v-model="editInput.lifetime" :disabled="lifetimeOk" class="form-control" placeholder="Rental Duration">
                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <selectize v-model="editInput.lifetime_uom_id" :settings="timeSettings">
                                                        <option value="1">Day(s)</option>
                                                        <option value="2">Month(s)</option>
                                                        <option value="3">Year(s)</option>
                                                    </selectize>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="sub_con_address" class="control-label">Sub Con Address*</label>
                                                <input type="text" id="sub_con_address" v-model="editInput.sub_con_address" class="form-control" placeholder="Please Input Sub Con Address">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="sub_con_phone" class="control-label">Sub Con Contact Phone Number*</label>
                                                <input type="text" id="sub_con_phone" v-model="editInput.sub_con_phone" class="form-control" placeholder="Please Input Sub Con Contact Phone Number">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="sub_con_competency" class="control-label">Sub Con Competency*</label>
                                                <input type="text" id="sub_con_competency" v-model="editInput.sub_con_competency" class="form-control" placeholder="Please Input Sub Con Competency">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <input type="text" id="description" v-model="editInput.description" class="form-control" placeholder="Please Input Description">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 no-padding">
                                                    <label for="performance" class="control-label">Performance</label>
                                                </div>
                                                <div class="col-sm-3 no-padding p-r-10">
                                                    <input type="text" id="performance" v-model="editInput.performance" :disabled="performanceOk" class="form-control" placeholder="Performance">

                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <selectize v-model="editInput.performance_uom_id" :settings="uomSettings">
                                                        <option v-for="(data, index) in uom" :value="data.id">{{ data.unit }} </option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-6 p-t-8">
                                                    Per Hour
                                                </div>
                                            </div>
                                        </div>

                                        <div v-show="editInput.category_id == '1'">
                                            <div class="col-sm-12">
                                                <label for="code" class="control-label">Code*</label>
                                                <input type="text" id="code" v-model="editInput.code" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="name" class="control-label">Name*</label>
                                                <input type="text" id="name" v-model="editInput.name" class="form-control" placeholder="Please Input Resource Name">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 no-padding">
                                                    <label for="lifetime" class="control-label">Rental Duration*</label>
                                                </div>
                                                <div class="col-sm-3 no-padding p-r-10">
                                                    <input type="text" v-model="editInput.lifetime" :disabled="lifetimeOk" class="form-control" placeholder="Rental Duration">
                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <selectize v-model="editInput.lifetime_uom_id" :settings="timeSettings">
                                                        <option value="1">Day(s)</option>
                                                        <option value="2">Month(s)</option>
                                                        <option value="3">Year(s)</option>
                                                    </selectize>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <input type="text" id="description" v-model="editInput.description" class="form-control" placeholder="Please Input Description">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 no-padding">
                                                    <label for="performance" class="control-label">Performance</label>
                                                </div>
                                                <div class="col-sm-3 no-padding p-r-10">
                                                    <input type="text" id="performance" v-model="editInput.performance" :disabled="performanceOk" class="form-control" placeholder="Performance">

                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <selectize v-model="editInput.performance_uom_id" :settings="uomSettings">
                                                        <option v-for="(data, index) in uom" :value="data.id">{{ data.unit }} </option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-6 p-t-8">
                                                    Per Hour
                                                </div>
                                            </div>
                                        </div>

                                        <div v-show="editInput.category_id == '2'">
                                            <div class="col-sm-12">
                                                <label for="code" class="control-label">Code*</label>
                                                <input type="text" id="code" v-model="editInput.code" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="brand" class="control-label">Brand*</label>
                                                <input type="text" id="brand" v-model="editInput.brand" class="form-control" placeholder="Please Input Brand">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 no-padding">
                                                    <label for="lifetime" class="control-label">Rental Duration*</label>
                                                </div>
                                                <div class="col-sm-3 no-padding p-r-10">
                                                    <input type="text" v-model="editInput.lifetime" :disabled="lifetimeOk" class="form-control" placeholder="Rental Duration">
                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <selectize v-model="editInput.lifetime_uom_id" :settings="timeSettings">
                                                        <option value="1">Day(s)</option>
                                                        <option value="2">Month(s)</option>
                                                        <option value="3">Year(s)</option>
                                                    </selectize>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <input type="text" id="description" v-model="editInput.description" class="form-control" placeholder="Please Input Description">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 no-padding">
                                                    <label for="performance" class="control-label">Performance</label>
                                                </div>
                                                <div class="col-sm-3 no-padding p-r-10">
                                                    <input type="text" id="performance" v-model="editInput.performance" :disabled="performanceOk" class="form-control" placeholder="Performance">

                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <selectize v-model="editInput.performance_uom_id" :settings="uomSettings">
                                                        <option v-for="(data, index) in uom" :value="data.id">{{ data.unit }} </option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-6 p-t-8">
                                                    Per Hour
                                                </div>
                                            </div>
                                        </div>

                                        <div v-show="editInput.category_id == '3'">
                                            <div class="col-sm-12">
                                                <label for="code" class="control-label">Code*</label>
                                                <input type="text" id="code" v-model="editInput.code" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="brand" class="control-label">Brand*</label>
                                                <input type="text" id="brand" v-model="editInput.brand" class="form-control" placeholder="Please Input Brand">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <input type="text" id="description" v-model="editInput.description" class="form-control" placeholder="Please Input Description">
                                            </div>
                                            <div class="col-sm-12 p-t-7">
                                                <label for="manufactured_date">Manufactured Date</label>
                                                <input required autocomplete="off" type="text" class="form-control datepicker width100" name="manufactured_date" id="manufactured_date" placeholder="Manufactured Date">  
                                            </div>
                                            <div class="col-sm-12 p-t-7">
                                                <label for="purchasing_date">Purchasing Date</label>
                                                <input required autocomplete="off" type="text" class="form-control datepicker width100" name="purchasing_date" id="purchasing_date" placeholder="Purchasing Date" >  
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="purchasing_price" class="control-label">Purchasing Price</label>
                                                <input type="text" id="purchasing_price" v-model="editInput.purchasing_price" class="form-control" placeholder="Please Input Purchasing Price">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 no-padding">
                                                    <label for="lifetime" class="control-label">Life Time</label>
                                                </div>
                                                <div class="col-sm-3 no-padding p-r-10">
                                                    <input type="text" id="lifetime" v-model="editInput.lifetime" :disabled="lifetimeOk" class="form-control" placeholder="Life Time">
                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <selectize v-model="editInput.lifetime_uom_id" :settings="timeSettings">
                                                        <option value="1">Day(s)</option>
                                                        <option value="2">Month(s)</option>
                                                        <option value="3">Year(s)</option>
                                                    </selectize>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="cost_per_hour" class="control-label">Cost Per Hour (Rp.)</label>
                                                <input type="text" id="cost_per_hour" v-model="editInput.cost_per_hour" class="form-control" placeholder="Please Input Cost Per Hour">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Depreciation Method</label>
                                                <selectize v-model="editInput.depreciation_method" :settings="depreciationSettings">
                                                    <option v-for="(depreciation_method, index) in depreciation_methods" :value="depreciation_method.id">{{ depreciation_method.name }} </option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 no-padding">
                                                    <label for="performance" class="control-label">Performance</label>
                                                </div>
                                                <div class="col-sm-3 no-padding p-r-10">
                                                    <input type="text" id="performance" v-model="editInput.performance" :disabled="performanceOk" class="form-control" placeholder="Performance">
                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <selectize v-model="editInput.performance_uom_id" :settings="uomSettings">
                                                        <option v-for="(data, index) in uom" :value="data.id">{{ data.unit }} </option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-6 p-t-8">
                                                    Per Hour
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" :disabled="inputOk" @click.prevent="update()">SAVE</button>
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

@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == ""){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tablePagingVue.column(i).search() !== this.value ) {
                    tablePagingVue
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            });
        });

        var tablePagingVue = $('.tablePagingVue').DataTable( {
            orderCellsTop   : true,
            fixedHeader     : true,
            paging          : true,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
        });

        $('div.overlay').hide();
    });

    var data = {
        modelRD : @json($modelRD),
        depreciation_methods : @json($depreciation_methods),
        resource_categories : @json($resource_categories),
        uom :   @json($uom),
        category : "",
        data:{
            category_id : "",
            selectedId : "",
            code : "",
            po_number : "",
            receive_date : "",
            rental_duration : "",
            brand : "",
            type : "",
            description : "",
            performance : "",
            status : "",
            prod_order_detail : [],
            utilization : "",
            total_performance : "",
            total_usage : "",
            running_hour : "",
            manufactured_date : "",
            purchasing_date : "",
            purchasing_price : "",
            lifetime : "",
            depreciation_method : "",
            cost_per_hour : "",
            other_name : "",
            address : "",
            phone : "",
            competency : "",
            avg_productivity : "",
            lt : "",
            lt_uom : "",
            perf : "",
            perf_uom : "",
            resource_detail_id : "",
            resource_id : "",
        },
        editInput : {
            pod_id : "",
            category_id : "",
            description : "",
            code : "",
            index : "",
            performance : "",
            performance_uom_id : "",

            name:"",

            brand : "",

            sub_con_address : "",
            sub_con_phone : "",
            sub_con_competency : "",

            manufactured_date : "",
            purchasing_date : "",
            purchasing_price : "",
            lifetime : "",
            lifetime_uom_id : "",
            depreciation_method : 0,
            cost_per_hour : "",
            resource_detail_id : "",
        },
        uomSettings: {
            placeholder: 'Please Select UOM'
        },
        timeSettings: {
            placeholder: 'Please Select Time'
        },
        depreciationSettings: {
            placeholder: 'Please Select Depreciation Method'
        },
    };

    var vm = new Vue({
    el : '#monitoring',
    data : data,
    computed : {
        lifetimeOk :function(){
            let isOk = false;

            if(this.editInput.lifetime_uom_id == ""){
                isOk = true;
            }
            return isOk;
        },
        performanceOk :function(){
            let isOk = false;

            if(this.editInput.performance_uom_id == ""){
                isOk = true;
            }
            return isOk;
        },
        inputOk: function(){
            let isOk = false;
            if(this.editInput.category_id == ""){
                isOk = true;
            }
            if(this.editInput.category_id == 0){
                if(this.editInput.lifetime == "" || this.editInput.sub_con_address == "" || this.editInput.sub_con_phone == "" || this.editInput.sub_con_competency == ""){
                    isOk = true;
                }
            }
            if(this.editInput.category_id == 1){
                if(this.editInput.lifetime == "" ||this.editInput.name == ""){
                    isOk = true;
                }
            }
            if(this.editInput.category_id == 2){
                if(this.editInput.lifetime == "" || this.editInput.brand == ""){
                    isOk = true;
                }
            }
            if(this.editInput.category_id == 3){
                if(this.editInput.brand == ""){
                    isOk = true;
                }
            }
            return isOk;
        }, 
    },
    mounted() {
        $('.datepicker').datepicker({
            autoclose : true,
        });
        $("#manufactured_date").datepicker().on(
            "changeDate", () => {
                this.editInput.manufactured_date = $('#manufactured_date').val();
            }
        );
        $("#purchasing_date").datepicker().on(
            "changeDate", () => {
                this.editInput.purchasing_date = $('#purchasing_date' ).val();
            }
        );
    },
    methods : {
        update(){
            $('div.overlay').show();
            this.editInput.resource_detail_id = this.data.resource_detail_id;
            this.editInput.performance = parseInt((this.editInput.performance+"").replace(/,/g , ''));
            this.editInput.lifetime = parseInt((this.editInput.lifetime+"").replace(/,/g , ''));
            this.editInput.cost_per_hour = parseInt((this.editInput.cost_per_hour+"").replace(/,/g , ''));
            this.editInput.purchasing_price = parseInt((this.editInput.purchasing_price+"").replace(/,/g , ''));
            let data = this.editInput;
            
            var url = "{{ route('resource.updateDetail') }}";
            window.axios.put(url,data).then((response) => {
                window.axios.get('/api/getNewResourceDetail/'+this.data.resource_id).then(({ data }) => {
                    this.data.selectedId = "";
                    iziToast.success({
                        displayMode: 'replace',
                        title: "Sucess Update Resource Information !",
                        position: 'topRight',
                    });
                    this.modelRD = data;
                });
                $('div.overlay').hide();
            })
            .catch((error) => {
                iziToast.warning({
                    displayMode: 'replace',
                    title: "Please try again.. ",
                    position: 'topRight',
                });
                $('div.overlay').hide();
            })
        },
        clearEditData(){
            this.editInput.category_id = '';
            this.editInput.code = '';
            this.editInput.description = '';
            this.editInput.pod_id = '';
            this.editInput.performance = '';
            this.editInput.performance_uom_id = '';
            this.editInput.lifetime = '';
            this.editInput.lifetime_uom_id = '';
            this.editInput.sub_con_address = '';
            this.editInput.sub_con_phone = '';
            this.editInput.sub_con_competency = '';
            this.editInput.name = '';
            this.editInput.brand = '';
            this.editInput.manufactured_date = '';
            this.editInput.purchasing_date = '';
            this.editInput.purchasing_price = '';
            this.editInput.cost_per_hour = '';
            this.editInput.depreciation_method = '';
        },
        openEditModal(category_id){
            this.clearEditData();

            this.resource_categories.forEach(resource_category =>{
                if(resource_category.id == category_id){
                    this.category = resource_category.name;
                    this.editInput.category_id = category_id;
                    this.editInput.code = this.data.code;
                    this.editInput.description = this.data.description;
                    this.editInput.lifetime = this.data.lt;
                    this.editInput.lifetime_uom_id = this.data.lt_uom;
                    this.editInput.performance = this.data.perf;
                    this.editInput.performance_uom_id = this.data.perf_uom;

                    if(category_id == 0){
                        this.editInput.sub_con_address = this.data.address;
                        this.editInput.sub_con_phone = this.data.phone;
                        this.editInput.sub_con_competency = this.data.competency;
                    }else if(category_id == 1){
                        this.editInput.name = this.data.other_name;
                    }else if(category_id == 2){
                        this.editInput.brand = this.data.brand;
                    }else if(category_id == 3){
                        this.editInput.brand = this.data.brand;
                        this.editInput.manufactured_date = this.data.manufactured_date;
                        this.editInput.purchasing_date = this.data.purchasing_date;
                        this.editInput.purchasing_price = this.data.purchasing_price;
                        this.editInput.cost_per_hour = this.data.cost_per_hour;
                        this.editInput.depreciation_method = this.data.depreciation_method_id;
                    }
                }
            });
        },
        clearData(){
            this.data.category_id = "";
            this.data.selectedId = "";
            this.data.code = "";
            this.data.po_number = "";
            this.data.receive_date = "";
            this.data.rental_duration = "";
            this.data.brand = "";
            this.data.type = "";
            this.data.description = "";
            this.data.performance = "";
            this.data.status = "";
            this.data.prod_order_detail = [];
            this.data.utilization = "";
            this.data.total_performance = "";
            this.data.total_usage = "";
            this.data.running_hour = "";
            this.data.manufactured_date = "";
            this.data.purchasing_date = "";
            this.data.purchasing_price = "";
            this.data.lifetime = "";
            this.data.depreciation_method = "";
            this.data.cost_per_hour = "";
            this.data.other_name = "";
            this.data.address = "";
            this.data.phone = "";
            this.data.competency = "";
            this.data.avg_productivity = "";
            this.data.resource_detail_id = "";
            this.data.resource_id = "";
        },
        showDetail(id){
            $('div.overlay').show();
            this.clearData();
            this.data.selectedId = id;

            this.modelRD.forEach(RD => {
                if(RD.id == this.data.selectedId){
                    let planned_performance = 0;
                    let actual_performance = 0;

                    this.data.resource_detail_id = RD.id;
                    this.data.category_id = RD.category_id;
                    this.data.resource_id = RD.resource_id;
                    this.data.code = RD.code;
                    this.data.brand = RD.brand;
                    this.data.description = RD.description;
                    if(RD.performance != null){
                        this.data.performance = (RD.performance+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+" "+RD.performance_uom.unit+" / hour";
                    }else{
                        this.data.performance = "-";
                    }
                    this.data.perf = (RD.performance+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.data.perf_uom = RD.performance_uom_id;
                    planned_performance = RD.performance;

                    if(RD.category_id == 0){
                        this.data.type = "Sub Con";
                    }else if(RD.category_id == 1){
                        this.data.type = "Others";
                    }else if(RD.category_id == 2){
                        this.data.type = "External Equipment";
                    }else if(RD.category_id == 3){
                        this.data.type = "Internal Equipment";
                    }

                    if(RD.status == 0){
                        this.data.status = "NOT ACTIVE";
                    }else if(RD.status == 1){
                        this.data.status = "IDLE";
                    }else if(RD.status == 2){
                        this.data.status = "USED";
                    }

                    let performance = 0;
                    let usage = 0;
                    if(RD.production_order_details.length > 0){
                        RD.production_order_details.forEach(prodOrderDetail =>{
                            if(prodOrderDetail.production_order.status == 0){
                                prodOrderDetail.production_order.prod_order_status = "COMPLETED";
                            }else if(prodOrderDetail.production_order.status == 1){
                                prodOrderDetail.production_order.prod_order_status = "UNRELEASED";
                            }else if(prodOrderDetail.production_order.status == 2){
                                prodOrderDetail.production_order.prod_order_status = "RELEASED";
                            }
                            performance += prodOrderDetail.performance;
                            usage += prodOrderDetail.usage;
                        });
                        let average = (performance / usage).toFixed(2);
                        this.data.prod_order_detail = RD.production_order_details;
                        if(RD.production_order_details[0].performance_uom_id != null){
                            this.data.total_performance = average+' '+RD.production_order_details[0].performance_uom.unit+' /hour';
                        }
                        this.data.total_usage = usage+' Hour(s)';
                        actual_performance = performance / usage;
                    }

                    if(this.data.category_id == 3){
                        this.data.running_hour = (RD.running_hours+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $('#manufactured_date').datepicker('setDate', new Date(RD.manufactured_date));
                        $('#purchasing_date').datepicker('setDate', new Date(RD.purchasing_date));

                        this.data.manufactured_date = RD.manufactured_date;
                        this.data.purchasing_date = RD.purchasing_date;
                        this.data.purchasing_price = (RD.purchasing_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        this.data.cost_per_hour = (RD.cost_per_hour+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        this.depreciation_methods.forEach(depreciation_method => {
                            if(RD.depreciation_method == depreciation_method.id){
                                this.data.depreciation_method = depreciation_method.name;
                                this.data.depreciation_method_id = depreciation_method.id;
                            }
                        });
                        let lifetime = 0;
                        if(RD.lifetime == null || RD.lifetime == ''){
                            this.data.lifetime = '0 Hour(s)';
                        }else{
                            this.data.lifetime = (RD.lifetime+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Hour(s)';
                        }
                        this.data.lt_uom = RD.lifetime_uom_id;
                        let lt = 0;
                        if(RD.lifetime_uom_id == 1){
                            lt = RD.lifetime/8;
                        }else if(RD.lifetime_uom_id == 2){
                            lt = (RD.lifetime/8)/30;
                        }else if(RD.lifetime_uom_id == 3){
                            lt = (RD.lifetime/8)/365;
                        }
                        this.data.lt = (lt+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        lifetime = RD.lifetime;

                        this.data.utilization = (usage / lifetime * 100).toFixed(2);
                    }else if(this.data.category_id == 1 || this.data.category_id == 2 || this.data.category_id == 0){
                        let lifetime = 0;
                        this.data.rental_duration = (RD.lifetime+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Hour(s)';
                        this.data.lt_uom = RD.lifetime_uom_id;
                        let lt = 0;
                        if(RD.lifetime_uom_id == 1){
                            lt = RD.lifetime/8;
                        }else if(RD.lifetime_uom_id == 2){
                            lt = (RD.lifetime/8)/30;
                        }else if(RD.lifetime_uom_id == 3){
                            lt = (RD.lifetime/8)/365;
                        }
                        this.data.lt = (lt+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        lifetime = RD.lifetime;

                        this.data.receive_date = RD.created_at.substr(0,10);
                        this.data.po_number = RD.goods_receipt_detail.goods_receipt.purchase_order.number;
                        this.data.utilization = (usage / lifetime * 100).toFixed(2);
                        if(this.data.category_id == 1){
                            this.data.other_name = RD.others_name;
                        }
                        if(this.data.category_id == 0){
                            this.data.address = RD.sub_con_address;
                            this.data.phone = RD.sub_con_phone;
                            this.data.competency = RD.sub_con_competency;
                        }
                    }
                    this.data.avg_productivity = ((actual_performance / planned_performance)*100).toFixed(2);
                    if(isNaN(this.data.avg_productivity)){
                        this.data.avg_productivity = "0.00"
                    }
                     if(isNaN(this.data.utilization)){
                        this.data.utilization = "0.00"
                    }
                }
            });
            $('div.overlay').hide();
        },
    },
    watch: {
        'editInput.performance': function(newValue){
            this.editInput.performance = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
        },
        'editInput.lifetime': function(newValue){
            this.editInput.lifetime = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
        },
        'editInput.cost_per_hour': function(newValue){
            this.editInput.cost_per_hour = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
        },
        'editInput.purchasing_price': function(newValue){
            this.editInput.purchasing_price = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
        },
    }
    });

</script>
@endpush
