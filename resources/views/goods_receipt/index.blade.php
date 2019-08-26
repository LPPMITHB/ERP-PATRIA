@extends('layouts.main')

@section('content-header')
@if($route == "/goods_receipt")
    @breadcrumb(
        [
            'title' => 'View All Goods Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipt' => route('goods_receipt.index'),
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_receipt_repair")
    @breadcrumb(
        [
            'title' => 'View All Goods Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipt' => route('goods_receipt_repair.index'),
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="col-sm-6 p-l-0">
                    <div class="box-tools pull-left">
                        <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter datepicker" type="text" id="datepicker_from" />
                        <span id="date-label-to" class="date-label">To: </span><input class="date_range_filter datepicker" type="text" id="datepicker_to" />
                        <button id="btn-reset" class="btn btn-primary btn-sm">RESET</button>
                    </div>
                </div>
                <table id="gr-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="12%">GR Code</th>
                            <th width="25%">Description</th>
                            <th width="20%">Vendor Name</th>
                            <th width="10%">PO Number</th>
                            <th width="15%">PO Description</th>
                            <th width="10%">Document Date</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGRs as $GR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $GR->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$GR->description}}">{{ $GR->description }}</td>
                                @if($GR->purchaseOrder != null)
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $GR->purchaseOrder->vendor->name }}">{{ $GR->purchaseOrder->vendor->name }}</td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $GR->purchaseOrder->number }}"><a href= "{{ route('purchase_order.show', ['id'=>$GR->purchaseOrder->id]) }}" class="text-primary">{{ $GR->purchaseOrder->number }}</a></td>
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$GR->purchaseOrder->description}}">{{ $GR->purchaseOrder->description }}</td>
                                @else
                                    <td class="tdEllipsis">-</td>
                                    <td class="tdEllipsis">-</td>
                                    <td class="tdEllipsis">-</td>
                                @endif
                                <td class="tdEllipsis">{{ $GR->created_at->format('d-m-Y') }}</td>
                                <td class="textCenter p-l-0 p-r-0">
                                    @if($route == "/goods_receipt")
                                        <a href="{{ route('goods_receipt.show', ['id'=>$GR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @elseif($route == "/goods_receipt_repair")
                                        <a href="{{ route('goods_receipt_repair.show', ['id'=>$GR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                </td>
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
        var gr_table = $('#gr-table').DataTable({
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

        $("#datepicker_from").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            gr_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            gr_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            gr_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            gr_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            gr_table.draw();
        }

        // Date range filter
        minDateFilter = "";
        maxDateFilter = "";

        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                if (typeof aData._date == 'undefined') {
                    var temp = aData[3].split("-");
                    aData._date = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                }

                if (minDateFilter && !isNaN(minDateFilter)) {
                    if (aData._date < minDateFilter) {
                        return false;
                    }
                }

                if (maxDateFilter && !isNaN(maxDateFilter)) {
                    if (aData._date > maxDateFilter) {
                        return false;
                    }
                }

                return true;
            }
        );
    });
</script>
@endpush
