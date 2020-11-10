@extends('layouts.error')
{!! config(['app.title' => 'Not found']) !!}

@section('content')
<div class="container mt-4">
    <div class="error">
        <div class="title font-xeta">
            404
        </div>
        <div class="description mb-1">
            La page que vous recherchez n'existe pas.
        </div>
        <div class="link">
            {!! link_to(
                route('discuss.index'),
                '<i class="fa fa-home" aria-hidden="true"></i> Accueil',
                ['class' => 'btn btn-outline-primary'],
                true,
                false
            ) !!}
        </div>
    </div>
</div>
@endsection