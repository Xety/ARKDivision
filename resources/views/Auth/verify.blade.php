@extends('layouts.app')
{!! config(['app.title' => 'Vérifiez votre E-mail !']) !!}

@section('content')
<div class="container mt-6">
    <div class="row">
        @if (config('settings.user.email.verification.enabled'))
            <div class="col-md-8 offset-md-2">
                <h2 class="text-xs-center font-xeta mt-2">
                    Vérifiez votre E-mail !
                </h2>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        <i aria-hidden="true" class="fa fa-check"></i>
                        Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                    </div>
                @endif
                <div role="alert" class="alert alert-danger text-xs-center mt-6 mb-2">
                    <i aria-hidden="true" class="fa fa-exclamation fa-2x pb-1"></i>
                    <p>
                        Avant de continuer, veuillez vérifier votre e-mail et cliquer sur le lien de vérification. (Pensez également à regarder dans les spams de votre boite mail.)
                    </p>
                    <p>
                        Si vous n'avez pas reçu l'e-mail, cliquez sur le bouton "Renvoyer" pour en demander un nouveau.
                    </p>

                </div>

                {!! Form::open(['route' => 'users.auth.verification.resend']) !!}
                    {!! Form::hidden('hash', $hash); !!}
                    <div class="form-group text-xs-center">
                        {!! Form::button('<i class="far fa-paper-plane"></i> ' . 'Renvoyer', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        @else
            <div class="col-md-4 offset-md-4">
                <h2 class="text-xs-center mt-2">
                    Whoops
                </h2>
            </div>
            <div class="col-md-8  offset-md-2 text-xs-center mt-6">
                <div role="alert" class="alert alert-danger">
                    <i aria-hidden="true" class="fa fa-exclamation fa-2x pb-1"></i><br>
                    Le système de vérification des e-mails est désactivé pour le moment, veuillez réessayer plus tard.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('users.auth.verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
