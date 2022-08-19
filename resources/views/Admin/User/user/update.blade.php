@extends('layouts.admin')
{!! config(['app.title' => 'Editer ' . e($user->username)]) !!}

@section('content')
{{-- Header --}}
<div class="col-12 pl-0 pr-0">
    <div class="profile-container">
        <div class="profile-header">
            <div class="background-container">
                {!! Html::image($user->profile_background, 'Profile background', ['class' => 'background']) !!}
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-3 col-xl-2">
                    <div class="profile-information text-center">
                        <ul class="list-group">
                            <li class="list-group-item mb-4">
                                {!! Html::image($user->avatar_small, e($user->username), ['class' => 'rounded-circle']) !!}
                                <h2 class="username font-xeta">
                                    {{ $user->username }}
                                </h2>
                                <h4 class="full-name">
                                    {{ $user->full_name }}
                                </h4>
                            </li>
                            <li class="list-group-item mb-4">
                                @if ($user->discordNickname != '#')
                                    <div class="d-inline-block me-2">
                                        {!! Html::link(
                                            e($user->discordNickname),
                                            '<i class="fab fa-discord fa-2x" style="color:#7289da;"></i>',
                                            [
                                                'class' => 'text-primary',
                                                'target' => '_blank',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => e($user->discordNickname)
                                            ],
                                            null,
                                            false
                                        ) !!}
                                    </div>
                                @endif

                                @if ($user->steamNickname)
                                    <div class="d-inline-block me-2">
                                        {!! Html::link(
                                            e($user->steamNickname),
                                            '<i class="fab fa-steam fa-2x" style="color:#0c5ec5;"></i>',
                                            [
                                                'class' => 'text-primary',
                                                'target' => '_blank',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => e($user->steamNickname)
                                            ],
                                            null,
                                            false
                                        ) !!}
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Breadcrumbs --}}
<div class="col-12 p-2">
    {!! $breadcrumbs->render() !!}
</div>

{{-- User Informations --}}
<div class="col-12 pl-2 pr-2 pb-2">
    <div class="card">
        <h5 class="card-header text-center">
            Editer {{ $user->username }}
        </h5>

        <div class="card-block p-4">
            <div class="row">
                <div class="col-lg-3 text-center">
                    <h5>
                        Avatar
                    </h5>

                    {!! Html::image($user->avatar_small, e($user->username), ['class' => 'rounded-circle img-thumbnail mb-1']) !!}
                    <br />

                    {{ link_to(
                        route('admin.user.user.deleteavatar', $user->id),
                        '<i class="fa fa-remove"></i> Supprimer l\'avatar',
                        [
                            'class' => 'btn btn-outline-primary mb-1',
                            'onclick' => 'event.preventDefault();document.getElementById(\'delete-avatar-form\').submit();'],
                        null,
                        false
                    ) }}

                    {!! Form::open([
                        'route' => ['admin.user.user.deleteavatar', $user->id],
                        'id' => 'delete-avatar-form',
                        'method' => 'delete',
                        'style' => 'display: none;'
                    ]) !!}
                    {!! Form::close() !!}

                    <h4>
                        Membre Information
                    </h4>
                    <div class="form-group">
                        <label class="form-control-label">
                            <span style="font-weight: bold; color: #00af94;">@Membres</span> :
                        </label>
                        <span class="text-white">
                            @if ($user->member_expire_at <= \Carbon\Carbon::now())
                                <span style="font-weight: bold; color: #ef3c3c;">
                                    Non
                                </span>
                            @else
                                <span style="font-weight: bold; color: #00af56;">
                                    Oui
                                </span>
                            @endif
                        </span>
                    </div>
                    @if ($user->member_expire_at >= \Carbon\Carbon::now())
                        <div class="form-group">
                            <label class="form-control-label">
                                <span style="font-weight: bold; color: #00af94;">@Membres</span> expire le :
                            </label>
                            <span class="text-white">
                                {{ $user->member_expire_at }}
                            </span>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="form-control-label">
                            Couleurs Totales :
                        </label>
                        <span class="text-white">
                            {{ $user->color_count }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">
                            Couleurs Restantes :
                        </label>
                        <span class="text-white">
                            {{ $user->color_remain }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">
                            Skins Totaux :
                        </label>
                        <span class="text-white">
                            {{ $user->skin_count }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">
                            Skins Restants :
                        </label>
                        <span class="text-white">
                            {{ $user->skin_remain }}
                        </span>
                    </div>

                    <button type="button" class="btn btn-outline-danger mb-1" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fa fa-remove" aria-hidden="true"></i> Supprimer le compte
                    </button>

                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteAccountModalLabel">
                                        Delete <strong>{{ $user->username }}</strong> Account
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                {!! Form::open([
                                    'route' => ['admin.user.user.delete', $user->id],
                                    'method' => 'delete'
                                ]) !!}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>
                                                Are you sure you want delete this account ? <strong>This operation is not reversible.</strong>
                                            </p>
                                        </div>
                                        {!! Form::bsInputGroup(
                                            'password',
                                            null,
                                            null,
                                            [
                                                'span' => '<i class="fa fa-lock"></i>',
                                                'required' => 'required',
                                                'type' => 'password',
                                                'placeholder' => 'Your password...'
                                            ]
                                        ) !!}
                                    </div>

                                    <div class="modal-actions">
                                        {!! Form::button('Yes, I confirm !', ['type' => 'submit', 'class' => 'ma ma-btn ma-btn-danger']) !!}
                                        <button type="button" class="ma ma-btn ma-btn-success" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    {!! Form::model($user, ['route' => ['admin.user.user.update', $user->id], 'method' => 'put']) !!}

                        {!! Form::bsText(
                            'username',
                            'Username',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsText(
                            'email',
                            'E-mail',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsText(
                            'discord_id',
                            'Discord ID',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsText(
                            'steam_id',
                            'Steam ID',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsSelect(
                            'roles[]',
                            $roles,
                            'Roles',
                            $user->roles->pluck('id')->toArray(),
                            ['class' => 'form-control form-control-inverse col-md-4', 'multiple'],
                            $optionsAttributes
                        ) !!}

                        {!! Form::bsText(
                            'account[first_name]',
                            'Prénom',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsText(
                            'account[last_name]',
                            'Nom',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        <div class="form-group">
                            <div class="col-md-12">
                                {!! Form::button('<i class="fa fa-edit" aria-hidden="true"></i> Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>

                <div class="col-lg-3">
                    <h4>
                        Autres Informations
                    </h4>
                    <div class="form-group">
                        <label class="form-control-label">
                            IP Dernière Connexion
                        </label>
                        <p class="form-control-static text-white">
                            {{ $user->last_login_ip }}
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">
                            IP d'Inscription
                        </label>
                        <p class="form-control-static text-white">
                            {{ $user->register_ip }}
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label ">
                            Inscrit le
                        </label>
                        <p class="form-control-static text-white">
                            {{ $user->created_at->formatLocalized('%d %B %Y à %T') }}
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">
                            Dernière mise à jour
                        </label>
                        <p class="form-control-static text-white">
                            {{ $user->updated_at->formatLocalized('%d %B %Y - %T') }}
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">
                            Evevements
                        </label>
                        <br><br>
                            @foreach ($badgesEvent as $badge)
                                @if ($badge->hasUser($user))
                                <span class="mb-1" style="color:{{ $badge->color }};display:block;" data-toggle="tooltip" title="Cet utilisateur à déjà déverouillé ce badge.">
                                    <i class="{{ $badge->icon }}" aria-hidden="true"></i> {{  $badge->name }}<br>
                                </span><br>
                                @else
                                    {{ link_to(
                                        route('admin.user.user.unlockbadge', [$user->id, $badge->id]),
                                        "<i class=\"{$badge->icon}\"></i> {$badge->name}",
                                        [
                                            'class' => 'btn btn-outline-secondary mb-1',
                                            'style' => "color:{$badge->color}",
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Débloquer ce badge à cet utilisateur.',
                                            'onclick' => "event.preventDefault();document.getElementById('unlockbadge-{$badge->id}').submit();",
                                        ],
                                        null,
                                        false
                                    ) }}<br>
                                    {!! Form::open([
                                        'route' => ['admin.user.user.unlockbadge', [$user->id, $badge->id]],
                                        'id' => "unlockbadge-{$badge->id}",
                                        'method' => 'post',
                                        'style' => 'display: none;'
                                    ]) !!}
                                    {!! Form::close() !!}
                                @endif
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
