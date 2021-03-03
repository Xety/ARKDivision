@extends('layouts.app')
{!! config(['app.title' =>  'Profil de ' . $user->username]) !!}

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="background-container">
            {!! Html::image($user->profile_background, 'Profil background', ['class' => 'background']) !!}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="profile-information text-xs-center">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <div class="profile-information-topleaderboard">
                             @if ($user->badges()->where('slug', 'topleaderboard')->exists())
                                <?php $badge = $user->badges()->where('slug', 'topleaderboard')->first(); ?>
                                <i aria-hidden="true" data-toggle="popover" class="profile-badges-item {{ $badge->icon }}" title="{{ $badge->name }}" data-content="{{ $badge->description }}" data-placement="top" data-trigger="hover" style="color:{{ $badge->color }}; {{ $badge->slug == "topleaderboard" ? "border-color: #eefc24;color:#fff;background-color:" . $badge->color : "" }}"></i>
                             @endif

                                {!! Html::image($user->avatar_small, e($user->username), ['class' => 'rounded-circle']) !!}
                            </div>
                            <h2 class="username font-xeta">
                                {{ $user->username }}
                            </h2>
                        </li>
                    </ul>
                </div>

                <div class="profile-information text-xs-center">
                    <ul class="list-inline">
                        <li class="list-inline-item">

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-header-navbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="profile-header-navbar-badge list-inline pull-left">
                        @if ($user->badges->isNotEmpty())
                            @foreach ($user->badges as $badge)
                            @if ($badge->slug !== 'topleaderboard')
                                    <li class="list-inline-item">
                                    <i aria-hidden="true" data-toggle="popover" class="profile-badges-item {{ $badge->icon }}" title="{{ $badge->name }}" data-content="{{ $badge->description }}" data-placement="top" data-trigger="hover" style="color:{{ $badge->color }}; {{ $badge->slug == "topleaderboard" ? "border-color: #eefc24;color:#fff;background-color:" . $badge->color : "" }}"></i>
                                </li>
                            @endif
                            @endforeach
                        @else
                            @if (Auth::user() && $user->id == Auth::id())
                                Vous n'avez pas encore débloqué de badges.
                            @else
                                Cet utilisateur n'a pas encore débloqué de badges.
                            @endif
                        @endif
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pt-1">
    <div class="row">
        <div class="col-md-12">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
    <div class="row profile pb-3">
        <div class="col-lg-3">
            <section id="sidebar-profile" class="sidebar-profile section">
                <div class="avatar">
                    {!! Html::image($user->avatar_small, 'Avatar', ['width' => '120', 'height' => '120']) !!}
                </div>
                <h4 class="mt-1 font-xeta">
                    {{ $user->username }}
                </h4>

                <div class="role">
                    @foreach ($user->roles as $role)
                        <span style="{{ $role->css }}">{{ $role->name }}</span>
                    @endforeach
                </div>

                <span class="joinedDate">
                    Rejoint le <br>
                    {{ $user->created_at->format('d-m-Y') }}
                </span>

                <ul class="social">
                    @if ($user->facebook)
                        <li class="list-inline-item">
                            {!! Html::link(
                                url('http://facebook.com/' . e($user->facebook)),
                                '<i class="fab fa-facebook-square fa-2x"></i>',
                                [
                                    'class' => 'text-primary',
                                    'target' => '_blank',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'http://facebook.com/' . e($user->facebook)
                                ],
                                null,
                                false
                            ) !!}
                        </li>
                    @endif
                    @if ($user->twitter)
                        <li class="list-inline-item">
                            {!! Html::link(
                                url('http://twitter.com/' . e($user->twitter)),
                                '<i class="fab fa-twitter-square fa-2x"></i>',
                                [
                                    'class' => 'text-primary',
                                    'target' => '_blank',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'http://twitter.com/' . e($user->twitter)
                                ],
                                null,
                                false
                            ) !!}
                        </li>
                    @endif
                </ul>
            </section>
        </div>

        <div class="col-lg-9">
            <section class="section">
                <div class="hr-divider">
                    <h4 class="font-xeta text-xs-center">
                        @if (Auth::user() && $user->id == Auth::id())
                            Votre Biographie
                        @else
                            Sa Biographie
                        @endif
                    </h4>
                </div>
                <div class="biography pt-1 pb-2">
                    @if (!empty($user->biography))
                        {!! Markdown::convertToHtml($user->biography) !!}
                    @else
                        @if (Auth::user() && $user->id == Auth::id())
                            Vous n'avez pas encore renseigné votre biographie.
                            {!! Html::link(route('users.account.index'), '<i class="fa fa-plus"></i> Ajouter maintenant', ['class' => 'btn btn-outline-primary'], null, false) !!}
                        @else
                            Cet utilisateur n'a pas encore renseigné de biographie.
                        @endif
                    @endif
                </div>

                <div class="hr-divider">
                    <h4 class="font-xeta text-xs-center">
                        @if (Auth::user() && $user->id == Auth::id())
                            Vos Badges
                        @else
                            Ces Badges
                        @endif
                    </h4>
                </div>
                <div class="badges pt-1 pb-2">

                </div>
            </section>
        </div>
    </div>
</div>

@endsection
