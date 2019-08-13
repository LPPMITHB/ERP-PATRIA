@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Stock Taking » Adjustment History',
        'items' => [
            'Dashboard' => route('index'),
            'View Adjustment History' =>"",
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
                <table id="pi-table" class="table table-bordered tableFixed" style="border-collapse:collapse; table-layout:fixed;">
                    <thead>
                        <tr>
                            <th class="p-l-5" style="width: 5%">No</th>
                            <th style="width: 15%">Code</th>
                            <th style="width: 20%">Status</th>
                            <th style="width: 20%">Items</th>
                            <th style="width: 20%">Document Date</th>
                            <th style="width: 20%">Created By</th>
                            <th style="width: 20%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach ($snapshots as $snapshot)
                            <tr>
                                <td class="p-l-10">{{ $counter++ }}</td>
                                <td class="p-l-10">{{ $snapshot->code }}</td>
                                <td class="p-l-10">
                                    @if($snapshot->status == 1)
                                        OPEN
                                    @elseif($snapshot->status == 0)
                                        CLOSED
                                    @elseif($snapshot->status == 2)
                                        COUNTED
                                    @elseif($snapshot->status == 6)
                                        REJECTED
                                    @endif
                                </td>
                                <td class="p-l-10">{{ count($snapshot->snapshotDetails) }}</td>
                                <td class="p-l-10">{{ $snapshot->created_at->format('d-m-Y')}}</td>
                                <td class="p-l-10">{{ $snapshot->user->name }}</td>
                                <td class="p-l-0 textCenter">
                                    @if($menu == "building")
                                        <a class="btn btn-primary btn-xs" href="{{route('physical_inventory.showPI', ['id' => $snapshot->id])}}">
                                            SELECT
                                        </a>
                                    @else
                                        <a class="btn btn-primary btn-xs" href="{{route('physical_inventory_repair.showPI', ['id' => $snapshot->id])}}">
                                            SELECT
                                        </a>
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
        $('#sloc, #material').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '100%',
            enableFiltering: true,
            filterBehavior: 'text',
            enableCaseInsensitiveFiltering: true,
            maxHeight: 400,
        })

        var pi_table = $('#pi-table').DataTable({
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
            pi_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            pi_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            pi_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            pi_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            pi_table.draw();
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
