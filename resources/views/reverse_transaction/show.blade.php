@extends('layouts.main')

@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'View Reverse Transaction » '.$modelRT->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Reverse Transactions' => route('reverse_transaction.index'),
                'View Reverse Transaction' => '',
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
        <div class="box box-blue">
                <div class="row">
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
                    <div class="col-sm-4 col-md-4">
                        <div class="box-header no-padding">
                            <div class="box-body">
                                <div class="col-md-7 col-xs-7 no-padding">Type</div>
                                <div class="col-md-5 col-xs-5 no-padding tdEllipsis">: <b> {{$type}} </b></div>

                                <div class="col-md-7 col-xs-7 no-padding">Old Reference Document Number</div>
                                <div class="col-md-5 col-xs-5 no-padding">: <b>
                                    <a class="text-primary" target="_blank" href="/{{$modelRT->url_type}}/{{$modelRT->oldReferenceDocument->id}}">{{$modelRT->oldReferenceDocument->number}}</a>
                                </b></div>
                                
                                @if ($modelRT->new_reference_document != null)
                                    <div class="col-md-7 col-xs-7 no-padding">New Reference Document Number</div>
                                    <div class="col-md-5 col-xs-5 no-padding">: <b>
                                        <a class="text-primary" target="_blank" href="/{{$modelRT->url_type}}/{{$modelRT->newReferenceDocument->id}}">{{$modelRT->newReferenceDocument->number}}</a>
                                    </b></div>
                                @endif

                                <div class="col-md-7 col-xs-7 no-padding">Status</div>
                                <div class="col-md-5 col-xs-5 no-padding tdEllipsis">: <b> {{$status}} </b></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                            <div class="box-header no-padding">
                                    <div class="box-body">
                                        <div class="col-md-4 col-xs-4 no-padding">Description</div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelRT->description}}">: <b> {{ $modelRT->description }} </b></div>
                                    </div>
                            </div>
                    </div>
                </div>
            <div class="box-body p-t-0">
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
                        <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                            {{-- @if($route == "/goods_receipt")
                                <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_receipt.print', ['id'=>$modelRT->id]) }}">DOWNLOAD</a>
                            @elseif($route == "/goods_receipt_repair")
                                <a class="col-xs-12 col-md-2 btn btn-primary pull-right" href="{{ route('goods_receipt_repair.print', ['id'=>$modelRT->id]) }}">DOWNLOAD</a>
                            @endif --}}
                        </div>
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
    </script>
@endpush
