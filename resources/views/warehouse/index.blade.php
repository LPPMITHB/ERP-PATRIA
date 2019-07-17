@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Warehouses',
        'items' => [
            'Dashboard' => route('index'),
            'View All Warehouses' => route('warehouse.index'),
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
                        <a href="{{ route('warehouse.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
                </div>
                <table id="warehouse-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Code</th>
                            <th style="width: 30%">Name</th>
                            <th style="width: 35%">Description</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($warehouses as $warehouse)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $warehouse->code }}</td>
                                <td>{{ $warehouse->name }}</td>
                                <td>{{ $warehouse->description }}</td>
                                @if ($warehouse->status == 1)
                                    <td>Active</td>
                                @elseif ($warehouse->status == 0)
                                    <td>Not Active</td>
                                @endif
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('warehouse.show', ['id'=>$warehouse->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('warehouse.edit',['id'=>$warehouse->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#warehouse-table').DataTable({
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
    });
</script>
@endpush
