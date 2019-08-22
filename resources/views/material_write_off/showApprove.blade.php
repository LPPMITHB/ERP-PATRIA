@extends('layouts.main')

@section('content-header')
@if($route == "/material_write_off")
    @breadcrumb(
        [
            'title' => 'View Material Write Off » '.$modelMWO->number,
            'items' => [
                'Dashboard' => route('index'),
                'Select Material Write Off' => route('material_write_off.indexApprove'),
                'View Material Write Off' => route('material_write_off.show',$modelMWO->id),
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/material_write_off_repair")
    @breadcrumb(
        [
            'title' => 'View Material Write Off » '.$modelMWO->number,
            'items' => [
                'Dashboard' => route('index'),
                'Select Material Write Off' => route('material_write_off_repair.indexApprove'),
                'View Material Write Off' => route('material_write_off_repair.show',$modelMWO->id),
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        @if($route == "/material_write_off")
            <form id="approve-mwo"class="form-horizontal" action="{{ route('material_write_off.approval') }}">
        @elseif($route == "/material_write_off_repair")
            <form id="approve-mwo"class="form-horizontal" action="{{ route('material_write_off_repair.approval') }}">
        @endif
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">MWO Number</span>
                            <span class="info-box-number">{{ $modelMWO->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="box-header p-t-0 p-b-0">
                    <div class="col-sm-4 col-md-4 m-t-10">
                        {{-- <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Ship Name
                            </div>
                            <div class="col-md-8">
                                : <b> {{ isset($modelMWO->materialRequisition) ? $modelMWO->materialRequisition->project->name : '-'}} </b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                MR Code
                            </div>
                            <div class="col-md-8">
                                : <b> {{ isset($modelMWO->materialRequisition) ? $modelMWO->materialRequisition->number : '-' }} </b>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Type
                            </div>
                            <div class="col-md-8">
                                @if($modelMWO->type == 1)
                                : <b> MR Transaction </b>
                                @elseif($modelMWO->type == 2)
                                : <b>  Resource Transaction </b>
                                @elseif($modelMWO->type == 3)
                                : <b>  PI Transaction </b>
                                @elseif($modelMWO->type == 4)
                                : <b>  Goods Return </b>
                                @else
                                : <b> Material Write Off </b>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Status
                            </div>
                            <div class="col-md-8">
                                @if($modelMWO->status == 0)
                                : <b> ISSUED </b>
                                @elseif($modelMWO->status == 1)
                                : <b>  OPEN </b>
                                @elseif($modelMWO->status == 2)
                                : <b>  APPROVED </b>
                                @elseif($modelMWO->status == 3)
                                : <b>  NEED REVISION </b>
                                @elseif($modelMWO->status == 4)
                                : <b> REVISED </b>
                                @elseif($modelMWO->status == 5)
                                : <b> REJECTED </b>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Created At
                            </div>
                            <div class="col-md-8">
                                : <b> {{$modelMWO->created_at->format('d-m-Y H:i:s')}} </b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                    Description
                                </div>
                            <div class="col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelMWO->description}}">
                                    : <b> {{ $modelMWO->description }} </b>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered showTable tableFixed m-t-20" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">Warehouse</th>
                            <th width="12%">S.Loc</th>
                            <th width="15%">Material Number</th>
                            <th width="15%">Material Description</th>
                            @if($modelMWO->status == 1)
                                <th width="8%">Available</th>
                            @endif
                            <th width="8%">Write-Off Quantity</th>
                            <th width="5%">Unit</th>
                            <th width=10%>Amount / Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelMWOD as $MWO)
                        <tr>
                            <td class="tdEllipsis">{{ $loop->iteration }}</td>
                            <td class="tdEllipsis">{{ $MWO->storageLocation->name }} </td>
                            <td class="tdEllipsis">{{ $MWO->storageLocation->warehouse->name }} </td>
                            <td class="tdEllipsis">{{ $MWO->material->code }}</td>
                            <td class="tdEllipsis">{{ $MWO->material->description }}</td>
                            @if($modelMWO->status == 1)
                                <td class="tdEllipsis">
                                    {{ number_format($MWO->storageLocation->storageLocationDetails->where('material_id',$MWO->material_id)->sum('quantity'),2) }}
                                </td>
                            @endif
                            <td class="tdEllipsis">{{ number_format($MWO->quantity,2) }}</td>
                            <td class="tdEllipsis">{{ $MWO->material->uom->unit }}</td>
                            <td class="tdEllipsis">Rp.{{ number_format($MWO->amount) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @verbatim
                <div id="approval">
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10" v-if="modelMWO.status == 1 || modelMWO.status == 4">
                        <a class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" @click.prevent="submitForm('approve')">APPROVE</a>
                        <a class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" @click.prevent="submitForm('need-revision')">REVISE</a>
                        <a class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" @click.prevent="submitForm('reject')">REJECT</a>
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
    const form = document.querySelector('form#approve-mwo');

    $(document).ready(function(){
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == "Cost per pcs" || title == "Sub Total Cost" || title == "Quantity"){
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
        modelMWO : @json($modelMWO),
        dataSubmit : {
            mwo_id : @json($modelMWO->id),
            status : "",
        }
    }

    var vm = new Vue({
        el : '#approval',
        data : data,
        methods : {
            submitForm(status){
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
        },
    })
</script>
@endpush
