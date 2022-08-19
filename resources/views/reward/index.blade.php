@extends('layouts.app')
{!! config(['app.title' => 'Mes récompenses']) !!}

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            @include('partials.user._sidebar')
        </div>

        <div class="col-lg-9">
            <h1 class="p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                Récompenses
            </h1>

            <div class="row">
                @if (config('settings.user.rewards.enabled'))
                    <div class="col-12">
                        @if ($rewards->isNotEmpty())
                            <div role="alert" class="alert alert-danger">
                                <i aria-hidden="true" class="fa fa-exclamation"></i> Pour réclamer vos récompenses, vous devez être <b>obligatoirement</b> connecté sur l'un des serveurs du cluster depuis au moins 1 minute. Veuillez ne <b>pas</b> changer de map lors d'une réclamation de récompense sinon vous n'aurez pas la récompense en question et elle sera mise comme validée !
                            </div>

                            <users-rewards
                                :rewards="{{ json_encode($rewards->items()) }}"
                                :route-claim-reward="{{ var_export(route('users.reward.claim')) }}"
                                :route-reward-mark-as-read="{{ var_export(route('users.reward.markasread')) }}">
                            </users-rewards>

                            <div class="col-md 12 text-center">
                                {{ $rewards->render() }}
                            </div>
                        @else
                            Vous n'avez aucune récompense.
                        @endif
                    </div>
                @else
                    <div class="col-12  text-center">
                        <div role="alert" class="alert alert-danger">
                            <i aria-hidden="true" class="fa fa-exclamation fa-2x pb-1"></i><br>
                            Le système de récompense est désactivé pour le moment, veuillez réessayer plus tard.
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
