@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Users',
        'subtitle' => 'Index',
        'items' => [
            'Dashboard' => route('index'),
            'View All Users' => route('user.index'),
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
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="users-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 35%">Name</th>
                            <th style="width: 35%">Email</th>
                            <th style="width: 15%">Role</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('user.show', ['id'=>$user->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('user.edit', ['id'=>$user->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#users-table').DataTable({
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
