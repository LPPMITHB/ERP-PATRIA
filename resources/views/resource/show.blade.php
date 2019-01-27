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
                                    <td>{{ rd.brand }}</td>
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
                                    <div class="box-body p-t-0 p-l-0">
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
                                    <div class="box box-solid box-default m-b-0">
                                        <div class="box-body">
                                            <div class="col-md-3 col-xs-3 no-padding"><b>Planned</b></div>
                                            <div class="col-md-3 col-xs-3 no-padding"><b>Actual</b></div>
                                            <div class="col-md-3 col-xs-3 no-padding"><b>Utilization</b></div>
                                            <div class="col-md-3 col-xs-3 no-padding"><b>Productivity</b></div>

                                            <div class="col-md-3 col-xs-3 no-padding">
                                                <div class="col-md-4 col-xs-4 no-padding">Performance</div>
                                                <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.performance}}</b></div>
                                            </div>
                                            <div class="col-md-3 col-xs-3 no-padding">
                                                <div class="col-md-4 col-xs-4 no-padding">Performance</div>
                                                <div class="col-md-8 col-xs-8 no-padding"><b>: </b></div>
                                            </div>
                                            <div class="col-md-3 col-xs-3 no-padding">
                                                <div class="col-md-8 col-xs-8 no-padding"><b>: </b></div>
                                            </div>
                                            <div class="col-md-3 col-xs-3 no-padding">
                                                <div class="col-md-8 col-xs-8 no-padding"><b>: </b></div>
                                            </div>
                                            
                                            <div class="col-md-3 col-xs-3 no-padding">
                                                <div class="col-md-4 col-xs-4 no-padding">Duration</div>
                                                <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.rental_duration}}</b></div>
                                            </div>
                                            <div class="col-md-3 col-xs-3 no-padding">
                                                <div class="col-md-4 col-xs-4 no-padding">Duration</div>
                                                <div class="col-md-8 col-xs-8 no-padding"><b>: </b></div>
                                            </div>
                                            <div class="col-md-3 col-xs-3 no-padding"></div>
                                            <div class="col-md-3 col-xs-3 no-padding"></div>
                                        </div>
                                    </div>
                                    <template v-if="data.wbs.length > 0">
                                        <div class="box-body p-l-0 p-b-0">
                                            <h4>Usage History</h4>
                                        </div>
                                        <template v-for="wbs in data.wbs">
                                            <div class="box box-solid box-default">
                                                <div class="box-body">
                                                    <div class="col-md-3 col-xs-3 no-padding"><b>Planned</b></div>
                                                    <div class="col-md-3 col-xs-3 no-padding"><b>Actual</b></div>
                                                    <div class="col-md-3 col-xs-3 no-padding"><b>Utilization</b></div>
                                                    <div class="col-md-3 col-xs-3 no-padding"><b>Productivity</b></div>

                                                    <div class="col-md-3 col-xs-3 no-padding">
                                                        <div class="col-md-4 col-xs-4 no-padding">Performance</div>
                                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.performance}}</b></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-3 no-padding">
                                                        <div class="col-md-4 col-xs-4 no-padding">Performance</div>
                                                        <div class="col-md-8 col-xs-8 no-padding"><b>: </b></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-3 no-padding">
                                                        <div class="col-md-8 col-xs-8 no-padding"><b>: </b></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-3 no-padding">
                                                        <div class="col-md-8 col-xs-8 no-padding"><b>: </b></div>
                                                    </div>
                                                    
                                                    <div class="col-md-3 col-xs-3 no-padding">
                                                        <div class="col-md-4 col-xs-4 no-padding">Duration</div>
                                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{data.rental_duration}}</b></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-3 no-padding">
                                                        <div class="col-md-4 col-xs-4 no-padding">Duration</div>
                                                        <div class="col-md-8 col-xs-8 no-padding"><b>: </b></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-3 no-padding"></div>
                                                    <div class="col-md-3 col-xs-3 no-padding"></div>
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
        data:{
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
            wbs : [],
        }
    };

    var vm = new Vue({
    el : '#monitoring',
    data : data,
    methods : {
        clearData(){
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
            this.data.wbs = [];
        },
        showDetail(id){
            $('div.overlay').show();
            this.clearData();
            this.data.selectedId = id;

            this.modelRD.forEach(RD => {
                if(RD.id == this.data.selectedId){
                    this.data.code = RD.code;
                    this.data.po_number = RD.goods_receipt_detail.goods_receipt.purchase_order.number;
                    this.data.receive_date = RD.created_at.substr(0,10);
                    this.data.brand = RD.brand;
                    this.data.description = (RD.description != '') ? RD.description : '-';
                    this.data.performance = (RD.performance+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+" "+RD.performance_uom.unit+" / hour";

                    if(RD.lifetime_uom_id == 1){
                        this.data.rental_duration = (RD.lifetime/8+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Day(s)';
                    }else if(RD.lifetime_uom_id == 2){
                        this.data.rental_duration = ((RD.lifetime/8)/30+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Month(s)';
                    }else if(RD.lifetime_uom_id == 3){
                        this.data.rental_duration = ((RD.lifetime/8)/365+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' Year(s)';
                    }

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
                    
                    if(RD.production_order_details.length > 0){
                        this.data.wbs = RD.production_order_details;
                    }
                }
            });
            $('div.overlay').hide();
        },
    }
    });

</script>
@endpush
