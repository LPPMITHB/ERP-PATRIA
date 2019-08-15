@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approve Material Requisition',
        'items' => [
            'Dashboard' => route('index'),
            'Select Material Requisition' => route('material_requisition.indexApprove'),
            'Approve Material Requisition' => route('material_requisition.show',$modelMR->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        @if($route == "/material_requisition")
            <form id="approve-mr"class="form-horizontal" action="{{ route('material_requisition.approval') }}">
        @elseif($route == "/material_requisition_repair")
            <form id="approve-mr"class="form-horizontal" action="{{ route('material_requisition_repair.approval') }}">
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
                            <span class="info-box-text">MR Number</span>
                            <span class="info-box-number">{{ $modelMR->number }}</span>
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
                            : <b> {{ $modelMR->user->name }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Created At
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelMR->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Last Update At
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelMR->updated_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Description
                        </div>
                        <div class="col-xs-8 col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelMR->description}}">
                            : <b> {{ $modelMR->description }} </b>
                        </div>
                        @if($modelMR->delivery_date != null)
                        <div class="col-xs-5 col-md-4">
                            Delivery Date
                        </div>
                        <div class="col-xs-5 col-md-8">
                            : <b> {{ date('d-m-Y', strtotime($modelMR->delivery_date)) }} </b>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            Project Number
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b>{{ $modelMR->project->number }}</b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Project Name
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b>{{ $modelMR->project->name }}</b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Customer
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b>{{ $modelMR->project->customer->name }}</b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Ship Type
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b>{{ $modelMR->project->ship->type }}</b>
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
                <table class="table table-bordered showTable" id="mr-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Material Desc.</th>
                            <th width="14%">Quantity</th>
                            <th width="30%">WBS Name</th>
                            <th width="14%">Planned Qty</th>
                            <th width="14%">Issued Qty</th>
                            <th width="6%">Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelMRD as $MRD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $MRD->material->description }}</td>
                                <td>{{ number_format($MRD->quantity,2) }}</td>
                                <td>{{ $MRD->wbs != null ? $MRD->wbs->number : "-" }}</td>
                                <td>{{ $MRD->planned_quantity }}</td>
                                <td>{{ $MRD->issued }}</td>
                                <td>{{ $MRD->material->uom->unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @verbatim
                <div id="approval">
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10" v-if="modelMR.status == 1 || modelMR.status == 4">
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
    const form = document.querySelector('form#approve-mr');
    $(document).ready(function(){
        $('#mr-table').DataTable({
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
        // $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        // $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'No' || title == "Cost per pcs" || title == "Sub Total Cost" || title == "Quantity" || title == "Planned Qty" || title == "Issued Qty" || title == "Unit"){
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }else{
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( table.column(i).search() !== this.value ) {
        //             table
        //             .column(i)
        //             .search( this.value )
        //             .draw();
        //         }
        //     });
        // });

        // var table = $('.tableNonPagingVue').DataTable( {
        //     orderCellsTop   : true,
        //     paging          : false,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : false,
        // });

        // $('div.overlay').hide();
    });

    var data = {
        modelMR : @json($modelMR),
        dataSubmit : {
            mr_id : @json($modelMR->id),
            status : "",
            desc : @json($modelMR->revision_description)
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
