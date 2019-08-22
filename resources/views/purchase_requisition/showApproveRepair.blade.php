@extends('layouts.main')

@section('content-header')
@if($modelPR->type == 1)
    @php($type = 'Material')
@else
    @php($type = 'Resource')
@endif
@if($route == "/purchase_requisition")
    @breadcrumb(
        [
            'title' => 'Approve Purchase Requisition - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Requisition' => route('purchase_requisition.indexApprove'),
                'Approve Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_requisition_repair")
    @breadcrumb(
        [
            'title' => 'Approve Purchase Requisition - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Requisition' => route('purchase_requisition_repair.indexApprove'),
                'Approve Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        @if($route == "/purchase_requisition")
            <form id="approve-pr"class="form-horizontal" action="{{ route('purchase_requisition.approval') }}">
        @elseif($route == "/purchase_requisition_repair")
            <form id="approve-pr"class="form-horizontal" action="{{ route('purchase_requisition_repair.approval') }}">
        @endif
        @csrf
        </form>
        <div class="box box-blue">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">PR Number</span>
                            <span class="info-box-number">{{ $modelPR->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            Status
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b>{{ $status }}</b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Created By
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelPR->user->name }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Created At
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelPR->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Description
                        </div>
                        <div class="col-xs-8 col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelPR->description}}">
                            : <b> {{ $modelPR->description }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 m-t-10">
                    <div class="col-xs-12 no-padding"><b>Revision Description</b></div>
                    <div class="col-xs-12 no-padding">
                        <textarea class="form-control" rows="3" id="rev_desc"></textarea>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                @if($modelPR->type != 3)
                    <table class="table table-bordered showTable tableFixed tableNonPagingVue">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                @if($modelPR->type == 1)
                                    <th width="20%">Material Number</th>
                                    <th width="25%">Material Description</th>
                                @else
                                    <th width="20%">Resource Number</th>
                                    <th width="25%">Resource Description</th>
                                @endif
                                <th width="8%">Request Quantity</th>
                                <th width="7%">Unit</th>
                                <th width="14%">Project Number</th>
                                <th width="13%">Required Date</th>
                                <th width="10%">Allocation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelPR->PurchaseRequisitionDetails as $PRD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if($modelPR->type == 1)
                                        <td class="tdEllipsis">{{ $PRD->material->code }}</td>
                                        <td class="tdEllipsis">{{ $PRD->material->description }}</td>
                                    @else
                                        <td class="tdEllipsis">{{ $PRD->resource->code }}</td>
                                        <td class="tdEllipsis">{{ $PRD->resource->name }}</td>
                                    @endif
                                    <td>{{ number_format((float)$PRD->quantity,2) }}</td>
                                    @if($modelPR->type == 1)
                                        <td>{{ $PRD->material->uom->unit}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td class="tdEllipsis">{{ isset($PRD->project) ? $PRD->project->number : '-' }}</td>
                                    <td>{{ isset($PRD->required_date) ? date('d-m-Y', strtotime($PRD->required_date)) : '-' }}</td>
                                    <td>{{ isset($PRD->alocation) ? $PRD->alocation : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif($modelPR->type == 3)
                        <table class="table table-bordered showTable tableFixed tableNonPagingVue">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Project Number</th>
                                    <th width="25%">WBS</th>
                                    <th width="40%">Job Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelPR->PurchaseRequisitionDetails as $PRD)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $PRD->project->number}}</td>
                                        <td>{{ $PRD->wbs->number}} - {{ $PRD->wbs->description}}</td>
                                        <td>{{ $PRD->job_order}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @verbatim
                <div id="approval">
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10" v-if="modelPR.status == 1 || modelPR.status == 4">
                        <button type="button" class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" @click.prevent="submitForm('approve')">APPROVE</button>
                        <button type="button" class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" @click.prevent="submitForm('need-revision')">REVISE</button>
                        <button type="button" class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" @click.prevent="submitForm('reject')">REJECT</button>
                    </div>
                </div>
                @endverbatim
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
    const form = document.querySelector('form#approve-pr');

    $(document).ready(function(){
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == "Cost per pcs" || title == "Sub Total Cost" || title == "Qty" || title == "Unit"){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            });
        });

        var table = $('.tableNonPagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : false,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
        });

        $('div.overlay').hide();
    });

    var data = {
        modelPR : @json($modelPR),
        dataSubmit : {
            pr_id : @json($modelPR->id),
            status : "",
            desc : @json($modelPR->revision_description)
        }
    }

    var vm = new Vue({
        el : '#approval',
        data : data,
        methods : {
            submitForm(status){
                $('div.overlay').show();
                this.dataSubmit.desc = document.getElementById('rev_desc').value;
                this.dataSubmit.status = status;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.dataSubmit));
                form.appendChild(struturesElem);
                form.submit();
            },
        },
        created: function() {
            document.getElementById('rev_desc').value = this.dataSubmit.desc;

        },
    })
</script>
@endpush
