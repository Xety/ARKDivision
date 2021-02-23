<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ config('app.title') . ' - ' . config('app.name') }}</title>

        <!-- Styles -->
        <link href="{{ mix('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ mix('css/bootstrap.plugins.min.css') }}" rel="stylesheet">

        <script src="https://kit.fontawesome.com/61f38896f8.js" crossorigin="anonymous"></script>

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Embed Styles -->
        <style>
            body {
                color: #78929f;
            }

            .slider-handle {
                top: 5px;
                width: 25px;
                height: 25px;
                background-image: linear-gradient(to bottom,#0d9691 0,#0d9691 100%);
            }
            .slider-selection {
                box-shadow: none;
                background-image: linear-gradient(to bottom,#e2e6ea 0,#e2e6ea 100%);
            }
            .slider.slider-horizontal .slider-track {
                height: 15px;
            }
            .slider-track-low, .slider-track-high {
                background-color: #f8f9fa;
                border-color: #f8f9fa;
            }
            .dropdown-item.active, .dropdown-item:active {
                background-color: #0d9691;
            }
            .slider.slider-horizontal {
                width: 100%;
                height: 30px;
                margin-bottom: 30px;
            }
            .form-control:focus {
                border-color: #1ca8a3e3;
                box-shadow: 0 0 0 .2rem rgba(13, 150, 145, 0.31);
            }
            .bootstrap-select:not(.input-group-btn), .bootstrap-select[class*="col-"] {
                display: inherit;
            }
            .dropdown-menu.show {
                min-width: 100% !important;
            }
            .donation {
                margin: 30px 0 10px;
                font-size: 25px;
            }

            .elementor-shape .elementor-shape-fill {
                fill: #fff;
                -webkit-transform-origin: center;
                -ms-transform-origin: center;
                transform-origin: center;
                -webkit-transform: rotateY(0deg);
                transform: rotateY(0deg);
            }
            .elementor-shape .elementor-shape-fill {
                fill: #fff;
                -webkit-transform-origin: center;
                -ms-transform-origin: center;
                transform-origin: center;
                -webkit-transform: rotateY(0deg);
                transform: rotateY(0deg);
            }
            .elementor-shape.elementor-shape-bottom {
                -webkit-transform: rotate(180deg);
                -ms-transform: rotate(180deg);
                transform: rotate(180deg);
                height: 100%;
            }

            .background {
                background-image: url(images/background/background-header-sub-domain.jpg);
                background-position: 50%;
                background-size: cover;
                height: 350px;
            }
            .logo {
                margin-left: auto;
                margin-right: auto;
                display: block;
            }
            .logo-container {
                position: absolute;
                width: 100%;
                z-index: 1;
            }
            .logo-container a {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 300px;
            }

            .footer-background {
                position: relative;
                background-image: url(images/background/background-footer-sub-domain.jpg);
                background-position: 50%;
                background-size: cover;
                height: 350px;
            }
            .footer-background-overlay {
                position: absolute;
                background-color: #0d6c69;
                opacity: .71;
                transition: background .3s,border-radius .3s,opacity .3s;
                height: 100%;
                width: 100%;
                top: 0;
                left: 0;
            }
            .footer-elementor-shape {
                height: 100%;
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            .footer-elementor-shape-fill {
                fill: #FFFFFF;
                -webkit-transform-origin: center;
                -ms-transform-origin: center;
                transform-origin: center;
                -webkit-transform: rotateY(0deg);
                transform: rotateY(0deg);
            }
            .footer-text {
                position: absolute;
                right: 0;
                left: 0;
                margin-top: -55px;
                font-weight: bold;
                color: #fff;
            }

            a {
                color: #0d9691
            }

            a:hover {
                color: #0a6763;
            }

            .btn-primary {
                color: #fff;
                background-color: #0d9691;
                border-color: #0d9691;
            }
            .btn-primary:hover, .btn-primary:focus, .btn-primary:not(:disabled):not(.disabled):active {
                color: #fff;
                background-color: #0a6763;
                border-color: #0a6763;
            }

            .dot {
                height: 20px;
                width: 20px;
                background-color: #bbb;
                border-radius: 50%;
                display: inline-block;
                vertical-align: sub;
                }

        </style>

    </head>
    <body>
            <!-- Flash Messages -->
            @include('elements.flash')

            <!-- Content -->
            @yield('content')

       <!-- Scripts -->
        <script src="{{ mix('js/lib.min.js') }}"></script>

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.Xetaravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>
        <script src="{{ mix('js/xetaravel.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/61f38896f8.js" crossorigin="anonymous"></script>

    </body>
</html>
