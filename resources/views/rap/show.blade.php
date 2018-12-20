@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View RAP » '.$modelRap->project->name,
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('rap.indexSelectProject'),
            'View RAP' => route('rap.show',$modelRap->id),
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
                            Project Code
                        </div>
                        <div class="col-xs-7 col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelRap->project->number}}">
                            : <b> {{ $modelRap->project->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Project Name
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
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Total Cost
                        </div>
                        <div class="col-xs-7 col-md-7 tdEllipsis">
                            : <b>Rp.{{ number_format($modelRap->total_price) }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-4">
                            Ship Name
                        </div>
                        <div class="col-xs-7 col-md-8 tdEllipsis">
                            : <b> {{ $modelRap->project->ship->type }} </b>
                        </div>
                    </div>
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
            <div class="box-body p-t-0 p-b-0">
                @if($route == '/rap')
                    <table class="table table-bordered showTable tableFixed" id="boms-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Material Name</th>
                                <th width="10%">Quantity</th>
                                <th width="15%">Cost per pcs</th>
                                <th width="20%">Sub Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelRap->rapDetails as $rapDetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rapDetail->material->name }}</td>
                                    <td>{{ $rapDetail->quantity }}</td>
                                    <td>Rp.{{ number_format($rapDetail->price / $rapDetail->quantity) }}</td>
                                    <td>Rp.{{ number_format($rapDetail->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>     
                @elseif($route == '/rap_repair')
                    <table class="table table-bordered showTable tableFixed" id="boms-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Type</th>
                                <th width="30%">Material Name</th>
                                <th width="10%">Quantity</th>
                                <th width="15%">Cost per pcs</th>
                                <th width="20%">Sub Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelRap->rapDetails as $rapDetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if($rapDetail->material_id != null)
                                        <td>Material</td>
                                        <td>{{ $rapDetail->material->name }}</td>
                                    @elseif($rapDetail->service_id != null)
                                        <td>Service</td>
                                        <td>{{ $rapDetail->service->name }}</td>
                                    @endif
                                    <td>{{ $rapDetail->quantity }}</td>
                                    <td>Rp.{{ number_format($rapDetail->price / $rapDetail->quantity) }}</td>
                                    <td>Rp.{{ number_format($rapDetail->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
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
        $('div.overlay').hide();

        $('#boms-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false,
            'initComplete': function(){
            }
        });
    });
</script>
@endpush
