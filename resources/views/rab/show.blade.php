@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View RAP » '.$modelRab->project->name,
        'items' => [
            'Dashboard' => route('index'),
            'View RAP' => route('rab.show',$modelRab->id),
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
                            <span class="info-box-text">RAP Number</span>
                            <span class="info-box-number">{{ $modelRab->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Project Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelRab->project->code }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Project Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelRab->project->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Customer Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelRab->project->customer->name }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Ship Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelRab->project->ship->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ship Type
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelRab->project->ship->type }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Total Cost
                        </div>
                        <div class="col-md-8">
                            : <b>Rp.{{ number_format($modelRab->total_price) }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered showTable" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">BOM Code</th>
                            <th width="30%">Material Name</th>
                            <th width="10%">Quantity</th>
                            <th width="15%">Cost per pcs</th>
                            <th width="20%">Sub Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelRab->RabDetails as $rabDetail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rabDetail->bom->code }}</td>
                                <td>{{ $rabDetail->material->name }}</td>
                                <td>{{ $rabDetail->quantity }}</td>
                                <td>Rp.{{ number_format($rabDetail->material->cost_standard_price) }}</td>
                                <td>Rp.{{ number_format($rabDetail->price) }}</td>
                            </tr>
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
        $('#boms-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
