@extends('layouts.app')
{!! config(['app.title' => 'Connectez-vous à votre compte']) !!}

@section('content')
<div class="container mt-6">
    <div class="row">
        @if (config('settings.user.login.enabled'))
            <div class="col-lg-4 offset-lg-4">
                <h1 class="text-center p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                    Connexion
                </h1>
                {!! Form::open(['route' => 'users.auth.login']) !!}
                    {!! Form::bsEmail('email', 'E-Mail', old('email'), [
                        'placeholder' => 'Votre E-Mail...',
                        'required' => 'required',
                        'autofocus'
                    ]) !!}

                    {!! Form::bsPassword('password', __('Mot de Passe'), [
                        'placeholder' => __('Votre mot de passe...'),
                        'required' => 'required'
                    ]) !!}

                    {!! Form::bsCheckbox("remember", null, old('remember'), __('Se souvenir de moi')) !!}

                    <div class="form-group text-center mb-2">
                        {!! Form::button('<i class="fa fa-sign-in" aria-hidden="true"></i> ' . 'Connexion', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                {!! Form::close() !!}

                <div class="text-center">
                    {!! link_to(route('auth.driver.redirect', ['driver' => 'discord']), __('<i class="fab fa-discord"></i> Connexion avec Discord'), ['class' => 'btn btn-discord'], true, false) !!}
                </div>
            </div>
            <div class="col-lg-12 text-center">
                <a class="btn btn-link" href="{{ route('users.auth.password.request') }}">
                    Mot de passe oublié?
                </a>
                <a class="btn btn-link" href="{{ route('users.auth.register') }}">
                    Pas encore inscrit?
                </a>
            </div>
        @else
            <div class="col-lg-4 offset-lg-4 text-center">
                <h2 class="mt-2">
                    Whoops
                </h2>
            </div>
            <div class="col-lg-8  offset-lg-2 mt-6">
                <div role="alert" class="alert alert-danger">
                    <i aria-hidden="true" class="fa fa-exclamation fa-2x pb-1"></i><br>
                    Le système de connexion est désactivé pour le moment, veuillez réessayer plus tard.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
