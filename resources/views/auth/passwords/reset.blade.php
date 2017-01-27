@extends('layouts.web')

@section('content')
<div class="container">
    <div class="container p-y-1 v-full flex flex-content-md-middle flex-items-md-center">
        <div class="wrapper-auth">
            <div class="card card-auth">
                <div class="card-block card-block-auth">
                    <h3 class="pb-1">Secure Your Account</h3>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        @if (session('message'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-has-addon">
                                <i class="fa fa-fw fa-envelope input-group-addon-icon input-group-addon-icon-auth"></i>
                                <input id="email" type="email" class="form-control form-control-auth" name="email" value="{{ old('email') }}"
                                       placeholder="{{ trans('app::login.p.email') }}" required autofocus>
                            </div>

                            @if ($errors->has('email'))
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-has-addon">
                                <i class="fa fa-fw fa-key input-group-addon-icon input-group-addon-icon-auth"></i>
                                <input id="password" type="password" class="form-control form-control-auth" name="password"
                                       placeholder="{{ trans('app::login.p.password') }}" required>
                            </div>

                            @if ($errors->has('password'))
                                <small class="text-danger">{{ $errors->first('password') }}</small>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <div class="input-has-addon">
                                <i class="fa fa-fw fa-key input-group-addon-icon input-group-addon-icon-auth"></i>
                                <input id="password-confirm" type="password" class="form-control form-control-auth" name="password_confirmation"
                                       placeholder="Confirm Password" required>
                            </div>

                            @if ($errors->has('password_confirmation'))
                                <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary btn-block text-uppercase btn-auth">
                            Set Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
