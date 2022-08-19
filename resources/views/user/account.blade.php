@extends('layouts.app')
{!! config(['app.title' => __('Mon compte')]) !!}

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-lg-9">

            <div class="row mb-5">
                <div class="col-12">
                    <h1 class="p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                        Mon compte
                    </h1>

                    {!! Form::model($user, ['route' => 'users.account.update', 'files'=>'true', 'method' => 'put']) !!}
                        <div class="row mb-5">
                            <div class="col-lg-4 text-center">
                                <img src="{{ $user->avatar_medium }}" class="img-thumbnail mb-2 d-block m-auto" alt="Avatar de l'utilisateur">

                                <label class="btn btn-outline-primary">
                                    {!! Form::file('avatar') !!}
                                    <i class="fa fa-refresh"></i> Change
                                </label>

                                @if ($errors->has('avatar'))
                                    <div class="form-control-feedback">
                                        {{ $errors->first('avatar') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-8">
                                {!! Form::bsText(
                                    'first_name',
                                    'Prénom',
                                    null,
                                    ['placeholder' => __('Votre Prénom...')]
                                ) !!}

                                {!! Form::bsText(
                                    'last_name',
                                    'Nom',
                                    null,
                                    ['placeholder' => __('Votre Nom...')]
                                ) !!}
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-lg-12">
                                {!! Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> ' . 'Enregistrer', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <h1 class="p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                        Changer mon E-mail
                    </h1>

                    {!! Form::open(['route' => 'users.user.settings', 'method' => 'put']) !!}
                        {!! Form::hidden('type', 'email') !!}

                        <div class="row mb-5">
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="email" readonly class="form-control-plaintext" id="floatingActuelEmail" placeholder="name@example.com" value="{{ Auth::user()->email }}">
                                    <label for="floatingActuelEmail">E-mail</label>
                                  </div>
                            </div>

                            <div class="col-lg-6">
                                {!! Form::bsEmail('email', 'Nouveau E-mail', null, [
                                    'placeholder' => 'Votre nouveau E-mail...',
                                    'required' => 'required'
                                ]) !!}
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-lg-12">
                                {!! Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> ' . 'Enregistrer', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    @if (!is_null(Auth::user()->password))
                        <h1 class="p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                            Changer mon Mot de Passe
                        </h1>

                        {!! Form::open(['route' => 'users.user.settings', 'method' => 'put']) !!}
                            {!! Form::hidden('type', 'password') !!}
                            <div class="row mb-5">
                                <div class="col-lg-4">
                                    {!! Form::bsPassword('oldpassword', 'Mot de Passe Actuel', [
                                        'placeholder' => 'Votre Mot de Passe actuel...',
                                        'required' => 'required'
                                    ]) !!}
                                </div>
                                <div class="col-lg-4">
                                    {!! Form::bsPassword('password', 'Nouveau Mot de Passe', [
                                        'placeholder' => 'Votre nouveau Mot de Passe...',
                                        'required' => 'required'
                                    ]) !!}
                                </div>
                                <div class="col-lg-4">
                                    {!! Form::bsPassword('password_confirmation', 'Confirmation', [
                                        'placeholder' => 'Confirmer votre nouveau Mot de Passe...',
                                        'required' => 'required'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col-12">
                                    {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> Changer', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    @else
                        <h1 class="p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                            Définir un Mot de Passe
                        </h1>

                        <div class="alert alert-dark text-xs-center" role="alert">
                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                            Avec une inscription via Discord, vous avez la possibilité de définir un mot de passe pour <b>vous connecter également avec votre email et mot de passe</b> en plus de la connexion via Discord  !
                        </div>
                        {!! Form::open(['route' => 'users.user.settings', 'method' => 'put']) !!}
                            {!! Form::hidden('type', 'newpassword') !!}
                            <div class="row mb-5">
                                <div class="col-lg-6">
                                    {!! Form::bsPassword('password', 'Nouveau Mot de Passe', [
                                        'placeholder' => 'Votre nouveau Mot de Passe...',
                                        'required' => 'required'
                                    ]) !!}
                                </div>
                                <div class="col-lg-6">
                                    {!! Form::bsPassword('password_confirmation', 'Confirmation', [
                                        'placeholder' => 'Confirmer votre nouveau Mot de Passe...',
                                        'required' => 'required'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col-12">
                                    {!! Form::button('<i class="fa fa-lock" aria-hidden="true"></i> Créer', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
