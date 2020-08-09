@extends('layouts.statut')
{!! config(['app.title' => 'Statut']) !!}

@section('content')
<div class="background">
    <div class="logo-container">
        <a href="https://ark-division.fr"><img src="https://ark-division.fr/wp-content/uploads/logo-ark-division-france.png" class="logo" alt="logo-ark-division-france" width="300"></a>
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
                Certain de nos serveurs sont actuellement <b>hors ligne</b>, l'equipe travail actuellement dessus !
            @elseif ($alert == "warning")
                <i class="fa fa-exclamation fa-2x " style="vertical-align: middle;"  aria-hidden="true"></i>
                Certain serveurs rencontrent actuellement des difficultés, l'équipe travail actuellement sur le problème !
            @elseif ($alert == "success")
                <i class="fa fa-check fa-2x " style="vertical-align: middle;" aria-hidden="true"></i>
                Tout nos serveurs sont actuellement en ligne !
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
                                    <ul class="list-unstyled">
                                        <li>Steam ID : <code>{{ $player->steam_id }}</code></li>
                                        <li>Nom Steam : <code>{{ $player->steam_name }}</code></li>
                                        <li>Tribu : <code>{{ $player->tribe == false ? "Aucune tribu" : $player->tribe  }}</code></li>
                                    </ul>
                                    @if (!is_null($player->user))
                                        <small class="text-muted">
                                            <ul class="list-unstyled">
                                                <li>Pseudo Discord : <code>{{ $player->user->username }}</code></li>
                                                <li>Discord ID: <code>{{ $player->user->discord_id }}</code></li>
                                            </ul>
                                        </small>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        </div>
                    </div>
                    </div>
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
    <div class="footer-text container-fluid">
        <div class="row">
            <div class="col-sm-10">
                © ARK Division 2020
            </div>
            <div class="col-sm-2">
                Fait par <a href="https://github.com/Xety">@ZoRo</a>
            </div>
        </div>
    </div>
</div>
@endsection