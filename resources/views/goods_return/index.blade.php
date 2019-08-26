@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Goods Return',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Goods Returns' => route('goods_return.index'),
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
                <table class="table table-bordered tableFixed" id="goods-return-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="15%">GR Number</th>
                            <th width="15%">PO Number</th>
                            <th width="25%">Description</th>
                            <th width="15%">Document Date</th>
                            <th width="12%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGIs as $modelGI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGI->number }}</td>
                                <td>
                                    @if( $modelGI->goodsReceipt != null )
                                    <a href= "{{ route('goods_receipt.show', ['id'=>$modelGI->goodsReceipt]) }}" class="text-primary">{{$modelGI->goodsReceipt->number}}</a>
                                    @else
                                    <b>-</b>
                                    @endif
                                </td>
                                <td>
                                    @if( $modelGI->purchaseOrder != null )
                                    <a href= "{{ route('purchase_order.show', ['id'=>$modelGI->purchaseOrder]) }}"class="text-primary">{{$modelGI->purchaseOrder->number}}</a>
                                    @else
                                    <b>-</b>
                                    @endif
                                </td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelGI->description}}">{{ $modelGI->description }}</td>
                                <td class="tdEllipsis">{{ $modelGI->created_at->format('d-m-Y') }}</td>
                                @if($modelGI->status == 1)
                                <td>OPEN</td>
                                <td class="textCenter">
                                    @if($menu == "building")
                                        <a onClick="loading()" href="{{ route('goods_return.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @elseif($menu == "repair")
                                        <a onClick="loading()" href="{{ route('goods_return_repair.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                </td>
                                @elseif($modelGI->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 0 || $modelGI->status == 7)
                                    <td>ORDERED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 3)
                                    <td>NEEDS REVISION</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.edit', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelGI->status == 6)
                                    <td>CONSOLIDATED</td>
                                    <td class="textCenter">
                                        @if($menu == "building")
                                            <a onClick="loading()" href="{{ route('goods_return.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($menu == "repair")
                                            <a onClick="loading()" href="{{ route('goods_return_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
        var goods_return_table = $('#goods-return-table').DataTable({
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
            goods_return_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            goods_return_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            goods_return_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            goods_return_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            goods_return_table.draw();
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
