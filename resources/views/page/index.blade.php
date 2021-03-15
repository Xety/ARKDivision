@extends('layouts.app')
{!! config(['app.title' => 'Welcome !']) !!}

@section('content')
<div class="container">

    @if (config('settings.discuss.enabled'))
        <h1 class="text-xs-center font-xeta pt-3 mb-2">Rejoignez notre Discuss !</h1>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <p class="text-muted text-md-center">
                    Rejoingnez notre tout nouvel espace de discussion ! Posez vos question, répondez aux questions de la communauté et gagner de l'expérience pour débloquer de futur fonctionnalités.
                </p>
            </div>
            <div class="col-md-12">
                <img src="{{ asset('images/home/discuss-illustration.png') }}" width="100%" class="d-inline-block align-middle" alt="Discuss">
            </div>
        </div>
    @endif
    <h1 class="text-xs-center font-xeta pt-3 mb-2">Découvrez les nouvelles récompenses de donation !</h1>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <p class="text-muted text-md-center">
                Lors d'une nouvelle donation, <b>vous débloquerez désormais des statues</b> de décoration de taille moyenne faites par notre développeur @Yashi en plus des habituelles récompenses de couleurs et de skins !
            </p>
        </div>

        <div class="card-deck mb-4">
            <div class="card col-md-4" style="padding-right: 0px;padding-left: 0px;">
                <img class="card-img-top" style="max-width: 100%;border-bottom: 2px solid rgba(0, 0, 0, 0.125);" src="{{ asset('images/rewards/dragon.png') }}" alt="Dragon">
                <div class="card-body">
                    <h4 class="card-title text-md-center mt-1">Dragon</h4>
                </div>
            </div>
            <div class="card col-md-4" style="padding-right: 0px;padding-left: 0px;">
                <img class="card-img-top" style="max-width: 100%;border-bottom: 2px solid rgba(0, 0, 0, 0.125);" src="{{ asset('images/rewards/gorilla.png') }}" alt="Gorilla">
                <div class="card-body">
                    <h4 class="card-title text-md-center mt-1">Gorille</h4>
                </div>
            </div>
            <div class="card col-md-4" style="padding-right: 0px;padding-left: 0px;">
                <img class="card-img-top" style="max-width: 100%;border-bottom: 2px solid rgba(0, 0, 0, 0.125);" src="{{ asset('images/rewards/manticore.png') }}" alt="Manticore">
                <div class="card-body">
                    <h4 class="card-title text-md-center  mt-1">Manticore</h4>
                </div>
            </div>
        </div>
    </div>

    <hr/>

    <div class="row mb-3">
        <div class="col-md-4">
            <div class="features-box">
                <i class="fa fa-users fa-fw text-primary" aria-hidden="true"></i>
                <h1 class="font-xeta text-muted">{{ $usersCount }}</h1>
                <h4 class="font-xeta">Utilisateurs</h4>
                <p class="text-muted">
                    Le nombre d'utilisateurs total sur le site Discuss.
                </p>
            </div>
        </div>

        @if (config('analytics.enabled'))
            <div class="col-md-4">
                <div class="features-box">
                    <i class="fa fa-globe fa-fw text-primary" aria-hidden="true"></i>
                    <h1 class="font-xeta text-muted">{{ $allTimesVisitors }}</h1>
                    <h4 class="font-xeta">Visites</h4>
                    <p class="text-muted">
                        Le nombre de visites totales depuis l'ouverture du site.
                    </p>
                </div>
            </div>
        @endif

        <div class="col-md-4">
            <div class="features-box">
                @if (config('settings.discuss.enabled'))
                    <i class="fa fa-comments-o fa-fw text-primary" aria-hidden="true"></i>
                    <h1 class="font-xeta text-muted">{{ $postsCount }}</h1>
                    <h4 class="font-xeta">Posts</h4>
                    <p class="text-muted">
                        Le nombre de posts sur le forum Discuss.
                    </p>
                @else
                    <i class="fas fa-award text-primary" aria-hidden="true"></i>
                    <h1 class="font-xeta text-muted">{{ $rewardsCount }}</h1>
                    <h4 class="font-xeta">Récompenses</h4>
                    <p class="text-muted">
                        Le nombre de récompenses totales obtenus par les membres.
                    </p>
                @endif
            </div>
        </div>
    </div>

    <hr/>
    <h1 class="text-xs-center font-xeta pt-3 mb-2">Découvrez une nouvelle section membre !</h1>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <p class="text-muted text-md-center">
                Profitez d'une nouvelle section membre où vous pourrez gérer votre compte sur le site, les liaisons de votre Steam et Discord mais également <b>claim vos récompenses de donations automatiquement</b> via un système unique à Division sans l'intervention d'un administrateur ingame.
            </p>
        </div>
        <div class="col-md-12">
            <img src="{{ asset('images/home/user-rewards.png') }}" width="100%" class="d-inline-block align-middle" alt="Discuss">
        </div>
    </div>

</div>
@endsection
