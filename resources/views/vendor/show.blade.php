@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Vendor',
        'items' => [
            'Dashboard' => route('index'),
            'View All Vendors' => route('vendor.index'),
            $vendor->name => route('vendor.show',$vendor->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-tools pull-right p-t-5 p-r-10">
                @can('edit-vendor')
                    <a href="{{ route('vendor.edit',['id'=>$vendor->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                @endcan
            </div>
            <div class="row p-t-15 m-l-15">
                <div class="col-xs-12 col-lg-5 col-md-12">
                    <div class="col-md-4 col-xs-6 no-padding">Code</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->code}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Name</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->name}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Type</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->type}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Address</div>
                    <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $vendor->address }}"><b>: {{ $vendor->address }}</b></div>

                    @if(in_array(2,json_decode($business_ids)))
                    <div class="col-md-4 col-xs-6 no-padding">City</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->phone_number_1}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Province</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->phone_number_1}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Country</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->country}}</b></div>
                    @endif

                    <div class="col-md-4 col-xs-6 no-padding">Phone Number 1</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->phone_number_1}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Phone Number 2</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->phone_number_2}}</b></div>

                </div>
                <div class="col-xs-12 col-lg-6 col-md-12">

                    @if(in_array(2,json_decode($business_ids)))
                    <div class="col-md-4 col-xs-6 no-padding">Currencies</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->currencies}}</b></div>
                    <div class="col-md-4 col-xs-6 no-padding">Tax Number</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->tax_number}}</b></div>
                    <div class="col-md-4 col-xs-6 no-padding">PPn</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->pajak_pertambahan_nilai}}%</b></div>
                    <div class="col-md-4 col-xs-6 no-padding">PPh</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->pajak_penghasilan}}%</b></div>
                    @endif

                    <div class="col-md-4 col-xs-6 no-padding">Contact Name</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->contact_name}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Email</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->email}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Description</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: {{$vendor->description}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Status</div>
                    <div class="col-md-8 col-xs-6 no-padding"><b>: @if ($vendor->status == 1)
                            <i class="fa fa-check"></i>
                        @elseif ($vendor->status == 0)
                            <i class="fa fa-times"></i>
                        @endif</b>
                    </div>

                    <div class="col-md-4 col-xs-6 no-padding">Delivery Term</div>
                    <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$dt_name}}"><b>: {{$dt_name}}</b></div>

                    <div class="col-md-4 col-xs-6 no-padding">Payment Term</div>
                    <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$pt_name}}"><b>: {{$pt_name}}</b></div>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-sm-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#quality" data-toggle="tab">Quality</a></li>
                            <li><a href="#cost" data-toggle="tab">Cost</a></li>
                            <li><a href="#delivery" data-toggle="tab">Delivery</a></li>
                            @if($vendor->type == "Subcon")
                                <li><a href="#safety" data-toggle="tab">Safety</a></li>
                                <li><a href="#morale" data-toggle="tab">Morale</a></li>
                                <li><a href="#productivity" data-toggle="tab">Productivity</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="quality">
                        <div class="box-body p-t-0 m-l-10 m-r-10">
                            <table class="table table-bordered showTable qualityTable tableFixed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">GI Number</th>
                                        <th width="45%">Description</th>
                                        <th width="30%">Returned Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($return as $GI)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('goods_issue.show',$GI->id) }}" class="text-primary">{{$GI->number}}</a>
                                            </td>
                                            <td>{{ $GI->description }}</td>
                                            <td>{{ $GI->goodsIssueDetails->sum('quantity')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="cost">
                        <div class="box-body p-t-0 m-l-10 m-r-10">
                            @if(count($modelPOs)>0)
                                <h4>Purchase Order</h4>
                                <table class="table table-bordered showTable poCostTable">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="10%">PO Number</th>
                                            <th width="40%">Description</th>
                                            <th width="10%">Status</th>
                                            <th width="35%">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modelPOs as $modelPO)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('purchase_order.show',$modelPO->id) }}" class="text-primary">{{$modelPO->number}}</a>
                                                </td>
                                                <td>{{ $modelPO->description }}</td>
                                                @if($modelPO->status == 1)
                                                    <td>OPEN</td>
                                                @elseif($modelPO->status == 2)
                                                    <td>APPROVED</td>
                                                @elseif($modelPO->status == 3)
                                                    <td>NEED REVISION</td>
                                                @elseif($modelPO->status == 4)
                                                    <td>REVISED</td>
                                                @elseif($modelPO->status == 5)
                                                    <td>REJECTED</td>
                                                @elseif($modelPO->status == 0)
                                                    <td>RECEIVED</td>
                                                @endif
                                                <td>Rp {{ number_format($modelPO->total_price,2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            @endif

                            {{-- @if(count($modelWOs)>0)  --}}
                            {{-- <h4>Work Order</h4> --}}
                            <table class="table table-bordered showTable woCostTable">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">WO Number</th>
                                            <th width="35%">Description</th>
                                            <th width="10%">Status</th>
                                            <th width="35%">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modelWOs as $modelWO)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('work_order.show',$modelWO->id) }}" class="text-primary">{{$modelWO->number}}</a>
                                                </td>
                                                <td>{{ $modelWO->description }}</td>
                                                @if($modelWO->status == 1)
                                                    <td>OPEN</td>
                                                @elseif($modelWO->status == 2)
                                                    <td>APPROVED</td>
                                                @elseif($modelWO->status == 3)
                                                    <td>NEED REVISION</td>
                                                @elseif($modelWO->status == 4)
                                                    <td>REVISED</td>
                                                @elseif($modelWO->status == 5)
                                                    <td>REJECTED</td>
                                                @elseif($modelWO->status == 0)
                                                    <td>RECEIVED</td>
                                                @endif
                                                <td>Rp {{ number_format($modelWO->total_price,2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            {{-- @else

                            @endif --}}
                        </div>
                    </div>
                    <div class="tab-pane" id="delivery">
                        <div class="box-body p-t-0 m-l-10 m-r-10">
                            <table class="table table-bordered deliveryTable">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">GR Number</th>
                                        <th width="15%">PO Number</th>
                                        <th width="20%">GR Description</th>
                                        <th width="10%">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modelGRs as $modelGR)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('goods_receipt.show',$modelGR->id) }}" class="text-primary">{{$modelGR->number}}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('purchase_order.show',$modelGR->purchaseOrder->id) }}" class="text-primary">{{$modelGR->purchaseOrder->number}}</a>
                                            </td>
                                            <td>{{ $modelGR->description }}</td>
                                            <td class="textCenter"><a class="btn btn-primary btn-xs buttonDetail" id="detail_{{$modelGR->id}}" @click.prevent="openDeliveryDetails({{$modelGR->id}})">DETAILS</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @verbatim
                            <div id="modal_details">
                                <div class="modal fade" id="show_details">
                                    <div class="modal-dialog modalFull">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title">Status Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Material Number</th>
                                                                    <th>Material Description</th>
                                                                    <th>PO Delivery Date</th>
                                                                    <th>GR Received Date</th>
                                                                    <th>Status</th>
                                                                    <th>Difference</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(grd,index) in selectedGRD">
                                                                    <td class="tdEllipsis">{{grd.material_code}}</td>
                                                                    <td class="tdEllipsis">{{grd.material_desription}}</td>
                                                                    <td>{{grd.required_date.split('-').reverse().join('-')}}</td>
                                                                    <td>{{grd.received_date.split('-').reverse().join('-')}}</td>
                                                                    <td v-if="grd.required_date > grd.received_date"><b class="text-success">EARLY</b></td>
                                                                    <td v-else-if="grd.required_date < grd.received_date"><b class="text-danger">LATE</b></td>
                                                                    <td v-else-if="grd.required_date == grd.received_date"><b class="text-success">ON TIME</b></td>
                                                                    <td v-else></b class="text-danger">-</b></td>
                                                                    <td>{{grd.date_diff}} Day(s)</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endverbatim
                        </div>
                    </div>
                    @if($vendor->type == "Subcon")
                    <div class="tab-pane" id="safety">
                        <div class="box-body p-t-0 m-l-10 m-r-10">
                            <table class="table table-bordered showTable safetyTable tableFixed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">Prod. Order Number</th>
                                        <th width="35%">WBS Name</th>
                                        <th width="25%">Project</th>
                                        <th width="25%">Total Accident</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 0;
                                    @endphp
                                    @foreach($resourceDetails->where('category_id', 0) as $resourceDetail)
                                        @foreach ($resourceDetail->productionOrderDetails->where('status',"ACTUALIZED")->take(5) as $prod)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>
                                                    <a href="{{ route('production_order.show',$prod->productionOrder->id) }}" class="text-primary">{{$prod->productionOrder->number}}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('wbs.show',$prod->productionOrder->wbs->id) }}" class="text-primary">{{$prod->productionOrder->wbs->number}}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('project.show',$prod->productionOrder->wbs->project->id) }}" class="text-primary">{{$prod->productionOrder->wbs->project->number}} - {{$prod->productionOrder->wbs->project->name}}</a>
                                                </td>
                                                <td>{{ $prod->actual }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="morale">
                        <div class="box-body p-t-0 m-l-10 m-r-10">
                            <table class="table table-bordered showTable moraleTable tableFixed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Prod. Order Number</th>
                                        <th width="20%">WBS Name</th>
                                        <th width="20%">Project</th>
                                        <th width="20%">Subject</th>
                                        <th width="40%">Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach($resourceDetails->where('category_id', 0) as $resourceDetail)
                                        @foreach ($resourceDetail->productionOrderDetails->take(5) as $prod)
                                            @php
                                                $moraleNotes = json_decode($prod->morale);
                                            @endphp
                                            @foreach ($moraleNotes as $morale)
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>
                                                        <a href="{{ route('production_order.show',$prod->productionOrder->id) }}" class="text-primary">{{$prod->productionOrder->number}}</a>
                                                    </td>
                                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$prod->productionOrder->wbs->number}}">
                                                        <a href="{{ route('wbs.show',$prod->productionOrder->wbs->id) }}" class="text-primary">{{$prod->productionOrder->wbs->number}}</a>
                                                    </td>
                                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$prod->productionOrder->wbs->project->number}} - {{$prod->productionOrder->wbs->project->name}}">
                                                        <a href="{{ route('project.show',$prod->productionOrder->wbs->project->id) }}" class="text-primary">{{$prod->productionOrder->wbs->project->number}} - {{$prod->productionOrder->wbs->project->name}}</a>
                                                    </td>
                                                    <td>{{ $morale->subject }}</td>
                                                    <td>{{ $morale->notes }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="productivity">
                        <div class="box-body p-t-0 m-l-10 m-r-10">
                            <table class="table table-bordered showTable productivityTable tableFixed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="35%">Resource Name</th>
                                        <th width="20%">Prod. Order Number</th>
                                        <th width="25%">Performance</th>
                                        <th width="25%">Usage</th>
                                        <th width="25%">Productivity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach($resourceDetails as $resourceDetail)
                                        @foreach ($resourceDetail->productionOrderDetails->where('status',"ACTUALIZED")->take(5) as $prod)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $resourceDetail->resource->name }} - {{ $resourceDetail->code }}</td>
                                                <td>
                                                    <a href="{{ route('production_order.show',$prod->productionOrder->id) }}" class="text-primary">{{$prod->productionOrder->number}}</a>
                                                </td>
                                                <td>{{ number_format($prod->performance,2) }} {{$prod->performanceUom->name}}</td>
                                                <td>{{ number_format($prod->usage,2) }} Hour(s)</td>
                                                <td>{{ number_format($prod->performance / $prod->usage,2) }} {{$prod->performanceUom->name}}/Hour(s)</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
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

    $(document).ready(function(){
        $('.qualityTable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
        // $('.qualityTable thead tr').clone(true).appendTo( '.qualityTable thead' );
        // $('.qualityTable thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Returned Quantity"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( qualityTable.column(i).search() !== this.value ) {
        //             qualityTable
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var qualityTable = $('.qualityTable').DataTable( {
        //     orderCellsTop   : true,
        //     fixedHeader     : true,
        //     paging          : true,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : true,
        // });

        $('.poCostTable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });

        // $('.poCostTable thead tr').clone(true).appendTo( '.poCostTable thead' );
        // $('.poCostTable thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Total Price"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( poCostTable.column(i).search() !== this.value ) {
        //             poCostTable
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var poCostTable = $('.poCostTable').DataTable( {
        //     orderCellsTop   : true,
        //     fixedHeader     : true,
        //     paging          : true,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : true,
        // });

        $('.woCostTable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });

        // $('.woCostTable thead tr').clone(true).appendTo( '.woCostTable thead' );
        // $('.woCostTable thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Total Price"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( woCostTable.column(i).search() !== this.value ) {
        //             woCostTable
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var woCostTable = $('.woCostTable').DataTable( {
        //     orderCellsTop   : true,
        //     fixedHeader     : true,
        //     paging          : true,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : true,
        // });

        $('.deliveryTable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });

        // $('.deliveryTable thead tr').clone(true).appendTo( '.deliveryTable thead' );
        // $('.deliveryTable thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Day(s)"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( deliveryTable.column(i).search() !== this.value ) {
        //             deliveryTable
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var deliveryTable = $('.deliveryTable').DataTable( {
        //     orderCellsTop   : true,
        //     fixedHeader     : true,
        //     paging          : true,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : true,
        // });

        $('.productivityTable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });

        // $('.productivityTable thead tr').clone(true).appendTo( '.productivityTable thead' );
        // $('.productivityTable thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Performance" || title == "Usage" || title == "Productivity"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( productivityTable.column(i).search() !== this.value ) {
        //             productivityTable
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var productivityTable = $('.productivityTable').DataTable( {
        //     orderCellsTop   : true,
        //     fixedHeader     : true,
        //     paging          : true,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : true,
        // });

        $('.safetyTable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });

        // $('.safetyTable thead tr').clone(true).appendTo( '.safetyTable thead' );
        // $('.safetyTable thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Total Accident"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( safetyTable.column(i).search() !== this.value ) {
        //             safetyTable
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var safetyTable = $('.safetyTable').DataTable( {
        //     orderCellsTop   : true,
        //     fixedHeader     : true,
        //     paging          : true,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : true,
        // });

        $('.moraleTable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });

        // $('.moraleTable thead tr').clone(true).appendTo( '.moraleTable thead' );
        // $('.moraleTable thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No'){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( moraleTable.column(i).search() !== this.value ) {
        //             moraleTable
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var moraleTable = $('.moraleTable').DataTable( {
        //     orderCellsTop   : true,
        //     fixedHeader     : true,
        //     paging          : true,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : true,
        // });

        // $('div.overlay').hide();
    });

    var data = {
        modelGRDs: @json($modelGRDs),
        modelPODs: @json($modelPODs),
        selectedGRD: [],
        selectedPOD: [],
    };

    function details(id){
        var details = ""
        document.getElementById("details").value = details;
    };

    var vm = new Vue({
        el:"#delivery",
        data: data,
        methods: {
            openDeliveryDetails(id) {
                //ambil material yang ada di goods receipt
                this.selectedGRD = [];
                this.modelGRDs.forEach(modelGRD => {
                    if(modelGRD.goods_receipt_id == id){
                        window.axios.get('/api/getMaterialVendor/'+modelGRD.material_id).then(({ data }) => {
                            this.modelPODs.forEach(modelPOD => {
                                modelPOD.forEach(POD =>{
                                    if(POD.material_id == modelGRD.material_id)
                                    {
                                        modelGRD.required_date = POD.delivery_date;
                                    }
                                })
                            });
                            modelGRD.material_code = data.code;
                            modelGRD.material_desription = data.description;
                            var date1 = new Date(modelGRD.received_date);
                            var date2 = new Date(modelGRD.required_date);
                            modelGRD.date_diff = Math.ceil(Math.abs(date1-date2) / (1000*60*60*24));
                            this.selectedGRD.push(modelGRD);
                            $('div.overlay').hide();
                        })
                        .catch((error) => {
                            iziToast.warning({
                                title: 'Please Try Again..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            console.log(error);
                            $('div.overlay').hide();
                        })
                    }
                });
                $('#show_details').modal();
            }
        }
    });

</script>
@endpush
