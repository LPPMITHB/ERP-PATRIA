@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Production Order » '.$modelPO->number,
        'items' => [
            'Dashboard' => route('index'),
            'View Production Order' => route('production_order.show',$modelPO->id),
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
                            <span class="info-box-text">Prod. Order Number</span>
                            <span class="info-box-number">{{ $modelPO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Project Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPO->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Project Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPO->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Work Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPO->work->code }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-5">
                            Status
                        </div>
                        @if($modelPO->status == 1)
                            <div class="col-md-7">
                                : <b>UNRELEASED</b>
                            </div>
                        @elseif($modelPO->status == 2)
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
            {{-- table material --}}
            <div class="box-body p-t-0 p-b-5">
                    <h4>Material</h4>
                <table class="table table-bordered showTable" id="material-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Material Name</th>
                            <th width="25%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter=1)
                        @foreach($modelPO->ProductionOrderDetails as $POD)
                        @if($POD->material_id != "")
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $POD->material->name }}</td>
                                <td>{{ number_format($POD->quantity) }}</td>
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
                            @foreach($modelPO->ProductionOrderDetails as $POD)
                            @if($POD->resource_id != "")
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $POD->resource ->name}}</td>
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
