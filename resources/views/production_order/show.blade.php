@extends('layouts.main')

@section('content-header')

@if($route == "/production_order")
    @breadcrumb(
        [
            'title' => 'View Production Order » '.$modelPrO->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Production Orders' => route('production_order.index'),
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
                'View All Production Orders' => route('production_order_repair.index'),
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
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Project Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPrO->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Project Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPrO->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            WBS Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPrO->wbs->code }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-5">
                            Status
                        </div>
                        @if($modelPrO->status == 1)
                            <div class="col-md-7">
                                : <b>UNRELEASED</b>
                            </div>
                        @elseif($modelPrO->status == 2)
                            <div class="col-md-7">
                                : <b>RELEASED</b>
                            </div>
                        @else
                            <div class="col-md-7">
                                : <b>COMPLETED</b>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- table activity --}}
            <div class="box-body p-t-0 p-b-5">
                    <h4>Activity</h4>
                <table class="table table-bordered showTable" id="activity-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Activity Name</th>
                            <th width="25%">Description</th>
                            <th width="25%">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter=1)
                        @foreach($modelActivities as $activity)
                        @if($activity->id != "")
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $activity->name }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->progress  }} %</td>
                            </tr>
                        @php($counter++)
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->

            {{-- table material --}}
            <div class="box-body p-t-0 p-b-5">
                    <h4>Material</h4>
                <table class="table table-bordered showTable" id="material-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Material Name</th>
                            <th width="25%">Quantity</th>
                            <th width="25%">Used</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter=1)
                        @foreach($modelPrO->ProductionOrderDetails as $PrOD)
                        @if($PrOD->material_id != "")
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $PrOD->material->name }}</td>
                                <td>{{ number_format($PrOD->quantity) }}</td>
                                <td>{{ number_format($PrOD->actual) }}</td>
                            </tr>
                        @php($counter++)
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->

            {{-- table service --}}
            <div class="box-body p-t-0 p-b-5">
                    <h4>Service</h4>
                <table class="table table-bordered showTable" id="service-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Service Name</th>
                            <th width="25%">Quantity</th>
                            <th width="25%">Used</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter=1)
                        @foreach($modelPrO->ProductionOrderDetails as $PrOD)
                        @if($PrOD->service_id != "")
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $PrOD->service->name }}</td>
                                <td>{{ number_format($PrOD->quantity) }}</td>
                                <td>{{ number_format($PrOD->actual) }}</td>
                            </tr>
                        @php($counter++)
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->

            {{-- table resource --}}
            <div class="box-body p-t-0 p-b-5">
                    <table class="table table-bordered showTable" id="resource-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="40%">Resource Name</th>
                            </tr>
                        </thead>
                <h4>Resource</h4>
                        <tbody>
                            @php($counter=1)
                            @foreach($modelPrO->ProductionOrderDetails as $PrOD)
                            @if($PrOD->resource_id != "")
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $PrOD->resource ->name}}</td>
                                </tr>
                                @php($counter++)
                            @endif
                            @endforeach
                        </tbody>
                    </table>
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
        $('div.overlay').hide();
    });

</script>
@endpush
