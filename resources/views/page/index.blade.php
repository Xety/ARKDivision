@extends('layouts.app')
{!! config(['app.title' => 'Welcome !']) !!}

@section('content')
<div class="container">

    <div class="row mb-3">
        <div class="col-md-4">
            <div class="features-box">
                <i class="fa fa-code text-primary" aria-hidden="true"></i>
                <h4 class="font-xeta">Open Source</h4>
                <p class="text-muted">
                    The code source of this website is open source and available on <a href="{{ config('xetaravel.site.github_url') }}" target="_blank">Github</a>. If you want to contribute, feel free to do a PR.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="features-box">
                <i class="fa fa-flask text-primary" aria-hidden="true"></i>
                <h4 class="font-xeta">Experiences</h4>
                <p class="text-muted">
                I use this site for my personal experiences in development, to try new things like JS libraries, or PHP libraries.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="features-box">
                <i class="fa fa-comments-o text-primary" aria-hidden="true"></i>
                <h4 class="font-xeta">Interact</h4>
                <p class="text-muted">
                You can interact with Xetaravel's members in the blog or directly with me in the comments of an article.
                </p>
            </div>
        </div>
    </div>

    <hr/>
    <h1 class="text-xs-center font-xeta mt-3 mb-3">Latest Articles</h1>

    <div class="row">

    </div>

    <hr/>
    <h1 class="text-xs-center font-xeta mt-3 mb-3">Latest Comments</h1>

    <div class="row pb-3">

    </div>

</div>
@endsection
