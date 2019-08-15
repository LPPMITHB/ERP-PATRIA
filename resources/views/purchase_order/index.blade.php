@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Purchase Order',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Purchase Order' => '',
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
                <table id="po-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="40%">Description</th>
                            <th width="15%">Status</th>
                            <th width="15%">Document Date</th>
                            <th width="15%">Created By</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPOs as $modelPO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelPO->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelPO->description}}">{{ $modelPO->description }}</td>
                                @if($modelPO->status == 1)
                                    <td>OPEN</td>
                                    <td>{{ $modelPO->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $modelPO->user->name }}</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a onClick="loading()" href="{{ route('purchase_order.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 2)
                                    <td>APPROVED</td>
                                    <td>{{ $modelPO->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $modelPO->user->name }}</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a onClick="loading()" href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 3)
                                    <td>NEED REVISION</td>
                                    <td>{{ $modelPO->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $modelPO->user->name }}</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a onClick="loading()" href="{{ route('purchase_order.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 4)
                                    <td>REVISED</td>
                                    <td>{{ $modelPO->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $modelPO->user->name }}</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a onClick="loading()" href="{{ route('purchase_order.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.edit', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 5)
                                    <td>REJECTED</td>
                                    <td>{{ $modelPO->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $modelPO->user->name }}</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a onClick="loading()" href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 8)
                                    <td>CANCELED</td>
                                    <td>{{ $modelPO->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $modelPO->user->name }}</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a onClick="loading()" href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelPO->status == 0)
                                    <td>RECEIVED</td>
                                    <td>{{ $modelPO->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $modelPO->user->name }}</td>
                                    <td class="textCenter">
                                        @if($route == "/purchase_order")
                                            <a onClick="loading()" href="{{ route('purchase_order.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/purchase_order_repair")
                                            <a onClick="loading()" href="{{ route('purchase_order_repair.show', ['id'=>$modelPO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
