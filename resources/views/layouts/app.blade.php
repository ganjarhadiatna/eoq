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
    <link href="{{ asset('/fonts/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="{{ asset('/js/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('/js/argon.js?v=1.0.0') }}"></script>

    <style type="text/css">
        
        /*@import url('https://fonts.googleapis.com/css?family=Nunito+Sans');*/
        @font-face {
            font-family: "FontFirst";
            src: url('{{ asset("/fonts/Nunito_Sans/NunitoSans-Regular.ttf") }}');
        }

        * {
            font-family: 'FontFirst', sans-serif;
        }

        .modal {
            overflow-y: auto !important;
        }

    </style>

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

</body>
</html>
