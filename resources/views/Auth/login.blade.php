@extends('layouts.app')
{!! config(['app.title' => 'Connectez-vous à votre compte']) !!}

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                Connexion
            </h2>
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

                <div class="form-group text-xs-center">
                    {!! Form::button('<i class="fa fa-sign-in" aria-hidden="true"></i> ' . 'Connexion', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}

            <div class="text-xs-center">
                {!! link_to(route('auth.driver.redirect', ['driver' => 'discord']), __('Connexion avec Discord') . ' <i class="fa fa-github"></i>', ['class' => 'btn btn-discord'], true, false) !!}
            </div>
        </div>
        <div class="col-md-12 text-xs-center">
            <a class="btn btn-link" href="{{ route('users.auth.password.request') }}">
                Mot de passe oublié?
            </a>
            <a class="btn btn-link" href="{{ route('users.auth.register') }}">
                Pas encore inscrit?
            </a>
        </div>
    </div>
</div>
@endsection
