@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Show Snapshot » '.$snapshot->code,
        'items' => [
            'Dashboard' => route('index'),
            'Show Snapshot' => "",
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
                <div class="col-xs-12 col-sm-12 col-sm-4 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">PI Document Number</span>
                            <span class="info-box-number">{{ $snapshot->code }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="row m-t-10 ">
                        <div class="col-md-2 col-xs-4">
                            Status
                        </div>
                        <div class="col-md-3 col-xs-8">
                            : 
                            <b> 
                                @if($snapshot->status == 1)
                                    Open
                                @elseif($snapshot->status == 0)
                                    Closed
                                @elseif($snapshot->status == 2)
                                    Counted
                                @endif
                            </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-xs-4">
                            Created At
                        </div>
                        <div class="col-md-3 col-xs-8">
                            : 
                            <b>{{$snapshot->created_at->format('d-m-Y H:i:s')}}</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-10">
                <table class="table table-bordered showTable" id="stock-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Material Number</th>
                            <th style="width: 25%">Material Description</th>
                            <th style="width: 5%">Unit</th>
                            <th style="width: 35%">Storage Location</th>
                            <th style="width: 10%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach ($snapshot->snapshotDetails as $details)
                            <tr>
                                <td class="p-l-10">{{ $counter++ }}</td>
                                <td class="p-l-10">{{ $details->material->code }}</td>
                                <td class="p-l-10">{{ $details->material->description }}</td>
                                <td class="p-l-10">{{ $details->material->uom->unit }}</td>
                                <td class="p-l-10">{{ $details->storageLocation->name }}</td>
                                <td class="p-l-10">{{ number_format($details->quantity,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($route == "/physical_inventory")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('physical_inventory.print', ['id'=>$snapshot->id]) }}">DOWNLOAD</a>
                    @elseif($route == "/physical_inventory_repair")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('physical_inventory_repair.print', ['id'=>$snapshot->id]) }}">DOWNLOAD</a>
                    @endif
                </div>
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
        $('#stock-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });
</script>
@endpush
