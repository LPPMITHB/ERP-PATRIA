@extends('layouts.main')
@section('content-header')

@breadcrumb(
    [
        'title' => 'Edit User',
        'items' => [
            'Dashboard' => route('index'),
            'View All Users' => route('user.index'),
            $user->name => route('user.show',$user->id),
            'Edit' => route('user.edit',$user->id),
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

                <form class="form-horizontal" method="POST" action="{{ route('user.update',['id'=>$user->id]) }}">
                <input type="hidden" name="_method" value="PATCH">
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">Username</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" name="username" required disabled value="{{ $user->username }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
            
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" required value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone_number" class="col-sm-2 control-label">Phone Number</label>
            
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{ $user->phone_number }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role" class="col-sm-2 control-label">Role</label>
            
                            <div class="col-sm-10">
                                @can('change-role')
                                <select name="role" id="role" required>
                                @else
                                <select name="role" id="role" required disabled>
                                @endcan
                                    <option></option>
                                    @foreach($roles as $name => $id)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="branch" class="col-sm-2 control-label">Branch</label>

                            <div class="col-sm-10">
                                @can('change-branch')
                                <select name="branch" id="branch" required>
                                @else
                                <select name="branch" id="branch" required disabled>
                                @endcan
                                    <option></option>
                                    @foreach($branches as $name => $id)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status</label>
            
                            <div class="col-sm-10">
                                <div class="checkbox icheck">
                                    <label>
                                        <input type="hidden" name="status" value="0">
                                        @can('change-status')
                                            <input type="checkbox" id="status" name="status" value="1" {{ $user->status == 0 ? '' : 'checked' }}>
                                        @else
                                            <input disabled type="checkbox" id="status" name="status" value="1" {{ $user->status == 0 ? '' : 'checked' }}>
                                        @endcan
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">SAVE</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
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
        $('#role').val("{{ $user->role_id }}");
        $('#branch').val("{{ $user->branch_id }}");
        $('.alert').addClass('animated bounce');
        $('#role,#branch').selectize();
        $('div.overlay').remove();
    });
</script>
@endpush
