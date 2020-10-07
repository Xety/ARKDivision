@extends('layouts.app')
{!! config(['app.title' => 'Mes récompenses']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-md-9">
            <section>

                @if ($rewards->isNotEmpty())
                    <div role="alert" class="alert alert-danger">
                        <i aria-hidden="true" class="fa fa-exclamation"></i> Pour réclamer vos récompenses, vous devez être <b>obligatoirement</b> connecté sur l'un des serveurs du cluster depuis au moins 1 minute. Veuillez ne <b>pas</b> changer de map lors d'une réclamation de récompense sinon vous n'aurez pas la récompense en question et elle sera mise comme validée !
                    </div>

                    <users-rewards
                        :rewards="{{ json_encode($rewards->items()) }}"
                        :route-claim-reward="{{ var_export(route('users.reward.claim')) }}"
                        :route-reward-mark-as-read="{{ var_export(route('users.reward.markasread')) }}">
                    </users-rewards>

                    <div class="col-md 12 text-xs-center">
                        {{ $rewards->render() }}
                    </div>
                @else
                    Vous n'avez aucune récompense.
                @endif

            </section>
        </div>
    </div>
</div>
@endsection
