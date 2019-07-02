@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Work Order',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Work Order' => route('work_order.index'),
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
                <table id="wo-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="35%">Description</th>
                            <th width="20%">Project Number</th>
                            <th width="15%">Document Date</th>
                            <th width="15%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWOs as $modelWO)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelWO->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelWO->description}}">{{ $modelWO->description }}</td>
                                <td>{{ isset($modelWO->project) ? $modelWO->project->number : '-' }}</td>
                                <td class="tdEllipsis">{{ $modelWO->created_at->format('d-m-Y') }}</td>
                                @if($modelWO->status == 1)
                                    <td>OPEN</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWO->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWO->status == 3)
                                    <td>NEED REVISION</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWO->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.edit', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWO->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @else
                                    <td>RECEIVED</td>
                                    <td class="textCenter">
                                        @if($route == "/work_order")
                                            <a href="{{ route('work_order.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @else
                                            <a href="{{ route('work_order_repair.show', ['id'=>$modelWO->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
        var wo_table = $('#wo-table').DataTable({
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
            wo_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            wo_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            wo_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            wo_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            wo_table.draw();
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
</script>
@endpush
