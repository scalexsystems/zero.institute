@extends('layouts.web')

@section('content')
    <div class="v-full flex flex-content-md-middle flex-items-md-center">
        <div id="app" class="container py-1">
            <div class="row">
                <div class="col-xs-12 col-lg-6 text-xs-center text-lg-left">
                    <div class="mb-1">
                        <img src="{{ attach_url($school->logo) ?? asset('img/placeholder.jpg') }}" width="160" height="160">
                    </div>

                    <h3>{{ $school->name }}</h3>
                </div>
                <div class="col-xs-12 col-lg-5">
                    <div class="card card-block card-block-auth">
                        <h3 class="pb-1">{{ trans('app::register.heading') }}</h3>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            @if(!$isTokenValid)
                                <div class="alert alert-danger">
                                    Your account token is not valid. Contact your institute system administrator.
                                </div>
                            @endif

                            @if(session('message'))
                                <div class="alert alert-warning">
                                    {{ session('message') }}
                                </div>
                            @endif

                            {!! csrf_field() !!}
                            <input type="hidden" name="institute" value="{{ old('institute', $institute) }}">
                            <input type="hidden" name="token" value="{{ old('token', $token) }}">

                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <div class="input-has-addon">
                                    <i class="fa fa-fw fa-user input-group-addon-icon input-group-addon-icon-auth"></i>
                                    <input id="name" type="text" class="form-control form-control-auth" name="name"
                                           value="{{ old('name') }}"
                                           placeholder="{{ trans('app::register.p.name') }}" required>
                                </div>

                                @if ($errors->has('name'))
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
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
                                    <input id="password_confirmation" type="password" class="form-control form-control-auth"
                                           name="password_confirmation"
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
                    <div class="text-xs-center">
                        <a href="{{ url('/login') }}" class="text-muted">
                            <small>{{ trans('app::register.btn.login') }}</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
