@extends('layouts.donation')
{!! config(['app.title' => 'Donation']) !!}

@section('content')
<div class="background">
    <div class="logo-container">
        <img src="https://ark-division.fr/wp-content/uploads/logo-ark-division-france.png" class="logo" alt="logo-ark-division-france" width="300">
    </div>
    <div class="elementor-shape elementor-shape-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path class="elementor-shape-fill" d="M761.9,44.1L643.1,27.2L333.8,98L0,3.8V0l1000,0v3.9"></path>
        </svg>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div style="font-size: 148px; color: #0d9691;">
                <i class="fas fa-check"></i>
            </div>

            <span class="thanks font-weight-bold" style="font-size: 25px; color: #5c6161;">
                Merci pour votre donation survivant !
            </span>
            <br>
            <a href="{{ env('APP_MAIN_URL') }}" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-home"></i> Accueil
            </a>
            <a href="{{ env('APP_URL') }}" class="btn btn-primary" style="margin-top: 20px;">
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
    <div class="footer-text container-fluid">
        <div class="row">
            <div class="col-sm-10">
                © ARK Division 2020
            </div>
            <div class="col-sm-2">
                Fait par <a href="https://github.com/Xety">@ZoRo</a>
            </div>
        </div>
    </div>
</div>
@endsection