@extends('layouts.app')
{!! config(['app.title' => 'Social']) !!}

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
            <section class="mb-3 bg-discord text-white">
                @if (is_null($user->discord_id))
                    <h4 class="text-xs-center font-xeta">
                        <i class="fab fa-discord"></i> Discord
                    </h4>
                    <i class="fas fa-exclamation-triangle"></i> Vous n'avez pas encore lier votre compte Discord à votre compte Division.
                    <div class="text-xs-center mt-1">
                        {!! link_to(
                            route('users.social.discord'),
                            'Lier mon Discord',
                            ['class' => 'btn btn-outline-discord-inverse']
                        ) !!}
                    </div>
                @else
                <div>
                    <i class="fab fa-discord fa-3x mr-1"></i>
                    <div class="d-inline-block">
                        <h6 class="d-block font-weight-bold align-top">{{ $user->discord_nickname }}</h6>
                        <span class="d-block align-bottom" style="font-size: small;">Nom du compte</span>
                    </div>
                    {!! link_to(
                        route('users.social.delete', ['type' => 'discord']),
                        '<span aria-hidden="true">&times;</span>',
                        [
                            'class' => 'close text-white',
                            'style' => 'font-size: xxx-large;',
                            'onclick' => "event.preventDefault();
                             document.getElementById('social-delete-discord-form').submit();",
                            'data-toggle' => 'tooltip',
                            'title' => 'Supprimer la liaison de mon compte Discord',
                            'data-dismiss' => 'alert',
                            'aria-label' => 'Supprimer'
                        ],
                        null,
                        false
                    ) !!}

                    {!! Form::open([
                        'route' => ['users.social.delete', 'type' => 'discord'],
                        'id' => 'social-delete-discord-form',
                        'method' => 'delete',
                        'style' => 'display: none;'
                    ]) !!}
                    {!! Form::close() !!}
                </div>
                @endif
            </section>

            <section class="mb-3 bg-steam text-white">
                @if (is_null($user->steam_id))
                    <h4 class="text-xs-center font-xeta">
                        <i class="fab fa-steam"></i> Steam
                    </h4>
                    <i class="fas fa-exclamation-triangle"></i> Vous n'avez pas encore lier votre compte Steam à votre compte Division.
                    <div class="text-xs-center mt-1">
                        {!! link_to(
                            route('users.social.steam'),
                            'Lier mon Steam',
                            ['class' => 'btn btn-outline-steam-inverse']
                        ) !!}
                    </div>
                @else
                    <div>
                    <i class="fab fa-steam fa-3x mr-1"></i>
                    <div class="d-inline-block">
                        <a href="{{ sprintf(config('xetaravel.steam.profile_url'), $user->steam_id) }}" target="_blank" class="text-white" data-toggle="tooltip" title="Visiter mon profil Steam">
                            <h6 class="d-block font-weight-bold align-top">{{ $user->steam_nickname }}</h6>
                        </a>
                        <span class="d-block align-bottom" style="font-size: small;">Nom du compte</span>
                    </div>
                    {!! link_to(
                        route('users.social.delete', ['type' => 'steam']),
                        '<span aria-hidden="true">&times;</span>',
                        [
                            'class' => 'close text-white',
                            'style' => 'font-size: xxx-large;',
                            'onclick' => "event.preventDefault();
                             document.getElementById('social-delete-steam-form').submit();",
                            'data-toggle' => 'tooltip',
                            'title' => 'Supprimer la liaison de mon compte Steam',
                            'data-dismiss' => 'alert',
                            'aria-label' => 'Supprimer'
                        ],
                        null,
                        false
                    ) !!}

                    {!! Form::open([
                        'route' => ['users.social.delete', 'type' => 'steam'],
                        'id' => 'social-delete-steam-form',
                        'method' => 'delete',
                        'style' => 'display: none;'
                    ]) !!}
                    {!! Form::close() !!}
                </div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
