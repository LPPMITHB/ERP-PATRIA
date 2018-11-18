@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Menus',
        'subtitle' => 'Index',
        'items' => [
            'Dashboard' => route('index'),
            'View All Menus' => route('menus.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-body">
                    <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm pull-right">CREATE</a>
                <table class="table table-bordered table-hover" id="menus-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 35%">Name</th>
                            <th style="width: 35%">URL</th>
                            <th style="width: 15%">Icon</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->route_name }}</td>
                                <td><i class="fa {{ $menu->icon }}"></i></td>
                                <td class="p-l-0 p-r-0" align="center"><a href="{{ route('menus.show', ['id'=>$menu->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                <a href="{{ route('menus.edit',['id'=>$menu->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#menus-table').DataTable({
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
