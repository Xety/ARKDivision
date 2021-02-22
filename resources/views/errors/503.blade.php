@extends('layouts.error')
{!! config(['app.title' => 'Website in maintenance']) !!}

@section('content')
<div class="container mt-4">
    <div class="error">
        <div class="title font-xeta">
            503
        </div>
        <div class="description mb-1">
            Le site est en maintenance, réessayez plus tard.
        </div>
        <div class="link">
            {!! link_to(
                route('page.index'),
                '<i class="fa fa-home" aria-hidden="true"></i> Accueil',
                ['class' => 'btn btn-outline-primary'],
                true,
                false
            ) !!}
        </div>
    </div>
</div>
@endsection