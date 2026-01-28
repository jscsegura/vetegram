@extends('layouts.empty')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/wpanel/library/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wpanel/style.css') }}">

    <body class="error-body no-top lazy" data-original="{{ asset('img/wpanel/login_background.jpg') }}" style="background-image: url('{{ asset('img/wpanel/login_background.jpg') }}')">
        <div class="container">
            <div class="row login-container animated fadeInUp">
                <form id="frm_login" class="animated fadeIn" method="POST" action="{{ route('wp.forgot.submit') }}" onsubmit="return validateNoMsj();">
                    @csrf
                    <div class="col-md-7 col-md-offset-2 tiles white no-padding">
                        <div class="p-t-30 p-l-40">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="normal">Olvide mi contraseña</h3>
                                    <p class="p-b-20">Ingrese su correo electrónico para recibir una nueva contraseña.</p>
                                </div>
                            </div>
                        </div>
            
                        <div class="tiles grey p-t-20 p-b-20 text-black">
                            <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                <div class="col-md-12 col-sm-12">
                                    <input type="text" id="email" name="email" class="form-control requerido" placeholder="Correo electrónico" autocomplete="off">
                                </div>
                            </div>
            
                            <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                <div class="col-md-6 col-sm-6">
                                    <button type="submit" class="btn btn-primary btn-cons" id="login_toggle">Recuperar</button>
                                </div>
                                <div class="col-md-6 col-sm-6">&nbsp;</div>
                            </div>
            
                            @if(session('error'))
                            <div class="alert alert-danger msgLogin">{{ session('error') }}</div>
                            @endif

                            @if(session('success'))
                            <div class="alert alert-success msgLogin">
                                {{ session('success') }}
                            </div>
                            @endif
            
                            <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                <div class="control-group  col-md-10">
                                    <div class="checkbox checkbox check-success">
                                        <a href="{{ route('wp.login') }}">
                                            Iniciar Sesion
                                        </a>&nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>

    <script src="{{ asset('js/wpanel/library/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/wpanel/validate.js') }}"></script>
@stop