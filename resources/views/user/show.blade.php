@extends('layouts.app')
{!! config(['app.title' =>  'Profil de ' . $user->username]) !!}

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="background-container">
            {!! Html::image($user->profile_background, 'Profil background', ['class' => 'background']) !!}
        </div>
        <div class="row">
            <div class="col-12">
                <div class="profile-information text-center">
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
            </div>
        </div>
    </div>

    <div class="profile-header-navbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <ul class="profile-header-navbar-badge list-inline pull-left">
                        @if ($user->badges->isNotEmpty())
                            @foreach ($user->badges as $badge)
                            @if ($badge->slug !== 'topleaderboard')
                                    <li class="list-inline-item">
                                    <i aria-hidden="true" data-bs-toggle="popover" class="profile-badges-item {{ $badge->icon }}" title="{{ $badge->name }}" data-bs-content="{{ $badge->description }}" data-placement="top" data-bs-trigger="hover" style="color:{{ $badge->color }};"></i>
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
        <div class="col-12">
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

            </section>
        </div>

        <div class="col-lg-9">
            <section class="section">

            </section>
        </div>
    </div>
</div>

@endsection
