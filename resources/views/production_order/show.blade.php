@extends('layouts.main')

@section('content-header')

@if($route == "/production_order")
    @breadcrumb(
        [
            'title' => 'View Production Order » '.$modelPrO->number,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order.selectProjectIndex'),
                'View All Production Order' => route('production_order.indexPrO',$modelPrO->project->id),
                'View Production Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/production_order_repair")
    @breadcrumb(
        [
            'title' => 'View Production Order » '.$modelPrO->number,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('production_order_repair.selectProjectIndex'),
                'View All Production Order' => route('production_order_repair.indexPrO',$modelPrO->project->id),
                'View Production Order' => '',
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
                <div class="col-sm-3 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Prod. Order Number</span>
                            <span class="info-box-number">{{ $modelPrO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-md-5 col-xs-5">
                            Project Number
                        </div>
                        <div class="col-md-7 col-xs-7">
                            : <b> {{ $modelPrO->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-xs-5">
                            Ship Name
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelPrO->project->name }}">
                            : <b> {{ $modelPrO->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-xs-5">
                            Ship Type
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelPrO->project->ship->type }}">
                            : <b> {{ $modelPrO->project->ship->type }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-xs-5">
                            Customer Name
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelPrO->project->customer->name }}">
                            : <b> {{ $modelPrO->project->customer->name }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            WBS Number
                        </div>
                        <div class="col-md-8 col-xs-7">
                            : <b> {{ $modelPrO->wbs->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Status
                        </div>
                        @if($modelPrO->status == 1)
                            <div class="col-md-8 col-xs-8">
                                : <b>UNRELEASED</b>
                            </div>
                        @elseif($modelPrO->status == 2)
                            <div class="col-md-8 col-xs-8">
                                : <b>RELEASED</b>
                            </div>
                        @else
                            <div class="col-md-8 col-xs-8">
                                : <b>COMPLETED</b>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Created By
                        </div>
                        <div class="col-md-8 col-xs-7 tdEllipsis">
                            : <b> {{ $modelPrO->user->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Created At
                        </div>
                        <div class="col-md-8 col-xs-7">
                            : <b> {{ $modelPrO->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            {{-- table activity --}}
            <div class="box-body p-t-0 p-b-5">
                <h4>Activity</h4>
                <table class="table table-bordered showTable tableFixed" id="activity-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Activity Name</th>
                            <th width="31%">Description</th>
                            <th width="13%">Planned Start Date</th>
                            <th width="13%">Planned End Date</th>
                            <th width="8%">Progress</th>
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
                                    <td>{{ $activity->progress  }} %</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->

            {{-- table material --}}
            <div class="box-body p-t-0 p-b-5">
                <h4>Material</h4>
                <table class="table table-bordered showTable tableFixed" id="material-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Material Number</th>
                            <th width="31%">Material Description</th>
                            <th width="7%">Quantity</th>
                            <th width="7%">Used</th>
                            <th width="10%">Unit</th>
                            <th width="10%">Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter=1)
                        @foreach($modelPrO->ProductionOrderDetails as $PrOD)
                        @if($PrOD->material_id != "" && $PrOD->production_order_detail_id == null)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $PrOD->material->code }}">{{ $PrOD->material->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $PrOD->material->description }}">{{ $PrOD->material->description }}</td>
                                <td>{{ number_format($PrOD->quantity,2) }}</td>
                                <td>{{ number_format($PrOD->actual,2) }}</td>
                                <td>{{ $PrOD->material->uom->unit }}</td>
                                <td>{{ $PrOD->source }}</td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- table resource --}}
            @if($modelPrO->status == 1)
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
                            @php($counter=1)
                            @foreach($modelPrO->ProductionOrderDetails as $PrOD)
                            @if($PrOD->resource_id != "")
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    @if($PrOD->category_id == 1)
                                        <td>Subcon</td>
                                    @elseif($PrOD->category_id == 2)
                                        <td>Others</td>
                                    @elseif($PrOD->category_id == 3)
                                        <td>External</td>
                                    @elseif($PrOD->category_id == 4)
                                        <td>Internal</td>
                                    @endif
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $PrOD->resource->code }} - {{ $PrOD->resource->description }}">{{ $PrOD->resource->code }} - {{ $PrOD->resource->description }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ ($PrOD->resourceDetail) ? $PrOD->resourceDetail->code : '' }}">{{ ($PrOD->resourceDetail) ? $PrOD->resourceDetail->code : '-'}}</td>
                                    <td>{{ number_format($PrOD->quantity) }}</td>
                                </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="box-body p-t-0 p-b-5">
                    <h4>Resource</h4>
                    <table class="table table-bordered showTable tableFixed" id="resource-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Category</th>
                                <th width="30%">Resource</th>
                                <th width="31%">Resource Detail</th>
                                <th width="17%">Performance</th>
                                <th width="17%">Usage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($counter=1)
                            @foreach($modelPrO->ProductionOrderDetails as $PrOD)
                                @if($PrOD->resource_id != "")
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        @if($PrOD->category_id == 1)
                                            <td>Subcon</td>
                                        @elseif($PrOD->category_id == 2)
                                            <td>Others</td>
                                        @elseif($PrOD->category_id == 3)
                                            <td>External</td>
                                        @elseif($PrOD->category_id == 4)
                                            <td>Internal</td>
                                        @endif
                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $PrOD->resource->code }} - {{ $PrOD->resource->name }}">{{ $PrOD->resource->code }} - {{ $PrOD->resource->name }}</td>
                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ ($PrOD->resourceDetail) ? $PrOD->resourceDetail->code : '' }}">{{ ($PrOD->resourceDetail) ? $PrOD->resourceDetail->code : '-'}}</td>
                                        @php($performance = isset($PrOD->performance) ? number_format($PrOD->performance) : '-')
                                        @if($performance == '-')
                                            @php($unit = '')
                                        @else
                                            @php($unit = isset($PrOD->performanceUom) ? $PrOD->performanceUom->unit : '')
                                        @endif
                                        <td class="tdEllipsis">{{ $performance.' '.$unit}}</td>
                                        <td class="tdEllipsis">{{ ($PrOD->usage) ? number_format($PrOD->usage).' Hour(s)' : '0 Hour'}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

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
        $('div.overlay').hide();
    });

</script>
@endpush
