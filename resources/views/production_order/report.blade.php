@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'WO Actual Cost Report » '.$modelWO->number,
        'items' => [
            'Dashboard' => route('index'),
            'WO Actual Cost Report' => '',
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
                            <span class="info-box-text">WO Number</span>
                            <span class="info-box-number">{{ $modelWO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Project Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelWO->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Project Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelWO->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Work Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelWO->work->code }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-5">
                            Status
                        </div>
                        @if($modelWO->status == 1)
                            <div class="col-md-7">
                                : <b>UNRELEASED</b>
                            </div>
                        @elseif($modelWO->status == 2)
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
                        @foreach($modelPO->ProductionOrderDetail as $POD)
                        @if($POD->material_id != "")
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $POD->material->name }}</td>
                                <td>{{ number_format($POD->quantity) }}</td>
                                <td>{{ number_format($POD->actual) }}</td>
                                <td>{{ number_format($POD->actual * $POD->material->cost_standard_price) }}</td>
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
                            @foreach($modelPO->ProductionOrderDetails as $POD)
                            @if($POD->resource_id != "")
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $POD->resource ->name}}</td>
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
