@extends('layouts.app')
{!! config(['app.title' => 'Rejoignez-nous !']) !!}

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                Inscription
            </h2>
            {!! Form::open(['route' => 'users.auth.register']) !!}
                {!! Form::bsText('username', 'Pseudo', old('username'), [
                    'placeholder' => 'Votre Pseudo...',
                    'required' => 'required',
                    'autofocus'
                ]) !!}

                {!! Form::bsEmail('email', 'E-Mail', old('email'), [
                    'placeholder' => 'Votre E-Mail...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsPassword('password', 'Mot de Passe', [
                    'placeholder' => 'Votre Mot de Passe...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsPassword('password_confirmation', 'Confirmation', [
                    'placeholder' => 'Confirmation de votre Mot de Passe...',
                    'required' => 'required'
                ]) !!}

                <div class="form-group {{ $errors->has('g-recaptcha-response') ? 'has-danger' : '' }}">
                    {!! NoCaptcha::display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <div class="form-control-feedback">
                            {{ $errors->first('g-recaptcha-response') }}
                        </div>
                    @endif
                </div>

                {!! Form::bsCheckbox("terms", null, false, "En cliquant sur \"S'inscrire\", vous acceptez d'avoir lu et compris les <a href=\"#\">Conditions d'Utilisation.</a>") !!}

                <div class="form-group text-xs-center">
                    <div class="col-md-12 mb-1">
                        {!! Form::button('<i class="fa fa-user-plus" aria-hidden="true"></i> S\'inscrire', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                    <div class="col-md-12">
                        <a class="btn btn-link" href="{{ route('users.auth.login') }}">
                            Déjà un compte?
                        </a>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
