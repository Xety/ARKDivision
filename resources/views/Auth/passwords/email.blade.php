@extends('layouts.app')
{!! config(['app.title' => 'Réinitialiser votre mot de passe']) !!}

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                Réinitialiser votre Mot de Passe
            </h2>

            {!! Form::open(['route' => 'users.auth.password.email']) !!}
                {!! Form::bsEmail('email', 'E-Mail', old('email'), [
                    'placeholder' => 'Votre E-Mail...',
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

                <div class="form-group text-xs-center">
                    {!! Form::button('<i class="fa fa-paper-plane-o" aria-hidden="true"></i> ' . 'Envoyer le lien', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
