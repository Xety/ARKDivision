@extends('layouts.app')
{!! config(['app.title' => 'Mes notifications']) !!}

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
                Notifications
            </h1>

            @if ($notifications->isNotEmpty())
                <users-notifications
                    :notifications="{{ json_encode($notifications->items()) }}"
                    :route-delete-notification="{{ var_export(route('users.notification.delete')) }}">
                </users-notifications>

                <div class="col-md 12 text-xs-center">
                    {{ $notifications->render() }}
                </div>
            @else
                Vous n'avez aucune notifications.
            @endif

        </div>
    </div>
</div>
@endsection
