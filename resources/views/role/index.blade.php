@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Roles',
        'items' => [
            'Dashboard' => route('index'),
            'View All Roles' => route('role.index'),
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
                    <a href="{{ route('role.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="permissions-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Role</th>
                            <th width="55%">Description</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('role.show', ['id'=>$role->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('role.edit', ['id'=>$role->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
