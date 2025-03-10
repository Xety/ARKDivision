@extends('layouts.app')
{!! config(['app.title' => 'Bienvenue !']) !!}

@push('scripts')
@if (!is_null($nextClaimDate) && !is_null(Auth::user()->last_claimed_coffre) && Auth::user()->last_claimed_coffre->isSameDay($nextClaimDatePreviousDay) == true)
<script>
    // The data/time we want to countdown to
    var countDownDate = new Date('{{ $nextClaimDate->format('F d, Y H:i:s') }}').getTime();

    // Run myfunc every second
    var myfunc = setInterval(function() {

    var now = new Date().getTime();
    var timeleft = countDownDate - now;

    // Calculating the hours, minutes and seconds left
    var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

    // Result is output to the specific element
    document.getElementById("hours").innerHTML = hours + "h "
    document.getElementById("mins").innerHTML = minutes + "m "
    document.getElementById("secs").innerHTML = seconds + "s "

    // Display the message when countdown is over
    if (timeleft < 0) {
        clearInterval(myfunc);
        document.getElementById("hours").innerHTML = ""
        document.getElementById("mins").innerHTML = ""
        document.getElementById("secs").innerHTML = ""
        document.getElementById("timer-end").innerHTML = "";
    }
    }, 1000);
</script>
@endif
@endpush

@section('content')
<div class="container">

    <h1 class="text-center fs-3 pt-3 mb-4" style="color:#bfb59e;border-bottom:1px solid #443c32">
        Bienvenue dans votre espace membre Division !
    </h1>

    <div class="row">
        <div class="col-lg-4 mb-4 align-self-stretch">

            <div class="home-widget h-100" style="background-color: #090909;">
                <div class="d-flex justify-content-between pb-4">
                    <h2 class="fs-4 text-primary">Votre compte</h2>
                    <!-- Points -->
                    @include('partials._points', ['header' => false])
                </div>

                @notauth
                <div class="d-flex justify-content-between pb-4">
                    <a class="btn btn-outline-danger" href="{{ route('users.auth.register') }}">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Inscription
                    </a>
                    <a class="btn btn-outline-primary" href="{{ route('users.auth.login') }}">
                        <i class="fa fa-sign-in" aria-hidden="true"></i> Connexion
                    </a>
                </div>
                @endnotauth

                @auth
                    <div class="pb-4 text-white">
                        <div class="form-group">
                            <label class="form-control-label">
                                Pseudo :
                            </label>
                            <span class="text-white">
                                {{ Auth::user()->username }}
                            </span>
                        </div>
                        <div class="form-group">
                            @if (Auth::user()->isMember)
                                <label class="form-control-label">
                                    Membre jusqu'au {{ Auth::user()->member_expire_at->format('d-m-Y') }}
                                </label>
                            @else
                                <label class="form-control-label">
                                    <span class="text-danger">Non membre,</span> {{ link_to(route('donation.page.index'), '<i class="fa fa-paypal"></i> Faire une Donation', ['class' => 'btn btn-sm btn-primary'], null, false) }}
                                </label>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">
                                <span>{{ Auth::user()->color_remain }}</span> Couleurs Restantes, <span>{{ Auth::user()->skin_remain }}</sapn> Skins Restants
                            </label>
                        </div>

                    </div>

                    {{ link_to(route('users.user.account'), '<i class="fas fa-user-edit"></i> Mon Compte', ['class' => 'btn btn-sm btn-primary'], null, false) }}
                @endauth
            </div>
        </div>

        <div class="col-lg-3 mb-4 align-self-stretch">
            <div class="home-widget h-100" style="background-color: #312e27;">
                <h2 class="fs-4 text-primary">Dernières notifications</h2>
                @if(is_null(Auth::user()))
                <div class="pb-2" style="font-family: var(--bs-body-font-family);font-size: 1.1rem;">
                    Inscrivez-vous afin de profitez des avantages lors d'une donation et pour
                    faire votre <img src="{{ asset('images/logo-adventures.png') }}" width="30"  alt="Logo Aventures"><span class="font-aventures text-primary">Aventure</span> Division !
                </div>
                @elseif (is_null(Auth::user()->discord_id))
                    <div class="pb-2" style="font-family: var(--bs-body-font-family);font-size: 0.92rem;">
                        Vous devez impérativement <b>lier votre compte Discord à votre compte en ligne Division</b> afin de profiter des récompenses de donation et de la partie <span class="font-aventures text-primary">Aventure</span>
                    </div>
                    {{ link_to(route('users.social.index'), '<i class="fab fa-discord"></i> Lier mon compte', ['class' => 'btn btn-sm btn-primary'], null, false) }}
                @elseif (is_null(Auth::user()->steam_id))
                    <div class="pb-2" style="font-family: var(--bs-body-font-family);font-size: 0.92rem;">
                        Vous devez impérativement <b>lier votre compte Steam à votre compte en ligne Division</b> afin de profiter des récompenses de donation et de la partie <span class="font-aventures text-primary">Aventure</span>
                    </div>
                    {{ link_to(route('users.social.index'), '<i class="fab fa-steam"></i> Lier mon compte', ['class' => 'btn btn-sm btn-primary'], null, false) }}
                @else
                    @if (!$notifications->isEmpty())
                        <users-notifications
                            :notifications="{{ json_encode($notifications) }}"
                            :route-delete-notification="{{ var_export(route('users.notification.delete')) }}"
                            :homepage="true">
                        </users-notifications>
                    @else
                        Vous n'avez aucune notifications.
                    @endif
                @endif
            </div>
        </div>

        <div class="col-lg-5 mb-4 align-self-stretch">
            <div class="home-widget h-100" style="background-color: #312e27;">
                <h2 class="fs-4 text-primary">Raccourcis</h2>

                <div class="row">
                    <div class="col-lg-4 mb-4 text-center">
                        <div class="shortcuts" data-bs-toggle="popover" data-bs-html="true" data-bs-content="{{ (!is_null($nextClaimDate) && !is_null(Auth::user()->last_claimed_coffre) && Auth::user()->last_claimed_coffre->isSameDay($nextClaimDatePreviousDay) == true) ? 'Prochain coffre dans <span id="hours">XXh</span>  <span id="mins">XXm</span> <span id="secs">XXs</span>' : 'Vous pouvez réclamer votre coffre !' }}" data-bs-placement="top" data-bs-trigger="hover">
                            <a href="{{ route('users.coffre.index') }}">
                                <img class="svg" src="{{ asset('images/svg/coffre.svg') }}">
                                <h3 class="fs-6">Coffres</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 text-center">
                        <div class="shortcuts" data-bs-title="Voir les classements des joueurs" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-container="body">
                            <a href="{{ route('leaderboard.index') }}">
                                <img class="svg" src="{{ asset('images/svg/trophee-du-championnat.svg') }}">
                                <h3 class="fs-6">Classements</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 text-center">
                        <div class="shortcuts" data-bs-title="Voir les packs Divison Shop" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-container="body">
                            <a href="https://ark-division.fr/packs-division-shop/" target="_blank">
                                <img class="svg" src="{{ asset('images/svg/icon-points.svg') }}">
                                <h3 class="fs-6">Packs Shop</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr/>

    <div class="row">
        <div class="col-lg-4 mb-4 align-self-stretch">
            <div class="home-widget h-100" style="background-color: #312e27;">
                @auth
                    <h2 class="fs-4 text-primary">
                        Vos Events terminés
                    </h2>
                @else
                    <h2 class="fs-4 text-primary">
                        Les Events terminés
                    </h2>
                @endauth

                    @if (!$badges->isEmpty())
                        <ul class="list-group">
                        @foreach ($badges as $badge)
                            <li class="list-group-item fs-5" style="border-bottom:1px solid #443c32" data-bs-title="{{ $badge->description }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-container="body">
                                <img src="{{ asset('images/events/' . $badge->slug . '.svg') }}" width="40px">
                                {{ $badge->name }}
                                <span class="d-block text-muted text-end" style="font-size:0.8rem">Le {{ $badge->created_at->format('d-m-Y') }}</span>
                            </li>
                        @endforeach
                        </ul>
                    @else
                        Vous avez terminé aucun Event encore !
                    @endif
            </div>
        </div>
        <div class="col-lg-4 mb-4 align-self-stretch">
            <div class="home-widget h-100" style="background-color: #090909;">
                <h2 class="fs-4 text-primary">Avancement des Quêtes</h2>
                    Comming soon...
            </div>
        </div>
        <div class="col-lg-4 mb-4 align-self-stretch">
            <div class="home-widget h-100" style="background-color: #2d2c31;">
                <h2 class="fs-4 text-primary">Suivre la communauté</h2>

                <div class="discord-news">
                    <ul class="list-group">
                        @foreach ($discordAnnonces as $discordAnnonce)
                            <li class="list-group-item">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $discordAnnonce->author["username"] }}#{{ $discordAnnonce->author["discriminator"] }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $discordAnnonce->timestamp->format('d-m-Y à H:i:s') }}</h6>

                                        <p class="card-text">{!! Markdown::convert(preg_replace(config('discord.regex.emoji'), '', $discordAnnonce->content)) !!}</p>
                                        <a href="https://discord.com/channels/{{ config('discord.guild.id') }}/{{ $discordAnnonce->channel_id }}/{{ $discordAnnonce->id }}" class="card-link">Lire sur le Discord</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <hr/>

    <div class="row mb-3">
        <div class="col-md-4">
            <div class="features-box">
                <i class="fa fa-users fa-fw text-primary" aria-hidden="true"></i>
                <div class="fs-1">{{ $usersCount }}</div>
                <div class="fs-3 text-primary">Utilisateurs</div>
                <p>
                    Le nombre d'utilisateurs total sur le site Membre.
                </p>
            </div>
        </div>

        @if (config('analytics.enabled'))
            <div class="col-md-4">
                <div class="features-box">
                    <i class="fa fa-globe fa-fw text-primary" aria-hidden="true"></i>
                    <div class="fs-1">{{ $allTimesVisitors }}</div>
                    <div class="fs-3 text-primary">Visites</div>
                    <p>
                        Le nombre de visites totales depuis l'ouverture du site.
                    </p>
                </div>
            </div>
        @endif

        <div class="col-md-4">
            <div class="features-box">
                <img src="{{ asset('images/svg/icon-points.svg') }}" style="margin-right: 6px;" height="50px">
                <div class="fs-1 total-points">{{ $pointsCount }}</div>
                <div class="fs-3 text-primary">Points Total</div>
                <p>
                    Le nombre de points total de tout les joueurs du cluster Division
                </p>
            </div>
        </div>
    </div>


</div>
@endsection
