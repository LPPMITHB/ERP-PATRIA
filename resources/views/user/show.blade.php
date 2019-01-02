@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'User Profile',
        'items' => [
            'Dashboard' => route('index'),
            'View All Users' => route('user.index'),
            'User' => '',
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
                <div class="box-tools pull-right p-t-10 m-r-15">
                    @can('edit-password')
                    <a class="btn btn-primary btn-sm" href="{{ route('user.change_password',['id'=>$user->id]) }}">CHANGE PASSWORD</a>
                    @endcan
                    
                    @can('edit-user')
                        <a class="btn btn-primary btn-sm" href="{{ route('user.edit',['id'=>$user->id]) }}">EDIT</a>
                    @endcan
                </div>
            </div>
            <div class="box-body">
                <div class="box box-widget widget-user col-sm-12">
                    <div class="widget-user-header bg-aqua-active m-b-75" style="background-color: #3c8dbc !important;">
                        <h3 class="widget-user-username">{{ $user->name }}</h3>
                        <h5 class="widget-user-desc">{{ $user->branch->name }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="https://cdn4.iconfinder.com/data/icons/green-shopper/1068/user.png" alt="User Avatar">
                    </div>
                    <div class="box-footer no-padding">    
                        <ul class="nav nav-stacked">
                            <li><a>Username <span class="pull-right">{{ $user->username }}</span></a></li>
                            <li><a>Email <span class="pull-right">{{ $user->email }}</span></a></li>
                            <li><a>Address <span class="pull-right">{{ $user->address }}</span></a></li>
                            <li><a>Phone Number <span class="pull-right">{{ $user->phone_number }}</span></a></li>
                            <li><a>Business Unit <span class="pull-right">{{ $stringBusinessUnit }}</span></a></li>
                            <li><a>Status <span class="pull-right"><i class="fa {{ $user->status == 1 ? 'fa-check' : 'fa-times' }}"></i></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function deleteUser(){
        iziToast.show({
            overlay : true,
            close : false,
            zindex : 100000,
            timeout: 7000,
            theme : 'dark',
            displayMode: 'replace',
            icon: 'fa fa-warning',
            title: 'Warning !',
            message: 'Are you sure to delete this user ?',
            position: 'center',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
                ['<button>OK</button>', function (instance, toast) {
                    document.getElementById('delete-form-{{ $user->id }}').submit();
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