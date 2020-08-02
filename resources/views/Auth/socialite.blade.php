@extends('layouts.app')
{!! config(['app.title' => __('Join us !')]) !!}

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="alert alert-primary text-xs-center" role="alert">
                <i class="fa fa-exclamation" aria-hidden="true"></i>
                @lang('There are some errors while registering your account. Please fix these errors before to continue.')
            </div>
            <h2 class="text-xs-center font-xeta mt-2">
                @lang('Register with :discord', ['discord' => title_case(session('socialite.driver'))])
            </h2>
        </div>
        <div class="col-md-4 offset-md-4">
            {!! Form::open(['route' => ['auth.driver.register.validate', 'driver' => session('socialite.driver')]]) !!}
                {!! Form::bsText('username', __('Username'), old('username'), [
                    'placeholder' => __('Your Username...'),
                    'required' => 'required',
                    'autofocus'
                ]) !!}

                {!! Form::bsEmail('email', __('E-Mail'), old('email'), [
                    'placeholder' => __('Your E-Mail...'),
                    'required' => 'required'
                ]) !!}

                <div class="form-group text-xs-center">
                    <div class="col-md-12 mb-1">
                        {!! Form::button('<i class="fa fa-user-plus" aria-hidden="true"></i> ' . __('Register'), ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                    <div class="col-md-12">
                        <a class="btn btn-link" href="{{ route('users.auth.login') }}">
                            @lang('Already an account?')
                        </a>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
