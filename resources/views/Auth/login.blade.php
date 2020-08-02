@extends('layouts.app')
{!! config(['app.title' => __('Login into your account')]) !!}

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                @lang('Login')
            </h2>
            {!! Form::open(['route' => 'users.auth.login']) !!}
                {!! Form::bsEmail('email', __('E-Mail'), old('email'), [
                    'placeholder' => __('Your E-Mail...'),
                    'required' => 'required',
                    'autofocus'
                ]) !!}

                {!! Form::bsPassword('password', __('Password'), [
                    'placeholder' => __('Your Password...'),
                    'required' => 'required'
                ]) !!}

                {!! Form::bsCheckbox("remember", null, old('remember'), __('Remember Me')) !!}

                <div class="form-group text-xs-center">
                    {!! Form::button('<i class="fa fa-sign-in" aria-hidden="true"></i> ' . __('Login'), ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}

            <div class="text-xs-center">
                {!! link_to(route('auth.driver', ['driver' => 'discord', 'type' => 'login']), __('Login with Discord') . ' <i class="fa fa-github"></i>', ['class' => 'btn btn-outline-secondary'], true, false) !!}
            </div>
        </div>
        <div class="col-md-12 text-xs-center">
            <a class="btn btn-link" href="{{ route('users.auth.password.request') }}">
                @lang('Forgot Your Password?')
            </a>
            <a class="btn btn-link" href="{{ route('users.auth.register') }}">
                @lang('Not registered yet?')
            </a>
        </div>
    </div>
</div>
@endsection
