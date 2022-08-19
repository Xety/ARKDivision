@extends('layouts.app')
{!! config(['app.title' => 'Donation']) !!}

@section('content')
<div class="container">
    <h1 class="p-4 text-center" style="color:#bfb59e;border-bottom:1px solid #443c32">
        Contribuez et devenez Membre ARK Division France
    </h1>

    <div class="row">
        <div class="col-lg-6 pb-4">
            <div class="p-4" style="border:1px solid #443c32;border-radius:8px">
                {!! Form::open(['route' => 'donation.paypal.checkout']) !!}
                    {!! Form::token() !!}
                    <div class="fs-4 pb-2">
                        <span for="donationRange" class="form-label">1 - Connectez vos comptes Discord et Steam</span>
                    </div>

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
                    <div class="form-group pt-4 pb-4">
                        <div class="fs-4 d-inline-block">
                            <label for="donationRange" class="form-label">2 - Montant de la donation</label>
                        </div>
                        <output class="fs-3 float-end">15 €</output>

                        <input type="range" name="donation" class="form-range" value="15" min="5" step="5" max="300" id="donationRange" oninput="this.previousElementSibling.value = this.value + ' €'">
                    </div>

                    <div class="form-group pb-4">
                        <div class="fs-4">
                            <label for="messagetest" class="form-label">3 - Informations</label>
                        </div>


                        @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {!! Form::bsTextarea('message', 'Veuillez renseigner votre nom de tribu et/ou un message personnel ici...', '', ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Message...', 'id' => 'messagetest', 'style' => 'height: 100px']) !!}
                    </div>

                    <div class="form-group text-center">
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
        </div>

        <div class="col-lg-6 pb-4">
            <div class="widget-container">
                <h3 class="widget-top">
                    Pourquoi être membre ?
                </h3>
                <div class="widget-text-editor">
                Sur nos serveurs en jeu
                </div>
                <ul class="widget-icon-list-items">
                    <li class="widget-icon-list-item">
                        <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                        <span class="widget-icon-list-text">Couleurs personnalisées sur vos dinos (Tranche de 10€)</span>
                    </li>
                    <li class="widget-icon-list-item">
                        <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                        <span class="widget-icon-list-text">Skins pour vos dinos (Tranche de 15€)</span>
                    </li>
                    <li class="widget-icon-list-item">
                        <span class="widget-icon-list-icon"><i aria-hidden="true" class="fas fa-check"></i>		</span>
                        <span class="widget-icon-list-text">3 Statues : (Tranche de 20€)<br> - Dragon <br> - Manticore <br> - Mega ! </span>
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
        </div>


    </div>
</div>
@endsection