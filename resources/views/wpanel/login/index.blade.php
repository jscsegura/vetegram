@extends('layouts.empty')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/wpanel/library/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wpanel/style.css') }}">

    <body class="error-body no-top lazy" data-original="{{ asset('img/wpanel/login_background.jpg') }}" style="background-image: url('{{ asset('img/wpanel/login_background.jpg') }}')">
        <div class="container">
            <div class="row login-container animated fadeInUp">
                <form id="frm_login" class="animated fadeIn" method="POST" action="{{ route('wp.login.submit') }}" onsubmit="return validateNoMsj();">
                    @csrf
                    <div class="col-md-7 col-md-offset-2 tiles white no-padding">
                        <div class="p-t-30 p-l-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="normal">Panel de Administraci&oacute;n</h3>
                                    <p class="p-b-20">Ingrese sus datos de acceso al administrador.</p>
                                </div>
                                <div class="col-md-6" align="right" style="height: 55px;width: 200px;">
                                    <!-- logo -->
                                </div>
                            </div>
                        </div>
            
                        <div class="tiles grey p-t-20 p-b-20 text-black">
                            <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" id="email" name="email" class="form-control requerido" placeholder="Correo electrónico" autocomplete="off">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="password" id="password" name="password" class="form-control requerido" placeholder="Contrase&ntilde;a" autocomplete="off">
                                </div>
                            </div>
            
                            <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                <div class="col-md-6 col-sm-6">
                                    <button type="submit" class="btn btn-primary btn-cons" id="login_toggle">Entrar</button>
                                </div>
                                <div class="col-md-6 col-sm-6">&nbsp;</div>
                            </div>
            
                            @if(session('error'))
                            <div class="alert alert-danger msgLogin">{{ session('error') }}</div>
                            @endif
            
                            <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                <div class="control-group  col-md-10">
                                    <div class="checkbox checkbox check-success">
                                        <a href="{{ route('wp.login.forgot') }}">
                                            Olvid&eacute; mi contrase&ntilde;a
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