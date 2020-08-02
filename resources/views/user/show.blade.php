@extends('layouts.app')
{!! config(['app.title' => $user->username . ' profile']) !!}

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="background-container">
            {!! Html::image($user->profile_background, 'Profile background', ['class' => 'background']) !!}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="profile-information text-xs-center">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            {!! Html::image($user->avatar_small, e($user->username), ['class' => 'rounded-circle']) !!}
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
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="statistics list-inline pull-left">
                        <li class="list-inline-item">
                            <span class="text">Comments</span>
                            <span class="number">
                                {{ $user->comment_count }}
                            </span>
                        </li>
                        <li class="list-inline-item">
                            <span class="text">Articles</span>
                            <span class="number">
                                {{ $user->article_count }}
                            </span>
                        </li>
                    </ul>

                    <ul class="socials list-inline pull-right">
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
                        @if (Auth::user() && $user->id == Auth::id())
                            <li class="list-inline-item" style="padding: 10px;">
                                {!! Html::link(route('users.account.index'), 'Edit my profile', ['class' => 'btn btn-outline-primary']) !!}
                            </li>
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
    <div class="row profile">
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
                    Joined<br>
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
                            Your Biography
                        @else
                            His Biography
                        @endif
                    </h4>
                </div>
                <div class="biography pt-1 pb-2">
                    @if (!empty($user->biography))
                        {!! Markdown::convertToHtml($user->biography) !!}
                    @else
                        @if (Auth::user() && $user->id == Auth::id())
                            You don't have set a biography.
                            {!! Html::link(route('users.account.index'), '<i class="fa fa-plus"></i> Add now', ['class' => 'btn btn-outline-primary'], null, false) !!}
                        @else
                            This user hasn't set a biography yet.
                        @endif
                    @endif
                </div>

                <div class="hr-divider">
                    <h4 class="font-xeta text-xs-center">
                        @if (Auth::user() && $user->id == Auth::id())
                            Your Badges
                        @else
                            His Badges
                        @endif
                    </h4>
                </div>
                <div class="badges pt-1 pb-2">
                    @if ($user->badges->isNotEmpty())
                        @foreach ($user->badges as $badge)
                        <div class="d-inline-block text-xs-center pr-1">
                            <img src="{{ asset($badge->image) }}" alt="{{ $badge->name }}" width="105" data-toggle="tooltip" title="{{ $badge->name }}">
                        </div>
                        @endforeach
                    @else
                        @if (Auth::user() && $user->id == Auth::id())
                            You don't have unlocked a badge yet.
                        @else
                            This user hasn't unlocked a badge yet.
                        @endif
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>

@endsection
