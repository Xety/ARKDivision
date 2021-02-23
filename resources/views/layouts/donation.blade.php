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
        <link href="{{ mix('css/donation/donation.min.css') }}" rel="stylesheet">

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
                background-image: url(/images/background/background-header-sub-domain.jpg);
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
                background-image: url(/images/background/background-footer-sub-domain.jpg);
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

            .btn-discord {
                color: #fff;
                background-color: #7289da;
                border-color: #7289da;
            }

            .btn-discord:hover, .btn-discord:focus, .btn-discord:not(:disabled):not(.disabled):active {
                color: #fff;
                background-color: #6070ab;
                border-color: #6070ab;
            }

            .widget-top {
                margin: 20px 0;
                padding: 10px 10px;
                background-color: #0d9691;
                color: #fff;
                font-size: 21px;
            }

            .widget-icon-list-items {
                list-style-type: none;
                padding: 0;
            }

            .widget-icon-list-item {
                font-size: 17px;
                font-weight: 600;
            }

            .widget-icon-list-icon i {
                color: #0d9691;
                font-size: 19px;
            }

            .widget-icon-list-text {
                color: #78929f;
            }

            .widget-text-editor {
                font-weight: bolder;
                color: #0d9691;
                font-size: 17px;
                line-height: 1em;
                margin: 25px 0 20px;
            }

            .widget-divider-separator {
                display: inline-block;
                width: 100%;
                border-top: var(--divider-border-width) var(--divider-border-style) var(--divider-border-color);
                margin: 0;
                direction: ltr;
            }

            .widget-divider {
                padding-bottom: 15px;
                --divider-border-style: solid;
                --divider-border-color: #ccc;
                --divider-border-width: 1px;
            }

            .widget-text {
                color: #78929f;
                font-weight: 400;
            }

            .widget-heading-title {
                color: #0d9691;
                font-size: 27px;
            }

            .discord {
                background-color: #7289da;
                color: #ffffff;
                padding: 15px;
                text-align: center;
                vertical-align: middle;
                display: inline-grid;
                border-radius: .35rem;
            }

            .discord-text {
                font-weight: bold;
            }

            .alert {
                border-radius: 0px;
            }

            .alert-danger {
                background-color: #ef3c3c;
                border-color: #ef3c3c;
                color: #fff;
            }

            .alert-success {
                background-color: #5ccc5c;
                border-color: #5ccc5c;
                color: #fff;
            }

        </style>

    </head>
    <body>
            <!-- Flash Messages -->
            @include('elements.flash')

            <!-- Content -->
            @yield('content')

       <!-- Scripts -->
        <script src="{{ mix('js/donation/donation.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/61f38896f8.js" crossorigin="anonymous"></script>
        <script type="text/javascript">
        $("#slider").slider({
            min: 5,
            max: 300,
            scale: 'logarithmic',
            step: 5
        });

        $("#slider").on("change", function(slideEvt) {
            $("#sliderVal").text(slideEvt.value.newValue);
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        </script>

    </body>
</html>
