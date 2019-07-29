@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Reverse Transaction » Select Reverse Transaction',
        'items' => [
            'Dashboard' => route('index'),
            'View All Reverse Transaction' => route('reverse_transaction.index'),
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
                <table class="table table-bordered tableFixed" id="rt-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Type</th>
                            <th width="15%">Number</th>
                            <th width="35%">Description</th>
                            <th width="20%">Old Reference Document</th>
                            <th width="15%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelDatas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$data->type_string}}</td>
                                <td>{{ $data->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip"  title="{{$data->description}}">{{ $data->description }}</td>
                                <td>{{ $data->referenceDocument->number }}</td>
                                <td>{{ $data->status_string }}</td>
                                <td class="textCenter">
                                    @if($menu == "building")
                                        <a href="{{ route('reverse_transaction.show', ['id'=>$data->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @else
                                        <a href="{{ route('reverse_transaction_repair.show', ['id'=>$data->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                    @if($data->status == 1 || $data->status == 3 || $data->status == 4)
                                        @if($menu == "building")
                                            <a href="{{ route('reverse_transaction.edit', ['id'=>$data->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        @else
                                            <a href="{{ route('reverse_transaction_repair.edit', ['id'=>$data->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        @endif
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
        var rt_table = $('#rt-table').DataTable({
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
            rt_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            rt_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            rt_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            rt_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            rt_table.draw();
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
