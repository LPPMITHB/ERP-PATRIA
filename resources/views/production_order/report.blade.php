@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Production Order Actual Cost Report » '.$modelPrO->number,
        'items' => [
            'Dashboard' => route('index'),
            'Production Order Actual Cost Report' => '',
        ]
    ]
)
@endbreadcrumb
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
                            <span class="info-box-text">Production Order Number</span>
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
                    <div class="row">
                        <div class="col-md-5">
                            Actual Total Price
                        </div>
                        <div class="col-md-7">
                            : <b>Rp.{{number_format($totalPrice)}}</b>
                        </div>
                    </div>
                </div>
            </div>
            {{-- table material --}}
            <div class="box-body p-t-0 p-b-5">
                    <h4>Material</h4>
                <table class="table table-bordered showTable" id="material-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Material Name</th>
                            <th width="20%">Planned Quantity</th>
                            <th width="20%">Actual Quantity</th>
                            <th width="20%">Actual Sub Total Cost</th>
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
                                <td>{{ number_format($PrOD->actual * $PrOD->material->cost_standard_price) }}</td>
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
                                <th width="40%">Actual Sub Total Cost</th>
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
                                    <td>Rp.{{ number_format(1000000)}}</td>
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
