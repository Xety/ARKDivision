@extends('layouts.app')
{!! config(['app.title'  => 'Créer votre nouveau mot de passe']) !!}

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                Réinittialiser le mot de passe
            </h2>

            {!! Form::open(['route' => 'users.auth.password.handlereset']) !!}
                {!! Form::hidden('token', $token) !!}

                {!! Form::bsEmail('email', 'E-Mail', old('email'), [
                    'placeholder' => 'Votre E-Mail...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsPassword('password', 'Mot de Passe', [
                    'placeholder' => 'Votre nouveau mot de passe...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsPassword('password_confirmation', 'Confirmation', [
                    'placeholder' => 'Confirmer votre mot de passe...',
                    'required' => 'required'
                ]) !!}

                <div class="form-group text-xs-center">
                    {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> ' . 'Réinittialiser', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
