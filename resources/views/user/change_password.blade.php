@extends('layouts.main')
@section('content-header')

@breadcrumb(
    [
        'title' => 'Change Password User',
        'subtitle' => 'Change Password',
        'items' => [
            'Dashboard' => route('index'),
            'User' => route('user.index'),
            $user->name => route('user.show',$user->id),
            'Change Password' => route('user.change_password',$user->id),
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
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('user.update_password',['id'=>$user->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="current_password" class="col-sm-2 control-label">Current Password</label>
            
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="current_password" name="current_password" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="col-sm-2 control-label">New Password</label>
            
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation" class="col-sm-2 control-label">Retype Password</label>
            
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
