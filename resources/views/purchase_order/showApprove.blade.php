@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Purchase Order » '.$modelPO->project->name,
        'items' => [
            'Dashboard' => route('index'),
            'View Purchase Order' => route('purchase_order.show',$modelPO->id),
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
                            <span class="info-box-text">PO Number</span>
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
                            Ship Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPO->project->ship->type }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ship Type
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPO->project->ship->type }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Ref Number
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelPO->purchaseRequisition->number }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Total Price
                        </div>
                        <div class="col-md-8">
                            : <b> {{ number_format($modelPO->total_price) }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-5">
                            Customer Name
                        </div>
                        <div class="col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelPO->project->customer->name}}">
                            : <b> {{ $modelPO->project->customer->name }} </b>
                        </div>
                        <div class="col-md-5">
                            Vendor Name
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelPO->vendor->code }} - {{ $modelPO->vendor->name }} </b>
                        </div>
                        <div class="col-md-5">
                            Status
                        </div>
                        @if($modelPO->status == 1)
                            <div class="col-md-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelPO->status == 2)
                            <div class="col-md-7">
                                : <b>CANCELED</b>
                            </div>
                        @else
                            <div class="col-md-7">
                                : <b>ORDERED</b>
                            </div>
                        @endif
                        <div class="col-md-5">
                            Created By
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelPO->user->name }} </b>
                        </div>
                        <div class="col-md-5">
                            Created At
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelPO->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered showTable" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Material Name</th>
                            <th width="20%">Quantity</th>
                            <th width="20%">Price / pcs</th>
                            <th width="20%">Sub Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPO->purchaseOrderDetails as $POD)
                            @if($POD->quantity > 0)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $POD->material->code }} - {{ $POD->material->name }}</td>
                                    <td>{{ number_format($POD->quantity) }}</td>
                                    <td>{{ number_format($POD->total_price / $POD->quantity) }}</td>
                                    <td>{{ number_format($POD->total_price) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12 p-t-10 p-b-10 p-r-0">
                    <button class="btn btn-primary pull-right m-l-10" >APPROVE</button>
                    <button class="btn btn-danger pull-right p-r-10" >NOT APPROVE</button>
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
        $('div.overlay').remove();
    });
</script>
@endpush
