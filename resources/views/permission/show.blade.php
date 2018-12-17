@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Permission',
        'items' => [
            'Dashboard' => route('index'),
            'View All Permissions' => route('permission.index'),
            'Permission' => route('permission.show', ['id' => $permission->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
            <div class="box-title"></div>
            <div class="box-tools pull-right p-t-5">
                @can('edit-permission')
                    <a class="btn btn-primary btn-sm" href="{{ route('permission.edit',['id'=>$permission->id]) }}">EDIT</a>
                @endcan
            </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover showTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Attribute</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Name</td>
                            <td>{{ $permission->name }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Middleware</td>
                            <td>{{ $permission->middleware }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Menu</td>
                            <td>{{ $permission->menu->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    function deletePermission(){
        iziToast.show({
            timeout: 10000,
            color : 'red',
            displayMode: 'replace',
            icon: 'fa fa-warning',
            title: 'Warning !',
            message: 'Are you sure to delete permission ?',
            position: 'topRight',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
                ['<button>OK</button>', function (instance, toast) {
                    document.getElementById('delete-form-{{ $permission->id }}').submit();
                }, true], 
                ['<button>CANCEL</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                    }, toast, 'buttonName');
                }]
            ],
        });
    }
</script>
@endpush