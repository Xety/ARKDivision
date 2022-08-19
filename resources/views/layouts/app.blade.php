<!DOCTYPE html>
<html lang="fr" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ config('app.title') . ' - ' . config('app.name') }}</title>

        <meta name="title" content="{{ config('app.title') . ' - ' . config('app.name') }}">
        <meta name="description" content="{{ config('division.site.description') }}">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&family=Orbitron&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ mix('css/division.min.css') }}" rel="stylesheet">

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111467542-3"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-111467542-3');
        </script>

        <!-- Embed Styles -->
        @stack('style')

        <!-- Embed Scripts -->
        @stack('scriptsTop')
    </head>
    <body class="d-flex flex-column h-100">

        <div id="app-vue">
            <!-- Header -->
            @include('elements.header')

            <!-- Flash Messages -->
            @include('elements.flash')

            <main class="flex-shrink-0">
                <!-- Content -->
                @yield('content')
            </main>
        </div>


        <!-- Footer -->
        @include('elements.footer')

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.Division = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>
        <script src="{{ mix('js/division.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/61f38896f8.js" crossorigin="anonymous"></script>

        <!-- Embed Scripts -->
        @stack('scripts')
    </body>
</html>
