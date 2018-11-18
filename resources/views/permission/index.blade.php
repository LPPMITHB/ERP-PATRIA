@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Permissions',
        'items' => [
            'Dashboard' => route('index'),
            'View All Permissions' => route('permission.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header m-b-15">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('permission.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="permissions-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 35%">Name</th>
                            <th style="width: 35%">Middleware</th>
                            <th style="width: 15%">Menu</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->middleware }}</td>
                                <td>{{ $permission->menu->name }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('permission.show', ['id'=>$permission->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('permission.edit', ['id'=>$permission->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#permissions-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
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
