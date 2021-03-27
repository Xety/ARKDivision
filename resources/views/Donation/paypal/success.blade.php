@extends('layouts.app')
{!! config(['app.title' => 'Donation']) !!}

@push('style')
<link href="{{ mix('css/donation/donation.lib.min.css') }}" rel="stylesheet">
<link href="{{ mix('css/donation/donation.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="background">
    <div class="logo-container">
    </div>
    <div class="elementor-shape elementor-shape-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path class="elementor-shape-fill" d="M761.9,44.1L643.1,27.2L333.8,98L0,3.8V0l1000,0v3.9"></path>
        </svg>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 text-xs-center">
            <div style="font-size: 148px; color: #0d9691;">
                <i class="fas fa-check"></i>
            </div>

            <span class="thanks font-weight-bold" style="font-size: 25px; color: #5c6161;">
                Merci pour votre donation survivant !
            </span>
            <br>
            <a href="https://ark-division.fr" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-home"></i> Accueil
            </a>
            <a href="https://discuss.ark-division.fr" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fab fa-discourse"></i> Discuss
            </a>
        </div>
    </div>
</div>
<div class="footer-background">
    <div class="footer-background-overlay"></div>
    <div class="footer-elementor-shape">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path class="footer-elementor-shape-fill" d="M761.9,44.1L643.1,27.2L333.8,98L0,3.8V0l1000,0v3.9"></path>
        </svg>
    </div>
</div>
@endsection