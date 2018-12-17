@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Ships',
        'items' => [
            'Dashboard' => route('index'),
            'View All Ships' => '',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="box-tools pull-right">
                    <a href="{{ route('ship.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body p-b-0 p-t-15">
                <table class="table table-bordered tableFixed" id="ship-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 35%">Type</th>
                            <th style="width: 50%">Description</th>
                            {{-- <th style="width: 15%">Code</th> --}}
                            {{-- <th style="width: 35%">Name</th> --}}
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($ships as $ship)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$ship->type}}">{{ $ship->type }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$ship->description}}">{{ $ship->description }}</td>
                                {{-- <td>{{ $ship->code }}</td> --}}
                                {{-- <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$ship->name}}">{{ $ship->name }}</td> --}}
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('ship.show', ['id'=>$ship->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('ship.edit', ['id'=>$ship->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#ship-table').DataTable({
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
