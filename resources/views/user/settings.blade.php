@extends('layouts.app')
{!! config(['app.title' => 'Paramètres']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-md-9">
            <section class="mb-3">
                <h4 class="text-xs-center font-xeta">
                    Changer votre E-mail
                </h4>
                {!! Form::open(['route' => 'users.user.settings', 'method' => 'put']) !!}
                    {!! Form::hidden('type', 'email') !!}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">E-mail</label>
                                <p class="form-control-static">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::bsEmail('email', 'Nouveau E-mail', null, [
                                'placeholder' => 'Votre nouveau E-mail...',
                                'required' => 'required'
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group text-xs-center">
                        <div class="col-md-12">
                            {!! Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </section>

            <section class="mb-3">
                <h4 class="text-xs-center font-xeta">
                    Changer votre Mot de Passe
                </h4>
                {!! Form::open(['route' => 'users.user.settings', 'method' => 'put']) !!}
                    {!! Form::hidden('type', 'password') !!}
                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::bsPassword('oldpassword', 'Mot de Passe Actuel', [
                                'placeholder' => 'Votre Mot de Passe actuel...',
                                'required' => 'required'
                            ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::bsPassword('password', 'Nouveau Mot de Passe', [
                                'placeholder' => 'Votre nouveau Mot de Passe...',
                                'required' => 'required'
                            ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::bsPassword('password_confirmation', 'Confirmation', [
                                'placeholder' => 'Confirmer votre nouveau Mot de Passe...',
                                'required' => 'required'
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group text-xs-center">
                        <div class="col-md-12">
                            {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> Changer', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </section>

        </div>
    </div>
</div>
@endsection
