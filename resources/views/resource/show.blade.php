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
                                    <div class="box-body p-t-0 p-l-0" v-if="data.category_id == 0">
                                        <div class="col-sm-3 p-l-0">
                                            <div class="col-md-6 col-xs-6 no-padding">PO Number</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.po_number}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Receive Date</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.receive_date}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Status</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.status}}</b></div>
                                        </div>
                                        <div class="col-sm-4 p-l-0">
                                            <div class="col-md-4 col-xs-4 no-padding">Address</div>
                                            <div class="col-md-8 col-xs-8 no-padding tdEllipsis"><b>: {{(data.address) ? data.address : '-'}}</b></div>
    
                                            <div class="col-md-4 col-xs-4 no-padding">Phone</div>
                                            <div class="col-md-8 col-xs-8 no-padding tdEllipsis"><b>: {{(data.phone) ? data.phone : '-'}}</b></div>
    
                                            <div class="col-md-4 col-xs-4 no-padding">Competency</div>
                                            <div class="col-md-8 col-xs-8 no-padding tdEllipsis" ><b>: {{(data.competency) ? data.competency : '-'}}</b></div>
                                        </div>
                                    </div>

                                    <div class="box-body p-t-0 p-l-0" v-if="data.category_id == 1">
                                        <div class="col-sm-3 p-l-0">
                                            <div class="col-md-6 col-xs-6 no-padding">PO Number</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.po_number}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Receive Date</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.receive_date}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Status</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.status}}</b></div>
                                        </div>
                                        <div class="col-sm-4 p-l-0">
                                            <div class="col-md-4 col-xs-4 no-padding">Name</div>
                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.other_name}}</b></div>
    
                                            <div class="col-md-4 col-xs-4 no-padding">Type</div>
                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.type}}</b></div>
    
                                            <div class="col-md-4 col-xs-4 no-padding">Description</div>
                                            <div class="col-md-8 col-xs-8 no-padding tdEllipsis"><b>: {{data.description}}</b></div>
                                        </div>
                                    </div>

                                    <div class="box-body p-t-0 p-l-0" v-if="data.category_id == 2">
                                        <div class="col-sm-3 p-l-0">
                                            <div class="col-md-6 col-xs-6 no-padding">PO Number</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.po_number}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Receive Date</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.receive_date}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Status</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.status}}</b></div>
                                        </div>
                                        <div class="col-sm-4 p-l-0">
                                            <div class="col-md-4 col-xs-4 no-padding">Brand</div>
                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.brand}}</b></div>
    
                                            <div class="col-md-4 col-xs-4 no-padding">Type</div>
                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.type}}</b></div>
    
                                            <div class="col-md-4 col-xs-4 no-padding">Description</div>
                                            <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.description}}</b></div>
                                        </div>
                                    </div>

                                    <div class="box-body p-t-0 p-l-0" v-if="data.category_id == 3">
                                        <div class="col-sm-4 p-l-0">
                                            <div class="col-md-6 col-xs-6 no-padding">Brand</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.brand}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Type</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.type}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Description</div>
                                            <div class="col-md-6 col-xs-6 no-padding tdEllipsis"><b>: {{data.description}}</b></div>
    
                                            <div class="col-md-6 col-xs-6 no-padding">Status</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{data.status}}</b></div>

                                            <div class="col-md-6 col-xs-6 no-padding">Running Hours</div>
                                            <div class="col-md-6 col-xs-6 no-padding"><b>: {{(data.running_hour) ? data.running_hour : '-'}}</b></div>
                                        </div>
                                        <div class="col-sm-8 p-l-0">
                                            <div class="col-md-3 col-xs-3 no-padding">Manufactured Date</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{(data.manufactured_date) ? data.manufactured_date : '-'}}</b></div>
    
                                            <div class="col-md-3 col-xs-3 no-padding">Purchasing Date</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{(data.purchasing_date) ? data.purchasing_date : '-'}}</b></div>
    
                                            <div class="col-md-3 col-xs-3 no-padding">Purchasing Price</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{(data.purchasing_price) ? data.purchasing_price : '-'}}</b></div>

                                            <div class="col-md-3 col-xs-3 no-padding">Lifetime</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{data.lifetime}}</b></div>

                                            <div class="col-md-3 col-xs-3 no-padding">Depreciation Method</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{data.depreciation_method}}</b></div>
                                            
                                            <div class="col-md-3 col-xs-3 no-padding">Cost Per Hour</div>
                                            <div class="col-md-9 col-xs-9 no-padding"><b>: {{(data.cost_per_hour) ? data.cost_per_hour : '-'}}</b></div>
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
            avg_productivity : ""
        }
    };

    var vm = new Vue({
    el : '#monitoring',
    data : data,
    methods : {
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
        },
        showDetail(id){
            $('div.overlay').show();
            this.clearData();
            this.data.selectedId = id;

            this.modelRD.forEach(RD => {
                if(RD.id == this.data.selectedId){
                    let planned_performance = 0;
                    let actual_performance = 0;

                    this.data.category_id = RD.category_id;
                    this.data.code = RD.code;
                    this.data.brand = RD.brand;
                    this.data.description = (RD.description != '') ? RD.description : '-';
                    this.data.performance = (RD.performance+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+" "+RD.performance_uom.unit+" / hour";
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
                        this.data.running_hour = RD.running_hour;
                        this.data.manufactured_date = RD.manufactured_date;
                        this.data.purchasing_date = RD.purchasing_date;
                        this.data.purchasing_price = RD.purchasing_price;
                        this.data.cost_per_hour = RD.cost_per_hour;
                        this.depreciation_methods.forEach(depreciation_method => {
                            if(RD.depreciation_method == depreciation_method.id){
                                this.data.depreciation_method = depreciation_method.name;
                            }
                        });
                        let lifetime = 0;
                        this.data.lifetime = (RD.lifetime+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Hour(s)';
                        lifetime = RD.lifetime;
                        // if(RD.lifetime_uom_id == 1){
                        // lifetime = RD.lifetime;
                        //     this.data.lifetime = (RD.lifetime+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Hour(s)';
                        // }else if(RD.lifetime_uom_id == 2){
                        //     lifetime = RD.lifetime/30;
                        //     this.data.lifetime = ((RD.lifetime/8)/30+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Month(s)';
                        // }else if(RD.lifetime_uom_id == 3){
                        //     lifetime = RD.lifetime/365;
                        //     this.data.lifetime = ((RD.lifetime/8)/365+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Year(s)';
                        // }
                        this.data.utilization = (usage / lifetime * 100).toFixed(2);
                    }else if(this.data.category_id == 1 || this.data.category_id == 2 || this.data.category_id == 0){
                        let lifetime = 0;
                        this.data.rental_duration = (RD.lifetime+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Hour(s)';
                        lifetime = RD.lifetime;
                        // if(RD.lifetime_uom_id == 1){
                        //     lifetime = RD.lifetime;
                        //     this.data.rental_duration = (RD.lifetime+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Hour(s)';
                        // }else if(RD.lifetime_uom_id == 2){
                        //     lifetime = RD.lifetime/30;
                        //     this.data.rental_duration = ((RD.lifetime/8)/30+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Month(s)';
                        // }else if(RD.lifetime_uom_id == 3){
                        //     lifetime = RD.lifetime/365;
                        //     this.data.rental_duration = ((RD.lifetime/8)/365+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Year(s)';
                        // }

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
                    console.log(this.data.avg_productivity);
                    }
                }
            });
            $('div.overlay').hide();
        },
    }
    });

</script>
@endpush
