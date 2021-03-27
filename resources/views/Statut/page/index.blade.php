@extends('layouts.app')
{!! config(['app.title' => 'Statut']) !!}

@push('style')
<link href="{{ mix('css/donation/donation.lib.min.css') }}" rel="stylesheet">
<link href="{{ mix('css/donation/donation.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="background">
    <div class="logo-container">
    </div>
    <div class="elementor-shape elementor-shape-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path class="elementor-shape-fill" d="M761.9,44.1L643.1,27.2L333.8,98L0,3.8V0l1000,0v3.9"></path>
        </svg>
    </div>
    <h1 class="text-md-center" style="color: #0d9691;">Statut des serveurs ARK Division France</h1>
</div>

<div class="container-fluid" style="margin-top: 150px;">
    <div class="container  justify-content-center mb-md-4">
        <div class="alert alert-{{ $alert }} text-xs-center" role="alert">
            @if($alert == "danger")
                <i class="fa fa-exclamation-triangle fa-2x " style="vertical-align: middle;" aria-hidden="true"></i>
                Certains de nos serveurs sont actuellement <b>hors ligne</b>, l'équipe travaille dessus !
            @elseif ($alert == "warning")
                <i class="fa fa-exclamation fa-2x " style="vertical-align: middle;"  aria-hidden="true"></i>
                Des opérations sont actuellement en cours sur certains de nos serveurs.
            @elseif ($alert == "success")
                <i class="fa fa-check fa-2x " style="vertical-align: middle;" aria-hidden="true"></i>
                Tous nos serveurs sont actuellement en ligne !
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach ($servers as $server)
            <div class="col-md-3 card text-md-center mr-md-3 mb-md-2 card text-md-center" style="width: 18rem;">
                <img class="card-img-top" src="{{ $server->image_small }}" alt="Card image cap" height="90px">
                <div class="card-body">
                    <h5 class="card-title" style="color: #{{ $server->color }}; font-weight: bold;">{{ $server->name }}</h5>
                    <p class="card-text">
                        <span style="display: block;">
                            <span class="dot" style="background-color: #{{ $server->status->color }}; box-shadow: 0px 0px 10px #{{ $server->status->color }};"></span> <span>{{ $server->status->type_formatted }}</span>
                        </span>

                    Joueurs en ligne : <b>{{ $server->user_count }}</b>
                    </p>

                    {{-- The user is connected to his account --}}
                    @auth
                        {{-- The user has the permission (ambassadeur, administrateur, developpeur) --}}
                        @if (Auth::user()->hasPermission('access.administration'))
                            <p>
                            @if ($server->user_count != 0)
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#{{ $server->slug }}" aria-expanded="false" aria-controls="{{ $server->slug }}">Afficher les joueurs</button>
                            @endif
                            </p>
                            <div class="row-fluid">
                                <div class="col">
                                    <div class="collapse multi-collapse" id="{{ $server->slug }}">
                                    <div class="list-group">
                                        @foreach ($server->players as $player)
                                            <div class="list-group-item list-group-item-action flex-column align-items-start text-md-left" style="border-right: 0px;border-left: 0px;border-radius: 0px;">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{ $player->ingame_name }}</h5>
                                                    <small class="text-muted">Connecté depuis {{ $player->created_at->format('H:i:s d-m-Y') }}</small>
                                                </div>
                                                <small class="text-muted">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Steam ID :</dt>
                                                        <dd class="col-sm-8"><code>{{ $player->steam_id }}</code></dd>
                                                        <dt class="col-sm-4">Nom Steam :</dt>
                                                        <dd class="col-sm-8"><code>{{ $player->steam_name }}</code></dd>
                                                        <dt class="col-sm-4">Tribu :</dt>
                                                        <dd class="col-sm-8"><code style="{{ $player->tribe != false ?: "color: red;" }}">{{ $player->tribe == false ? "Aucune tribu" : $player->tribe  }}</code></dd>
                                                    </dl>
                                                </small>
                                                @if (!is_null($player->user))
                                                    <small class="text-muted">
                                                        <dl class="row">
                                                            <dt class="col-sm-4">Pseudo Discord :</dt>
                                                            <dd class="col-sm-8"><code>{{ $player->user->username }}</code></dd>
                                                            <dt class="col-sm-4">Discord ID :</dt>
                                                            <dd class="col-sm-8"><code>{{ $player->user->discord_id }}</code></dd>
                                                            <dt class="col-sm-4">Profil Discuss :</dt>
                                                            <dd class="col-sm-8 font-weight-bold">{!! Html::link(
                                                                    url('http://discuss.ark-division.fr/users/profile/@' . e($player->user->username)),
                                                                    "@" . $player->user->username,
                                                                    [
                                                                        'class' => 'text-primary',
                                                                        'targ
                                                                    null,
                                                                    falseet' => '_blank'
                                                                    ],
                                                                ) !!}</dd>
                                                        </dl>
                                                    </small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="footer-background">
    <div class="footer-background-overlay"></div>
    <div class="footer-elementor-shape">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path class="footer-elementor-shape-fill" d="M761.9,44.1L643.1,27.2L333.8,98L0,3.8V0l1000,0v3.9"></path>
        </svg>
    </div>
</div>
@endsection