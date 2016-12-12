@extends('layouts.web')

@section('content')
    <div class="container py-2">
        <div class="row">
            <div class="col-xs-12 col-lg-8 offset-lg-2">
                <form action="{{ url('/setup') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="card">
                        <h3 class="card-header py-1">
                            About Institute
                        </h3>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group @if($errors->has('name')) has-danger @endif">
                                        <label for="formName">Name of the Intitute</label>
                                        <input type="text" class="form-control form-control-lg" id="formName" name="name"
                                               value="{{ $school->name ?? old('name') }}" placeholder="Name of the Intitute">
                                        @if($errors->has('name'))
                                            <div class="form-control-feedback">{{ $errors->first('name') }}</div>
                                        @endif
                                        <small class="form-text text-muted">Registered name of the institute.</small>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group @if($errors->has('university')) has-danger @endif">
                                        <label for="formUniversity">University</label>
                                        <input type="text" class="form-control form-control-lg" id="formUniversity" name="university"
                                               value="{{ $school->university ?? old('university') }}" placeholder="University">
                                        @if($errors->has('university'))
                                            <div class="form-control-feedback">{{ $errors->first('university') }}</div>
                                        @endif
                                        <small class="form-text text-muted">Name of the university.</small>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group @if($errors->has('institute_type')) has-danger @endif">
                                        <label for="formInstituteType">Institute Type</label>
                                        <select class="form-control form-control-lg custom-select" id="formInstituteType" name="institute_type">
                                               <option value="" disabled
                                                    @if(!array_key_exists($school->institute_type ?? old('institute_type'), $instituteTypes))
                                                        selected @endif >Institute Type</option>
                                               @foreach ($instituteTypes as $key => $value)
                                                    <option value="{{ $key }}"
                                                        @if($key === ($school->institute_type ?? old('institute_type'))) selected @endif>
                                                            {{ $value }}
                                                    </option>
                                               @endforeach
                                        </select>
                                        @if($errors->has('institute_type'))
                                            <div class="form-control-feedback">{{ $errors->first('institute_type') }}</div>
                                        @endif
                                        <small class="form-text text-muted">Type of the institute.</small>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group @if($errors->has('email')) has-danger @endif">
                                        <label for="formEmail">Email Address</label>
                                        <input type="email" class="form-control form-control-lg" id="formEmail" name="email"
                                               value="{{ $school->email ?? old('email') }}" placeholder="Email Address">
                                        @if($errors->has('email'))
                                            <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                                        @endif
                                        <small class="form-text text-muted">Institute's official email address.</small>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group @if($errors->has('logo')) has-danger @endif">
                                        <label for="formLogo">Insitute Logo</label>
                                        <input type="file" id="formLogo" name="logo">
                                        @if($errors->has('logo'))
                                            <div class="form-control-feedback">{{ $errors->first('logo') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-xs-right">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
