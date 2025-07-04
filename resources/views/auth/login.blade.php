@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card mx-2 shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Welcome Back! Please Log In</h2>


                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input id="email" name="email" type="text"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required
                                autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}"
                                value="{{ old('email') }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input id="password" name="password" type="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required
                                placeholder="{{ trans('global.login_password') }}">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>



                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary px-4">{{ trans('global.login') }}</button>
                            <a class="btn btn-link px-0" href="{{ url('/register') }}">
                                Get yourself registered
                            </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection