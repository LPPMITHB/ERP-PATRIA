@extends('layouts.app')

@section('content')
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="login-box-body">
      <div class="row">
          <div class="text-center p-b-20">
            <img src="{{ asset('images/logo-PMP.png') }}" alt="" srcset="">
          </div>
      </div>
  
      <form action="{{ route('login') }}" aria-label="{{ __('Login') }}" method="POST">
        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
        @csrf
        <div class="form-group has-feedback">
          <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus  placeholder="Username">
              @if ($errors->has('username'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('username') }}</strong>
                  </span>
              @endif
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row p-b-20">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
  
      <a href="{{ route('password.request') }}">Forgot Your Password?</a><br>
  
    </div>
    <!-- /.login-box-body -->
  </div>


@endsection
