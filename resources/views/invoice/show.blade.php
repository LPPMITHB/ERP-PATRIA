@extends('layouts.main')

@section('content-header')
@if($route == "/invoice")
    @breadcrumb(
        [
            'title' => 'View Invoice',
            'items' => [
                'Dashboard' => route('index'),
                'View All Invoices' => route('invoice.index'),
                'View Invoice' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/invoice_repair")
    @breadcrumb(
        [
            'title' => 'View Invoice',
            'items' => [
                'Dashboard' => route('index'),
                'View All Invoices' => route('invoice_repair.index'),
                'View Invoice' => '',
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
                            <span class="info-box-text">Invoice Number</span>
                            <span class="info-box-number">{{ $modelInvoice->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 m-t-10 m-l-25 no-padding">
                    <div class="row">
                        <div class="col-md-5 col-xs-5" >
                            Project Number
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelInvoice->project->number }}">
                        @if($route == "/invoice")
                            : <b><a href="{{ route('project.show',['id'=>$modelInvoice->project_id]) }}" target="_blank"> {{ $modelInvoice->project->number }} </b></a>
                        @elseif($route == "/invoice_repair")
                            : <b><a href="{{ route('project_repair.show',['id'=>$modelInvoice->project_id]) }}" target="_blank"> {{ $modelInvoice->project->number }} </b></a>
                        @endif
                        </div>

                        <div class="col-md-5 col-xs-5" >
                            SO Number
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelInvoice->salesOrder->number }}">
                        @if($route == "/invoice")
                            : <b><a href="{{ route('sales_order.show',['id'=>$modelInvoice->salesOrder->id]) }}" target="_blank"> {{ $modelInvoice->salesOrder->number }} </b></a>
                        @elseif($route == "/invoice_repair")
                            : <b><a href="{{ route('sales_order_repair.show',['id'=>$modelInvoice->salesOrder->id]) }}" target="_blank"> {{ $modelInvoice->salesOrder->number }} </b></a>
                        @endif
                        </div>

                        <div class="col-md-5 col-xs-5" >
                            Customer Name
                        </div>
                        <div class="col-md-7 col-xs-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelInvoice->project->customer->code }} - {{ $modelInvoice->project->customer->name }}">
                            : <b> {{ $modelInvoice->project->customer->code }} - {{ $modelInvoice->project->customer->name }} </b>
                        </div>

                        <div class="col-md-5 col-xs-5">
                            Status
                        </div>
                        <div class="col-md-7 col-xs-7">
                            : <b>{{$statusInvoice}}</b>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 m-t-10 m-l-25 no-padding">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Created By
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelInvoice->user->name }} </b>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            Created At
                        </div>
                        <div class="col-md-8 col-xs-8">
                            : <b> {{ $modelInvoice->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered tableFixed" id="qt-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Project Progress</th>
                            <th width="25%">Payment Percentage</th>
                            <th width="25%">Payment Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="tdEllipsis p-t-13 p-b-13">{{ $modelInvoice->top_project_progress }} %</td>
                            <td class="tdEllipsis p-t-13 p-b-13">{{ $modelInvoice->top_payment_percentage }} %</td>
                            <td class="tdEllipsis p-t-13 p-b-13">Rp.{{ number_format($modelInvoice->payment_value) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
        $("textarea").keydown(false);
    });
</script>
@endpush
