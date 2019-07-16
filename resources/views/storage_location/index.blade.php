@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Storage Locations',
        'items' => [
            'Dashboard' => route('index'),
            'View All Storage Locations' => route('storage_location.index'),
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
                        <a href="{{ route('storage_location.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
                </div>
                <table id="sloc-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Code</th>
                            <th style="width: 30%">Name</th>
                            <th style="width: 10%">Area (m<sup>2</sup>)</th>
                            <th style="width: 25%">Description</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($storage_locations as $storage_location)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $storage_location->code }}</td>
                                <td>{{ $storage_location->name }}</td>
                                <td>{{ $storage_location->area }}</td>
                                <td>{{ $storage_location->description }}</td>
                                @if ($storage_location->status == 1)
                                    <td>Active</td>
                                @elseif ($storage_location->status == 0)
                                    <td>Not Active</td>
                                @endif
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('storage_location.show', ['id'=>$storage_location->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('storage_location.edit',['id'=>$storage_location->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#sloc-table').DataTable({
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
