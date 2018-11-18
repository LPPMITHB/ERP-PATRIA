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
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                    @csrf

                    <div class="form-group row">

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-mail Address" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
