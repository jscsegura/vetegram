<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

        @stack('scriptHead')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/fc.css') }}" rel="stylesheet" type="text/css">

        <meta name="theme-color" content="#f2fbff">
		<meta name="msapplication-navbutton-color" content="#f2fbff">
		<meta name="apple-mobile-web-app-status-bar-style" content="#f2fbff">
    </head>

    <body>

        @yield('content')

        <div id="divCharge" class="loaderP" style="display: none;">
            <div><p><i class="fa-solid fa-paw fa-bounce"></i></p></div>
        </div>

        <div id="divCharge2" class="loaderP2" style="display: none;">
            <div><p><i class="fa-solid fa-paw fa-bounce"></i></p></div>
        </div>

        @php
            if(isset(Auth::guard('web')->user()->getVet)) {
                $vetData = Auth::guard('web')->user()->getVet;
                $now = date('Y-m-d');
            }
        @endphp

        @if((isset($vetData->pro)) && ($vetData->pro == 1) && (strtotime($vetData->expire) < strtotime($now)))
        <div id="payError">
            <div class="bg-danger text-white p-4 text-center">
                <a href="" class="link-light text-decoration-none fw-medium">
                    <i class="fa-solid fa-xmark me-2"></i>{{ trans('dash.label.pro.pending') }} <a href="{{ url('payment') }}">{{ trans('dash.label.here') }}</a>
                </a>
            </div>
        </div>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="{{ asset('js/front/general.js') }}"></script>

        @stack('scriptBottom')
    </body>
</html>