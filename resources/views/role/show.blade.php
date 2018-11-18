@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Role',
        'items' => [
            'Dashboard' => route('index'),
            'View All Roles' => route('role.index'),
            'Role' => route('role.show', ['id' => $role->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#info" data-toggle="tab">Role Info</a></li>
                    <li><a href="#permissions" data-toggle="tab">Permissions</a></li>
                    <div class="box-tools pull-right p-t-5 p-r-10">
                    
                        <!-- @can('destroy-role')
                            <a data-toggle="tooltip" title="Delete Role" data-placement="top"  class="btn btn-danger btn-sm" href="#" onclick="deleteRole()">DELETE</a>
                        @endcan

                        <form id="delete-form-{{ $role->id }}" action="{{ route('role.destroy', ['id' => $role->id]) }}" method="POST" style="display: none;">
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                        </form> -->
                    
                    
                        @can('edit-role')
                            <a data-toggle="tooltip" title="Edit Role" data-placement="top" href="{{ route('role.edit',['id'=>$role->id]) }}"  class="btn btn-primary btn-sm">EDIT</a>
                        @endcan
                    
                    </div>
                </ul>
                @verbatim
                <div class="tab-content" id="show-role">
                    <div class="tab-pane active" id="info">
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
                                    <td>{{ role.name }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Description</td>
                                    <td>{{ role.description }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="permissions">
                        <table id="permissions-table" class="table table-bordered table-hover showTable">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="45%">Permission Name</th>
                                    <th width="45%">Menu Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(permission,index) in permissions">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ permission.name }}</td>
                                    <td>{{ permission.menu.name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endverbatim
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
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
                $('div.overlay').hide();
            }
        });
    });

    var data = {
        role : @json($jsonRole),
        permissions : @json($permissions)
    }

    var vm = new Vue({
        el : '#show-role',
        data : data
    });

    function deleteRole(){
        iziToast.show({
            timeout: 10000,
            color : 'red',
            displayMode: 'replace',
            icon: 'fa fa-warning',
            title: 'Warning !',
            message: 'Are you sure to delete role ?',
            position: 'topRight',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
                ['<button>OK</button>', function (instance, toast) {
                    document.getElementById('delete-form-{{ $role->id }}').submit();
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