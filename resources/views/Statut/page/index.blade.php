@extends('layouts.statut')
{!! config(['app.title' => 'Statut']) !!}

@section('content')
<div class="background">
    <div class="logo-container">
        <a href="https://ark-division.fr"><img src="https://ark-division.fr/wp-content/uploads/logo-ark-division-france.png" class="logo" alt="logo-ark-division-france" width="300"></a>
    </div>
    <div class="elementor-shape elementor-shape-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path class="elementor-shape-fill" d="M761.9,44.1L643.1,27.2L333.8,98L0,3.8V0l1000,0v3.9"></path>
        </svg>
    </div>
    <h1 class="text-md-center" style="color: #0d9691;">Statut des serveurs ARK Division France</h1>
</div>

<div class="container-fluid" style="margin-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-md-3">

        </div>
        <div class="col-md-5">

            <br>
            Une fois la donation effectuée, <span class="font-weight-bold">vous aurez automatiquement</span> les rôles <span class="font-weight-bold">Membres</span> et <span class="font-weight-bold">DJ</span> ainsi que vos couleurs et skins.
            <br><br>
            <i>Si vous n'avez pas reçu les rôles dans les 5 minutes, veuillez contacter un administrateur sur Discord.</i>
        </div>
        <div class="col-md-3">

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