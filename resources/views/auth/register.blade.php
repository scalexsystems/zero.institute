@extends('layouts.web')

@section('content')
    <div id="app" class="container p-y-1 v-full flex flex-content-md-middle flex-items-md-center">
        <div class="wrapper-auth">
            <div class="card card-auth">
                <div class="card-block card-block-auth">
                    <h3 class="p-b-1">{{ trans('app::register.heading') }}</h3>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-institute-selector">
                            <div is="select-institute" :large="true"
                                 placeholder="{{ trans('app::register.p.institute') }}"></div>
                            @if ($errors->has('institute'))
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-has-addon">
                                <i class="fa fa-fw fa-envelope input-group-addon-icon input-group-addon-icon-auth"></i>
                                <input id="email" type="email" class="form-control form-control-auth" name="email"
                                       value="{{ old('email') }}"
                                       placeholder="{{ trans('app::register.p.email') }}" required>
                            </div>

                            @if ($errors->has('email'))
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">

                            <div class="input-has-addon">
                                <i class="fa fa-fw fa-key input-group-addon-icon input-group-addon-icon-auth"></i>
                                <input id="password" type="password" class="form-control form-control-auth"
                                       name="password"
                                       placeholder="{{ trans('app::register.p.password') }}" required>
                            </div>

                            @if ($errors->has('password'))
                                <small class="text-danger">{{ $errors->first('password') }}</small>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">

                            <div class="input-has-addon">
                                <i class="fa fa-fw fa-key input-group-addon-icon input-group-addon-icon-auth"></i>
                                <input id="password" type="password" class="form-control form-control-auth"
                                       name="password"
                                       placeholder="{{ trans('app::register.p.password_confirmation') }}" required>
                            </div>

                            @if ($errors->has('password_confirmation'))
                                <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block text-uppercase btn-auth">
                                {{ trans('app::register.btn.register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-xs-center">
                <a href="{{ url('/login') }}" class="text-muted">
                    <small>{{ trans('app::register.btn.login') }}</small>
                </a>
            </div>
        </div>
    </div>
@endsection
