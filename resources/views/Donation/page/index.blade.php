@extends('layouts.app')
{!! config(['app.title' => 'Donation']) !!}

@push('scripts')
<script src="{{ mix('js/donation/donation.min.js') }}"></script>
<script type="text/javascript">
    $("#slider").slider({
        min: 5,
        max: 300,
        scale: 'logarithmic',
        step: 5
    });

    $("#slider").on("change", function(slideEvt) {
        $("#sliderVal").text(slideEvt.value.newValue);
    });
</script>
@endpush

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
    <h1 class="text-xs-center" style="color: #0d9691;">Contribuez à la Communauté ARK Division France et devenez Membre !</h1>
</div>

<div class="container-fluid" style="margin-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="widget-top">
                Être membre, pourquoi ?
            </div>
            <div class="widget-text-editor">
            Sur nos serveurs en jeu
            </div>
            <ul class="widget-icon-list-items">
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Couleurs personnalisées sur vos dinos (10€+)</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Skins pour vos dinos (15€+)</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">3 Statues : (20€+)<br> - Dragon <br> - Manticore <br> - Mega ! </span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Couleurs, skins et Statues <b>cumulables</b></span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Génération automatique de point de Shop ingame à <b>16 points/10min</b> au lieu de 10 points/10min pour les non-membres.<span class="tag tag-danger">Nouveau</span></span>
                </li>
            </ul>
            <div class="widget-divider">
                <span class="widget-divider-separator"></span>
            </div>
            <div class="widget-text-editor">
                Sur le Discord
            </div>
            <ul class="widget-icon-list-items">
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Rôle membre sur le Discord ARK Division</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Accès à la section membre</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Votes communautaires réservés aux membres</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Message de remerciement de l'équipe</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Droit prioritaire sur le Bot musique</span>
                </li>
            </ul>
            <div class="widget-divider">
                <span class="widget-divider-separator"></span>
            </div>
            <div class="widget-text-editor">
                ARKLog
            </div>
            <ul class="widget-icon-list-items">
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Cet outil permet à nos Membres d'accéder à leurs informations dans le jeu en tout temps et de n'importe où !</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Consultez vos logs de tribu, surveillez vos créatures, cultures et plus encore...</span>
                </li>
            </ul>
        </div>
        <div class="col-md-5">
            {!! Form::open(['route' => 'donation.paypal.checkout']) !!}
                {!! Form::token() !!}

                {{-- The user is connected to his account --}}
                @auth

                    {{-- The user has a valid Discord ID --}}
                    @if ($discord)
                        <div class="form-group text-md-center">
                            @error('discord')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            @if ($steam)
                                <div class="alert alert-success">
                                    <i class="fa fa-check fa-2x " style="vertical-align: middle;" aria-hidden="true"></i> Votre compte <b>Discord</b> et <b>Steam</b>  ont bien été lié à votre compte Division, vos rewards vous seront attribués !
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    Vous n'avez pas lié votre <b>Steam</b> à votre compte Division. Vous <b>devez lier votre compte Steam à votre compte Division</b> afin d'obtenir vos récompenses.
                                    <div class="row justify-content-center">
                                        <a class="btn btn-steam" href="{{ route('users.social.index') }}" target="_blank"><i class="fab fa-steam"></i> Lier mon Compte</a>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-3 discord">
                                <i class="fab fa-discord fa-2x"></i>
                                <span class="discord-text" data-toggle="tooltip" data-placement="top" title="Votre nom d'utilisateur Discord">
                                    {{ $discord->user->username }}#{{ $discord->user->discriminator }}
                                </sapn>
                            </div>

                            {{-- The user has linked his steamid --}}
                            @if ($steam)
                                <div class="col-md-3 steam">
                                    <i class="fab fa-steam fa-2x"></i>
                                    <span class="steam-text" data-toggle="tooltip" data-placement="top" title="Votre nom d'utilisateur Steam">
                                        {{ Auth::user()->account->steam_username }}
                                    </sapn>
                                </div>
                            @endif

                            {{ Form::hidden('discord', Auth::user()->discord_id, ['class' => 'form-control']) }}
                        </div>

                    {{-- The user has not join the Division discord --}}
                    @elseif ($discord == 404)
                        <div class="alert alert-danger">
                            Le Discord ID associé à votre compte (<b>{{ Auth::user()->discord_nickname }}</b>) n'a pas rejoint le discord de ARK Division France, vous ne pourrez par conséquent pas obtenir vos rewards. Vous pouvez rejoindre notre Discord <b><a href="https://discord.gg/tcud7UG" target="_blank">ici</a></b>.
                        </div>

                    {{-- The user has not linked his Discord to his Division account --}}
                    @else
                        <div class="alert alert-danger">
                            Vous n'avez pas lié votre <b>Discord</b> à votre compte Division. Vous <b>devez lier votre compte Discord à votre compte Division</b> afin d'obtenir vos récompenses.
                            <div class="row justify-content-center">
                                <a class="btn btn-discord" href="{{ route('users.social.index') }}" target="_blank"><i class="fab fa-discord"></i> Lier mon Compte</a>
                            </div>
                        </div>
                    @endif

                @endauth

                {{-- The user is not connected to his account --}}
                @guest
                    <div class="alert alert-danger">
                            Vous n'êtes pas connecté à votre compte Division. Vous devez <b>être connecté pour obtenir vos récompenses</b>.
                            <div class="row justify-content-center">
                                <a class="btn btn-primary m-md-1" href="{{ route('users.auth.register') }}">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> Inscription
                                </a>
                                <a class="btn btn-primary m-md-1" href="{{ route('users.auth.login') }}">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i> Connexion
                                </a>
                            </div>
                        </div>
                @endguest

                @error('donation')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="donation font-weight-bold text-monospace text-xs-center">
                    <span id="sliderVal" class="">5</span>€
                </div>

                <div class="form-group">
                    {!! Form::text('donation', '10', ['class' => 'form-control-range', 'id' => 'slider', 'data-toggle' => 'tooltip', 'data-slider-min' => '5', 'data-slider-max' => '300', 'data-slider-step' => '5', 'data-value' => '10']) !!}
                </div>
                <div class="form-group">
                    @error('message')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {!! Form::textarea('message', '', ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Veuillez renseigner votre nom de tribu et/ou un message personnel ici...']) !!}
                </div>
                <div class="form-group text-xs-center">
                    @if (Auth::user() && !is_null(Auth::user()->steam_id) && !is_null(Auth::user()->discord_id))
                        {!! Form::button('<i class="fab fa-paypal"></i>  Faire un don', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                    @endif
                </div>
            {!! Form::close() !!}
            <br>
            Une fois la donation effectuée, <span class="font-weight-bold">vous aurez automatiquement</span> les rôles <span class="font-weight-bold">Membres</span> et <span class="font-weight-bold">DJ</span> ainsi que vos couleurs et skins.
            <br><br>
            <i>Si vous n'avez pas reçu les rôles dans les 5 minutes, veuillez contacter un administrateur sur Discord.</i>
        </div>
        <div class="col-md-3">
            <h2 class="widget-heading-title">À quoi servent vos dons ?</h2>
            <div class="widget-text">
                <p>
                    <strong>Ces dons servent uniquement à financer les serveurs ainsi que l’hébergement du site officiel.</strong>
                    &nbsp;Nous souhaitons valoriser vos dons pour vous offrir une expérience de jeu la plus agréable possible.</p>
            </div>
            <ul class="widget-icon-list-items">
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Financer les serveurs</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Financer l'hébergement du site</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Financer certains add-on pour le jeu et Discord</span>
                </li>
            </ul>
            <div class="widget-divider">
                <span class="widget-divider-separator"></span>
            </div>
            <h2 class="widget-heading-title">Chaque don vous permet de devenir membre !</h2>
            <div class="widget-text">
                <p>Chaque donateur recevra une magnifique couleur pour le dino de son choix. (couleur flashy et mauvais goût admis ! )</p>
                <p>Devenir donateur vous permet d’avoir un statut de membre dans notre Discord. Cela vous permet de participer à certains votes proposés par les admins, concernant la vie du serveur.</p>
                <p>Être un donateur vous permet d'accèder à votre espace ARKLog et de consulter toutes les informations de vos dinos; nourriture, état de reproduction, statistiques</p>
            </div>
        </div>
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