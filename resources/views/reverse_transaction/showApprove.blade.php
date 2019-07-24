@extends('layouts.main')

@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'Approve Reverse Transaction » '.$modelRT->number,
            'items' => [
                'Dashboard' => route('index'),
                'Select Reverse Transactions' => route('reverse_transaction.indexApprove'),
                'Approve Reverse Transaction' => '',
            ]
        ]
    )
    @endbreadcrumb
{{-- @elseif($menu == "/goods_receipt_repair")
    @breadcrumb(
        [
            'title' => 'View Reverse Transaction » '.$reverseTransaction->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Reverse Transactions' => route('goods_receipt_repair.index'),
                'View Reverse Transaction' => '',
            ]
        ]
    )
    @endbreadcrumb --}}
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12">
        @if($menu == "building")
            <form id="approve-rt"class="form-horizontal" action="{{ route('reverse_transaction.approval') }}">
        @elseif($menu == "repair")
            {{-- <form id="approve-rt"class="form-horizontal" action="{{ route('reverse_transaction_repair.approval') }}"> --}}
        @endif
        @csrf
        </form>
        <div class="box box-blue">
            <div class="box-header no-padding">
                <div class="row m-r-10">
                    <div class="col-sm-4 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Reverse Transaction Number</span>
                                <span class="info-box-number">{{ $modelRT->number }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-4 m-t-10">
                        <div class="row">
                            <div class="col-xs-4 col-md-4">
                                Type
                            </div>
                            <div class="col-xs-8 col-md-8">
                                : <b>{{ $type }}</b>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                Created By
                            </div>
                            <div class="col-xs-8 col-md-8">
                                : <b> {{ $modelRT->user->name }} </b>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                Created At
                            </div>
                            <div class="col-xs-8 col-md-8">
                                : <b> {{ $modelRT->created_at->format('d-m-Y H:i:s') }} </b>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                Description
                            </div>
                            <div class="col-xs-8 col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelRT->description}}">
                                : <b> {{ $modelRT->description }} </b>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-4 m-t-10">
                        <div class="row">
                            <div class="col-xs-2 col-md-2 p-l-0">
                                Status
                            </div>
                            <div class="col-md-10 col-xs-10">
                                : <b>{{ $status }}</b>
                            </div>

                            <div class="col-xs-12 no-padding"><b>Revision Description</b></div>
                            <div class="col-xs-12 no-padding">
                                <textarea class="form-control" rows="3" id="rev_desc"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <div class="row">
                        <table id="data-table" class="table table-bordered showTable tableFixed">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Material Number</th>
                                    <th width="40%">Material Description</th>
                                    <th width="5%">Unit</th>
                                    <th width="10%">Old Qty</th>
                                    <th width="10%">New Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modelRT->reverseTransactionDetails as $RTD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $RTD->material->code }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$RTD->material->description}}">{{ $RTD->material->description }}</td>
                                    <td>{{ $RTD->material->uom->unit }}</td>
                                    <td>{{ number_format($RTD->old_quantity,2) }}</td>
                                    <td>{{ number_format($RTD->new_quantity,2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @verbatim
                        <div id="approval">
                            <div class="col-md-12 m-b-10 p-r-0 p-t-10" v-if="modelRT.status == 1 || modelRT.status == 4">
                                <button type="button" class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" @click.prevent="submitForm('approve')">APPROVE</button>
                                <button type="button" class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" @click.prevent="submitForm('need-revision')">REVISE</button>
                                <button type="button" class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" @click.prevent="submitForm('reject')">REJECT</button>
                            </div>
                        </div>
                        @endverbatim
                    </div>
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
    const form = document.querySelector('form#approve-rt');

    $(document).ready(function(){
        var data_table = $('#data-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });

    var data = {
        modelRT : @json($modelRT),
        dataSubmit : {
            rt_id : @json($modelRT->id),
            status : "",
            desc : @json($modelRT->revision_description)
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
