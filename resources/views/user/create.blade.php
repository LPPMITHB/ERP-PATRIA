@extends('layouts.main')
@section('content-header')

@breadcrumb(
    [
        'title' => 'Create User',
        'items' => [
            'Dashboard' => route('index'),
            'View All Users' => route('user.index'),
            'Create User' => route('user.create'),
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

                <form class="form-horizontal" method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">Username</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" name="username" required autofocus value="{{ old('username') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
            
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone_number" class="col-sm-2 control-label">Phone Number</label>
            
                            <div class="col-sm-10">
                                <input type="text" onkeypress="validate(event)" minlength="10" maxlength="12" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role" class="col-sm-2 control-label">Role</label>
            
                            <div class="col-sm-10">
                                <select name="role" id="role" required>
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
                                <select name="branch" id="branch" required>
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
                                        <input type="checkbox" id="status" name="status" value="1" {{ $user->status == 0 ? '' : 'checked' }}>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">CREATE</button>
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
        $('#role').val("{{ old('role') }}");
        $('#branch').val("{{ old('branch') }}");
        $('.alert').addClass('animated bounce');
        $('#role,#branch').selectize();
        $('div.overlay').remove();
    });

    function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>
@endpush
