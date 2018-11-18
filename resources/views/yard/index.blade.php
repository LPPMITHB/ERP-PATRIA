@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Yards',
        'items' => [
            'Dashboard' => route('index'),
            'View All Yards' => route('yard.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header m-b-10">
                    <div class="box-tools pull-right p-t-5">
                        <a href="{{ route('yard.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="yard-table">
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
                        @foreach($yards as $yard)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $yard->code }}</td>
                                <td>{{ $yard->name }}</td>
                                <td>{{ $yard->area }}</td>
                                <td>{{ $yard->description }}</td>
                                @if ($yard->status == 2)
                                    <td>Not Available</td>
                                @elseif ($yard->status == 1)
                                    <td>Available</td>
                                @else
                                    <td>Not Active</td>
                                @endif
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('yard.show', ['id'=>$yard->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('yard.edit',['id'=>$yard->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#yard-table').DataTable({
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
