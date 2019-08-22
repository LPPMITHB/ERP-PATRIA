@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Purchase Order » Select Purchase Requisition',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Purchase Requisition' => '',
        ]
    ]
)
@endbreadcrumb
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
                <table class="table table-bordered tableFixed" id="po-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Type</th>
                            <th width="10%">Number</th>
                            <th width="10%">PR Date</th>
                            <th width="25%">Description</th>
                            <th width="13%">Status</th>
                            <th width="17%">Created By</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPRs as $modelPR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if($modelPR->type == 1)
                                    <td>Material</td>
                                @elseif($modelPR->type == 2)
                                    <td>Resource</td>
                                @elseif($modelPR->type == 3)
                                    <td>Subcon</td>
                                @endif
                                <td>{{ $modelPR->number }}</td>
                                <td>{{ $modelPR->created_at->format('d-m-Y') }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelPR->description}}">{{ isset($modelPR->description) ? $modelPR->description : '-'}}</td>
                                @if($modelPR->status == 0)
                                    <td>ORDERED</td>
                                @elseif($modelPR->status == 1)
                                    <td>OPEN</td>
                                @elseif($modelPR->status == 2)
                                    <td>APPROVED</td>
                                @elseif($modelPR->status == 3)
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="NEEDS REVISION">NEEDS REVISION</td>
                                @elseif($modelPR->status == 4)
                                    <td>REVISED</td>
                                @elseif($modelPR->status == 5)
                                    <td>REJECTED</td>
                                @elseif($modelPR->status == 6)
                                    <td>CONSOLIDATED</td>
                                @elseif($modelPR->status == 7)
                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="ORDERED PARTIALLY">ORDERED PARTIALLY</td>
                                @endif
                                <td>{{ $modelPR->user->name }}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    @if($route == "/purchase_order")
                                        <a onClick="loading()" href="{{ route('purchase_order.selectPRD', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @elseif($route == "/purchase_order_repair")
                                        <a onClick="loading()" href="{{ route('purchase_order_repair.selectPRD', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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
        var po_table = $('#po-table').DataTable({
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
            po_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            po_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            po_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            po_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            po_table.draw();
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

    function loading(){
        $('div.overlay').show();
    }
</script>
@endpush
