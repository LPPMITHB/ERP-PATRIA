@extends('layouts.main')

@section('content-header')
@if($route == "/rap")
    @breadcrumb(
        [
            'title' => 'View RAP » '.$modelRap->project->name,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap.indexSelectProject'),
                'Select RAP' => route('rap.index',$modelRap->project_id),
                'View RAP' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/rap_repair")
    @breadcrumb(
        [
            'title' => 'View RAP » '.$modelRap->project->name,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap_repair.indexSelectProject'),
                'Select RAP' => route('rap_repair.index',$modelRap->project_id),
                'View RAP' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">RAP Number</span>
                            <span class="info-box-number">{{ $modelRap->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Project Number
                        </div>
                        <div class="col-xs-7 col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelRap->project->number}}">
                            : <b> {{ $modelRap->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Ship Name
                        </div>
                        <div class="col-xs-7 col-md-7 tdEllipsis">
                            : <b> {{ $modelRap->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Customer Name
                        </div>
                        <div class="col-xs-7 col-md-7 tdEllipsis">
                            : <b> {{ $modelRap->project->customer->name }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-4">
                            Ship Type
                        </div>
                        <div class="col-xs-7 col-md-8 tdEllipsis">
                            : <b> {{ $modelRap->project->ship->type }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-4">
                            Created At
                        </div>
                        <div class="col-xs-7 col-md-8 tdEllipsis">
                            : <b>{{ $modelRap->created_at }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-4">
                            Created By
                        </div>
                        <div class="col-xs-7 col-md-8 tdEllipsis">
                            : <b>{{ $modelRap->user->name }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-10">
                @if($route == '/rap')
                    <table class="table table-bordered tableFixed showTable" id="rap-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Material Number</th>
                                <th width="30%">Material Description</th>
                                <th width="10%">Quantity</th>
                                <th width="5%">Unit</th>
                                <th width="15%">Cost per unit</th>
                                <th width="20%">Sub Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelRap->rapDetails as $rapDetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rapDetail->material->code }}</td>
                                    <td>{{ $rapDetail->material->description }}</td>
                                    <td>{{ number_format($rapDetail->quantity,2) }}</td>
                                    <td>{{ $rapDetail->material->uom->unit }}</td>
                                    <td>Rp.{{ number_format($rapDetail->price / $rapDetail->quantity,2) }}</td>
                                    <td>Rp.{{ number_format($rapDetail->price,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="visibility:hidden"></td>
                                <td class="text-right p-r-5"><b>Total Cost :</b></td>
                                <td class="text-left p-r-5"><b>Rp.{{ number_format($modelRap->total_price,2) }}</b></td>
                            </tr>
                        </tfoot>
                    </table>     
                @elseif($route == '/rap_repair')
                    <h4>Material</h4>
                    <table class="table table-bordered tableFixed showTable" id="rap-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Number</th>
                                <th width="30%">Description</th>
                                <th width="20%">Dimension</th>
                                <th width="8%">Qty</th>
                                <th width="10%">Source</th>
                                <th width="15%">Cost per pcs</th>
                                <th width="15%">Sub Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelRapDetails as $rapDetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="tdEllipsis">{{ $rapDetail->material->code }}</td>
                                    <td class="tdEllipsis">{{ $rapDetail->material->description }}</td>
                                    <td class="tdEllipsis">{{$rapDetail->dimensions_string}}</td>
                                    <td>{{ number_format($rapDetail->quantity,2) }}</td>                                    
                                    <td class="tdEllipsis">{{$rapDetail->source}}</td>
                                    <td>Rp.{{ number_format($rapDetail->price / $rapDetail->quantity,2) }}</td>
                                    <td>Rp.{{ number_format($rapDetail->price,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" style="visibility:hidden"></td>
                                <td class="text-right p-r-5"><b>Total Material Cost :</b></td>
                                <td class="text-left p-r-5"><b>Rp.{{ number_format($modelRap->total_price,2) }}</b></td>
                            </tr>
                        </tfoot>
                    </table>   

                    <h4>Service</h4>
                    <table class="table table-bordered tableFixed showTable" id="service-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Number</th>
                                <th width="20%">Description</th>
                                <th width="25%">Service Detail</th>
                                <th width="10%">Qty/Area</th>
                                <th width="20%">Vendor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wbss as $wbs)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="tdEllipsis">{{ $wbs->number }}</td>
                                <td class="tdEllipsis">{{ $wbs->description }}</td>
                                <td class="tdEllipsis">{{ $wbs->serviceDetail->name }} - {{ $wbs->serviceDetail->description }}</td>
                                <td class="tdEllipsis">{{ $wbs->area }} {{ $wbs->areaUom->unit }}</td>
                                <td class="tdEllipsis">{{ $wbs->vendor->code }} - {{ $wbs->vendor->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="visibility:hidden"></td>
                                <td class="text-right p-r-5"><b>Total Cost :</b></td>
                                <td class="text-left p-r-5"><b>Rp.{{ number_format($modelRap->total_price,2) }}</b></td>
                            </tr>
                        </tfoot>
                    </table>
                @endif
                </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){

        $('#rap-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
                document.getElementById("rap-table_wrapper").setAttribute("style", "margin-top: -30px");
            }
        });

        $('#service-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
                document.getElementById("service-table_wrapper").setAttribute("style", "margin-top: -30px");
            }
        });
    });
</script>
@endpush
