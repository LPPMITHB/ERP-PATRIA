@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Physical Inventory » Adjustment History',
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
                <table id="stock-table" class="table table-bordered tableFixed" style="border-collapse:collapse; table-layout:fixed;">
                    <thead>
                        <tr>
                            <th class="p-l-5" style="width: 5%">No</th>
                            <th style="width: 15%">Code</th>
                            <th style="width: 20%">Created At</th>
                            <th style="width: 20%">Created By</th>
                            <th style="width: 20%">Status</th>
                            <th style="width: 20%">Items</th>
                            <th style="width: 20%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach ($snapshots as $snapshot)
                            <tr>
                                <td class="p-l-10">{{ $counter++ }}</td>
                                <td class="p-l-10">{{ $snapshot->code }}</td>
                                <td class="p-l-10">{{ $snapshot->created_at->format('d-m-Y H:i:s')}}</td>
                                <td class="p-l-10">{{ $snapshot->user->name }}</td>
                                <td class="p-l-10">
                                    @if($snapshot->status == 1)
                                        OPEN
                                    @elseif($snapshot->status == 0)
                                        CLOSED
                                    @elseif($snapshot->status == 2)
                                        COUNTED
                                    @endif
                                </td>
                                <td class="p-l-10">{{ count($snapshot->snapshotDetails) }}</td>
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

        $('#stock-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
