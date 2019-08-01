@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Goods Issue',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Goods Issue' => route('goods_issue.index'),
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
                <table class="table table-bordered tableFixed" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Number</th>
                            <th width="20%">Description</th>
                            <th width="15%">Project Name</th>
                            <th width="15%">Project Number</th>
                            <th width="10%">Document Date</th>
                            <th width="12%">Type</th>
                            <th width="8%">Status MR</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGIs as $modelGI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGI->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelGI->description}}">{{ $modelGI->description }}</td>
                                <td>{{ isset ($modelGI->materialRequisition) ? $modelGI->materialRequisition->project->name : '-'}}</td>
                                <td>{{ isset ($modelGI->materialRequisition) ? $modelGI->materialRequisition->project->number : '-'}}</td>
                                <td class="tdEllipsis">{{ $modelGI->created_at->format('d-m-Y') }}</td>
                                <td>
                                    @if( $modelGI->type == 1 )
                                        MR Transaction
                                    @elseif($modelGI->type == 2)
                                        Resource Transaction
                                    @elseif($modelGI->type == 3)
                                        PI Transaction
                                    @elseif($modelGI->type == 4)
                                        Goods Return
                                    @elseif($modelGI->type == 5)
                                        Material Write Off
                                    @endif
                                </td>
                                <td>
                                    @if($modelGI->status == 0)
                                        Issued
                                    @elseif($modelGI->status == 1)
                                        Open
                                    @elseif($modelGI->status == 2)
                                        Approved
                                    @elseif($modelGI->status == 3)
                                        Need Revision
                                    @elseif($modelGI->status == 4)
                                        Rejected
                                    @else
                                    @endif
                                </td>
                                <td align="center">
                                @if($modelGI->type == 2 && $modelGI->status == 1 || $modelGI->status == 3)
                                    @if($menu == "building")
                                        <a href="{{ route('goods_issue.showApprove', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @else
                                        <a href="{{ route('goods_issue_repair.showApprove', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                @else
                                    @if($menu == "building")
                                        <a href="{{ route('goods_issue.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @else
                                        <a href="{{ route('goods_issue_repair.show', ['id'=>$modelGI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
        var gi_table = $('#gi-table').DataTable({
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
            gi_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            gi_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            gi_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            gi_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            gi_table.draw();
        }

        // Date range filter
        minDateFilter = "";
        maxDateFilter = "";

        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                if (typeof aData._date == 'undefined') {
                    var temp = aData[5].split("-");
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
