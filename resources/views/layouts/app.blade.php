<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Informasi Manajamen Stok</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> -->

    <!-- Styles -->
    <link href="{{ asset('/css/argon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/nucleo/css/nucleo.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/chart.css') }}" rel="stylesheet">
    <link href="{{ asset('/fonts/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <script src="{{ asset('/js/app.js') }}" defer></script>

    <script src="{{ asset('/js/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('/js/argon.js?v=1.0.0') }}"></script>

    <script src="{{ asset('/js/chart.min.js') }}"></script>

    <!-- <script src="{{ asset('/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('/vendor/chart.js/dist/Chart.extension.js') }}"></script>
    <script src="{{ asset('/vendor/chart.js/dist/Chart.bundle.min.js') }}"></script> -->

    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link type="text/css" href="/css/argon.css?v=1.0.0" rel="stylesheet"> -->

    <style type="text/css">
        
        /*@import url('https://fonts.googleapis.com/css?family=Nunito+Sans');*/
        @font-face {
            font-family: "FontFirst";
            src: url('{{ asset("/fonts/Nunito_Sans/NunitoSans-Light.ttf") }}');
        }

        * {
            font-family: 'FontFirst', sans-serif;
        }

        .modal {
            overflow-y: auto !important;
        }

    </style>


    <script type="text/javascript">
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
        

</head>
<body>
    <div class="main-content">
        @include('layouts.sidebar')

        <div class="main-content">
            @include('layouts.navbar')
            <div class="container-fluid" style="padding: 20px 0 0 0;">
                @yield('content')
            </div>
            <div class="main-content" style="padding: 0 0 20px 0;">
                @yield('profile')
            </div>
        </div>
    </div>

    <!-- <script src="/vendor/jquery/dist/jquery.min.js"></script>
    <script src="/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/js/argon.js?v=1.0.0"></script>
    <script src="/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="/vendor/chart.js/dist/Chart.extension.js"></script> -->

</body>
</html>
