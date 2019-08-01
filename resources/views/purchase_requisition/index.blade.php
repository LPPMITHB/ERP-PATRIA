@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Purchase Requisitions',
        'items' => [
            'Dashboard' => route('index'),
            'View All Purchase Requisitions' => '',
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
                <table id="pr-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th class="tdBreakWord" width="6%">No</th>
                            <th class="tdBreakWord" width="10%">Type</th>
                            <th class="tdBreakWord" width="10%">Number</th>
                            <th class="tdBreakWord" width="35%">Description</th>
                            <th class="tdBreakWord" width="13%">Document Date</th>
                            <th class="tdBreakWord" width="13%">Status</th>
                            <th class="tdBreakWord" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPRs as $modelPR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if($modelPR->type == 1)
                                    <td class="tdEllipsis">Material</td>
                                @elseif($modelPR->type == 2)
                                    <td class="tdEllipsis">Resource</td>
                                @elseif($modelPR->type == 3)
                                    <td class="tdEllipsis">Subcon</td>
                                @endif
                                <td class="tdEllipsis">{{ $modelPR->number }}</td>
                                <td class="tdEllipsis">{{ isset($modelPR->description) ? $modelPR->description : '-' }}</td>
                                <td class="tdEllipsis">{{ $modelPR->created_at->format('d-m-Y') }}</td>
                                @if($modelPR->status == 1)
                                    <td>OPEN</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 0 || $modelPR->status == 7)
                                    <td>ORDERED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 3)
                                    <td>NEEDS REVISION</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.edit', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 6)
                                    <td>CONSOLIDATED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPR->status == 8)
                                    <td>CANCELED</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_requisition")
                                            <a onClick="loading()" href="{{ route('purchase_requisition.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_requisition_repair")
                                            <a onClick="loading()" href="{{ route('purchase_requisition_repair.show', ['id'=>$modelPR->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @endif
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
        var pr_table = $('#pr-table').DataTable({
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
            pr_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            pr_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            pr_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            pr_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            pr_table.draw();
        }
        
        // Date range filter
        minDateFilter = "";
        maxDateFilter = "";

        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                if (typeof aData._date == 'undefined') {
                    var temp = aData[4].split("-");                    
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
