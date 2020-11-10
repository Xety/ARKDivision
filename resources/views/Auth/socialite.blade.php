@extends('layouts.app')
{!! config(['app.title' => 'Rejoignez-nous !']) !!}

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="alert alert-primary text-xs-center" role="alert">
                <i class="fa fa-exclamation" aria-hidden="true"></i>
                Il y a des erreurs lors de l'enregistrement de votre compte. Veuillez corriger ces erreurs avant de continuer.
            </div>
            <h2 class="text-xs-center font-xeta mt-2">
                @lang('Register with :driver', ['driver' => Str::title($driver)])
            </h2>
        </div>
        <div class="col-md-4 offset-md-4">
            {!! Form::open(['route' => ['auth.driver.register.validate', 'driver' => $driver]]) !!}
                {!! Form::bsText('username', 'Pseudo', old('username'), [
                    'placeholder' => 'Votre Pseudo...',
                    'required' => 'required',
                    'autofocus'
                ]) !!}

                {!! Form::bsEmail('email', __('E-Mail'), old('email'), [
                    'placeholder' => 'Votre E-Mail...',
                    'required' => 'required'
                ]) !!}

                <div class="form-group text-xs-center">
                    <div class="col-md-12 mb-1">
                        {!! Form::button('<i class="fa fa-user-plus" aria-hidden="true"></i> ' . 'S\'inscrire', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
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
