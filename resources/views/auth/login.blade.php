@extends('layouts.web')

@section('content')
    <div class="container py-3 v-full d-flex flex-row justify-content-center align-items-center">
        <div class="wrapper-auth">
            <div class="card card-auth">
                <div class="card-block card-block-auth">
                    <h3 class="pb-3">{{ trans('app::login.heading') }}</h3>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

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

                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">{{ trans('app::login.l.remember') }}</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block text-uppercase btn-auth">
                                {{ trans('app::login.btn.login') }}
                            </button>
                        </div>

                        <div class="text-center">
                            <a class="text-muted" href="{{ url('/password/reset') }}">
                                {{ trans('app::login.btn.forgot') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ url('/privacy') }}" class="text-muted">
                    <small>Privacy Policy</small>
                </a>
            </div>
        </div>
    </div>
@endsection
