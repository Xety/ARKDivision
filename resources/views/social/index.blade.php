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
            <h1 class="p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                Social
            </h1>

            <div class="p-3 mb-3 bg-discord text-white">
                @if (is_null($user->discord_id))
                    <div class="text-center">
                        <h4>
                            <i class="fab fa-discord"></i> Discord
                        </h4>
                        <i class="fas fa-exclamation-triangle"></i> Vous n'avez pas encore lier votre compte Discord à votre compte Division.
                        <div class="mt-1">
                            {!! link_to(
                                route('users.social.discord'),
                                'Lier mon Discord',
                                ['class' => 'btn btn-outline-primary']
                            ) !!}
                        </div>
                    </div>

                @else
                    <div class="row">
                        <div class="col-10 d-flex align-items-center">
                             <i class="fab fa-discord fa-3x me-3"></i>
                                <div class="d-inline-block">
                                    <h6 class="d-block">{{ $user->discord_nickname }}</h6>
                                    <span class="d-block" style="font-size: small;">Nom du compte</span>
                                </div>
                        </div>
                        <div class="col-2 text-end">
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
                    </div>
                @endif
            </div>

            <div class="p-3 mb-3 bg-steam text-white">
                @if (is_null($user->steam_id))
                    <div class="text-center">
                        <h4>
                            <i class="fab fa-steam"></i> Steam
                        </h4>
                        <i class="fas fa-exclamation-triangle"></i> Vous n'avez pas encore lier votre compte Steam à votre compte Division.
                        <div class="mt-1">
                            {!! link_to(
                                route('users.social.steam'),
                                'Lier mon Steam',
                                ['class' => 'btn btn-outline-primary']
                            ) !!}
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-10 d-flex align-items-center">
                            <i class="fab fa-steam fa-3x me-3"></i>
                            <div class="d-inline-block">
                                <a href="{{ sprintf(config('division.steam.profile_url'), $user->steam_id) }}" target="_blank" class="text-white" data-toggle="tooltip" title="Visiter mon profil Steam">
                                    <h6 class="d-block">{{ $user->steam_nickname }}</h6>
                                </a>
                                <span class="d-block" style="font-size: small;">Nom du compte</span>
                            </div>
                        </div>
                        <div class="col-2 text-end">
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
                    </div>
                @endif
            </div>

            <div class="p-3 mb-3 bg-twitch text-white">
                @if (is_null($user->twitch_id))
                    <div class="text-center">
                        <h4>
                            <i class="fab fa-twitch"></i> Twitch
                        </h4>
                        <i class="fas fa-exclamation-triangle"></i> Vous n'avez pas encore lier votre compte Twitch à votre compte Division. Lier votre compte maintenant pour être mis en avant sur le Discord de Division lors de vos lives !
                        <div class="mt-1">
                            {!! link_to(
                                route('users.social.twitch'),
                                'Lier mon Twitch',
                                ['class' => 'btn btn-outline-primary']
                            ) !!}
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-10 d-flex align-items-center">
                            <i class="fab fa-twitch fa-3x me-3"></i>
                            <div class="d-inline-block">
                                <a href="{{ sprintf(config('division.twitch.profile_url'), $user->twitch_nickname) }}" target="_blank" class="text-white" data-toggle="tooltip" title="Visiter ma chaine Twitch">
                                    <h6 class="d-block">{{ $user->twitch_nickname }}</h6>
                                </a>
                                <span class="d-block" style="font-size: small;">Nom du compte</span>
                            </div>
                        </div>
                        <div class="col-2 text-end">
                            {!! link_to(
                                route('users.social.delete', ['type' => 'twitch']),
                                '<span aria-hidden="true">&times;</span>',
                                [
                                    'class' => 'close text-white',
                                    'style' => 'font-size: xxx-large;',
                                    'onclick' => "event.preventDefault();
                                    document.getElementById('social-delete-twitch-form').submit();",
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Supprimer la liaison de mon compte Twitch',
                                    'data-dismiss' => 'alert',
                                    'aria-label' => 'Supprimer'
                                ],
                                null,
                                false
                            ) !!}

                            {!! Form::open([
                                'route' => ['users.social.delete', 'type' => 'twitch'],
                                'id' => 'social-delete-twitch-form',
                                'method' => 'delete',
                                'style' => 'display: none;'
                            ]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
