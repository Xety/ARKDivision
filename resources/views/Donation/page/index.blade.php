@extends('layouts.donation')
{!! config(['app.title' => 'Donation']) !!}

@section('content')
<div class="background">
    <div class="logo-container">
        <a href="{{ route('page.index') }}"><img src="https://ark-division.fr/wp-content/uploads/logo-ark-division-france.png" class="logo" alt="logo-ark-division-france" width="300"></a>
    </div>
    <div class="elementor-shape elementor-shape-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path class="elementor-shape-fill" d="M761.9,44.1L643.1,27.2L333.8,98L0,3.8V0l1000,0v3.9"></path>
        </svg>
    </div>
    <h1 class="text-center" style="color: #0d9691;">Contribuez à la Communauté ARK Division France et devenez Membre !</h1>
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
                    <span class="widget-icon-list-text">Couleurs personnalisées sur vos dinos</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Skins pour vos dinos</span>
                </li>
                <li class="widget-icon-list-item">
                    <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                    <span class="widget-icon-list-text">Couleurs et skins cumulables</span>
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

                    {{-- The user has a valid Discord ID--}}
                    @if ($member)
                        <div class="form-group text-md-center">
                            @error('discord')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="alert alert-success">
                                <i class="fa fa-check fa-2x " style="vertical-align: middle;" aria-hidden="true"></i> Votre compte Discord est bien lié à votre compte Division, vos rewards vous seront attribués !
                            </div>
                            <div class="col-md-3 discord">
                                <i class="fab fa-discord fa-2x"></i>
                                <span class="discord-text" data-toggle="tooltip" data-placement="top" title="Votre nom d'utilisateur Discord">
                                    {{ $member->user->username }}#{{ $member->user->discriminator }}
                                </sapn>
                            </div>

                            {{ Form::hidden('discord', Auth::user()->discord_id, ['class' => 'form-control']) }}
                        </div>

                    {{-- The user has not join the Division discord --}}
                    @elseif ($member == 404)
                        <div class="alert alert-danger">
                            Le Discord ID associé à votre compte (<b>{{ Auth::user()->discord_nickname }}</b>) n'a pas rejoint le discord de ARK Division France, vous ne pourrez par conséquent pas obtenir vos rewards. Vous pouvez rejoindre notre Discord <b><a href="https://discord.gg/tcud7UG" target="_blank">ici</a></b>.
                        </div>
                        {{ Form::hidden('discord', 'anonymous', ['class' => 'form-control']) }}

                    {{-- The user has not linked his Discord to his Division account --}}
                    @else
                        <div class="alert alert-danger">
                            Vous n'avez pas lié votre Discord à votre compte Division. Vous ne pourrez pas obtenir vos rewards si vous ne lier pas vos comptes.
                            <div class="row justify-content-center">
                                <a class="btn btn-discord" href="{{ route('users.social.index') }}" target="_blank"><i class="fab fa-discord"></i> Lier mon Compte</a>
                            </div>
                        </div>

                        {{ Form::hidden('discord', 'anonymous', ['class' => 'form-control']) }}
                    @endif
                @endauth

                {{-- The user is not connected to his account --}}
                @guest
                    <div class="alert alert-danger">
                            Vous n'êtes pas connecté à votre compte Division. Vous ne pourrez pas obtenir vos rewards si vous n'êtes pas connecté.
                            <div class="row justify-content-center">
                                <a class="btn btn-primary m-md-1" href="{{ route('users.auth.register') }}">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> @lang('Register')
                                </a>
                                <a class="btn btn-primary m-md-1" href="{{ route('users.auth.login') }}">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i> @lang('Login')
                                </a>
                            </div>
                        </div>

                        {{ Form::hidden('discord', 'anonymous', ['class' => 'form-control']) }}
                @endguest
                    @error('donation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="donation font-weight-bold text-monospace text-center">
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
                <div class="form-group text-center">
                    {!! Form::button('<i class="fab fa-paypal"></i>  Faire un don', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
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