<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ config('app.title') . ' - ' . config('app.name') }}</title>

        <!-- Styles -->
        <link href="{{ mix('css/division.admin.min.css') }}" rel="stylesheet">

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Embed Styles -->
        @stack('style')

        <!-- Embed Scripts -->
        @stack('scriptsTop')
    </head>
    <body>

        <div id="app-vue">
            <!-- Header -->
            @include('Admin::elements.header')

            <!-- Flash Messages -->
            @include('elements.flash')

            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('Admin::elements.interface')

                    <main class="ms-sm-auto col-lg-10 px-md-4 pt-5">
                        <!-- Content -->
                        @yield('content')
                    </main>

                    <!-- Footer -->
                    @include('Admin::elements.footer')
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.Division = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>
        <script src="{{ mix('js/division.admin.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/61f38896f8.js" crossorigin="anonymous"></script>

        <!-- Embed Scripts -->
        @stack('scripts')
    </body>
</html>
